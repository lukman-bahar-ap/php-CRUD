<?php
session_start();
if(isset($_SESSION["ssUsr_idUser"])){

 include_once("../WEB-INF/classes/base/UsersBase.php");
$user_base =  new UsersBase();
	$user_base->selectById($_SESSION["ssUsr_idUser"]);
	if($user_base->firstRow()){
		if($user_base->getField("LOG_ONLINE")==0){
			header("Location: login.php"); exit;
		}
	}else{
		header("Location: login.php"); exit;
	}
	
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");


// if(!isset($_SESSION['logged_in'])){ header("Location: login.php"); exit;   }
	
	
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
	$status=$userLogin->unitUpj;
	
	$reqPelangganKontrakId  =$userLogin->userPelangganKontrakId;
	$reqUserAllAkses		=$userLogin->userAllAkses;



?>
<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<link rel="shortcut icon" href="assets/images/logo-sibagus.png">
        <title><?=titleWeb()?></title>
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
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
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
        <script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
    
		<style type="text/css">  
          .ifrm-main {
            width:100%;
            border:none;
            overflow-x:hidden;
            position:relative; right:0px; left:0px;  top:0px; bottom:0px;
          }
		/*current*/
		  #menulight1 li a.current {
			  	color: #000000 !important;
				background: #D9D9D9 !important;
		  }
		  .TopMenuHeader {
				z-index:99 !important
			}
		  @media (max-width: 768px) {
		  	.TopMenuHeader {
				z-index:999 !important
			}
		  }
		  
		  @media screen and (min-width:767px) {
			.form-desktop {
	  
			}  
			.form-mobile {
			  display:none;
			}
		  }
		  
		  @media screen and (max-width:767px) {
			.form-desktop {
			  display:none;
			}
			.form-mobile {
	  
			}
		  }		  		  
        </style>  

<script type="text/javascript">
$(document).ready(function(){
	var ScreenX = $(window).width(), ScreenY = $(window).height();	
	
	var cssFrame = document.getElementById("the_iframe");
	var TingginavHeader = 51;
	var TingginavTool = 50;
	var TingginavFooter = 41;
	
		ScreenYfrme = ScreenY - TingginavTool - TingginavFooter; 
	if(ScreenX<=767){ 
		ScreenYfrme = ScreenY - TingginavHeader - TingginavTool - TingginavFooter; 
	}
	 cssFrame.style.height = ScreenYfrme + "px";
	//alert(ScreenY+'d');
	
	//aktive sub menu
	$('.sub-menu').on('click', 'li', function(e) {
		//$('.main-navigation-menu li.active').find('.sub-menu').slideUp();
		if($(this).parents('li').eq(0).hasClass('active')==false){
		$('.main-navigation-menu li.active').find('.sub-menu').hide(); //hide tanpa animas kalo slideup pake animasi
		}
		
		$('.sub-menu li.active').removeClass('active');
		$('.main-navigation-menu li.active').removeClass('active');
	    $(this).addClass('active');
		$(this).parents('li').eq(0).addClass('active');
	});
	 
	 
});

