<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: index.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: page of interface for login form and consist authentication process
***************************************************************************************************** */

/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
/*include_once("../WEB-INF/classes/utils/LogCounter.php");*/

/* PARAMETERS */
$reqMode 		= httpFilterRequest("reqMode");
$reqUsername 	= httpFilterPost("reqUsername");
$reqPassword 	= httpFilterPost("reqPassword");

if ($reqMode == "submitLogin" && $reqUsername != "" && $reqPassword != "") 
{
	$userLogin->resetLogin();
	if ($userLogin->verifyUserLogin($reqUsername, $reqPassword)) 
	{
		$userLogin->startSession();
		$userLogin->sessionLogOnline(1);
		$_SESSION['logged_in']="1";
		header("location:index.php");
		exit;
	}
	/*else
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid username or password.");';
		echo 'top.location.href = "login.php";';
		echo '</script>';		
		exit;		
	}*/
}
else if ($reqMode == "submitLogout")
{
	/*$log->writeLoginLog($userLogin, 'logout');*/
	//$userLogin->startSession();
	$userLogin->sessionLogOnline(0);
	
	$userLogin->resetLogin();
	$userLogin->emptyUsrSessions();
	//$userLogin->backHistory();
	//header("Location:login.php");
	
	unset($_SESSION['logged_in']);  
	$userLogin->destroySession();
    //session_destroy(); 
	 
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");
	//header("Location:login.php");
	/*echo '<script language="javascript">';
	echo 'top.location.href = "login.php";';
	echo '</script>';*/		
	//exit;	
}
else
	$userLogin->resetLogin();
?>
<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
        <link rel="shortcut icon" href="assets/images/logo-sibagus.png">
        <title>Login - Dokterku</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/fonts/style.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/main-responsive.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        
        <link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">   
        <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
        
		<script type="text/javascript" src="../main/js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
        <?php 
        if ($reqMode == "submitLogout")
		{
		?>
      <!-- <script language="javascript"> 
		{
  		var len=history.length;   
  		history.go(-len); 
  		window.location.href= "login.php"
 		}
		</script>
        
        <script type="text/javascript">
        window.history.forward();
        function noBack()
        {
            window.history.forward();
        }
		onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload=""-->
        
        <?php } ?>
        
	</SCRIPT>
       <script type="text/javascript">
		function noBack(){window.history.forward();}
		noBack();
		window.onload=noBack;
		window.onpageshow=function(evt){if(evt.persisted)noBack();}
		window.onunload=function(){void(0);}
		</script>
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login example2" >
		<div class="main-login col-sm-4 col-sm-offset-4">
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<div class="logo"><a href="../../main/index.php"><img src="assets/images/logo-login.png"></a> </div>
                <p style="text-align:center; font-weight:600; font-size:11px;">
                Dokterku</p><br>
				<p align="center">Please Login with your Credential</p>
                
    <form method="post" novalidate enctype="multipart/form-data">
    <table border="0" class=datatablelogin width="80%" align="center">
        <tr>
            <td width="15%">Username</td>
            <td width="1%">:</td>
            <td>
                <input name="reqUsername" class="easyui-validatebox" required="true" size="35" id="reqUsername" type="text"/>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>        
            <td>
                <input name="reqPassword" class="easyui-validatebox" required="true" size="35" id="reqPassword" type="password"/>
            </td>
        </tr>
        <tr>
        	<td colspan="3">
                <div class="form-actions">
                    <button type="submit" class="btn btn-bricky pull-right">
                        Login <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>  
                <!--<a href="../reg/it.php"> >>Registrasi IT</a>-->          
            </td>
        </tr>        
    </table>

    <div class="new-account" align="center">
        Copyright © Lukman BAP 2021. All Rights Reserved.
    </div>    
    <div style="display:none;">
    	<span><input type="hidden" name="reqMode" value="submitLogin"></span>
    </div>            
    </form>                

			</div>
			<!-- end: LOGIN BOX -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="assets/plugins/jQuery-lib/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="assets/plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
		<!--<![endif]-->
		<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="assets/plugins/less/less-1.5.0.min.js"></script>
		<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
		<script src="assets/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/js/login.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
	function registerServiceWorker () {
      navigator.serviceWorker.register('../service-worker.js')
        .then(()=> {
          console.log('Registrasi service worker berhasil.');
        }).catch((err)=> {
          console.error('Registrasi service worker gagal.', err);
        });
    }
	// Periksa service worker
    if (!('serviceWorker' in navigator)) {
      console.log("Service worker tidak didukung browser ini.");
    } else {
      registerServiceWorker();
    }
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>