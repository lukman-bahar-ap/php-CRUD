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
  * Entity-base class untuk mengimplementasikan tabel PASIEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Pasien extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pasien()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PASIEN_ID", $this->getNextId("PASIEN_ID","pasien"));

		$str = "
				INSERT INTO pasien (
					PASIEN_ID, NO_IDENTITAS, NAMA, TGL_LAHIR, ALAMAT, NO_HP
				) VALUES (
				  ".$this->getField("PASIEN_ID").",
				  '".$this->getField("NO_IDENTITAS")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("TGL_LAHIR")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("NO_HP")."'
				)"; 
		$this->id = $this->getField("PASIEN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "UPDATE pasien
				SET    				
					  NO_IDENTITAS	= '".$this->getField("NO_IDENTITAS")."',
					  NAMA	 		= '".$this->getField("NAMA")."',
					  TGL_LAHIR	 	= '".$this->getField("TGL_LAHIR")."',
					  ALAMAT		= '".$this->getField("ALAMAT")."',
					  NO_HP			= '".$this->getField("NO_HP")."'					  
				WHERE  PASIEN_ID = '".$this->getField("PASIEN_ID")."'
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
        $str = "DELETE FROM pasien
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
	function selectMatchPasien($usr){      
	  $str = "SELECT PASIEN_ID FROM pasien WHERE NO_IDENTITAS='".$usr."'";
	  return $this->select($str);
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
		SELECT 
			PASIEN_ID, NO_IDENTITAS, NAMA, TGL_LAHIR, ALAMAT, NO_HP, 
			DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), TGL_LAHIR)), '%Y')+0 AS USIA
		FROM pasien 
        WHERE 1 = 1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PASIEN_ID";
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
		SELECT COUNT(PASIEN_ID) AS ROWCOUNT
		FROM pasien 
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