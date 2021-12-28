<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UserLoginBase extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UserLoginBase()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("USER_LOGIN_ID", $this->getNextId("USER_LOGIN_ID","user_login")); 
		$this->setField("USER_PASS", md5($this->getField("USER_PASS")));
		$str = "
				INSERT INTO user_login (
				   USER_LOGIN_ID, USER_GROUP_ID, USER_NAMA, 
				   USER_PASS, NAMA, ALAMAT, 
				   EMAIL, TELEPON, UNIT_UPJ, TEKNISI_ID, MIROR_ID) 
  			 	VALUES (
				  ".$this->getField("USER_LOGIN_ID").",
				  '".$this->getField("USER_GROUP_ID")."',
				  '".$this->getField("USER_NAMA")."', 	
    			  '".$this->getField("USER_PASS")."',
      			  '".$this->getField("NAMA")."',
  				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("EMAIL")."',	
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("UNIT_UPJ")."',
				  '".$this->getField("TEKNISI_ID")."',
				  '".$this->getField("MIROR_ID")."'
			)";
		$this->id = $this->getField("USER_LOGIN_ID");	  	
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("USER_PASS", md5($this->getField("USER_PASS")));
		$str = "
				UPDATE user_login
				SET     
					   USER_GROUP_ID	= '".$this->getField("USER_GROUP_ID")."',					   
					   NAMA    			= '".$this->getField("NAMA")."',
					   ALAMAT     		= '".$this->getField("ALAMAT")."',
					   EMAIL			= '".$this->getField("EMAIL")."',
					   TELEPON			= '".$this->getField("TELEPON")."',
					   USER_NAMA		= '".$this->getField("USER_NAMA")."',
					   UNIT_UPJ			= '".$this->getField("UNIT_UPJ")."'			   
				WHERE  USER_LOGIN_ID   	= ".$this->getField("USER_LOGIN_ID")."
 				"; 

				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updatePassword()
	{
		$this->setField("USER_PASS", md5($this->getField("USER_PASS")));
		$str = "UPDATE user_login SET
				  USER_PASS = '".$this->getField("USER_PASS")."'
				WHERE USER_LOGIN_ID = '".$this->getField("USER_LOGIN_ID")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateFormat()
	{
		$str = "
				UPDATE user_login
				SET    
					  FORMAT			=	".$this->getField("FORMAT").",
				  	  UKURAN			=	".$this->getField("UKURAN")."
				WHERE  USER_LOGIN_ID   	= 	'".$this->getField("USER_LOGIN_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }	
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE user_login A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }	

    function updateByFieldTanpaPetik()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE user_login A SET
				  ".$this->getField("FIELD")." = ".$this->getField("FIELD_VALUE")."
				WHERE USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }	
		
    function resetPassword()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE user_login A SET
				  ".$this->getField("USER_PASS")." = '".$this->getField("USER_PASS")."'
				WHERE USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }			
	
	function delete()
	{
        $str = "DELETE FROM user_login
                WHERE 
                  USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	function deleteTeknisi()
	{
        $str = "DELETE FROM user_login
                WHERE 
                  TEKNISI_ID = ".$this->getField("TEKNISI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	function deleteMiror()
	{
        $str = "DELETE FROM user_login
                WHERE 
                  USER_GROUP_ID = ".$this->getField("USER_GROUP_ID")." AND MIROR_ID = ".$this->getField("MIROR_ID")." "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/
	
	function selectByParamsBlob($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
		SELECT 
			USER_LOGIN_ID, FOTO, FORMAT, UKURAN
		FROM user_login
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
				SELECT USER_LOGIN_ID, A.USER_GROUP_ID, 
		            C.NAMA NAMA_USER_GROUP,
                    A.NAMA, ALAMAT, EMAIL, 
				    TELEPON, A.USER_NAMA, USER_PASS, A.UNIT_UPJ, A.TEKNISI_ID, A.MIROR_ID
				FROM user_login A 
				LEFT JOIN user_group C ON A.USER_GROUP_ID = C.USER_GROUP_ID 
				WHERE USER_LOGIN_ID IS NOT NULL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.UNIT_UPJ ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
				SELECT USER_LOGIN_ID, A.USER_GROUP_ID, 
		            B.NAMA NAMA_USER_GROUP,
                    A.NAMA, ALAMAT, EMAIL, 
				    TELEPON, USER_NAMA, USER_PASS, A.UNIT_UPJ, A.TEKNISI_ID, A.MIROR_ID
				FROM user_login A 
				LEFT JOIN user_group B ON A.USER_GROUP_ID = B.USER_GROUP_ID 
				WHERE USER_LOGIN_ID IS NOT NULL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA	 ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 

	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM user_login
		        WHERE USER_LOGIN_ID IS NOT NULL AND USER_LOGIN_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	
    function getCountByParams($paramsArray=array(),$stat="")
	{
		$str = "SELECT COUNT(USER_LOGIN_ID) AS ROWCOUNT FROM user_login A WHERE USER_LOGIN_ID IS NOT NULL ".$stat; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(USER_LOGIN_ID) AS ROWCOUNT FROM user_login WHERE USER_LOGIN_ID IS NOT NULL "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
  } 
?>