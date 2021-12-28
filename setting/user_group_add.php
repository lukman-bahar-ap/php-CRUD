<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserAccess.php");
include_once("../WEB-INF/classes/base/UserGroup.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$user_access = new UserAccess();
$user_group = new UserGroup();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqDevice = httpFilterGet("reqDevice");

	$user_access->selectByParams(array(), -1, -1, $reqId);
	$i=0;
	while($user_access->nextRow())
	{
		$arrUserAccess[$i]["USER_ACCESS_ID"] 	= $user_access->getField("USER_ACCESS_ID");
		$arrUserAccess[$i]["NAMA_MENU"] 		= $user_access->getField("NAMA_MENU");
		$arrUserAccess[$i]["GROUP_".$reqId] 	= $user_access->getField("GROUP_".$reqId);

		$i++;	
	}
	
	$user_group->selectByParams(array("USER_GROUP_ID" => $reqId));
	$user_group->firstRow();
	
	$tempUserGroupId	= $user_group->getField("USER_GROUP_ID");
	$tempNamaGroup		= $user_group->getField("NAMA_GROUP");	
?>
<style>
.close-submenu-mobile{
	display:none;
}
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;Sistem Informasi Manajemen Pegawai dan Tenaga Kependidikan Dinas Pendidikan Kabupaten Bondowoso</title>

    <link href="../main/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../main/css/admin.css" rel="stylesheet" type="text/css">    
    <link href="../main/css/stylesheet.css" rel="stylesheet" type="text/css">   
    <link rel="stylesheet" type="text/css" href="../main/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">

    <script type="text/javascript" src="../main/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-setting/user_group_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("#");
					$.messager.alert('Info', data[1], 'info');
					//$('#rst_form').click();
					//parent.frames['mainFramePop'].location.href = 'arsip_add_identitas_pribadi_monitoring.php?reqId=' + data[0];
					window.top.displayUrlFromIframeChild('../setting/user_group.php');
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
	
	function OpenSubMenu(par1){
	$('#submenu').addClass('.close-submenu-mobile');
	}
    </script>
    
<script>
function cek(reqCheckAccessId){
    for(i=0; i < reqCheckAccessId.length; i++){
        reqCheckAccessId[i].checked = true;
    }
}
function uncek(reqCheckAccessId){
    for(i=0; i < reqCheckAccessId.length; i++){
        reqCheckAccessId[i].checked = false;
    }
}
</script>    
            
</head>
<body>
<div id="begron"><!--<img src="../main/images/wall-kanan-polos.jpg" width="100%" height="100%" alt="Smile">--></div>
<div id="wadah" class="CodeMirror-scroll">
        <div id="bluemenu" class="bluetabs" style="background:url(../main/css/media/bluetab.gif); position:fixed; width:100%; margin-top:0px; zIndex: -1'">    
            <ul>
                <li>
                <a href="#" onClick="$('#btnSubmit').click();"><img src="../main/images/btn-simpan.png" width="15" height="15"/> Simpan</a>
                <a href="#" onClick="$('#btnCheckAll').click();"><img src="../main/images/btn-check.png" width="15" height="15"/> Check All</a>
                <a href="#" onClick="$('#btnClearAll').click();"><img src="../main/images/btn-hapus.png" width="15" height="15"/> Clear All</a>
                </li>  
                <li> 
                   <a href="#" onClick="window.parent.divwin.close();" title="Tutup"><img src="../main/images/btn-batal.png" width="15" height="15"/> Tutup</a>
				</li>     
      
            </ul>
        </div>
   
    <div id="area-form">
    <?
    if($reqDevice == 1)
    {
	?>           

    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table border="0" class=datatable width="100%">
        <tr>
            <td colspan="7" align="center" bgcolor="#FFFFC0">Checklist User Group - <?=$tempNamaGroup?></td>
        </tr>
        <tr>
            <td width="157px" align="center">Master Data</td>
            <td width="157px" align="center">Absensi</td>
            <td width="157px" align="center">Pesan SMS</td>
            <td width="157px" align="center">Laporan dan Statistik</td>
            <td width="157px" align="center">Setting</td>
        </tr>
        <tr>
            <td valign="top">
            	<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[0]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[0]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Siswa</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[1]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[1]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Kelas</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[2]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[2]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Phone Book</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[3]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[3]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Number Group</td>
                    </tr>
                </table>
            </td>
            <td valign="top">
            	<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[4]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[4]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Absensi</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[5]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[5]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Jam Efektif</td>                         
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[6]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[6]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Libur Sekolah</td>                         
                    </tr>
                 </table>               
            </td>
            <td valign="top">
            	<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[7]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[7]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Tulis Pesan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[8]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[8]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Inbox</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[9]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[9]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Outbox</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[10]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[10]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Terkirim</td>                         
                    </tr>
                 </table>               
            </td>
            <td valign="top">
            	<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[11]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[11]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Absensi Berdasarkan Bulan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[12]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[12]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Absensi Berdasarkan Siswa</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[13]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[13]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Rekap Absensi Kelas</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[14]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[14]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Rekap Absensi Bulan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[15]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[15]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Statistik Absensi Kelas</td>      
                    </tr>                                          
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[16]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[16]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Statistik Absensi Bulan</td>      
                    </tr>                                          
                </table>                
            </td>
            <td valign="top">
            	<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[17]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[17]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Koneksi Modem</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[18]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[18]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Ubah Password</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[19]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[19]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>User Login</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[20]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[20]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>User Group</td>                         
                    </tr>
                </table>                
            </td>
        </tr>
                        
    </table>
        <div style="display:none;">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
        <input type="reset" id="rst_form">
        <input type="button" id="btnCheckAll" name="btnCheckAll" onclick="cek(this.form.reqCheckAccessId)" value="Select All" />
        <input type="button" id="btnClearAll" name="btnClearAll" onclick="uncek(this.form.reqCheckAccessId)" value="Clear All" />                    
        </div>            
    </form>
	<?
	}
	else
	{
	?>
        <form id="ff" method="post" novalidate enctype="multipart/form-data">
            <table border="0" width="100%">
        <tr>
			<td colspan="2">
             <table border="0" class=datatable width="100%">
        <tr>
            <td align="center" bgcolor="#FFFFC0">Checklist User Group - <?=$tempNamaGroup?></td>
            </tr>
            </table>
			</td>
        </tr>
        <tr>
        <td valign="top" width="50%">
    <table border="0" class=datatable width="100%">
        <tr>
          <td width="157px" align="center" bgcolor="#e6e6e6" onClick="OpenSubMenu('MasterData');">Master Data</td>
</tr>
<tr>
<td valign="top">
<table border="0" class="datatable submenu" width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[0]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[0]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Siswa</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[1]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[1]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Kelas</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[2]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[2]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Phone Book</td>
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[3]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[3]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Number Group</td>
                    </tr>
                </table>
</td>
</tr>
</table>

    <table border="0" class=datatable width="100%">
        <tr>
 <td width="157px" align="center" bgcolor="#e6e6e6">Pesan SMS</td>      
 </tr>
 <tr>
 <td valign="top">
 
 <table border="0" class=datatable width="100%">
<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[4]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[4]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Tulis Pesan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[5]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[5]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Inbox</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[6]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[6]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Outbox</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[7]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[7]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Terkirim</td>                         
                    </tr>
       </table>
 
 </td>
 </tr>
</table>

    <table border="0" class=datatable width="100%">
        <tr>
 <td width="157px" align="center" bgcolor="#e6e6e6">Setting</td>      
 </tr>
 <tr>
 <td valign="top">
		<table border="0" class=datatable width="100%">
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[8]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[8]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Koneksi Modem</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[9]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[9]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Ubah Password</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[10]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[10]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>User Login</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[11]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[11]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>User Group</td>                         
                    </tr>

                </table>
 </td>
 </tr>
</table>

        </td>
        <td valign="top" width="50%">
    <table border="0" class=datatable width="100%">
        <tr>        
        <td width="157px" align="center" bgcolor="#e6e6e6">Absensi</td>
</tr>
<tr>
<td valign="top">
<table border="0" class=datatable width="100%">
<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[12]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[12]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Data Absensi</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[13]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[13]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Jam Efektif</td>                         
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[14]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[14]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Libur Sekolah</td>                         
                    </tr>                 </table>
</td>
</tr>
</table>

    <table border="0" class=datatable width="100%">
        <tr>        
        <td width="157px" align="center" bgcolor="#e6e6e6">Laporan dan Statistik</td>
</tr>
<tr>
<td valign="top">
<table border="0" class=datatable width="100%">
<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[15]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[15]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Absensi Berdasarkan Bulan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[16]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[16]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Absensi Berdasarkan Siswa</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[17]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[17]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Rekap Absensi Kelas</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[18]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[18]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Rekap Absensi Bulan</td>                         
                    </tr>
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[19]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[19]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Statistik Absensi Kelas</td>      
                    </tr>                                          
                	<tr>
                        <td align="center">
                            <input type="checkbox" id="reqCheckAccessId" name="reqCheckAccessId[]" value="<?=$arrUserAccess[20]["USER_ACCESS_ID"];?>" <? if($arrUserAccess[20]["GROUP_".$reqId] == "0"){}else{ echo "checked";} ?>/>
                        </td>
                        <td>Statistik Absensi Bulan</td>      
                    </tr>
               </table>
</td>
</tr>
</table>



        </td>
        </tr>
        </table>
        <div style="display:none;">
        <input type="text" id="reqId" name="reqId" value="<?=$reqId?>">
        <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
        <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
        <input type="reset" id="rst_form">
        <input type="button" id="btnCheckAll" name="btnCheckAll" onclick="cek(this.form.reqCheckAccessId)" value="Select All" />
        <input type="button" id="btnClearAll" name="btnClearAll" onclick="uncek(this.form.reqCheckAccessId)" value="Clear All" />                    
        </div>            
    </form>

    <?
	}
	?>
    </div>
    
</div>
<script>
$("#reqTahun").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>