<?php
function SendDGNotificationEmail($toCust, $toAdmin, $TicketNumber, $Category, $unit, $StatusTiket, $nama, $telp, $alamat, $tgltiket, $servicetag, $keluhan, $toAssignee, $Assignee, $TiketJenis, $GpsL, $GpsB, $Solution="", $note=""){

$defaultsendEmail="admin@dg-itonline.com, project@cvdeagroup.com, finance@cvdeagroup.com, info@cvdeagroup.com, helpdesk@dg-itonline.com";
//, support@dg-itonline.com

// multiple recipients
$to  = $toCust . ''; // note the comma
//$to .= $toAdmin;
//$to .= $toAdmin.$defaultsendEmail;

// subject
$subject = $TicketNumber.' - Status Tiket : '.$StatusTiket;

if(!empty($toAdmin)){
	$toAdmin= $toAdmin.", ";
}
if(!empty($toAssignee)){
	$to .= ', '.$toAssignee;
}
if($StatusTiket=="Open")
	$info="registrasi";
else
	$info="di update";

$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Bpk/Bu</b><br><br>';
$message .= '<p>Pengaduan dengan nomor tiket <b>'.$TicketNumber.'</b> telah berhasil '.$info.' dengan rincian sebagai berikut</p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_opengenap.'  User'.$td_genap. $nama .$tr_tutup;
$message .= $tr_openganjil.' Kontak Person'.$td_ganjil. $telp .$tr_tutup;
$message .= $tr_opengenap.' Lokasi'.$td_genap. $alamat .$tr_tutup;

$message .= $tr_openganjil.' Tgl Tiket'.$td_ganjil. $tgltiket .$tr_tutup;
$message .= $tr_opengenap.' Deskripsi Pengaduan'.$td_genap. $keluhan .$tr_tutup;
$message .= $tr_openganjil.' Kategori'.$td_ganjil. $Category .$tr_tutup;

if($TiketJenis==1){
	$message .= $tr_opengenap.' Unit'.$td_genap. $unit .$tr_tutup;
	$message .= $tr_openganjil.' ServiceTag / SN'.$td_ganjil. $servicetag .$tr_tutup;
}else{
	$message .= $tr_opengenap.' Tipe Unit'.$td_genap. $servicetag .$tr_tutup;
	$message .= $tr_openganjil.' Unit'.$td_ganjil. $unit .$tr_tutup;
}
$message .= $tr_opengenap.' Status Tiket'.$td_genap. $StatusTiket .$tr_tutup;
$message .= $tr_openganjil.' Assignee'.$td_ganjil. $Assignee .$tr_tutup;

if($StatusTiket=="Resolved" || $StatusTiket=="Closed"){
	$message .= $tr_opengenap.' Penyelesaian / Penjelasan'.$td_genap. $Solution .$tr_tutup;
}
if($StatusTiket=="Pending" || $StatusTiket=="Cancel" ){
	$message .= $tr_opengenap.' Catatan'.$td_genap. $note .$tr_tutup;
}
if($TiketJenis==2){
	$message .= $tr_openganjil.' Koordinat'.$td_ganjil. $GpsL.", ".$GpsB .$tr_tutup;
}

$message .= '</table>';

$message .= '<p>Ini adalah notifikasi otomatis dari sistem kami, Anda tidak dapat membalas email ini. Hubungi kami untuk pertanyaan lebih lanjut<br>Terimakasih</p><br>';

$message .= 'DG Ticket Notification<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG Ticket Notification<info@dg-itonline.com>' . "\r\n";
$headers .= 'Cc: '.$toAdmin.$defaultsendEmail . "\r\n";

mail($to, $subject, $message, $headers);

}
function SendDGNotificationEmailEng($toCust, $toAdmin, $TicketNumber, $Category, $unit, $StatusTiket, $nama, $telp, $alamat, $tgltiket, $servicetag, $keluhan, $toAssignee, $Assignee, $TiketJenis, $GpsL, $GpsB, $Solution="", $note=""){

$defaultsendEmail="admin@dg-itonline.com, project@cvdeagroup.com, finance@cvdeagroup.com, info@cvdeagroup.com, helpdesk@dg-itonline.com";
//, support@dg-itonline.com
 
// multiple recipients
$to  = $toCust . ', '; // note the comma
$to .= $toAdmin.$defaultsendEmail;

// subject
$subject = $TicketNumber.' - Incident Ticket Status '.$StatusTiket;

if(!empty($toAdmin)){
	$toAdmin= $toAdmin.", ";
}
if(!empty($toAssignee)){
	$to .= ', '.$toAssignee;
}
if($StatusTiket=="Open")
	$info="registered";
else
	$info="updated";

$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Sir/Madam</b><br><br>';
$message .= '<p>The Incident ticket number <b>'.$TicketNumber.'</b> has been '.$info.'</p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_opengenap.'  User Name'.$td_genap. $nama .$tr_tutup;
$message .= $tr_openganjil.' Contact Number'.$td_ganjil. $telp .$tr_tutup;
$message .= $tr_opengenap.' Location'.$td_genap. $alamat .$tr_tutup;

$message .= $tr_openganjil.' Open Time'.$td_ganjil. $tgltiket .$tr_tutup;
$message .= $tr_opengenap.' Issue Description'.$td_genap. $keluhan .$tr_tutup;
$message .= $tr_openganjil.' Category'.$td_ganjil. $Category .$tr_tutup;

if($TiketJenis==1){
	$message .= $tr_opengenap.' Unit Name'.$td_genap. $unit .$tr_tutup;
	$message .= $tr_openganjil.' ServiceTag / SN'.$td_ganjil. $servicetag .$tr_tutup;
}else{
	$message .= $tr_opengenap.' Unit Type'.$td_genap. $servicetag .$tr_tutup;
	$message .= $tr_openganjil.' Unit Name'.$td_ganjil. $unit .$tr_tutup;
}
$message .= $tr_opengenap.' Status Ticket'.$td_genap. $StatusTiket .$tr_tutup;
$message .= $tr_openganjil.' Assignee'.$td_ganjil. $Assignee .$tr_tutup;

if($StatusTiket=="Resolved" || $StatusTiket=="Closed"){
	$message .= $tr_opengenap.' Resolution'.$td_genap. $Solution .$tr_tutup;
}
if($StatusTiket=="Pending" || $StatusTiket=="Cancel" ){
	$message .= $tr_opengenap.' Note'.$td_genap. $note .$tr_tutup;
}
if($TiketJenis==2){
	$message .= $tr_openganjil.' Coordinate'.$td_ganjil. $GpsL.", ".$GpsB .$tr_tutup;
}

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG Ticket Notification<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG Ticket Notification<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}

