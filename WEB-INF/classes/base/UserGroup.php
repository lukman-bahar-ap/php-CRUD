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
  * Entity-base class untuk mengimplementasikan tabel USER_GROUP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UserGroup extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UserGroup()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("USER_GROUP_ID", $this->getNextId("USER_GROUP_ID","user_group")); 		

		$str = "
				INSERT INTO user_group (
				   USER_GROUP_ID, NAMA) 
 			  	VALUES (
				  ".$this->getField("USER_GROUP_ID").",
				  '".$this->getField("NAMA")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE user_group
				SET    
					  NAMA	= '".$this->getField("NAMA")."'
				WHERE  USER_GROUP_ID	= '".$this->getField("USER_GROUP_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM user_group
                WHERE 
                  USER_GROUP_ID = ".$this->getField("USER_GROUP_ID").""; 
				  
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
					USER_GROUP_ID, NAMA AS NAMA_GROUP
				FROM user_group	
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY USER_GROUP_ID";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	function selectByParamsNotKontrak($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					USER_GROUP_ID, NAMA AS NAMA_GROUP
				FROM user_group	
				WHERE USER_GROUP_ID <> '5' 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY USER_GROUP_ID";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
					USER_GROUP_ID, NAMA AS NAMA_GROUP
				FROM user_group		
				WHERE 1 = 1
			 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY USER_GROUP_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM user_group A
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
		
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
	 function getCountByParamsNotKontrak($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM user_group A
		        WHERE USER_GROUP_ID <> '5' AND USER_GROUP_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM user_group A
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
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