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

$tinggi = 222;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="assets/images/logo-ksp.png">
<title>SIMERO - Sistem Aplikasi Menu Restoran</title>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../main/css/admin.css" rel="stylesheet" type="text/css">
<link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">

<style type="text/css" media="screen">
    @import "../WEB-INF/lib/media/css/demo_page.css";
    @import "../WEB-INF/lib/media/css/demo_table.css";
    @import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";
    /*
     * Override styles needed due to the mix of three different CSS sources! For proper examples
     * please see the themes example in the 'Examples' section of this site
     */
    .dataTables_info { padding-top: 0; }
    .dataTables_paginate { padding-top: 0; }
    .css_right { float: right; }
    #example_wrapper .fg-toolbar { font-size: 0.7em }
    #theme_links span { float: left; padding: 2px 10px; }
	.rightCol{text-align: right;}
	.warnaAbsenKosong{background-color: #ff00c6;}
	
	/*@media screen and (max-width:767px) {
  	.ui-helper-clearfix:after { content: "."; display: block; height: 45px; clear: both; visibility: hidden; }
	}*/
</style>

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/extensions/Responsive/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">

<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/konfirmasi-dialog.js"></script>
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/Responsive/js/dataTables.responsive.js"></script>
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/Scroller/js/dataTables.scroller.min.js"></script>	
<script type="text/javascript" language="javascript" class="init">
	function trim(str)
	{
		if(!str || typeof str != 'string')
			return null;
	
		return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

    $(document).ready( function () {
		var ScreenX = $(window).width();
		if(ScreenX<=767)
		{
			varColumnDefs = [{ className: 'never', targets: [0] }, { className: 'none', targets: [0] }]
			varTinggi = 174;
		}
		else
		{
			varColumnDefs = [{ className: 'never', targets: [0] }, { className: 'none', targets: [0] }]
			varTinggi = 222;
		}
		
        var id = -1;//simulation of id
		$(window).resize(function() {
		  console.log($(window).height());
		  $('.dataTables_scrollBody').css('height', ($(window).height() - varTinggi));
		});
		
        var oTable = $('#example').dataTable({ "iDisplayLength": 50, bJQueryUI: true,
		/* UNTUK MENGHIDE KOLOM ID */
		"aoColumns": [ 
						{ bVisible:false },
						null
				  ],			
		"bProcessing": true,
		"bServerSide": true,
		responsive: true,
		columnDefs: varColumnDefs,
		"sScrollY": ($(window).height() - varTinggi),
		"sScrollX": "100%",
		"sScrollXInner": "100%",					  
		"sAjaxSource": "../json-setting/user_group_json.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			//usulanWarna;prosesWarna;selesaiWarna
			if( aData[22] == '1')
			{
				var i=0;
				for (i=0;i<=25;i++)
				{
					jQuery('td:eq('+i+')', nRow).addClass('hukumanStyle');
				}
			}
			
			return nRow;
		 },
		"sPaginationType": "full_numbers",
		});
		  
		//$('#example tbody tr').on('dblclick', function () {
		$('#example tbody').on( 'dblclick', 'tr', function () {
			$("#btnUbahData").click();	
		});														

		/* RIGHT CLICK EVENT */
		function fnGetSelected( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
					aReturn.push( aTrs[i] );
				}
			}
			return aReturn;
		}
		  
		function findRowIndexUsingCol(StringToCheckFor, oTableLocal, iColumn){
			// Initialize variables
			var i, aData, sValue, IndexLoc, oTable, iColumn;
			 
			aiRows = oTableLocal.fnGetNodes();
			 
			for (i=0,c=aiRows.length; i<c; i++) {
				iRow = aiRows[i];   // assign current row to iRow variable
				aData = oTableLocal.fnGetData(iRow); // Pull the row
				 
				sValue = aData[iColumn];    // Pull the value from the corresponding column for that row
				 
				if(sValue == StringToCheckFor){
					IndexLoc = i;
					break;
				}
			}
			 
			return IndexLoc;
		}
		  
		var anSelectedData = '';
		var anSelectedId = '';
		
		$('#example tbody').on( 'click', 'tr', function () {
			
			$("#example tr").removeClass('row_selected');
			$(".DTFC_Cloned tr").removeClass("row_selected");
			var row = $(this);
			var rowIndex = row.index() + 1;
			
			if (row.parent().parent().hasClass("DTFC_Cloned")) {
				$("#example tr:nth-child(" + rowIndex + ")").addClass("row_selected");;
			} else {
				$(".DTFC_Cloned tr:nth-child(" + rowIndex + ")").addClass("row_selected");
			}
			
			row.addClass("row_selected");
			var anSelected = fnGetSelected(oTable);													
			anSelectedData = String(oTable.fnGetData(anSelected[0]));
			var element = anSelectedData.split(','); 
		   // anSelectedSatkerId = element[element.length-2];
			anSelectedId = element[0];
		});	  			  
		
		$('#btnUbah').on('click', function () {
			  var ScreenX = $(window).width(), ScreenY = $(window).height();
			  //alert(ScreenX + ' × ' + ScreenY);
			  var widthPopup = 1000;
			  var heightPopup = 520;
			
			  if(ScreenX<1000){ var widthPopup = ScreenX; var heightPopup = 520; var anDevice = 1;}
			  if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var anDevice = 2;}
			  else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var anDevice = 2;}
			  else {var anDevice = 1;}		
			
			  if(anSelectedData == "")
				  return false;
				  
			  opUrl = 'user_group_add.php?reqMode=update&reqId='+anSelectedId+'&reqDevice='+anDevice;		
			  window.parent.OpenDHTML(opUrl, 'SIMERO - Sistem Aplikasi Menu Restoran', widthPopup, heightPopup);	
		});		  
		  
		$('#btnHapus').on('click', function () {
			if(anSelectedData == "")
			{
				return false;						  				  
			}
			else
			{
				$.messager.confirm('Warning', 'Apakah Anda yakin ingin menghapus data ini?', function(r){
					if (r){
					  $.getJSON("../json-setting/delete.php?reqMode=user_login&id=" + anSelectedId,
				  function(data){
					  location.reload(true);
					  window.top.displayUrlFromIframeChild('../setting/user_login.php');
				  });
					}
				});					  
			}
		});

	} );

