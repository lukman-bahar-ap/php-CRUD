<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel SUB_KATEGORI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KunciDevice extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KunciDevice()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KUNCI_DEVICE_ID", $this->getNextId("KUNCI_DEVICE_ID","kunci_device"));		
		$str = "
				INSERT INTO kunci_device (
					KUNCI_DEVICE_ID, USER_LOGIN_ID, DEVICE, KUNCI
				) VALUES (
				  ".$this->getField("KUNCI_DEVICE_ID").",
				  '".$this->getField("USER_LOGIN_ID")."',
				  '".$this->getField("DEVICE")."',
				  '".$this->getField("KUNCI")."'
				)"; 
		$this->id = $this->getField("KUNCI_DEVICE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	function delete()
	{
        $str = "DELETE FROM kunci_device
                WHERE 
                  KUNCI_DEVICE_ID = ".$this->getField("KUNCI_DEVICE_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	function deleteUserLogin()
	{
        $str = "DELETE FROM kunci_device
                WHERE 
                  USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	function deleteLogout()
	{
        $str = "DELETE FROM kunci_device
                WHERE 
                  USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID")." 
				  AND 
				  KUNCI = '".$this->getField("KUNCI")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
		SELECT 
			KUNCI_DEVICE_ID, USER_LOGIN_ID, DEVICE, KUNCI
		FROM kunci_device 
        WHERE 1 = 1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KUNCI_DEVICE_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
			
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT COUNT(KUNCI_DEVICE_ID) AS ROWCOUNT
		FROM kunci_device 
        WHERE 1 = 1 ".$statement; 
		
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

   
  } 
?>