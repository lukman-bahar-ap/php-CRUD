<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$user_login_base = new UserLoginBase();

$reqDevice = httpFilterGet("reqDevice");
	$user_login_base->selectByParams(array("USER_LOGIN_ID" => $userLogin->UID));
	$user_login_base->firstRow();
	
	$tempUserGroupId	= $user_login_base->getField("USER_GROUP_ID");
	$tempUserNama		= $user_login_base->getField("USER_NAMA");
	$tempNamaPegawai	= $user_login_base->getField("NAMA");
	$tempNamaGroup		= $user_login_base->getField("STATUS");
	$reqId				= $userLogin->UID;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-ksp.png">
<title>SIABAS - Sistem Aplikasi Absensi</title>
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
					if(data[2]=='gagal')
					{
						ResetInputType();
					}
					else
					{
					  window.top.displayUrlFromIframeChild('../setting/ubah_password.php');
					  window.parent.divwin.close();	
					}
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
    function ResetInputType() {
        document.getElementById('reqUserPassword').value = '';
        document.getElementById('reqUserPasswordReType').value = '';
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
              Ubah Password
          	</li>
      	</ol>
  	</div>
  <div class="panel-heading">
    <i class="fa fa-external-link-square"></i>
        <a href="#" onClick="$('#btnSubmit').click();"><img src="../main/images/btn-simpan.png" width="15" height="15"/> Simpan</a>
   </div>    
   <div class="col-md-6" style="margin-top:20px; margin-left:30px">
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
        <div class="form-group">
         <label class="control-label">
              Username :
          </label>
         <input name="reqUserNama" readonly class="easyui-validatebox form-control" required="true" title="Username harus diisi" size="30" id="reqUserNama" type="text" value="<?=$tempUserNama?>" />

        </div>
        <div class="form-group">
         <label class="control-label">
              Password :
          </label>
		<input name="reqUserPassword" id="reqUserPassword" class="easyui-validatebox form-control" required="true" size="18" maxlength="15" type="text"  />
		 </div>
         <div class="form-group">
         <label class="control-label">
             Ketik Ulang Password :
          </label>
		<input name="reqUserPasswordReType" id="reqUserPasswordReType" class="easyui-validatebox form-control" required="true" size="18" maxlength="15" type="text"  />
		 </div>

        <div style="display:none">
		<input type="text" id="reqMode" name="reqMode" value="ubah_password">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
	   <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
       <input type="reset" id="rst_form"> 
       </div>
    </form>
    </div> 

</body>
</html>