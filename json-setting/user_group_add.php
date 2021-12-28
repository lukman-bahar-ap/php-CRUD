<?php
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserAccess.php");

$reqId = httpFilterPost("reqId");
$reqCheckAccessId = $_POST["reqCheckAccessId"];

$user_access_uncheck = new UserAccess();
$user_access_uncheck->setField("GROUP_ID",$reqId);
$user_access_uncheck->updateUserAccessUnCheck();

	for($i=0;$i<count($reqCheckAccessId);$i++)
	{
		$user_access_check = new UserAccess();
		
		$user_access_check->setField("GROUP_ID",$reqId);
		$user_access_check->setField("USER_ACCESS_ID", $reqCheckAccessId[$i]);	
		$user_access_check->updateUserAccessCheck();
	
		unset($user_access_check);			
	}
	
	echo "Data berhasil disimpan";
?>