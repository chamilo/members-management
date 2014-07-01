<?php
require 'funciones.php';
require_once 'clases/PHPExcel.php';
require_once 'clases/PHPExcel/Cell/AdvancedValueBinder.php';
PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$query = desencriptar($_GET['query']);
$title = "Listado de miembros chamilo";

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Chamilo")
							 ->setLastModifiedBy("Chamilo")
							 ->setTitle($title);
							 
//$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth('100');
//$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight('100%');

$validLocale = PHPExcel_Settings::setLocale('es');
if (!$validLocale) {
	echo "La localización ha fallado\n";
}

$link = conectar();
$result = $link->query($query); 
if (!$result) {
	die('Invalid query: ' . $link->error);
}
if($result->num_rows > 0){
	// Head
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "Name")
            ->setCellValue('B1', "Surname")
            ->setCellValue('C1', 'Country')
			->setCellValue('D1', 'E-mail')
			->setCellValue('E1', 'Renewal')
			->setCellValue('F1', 'Quota')
			->setCellValue('G1', 'Type')
			->setCellValue('H1', 'Status')
			->setCellValue('I1', 'Date Arrival')
			->setCellValue('J1', 'Institution')
			->setCellValue('K1', 'Address')
			->setCellValue('L1', 'Postal Code')
			->setCellValue('M1', 'VAT')
			->setCellValue('N1', 'Language')
			->setCellValue('O1', 'Phone');

	$styleArray = array(
		'font' => array(
			'bold' => true,
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			),
		),
	);
	
	$styleArray2 = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '77BBFF')
		)
	);
	
	$styleArray3 = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'FAFAFA')
		) 
	);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray2);

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	
	$row = 1;
	while($aux = $result->fetch_assoc()){
		$row ++;
		$country = obtener("country","iso",$aux['country'],"printable_name");
		$type = obtener("type_member","cod",$aux['type'],"name");
		$status = obtener("status","cod",$aux['status'],"status");
		$language = obtener("language","cod",$aux['language'],"language");
		
		
		//Introducimos los datos en la línea del fichero de excel
		$objPHPExcel->setActiveSheetIndex(0)	
			->setCellValueByColumnAndRow(0, $row, $aux['name'])
			->setCellValueByColumnAndRow(1, $row, $aux['surname'])
			->setCellValueByColumnAndRow(2, $row, $country)
			->setCellValueByColumnAndRow(3, $row, $aux['email'])
			->setCellValueByColumnAndRow(4, $row, $aux['renewal'])
			->setCellValueByColumnAndRow(5, $row, $aux['quota'])
			->setCellValueByColumnAndRow(6, $row, $type)
			->setCellValueByColumnAndRow(7, $row, $status)
			->setCellValueByColumnAndRow(8, $row, $aux['date_arrival'])
			->setCellValueByColumnAndRow(9, $row, $aux['institution'])
			->setCellValueByColumnAndRow(10, $row, $aux['address'])
			->setCellValueByColumnAndRow(11, $row, $aux['postal_code'])
			->setCellValueByColumnAndRow(12, $row, $aux['vat'])
			->setCellValueByColumnAndRow(13, $row, $language)
			->setCellValueByColumnAndRow(14, $row, $aux['phone']);
	}
	
	//$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$row)->getNumberFormat()->setFormatCode('#.##');
	$objPHPExcel->getActiveSheet()->getStyle('A2:O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), '=SUM(F2:F'.$row.')');
	$objPHPExcel->getActiveSheet()->getStyle('F2:F'.($row+1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
	
}else{
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO ITEM LIST');
}
	
		
			
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="List_Members_Chamilo.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>