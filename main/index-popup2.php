<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
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
		<link rel="shortcut icon" href="assets/images/logo-ksp.png">
        <title>Sistem Aplikasi Koperasi</title>
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
        </style>  

<script type="text/javascript">
$(document).ready(function(){
	var ScreenX = $(window).width(), ScreenY = $(window).height();	
	
	var cssFrame = document.getElementById("the_iframe");
	var cssFrameDiv = document.getElementById("the_div_iframe");
	var TingginavHeader = 0;
	var TingginavTool = 50;
	var TingginavFooter = 6;
	
		ScreenYfrme = ScreenY - 4; 
	if(ScreenX<=767){ 
		ScreenYfrme = ScreenY - TingginavHeader - TingginavTool - TingginavFooter; 
	}
	 cssFrame.style.height = ScreenYfrme + "px";
	 cssFrameDiv.style.height = ScreenYfrme + "px";
	 	 //cssFrame.style.height = "800px";

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
    <script type="text/javascript">
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight, TopScreen)
    {
		/*lukman*/
        var left = (screen.width/2)-(opWidth/2);
		var ScreenX = $(window).width(), ScreenY = $(window).height();
		/*var TopScreen = 10;*/
		
		if(!TopScreen){ var TopScreen = 50;}
		if(ScreenX<=1024){ var TopScreen = 0; var left = 0;}
        
divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top='+TopScreen+',resize=1,scrolling=1,midle=1'); return false;
    }
    
    function displayUrlFromIframeChild(link_url)
    {
        document.getElementById("the_iframe").src=link_url;
    }
    </script>

	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
    
	<body>
		<!-- start: HEADER -->
		<div class="navbar-popup navbar-inverse navbar-fixed-top" style="z-index:99;">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header" style="border-bottom: 1px solid #C8C7CC;">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<!-- end: LOGO -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
		<div class="main-container-popup">
        
			<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse navigation-configuretop" style="z-index:99">
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu">
						<li>
							<a href="index.html"><i class="clip-home-3"></i>
								<span class="title"> Dashboard </span><span class="selected"></span>
							</a>
						</li>
						<li style="border-bottom: 1px solid #DDDDDD;">
							<a href="javascript:void(0)"><i class="clip-screen"></i>
								<span class="title"> Master Data </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                                <li>
									<a href="../master-data/karyawan-popup.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<i class="clip-user-5"></i><span class="title" style="margin-left:4px"> Data Karyawan </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<i class="clip-users-2"></i><span class="title" style="margin-left:4px"> Data Anggota </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<i class="clip-cube"></i><span class="title" style="margin-left:4px"> Data Inventaris </span>
									</a>
								</li>
							</ul>
						</li>
                        <!--<li>
							<a href="javascript:void(0)"><i class="clip-screen"></i>
								<span class="title"> Master Data </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                                <li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-employee.png"><span class="title"> Data Karyawan </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-anggota.png"><span class="title"> Data Anggota </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-invent.png"><span class="title"> Data Inventaris </span>
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="../../frontend/clip-one/index.html" target="_blank"><i class="clip-cursor"></i>
								<span class="title"> Frontend Theme </span><span class="selected"></span>
							</a>
						</li>
                        <li>
							<a href="javascript:void(0)"><i class="clip-screen"></i>
								<span class="title"> Master Data </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                                <li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-employee.png"><span class="title"> Data Karyawan </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-anggota.png"><span class="title"> Data Anggota </span>
									</a>
								</li>
								<li>
									<a href="../master-data/karyawan.php" target="frameUtama" data-target=".navbar-collapse" data-toggle="collapse">
										<img src="images/icon-submenu-invent.png"><span class="title"> Data Inventaris </span>
									</a>
								</li>
							</ul>
						</li>-->

					</ul>
					<!-- end: MAIN NAVIGATION MENU -->
				</div>
				<!-- end: SIDEBAR -->
			</div>
			<!-- start: PAGE -->
			<div class="main-content">
				<!-- start: PANEL CONFIGURATION MODAL FORM -->
				<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Panel Configuration</h4>
							</div>
							<div class="modal-body">
								Here will be a configuration form
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary">
									Save changes
								</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<!--<div class="container">-->
                <div id="the_div_iframe" style="width:100%; border: 1px solid #DDDDDD; padding-bottom:0; margin-bottom:0;">
<iframe class="ifrm-main" id="the_iframe" name="frameUtama" scrolling="no" src="home-main.php" style="padding:0; margin:0;"></iframe>
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
<!--		<div class="footer clearfix">
			<div class="footer-inner">
				2017 &copy; Sistem Aplikasi Koperasi by trescode.net
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
-->		<!-- end: FOOTER -->

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
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>