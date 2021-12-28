<? 
  /***
  * Entity-base class untuk mengimplementasikan tabel BAROKAH_YANBUNG.ASOSIASI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Propinsi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Propinsi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PROPINSI_ID", $this->getNextId("PROPINSI_ID", "propinsi")); 
		$str = "
				INSERT INTO propinsi
					(PROPINSI_ID, NAMA_PROPINSI, NAMA_KABUPATEN, NAMA_KECAMATAN, NAMA_KELURAHAN) 
				VALUES(
				  ".$this->getField("PROPINSI_ID").",
				  '".$this->getField("NAMA_PROPINSI")."',
				  '".$this->getField("NAMA_KABUPATEN")."',
				  '".$this->getField("NAMA_KECAMATAN")."',
				  '".$this->getField("NAMA_KELURAHAN")."'
				)"; 
		$this->id = $this->getField("PROPINSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }	
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			UPDATE propinsi SET
				  NAMA_PROPINSI		= '".$this->getField("NAMA_PROPINSI")."',
				  NAMA_KABUPATEN	= '".$this->getField("NAMA_KABUPATEN")."',
				  NAMA_KECAMATAN	= '".$this->getField("NAMA_KECAMATAN")."',
				  NAMA_KELURAHAN	= '".$this->getField("NAMA_KELURAHAN")."'
			WHERE PROPINSI_ID 		= '".$this->getField("PROPINSI_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM propinsi WHERE PROPINSI_ID = '".$this->getField("PROPINSI_ID")."'"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 

    function selectByParams($paramsArray=array(), $limit=-1, $from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
					PROPINSI_ID, NAMA_PROPINSI, NAMA_KABUPATEN, NAMA_KECAMATAN, NAMA_KELURAHAN 
				FROM propinsi
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDist($paramsArray=array(), $limit=-1, $from=-1, $statement="", $order="",$reqField)
	{
		$str = "
				SELECT DISTINCT
					".$reqField." AS NAMA_KABUPATEN
				FROM propinsi
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 

    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
					COUNT(PROPINSI_ID) AS ROWCOUNT 
				FROM propinsi
				WHERE 1 = 1
			".$statement; 
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
	function getCountByParamsKota($paramsArray=array(), $statement="",$reqField)
	{
		$str = "
				SELECT 
					COUNT(NAMA_KABUPATEN) AS ROWCOUNT 
				FROM 
					(
					SELECT DISTINCT ".$reqField." FROM propinsi WHERE 1 = 1 ".$statement."
					)A
				WHERE 1 = 1
			"; 
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