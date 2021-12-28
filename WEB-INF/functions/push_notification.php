<?php
// Enabling error reporting
function push_fcm($title, $message, $regId, $push_type = 'individual',$include_image = FALSE){
	
	error_reporting(-1);
	ini_set('display_errors', 'On');
	
	require_once '../lib/fcm/firebase.php';
	require_once '../lib/fcm/push.php';
	
	$firebase = new Firebase();
	$push = new Push();
	
	// optional payload
	$payload = array();
	$payload['team'] = 'Deagroup';
	$payload['score'] = '5.6';
	
	
	$push->setTitle($title);
	$push->setMessage($message);
	if ($include_image) {
		$push->setImage('http://dg-itonline.com/tiket/main/assets/images/logo-login.png');
	} else {
		$push->setImage('');
	}
	$push->setIsBackground(FALSE);
	$push->setPayload($payload);
	
	
	$json = '';
	$response = '';
	
	if ($push_type == 'topic') {
		$json = $push->getPush();
		$response = $firebase->sendToTopic('global', $json);
	} else if ($push_type == 'individual') {
		$json = $push->getPush();
		$response = $firebase->send($regId, $json);
	}
	else if ($push_type == 'multiple') {
		$json = $push->getPush();
		$response = $firebase->sendMultiple($regId, $json);
	}
	//echo json_encode($json)." <br>". json_encode($response);
	
}
/*
$regId = array('ckzOiq7gZNQ:APA91bG614yJMNhADDZfH3keWCJ5CmmH1iXIYbAM9J1oSel74PB8cjokPfQrMXf_EWqUpcaQuv9eqA8uCnKMQaTMKOFUFoTM-03TgmMK0cQ0RCSR4PnQNmMkC4LMDYe5-QKJVvI5Aojp', 'fprvI3071Dg:APA91bFm7Lj713wHNJRb_kk9yy-6or7VeooDQmaASbNFIh2qLKsq8OVfHKwHBZC-8BE4h3jf5OqLK5hMpX1JcVKzSkFEwP04DRsJNnPxajgs48nOnkBoGEOxExF9jFmpJNKOqKZ5EYu0');
push_fcm("test sukses", "hore", $regId, "multiple");
*/
?>