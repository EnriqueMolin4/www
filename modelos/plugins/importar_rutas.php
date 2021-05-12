<?php
include "../conexion.php";


	$archivo = $_FILES['excel']['name'];
	!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = 2;

	if(!empty($archivo)){
		if(!(copy($_FILES['excel']['tmp_name'], $archivo))){
			echo 'ERROR AL CARGAR ARCHIVO';
		}

		if(file_exists($archivo)){

			include "Classes/PHPExcel.php";
			include "Classes/PHPExcel/Reader/Excel2007.php";

			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load($archivo);
			$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
			$dimension = $objWorkSheet->getHighestRow();

			for($i = $desde; $i <= $dimension; $i++){

				$_DATOS_EXCEL[$i]['odt'] = 
				$objPHPExcel->getActiveSheet()->getCell("A".$i)->getCalculatedValue();

				$objPHPExcel->getActiveSheet()->getCell("R".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['ticket'] = 
				$objPHPExcel->getActiveSheet()->getCell("B".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['descripcion'] = 
				$objPHPExcel->getActiveSheet()->getCell("K".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['telefono'] = 
				$objPHPExcel->getActiveSheet()->getCell("M".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['tipo_servicio'] = 
				$objPHPExcel->getActiveSheet()->getCell("P".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['sub_tipo'] = 
				$objPHPExcel->getActiveSheet()->getCell("Q".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['id_equipo'] = 
				$objPHPExcel->getActiveSheet()->getCell("AC".$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['afiliacion_amex'] = 
				$objPHPExcel->getActiveSheet()->getCell("AM".$i)->getCalculatedValue();

				$odt_trim = utf8_decode($_DATOS_EXCEL[$i]['odt']);
				$odt = trim($odt_trim);
				$ticket = utf8_decode($_DATOS_EXCEL[$i]['ticket']);
				$descrip = utf8_decode($_DATOS_EXCEL[$i]['descripcion']);
				$telefono = utf8_decode($_DATOS_EXCEL[$i]['telefono']);
				$tipo_servicio = utf8_decode($_DATOS_EXCEL[$i]['tipo_servicio']);
				$id_equipo = utf8_decode($_DATOS_EXCEL[$i]['id_equipo']);
				$sub_tipo = utf8_decode($_DATOS_EXCEL[$i]['sub_tipo']);
				$afiliacion_amex = utf8_decode($_DATOS_EXCEL[$i]['afiliacion_amex']);
				$descripcion = str_replace(',',' ', $descrip);

				$sql_odt_existe = "SELECT * from `rutas` where odt = '$odt'";
				$odt_existente = $conexion->query($sql_odt_existe);
				$num = mysqli_num_rows($odt_existente);

				$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    			$modificadas = 'AAAAAAACEEEEIIIIdNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    			$descripcion = strtr($descripcion, utf8_decode($originales), $modificadas);

    			$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    			$modificadas = 'AAAAAAACEEEEIIIIdNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    			$sub_tipo = strtr($sub_tipo, utf8_decode($originales), $modificadas);

    			$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    			$modificadas = 'AAAAAAACEEEEIIIIdNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    			$tipo_servicio = strtr($tipo_servicio, utf8_decode($originales), $modificadas);
    			
				if($num == 0){
				$sql = "INSERT INTO `rutas` (`odt`, `ticket`, `descripcion`, `telefono`, `tipo_servicio`, `id_equipo`, `sub_tipo`, `afiliacion_amex`) VALUES ('$odt', '$ticket', '$descripcion', '$telefono', '$tipo_servicio', '$id_equipo', '$sub_tipo', '$afiliacion_amex')";
				$con = $conexion->query($sql);
				}
				// else{
				// 	echo $i.'.-Existe la odt: '.$odt.'<br>';
				// }
			}
			unlink($archivo);
	}
	else{
		echo 'NO HAY ARCHIVOS SELECCIONADOS, ELIGE UN FICHERO';
	}
}
else{
	echo 'NECESITAS IMPORTAR EL ARCHIVO';
}
header('location: pdf_servicios.php');
?>