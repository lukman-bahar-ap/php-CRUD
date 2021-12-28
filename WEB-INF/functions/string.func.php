<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: string.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */



/* fungsi untuk mengatur tampilan mata uang
 * $value = string
 * $digit = pengelompokan setiap berapa digit, default : 3
 * $symbol = menampilkan simbol mata uang (Rupiah), default : false
 * $minusToBracket = beri tanda kurung pada nilai negatif, default : true
 */
function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = "Rp. ".$resValue."";
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";
	$resValue = str_replace("..", ",", $resValue);
	return $resValue;
}

function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function bigIntval($value) {
  $value = trim($value);
  if (ctype_digit($value)) {
    return $value;
  }
  $value = preg_replace("/[^0-9](.*)$/", '', $value);
  if (ctype_digit($value)) {
    return $value;
  }
  return 0;
}

function getNameValueYaTidak($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}

function getNameLampiran($number) {
	$number = (int)$number;
	$arrValue = array(
	"1"=>"KTP", 
	"2"=>"CV", 
	"3"=>"IJASAH", 
	"4"=>"SERTIFIKAT 1",
	"5"=>"SERTIFIKAT 2 (Jika ada)",
	"6"=>"SERTIFIKAT 3 (Jika ada)"
	);
	return $arrValue[$number];
}
	
function dotToComma($varId)
{
	$newId = str_replace(".", ",", $varId);	
	return $newId;
}

function CommaToQuery($varId)
{
	$newId = str_replace(",", "','", $varId);	
	return $newId;
}

function dotToNo($varId)
{
	$newId = str_replace(".", "", $varId);	
	return $newId;
}

function CommaToNo($varId)
{
	$newId = str_replace(",", "", $varId);	
	return $newId;
}

function CrashToNo($varId)
{
	$newId = str_replace("#", "", $varId);	
	return $newId;
}

function StarToNo($varId)
{
	$newId = str_replace("* ", "", $varId);	
	return $newId;
}

function NullDotToNo($varId)
{
	$newId = str_replace(".00", "", $varId);
	return $newId;
}

function ExcelToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = CommaToNo($newId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNull($varId)
{
	if($varId == '')
		return 0;
	else
		return $varId;
}

function ValToNullDB($varId)
{
	if($varId == '')
		return 'NULL';
	else
		return "'".$varId."'";
}
// fungsi untuk generate nol untuk melengkapi digit

function generateZero($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";
	
	$lengthZero = $digitGroup - strlen($varId);
	
	for($i = 0; $i < $lengthZero; $i++)
	{
		$newId .= $digitCompletor;
	}
	
	$newId = $newId.$varId;
	
	return $newId;
}

// truncate text into desired word counts.
// to support dropDirtyHtml function, include default.func.php
function truncate($text, $limit, $dropDirtyHtml=true)
{
	$tmp_truncate = array();
	$text = str_replace("&nbsp;", " ", $text);
	$tmp = explode(" ", $text);
	
	for($i = 0; $i <= $limit; $i++)		//truncate how many words?
	{
		$tmp_truncate[$i] = $tmp[$i];
	}
	
	$truncated = implode(" ", $tmp_truncate);
	
	if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
		return dropAllHtml($truncated);
	else
		return $truncated;
}

function arrayMultiCount($array, $field_name, $search)
{
	$summary = 0;
	for($i = 0; $i < count($array); $i++)
	{
		if($array[$i][$field_name] == $search)
			$summary += 1;
	}
	return $summary;
}

function getValueArray($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= $var[$i];
		else
			$tmp .= ",".$var[$i];
	}
	
	return $tmp;
}

function getValueArrayMonth($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= "'".$var[$i]."'";
		else
			$tmp .= ", '".$var[$i]."'";
	}
	
	return $tmp;
}

function getColoms($var)
{
	$tmp = "";
	if($var == 0)	$tmp = 'D';
	elseif($var == 1)	$tmp = 'E';
	elseif($var == 2)	$tmp = 'F';
	elseif($var == 3)	$tmp = 'G';
	elseif($var == 4)	$tmp = 'H';
	elseif($var == 5)	$tmp = 'I';
	elseif($var == 6)	$tmp = 'J';
	elseif($var == 7)	$tmp = 'K';
	
	return $tmp;
}

