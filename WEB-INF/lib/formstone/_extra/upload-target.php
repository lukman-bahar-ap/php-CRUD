<?php

  // Grab any extra form data!

  foreach ($_POST as $key => $val) {
    echo $key . ": " . $val . "\n";
  }

  echo "\n\n";

  // Remember to process the uploads!
	  $arr_file_types = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg');
 
	  if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
		  echo "false";
		  return;
	  }
	   
	  if (!file_exists('uploads')) {
		  mkdir('uploads', 0777);
	  }
	   
	  move_uploaded_file($_FILES['file']['tmp_name'], '../templates/rekrutmen/' . time() . $_FILES['file']['name']);
	   
	  echo "File uploaded successfully.";



  $f = $_FILES["file"];
  $file = $f["name"];




  $error = false;

  if ($error) {
    die("Error: " . $error);
  } else {

    die("File: " . $file);
  }
