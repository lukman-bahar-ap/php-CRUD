<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
	$namaPegawai = $userLogin->nama;
}
$reqHour=gmdate("H", time()+60*60*7);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-sibagus.jpg">
<title>Dokterku</title>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../main/css/admin.css" rel="stylesheet" type="text/css">
<link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../main/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="../main/css/bluetabs.css" />
<script type="text/javascript" src="../main/css/dropdowntabs.js"></script>

<!-- CSS BARU-->
		<link rel="stylesheet" href="../main/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../main/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../main/assets/fonts/style.css">
		<link rel="stylesheet" href="../main/assets/css/main.css">
<!-- Tutup CSS BARU -->
</head>
<body class="tinggi">
<div id="wadah">
   <div class="container">
        <ol class="breadcrumb">
          <li class="active">
              <i class="clip-home-3"></i>&nbsp;&nbsp;Home
          </li>
          <li class="active">Homepage</li>
       </ol>
  </div><br>    
  <div class="alert alert-info" align="center">
      <i class="fa fa-check-circle"></i>&nbsp; Selamat <?=greeting($reqHour).", ".$namaPegawai?>
  </div>
  <div id="object" align="center">
  	<img src="assets/images/logo-login.png" style="margin-bottom:25px;">
    <p><b>Dokterku</b><br>Aplikasi Pencatatan Riwayat Pasien</p>    
  </div>
  <div class="alert alert-info" align="center">
      Designed and developed by agungtech
  </div>    
</div>
</body>
</html>