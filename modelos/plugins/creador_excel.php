<?php

include '../conexion.php';
include 'Classes/PHPExcel.php';
include 'Classes/PHPExcel/Writer/Excel2007.php';

$objPHPExcel = new PHPExcel();

if($_POST['t_reporte'] == 'COMERCIOS' OR $_POST['t_reporte'] == 'EVENTOS' OR $_POST['t_reporte'] == 'INVENTARIOS'){
	$error = 0;
	
	$objPHPExcel->getProperties()->setCreator("SINTTECOM");
	$objPHPExcel->getProperties()->setLastModifiedBy("SINTTECOM");
	$objPHPExcel->getProperties()->setTitle("REPORTERIA SINTTECOM DE ".$_POST['t_reporte']);
	$objPHPExcel->getProperties()->setSubject("REPORTES");
	$objPHPExcel->getProperties()->setDescription("CONJUNTO DE INFORMACION IMPRESA SINTTECOM");

	$objPHPExcel->setActiveSheetIndex(0);

	if($_POST['t_reporte'] == 'EVENTOS'){
		$tabla = 'eventos';
		$sql = "SELECT * from `eventos`";

		if($_POST['estatus'] != 'SELECCIONA'){
			if($sql == "SELECT * from `eventos`"){
				$sql .= " where estatus = '$_POST[estatus]'";
			}else{
				$sql .= " and estatus = '$_POST[estatus]'";
			}
		}
		if($_POST['estatus_cierre'] != 'SELECCIONA'){
			if($sql == "SELECT * from `eventos`"){
				$sql .= " where estatus_servicio = '$_POST[estatus_cierre]'";
			}else{
				$sql .= " and estatus_servicio  = '$_POST[estatus_cierre]'";
			}
		}
		if($_POST['tecnico'] != 'SELECCIONA'){
			$con_tec = $conexion->query("SELECT * from `tecnicos` where nombre = '$_POST[tecnico]'");
			if(mysqli_num_rows($con_tec) > 0){
				$dato = mysqli_fetch_array($con_tec);
				if($sql == "SELECT * from `eventos`"){
					$sql .= " where tecnico = '$dato[nombre]'";
				}else{
					$sql .= " and tecnico = '$dato[nombre]'";
				}
			}
		}
		if($_POST['cve'] != 'SELECCIONA'){
			$con_cve = $conexion->query("SELECT * from `bancos` where banco = '$_POST[cve]'");
			if(mysqli_num_rows($con_cve) > 0){
				$dato = mysqli_fetch_array($con_cve);
				if($sql == "SELECT * from `eventos`"){
					$sql .= " where cve_banco = '$dato[cve]'";
				}else{
					$sql .= " and cve_banco = '$dato[cve]'";
				}
			}
		}
		if(!empty($_POST['fecha_desde']) and !empty($_POST['fecha_hasta'])){
			if($sql == "SELECT * from `eventos`"){
				$sql .= " where fecha_alta >= '$_POST[fecha_desde]' and fecha_alta <= '$_POST[fecha_hasta]'";
			}else{
				$sql .= " and fecha_alta >= '$_POST[fecha_desde]' and fecha_alta <= '$_POST[fecha_hasta]'";	
			}
		}
		if(!empty($_POST['fecha_vencimiento_desde']) and !empty($_POST['fecha_vencimiento_hasta'])){
			if($sql == "SELECT * from `eventos`"){
				$sql .= " where fecha_cierre >= '$_POST[fecha_vencimiento_desde]' and fecha_cierre <= '$_POST[fecha_vencimiento_hasta]'";
			}else{
				$sql .= " and fecha_cierre >= '$_POST[fecha_vencimiento_desde]' and fecha_cierre <= '$_POST[fecha_vencimiento_hasta]'";	
			}
		}
		if(!empty($_POST['fecha_cierre_desde']) and !empty($_POST['fecha_cierre_hasta'])){
			if($sql == "SELECT * from `eventos`"){
				$sql .= " where fecha_alta >= '$_POST[fecha_cierre_desde]' and fecha_alta <= '$_POST[fecha_cierre_hasta]'";
			}else{
				$sql .= " and fecha_alta >= '$_POST[fecha_cierre_desde]' and fecha_alta <= '$_POST[fecha_cierre_hasta]'";	
			}
		}
		
		$con = $conexion->query($sql);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ODT');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'AFILIACION');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TIPO SERVICIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FECHA ALTA');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'FECHA VENCIMIENTO');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'COMERCIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'COLONIA');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'CIUDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ESTADO');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'DIRECCION');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'TELEFONO');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'DESCRIPCION');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'TICKET');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'HORARIO ATENCION');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'HORARIO COMIDA');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'QUIEN ATENDIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'FECHA ATENCION');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'HORA LLEGADA');
		$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'HORA SALIDA');
		$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'TECNICO');
		$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'ESTATUS');
		$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'SERVICIO SOLICITADO');
		$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'SERVICIO FINAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'FECHA ALTA');

		$i = 2;
		if(mysqli_num_rows($con) > 0){
			while($dato = mysqli_fetch_array($con)){
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $dato['odt']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dato['afiliacion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato['tipo_servicio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato['fecha_alta']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato['fecha_cierre']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato['comercio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato['colonia']);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato['ciudad']);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato['estado']);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato['direccion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato['telefono']);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato['descripcion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato['ticket']);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $dato['hora_atencion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $dato['hora_comida']);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $dato['receptor_servicio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $dato['fecha_atencion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $dato['hora_llegada']);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $dato['hora_salida']);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, $dato['tecnico']);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i, $dato['estatus']);
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, $dato['tipo_serv_real']);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, $dato['tipo_servicio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, $dato['fecha_alta']);
				$i++;
			}
		}
		else{
			$error++;
		}
	}
	if($_POST['t_reporte'] == 'INVENTARIOS'){
		$sql0 = "SELECT * from `almacen`";
		$where = " INNER JOIN `modelos` ON `almacen`.`modelo_tpv` = `modelos`.`modelo`";
		$sql1 = "";

		if($_POST['tipo_producto'] != 'SELECCIONA'){
			if(empty($sql1)){
				$sql1 .= " where producto = '$_POST[tipo_producto]'";
			}else{
				$sql1 .= " and producto = '$_POST[tipo_producto]'";	
			}
		}
		if($_POST['ubicacion'] != 'SELECCIONA'){
			if(empty($sql1)){
				$sql1 .= " where tipo_ubicacion = '$_POST[ubicacion]'";
			}else{
				$sql1 .= " and tipo_ubicacion = '$_POST[ubicacion]'";	
			}
		}
		if($_POST['estatus'] != 'SELECCIONA'){
			if(empty($sql1)){
				$sql1 .= " where estatus = '$_POST[estatus]'";
			}else{
				$sql1 .= " and estatus = '$_POST[estatus]'";	
			}
		}
		if($_POST['cliente'] != 'SELECCIONA'){
			$con_cve = $conexion->query("SELECT * from `bancos` where banco = '$_POST[cliente]'");
			if(mysqli_num_rows($con_cve) > 0){
				$dato = mysqli_fetch_array($con_cve);
				if(empty($sql1)){
					$sql1 .= " where cve_banco = '$dato[cve]'";
				}else{
					$sql1 .= " and cve_banco = '$dato[cve]'";	
				}
			}
		}
		if(!empty($_POST['conect'])){
			if(empty($sql1)){
				$sql1 .= " where conectividad = '$_POST[modelo]'";
			}else{
				$sql1 .= " and conectividad = '$_POST[modelo]'";	
			}
		}
		if($_POST['modelo'] != 'SELECCIONA'){
			if(empty($sql1)){
				$sql1 .= " where modelo = '$_POST[modelo]'";
			}else{
				if($sql1 = $where.$sql1)
				$sql1 .= " and modelo = '$_POST[modelo]'";	
			}
		}

		if($_POST['modelo'] == 'SELECCIONA' and empty($_POST['conect'])){
			$sql = $sql0.$sql1;
		}
		else{
			$sql = $sql0.$where.$sql1;
		}

		$tabla = 'almacen';
// echo $sql;
		$con = $conexion->query($sql);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CVE');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'UBICACION');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NO. DE SERIE');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'MODELO');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'CARRIER');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'PRODUCTO');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'INSUMO');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'CANTIDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ESTATUS');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'PROVEEDOR');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'FECHA ALTA');

		$i = 2;
		if(mysqli_num_rows($con) > 0){
			while($dato = mysqli_fetch_array($con)){
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $dato['cve_banco']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dato['ubicacion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato['no_serie']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato['modelo']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato['carrier']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato['producto']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato['insumo']);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato['cantidad']);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato['estatus']);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato['proveedor']);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato['fecha_alta']);
				$i++;
			}
		}
		else{
			$error++;
		}
	}
	if($_POST['t_reporte'] == 'COMERCIOS'){
		$tabla = 'comercio';
		$sql = "SELECT * from `comercios`";
		$con = $conexion->query($sql);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CVE');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'AFILIACION');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'CODIGO POSTAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'COMERCIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ESTADO');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CIUDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'COLONIA');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'DIRECCION');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'PROPIETARIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'RESPONSABLE');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'TIPO COMERCIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'TELEFONO');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'FECHA ALTA');

		$i = 2;
		if(mysqli_num_rows($con) > 0){
			while($dato = mysqli_fetch_array($con)){
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $dato['cve_banco']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dato['afiliacion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato['cp']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato['comercio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato['estado']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato['ciudad']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato['colonia']);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato['direccion']);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato['propietario']);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato['responsable']);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato['tipo_comercio']);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato['telefono']);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato['fecha_alta']);
				$i++;
			}
		}
		else{
			$error++;
		}
	}
}

if($error == 0){
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("R_SINTTECOM_".strtoupper($tabla).".xlsx");

	echo strtoupper($tabla);
}
else{
	echo 'error';
}

//AGREGAR ESTILOS A LA HOJA
// $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(array('font' => array('bold' => true)));
// AGREGAR TITULO
// $objPHPExcel->getActiveSheet()->setTitle('Reporte Enero');
// LINEAS PARA CREAR Y ACTIVAR HOJAS
// $objPHPExcel->createSheet();
// $objPHPExcel->setActiveSheetIndex(1);
?>