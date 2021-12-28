<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="../main/assets/images/logo-icon.png">
<title>test</title>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

<!-- push.js notification show -->

<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script src="1.0.5/push.min.js"></script>
<script type="text/javascript">
function playSound()
	{
		var audio = new Audio('solemn.mp3');
		audio.play();
	}
	
$(document).ready(function(){
	alert('ad');
	//notification
	//var reqJml = document.getElementById('reqJml').value;
	var updatedCheck = window.setInterval(    
	function(){$.ajax({
			url: "notification.php?reqJml=11", //Returns {"updated": "true"} or {"updated": "false"}
			//data: dataString,
			//dataType: "json", 
			success: function(data){ 
				//if (STATUS.toString()=="true") { //not sure if this is the correct method
				  data = data.split("#");
				  if (data[1]=="true") { 
				   playSound();
				   
				   Push.Permission.request(() => {
					Push.create('Notifikasi', {
					body: 'notifikasi muncul',
					icon: 'confirm.png',
					timeout: 3000,
					onClick: () => {
						alert('Cek Tiket bosku!');
							}
						});
					});
				   //The user is updated - the page needs a reload
				  // window.parent.document.getElementById('SpanNotifikasi').innerHTML = data[0];
				  // window.parent.document.getElementById('SpanNotifikasi2').innerHTML = "!";
				 //  document.getElementById('reqJml').value = data[0];
				   playSound();
				   //window.top.displayUrlFromIframeChild('../monitoring/monitoring_tiket.php');
			   }
			} //success

		})}
	, 15000);
	//notification		
	updatedCheck();						
	} );

</script>

</head>
<body >
test notifikasi
</body>
</html>
