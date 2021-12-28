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
  * Entity-base class untuk mengimplementasikan tabel PERIKSA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Periksa extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Periksa()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERIKSA_ID", $this->getNextId("PERIKSA_ID","periksa"));

		$str = "
				INSERT INTO periksa (
					PERIKSA_ID, PASIEN_ID, TGL_PERIKSA, S, O, A, P
				) VALUES (
				  ".$this->getField("PERIKSA_ID").",
				  ".$this->getField("PASIEN_ID").",
				  '".$this->getField("TGL_PERIKSA")."',
				  '".$this->getField("S")."',
				  '".$this->getField("O")."',
				  '".$this->getField("A")."',
				  '".$this->getField("P")."'
				)"; 
		$this->id = $this->getField("PERIKSA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "UPDATE periksa
				SET    				
					  TGL_PERIKSA	= '".$this->getField("TGL_PERIKSA")."',
					  S	 			= '".$this->getField("S")."',
					  O	 			= '".$this->getField("O")."',
					  A				= '".$this->getField("A")."',
					  P				= '".$this->getField("P")."'					  
				WHERE  PERIKSA_ID 	= '".$this->getField("PERIKSA_ID")."'
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
        $str = "DELETE FROM periksa
                WHERE 
                  PERIKSA_ID = ".$this->getField("PERIKSA_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteFromPasien()
	{
        $str = "DELETE FROM periksa
                WHERE 
                  PASIEN_ID = ".$this->getField("PASIEN_ID").""; 
				  
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
			PERIKSA_ID, PASIEN_ID, TGL_PERIKSA, S, O, A, P
		FROM periksa 
        WHERE 1 = 1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PERIKSA_ID";
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
		SELECT COUNT(PERIKSA_ID) AS ROWCOUNT
		FROM periksa 
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