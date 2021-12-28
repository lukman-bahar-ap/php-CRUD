<?php
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Periksa.php");
include_once("../WEB-INF/functions/image.func.php");
		
$periksa = new Periksa();


$reqId		 	= httpFilterPost("reqId");
$reqPasienId	= httpFilterPost("reqPasienId");
$reqTglPeriksa	= httpFilterPost("reqTglPeriksa");
$reqS			= httpFilterPost("reqS");
$reqO			= httpFilterPost("reqO");
$reqA			= httpFilterPost("reqA");
$reqP			= httpFilterPost("reqP");

/*$reqPasienId = 2;
$reqTglPeriksa=date("d-m-Y");
$reqS			= "2";
$reqO			= "2";
$reqA			= "2";
$reqP			= "2";*/


$reqMode		= httpFilterPost("reqMode");
$reqDevice		= httpFilterPost("reqDevice");

if($reqMode == "insert")
{

	$periksa->setField("PASIEN_ID", $reqPasienId);
	$periksa->setField("TGL_PERIKSA", dateToDBMysql($reqTglPeriksa));
	$periksa->setField("S", $reqS);
	$periksa->setField("A", $reqA);
	$periksa->setField("O", $reqO);
	$periksa->setField("P", $reqP);
		
	if($periksa->insert())
	{
		$reqId= $periksa->id;	
		echo $reqId."#Data berhasil disimpan.#update#".$reqMode."#".$reqDevice;
	}
}
else
{
	$periksa->setField("PERIKSA_ID", $reqId);
	$periksa->setField("PASIEN_ID", $reqPasienId);
	$periksa->setField("TGL_PERIKSA", dateToDBMysql($reqTglPeriksa));
	$periksa->setField("S", $reqS);
	$periksa->setField("A", $reqA);
	$periksa->setField("O", $reqO);
	$periksa->setField("P", $reqP);
	
	if($periksa->update())
	{	
		echo $reqId."#Data berhasil diupdate.#update#".$reqMode."#".$reqDevice;
	}
}

?>