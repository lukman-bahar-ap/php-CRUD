<?php
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");

$user_login_base = new UserLoginBase();

$reqId 		= httpFilterPost("reqId");
$reqMode 	= httpFilterPost("reqMode");

$reqUserGroupId		= httpFilterPost("reqUserGroupId");
$reqNamaGroup		= httpFilterPost("reqNamaGroup");
$reqUserNama		= httpFilterPost("reqUserNama");
$reqNama			= httpFilterPost("reqNama");
$reqEmail			= httpFilterPost("reqEmail");
$reqAlamat			= httpFilterPost("reqAlamat");
$reqNoHp			= httpFilterPost("reqNoHp");
$reqPassword		= httpFilterPost("reqPassword");
$reqIdTeknisi		= httpFilterPost("reqIdTeknisi");

$reqUserPassword		= httpFilterPost("reqUserPassword");
$reqUserPasswordReType	= httpFilterPost("reqUserPasswordReType");

$reqIdPelangganKontrak	= httpFilterPost("reqIdPelangganKontrak");
$reqIdPelangganKontrakList	= httpFilterPost("reqIdPelangganKontrakList");

if($reqIdPelangganKontrak==0)
	$reqAllAkses = 1;
else
	$reqAllAkses = 0;

if($reqMode == "insert")
{
	$user_login_base->setField("USER_GROUP_ID", $reqUserGroupId);
	$user_login_base->setField("USER_NAMA", $reqUserNama);
	$user_login_base->setField("USER_PASS", $reqPassword);
	$user_login_base->setField("NAMA", $reqNama);
	$user_login_base->setField("ALAMAT", $reqAlamat);
	$user_login_base->setField("EMAIL", $reqEmail);
	$user_login_base->setField("TELEPON", $reqNoHp);
	$user_login_base->setField("UNIT_UPJ", $reqNamaGroup);
	$user_login_base->setField("TEKNISI_ID", "0");
	$user_login_base->setField("MIROR_ID", "0");
	$user_login_base->setField("PELANGGAN_KONTRAK_ID", $reqIdPelangganKontrak);
	$user_login_base->setField("ALL_AKSES", $reqAllAkses);
		
	$user_login_base->insert();
	$reqId= $user_login_base->id;
	//form login hanya bisa add admin. teknisi dan lainya di form masing2
	echo $reqId."#Data berhasil disimpan.#update";
}
else if($reqMode == "ubah_password")
{
	if($reqUserPasswordReType==$reqUserPassword)
	{
		$user_login_base->selectByParams(array("USER_LOGIN_ID" => $reqId));
		$user_login_base->firstRow();
		
		$tempUserGroupId	= $user_login_base->getField("USER_GROUP_ID");
		$tempMirorId		= $user_login_base->getField("MIROR_ID");
		if($tempUserGroupId=="5"){
			
			  /*$user_login_base->setField("MIROR_ID", $tempMirorId);
			  $user_login_base->setField("USER_GROUP_ID", $tempUserGroupId);
			  $user_login_base->setField("USER_PASS", $reqUserPassword);
			  $user_login_base->updatePasswordMirorId();*/
			  $user_login_base->setField("USER_LOGIN_ID", $reqId);
			  $user_login_base->setField("USER_PASS", $reqUserPassword);
			  
			  if($user_login_base->updatePassword()){
				  	
					include_once("../WEB-INF/classes/base/UserKontrakLogin.php");
					$pelanggan_kontrak = new UserKontrakLogin();
					$pelanggan_kontrak->setField("USER_KONTRAK_LOGIN_ID", $tempMirorId);
					$pelanggan_kontrak->setField("USER_PASS", $reqUserPassword);
					$pelanggan_kontrak->updatePassword();
			  
			 	 echo $reqId."#Data berhasil disimpan.#update";	
			  }
		}else{
		
			  $user_login_base->setField("USER_LOGIN_ID", $reqId);
			  $user_login_base->setField("USER_PASS", $reqUserPassword);
			  
			  $user_login_base->updatePassword();
		  
			  echo $reqId."#Data berhasil disimpan.#update";
		}

	}
	else
	{
	  echo $reqId."#Password tidak sama dengan ketik ulang password.#gagal";
	}
	
		
}
else
{
	
	$user_login_base->setField("USER_LOGIN_ID", $reqId);
	$user_login_base->setField("USER_GROUP_ID", $reqUserGroupId);
	$user_login_base->setField("USER_NAMA", $reqUserNama);
	$user_login_base->setField("NAMA", $reqNama);
	$user_login_base->setField("ALAMAT", $reqAlamat);
	$user_login_base->setField("EMAIL", $reqEmail);
	$user_login_base->setField("TELEPON", $reqNoHp);
	$user_login_base->setField("UNIT_UPJ", $reqNamaGroup);
	$user_login_base->setField("PELANGGAN_KONTRAK_ID", $reqIdPelangganKontrak);
	$user_login_base->setField("ALL_AKSES", $reqAllAkses);
	
	if($user_login_base->update())
	{
		include_once("../WEB-INF/classes/base/UserProject.php");
		$user_project1 = new UserProject();
		$user_project1->setField("USER_LOGIN_ID", $reqId);
		$user_project1->deleteUserLogin();
		
		if($reqAllAkses==0)
		{
			$cats = explode("*", $reqIdPelangganKontrakList);
			foreach($cats as $cat) {
				$cat = trim($cat);
				
				$user_project = new UserProject();
				$user_project->setField("USER_LOGIN_ID", $reqId); 
				$user_project->setField("TEKNISI_ID", $reqIdTeknisi); 
				$user_project->setField("PELANGGAN_KONTRAK_ID", $cat); 
				$user_project->insert();
			}
		}
	}

	echo $reqId."#Data berhasil disimpan.#update";
}
?>