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

if($reqMode == "user_login")
{
	include_once("../WEB-INF/classes/base/UserLoginBase.php");
	
	$user_login = new UserLoginBase();
	
	$user_login->selectByParams(array("USER_LOGIN_ID" => $reqId));
	$user_login->firstRow();
						
	$user_login->setField("USER_LOGIN_ID", $reqId);
	if($user_login->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$user_login->getErrorMsg();
}
?>
