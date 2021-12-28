<?Php
/* -----------------------------------------------------
Simple PHP script for Sending Telegram Bot Message
~ Iky | https://www.wadagizig.com
------------------------------------------------------ */
function sendMessage($telegram_id, $message_text, $secret_token) {
    $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=markdown&chat_id=" . $telegram_id;
    $url = $url . "&text=" . urlencode($message_text);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}
/*----------------------
only basic POST method :
-----------------------*/
$telegram_id = "673184047";
//$telegram_id = "+628155700852";
$message_text = "test";
/*--------------------------------
Isi TOKEN dibawah ini: 
--------------------------------*/
$secret_token = "673184047:AAFv_ippP2dlYmSkedLyq3os6IP2c2nCFJ0";
sendMessage($telegram_id, $message_text, $secret_token);
echo "<script>alert('Pesan berhasil terkirim!'); window.location.href = './';</script>";
?>