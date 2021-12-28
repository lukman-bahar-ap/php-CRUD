<?php
if(!empty($_FILES)){
	
	//konfigurasi database
	$dbHost = 'localhost';
	$dbUsername = 'root';
	$dbPassword = 'bismillah';
	$dbName = 'codingan';
	//menghubungkan ke database
	$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
	if($mysqli->connect_errno){
		echo "Gagal terhubung ke MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$targetDir = "upload/";
	$namaFile = $_FILES['file']['name'];
	$targetFile = $targetDir.$namaFile;
	if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
		//memasukkan informasi file ke dalam database
		$conn->query("INSERT INTO file (nama_file, diupload) VALUES('".$namaFile."','".date("Y-m-d H:i:s")."')");
	}
	
}
?>