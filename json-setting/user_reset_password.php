<?php
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/email_notif.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId		= $_GET["reqId"];
$reqMode	= $_GET["reqMode"];

if($reqMode == "user_login")
{
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
	
		$user_login = new UserLoginBase();	
		$reqPasswordNew = randStrGen(5);
		
		$user_login->selectByParams(array("USER_LOGIN_ID" => $reqId));
		if($user_login->firstRow())
		{
			$reqNama = $user_login->getField("NAMA");
			$reqEmail = $user_login->getField("EMAIL");
			
			$user_login->setField("USER_LOGIN_ID", $reqId);
			$user_login->setField("USER_PASS", $reqPasswordNew);
			
			if($user_login->updatePassword())
			{
				SendEmailPass($reqEmail, $reqNama, $reqPasswordNew);
				$alertMsg .= "Data berhasil direset";
			}
		}else{
			$alertMsg .= "Nomatch";	
		}
}
if($reqMode == "reset_default")
{
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
	
		$user_login = new UserLoginBase();	
		$reqPasswordNew = "123456";
		
		$user_login->selectByParams(array("USER_LOGIN_ID" => $reqId));
		if($user_login->firstRow())
		{
			$reqNama = $user_login->getField("NAMA");
			$reqEmail = $user_login->getField("EMAIL");
			
			$user_login->setField("USER_LOGIN_ID", $reqId);
			$user_login->setField("USER_PASS", $reqPasswordNew);
			
			if($user_login->updatePassword())
			{
				SendEmailPass($reqEmail, $reqNama, $reqPasswordNew);
				$alertMsg .= "Data berhasil direset";
			}
		}else{
			$alertMsg .= "Nomatch";	
		}
}
?>