function SendEmailPass($toCust, $nama, $pass){
// multiple recipients
$to  = $toCust;

// subject
$subject = ' Reset Password ';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Sdr/Sdri '.$nama.'</b><br><br>';
$message .= '<p>Password anda berhasil di reset. cobalah menggunakan password berikut untuk login </p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' Password '.$td_ganjil. $pass .$tr_tutup;

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}

function SendEmailWelcome($reqEmail, $reqNama, $reqNoHp, $reqAlamat, $reqKota, $reqPropinsi){
// multiple recipients
$to  = $reqEmail;

// subject
$subject = ' Selamat Datang';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Sdr/Sdri '.$nama.'</b><br><br>';
$message .= '<p>Selamat Bergabung di member Dea Group IT Online. kami sangat senang jika dapat membantu anda dalam menangani masalah dalam seputar perangkat IT. anda telah berhasil registrasi dengan data berikut </p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' Nama'.$td_ganjil. $reqNama .$tr_tutup;
$message .= $tr_openganjil.' Telepon'.$td_ganjil. $reqNoHp .$tr_tutup;
$message .= $tr_openganjil.' Email'.$td_ganjil. $reqEmail .$tr_tutup;
$message .= $tr_openganjil.' Propinsi'.$td_ganjil. $reqPropinsi .$tr_tutup;
$message .= $tr_openganjil.' Kota/Kabupaten'.$td_ganjil. $reqKota .$tr_tutup;
$message .= $tr_openganjil.' Alamat'.$td_ganjil. $reqAlamat .$tr_tutup;

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}