function setNULL($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = $var;
	
	return $tmp;
}

function setVal_0($var)
{	
	if($var == '')
		$tmp = '0';
	else
		$tmp = $var;
	
	return $tmp;
}

function get_null_10($varId)
{
	if($varId == '') return '';
	if($varId < 10)	$temp= '0'.$varId;
	else			$temp= $varId;
			
	return $temp;
}

function _ip( )
{
    return ( preg_match( "/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
}

function searchWordDelimeter($varSource, $varSearch, $varDelimeter=",")
{

	$arrSource = explode($varDelimeter, $varSource);
	
	for($i=0; $i<count($arrSource);$i++)
	{
		if(trim($arrSource[$i]) == $varSearch)
			return true;
	}
	
	return false;
}

function getZodiac($day,$month){
	if(($month==1 && $day>20)||($month==2 && $day<20)){
	$mysign = "Aquarius";
	}
	if(($month==2 && $day>18 )||($month==3 && $day<21)){
	$mysign = "Pisces";
	}
	if(($month==3 && $day>20)||($month==4 && $day<21)){
	$mysign = "Aries";
	}
	if(($month==4 && $day>20)||($month==5 && $day<22)){
	$mysign = "Taurus";
	}
	if(($month==5 && $day>21)||($month==6 && $day<22)){
	$mysign = "Gemini";
	}
	if(($month==6 && $day>21)||($month==7 && $day<24)){
	$mysign = "Cancer";
	}
	if(($month==7 && $day>23)||($month==8 && $day<24)){
	$mysign = "Leo";
	}
	if(($month==8 && $day>23)||($month==9 && $day<24)){
	$mysign = "Virgo";
	}
	if(($month==9 && $day>23)||($month==10 && $day<24)){
	$mysign = "Libra";
	}
	if(($month==10 && $day>23)||($month==11 && $day<23)){
	$mysign = "Scorpio";
	}
	if(($month==11 && $day>22)||($month==12 && $day<23)){
	$mysign = "Sagitarius";
	}
	if(($month==12 && $day>22)||($month==1 && $day<21)){
	$mysign = "Capricorn";
	}
	return $mysign;
}

function getExe($tipe)
{
	switch ($tipe) {
	  case "application/pdf": $ctype="pdf"; break;
	  case "application/octet-stream": $ctype="exe"; break;
	  case "application/zip": $ctype="zip"; break;
	  case "application/msword": $ctype="doc"; break;
	  case "application/vnd.ms-excel": $ctype="xls"; break;
	  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
	  case "image/gif": $ctype="gif"; break;
	  case "image/png": $ctype="png"; break;
	  case "image/jpeg": $ctype="jpeg"; break;
	  case "image/jpg": $ctype="jpg"; break;
	  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
	  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
	  default: $ctype="application/force-download";
	} 
	
	return $ctype;
}

function getStatusTiket($num)
{
	switch ($num) {
	  case 1: $st="Open"; break;
	  case 2: $st="Assignee"; break;
	  case 3: $st="On progress"; break;
	  case 4: $st="Pending"; break;
	  case 5: $st="Resolved"; break;
	  case 6: $st="Cancel"; break;
	  case 7: $st="Closed"; break;
	  case 8: $st="Pending - Part Request"; break;
	  case 9: $st="Confirmed Part"; break;
	  case 10: $st="On Delivery Part"; break;
	  case 11: $st="Delivered Part"; break;
  	  case 12: $st="Pending - Rejected by IT on site"; break;
	  case 13: $st="Not Confirmed Part"; break;
	  case 14: $st="Re Assignee"; break;
	  case 15: $st="Re Open"; break;
	  default: $st="Unknown";
	} 
	
	return $st;
}

function getJenisTiket($num)
{
	switch ($num) {
	  case 1: $st="Maintenance Contract"; break;
	  case 2: $st="Call Of Service"; break;
	  default: $st="Unknown";
	} 
	
	return $st;
}

function getJenisUnit($num)
{
	switch ($num) {
	  case 1: $ju="CPU"; break;
	  case 2: $ju="Monitor"; break;
	  case 3: $ju="PC"; break;
	  case 4: $ju="NoteBook"; break;
	  case 5: $ju="CCTV"; break;
	  case 6: $ju="Printer"; break;
	  case 7: $ju="Proyektor"; break;
	  case 8: $ju="LAN"; break;
	  default: $ju="Unknown";
	} 
	return $ju;
}

function getKategori($num)
{ 
	switch ($num) {
	  case 1: $gk="Hardware"; break;
	  case 2: $gk="Software"; break;
	  case 3: $gk="Operating System"; break;
	  case 4: $gk="Network"; break;
	  case 5: $gk="Other"; break;
	  default: $gk="Unknown";
	} 
	return $gk;
}

function getJenisPengaduan($num)
{ 
	switch ($num) {
	  case 1: $jp="Incident"; break;
	  case 2: $jp="Instal"; break;
	  case 3: $jp="Setting"; break;
	  case 4: $jp="Maintenance"; break;
	  case 5: $jp="Request"; break;
	  case 6: $jp="Other"; break;
	  default: $jp="Unknown";
	} 
	return $jp;
}
function getStatusPelanggan($num)
{ 
	switch ($num) {
	  case 1: $jp="User Pelanggan Kontrak"; break;
	  case 2: $jp="Pelanggan Umum"; break;
	  case 3: $jp="Tidak Terdaftar"; break;
	  default: $jp="Unknown";
	} 
	return $jp;
}

function jenisunitToDb($num)
{
	switch ($num) {
	  case "CPU": $ju=1; break;
	  case "Monitor": $ju=2; break;
	  case "PC": $ju=3; break;
	  case "NoteBook": $ju=4; break;
	  case "CCTV": $ju=5; break;
	  case "Printer": $ju=6; break;
	  case "Proyektor": $ju=7; break;
	  case "LAN": $ju=8; break;
	  default: $ju="-";
	} 
	return $ju;
}

function terbilang($bilangan){
 $bilangan = abs($bilangan);
 
$angka = array("","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas");
 $temp = "";
 
if($bilangan < 12){
 $temp = " ".$angka[$bilangan];
 }else if($bilangan < 20){
 $temp = terbilang($bilangan - 10)." Belas";
 }else if($bilangan < 100){
 $temp = terbilang($bilangan/10)." Puluh".terbilang($bilangan%10);
 }else if ($bilangan < 200) {
 $temp = " seratus".terbilang($bilangan - 100);
 }else if ($bilangan < 1000) {
 $temp = terbilang($bilangan/100). " Ratus". terbilang($bilangan % 100);
 }else if ($bilangan < 2000) {
 $temp = " seribu". terbilang($bilangan - 1000);
 }else if ($bilangan < 1000000) {
 $temp = terbilang($bilangan/1000)." Ribu". terbilang($bilangan % 1000);
 }else if ($bilangan < 1000000000) {
 $temp = terbilang($bilangan/1000000)." Juta". terbilang($bilangan % 1000000);
 }else if ($bilangan < 1000000000000) {
 $temp = terbilang($bilangan/1000000000)." Milyar". terbilang(fmod($bilangan,1000000000));
 }else if ($bilangan < 1000000000000000) {
 $temp = terbilang($bilangan/1000000000000)." Triliyun". terbilang(fmod($bilangan,1000000000000));
 }
 
return $temp;
}

function randStrGen($len){
	$result = "";
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$charArray = str_split($chars);
	for($i=0; $i < $len; $i++){
		$randamItem = array_rand($charArray);
		$result .= "".$charArray[$randamItem];
	}
	return $result;
}

function greeting($reqHour){

	if($reqHour < 10)
	{
		$greet="pagi";
	}
	else if($reqHour >= 10 && $reqHour < 15)
	{
		$greet="siang";	
	}
	else if($reqHour >= 15 && $reqHour < 20)
	{
		$greet="sore";	
	}
	else if($reqHour >= 20)
	{
		$greet="malam";
	}
return $greet;
}

function titleWeb(){
echo "Dokterku - Aplikasi Pencatatan Riwayat Pasien";
}
?>