</script>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../main/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="../main/css/bluetabs.css" />
<script type="text/javascript" src="../main/css/dropdowntabs.js"></script>

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	var ScreenX = $(window).width(), ScreenY = $(window).height();
	var anDevice = 1;
	
	if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var anDevice = 2;}
	else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var anDevice = 2;}
	else {var anDevice = 1;}

	/*
	dimatikan karna ga ada kombo
	if (anDevice == 2)
	{
		$('#display').addClass('ui-helper-clearfix:after');
	}*/

});
</script>
<!-- CSS BARU-->
    <link rel="stylesheet" href="../main/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../main/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../main/assets/fonts/style.css">
    <link rel="stylesheet" href="../main/assets/css/main.css">
<!-- Tutup CSS BARU -->
</head>
<body class="tinggi">

<div id="begron_data_table"></div>
<div id="wadah">
             
   <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
   </form>
    
 	 <div class="container">
    	  <ol class="breadcrumb">
        	<li>
            	  <i class="clip-cog-2"></i>&nbsp;
              	<a href="#"> Setting</a>
          	</li>
          	<li class="active">
              User Group
          	</li>
      	</ol>
  	</div>
  <div class="panel-heading">
    <i class="fa fa-external-link-square"></i>
		<a href="#!" id="btnUbah" title="Ubah"><img src="../main/images/btn-ubah.png" width="15" height="15"/> Ubah Akses</a>
   </div>    
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nama Group</th>
        </tr>
    </thead>
    </table>
    </div>    
</div>
</body>
</html>