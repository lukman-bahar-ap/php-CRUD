<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: date.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle date operations
***************************************************************************************************** */

	function dateToPage($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function datetimeToPage($_date, $_type){
		if($_date == "")
			return "";
		$arrDateTime = explode(" ", $_date);
		if($_type == "date")
		{
			$arrDate = explode("-", $arrDateTime[0]);
			$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
			return $_date;
		}
		else
		{
			$_date = $arrDateTime[1];
			$arrTime = explode(":", $_date);
			if($_type == "hour")
				return $arrTime[0];
			elseif($_type == "minutes")
				return $arrTime[1];						
			else
				return $_date;							
		}
	}	
	
	function dateToPageCheck($_date, $validate=''){
		if($_date == "")
		{
			return "";	
		}
		
		if($validate == 1){
			if(substr($_date, 0, 2) == "[]"){
				$explode = explode('[]',$_date);
				$arrDate = explode("-", $explode[2]);
				$_date= ''.$arrDate[0]."-".$arrDate[1]."-".$arrDate[2];
			}else{
				$arrDate = explode("-", $_date);
				$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
			}
		}
		else{
			$arrDate = explode("-", $_date);
			$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		}
			return $_date;
	}
	
	function dateToPageBulan($_date, $validate=''){
		if($_date == "")
		{
			return "";	
		}
			$arrDate 	= substr($_date, 6, 2);
			$arrMonth 	= substr($_date, 4, 2);
			$arrYear 	= substr($_date, 0, 4);
			
			$_date = $arrDate."-".$arrMonth."-".$arrYear;
			return $_date;
	}
	
	function getDiffDay($start_date,$end_date){
		// $start_date -> thn -  bln - tgl
		$tglAwal = strtotime($start_date);
		$tglAkhir = strtotime($end_date);
		$jeda = abs($tglAkhir - $tglAwal);
		return floor($jeda/(60*60*24));
	}
	
	function getDiffYear($start_date,$end_date){
			//$start_date = "2007-03-24";
			//$end_date = "2009-06-26";
			
			$diff = abs(strtotime($end_date) - strtotime($start_date));
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			//printf("%d years, %d months, %d days\n", $years, $months, $days);
			return $end_date." (".$start_date.") ".$years;
	}
	
	function dateToDB($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[0]."-".$arrDate[1];
		return $_date;
	}
	
	function dateToDBMysql($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function dateToDBExcel($_date){
		$arrDate = explode("/", $_date);
		$_date = $arrDate[2]."-".$arrDate[0]."-".$arrDate[1];
		return $_date;
	}	
	
	function dateToIna($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[0]."-".$arrDate[1];
		return $_date;
	}		
	
	function dateToDBCheck($_date){
		if($_date == "")
		{
			return "NULL";	
		}
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return "TO_DATE('".$_date."', 'YYYY-MM-DD')";
	}
	
	function dateMixToDB($_date){
		$arrDate = explode("/", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function dateToExcel($_date) {
		$tgl 	= substr($_date, 0,2);
		$bulan 	= substr($_date, 2,2);
		$tahun 	= substr($_date, 4,4);
		 
		return $tgl."-".$bulan."-".$tahun;
	}	
	
	function getDay($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[2];
	}
	
	function getMonth($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[1];
	}
	
	function getYear($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[0];
	}
	
	function getNamePeriode($periode) {
		$tahun = substr($periode, 0,4);
		$bulan = substr($periode, 4,2);
		 
		return getNameMonth((int)$bulan)." ".$tahun;
	}
	
	function getNamePeriodeUrut($periode) {
		$bulan = substr($periode, 0,2);
		$tahun = substr($periode, 2,4);
		 
		return $tahun." ".(int)$bulan;
	}		
	
	function getNameMonth($number) {
		$number = (int)$number;
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");
		return $arrMonth[$number];
	}
	
	function getNameMonthHeader($number) {
		//$number = (int)$number;
		$arrMonth = array("01"=>"JAN", "02"=>"FEB", "03"=>"MAR", "04"=>"APR", "05"=>"MEI", 
						  "06"=>"JUN", "07"=>"JUL", "08"=>"AGU", "09"=>"SEP", "10"=>"OKT", 
						  "11"=>"NOV", "12"=>"DES");
		return $arrMonth[$number];
	}	

	function getRomawiMonth($number) {
		$arrMonth = array("1"=>"I", "2"=>"II", "3"=>"III", "4"=>"IV", "5"=>"V", 
						  "6"=>"VI", "7"=>"VII", "8"=>"VIII", "9"=>"IX", "10"=>"X", 
						  "11"=>"XI", "12"=>"XII");
		return $arrMonth[$number];
	}
	
	// date input : database
	function getFormattedDateJson($_date)
	{
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);

		$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
		return $date;
	}
	
	function getValueDate($_date)
	{		
		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);
		
		$jumHari = cal_days_in_month(CAL_GREGORIAN, $_month, $arrDate[0]);	
		$date = $jumHari;
		
		return $date;
	}
	
	function getFormattedDate($_date)
	{
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);

		$date = ''.$arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0].'';
		return $date;
	}
	
	function getFormattedDateTimeNoSpace($_date, $showTime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
		
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $explodedDate);
		$_month = intval($arrDate[1]);
		
		$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
		$time = $explodedTime;

		if($showTime == true)
			$datetime = $date.' '.substr($time, 0, 5);
		else
			$datetime = '<span style="white-space:nowrap">'.$date.'</span>';
		return $datetime;
	}	
	
	// date input : database
	function getFormattedDateTime($_date, $showTime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
		
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $explodedDate);
		$_month = intval($arrDate[1]);
		
		$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
		$time = $explodedTime;

		if($showTime == true)
			/*$datetime = '<span style="white-space:nowrap">'.$date.',&nbsp;'.$time.'</span>';*/
			$datetime = $arrDate[2]." ".$arrMonth[$_month]." ".$arrDate[0]." - ".$time;
		else
			/*$datetime = '<span style="white-space:nowrap">'.$date.'</span>';*/
			$datetime = $arrDate[2]." ".$arrMonth[$_month]." ".$arrDate[0];
		return $datetime;
	}
	
	function getFormattedDateTimeMysql($_date, $showTime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
		
		$arrDate = explode("-", $explodedDate);
		$time = $explodedTime;

		if($showTime == true)
			$datetime = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0]." ".$time;
		else
			$datetime = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $datetime;
	}
	
	function dateToDBDateTimeMysql($_date,$_istime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		if($_time==true)
			$explodedTime = $_date[1];
		else
			$explodedTime = "0:00:00";
			
		$arrDate = explode("-", $explodedDate);
		$time = $explodedTime;

		$datetime = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0]." ".$time;
		return $datetime;
	}	

	function getJumlahHari($bulan=0, $tahun=0) {
	 
		$bulan = $bulan > 0 ? $bulan : date("m");
		$tahun = $tahun > 0 ? $tahun : date("Y");
	 
		switch($bulan) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;
				break;
			case 4:
			case 6:
			case 9:
			case 11:
				return 30;
				break;
			case 2:
				return $tahun % 4 == 0 ? 29 : 28;
				break;
		}
	}
	
	function getFormattedDateTimeMysqlWithDay($_date, $showTime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
		
		$arrDate = explode("-", $explodedDate);
		$time = $explodedTime;
		
		$day = date('D', strtotime($explodedDate));
		$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);		

		if($showTime == true)
			$datetime = $dayList[$day].", ".$arrDate[2]."-".$arrDate[1]."-".$arrDate[0]." - ".$time;
		else
			$datetime = $dayList[$day].", ".$arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $datetime;
	}		
?>
