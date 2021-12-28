<?php
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Pasien.php");
include_once("../WEB-INF/functions/image.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
		
$pasien = new Pasien();
$pasienMatch = new Pasien();
$user_login_base = new UserLoginBase();


$reqId		 	= httpFilterPost("reqId");
$reqNoIdentitas	= httpFilterPost("reqNoIdentitas");
$reqNama		= httpFilterPost("reqNama");
$reqTglLahir	= httpFilterPost("reqTglLahir");
$reqNoHp		= httpFilterPost("reqNoHp");
$reqAlamat		= httpFilterPost("reqAlamat");

$reqMode		= httpFilterPost("reqMode");
$reqDevice		= httpFilterPost("reqDevice");

if($reqMode == "insert")
{

	$pasienMatch->selectMatchPasien($reqNoIdentitas);
	if($pasienMatch->firstRow()){
		
		echo "0"."#Identitas telah terdaftar sebelumnya .#update#".$reqMode."#".$reqDevice;
		
	}else{

		$pasien->setField("NO_IDENTITAS", $reqNoIdentitas);
		$pasien->setField("NAMA", $reqNama);
		$pasien->setField("TGL_LAHIR", dateToDBMysql($reqTglLahir));
		$pasien->setField("ALAMAT", $reqAlamat);
		$pasien->setField("NO_HP", $reqNoHp);
			
		if($pasien->insert())
		{
			$reqId= $pasien->id;	
			echo $reqId."#Data berhasil disimpan.#update#".$reqMode."#".$reqDevice;
		}
	}

}
else
{
	$pasien->setField("PASIEN_ID", $reqId);
	$pasien->setField("NO_IDENTITAS", $reqNoIdentitas);
	$pasien->setField("NAMA", $reqNama);
	$pasien->setField("TGL_LAHIR", dateToDBMysql($reqTglLahir));
	$pasien->setField("ALAMAT", $reqAlamat);
	$pasien->setField("NO_HP", $reqNoHp);
	
	if($pasien->update())
	{	
		echo $reqId."#Data berhasil diupdate.#update#".$reqMode."#".$reqDevice;
	}
}

?>