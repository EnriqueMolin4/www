<?php
ini_set('max_execution_time', '2000');
ini_set('memory_limit', '650M');
ini_set('post_max_size', '600M');
ini_set('upload_max_filesize', '1000M');
ini_set('max_input_time', '2000');

include '../conexion.php';
$archivo = $_FILES['excel']['name'];
$destino = 'bak_'.$archivo;
!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = 2;
!empty($_POST['altura']) ? $altura = $_POST['altura'] : $altura = 6;
if(!empty($archivo)){
	if(copy($_FILES['excel']['tmp_name'], $destino)){
		// echo 'ARCHIVO CARGADO CON EXITO, IMPRIMA EXCEL ';
	}
	else{
		echo 'ERROR AL CARGAR ARCHIVO';
	}
	if(file_exists('bak_'.$archivo)){

		include "Classes/PHPExcel.php";
		include "Classes/PHPExcel/Reader/Excel2007.php";
		
		$objReader = new PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load('bak_'.$archivo);

		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

		$dimension = $objWorkSheet->getHighestRow();


		// for($i = $desde; $i <= $dimension; $i++){
		// 	$odtEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();

		// 	$comercioEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

		// 	$afiliEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

		// 	$direccionEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

		// 	$coloniaEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

		// 	$ciudadEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

		// 	$estadoEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();

		// 	$cpEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();

		// 	$tel_campoEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();

		// 	$emailEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('AR'.$i)->getCalculatedValue();

		// 	$servicioEx[$i] = 
		// 	$objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();

		// 	$tel_campoEx[$i] = str_replace(',',' ', $tel_campoEx[$i]);
		// }

		// for($i = $desde; $i <= $dimension; $i++){
		// 	$sql = "INSERT INTO `recivos`(`comercio`, `afiliacion`, `estado`, `direccion`, `colonia`, `ciudad`, `cp`, `tel_campo`, `email`, `banco`, `servicio`, `odt`,`altura`) 
		// 		values ('$comercioEx[$i]','$afiliEx[$i]','$estadoEx[$i]','$direccionEx[$i]','$coloniaEx[$i]','$ciudadEx[$i]','$cpEx[$i]','$tel_campoEx[$i]','$emailEx[$i]','SANTANDER','$servicioEx[$i]','$odtEx[$i]','$altura')";
		// 	$inDatos = $conexion->query($sql);
		// }
		unlink('bak_'.$archivo);
	}
	header('location: pdf_creator.php');
}
else{
	echo 'NO HAY ARCHIVOS SELECCIONADOS, ELIGE UN FICHERO';
}

?>