<?
include 'PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Jobin Jose");
$objPHPExcel->getProperties()->setLastModifiedBy("Jobin Jose");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHPExcel classes.");
// Add some data
// echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
//$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');
$objPHPExcel->getActiveSheet()->setTitle('Simple');
$gdImage = imagecreatefromjpeg('uploads/t12.jpg');
// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";


for($i=1;$i<=3;$i++)
{
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Sample image');
	$objDrawing->setDescription('Sample image');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(50);
	$objDrawing->setCoordinates('C'.$i);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
}


$objWriter->save(str_replace('.php', '.xls', __FILE__));
// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
?>