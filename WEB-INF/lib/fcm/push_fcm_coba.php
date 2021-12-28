<?php
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyCTCVKhTYD6qPsLvYPIfaRJImTBggeguX0' );
//$registrationIds = array( $_GET['id'] );
$registrationIds = array('eFNvsxIq-2o:APA91bE-9EAi6Ezw1MOJneyRt9eCLAcAv0OOmxn-Xp8TxWpTtgAAs-_Cp3ppwrf7kWGY0ZjvrJkiolcfo8vrLZAJFbfR5zM-EG8qJ5weJQV7bqF9XxR7Jz5xVnaZYjM3u5638IPTH7j8');

// prep the bundle
$msg = array
(
	'message' 	=> 'test FCM',
	'title'		=> 'title FCM',
	'subtitle'	=> 'subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1 /*,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'*/
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
?>