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

$reqId = httpFilterGet("reqId");
$reqNama = httpFilterGet("reqNama");
$reqDevice = httpFilterGet("reqDevice");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="../main/assets/images/logo-icon.png">
<title><?=titleWeb?></title>
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
	.warnaJumlah{background-color: #fcf303;}
</style>

<style type="text/css">  
  @media screen and (min-width:992px) {
	.form-desktop {}  
	.form-mobile { display:none;}
  }

  @media screen and (max-width:991px) {
	.form-desktop { display:none; }
	.form-mobile {}
  }	  		  		  
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

<script src="../WEB-INF/lib/media/js/jquery.dataTables.rowGrouping.js" type="text/javascript"></script>	
<!--<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script> -->
<script>
  $(window).bind('hashchange', function () {
      if (location.hash == null || location.hash == "") {
          window.parent.divwin.close();
      }
  });
</script>


<script type="text/javascript">
$(document).ready(function(){
	var ScreenX = $(window).width(), ScreenY = $(window).height();
	var anDevice = 1;
	
	//mengatur tinggi dhtml / popup
	if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var anDevice = 2;}
	else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var anDevice = 2;}
	else {var anDevice = 1;}
	
	if (anDevice == 2)
	{
		$('#display').addClass('ui-helper-clearfix:after');
	}
	
	//mengatur tinggi datatables
	var TingginavHeader = 51;
	var TingginavTool = 50;
	var TinggiPanelTambahUbah = 36;
	var TinggiToolbarDT = 37;
	var TinggiFieldDT = 37;
	var TinggiFooterDT = 63;
	var TingginavFooter = 42;
	
	var PenguranganNilai = 93;
		varTinggi = ScreenY - TingginavTool - TinggiPanelTambahUbah - TinggiToolbarDT -TinggiFieldDT - TinggiFooterDT - TingginavFooter - PenguranganNilai; 
});
</script>

