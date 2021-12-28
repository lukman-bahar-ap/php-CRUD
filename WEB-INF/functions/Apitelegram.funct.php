<?php
include("token.php");
function request_url($method)
{
	global $TOKEN;
	return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}
function get_updates($offset) 
{
	$url = request_url("getUpdates")."?offset=".$offset;
        $resp = file_get_contents($url);
        $result = json_decode($resp, true);
        if ($result["ok"]==1)
            return $result["result"];
        return array();
}
function send_reply($chatid, $msgid, $text)
{
    $data = array(
        'chat_id' => $chatid,
        'text'  => $text,
        'reply_to_message_id' => $msgid
    );
    // use key 'http' even if you send the request to https://...
    $options = array(
    	'http' => array(
        	'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        	'method'  => 'POST',
        	'content' => http_build_query($data),
    	),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents(request_url('sendMessage'), false, $context);
    print_r($result);
}
function create_response($text)
{
   return "definisi " . $text;
}
function process_message($message)
{
    $updateid = $message["update_id"];
    $message_data = $message["message"];
    if (isset($message_data["text"])) {
	$chatid = $message_data["chat"]["id"];
        $message_id = $message_data["message_id"];
        $text = $message_data["text"];
        $response = create_response($text);
        send_reply($chatid, $message_id, $response);
    }
    return $updateid;
}
function process_one()
{
	$update_id  = 0;
	if (file_exists("last_update_id")) {
		$update_id = (int)file_get_contents("last_update_id");
	}
	$updates = get_updates($update_id);
	foreach ($updates as $message)
	{
     		$update_id = process_message($message);
	}
	file_put_contents("last_update_id", $update_id + 1);
}
while (true) {
	process_one();
}
          
?>