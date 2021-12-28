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
include_once("../WEB-INF/classes/entities/Users.php");
include_once("../WEB-INF/classes/entities/GroupAccess.php");

  class UserLogin{
	  
    /* Properties */
    //-- PERSISTENT IN SESSION
	var $UID;
	var $nama;
	var $unitUpj;
    var $idUser;
	var $loginTime;
	var $loginTimeStr;
	var $userLevel;
	var $userStatus;	
	
	
	var $pageLevel;
	var $bannedPageLevel;
	
	var $pageId;
		
    //-- NOT PERSISTENT
	var $userGroupId;	
	var $userEmail;
	var $userHp;
	var $userArea;


		
	//-- BUGTRACK
	var $query;

    /******************** CONSTRUCTOR **************************************/
    function UserLogin(){ 
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
		session_register("ssUsr_userTeknisiId");
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
		$this->unitUpj = "";		
		$this->loginTime = "";
		$this->loginTimeStr = "";
		$this->userLevel = "";
		$this->userGroupId = "";

		$this->pageLevel = false;
			
		$this->active = false;
    }

    /** empty sessions **/
    function emptyUsrSessions(){
		unset($_SESSION["ssUsr_UID"]);
		unset($_SESSION["ssUsr_idUser"]);
		unset($_SESSION["ssUsr_unitUpj"]);
		unset($_SESSION["ssUsr_nama"]);	
		unset($_SESSION["ssUsr_loginTime"]);
		unset($_SESSION["ssUsr_loginTimeStr"]);	
		unset($_SESSION["ssUsr_userGroupId"]);
		unset($_SESSION["ssUsr_userEmail"]);	
		unset($_SESSION["ssUsr_userHp"]);			
		unset($_SESSION["ssUsr_userArea"]);
		unset($_SESSION["ssUsr_userStatus"]);
		
    }

	/** reset user information **/
	function resetUserInfo(){
		$this->emptyUsrSessions();
		$this->emptyProps();
	}
	function destroySession(){
		session_unset(); 
		session_destroy();
	}
	function startSession(){
		session_start();
	}
	function sessionLogOnline($log){
		$usr = new Users();
		$usrLogin = $this->idUser;
		$usr->setField("USER_NAMA",$usrLogin);
		$usr->updateStatusOnline($log);
		return true;
	}
	function checkLogOnline($usrLogin){
		$usr = new Users();
		$usr->selectById($usrLogin);
		if($usr->firstRow())
			$this->logonline = $usr->getField("LOG_ONLINE");
		else
			$this->logonline = 0;
	}
	
	function notifWrong(){
			echo '<script language="javascript">';
			echo 'alert("Username atau Password Salah.");';
			echo 'top.location.href = "../main/login.php";';
			echo '</script>';
	}
	function notifNotAktif(){
			echo '<script language="javascript">';
			echo 'alert("User Tidak Aktif.");';
			echo 'top.location.href = "../main/login.php";';
			echo '</script>';
	}
	function notifNotHak(){
			echo '<script language="javascript">';
			echo 'alert("Anda tidak memiliki hak mengakses halaman ini");';
			echo 'top.location.href = "../main/login.php";';
			echo '</script>';
	}
	
	function backHistory(){
			echo '<script language="javascript">';
			echo '	var Backlen=history.length; ';  
     		echo '	history.go(-Backlen);   ';
     		echo '	top.location.href="../main/login.php";';
			echo '</script>';
	}
		
    /** set properties depends on data from sessions**/
    function setProps(){
		$this->UID = $_SESSION["ssUsr_UID"];
		$this->idUser = $_SESSION["ssUsr_idUser"];
		$this->unitUpj = $_SESSION["ssUsr_unitUpj"];
		$this->nama = $_SESSION["ssUsr_nama"];		
		$this->loginTime = $_SESSION["ssUsr_loginTime"];
		$this->loginTimeStr = $_SESSION["ssUsr_loginTimeStr"];
		$this->userLevel = $_SESSION["ssUsr_level"];
		$this->userGroupId = $_SESSION["ssUsr_userGroupId"];	
		$this->userEmail = $_SESSION["ssUsr_userEmail"];
		$this->userHp = $_SESSION["ssUsr_userHp"];		
		$this->userArea = $_SESSION["ssUsr_userArea"];
		$this->userStatus = $_SESSION["ssUsr_userStatus"];
				
		if($this->idUser)
			//$this->active = true;
			$this->active = true; //$this->idUser;
    }
    
    /** Verify user login. True when login is valid**/
    function verifyUserLogin($usrLogin,$password){			
		$usr = new Users();

		$this->resetUserInfo();
		if(trim($usrLogin)=="" || trim($password)==""){	
			$this->notifWrong();			
			//echo 'gagal 1<br>';
			return false;        
		}	
		if(!$usr->selectByIdPassword($usrLogin,md5($password))){
			//echo $usrLogin." ". md5($password);
			$this->notifWrong();
			return false;
		}
			
		if($usr->firstRow()){
			//echo $usr->field("USER_ID").'<br>';
			$_SESSION["ssUsr_UID"] = $usr->getField("USER_LOGIN_ID");
			$_SESSION["ssUsr_idUser"] = $usr->getField("USER_NAMA");
			$_SESSION["ssUsr_unitUpj"] = $usr->getField("UNIT_UPJ");
			$_SESSION["ssUsr_nama"] = $usr->getField("NAMA");
			$_SESSION["ssUsr_loginTime"] = time();
			$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
			$_SESSION["ssUsr_level"] = $usr->getField("USER_GROUP_ID");
			$_SESSION["ssUsr_userGroupId"] = $usr->getField("USER_GROUP_ID");
			$_SESSION["ssUsr_userEmail"] = $usr->getField("EMAIL");
			$_SESSION["ssUsr_userHp"] = $usr->getField("TELEPON");
			$_SESSION["ssUsr_userArea"] ="";
			$_SESSION["ssUsr_userStatus"] = "";
				
			$this->setProps();
		}else{
			//echo 'gagal 3<br>';
			//echo "tidak ada user";
			$this->notifWrong();
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
			$this->notifWrong();			
			return false;        
		}
				
      	if(!$usr->findById($usrLogin)){
			$this->notifWrong();
        	return false; //login/password salah
      }
			
			//echo $success.NL;		
      if($usr->firstRow()){
				if($usr->field("aktif")){
					
				$_SESSION["ssUsr_UID"] = $usr->getField("USER_LOGIN_ID");
				$_SESSION["ssUsr_idUser"] = $usr->getField("USER_NAMA");
				$_SESSION["ssUsr_unitUpj"] = $usr->getField("UNIT_UPJ");
				$_SESSION["ssUsr_nama"] = $usr->getField("NAMA");
				$_SESSION["ssUsr_loginTime"] = time();
				$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
				$_SESSION["ssUsr_level"] = $usr->getField("USER_GROUP_ID");
				$_SESSION["ssUsr_userGroupId"] = $usr->getField("USER_GROUP_ID");
				$_SESSION["ssUsr_userEmail"] = $usr->getField("EMAIL");
				$_SESSION["ssUsr_userHp"] = $usr->getField("TELEPON");
				$_SESSION["ssUsr_userArea"] = "";
				$_SESSION["ssUsr_userStatus"] = "";
					
					//$this->setProps();
				} else{
					echo '<script language="javascript">';
					echo 'alert("User tidak aktif.");';
					echo 'top.location.href = "../main/login.php";';
					echo '</script>';
					
					return false;//user tidak aktif
				}
      }else{

			$this->notifWrong();
			return false; //login/password salah
	  }
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
			echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			echo 'top.location.href = "../main/login.php";';
			
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
			echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
			
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
	
	function checkGroupAkses($groupId=""){
		if($groupId==""){
			notifNotHak();
		}
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
			$this->unitUpj = $usr->getField("UNIT_UPJ");
			
			$this->userGroupId = $usr->getField("USER_GROUP_ID");//1; mode bukan satker validator
			$this->userEmail = $usr->getField("EMAIL");
			$this->userHp = $usr->getField("TELEPON");
			$this->userArea = "";
			$this->userStatus = $_SESSION["ssUsr_userStatus"];
		}
		
		$this->query = $usr->query;
		
		unset($usr);
	}

	function retrieveUserInfoKhusus($reqId){
				
		$usr = new Users();
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if ($usr->firstRow()) {
			$this->UID = $_SESSION["ssUsr_UID"];
			$this->idUser = $_SESSION["ssUsr_idUser"];
			$this->nama = $usr->getField("NAMA");
			$this->unitUpj = $usr->getField("UNIT_UPJ");
			
			$this->userGroupId = $usr->getField("USER_GROUP_ID");//1; mode bukan satker validator
			$this->userEmail = $usr->getField("EMAIL");
			$this->userHp = $usr->getField("TELEPON");
			$this->userStatus = $_SESSION["ssUsr_userStatus"];
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
				if($value == $this->userLevel || $this->userLevel == '1'|| $this->userLevel == '2' || $this->pageLevel == '9999')
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
		
		$group_access->selectByParams(array('UID' => $this->userLevel, 'id_menu' => $this->pageId));
		
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
  $userLogin = new UserLogin();

?>