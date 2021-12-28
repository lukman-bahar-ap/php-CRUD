<?php
/*
El directorio donde se va a generar el archivo debe tener permisos de lectura y escritura
*/

    require 'phpword/PHPWord.php';
     
    $template = 'template.docx';
     
    $PHPWord = new PHPWord();
    $document = $PHPWord->loadTemplate($template);

    #reemplaza una variable con varias imagenes
    $aImgs = array(
        array(
            	'img' => 'phpword/Examples/_earth.JPG',
		'size' => array(580, 280)
        ),
        array(
            'img' => 'phpword/Examples/_mars.jpg',
            'dataImg' => 'Esta es el pie de imagen para _mars.jpg'
        )
    );
    $document->replaceStrToImg( 'areaImages', $aImgs);
     
    #reemplaza una variable con una imagen
    $aImgs = array(
        array(
            	'img' => 'phpword/Examples/_earth.JPG',
		'size' => array(200, 150),
		'dataImg' => 'Esta es el pie de imagen para _earth.JPG'
        )
    );
    $document->replaceStrToImg( 'unaImagen', $aImgs);
     

    $document->save('nuevoDoc.docx');
?>
