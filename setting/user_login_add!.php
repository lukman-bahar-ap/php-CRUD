<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/base/Resto.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$user_login_base = new UserLoginBase();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqDevice = httpFilterGet("reqDevice");

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
	$tempNamaPegawai	= $user_login_base->getField("NAMA_PEGAWAI");
	$tempNamaGroup		= $user_login_base->getField("NAMA_GROUP");
	$tempUserPassAsli	= $user_login_base->getField("USER_PASS_ASLI");
	$tempRestoId		= $user_login_base->getField("RESTO_ID");
	
	
	$resto = new Resto();
	$resto->selectByParams(array("RESTO_ID" => $tempRestoId));
	$resto->firstRow();
	$tempNamaResto	= $resto->getField("NAMA_RESTO");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-ksp.png">
<title>SIABAS - Sistem Aplikasi Menu Restoran</title>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../main/css/admin.css" rel="stylesheet" type="text/css">
<link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">


        <!--scrol-->
        <link rel="stylesheet" href="../WEB-INF/lib/JqueryScrollbar/includes/style.css">
        <link rel="stylesheet" href="../WEB-INF/lib/JqueryScrollbar/includes/prettify/prettify.css">
        <link rel="stylesheet" href="../WEB-INF/lib/JqueryScrollbar/jquery.scrollbar.css">

        <script type="text/javascript" src="../WEB-INF/lib/JqueryScrollbar/includes/prettify/prettify.js"></script>
        <script type="text/javascript" src="../WEB-INF/lib/JqueryScrollbar/includes/jquery.js"></script>
        <script type="text/javascript" src="../WEB-INF/lib/JqueryScrollbar/jquery.scrollbar.js"></script>
		<!-- End scrol-->


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
    <script type="text/javascript" src="js/globalfunction.js"></script>
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
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
        var left = 50;
        
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=25,resize=1,scrolling=1,midle=1'); return false;
    }
    </script>
	<script type="text/javascript">
    function ResetNamaPegawai() {
        document.getElementById('reqNamaPegawai').value = '';
        document.getElementById('reqPegawaiId').value = '';
        document.getElementById('reqSatkerId').value = '';
		document.getElementById('reqSatkerSubId').value = '';
    }	
    </script>            
</head>
<body>                 
 	 <div class="container">
    	  <ol class="breadcrumb">
        	<li>
            	  <i class="clip-cog-2"></i>&nbsp;
              	<a href="#"> Setting</a>
          	</li>
          	<li class="active">
              User Login
          	</li>
            <li>
              <?=$reqMode;?>
          	</li>
      	</ol>
  	</div>
  <div class="panel-heading">
    <i class="fa fa-external-link-square"></i>
        <a href="#" onClick="$('#btnSubmit').click();"><img src="../main/images/btn-simpan.png" width="15" height="15"/> Simpan</a>
        &nbsp;&nbsp;&nbsp;
        <a href="#" onClick="window.parent.divwin.close();" title="Tutup"><img src="../main/images/btn-batal.png" width="15" height="15"/> Tutup</a>
   </div>    


<div class="wrapperScroll scrollbar-dynamic">   
   <div class="col-md-6" style="margin-top:20px">
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
         <div class="form-group">
            <label class="control-label">
                Nama Group :
            </label>
            <div class="input-group">
                <input name="reqNamaGroup" readonly class="easyui-validatebox form-control" required="true" title="Nama Group harus diisi" size="65" id="reqNamaGroup" type="text" value="<?=$tempNamaGroup?>" />
                <input type="hidden" name="reqUserGroupId" value="<?=$tempUserGroupId?>" id="reqUserGroupId">
                &nbsp;<a href="#" onClick="OpenDHTML('user_group_lookup3.php', '&nbsp;', 700,515);"><img src="../main/images/cari.png" width="15" height="15"> Cari</a> 
                &nbsp;<a href="#" onClick="ResetNamaGroup();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">
                Nama Resto :
            </label>
            <div class="input-group">
                <input name="reqNamaGroup" readonly class="easyui-validatebox form-control" required="true" title="Nama Resto harus diisi" size="65" id="reqNamaResto" type="text" value="<?=$tempNamaResto?>" />
                <input type="hidden" name="reqRestoId" value="<?=$tempRestoId?>" id="reqRestoId">
                &nbsp;<a href="#" onClick="OpenDHTML('resto_lookup.php', '&nbsp;', 400,450);"><img src="../main/images/cari.png" width="15" height="15"> Cari</a> 
                &nbsp;<a href="#" onClick="ResetNamaGroup();"><img src="../main/images/btn-reload.png" width="15" height="15"> Reset</a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">
                Nama Lengkap :
            </label>
            <input type="text" class="easyui-validatebox form-control" value="<?=$tempNamaPegawai?>" id="reqNamaPegawai" name="reqNamaPegawai" required="true"/>            
        </div>
        <div class="form-group">
         <label class="control-label">
              Username :
          </label>
         <input name="reqUserNama" class="easyui-validatebox form-control" required="true" title="Username harus diisi" size="30" id="reqUserNama" type="text" value="<?=$tempUserNama?>" />

        </div>
        <div class="form-group">
         <label class="control-label">
              Password :
          </label>
		<input name="reqUserPassword" id="reqUserPassword" class="easyui-validatebox form-control" required="true" size="30" type="text"  />
		 </div>
        <div class="form-group">
          <label class="control-label">
              View Password :
          </label>
		<input name="reqUserPassAsli" id="reqUserPassAsli" class="easyui-validatebox form-control" size="30" type="text" readonly value="<?=$tempUserPassAsli?>"  />
        </div>
        <div style="display:none">
		<input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
	   <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       <input type="reset" id="rst_form"> 
       </div>
    </form>
    </div> 
</div>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                window.prettyPrint && prettyPrint();
                $('.wrapperScroll').scrollbar();
            });
        </script>

</body>
</html>