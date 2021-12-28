<?php

$allRecord=10;
$reqJml=11;

if($allRecord==0 || $allRecord==$reqJml)
	$status="false";
else
	$status="true";
	
echo $allRecord."#".$status;
?>