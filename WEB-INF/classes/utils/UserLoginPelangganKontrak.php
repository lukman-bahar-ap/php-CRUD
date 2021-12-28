<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: TamuLogin.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle process authentication for users on Admin group
***************************************************************************************************** */

/***********************************************************************
class.userlogin.php	
Mengelola informasi tentang user login. Untuk menggunakan kelas ini tidak
perlu di-instansiasi dulu, sudah otomatis.
Priyo Edi Purnomo dimodifikasi M Reza Faisal
************************************************************************/

include_once("../WEB-INF/classes/utils/GlobalParam.php");
include_once("../WEB-INF/classes/base/PelangganKontrak.php");

  class UserLoginPelangganKontrak{
    /* Properties */
    //-- PERSISTENT IN SESSION
	var $UID;
	var $nama;
	var $userEmail;
	var $userAlamat;
    var $idUser;
	var $loginTime;
	var $loginTimeStr;
	var $userLevel;
	
	
	var $pageLevel;
	var $bannedPageLevel;
	
	var $pageId;
		
    //-- NOT PERSISTENT
	var $userGroupId;	
	var $userArea;
	var $userRayon;	
		
	//-- BUGTRACK
	var $query;

    /******************** CONSTRUCTOR **************************************/
    function UserLoginPelangganKontrak(){
		/*session_register("ssUsr_UID");
		session_register("ssUsr_idUser");
		session_register("ssUsr_nama");	
		session_register("ssUsr_unitUpj");	
		session_register("ssUsr_loginTime");
		session_register("ssUsr_loginTimeStr");							
		session_register("ssUsr_userGroupId");
		session_register("ssUsr_userEmail");
		session_register("ssUsr_userHp");		
		session_register("ssUsr_userArea");		
		session_register("ssUsr_userRayon");
		session_register("ssUsr_userStatus");*/						

		 $this->emptyProps();
		 $this->setProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->UID = "";
		$this->idUser = "";
		$this->nama = "";		
		$this->email = "";
		$this->loginTimeStr = "";
		$this->userLevel = "";
		$this->pageLevel = false;
			
		$this->active = false;
    }

    /** empty sessions **/
    function emptyUsrSessions(){
		$_SESSION["ssUsr_UID"] = "";
		$_SESSION["ssUsr_idUser"] = "";
		$_SESSION["ssUsr_nama"] = "";		
		$_SESSION["ssUsr_loginTime"] = "";
		$_SESSION["ssUsr_loginTimeStr"] = "";		
		$_SESSION["ssUsr_userEmail"] = "";	
		$_SESSION["ssUsr_userHp"] = "";			
		
    }

	/** reset user information **/
	function resetUserInfo(){
		$this->emptyUsrSessions();
		$this->emptyProps();
	}
		
    /** set properties depends on data from sessions**/
    function setProps(){
		$this->UID = $_SESSION["ssUsr_UID"];
		$this->idUser = $_SESSION["ssUsr_idUser"];
		$this->nama = $_SESSION["ssUsr_nama"];		
		$this->loginTime = $_SESSION["ssUsr_loginTime"];
		$this->loginTimeStr = $_SESSION["ssUsr_loginTimeStr"];
		$this->userLevel = $_SESSION["ssUsr_level"];
		$this->userEmail = $_SESSION["ssUsr_userEmail"];
		$this->userAlamat = $_SESSION["ssUsr_userAlamat"];		
				
		if($this->idUser)
			//$this->active = true;
			$this->active = true; //$this->idUser;
    }
    
    /** Verify user login. True when login is valid**/
    function verifyUserLogin($usrLogin,$password){			
		$usr = new PelangganKontrak();

		if(!$usr->selectByIdPassword($usrLogin,md5($password))){
			//echo $usrLogin." ". md5($password);
			return false;
		}
			
		if($usr->firstRow()){
			//echo $usr->field("USER_ID").'<br>';
			$_SESSION["ssUsr_UID"] = $usr->getField("PELANGGAN_KONTRAK_ID");
			$_SESSION["ssUsr_idUser"] = $usr->getField("NO_HP");
			$_SESSION["ssUsr_nama"] = $usr->getField("NAMA");
			$_SESSION["ssUsr_loginTime"] = time();
			$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
			$_SESSION["ssUsr_level"] = "Pelanggan Unit Kontrak";
			$_SESSION["ssUsr_userEmail"] = $usr->getField("EMAIL");
			$_SESSION["ssUsr_userAlamat"] = $usr->getField("ALAMAT");
	
			$this->setProps();
		}else{
			//echo 'gagal 3<br>';
			//echo "tidak ada user";
			return false; //login/password salah								
  	  }
      unset($usr);
      return true;
    }
		
	//login user without password
	function verifyUserLoginNoPassword($usrLogin){			
      	$usr = new Users();
			
		$this->resetUserInfo();
      	if(trim($usrLogin)==""){				
			return false;        
		}
				
      	if(!$usr->findById($usrLogin)){
        	return false; //login/password salah
      }
			
			//echo $success.NL;		
      if($usr->firstRow()){
				if($usr->field("aktif")){
					$_SESSION["ssUsr_UID"] = $usr->getField("UID");
					$_SESSION["ssUsr_idUser"] = $usr->getField("NO_HP");
					$_SESSION["ssUsr_nama"] = $usr->getField("NAMA");
					$_SESSION["ssUsr_loginTime"] = time();
					$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
					$_SESSION["ssUsr_level"] = "Pelanggan Unit Kontrak";
					$_SESSION["ssUsr_userEmail"] = $usr->getField("EMAIL");
					$_SESSION["ssUsr_userAlamat"] = $usr->getField("ALAMAT");
					
					//$this->setProps();
				} else
					return false;//user tidak aktif
      }else
				return false; //login/password salah
				
      unset($usr);
      return true;
    }
    
	// added by esa unutk ubah password supaya jika pengisian password salah tidak dilakukan verify user login
	function verifyPassLama($usrLogin,$password){			
      $usr = new Users();
			
	  if(!$usr->selectByIdPassword($usrLogin,$password)){
        return false;
		exit();
      }
					
      if($usr->firstRow()){
        $this->active=true;
		return true;
	  }else {
		return false;
	  }
				
      unset($usr);
      return true;
    }

    /** Reset login information **/
    function resetLogin(){
      $this->emptyUsrSessions();
      $this->emptyProps();
    }

    /** Cek apakah user sudah login atau belum **/
    function checkUserLogin(){
		$usr = new Users();
		
		$statusLogin = false;
		if (trim($_SESSION["ssUsr_idUser"])) {
			$statusLogin = false;
		}
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if (!$usr->firstRow()) {
			$statusLogin = false;
		} else {
			$statusLogin = true;
		}
		
		if (!$statusLogin) {
			echo '<script language="javascript">';
			//echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/iPhone|SonyEricsson|Nokia|Android|Blackberry/i', $useragent)){
				//echo 'top.location.href = "../download_bungsigap_mobile.php";';
				echo 'top.location.href = "login.php";';
			}else{
				echo 'top.location.href = "login.php";';
			}
			
			echo '</script>';
			
			exit;
		}
		
		/*
			return true;
      if(!$this->active){
        unset($dbMgr);
        unset($this);
        showMessageDlg("Untuk mengakses halaman ini anda harus login dulu!",false,"../","parent.");
      }
	  */
	  
	  	return $statusLogin;
    }
	
	
    /** Cek apakah user sudah login atau belum **/
    function checkUserLoginMenu(){
		$usr = new Users();
		
		$statusLogin = false;
		if (trim($_SESSION["ssUsr_idUser"])) {
			$statusLogin = false;
		}
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if (!$usr->firstRow()) {
			$statusLogin = false;
		} else {
			$statusLogin = true;
		}
		
		if (!$statusLogin) {
			echo '<script language="javascript">';
			//echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/iPhone|SonyEricsson|Nokia|Android|Blackberry/i', $useragent)){
				//echo 'top.location.href = "../download_bungsigap_mobile.php";';
				echo 'top.location.href = "../main/login.php";';
			}else{
				echo 'top.location.href = "../main/login.php";';
			}
			
			echo '</script>';
			
			exit;
		}
		
		/*
			return true;
      if(!$this->active){
        unset($dbMgr);
        unset($this);
        showMessageDlg("Untuk mengakses halaman ini anda harus login dulu!",false,"../","parent.");
      }
	  */
	  
	  	return $statusLogin;
    }	

    /** Cek apakah user memiliki kode akses yang dimaksud **/
    function checkAccessCode($accessCode=""){

      $found=0;

      if($accessCode=="")
        return true;
      else{//ada kode aksesnya
        $usr = new User();
        $usr->load($this->usrID);
        $groupFac=new GrpPrivilege();
        $groupFac->findByIdGroup($usr->idGroup);
        if ($groupFac->firstRow()){
          do{
            if ($groupFac->accessCode==$accessCode)
              $found=1;
          }while($groupFac->goNext() && !$found);
        }
        unset($groupFac);
        unset($usr);
        unset($this);
        if (!$found)
          showMessageDlg("Anda tidak memiliki hak untuk mengakses fasilitas ini.",false,"../main/mainpage.php");
        else
          return true;

      }

    }

	/** Mengambil informasi user yang sedang logged in **/
	function retrieveUserInfo(){
		$usr = new Users();
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if ($usr->firstRow()) {
			$this->UID = $_SESSION["ssUsr_UID"];
			$this->idUser = $_SESSION["ssUsr_idUser"];
			$this->nama = $usr->getField("NAMA");
			
			$this->userEmail = $usr->getField("EMAIL");
			$this->userAlamat = $usr->getField("ALAMAT");
		}
		
		$this->query = $usr->query;
		
		unset($usr);
	}

	function retrieveUserInfoKhusus($reqId){
		
		if(substr($reqId, 0, 2) == $this->userSatkerId || $this->userGroupId == 1)
		{}
		else
		{
			echo '<script language="javascript">';
			//echo 'alert("Anda tidak punya hak mengakses halaman ini.\n IP Address anda telah kami catat sebagai user yang mencoba mengakses Satker lain.");';
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/iPhone|SonyEricsson|Nokia|Android|Blackberry/i', $useragent)){
				//echo 'top.location.href = "../download_bungsigap_mobile.php";';
				echo 'top.location.href = "login.php";';
			}else{
				echo 'top.location.href = "login.php";';
			}
			
			echo '</script>';
			
			exit;			
		}
		
		$usr = new Users();
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if ($usr->firstRow()) {
			$this->UID = $_SESSION["ssUsr_UID"];
			$this->idUser = $_SESSION["ssUsr_idUser"];
			$this->nama = $usr->getField("NAMA");
			
			$this->userEmail = $usr->getField("EMAIL");
			$this->userAlamat = $usr->getField("ALAMAT");
		}
		
		$this->query = $usr->query;
		
		unset($usr);
	}
  	
	/* Mengambil informasi tanggal login */  
	function getLoginDateStr(){
		return date("l, j M Y",$this->loginTime);		
	}
		
	/* Mengambil informasi tanggal login */  
	function getLoginTimeStr(){
		return date("H:i",$this->loginTime);		
	}
	
	/* mengeset level akses halaman 
	   isi $varLevel dengan array untuk multilevel
	   # $varBannedLevel : level yang ditolak
	*/
	function setPageLevel($varLevel, $varBannedLevel = "")
	{
		$this->pageLevel = $varLevel;
		$this->bannedPageLevel = $varBannedLevel;
	}
	
	/* mengeset ID halaman yang akan dibandingkan dengan tabel group_access
	   apakah halaman yg bersangkutan boleh diakses oleh level user yg sedang login
	*/
	function setPageId($varId)
	{
		$this->pageId = $varId;
	}
	
	/* Mengecek level akses halaman berdasarkan $pageLevel dan $userLevel. 
	   Jika privilege tepat maka return true.
	   Jika $pageLevel tidak diset maka akan selalu return true 
	   # untuk admin : $this->userLevel = 1
	   # untuk guest : $this->userLevel = 9999
	   # halaman yang boleh diakses user asal sudah login, maka : set $this->pageLevel = 9999 
	 */
	function checkPagePrivileges($autoExit = true)
	{
		$ret = false;
		
		if($this->pageLevel == false)
			$ret = true;
		
		// if admin, bypass checking
		// check whether $pageLevel is array or not
		// jika pageLevel = 9999 (public) then bypass checking
		if(is_array($this->pageLevel))
		{
			foreach($this->pageLevel as $key => $value)
			{
				if($value == $this->userLevel || $this->userLevel == '1' || $this->userLevel == '2' || $this->pageLevel == '9999')
				{
					$ret = true;
					break;
				}
				else
					$ret = false;
			}
		}
		else
		{
			if($this->pageLevel == $this->userLevel || $this->userLevel == '1'|| $this->userLevel == '2' || $this->pageLevel == '9999')
				$ret = true;
			else
				$ret = false;
		}
		
		// check for any banned level
		if(is_array($this->bannedPageLevel))
		{
			foreach($this->bannedPageLevel as $key => $value)
			{
				if($value == $this->userLevel)
				{
					$ret = false;
					break;
				}
			}
		}
		else
		{
			if($this->bannedPageLevel == $this->userLevel)
			{
				$ret = false;
				//break;
			}
		}
		
		// cek page access
		if($this->checkPageAccess() == false)
			$ret = false;
		
		
		if($autoExit == true)
		{
			if($ret == false) exit;
		}
		else
			return $ret;
	}
	
	/* helper method untuk mengecek apakah halaman yang bersangkutan 
	   boleh dibuka oleh usergroup yg sedang login 
	*/
	function checkPageAccess()
	{
		$gp = new GlobalParam();
		
		$group_access = new GroupAccess();
		
		$group_access->selectByParams(array('UGID' => $this->userLevel, 'id_menu' => $this->pageId));
		
		// bypass if admin
		if($this->userLevel == $gp->usergroupAdmin)
			return true;
		
		if($group_access->firstRow())
			return true;
		else
			return false;
	}
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $userLoginPelangganKontrak = new UserLoginPelangganKontrak();

?>