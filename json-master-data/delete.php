<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET["id"];
$reqMode = $_GET["reqMode"];


/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

if($reqMode == "pasien")
{
	include_once("../WEB-INF/classes/base/Pasien.php");
	include_once("../WEB-INF/classes/base/Periksa.php");
	
	$pasien = new Pasien();	
	$pasien->selectByParams(array("PASIEN_ID" => $reqId));
	$pasien->firstRow();	
						
	$pasien->setField("PASIEN_ID", $reqId);
	if($pasien->delete()){
		$periksa = new Periksa();
		$periksa->setField("PASIEN_ID", $reqId);
		$periksa->deleteFromPasien();
		
		$alertMsg .= "Data berhasil dihapus";
	}else{
		$alertMsg .= "Error ".$pasien->getErrorMsg();
	}
}
if($reqMode == "periksa")
{
	include_once("../WEB-INF/classes/base/Periksa.php");

	$periksa = new Periksa();
	
	$periksa->selectByParams(array("PERIKSA_ID" => $reqId));
	$periksa->firstRow();	
						
	$periksa->setField("PERIKSA_ID", $reqId);
	if($periksa->delete()){
	
		$alertMsg .= "Data berhasil dihapus";	
	}else{
		$alertMsg .= "Error ".$periksa->getErrorMsg();
	}
}
?>