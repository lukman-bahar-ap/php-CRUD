<? 

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Content extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Content()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("content_id", $this->getNextId("content_id","content")); 
		$str = "
			INSERT INTO content(content_id, nama, keterangan)
			VALUES(
				  ".$this->getField("content_id").",
				  '".$this->getField("nama")."',
				  '".$this->getField("keterangan")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE content SET
				  		keterangan = '".$this->getField("keterangan")."'
				WHERE content_id = '".$this->getField("content_id")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM content
                WHERE 
                  content_id = '".$this->getField("content_id")."'
				"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "
				SELECT content_id, nama, keterangan
				FROM content 
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = $val ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY content_id ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "
				SELECT content_id, nama, keterangan
				FROM content 
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= " ORDER BY content_id ASC";
		return $this->selectLimit($str,$limit,$from);
    }	
   
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(content_id) AS ROWCOUNT FROM content WHERE 1 = 1"; 
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
		$str = "SELECT COUNT(content_id) AS ROWCOUNT FROM content WHERE 1 = 1";  
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
	
	function getContentTitle($varContentId)
	{
		$this->selectByParams(array('content_id' => $varContentId));
		$this->firstRow();
		
		return $this->getField('nama');
	}
	
	function getContentText($varContentId)
	{
		$this->selectByParams(array('content_id' => $varContentId));
		$this->firstRow();
		
		return $this->getField('keterangan');
	}
	
} 
?>