<?php
// header('Content-Type: text/html; charset=ISO-8859-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('memory_limit', '3024M');
ini_set('max_execution_time',9500);
ini_set("upload_max_filesize","900M");
ini_set('post_max_size','900M');

include '../conexion.php';


!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = 2;

!empty($_POST['altura']) ? $altura = $_POST['altura'] : $altura = 6;



if(!empty($_FILES['excel']['tmp_name'])){

	$archivo = $_FILES['excel']['name'];

	$destino = 'bak_'.$archivo;

	if(copy($_FILES['excel']['tmp_name'], $destino)){

		// echo 'ARCHIVO CARGADO CON EXITO, IMPRIMA EXCEL';

	}

	else{

		echo 'ERROR AL CARGAR ARCHIVO';

	}

	if(file_exists($destino)){



		include "../plugins/Classes/PHPExcel.php";

		include "../plugins/Classes/PHPExcel/Reader/Excel2007.php";

		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);



		$objReader = new PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load($destino);

		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);



		$dimension = $objWorkSheet->getHighestRow();



		for($i = $desde; $i <= $dimension; $i++){

			$odtEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();



			$comercioEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();



			$afiliEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();



			$direccionEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();



			$coloniaEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();



			$ciudadEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();



			$estadoEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();



			$cpEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();



			$tel_campoEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();



			$emailEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('AR'.$i)->getCalculatedValue();



			$servicioEx[$i] = 

			$objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();



			$tel_campoEx[$i] = str_replace(',',' ', $tel_campoEx[$i]);

			$direccionEx[$i] = str_replace(',',' ', $direccionEx[$i]);

		}



			$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';

    		$modificadas = 'AAAAAAACEEEEIIIIdNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';



		for($i = $desde; $i <= $dimension; $i++){



			$odt = strtoupper(strtr($odtEx[$i], utf8_decode($originales), $modificadas));

			$comercio = strtoupper(strtr($comercioEx[$i], utf8_decode($originales), $modificadas));

			$afili = strtoupper(strtr($afiliEx[$i], utf8_decode($originales), $modificadas));

			$direccion = strtoupper(strtr($direccionEx[$i], utf8_decode($originales), $modificadas));

			$colonia = strtoupper(strtr($coloniaEx[$i], utf8_decode($originales), $modificadas));

			$ciudad = strtoupper(strtr($ciudadEx[$i], utf8_decode($originales), $modificadas));

			$estado = strtoupper(strtr($estadoEx[$i], utf8_decode($originales), $modificadas));

			$cp = strtoupper(strtr($cpEx[$i], utf8_decode($originales), $modificadas));

			$tel_campo = strtoupper(strtr($tel_campoEx[$i], utf8_decode($originales), $modificadas));

			$email = strtoupper(strtr($emailEx[$i], utf8_decode($originales), $modificadas));

			$servicio = strtoupper(strtr($servicioEx[$i], utf8_decode($originales), $modificadas));

			$tel_campo = strtoupper(strtr($tel_campoEx[$i], utf8_decode($originales), $modificadas));

			$direccion = strtoupper(strtr($direccionEx[$i], utf8_decode($originales), $modificadas));



			$sql = "INSERT INTO `recivos`(`comercio`, `afiliacion`, `estado`, `direccion`, `colonia`, `ciudad`, `cp`, `tel_campo`, `email`, `banco`, `servicio`, `odt`,`altura`) 

				values ('$comercio','$afili','$estado','$direccion','$colonia','$ciudad','$cp','$tel_campo','$email','SANTANDER','$servicio','$odt','$altura')";

			$sql1 = "INSERT INTO `recivos`(`comercio`, `afiliacion`, `estado`, `direccion`, `colonia`, `ciudad`, `cp`, `tel_campo`, `email`, `banco`, `servicio`, `odt`,`altura`) 

				values ('$comercio','$afili','$estado','$direccion','$colonia','$ciudad','$cp','$tel_campo','$email','SANTANDER','$servicio','$odt','$altura')";



			$inDatos = $conexion->query($sql);

			$inDatos = $conexion->query($sql1);

		}

		unlink($destino);

		header('location: pdf_creator.php');

	}

}
else{

	echo 'NO HAY ARCHIVOS SELECCIONADOS, ELIGE UN FICHERO';

}



?>