<script type="text/javascript" language="javascript" class="init">
	function trim(str)
	{
		if(!str || typeof str != 'string')
			return null;
	
		return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

    $(document).ready( function () {
		
		var ScreenX = $(window).width();
		if(ScreenX<=494)
		{
			varColumnDefs = [{className: 'never', targets: [0,1]}, {className: 'none', targets: [0,1,-1,-2]}];
			varTinggi = 130;
			varaoColumns = [
								{ bVisible:false },
								{ bVisible:false },
							   null,
							   null,
							   null,
							   null,
							   null			
							];			
		}
		else
		{
			varColumnDefs = [{className: 'never', targets: [0,1]}, {className: 'none', targets: [0,1]}];
			varTinggi = 240;
			varaoColumns = [
							   { bVisible:false },
							   { bVisible:false },
							   null,
							   null,
							   null,
							   null,
							   null				
							];				
		}		
		
        var id = -1;//simulation of id
		$(window).resize(function() {
		  console.log($(window).height());
		  $('.dataTables_scrollBody').css('height', ($(window).height() - varTinggi));
		});
		
        var oTable = $('#example').dataTable({ "iDisplayLength": 50, bJQueryUI: true,
		/* UNTUK MENGHIDE KOLOM ID */
		"aoColumns": varaoColumns,
		"bSort" : false,
		"bProcessing": true,
		"bServerSide": true,
		responsive: true,
		columnDefs: varColumnDefs,
		"sScrollY": ($(window).height() - varTinggi),
		"sScrollX": "100%",
		"sScrollXInner": "100%",					  
		"sAjaxSource": "../json-master-data/periksa_json.php?reqId=<?=$reqId?>",		
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
		
		$('#btnKembali').on('click', function () {
			var ScreenX = $(window).width(), ScreenY = $(window).height();
			  var widthPopup = 600;
			  var heightPopup = 400;
			  
			  if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
			  else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
			  else {var anDevice = 1;}
			  
			 window.top.displayUrlFromIframeChild('../master-data/pasien.php?&reqDevice='+anDevice);
		
		});  
		
		
		$('#btnUbah').on('click', function () {
			  var ScreenX = $(window).width(), ScreenY = $(window).height();
			  var widthPopup = 600;
			  var heightPopup = 400;
			  
			  if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
			  else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
			  else {var anDevice = 1;}
			
			  if(anSelectedData == "")
				  return false;
				  
			  opUrl = 'periksa_add.php?reqMode=update&reqId='+anSelectedId+'&reqDevice='+anDevice;		
			  window.parent.OpenDHTML(opUrl, '<?=titleWeb()?>', widthPopup, heightPopup, topPopup);	
		});
		
		$('#btnHapus').on('click', function () {
			if(anSelectedData == ""){ return false; }
			else
			{
				$.messager.confirm('Warning', 'Apakah Anda yakin ingin menghapus data ini?', function(r){
					if (r){
						$.getJSON("../json-master-data/delete.php?reqMode=periksa&id="+anSelectedId,
				  function(data){
					  location.reload(true);
					  window.top.displayUrlFromIframeChild('../master-data/periksa.php?reqId=<?=$reqId?>&reqNama=<?=$reqNama?>');
				  });
					}
				});					  
			}
		});
		
		$('#btnExpor').on('click', function () {
			newWindow = window.open("report_periksa_excel.php?reqIdPelangganKontrak=<?=$reqIdPelangganKontrak?>&reqPelangganKontrak=<?=$reqPelangganKontrak?>", "Cetak");
			newWindow.focus();
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

<script type="text/javascript" charset="utf-8">
/*lukman*/
function Tambah(){
	var ScreenX = $(window).width(), ScreenY = $(window).height();
	//alert(ScreenX + ' × ' + ScreenY);
	var widthPopup = 600;
	var heightPopup = 400;
	
	if(ScreenX<=767){ var widthPopup = ScreenX; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
	else if(ScreenX>494 && ScreenX<=1024){ var widthPopup = ScreenX+200; var heightPopup = 750; var topPopup = -20; var anDevice = 2;}
	else {var anDevice = 1; var topPopup = 50;}
	
	opUrl = 'periksa_add.php?reqMode=insert&reqId=<?=$reqId?>&reqDevice='+anDevice;		
	window.parent.OpenDHTML(opUrl, '<?=titleWeb()?>', widthPopup, heightPopup, topPopup);		
}
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
             
 	 <div class="container">
    	<ol class="breadcrumb">
        	<li class="active">&nbsp;&nbsp;&nbsp;&nbsp;
            	<i class="fa fa-columns"></i>&nbsp;&nbsp;Riwayat Pasien
          	</li>
            <li><?=$reqNama?></li>
      	</ol>
  	</div>
    <div class="panel-heading">
      <i class="fa fa-arrow-left"><a href="#!" id="btnKembali" title="Back to Data Pasien">&nbsp;Back</a></i>
          <!--<a href="#!" id="btnCetak" title="Cetak"><img src="../main/images/btn-cetak.png" width="15" height="15"/> Cetak</a>
          &nbsp;&nbsp;&nbsp;-->
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="#!" id="btnTambah" onClick="Tambah();" title="Add"><img src="../main/images/btn-tambah.png" width="15" height="15"/> Tambahkan Data</a>
          &nbsp;&nbsp;&nbsp;
          <?
            if($userLogin->unitUpj == "Super Admin")
            {
          ?>
          <a href="#!" id="btnHapus" title="Delete"><img src="../main/images/btn-hapus.png" width="15" height="15"/> Hapus</a>
          <? } ?>
    </div>
    
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>PERIKSA_ID</th>
            <th>PASIEN_ID</th>
            <th width="20%">TGL PERIKSA</th>
            <th>S</th>
            <th>O</th>
            <th>A</th>
            <th>P</th>
        </tr>
    </thead>
    </table>
    </div>    
</div>
</body>
</html>
