<?php
include '../conexion.php';
$archivo = $_FILES['excel_cp_santd']['name'];
$destino = 'bak_'.$archivo;
!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = 2;
if(!empty($archivo)){
	if(copy($_FILES['excel_cp_santd']['tmp_name'], $destino)){
		echo 'ARCHIVO CARGADO CON EXITO, IMPRIMA EXCEL ';
	}
	else{
		echo 'ERROR AL CARGAR ARCHIVO';
	}
	if(file_exists('bak_'.$archivo)){

		require_once ("Classes/PHPExcel.php");
		require_once ("Classes/PHPExcel/Reader/Excel2007.php");
		
		$objReader = new PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load('bak_'.$archivo);

		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

		$dimension = $objWorkSheet->getHighestRow();


		for($i = 2; $i <= $dimension; $i++){
			$cpEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();

			$cveEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

			$territorial_bancoEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

			$territorial_sinttecomEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

			$tiempo_atencionEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

			$ciudadEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

			$estadoEx[$i] = 
			$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		}

		for($i = 2; $i <= $dimension; $i++){
			$cp = trim($cpEx[$i]);
			$cve = trim($cveEx[$i]);
			$territorial_banco = trim($territorial_bancoEx[$i]);
			$territorial_sinttecom = trim($territorial_sinttecomEx[$i]);
			$tiempo_atencion = trim($tiempo_atencionEx[$i]);
			$ciudad = trim($ciudadEx[$i]);
			$estado = trim($estadoEx[$i]);
			$cp = strtoupper($cp);
			$cve = strtoupper($cve);
			$territorial_banco = strtoupper($territorial_banco);
			$territorial_sinttecom = strtoupper($territorial_sinttecom);
			$tiempo_atencion = strtoupper($tiempo_atencion);
			$ciudad = strtoupper($ciudad);
			$estado = strtoupper($estado);
			$sql = "INSERT INTO `cp_santander`(`cp`, `cve`, `territorial_banco`, `territorial_sinttecom`, `ciudad`, `estado`, `tiempo_atencion`) 
			VALUES ('$cp','$cve','$territorial_banco','$territorial_sinttecom','$ciudad','$estado','$tiempo_atencion')";
			$inDatos = $conexion->query($sql);
			var_dump($inDatos);
			var_dump($sql);
		}
		unlink('bak_'.$archivo);
	}
}
else{
	echo 'NO HAY ARCHIVOS SELECCIONADOS, ELIGE UN FICHERO';
}

?>