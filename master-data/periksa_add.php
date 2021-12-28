<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Periksa.php");
include_once("../WEB-INF/classes/base/Pasien.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$periksa = new Periksa();
$pasien = new Pasien();

$reqMode = httpFilterGet("reqMode");
$reqId 	 = httpFilterGet("reqId");
$reqNama = httpFilterGet("reqNama");
$reqDevice = httpFilterGet("reqDevice");


if($reqMode == "insert")
{
	
	$pasien->selectByParams(array("PASIEN_ID" => $reqId));
	$pasien->firstRow();
	
	$tempNoIdentitas  	= $pasien->getField("NO_IDENTITAS");
	$tempNama 			= $pasien->getField("NAMA");
	$tempNoHp 			= $pasien->getField("NO_HP");
	$tempTglLahir 		= $pasien->getField("TGL_LAHIR");
	$tempAlamat			= $pasien->getField("ALAMAT");
	$tempUsia			= $pasien->getField("USIA");
	$tempPasienId       = $reqId;
}
else
{
	$periksa->selectByParams(array("PERIKSA_ID" => $reqId));
	if($periksa->firstRow()){
	
	$tempPasienId	= $periksa->getField("PASIEN_ID");
	$tempS 			= $periksa->getField("S");
	$tempO 			= $periksa->getField("O");
	$tempA			= $periksa->getField("A");
	$tempP			= $periksa->getField("P");
	$tempTglPeriksa	= $periksa->getField("TGL_PERIKSA");
	
	
		$pasien->selectByParams(array("PASIEN_ID" => $tempPasienId));
		$pasien->firstRow();
		
		$tempNoIdentitas  	= $pasien->getField("NO_IDENTITAS");
		$tempNama 			= $pasien->getField("NAMA");
		$tempNoHp 			= $pasien->getField("NO_HP");
		$tempTglLahir 		= $pasien->getField("TGL_LAHIR");
		$tempAlamat			= $pasien->getField("ALAMAT");
		$tempUsia			= $pasien->getField("USIA");
	
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-ksp.png">
<title><?=titleWeb()?></title>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../main/css/admin.css" rel="stylesheet" type="text/css">
<link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">

<!-- CSS BARU-->
    <link rel="stylesheet" href="../main/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../main/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../main/assets/fonts/style.css">
    <link rel="stylesheet" href="../main/assets/css/main.css">
<!-- Tutup CSS BARU -->

    <link rel="stylesheet" type="text/css" href="../main/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../main/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
	<script type="text/javascript" src="../main/js/globalfunction.js"></script>	
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-master-data/periksa_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("#");
					$.messager.alert('Info', data[1], 'info', function(){
						window.top.displayUrlFromIframeChild('../master-data/periksa.php?reqId=<?=$reqId?>&reqNama=<?=$tempNama?>');
						window.parent.divwin.close();		
					});
				
				}
			});
		});
		
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};		
	</script>
    
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>

    <script language="javascript">
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
        var left = 10;
        
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=25,resize=1,scrolling=1,midle=1'); return false;
    }
	function ResetPelangganKontrak() {
        document.getElementById('reqPelangganKontrak').value = '';
		document.getElementById('reqIdPelangganKontrak').value = '';
    }
    </script>

 <!-- Scroll -->    
    	<script type="text/javascript">
    $(document).ready(function(){
        var ScreenX = $(window).width(), ScreenY = $(window).height();	
        var cssScrollHeight = document.getElementById("container_scroll");
        cssScrollHeight.style.height = ScreenY - 90 + "px";
		
	  $("#reqEmail").keyup(function(){
		   var email = $("#reqEmail").val();
		   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		   if (!filter.test(email)) {
			 //alert('Please provide a valid email address');
			 $("#erroremail").text(email+" is not a valid email");
			 //return false;
		  } else {
			  $("#erroremail").text("");
		  }
	   });
	 
    });
	function isNumberKey(evt){
	  var charCode = (evt.which) ? evt.which : event.keyCode
	  if (charCode > 31 && (charCode < 48 || charCode > 57))
		  return false;
	  return true;
	}
    </script>
<link href="../WEB-INF/lib/perfect-scrollbar-master/examples/custom-theme.css" rel="stylesheet">
  <script src="../WEB-INF/lib/perfect-scrollbar-master/dist/js/perfect-scrollbar.js"></script>
  <style>
    .contentHolder { position: relative; margin:0px auto; padding:0px; width: 100%; overflow: hidden; }
  </style> 
<!-- akhir Scroll -->    

</head>
<body class="tinggi">