</script>

    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/font-muli.css" type="text/css">
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow2.js"></script>
    <script type="text/javascript">
	
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight, TopScreen)
    {
		/*lukman*/
        var left = (screen.width/2)-(opWidth/2);
		var ScreenX = $(window).width(), ScreenY = $(window).height();
		/*var TopScreen = 10;*/
		
		if(!TopScreen){ var TopScreen = 50;}
		if(ScreenX<=1024){ var TopScreen = 98; var left = 0;}
        
		divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top='+TopScreen+',resize=1,scrolling=0,midle=1'); return false;
    }
	 function OpenDHTML2(opAddress, opCaption, opWidth, opHeight, TopScreen)
    {
        var left = (screen.width/2)-(opWidth/2);
		var ScreenX = $(window).width(), ScreenY = $(window).height();
		
		if(!TopScreen){ var TopScreen = 50;}
		divwin2=dhtmlwindow2.open('divbox2', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top='+TopScreen+',resize=1,scrolling=0,midle=1'); return false;
    }
	
    function displayUrlFromIframeChild(link_url)
    {
        document.getElementById("the_iframe").src=link_url;
    }	
	function displayNotifMonitoring(val)
    {
		if(val>0){
        	document.getElementById('SpanNotifikasi').innerHTML = val;
			document.getElementById('SpanNotifikasi2').innerHTML = "!";
		}else{
			document.getElementById('SpanNotifikasi').innerHTML = "";
			document.getElementById('SpanNotifikasi2').innerHTML = "";
		}
    }	
    </script>
       
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
    
	<body class="footer-fixed">
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top TopMenuHeader">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
 					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button" onClick="window.parent.divwin.close();">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->                   
                    
					<!-- start: LOGO -->
					<a class="navbar-brand" href="home-main.php">
						<p><b>Dokterku</b><br>Aplikasi Pencatatan Riwayat Passien</p> 
					</a>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
					<ul class="nav navbar-right">
						<!-- start: USER DROPDOWN -->
						<li class="dropdown current-user">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<img src="assets/images/icn-administrator.png" height="30px" width="30px" class="circle-img" alt="">
								<span class="username">&nbsp;<?=$userLogin->nama?> - <?=$status?> </span>
								<i class="clip-chevron-down"></i>
							</a>
                           
							<ul class="dropdown-menu">
								<li>
									<a href="#">
										<i class="clip-user-2"></i>
										&nbsp;My Profile
									</a>
								</li>
                                <li>
									<a href="https://play.google.com/store/apps/details?id=com.deagroup.dgitonsite" target="_new">
										<i class="clip-user-2"></i>
										&nbsp;Download Apk
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="#" onClick="parent.frames['frameUtama'].location.href='../help/work_intruction.php'; window.parent.divwin.close();">
										<i class="clip-book"></i>
										&nbsp;Help
									</a>
								</li>
                                <li>
									<a href="login.php?reqMode=submitLogout" target="_parent"> 
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>

						</li>
						<!-- end: USER DROPDOWN -->
					</ul>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
                
				<!-- start: HORIZONTAL MENU -->
				<div class="horizontal-menu">
					<ul class="form-desktop nav navbar-nav">
						<li class="active">
							<a href="#" onClick="parent.frames['frameUtama'].location.href='home-main.php'; window.parent.divwin.close();"><i class="clip-home-3"></i>&nbsp;Home</a>
						</li>				
                        <li main-navigation-menu>
							<a href="#" onClick="parent.frames['frameUtama'].location.href='../master-data/pasien.php'; window.parent.divwin.close();" class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown">
								<i class="clip-data"></i>&nbsp;Data Pasien&nbsp;&nbsp;
							</a>                      
						</li>				
                        <li main-navigation-menu>
							<a href="javascript:void(0)" class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown">
								<i class="clip-cog-2"></i>&nbsp;Setting&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
                                <li class="dropdown">
                                    <a href="#" onClick="parent.frames['frameUtama'].location.href='../setting/ubah_password.php?reqDevice=1'; window.parent.divwin.close();">Ubah Password</a>
								</li>
                                <? 	
								if($userLogin->userGroupId == "1")
                            	{
								?>
                                <li class="dropdown">
                                    <a href="#" onClick="parent.frames['frameUtama'].location.href='../setting/user_login.php?reqDevice=1'; window.parent.divwin.close();">User Login</a>
								</li>
                                <? } ?>
							</ul>                            
						</li>
					</ul>
				</div>
				<!-- end: HORIZONTAL MENU -->

                
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->
        

			<div class="navbar-content form-mobile">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse" style="z-index:99;" >
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu panel-scroll">
						<li>
							<a href="#" onClick="parent.frames['frameUtama'].location.href='home-main.php'; window.parent.divwin.close();" data-target=".navbar-collapse" data-toggle="collapse"><i class="clip-home-3"></i><span class="title">&nbsp;Beranda</span><span class="selected"></span></a>
						</li>                     
						<li>
							<a href="#" onClick="parent.frames['frameUtama'].location.href='../master-data/pasien.php?reqDevice=2'; window.parent.divwin.close();" data-target=".navbar-collapse" data-toggle="collapse">
                            	<i class="fa fa-columns"></i><span class="title">&nbsp;Data Pasien</span>
								<span class="selected"></span>
							</a>             
                        <li>
							<a href="javascript:void(0)">
                            	<i class="clip-cog-2"></i><span class="title">&nbsp;Setting</span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                                <li class="dropdown">
                                    <a href="#" onClick="parent.frames['frameUtama'].location.href='../setting/ubah_password.php?reqDevice=2'; window.parent.divwin.close();" data-target=".navbar-collapse" data-toggle="collapse">Ubah Password</a>
								</li>
							 	<?
                                if($userLogin->userGroupId == "1")
                                {
                            	?>
                                <li class="dropdown">
                                    <a href="#" onClick="parent.frames['frameUtama'].location.href='../setting/user_login.php?reqDevice=2'; window.parent.divwin.close();" data-target=".navbar-collapse" data-toggle="collapse">User Login</a>
								</li>
                                <? } ?>
							</ul>                            
						</li>
					</ul>
					<!-- end: MAIN NAVIGATION MENU -->
				</div>
				<!-- end: SIDEBAR -->
			</div>
        
        
        
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<!-- start: PAGE -->
			<div class="main-content">

				<!--<div class="container">-->
                <div style="width:100%;">
<iframe class="ifrm-main" id="the_iframe" name="frameUtama" scrolling="no" src="home-main.php"></iframe>
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<div class="footer-inner">
				2021 &copy; Dokterku by Lukman BAP
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<!-- end: FOOTER -->

		<!-- start: MAIN JAVASCRIPTS -->
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
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>

	</body>
	<!-- end: BODY -->
</html>


<?php 
}else{
header("Location:login.php");	
}

}else{
header("Location:login.php");	
}
?>