function SendEmailWelcomeKontrak($reqEmail, $reqNama, $reqNoHp, $reqAlamat){
// multiple recipients
$to  = $reqEmail;

// subject
$subject = ' Selamat Datang di layanan Dea Group IT Online';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Mitra Dea Group </b><br><br>';
$message .= '<p>Selamat Bergabung di member Dea Group IT Online.</p>';
$message .= '<p>Anda telah terdaftar sebagai mitra kerjasama dengan data seperti berikut :</p>';

$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' Nama Mitra '.$td_ganjil. $reqNama .$tr_tutup;
$message .= $tr_openganjil.' Telepon'.$td_ganjil. $reqNoHp .$tr_tutup;
$message .= $tr_openganjil.' Email'.$td_ganjil. $reqEmail .$tr_tutup;
$message .= $tr_openganjil.' Alamat'.$td_ganjil. $reqAlamat .$tr_tutup;

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}


function SendEmailAktifasi($toCust, $nama, $aktivasi){
// multiple recipients
$to  = $toCust;

// subject
$subject = ' Kode Aktivasi ';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Sdr/Sdri '.$nama.'</b><br><br>';
$message .= '<p>Silahkan masukkan kode aktivasi berikut pada aplikasi agar akun anda terverifikasi secara otomatis. Kode Aktifasi hanya digunakan sekali saja. jika anda telah terlanjur menutup aplikasi IT Online android, kode ini bisa digunakan setelah anda melakukan login pertama kali. gunakan telepon dan password yang telah anda daftarkan</p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' Kode Aktifasi '.$td_ganjil. $aktivasi .$tr_tutup;

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}

function SendEmailRekrutmenAdmin($toCust, $id, $nama, $kota){
// multiple recipients
$to  = $toCust;

// subject
$subject = ' Register id -'.$id.' rekrutmen ';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear Admin, </b><br><br>';
$message .= '<p>Telah tersubmit dari website rekrutmen dengan data berikut. mohon lakukan cek pada aplikasi monitoring</p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' ID Rekrut '.$td_ganjil. $id .$tr_tutup;
$message .= $tr_opengenap.' Nama Pelamar'.$td_genap. $nama .$tr_tutup;
$message .= $tr_openganjil.' Kota/Kabupaten '.$td_ganjil. $kota .$tr_tutup;

$message .= '</table><br><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}

function SendEmailRekrutmenUser($toCust, $id, $nama, $kota){
// multiple recipients
$to  = $toCust;

// subject
$subject = ' Register id -'.$id.' rekrutmen IT Online ';


$tr_opengenap = '<tr><td bgcolor=#f4f8f7 style=padding:10px>';
$tr_openganjil= '<tr><td bgcolor=#e8f2f1 style=padding:10px>';
$td_genap = '</td><td bgcolor=#f4f8f7 style=padding:10px>';
$td_ganjil = '</td><td bgcolor=#e8f2f1 style=padding:10px>';
$tr_tutup = '</td></tr>';

// message
$message = '<b>Dear '.$nama.', </b><br><br>';
$message .= '<p>Terimakasih telah berpartisipasi dengan Dea Group. Dokumen yang anda submit akan diproses, kami akan menghubungi anda apabila dokumen anda telah lolos seleksi</p>';
$message .= '<table border=0 width=550px style=font-size:14px>';

$message .= $tr_openganjil.' ID Rekrut '.$td_ganjil. $id .$tr_tutup;
$message .= $tr_opengenap.' Nama Pelamar'.$td_genap. $nama .$tr_tutup;
$message .= $tr_openganjil.' Kota/Kabupaten '.$td_ganjil. $kota .$tr_tutup;

$message .= '</table>';

$message .= '<p>Do not reply this email. Please contact us for question<br>Thank you</p><br>';

$message .= 'DG IT Online<br>';
$message .= '<b>CV. DEA GROUP</b><br>';
$message .= 'Jl. Sari Gading No. 16A Denpasar<br>';
$message .= 'Contact  : 0361 8957199 | 081558031078<br>';
$message .= 'Email Us : info@cvdeagroup.com<br>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: DG IT Online<info@dg-itonline.com>' . "\r\n";

mail($to, $subject, $message, $headers);

}


?>