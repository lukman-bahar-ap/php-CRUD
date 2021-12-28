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
  * Entity-base class untuk mengimplementasikan tabel WORK_INTRUCTION.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class WorkIntruction extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function WorkIntruction()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("WORK_INTRUCTION_ID", $this->getNextId("WORK_INTRUCTION_ID","work_intruction"));

		$str = "
				INSERT INTO work_intruction (
					WORK_INTRUCTION_ID, TITLE, DESCRIPTION, LINK_FILE
				) VALUES (
				  ".$this->getField("WORK_INTRUCTION_ID").",
				  '".$this->getField("TITLE")."',
				  '".$this->getField("DESCRIPTION")."',
				  '".$this->getField("LINK_FILE")."'
				)"; 
		$this->id = $this->getField("WORK_INTRUCTION_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "UPDATE work_intruction
				SET   
					  TITLE		= '".$this->getField("TITLE")."',
					  DESCRIPTION		= '".$this->getField("DESCRIPTION")."'
				WHERE  WORK_INTRUCTION_ID = '".$this->getField("WORK_INTRUCTION_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
		
	function delete()
	{
        $str = "DELETE FROM work_intruction
                WHERE 
                  WORK_INTRUCTION_ID = ".$this->getField("WORK_INTRUCTION_ID").""; 
				  
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
			WORK_INTRUCTION_ID, TITLE, DESCRIPTION, LINK_FILE
		FROM work_intruction 
        WHERE 1 = 1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY WORK_INTRUCTION_ID";
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
		SELECT COUNT(WORK_INTRUCTION_ID) AS ROWCOUNT
		FROM work_intruction 
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