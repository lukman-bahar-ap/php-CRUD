<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/base/PelangganKontrak.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
	$reqPelangganKontrakId=$userLogin->userPelangganKontrakId;
}
$user_login_base = new UserLoginBase();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqDevice = httpFilterGet("reqDevice");

if($reqPelangganKontrakId==0){

	$tempPelangganKontrak="All Access";
	$tempIdPelanggan="0";

}else{
	include_once("../WEB-INF/classes/base/PelangganKontrak.php");
	$pelanggan_kontrak = new PelangganKontrak();
	
	$pelanggan_kontrak->selectByParams(array("PELANGGAN_KONTRAK_ID" => $reqPelangganKontrakId));
	$pelanggan_kontrak->firstRow();
	
	$tempPelangganKontrak = $pelanggan_kontrak->getField("NAMA");
	$tempIdPelanggan=$reqPelangganKontrakId;
}


if($reqId == "")
{
	$reqMode = "insert";	

}
else
{
	$user_login_base->selectByParams(array("USER_LOGIN_ID" => $reqId));
	$user_login_base->firstRow();
	
	$tempUserGroupId	= $user_login_base->getField("USER_GROUP_ID");
	$tempUserNama		= $user_login_base->getField("USER_NAMA");
	$tempNama			= $user_login_base->getField("NAMA");
	$tempNoHp 			= $user_login_base->getField("TELEPON");
	$tempEmail			= $user_login_base->getField("EMAIL");
	$tempAlamat 		= $user_login_base->getField("ALAMAT");
	$tempNamaGroup		= $user_login_base->getField("NAMA_USER_GROUP");
	$tempUserPassAsli	= $user_login_base->getField("USER_PASS");
	$tempIdPelanggan	= $user_login_base->getField("PELANGGAN_KONTRAK_ID");
	$tempIdTeknisi		= $user_login_base->getField("TEKNISI_ID");
	
	
	if($tempIdPelanggan==0){
		$tempPelangganKontrak="All Access";
		$tempIdPelanggan="0";	
		
		if($tempUserGroupId=="3"){
			
			$pelanggan_kontrak = new PelangganKontrak();	
			$pelanggan_kontrak->getCountByParams(array());
			$pelanggan_kontrak->firstRow();
			
			$tempAllKontrak = $pelanggan_kontrak->getField("ROWCOUNT");
		
			$user_project = new PelangganKontrak();
			$user_project->selectByParams(array());
		
		}
		
	}else{
				
		if($tempUserGroupId=="3"){
			
			$pelanggan_kontrak = new PelangganKontrak();	
			$pelanggan_kontrak->getCountByParams(array());
			$pelanggan_kontrak->firstRow();
			
			$tempAllKontrak = $pelanggan_kontrak->getField("ROWCOUNT");
		
			include_once("../WEB-INF/classes/base/UserProject.php");
			$user_project = new UserProject();
			$user_project->selectByParamsPelangganKotrak(array("USER_LOGIN_ID" => $reqId));
		
		}else{
			
			$pelanggan_kontrak = new PelangganKontrak();	
			$pelanggan_kontrak->selectByParams(array("PELANGGAN_KONTRAK_ID" => $tempIdPelanggan));
			$pelanggan_kontrak->firstRow();
			
			$tempPelangganKontrak = $pelanggan_kontrak->getField("NAMA");
		}

	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-ksp.png">
<title>goIT - Aplikasi Monitoring Tiket</title>
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
				url:'../json-setting/user_login_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("#");
					$.messager.alert('Info', data[1], 'info');
					//$('#rst_form').click();
					//parent.frames['mainFramePop'].location.href = 'arsip_add_identitas_pribadi_monitoring.php?reqId=' + data[0];
					window.top.displayUrlFromIframeChild('../setting/user_login.php');
					window.parent.divwin.close();					
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
	var array_id_project = [] ;
	var val_id_project = "";
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
        var left = 10;
        
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=25,resize=1,scrolling=1,midle=1'); return false;
    }
	function OpenPelangganKontrakArray(){
		OpenDHTML('../master-data/pelanggan_kontrak_add_array_lookup.php?reqIdPelangganKontrakList='+val_id_project+'&reqDevice=<?=$reqDevice?>', 'Monitoring Tiket', 575, 435);
	}
    </script>
    </script>
	<script type="text/javascript">
    function ResetNamaGroup() {
        document.getElementById('reqNamaGroup').value = '';
        document.getElementById('reqUserGroupId').value = '';
    }
	function HiddenTrTable(v) {
		if(v=="0")
		{
		  var element = document.getElementById("trHiddenPelanggan");
		  element.classList.remove("HiddenTr");
		  document.getElementById("reqPelanggan").value ='';
		  document.getElementById("reqIdPelanggan").value ='';
		}else{
		  var element = document.getElementById("trHiddenPelanggan");
		  element.classList.add("HiddenTr");
		  document.getElementById("reqPelanggan").value ='0';
		  document.getElementById("reqIdPelanggan").value ='0';
		}
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
	function createTextboxArray(paramId,paramName,parCount) {
		var count_project = document.getElementById("reqCountProject").value;	
		
    	var s = '<input type="hidden" id="reqIdTeknisiArray_'+count_project+'" name="reqIdTeknisiArray_'+count_project+'" value="'+paramId+'"><input type="text" id="reqTeknisiArray_'+count_project+'" name="reqTeknisiArray_'+count_project+'" readonly size="35" style="color:#000; margin-top:2px;" value="'+paramName+'"><a href="#" id="removeTextboxArray_'+count_project+'" onclick="removeTextboxArray('+count_project+')"> <img src="../main/images/icon-uncheck.png" width="15" height="15"/><br></a>'; //Create one textbox as HTML
	  	document.getElementById("textProject").innerHTML += s;
		
		count_project = parseInt(count_project) + 1;
		document.getElementById("reqCountProject").value = count_project;
		if(parCount==1){
			document.getElementById("reqJmlPelangganKontrak").value = "All Access";	
			document.getElementById("reqIdPelangganKontrak").value = "0";	
		}else{
			document.getElementById("reqJmlPelangganKontrak").value = count_project +" Project";
		}
		
		array_id_project.push(paramId);
		
		if(val_id_project == "")
			val_id_project = paramId;
		else
			val_id_project +='*'+paramId;
			
		document.getElementById("reqIdPelangganKontrakList").value = val_id_project;
	}
	function removeTextboxArray(ida) {
		var paramId = document.getElementById("reqIdTeknisiArray_"+ida).value;

		index = array_id_project.indexOf(paramId);
		if(index != -1) {
    		array_id_project.splice(index, 1);
		}
		document.getElementById("reqIdTeknisiArray_"+ida).remove();
		document.getElementById("reqTeknisiArray_"+ida).remove();
		document.getElementById("removeTextboxArray_"+ida).remove();
		
		val_id_project = "";
		val_id_project = array_id_project.join("*");
		document.getElementById("reqIdPelangganKontrakList").value = val_id_project;
		
		var count_project = document.getElementById("reqCountProject").value;
		count_project = parseInt(count_project) - 1;
		document.getElementById("reqCountProject").value = count_project;
		if(count_project>0)
			document.getElementById("reqJmlPelangganKontrak").value = count_project +" Project";
		else
			document.getElementById("reqJmlPelangganKontrak").value = "";
	}
    </script>
<link href="../WEB-INF/lib/perfect-scrollbar-master/examples/custom-theme.css" rel="stylesheet">
  <script src="../WEB-INF/lib/perfect-scrollbar-master/dist/js/perfect-scrollbar.js"></script>
  <style>
    .contentHolder { position: relative; margin:0px auto; padding:0px; width: 100%; overflow: hidden; }
	.HiddenTr { display:none; }
  </style> 
<!-- akhir Scroll -->    
</head>
<body class="tinggi">

<div id="begron_data_table"></div>
                 
 	 <div class="container">
    	  <ol class="breadcrumb">
        	<li class="active">
            	  <i class="clip-cog-2"></i>&nbsp;
              	<a href="#"> Setting</a>
          	</li>
          	<li>
              <a href="#"> User Login</a>
          	</li>
            <li class="active">
              <?
				if($reqMode=="insert")
				{
					echo "Tambah";
				}else{
					echo "Ubah";
				}
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
            	<td colspan="3" bgcolor="#FFFF99">User Login</td>
            </tr>
            <tr>
                <td width="30%">Nama Group</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="25" readonly class="easyui-validatebox" id="reqNamaGroup" name="reqNamaGroup" size="25" style="color:#000" required="true" value="<?=$tempNamaGroup?>">
                <? if($tempUserGroupId=="1" || $tempUserGroupId=="2" || $reqMode=="insert"){ ?>
                &nbsp;<a href="#" onClick="OpenDHTML('user_group_lookup.php', '&nbsp;', 400,400);"><img src="../main/images/btn-cari.png" width="15" height="15"> Cari</a> 
                &nbsp;<a href="#" onClick="ResetNamaGroup();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>
            	<? } ?>
            </td>
            </tr>
            <? if($reqPelangganKontrakId==0){ ?>
				  <? if($tempUserGroupId==3){ ?>            
                  <tr>
                      <td width="30%" valign="top">Project</td>
                      <td width="1%" valign="top">:</td>
                      <td><input type="hidden" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" value="<?=$tempPelangganKontrak?>">
                      <input type="text" class="easyui-validatebox" id="reqJmlPelangganKontrak" readonly name="reqJmlPelangganKontrak" size="18" style="color:#000" required="true" value="<?=$tempJmlPelangganKontrak?>">
                      &nbsp;<a href="#" onClick="OpenPelangganKontrakArray();"><img src="../main/images/btn-tambah.png" width="15" height="15"> Add Project</a> 
                      <!--&nbsp;<a href="#" onClick="ResetPelangganKontrak();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>-->
                      <div id="textProject" style="margin-top:5px"></div>
                      <input type="hidden" id="reqCountProject" name="reqCountProject" value="0">
                      <input type="hidden" id="reqIdPelangganKontrakList" name="reqIdPelangganKontrakList">
                      </td>
                  </tr>
                  <? }else{ ?>
                  <tr>
                      <td width="30%">Project</td>
                      <td width="1%">:</td>
                      <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" required="true" value="<?=$tempPelangganKontrak?>">
                      &nbsp;<a href="#" onClick="OpenDHTML('../setting/pelanggan_kontrak_lookup.php?reqDevice=<?=$reqDevice?>', 'Monitoring Tiket', 575, 435);"><img src="../main/images/btn-cari.png" width="15" height="15"> Cari</a> 
                      &nbsp;<a href="#" onClick="ResetPelangganKontrak();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>
                      </td>
                  </tr>
                  <? } ?>
            <? }else{ ?>
            <tr>
                <td width="30%">Project</td>
                <td width="1%">:</td>
                <td><?=$tempPelangganKontrak?>
                <input type="hidden" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" required="true" value="<?=$tempPelangganKontrak?>">
                </td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%">Nama</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqNama" name="reqNama" size="60" style="color:#000" required="true" value="<?=$tempNama?>"></td>
            </tr>
            <tr>
                <td width="30%">Telepon</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="15" class="easyui-validatebox" id="reqNoHp" name="reqNoHp" size="18" style="color:#000" required="true" value="<?=$tempNoHp?>" onKeyUp="CekNumber('reqNoHp');" OnFocus="FormatAngka('reqNoHp')" OnBlur="CekNumber('reqNoHp')"></td>
			</td>
            <tr>
                <td width="30%">Email</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="50" class="easyui-validatebox" id="reqEmail" name="reqEmail" data-options="required:true,validType:'email'" size="28" style="color:#000" value="<?=$tempEmail?>">
                <label id="erroremail" style="color: red;"></label>
                </td>
			</td>
            <tr>
                <td width="30%">Alamat</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="225" class="easyui-validatebox" id="reqAlamat" name="reqAlamat" size="60" style="color:#000" required="true" value="<?=$tempAlamat?>"></td>
			</td>
            </tr>
            <tr>
                <td width="30%">Username</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqUserNama" name="reqUserNama" size="25" style="color:#000" required="true" value="<?=$tempUserNama?>"></td>
			</td>
            </tr>
            <?php  if($reqMode=="insert"){ ?>
            <tr>
                <td width="30%">Password</td>
                <td width="1%">:</td>
                <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqPassword" name="reqPassword" size="18" style="color:#000" required="true" value="<?=$tempPassword?>"></td>
			</td>
            </tr>
            <? } ?>
            </table>
               
        <div style="display:none">
        <input type="text" name="reqUserGroupId" value="<?=$tempUserGroupId?>" id="reqUserGroupId">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
		<input type="text" id="reqIdPelangganKontrak" name="reqIdPelangganKontrak" value="<?=$tempIdPelanggan?>">         
        <input type="text" id="reqIdTeknisi" name="reqIdTeknisi" value="<?=$tempIdTeknisi?>">   
       <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       </div>
    </form>
    
    <? }else{ ?>
     <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table class="datatable form-mobile" width="90%" align="center">
            <tr>
            	<td colspan="3" bgcolor="#FFFF99">User Login</td>
            </tr>
            <tr>
                <td width="30%">Nama Group :</td>
            </tr><tr>
                <td><input type="text" readonly maxlength="25" class="easyui-validatebox" id="reqNamaGroup" name="reqNamaGroup" size="25" style="color:#000" required="true" value="<?=$tempNamaGroup?>">
                <? if($tempUserGroupId=="1" || $tempUserGroupId=="2" || $reqMode=="insert"){ ?>
                
                  &nbsp;<a href="#" onClick="OpenDHTML('user_group_lookup3.php', '&nbsp;', 400,400);"><img src="../main/images/btn-cari.png" width="15" height="15"> Cari</a> 
                  &nbsp;<a href="#" onClick="ResetNamaGroup();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a></td>
            	
				<? } ?>
			</tr>
            <? if($reqPelangganKontrakId==0){ ?>
            	<? if($tempUserGroupId==3){ ?>            
                  	<tr>
                      <td width="30%" valign="top">Project :</td>
                      </tr><tr>
                      <td><input type="hidden" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" value="<?=$tempPelangganKontrak?>">
                      <input type="text" class="easyui-validatebox" id="reqJmlPelangganKontrak" readonly name="reqJmlPelangganKontrak" size="18" style="color:#000" required="true" value="<?=$tempJmlPelangganKontrak?>">
                      &nbsp;<a href="#" onClick="OpenPelangganKontrakArray();"><img src="../main/images/btn-tambah.png" width="15" height="15"> Add Project</a> 
                      <!--&nbsp;<a href="#" onClick="ResetPelangganKontrak();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>-->
                      <div id="textProject" style="margin-top:5px"></div>
                      <input type="hidden" id="reqCountProject" name="reqCountProject" value="0">
                      <input type="hidden" id="reqIdPelangganKontrakList" name="reqIdPelangganKontrakList">
                      </td>
                  	</tr>
                <? }else{ ?>
                  	<tr>
                      <td width="30%">Project :</td>
                      </tr><tr>
                      <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" required="true" value="<?=$tempPelangganKontrak?>">
                      &nbsp;<a href="#" onClick="OpenDHTML('../setting/pelanggan_kontrak_lookup.php?reqDevice=<?=$reqDevice?>', 'Monitoring Tiket', 575, 435);"><img src="../main/images/btn-cari.png" width="15" height="15"> Cari</a> 
                      &nbsp;<a href="#" onClick="ResetPelangganKontrak();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>
                      </td>
                  </tr>
    	        <? } ?>
            <? }else{ ?>
            <tr>
                <td width="30%">Project :</td>
                </tr><tr>
                <td><?=$tempPelangganKontrak?>
                <input type="hidden" maxlength="25" class="easyui-validatebox" id="reqPelangganKontrak" readonly name="reqPelangganKontrak" size="25" style="color:#000" required="true" value="<?=$tempPelangganKontrak?>">
                </td>
            </tr>
            <? } ?>
            <tr>
                <td width="30%">Nama :</td>
            </tr><tr>
                <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqNama" name="reqNama" size="60" style="color:#000" required="true" value="<?=$tempNama?>"></td>
            </tr>
            <tr>
                <td width="30%">Telepon :</td>
            </tr><tr>
                <td><input type="text" maxlength="15" class="easyui-validatebox" id="reqNoHp" name="reqNoHp" size="18" style="color:#000" required="true" value="<?=$tempNoHp?>" onKeyUp="CekNumber('reqNoHp');" OnFocus="FormatAngka('reqNoHp')" OnBlur="CekNumber('reqNoHp')"></td>
			</td>
            <tr>
                <td width="30%">Email :</td>
            </tr><tr>
                <td><input type="text" maxlength="50" class="easyui-validatebox" id="reqEmail" name="reqEmail" data-options="required:true,validType:'email'" size="28" style="color:#000" value="<?=$tempEmail?>">
                <label id="erroremail" style="color: red;"></label>
                </td>
			</td>
            <tr>
                <td width="30%">Alamat :</td>
           </tr><tr>
                <td><input type="text" maxlength="225" class="easyui-validatebox" id="reqAlamat" name="reqAlamat" size="60" style="color:#000" required="true" value="<?=$tempAlamat?>"></td>
			</td>
            </tr>
            <tr>
                <td width="30%">Username :</td>
            </tr><tr>
                <td><input type="text" maxlength="25" class="easyui-validatebox" id="reqUserNama" name="reqUserNama" size="25" style="color:#000" required="true" value="<?=$tempUserNama?>"></td>
			</td>
            </tr>
            <?php  if($reqMode=="insert"){ ?>
            <tr>
                <td width="30%">Password :</td>
            </tr><tr>
                <td><input type="text" maxlength="15" class="easyui-validatebox" id="reqPassword" name="reqPassword" size="18" style="color:#000" required="true" value="<?=$tempPassword?>"></td>
			</td>
            </tr>
            <? } ?>
            </table>
              <div style="display:none">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
        <input type="text" id="reqIdPelangganKontrak" name="reqIdPelangganKontrak" value="<?=$tempIdPelanggan?>">
		<input type="text" id="reqIdTeknisi" name="reqIdTeknisi" value="<?=$tempIdTeknisi?>">         
	   <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       </div>
    </form>
            <? } ?>
    </div> 
</div>
<script type="text/javascript">
<?
if($reqMode=="update" && $tempUserGroupId=="3")
{
	if($user_project->firstRow())
	{
			?>
			createTextboxArray('<?=$user_project->getField("PELANGGAN_KONTRAK_ID")?>','<?=$user_project->getField("NAMA")?>','<?=$tempAllKontrak?>'); 
			<?
			$tempAllKontrak = $tempAllKontrak - 1;
		
		while($user_project->nextRow())
		{
			?>
			createTextboxArray('<?=$user_project->getField("PELANGGAN_KONTRAK_ID")?>','<?=$user_project->getField("NAMA")?>','<?=$tempAllKontrak?>'); 
			<?
			$tempAllKontrak = $tempAllKontrak - 1;
		}
	}
}
?>
</script>
<script>
  var scrollvar = document.querySelector.bind(document);
  var container_scroll = scrollvar('#container_scroll');
  window.onload = function () {
    Ps.initialize(container_scroll, { theme: 'square' });
  };
</script>

</body>
</html>