<div id="begron_data_table"></div>
                 
 	 <div class="container">
    	  <ol class="breadcrumb">
            <li class="active">
            <i></i>&nbsp;
              <?
				echo "<b>".$tempNama."</b> (".$tempUsia." th)";
			  ?>
          	</li>
      	</ol>
  	</div>
  <div class="panel-heading">
    <i class="fa fa-external-link-square"></i>
        <a href="#" onClick="$('#btnSubmit').click();"><img src="../main/images/btn-simpan.png" width="15" height="15"/> Simpan</a>
        &nbsp;&nbsp;&nbsp;
        <a href="#" onClick="window.parent.divwin.close();" title="Tutup"><img src="../main/images/btn-batal.png" width="15" height="15"/> Tutup</a>
   </div>    
<div id="container_scroll" class="contentHolder">    
   <div class="col-md-6" style="margin-top:20px">
   <? if($reqDevice==1){ ?>
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<table class="datatable form-desktop" width="90%" align="center">
            <tr>
            	<td colspan="3" bgcolor="#FFFF99">Data Periksa</td>
            </tr>
             <tr>
                <td width="30%">Tanggal Periksa</td>
                <td width="1%">:</td>
                <td>
                <?
				if($reqMode=="insert")
				{
					$reqTglPeriksa=date("d-m-Y");
				}
				else
				{
					$reqTglPeriksa=dateToPage($tempTglPeriksa);
				}?>
				<input id="reqTglPeriksa" name="reqTglPeriksa" class="easyui-datebox" title="dd-mm-yyyy" data-options="validType:'date'" style="color:#000" value="<?=$reqTglPeriksa?>"></input>
				</td>
            </tr>
            <tr>
                <td width="40%">S (Keluhan)</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqS" name="reqS" size="60" style="color:#000" required="true" value="<?=$tempS?>"></td>
            </tr>
            <tr>
                <td width="40%">O (Hasil Pemeriksaan)</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqO" name="reqO" size="60" style="color:#000" required="true" value="<?=$tempO?>"></td>
            </tr>
            <tr>
                <td width="40%">A (Diagnosis)</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqA" name="reqA" size="60" style="color:#000" required="true" value="<?=$tempA?>"></td>
            </tr>
            <tr>
                <td width="40%">P (Obat)</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqP" name="reqP" size="60" style="color:#000" required="true" value="<?=$tempP?>"></td>
            </tr>
            </table>
               
        <div style="display:none">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">   
        <input type="text" id="reqPasienId" name="reqPasienId" value="<?=$tempPasienId?>">         
	   <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       </div>
    </form>
    
    <? }else{ ?>
     <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table class="datatable form-mobile" width="90%" align="center">
            <tr>
            	<td colspan="3" bgcolor="#FFFF99">Data Periksa</td>
            </tr>
            <tr>
                <td width="30%">Tanggal Periksa</td>
            </tr><tr>
                <td>
                <?
				if($reqMode=="insert")
				{
					$reqTglPeriksa=date("d-m-Y");
				}
				else
				{
					$reqTglPeriksa=dateToPage($tempTglPeriksa);
				}?>
				<input id="reqTglPeriksa" name="reqTglPeriksa" class="easyui-datebox" title="dd-mm-yyyy" data-options="validType:'date'" style="color:#000" value="<?=$reqTglPeriksa?>"></input>
				</td>
            </tr>
            <tr>
                <td width="30%">S (Keluhan)</td>
            <tr></tr>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqS" name="reqS" size="60" style="color:#000" required="true" value="<?=$tempS?>"></td>
            </tr>
            <tr>
                <td width="30%">O (Hasil)</td>
            <tr></tr>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqO" name="reqO" size="60" style="color:#000" required="true" value="<?=$tempO?>"></td>
            </tr>
            <tr>
                <td width="30%">A (Diagnosis)</td>
            <tr></tr>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqA" name="reqA" size="60" style="color:#000" required="true" value="<?=$tempA?>"></td>
            </tr>
            <tr>
                <td width="30%">P (Obat)</td>
            <tr></tr>
                <td><input type="text" maxlength="2000" class="easyui-validatebox" id="reqP" name="reqP" size="60" style="color:#000" required="true" value="<?=$tempP?>"></td>
            </tr>
            </table>
              <div style="display:none">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
        <input type="text" id="reqPasienId" name="reqPasienId" value="<?=$tempPasienId?>">
         
	   <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       </div>
    </form>
            <? } ?>
    </div> 
</div>
<script>
  var scrollvar = document.querySelector.bind(document);
  var container_scroll = scrollvar('#container_scroll');
  window.onload = function () {
    Ps.initialize(container_scroll, { theme: 'square' });
  };
</script>

</body>
</html>