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
  * Entity-base class untuk mengimplementasikan tabel TEKNISI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Kontrak extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kontrak()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_ID", $this->getNextId("KONTRAK_ID","kontrak"));

		$str = "
				INSERT INTO kontrak (
					KONTRAK_ID, PELANGGAN_KONTRAK_ID, UNIT_KONTRAK_ID, JUMLAH
				) VALUES (
				  ".$this->getField("KONTRAK_ID").",
				  '".$this->getField("PELANGGAN_KONTRAK_ID")."',
				  '".$this->getField("UNIT_KONTRAK_ID")."',
				  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("KONTRAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "UPDATE kontrak
				SET    				
					  PELANGGAN_KONTRAK_ID	= '".$this->getField("PELANGGAN_KONTRAK_ID")."',
					  UNIT_KONTRAK_ID	 	= '".$this->getField("UNIT_KONTRAK_ID")."',
					  JUMLAH				= '".$this->getField("JUMLAH")."'
				WHERE  KONTRAK_ID = '".$this->getField("KONTRAK_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function delete()
	{
        $str = "DELETE FROM kontrak
                WHERE 
                  KONTRAK_ID = ".$this->getField("KONTRAK_ID").""; 
				  
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
			KONTRAK_ID, PELANGGAN_KONTRAK_ID, UNIT_KONTRAK_ID, JUMLAH
		FROM kontrak 
        WHERE 1 = 1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KONTRAK_ID";
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
		SELECT COUNT(KONTRAK_ID) AS ROWCOUNT
		FROM kontrak 
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