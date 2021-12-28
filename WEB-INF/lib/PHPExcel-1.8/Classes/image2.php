<?
$xlsFile = 'test.xls';
require_once 'PHPExcel/Reader/Excel5.php';
$objReader = new PHPExcel_Reader_Excel5();
//$objReader->setReadDataOnly(true);
$data = $objReader->load($xlsFile);
$objWorksheet = $data->getActiveSheet();
foreach ($objWorksheet->getDrawingCollection() as $drawing) {
//for XLSX format
$string = $drawing->getCoordinates();
$coordinate = PHPExcel_Cell::coordinateFromString($string);
if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
$image = $drawing->getImageResource();
// save image to disk
$renderingFunction = $drawing->getRenderingFunction();
switch ($renderingFunction) {
case PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG:
imagejpeg($image, 'uploads/t12.jpg');
break;
case PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF:
imagegif($image, 'uploads/' . $drawing->getIndexedFilename());
break;
case PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG:
case PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT:
imagepng($image, 'uploads/' . $drawing->getIndexedFilename());
break;
}
}
}
?>