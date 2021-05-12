<?php
ini_set("memory_limit","512M");
ini_set('max_execution_time',6000);

// include '../conexion.php';
// date_default_timezone_set('America/Mexico_City');
// $fecha_alta = date("Y-m-d H:i:s");

// if(!empty($_FILES)){
// 	$archivo = $_FILES['archvio']['name'];
// 	$destino = 'bak_'.$archivo;
// 	!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = 2;
// 	if(copy($_FILES['archvio']['tmp_name'], $destino)){
// 		echo 'se cop'
// 	}
// 	else{
// 		echo '0';
// 	}
// 	if(file_exists('bak_'.$archivo)){

// 		include 'Classes/PHPExcel/IOFactory.php';
// 		include "Classes/PHPExcel.php";
// 		include "Classes/PHPExcel/Reader/Excel2007.php";
		
// 		$objReader = PHPExcel_IOFactory::createReader('Excel2007');

// 		$objPHPExcel = $objReader->load('bak_'.$archivo);

// 		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

// 		$dimension = $objWorkSheet->getHighestRow();

// 		for($i = $desde; $i <= $dimension; $i++){
// 			$odtEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();

// 			$comercioEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

// 			$afiliacionEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

// 			$direccionEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

// 			$coloniaEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

// 			$ciudadEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

// 			$estadoEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

// 			$cpEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();

// 			$telEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

// 			$descripcionEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();

// 			$servicioEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();

// 			$ejecutivo_callcenterEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
// 			// $tel_campoEx[$i] = str_replace(',',' ', $tel_campoEx[$i]);

// 			$fecha_vencimientoEx[$i] = 
// 			$objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
// 		}

// 		$acierto = 0;
// 		for($i = $desde; $i <= $dimension; $i++){
// 			$odt 	   = trim($odtEx[$i]);	     $odt       = strtoupper($odt);
// 			$comercio  = trim($comercioEx[$i]);	 $comercio  = strtoupper($comercio);
// 			$afiliacion= trim($afiliacionEx[$i]);$afiliacion= strtoupper($afiliacion);
// 			$direccion = trim($direccionEx[$i]); $direccion = strtoupper($direccion);
// 			$colonia   = trim($coloniaEx[$i]);	 $colonia   = strtoupper($colonia);
// 			$ciudad    = trim($ciudadEx[$i]);	 $ciudad    = strtoupper($ciudad);
// 			$estado    = trim($estadoEx[$i]);	 $estado    = strtoupper($estado);
// 			$cp        = trim($cpEx[$i]);	     $cp        = strtoupper($cp);
// 			$tel       = trim($telEx[$i]);	     $tel       = strtoupper($tel);
// 			$servicio = trim($servicioEx[$i]);	$servicio = strtoupper($servicio);
// 			$descripcion = trim($descripcionEx[$i]);	$descripcion = strtoupper($descripcion);
// 			$descripcion = str_replace(',',' ', $descripcion);
// 			$ejecutivo_callcenter = trim($ejecutivo_callcenterEx[$i]);	$ejecutivo_callcenter = strtoupper($ejecutivo_callcenter);
// 			$fecha_vencimiento = $fecha_vencimientoEx[$i];

// 			$con = $conexion->query("SELECT * from `eventos` where odt = '$odt'");
// 			$num = mysqli_num_rows($con);

// 			if($num == 0){
// 				$arr_fecha = explode(" ", $fecha_vencimiento);
// 				$fecha = $arr_fecha[0];
// 				$sub_fecha = explode("/", $fecha);
// 				$fecha_vencimiento = $sub_fecha[0].'-'.$sub_fecha[1].'-'.$sub_fecha[0].' '.$arr_fecha[1];

// 				$select = $conexion->query("SELECT * from `cp_santander` where cp = '$cp'");
// 				$dato = mysqli_fetch_array($select);
				
// 				$cve_cp = $dato['cve'];
// 				$territorial_banco_cp = $dato['territorial_banco'];
// 				$territorial_sinttecom_cp = $dato['territorial_sinttecom'];
// 				$ciudad_cp = $dato['ciudad'];
// 				$estado_cp = $dato['estado'];
// 				$tiempo_atencion_cp = $dato['tiempo_atencion'];
// 				$tiempo_atencion_cp == '12' ? $atencion = 'NORMAL' : $atencion = 'VIP';

// 				$select = $conexion->query("SELECT * from `comercios` where afiliacion = '$afiliacion' and cve_banco = '$cve_cp'");
// 				$num = mysqli_num_rows($select);

// 				if($num == 0){
// 					$sql = "INSERT into `comercios` (`comercio`,`afiliacion`,`colonia`,`telefono`,`fecha_alta`,`cve_banco`,`territorial_banco`,`territorial_sinttecom`,`ciudad`,`estado`,`tipo_comercio`) 
// 										  values ('$comercio', '$afiliacion', '$colonia', '$tel', '$fecha_alta', '$cve_cp', '$territorial_banco_cp', '$territorial_sinttecom_cp', '$ciudad_cp', '$estado_cp', '$atencion')";
// 					// echo $sql;
// 	 				$con = $conexion->query($sql);
// 	 				// var_dump($con);
// 	 				if($con){
// 	 					echo '<br><label><center>EL COMERCIO CON AFILIACION "'.$afiliacion.'" SE REGISTRO EXITOSAMENTE</center></label>';
// 	 				}
// 	 				else{
// 	 					echo '<br><label><center>EL COMERCIO CON AFILIACION "'.$afiliacion.'" NO SE REGISTRO, CONTACTE AL ADMINISTRADO</center></label>';
// 	 				}
	 				
// 				}
// 				else{
// 					// echo '<br><label><center>EL COMERCIO CON AFILIACION "'.$afiliacion.'" YA EXISTE EN EL REGISTRO Y NO HAY DATOS POR ACTUALIZAR</center></label>';
// 				}

// 				$con_datos_comercio = $conexion->query("SELECT * from `comercios` where afiliacion = '$afiliacion'");
// 				$datos_comercio = mysqli_fetch_array($con_datos_comercio);

// 				$fecha = date(" Y-m-");
// 				$dia = date("d");
// 				$fecha_alta = date("Y-m-d H:i:s");
// 				$fecha_cierre = '';
// 				date('l')[0] == 'F' ? $viernes = 1 : $viernes = 0;
// 				if(date("H") >= 10){
// 					if($viernes == 1){
// 						if($atencion == 'NOMRAL'){
// 							$fecha_cierre = $fecha.($dia + 3).' 23:59:00';
// 						}
// 						else{
// 							$fecha_cierre = $fecha.($dia + 4).' 23:59:00';
// 						}
// 					}
// 					else{
// 						if($atencion == 'NOMRAL'){
// 							$fecha_cierre = $fecha.($dia + 1).' 23:59:00';
// 						}
// 						else{
// 							$fecha_cierre = $fecha.($dia + 2).' 23:59:00';
// 						}
// 					}
// 				}
// 				else{
// 					if($viernes == 1){
// 						if($atencion == 'NOMRAL'){
// 							$fecha_cierre = $fecha.$dia.' 23:59:00';
// 						}
// 						else{
// 							$fecha_cierre = $fecha.($dia + 3).' 23:59:00';
// 						}
// 					}
// 					else{
// 						if($atencion == 'NOMRAL'){
// 							$fecha_cierre = $fecha.$dia.' 23:59:00';
// 						}
// 						else{
// 							$fecha_cierre = $fecha.($dia + 1).' 23:59:00';
// 						}
// 					}
// 				}

// 				$vencimiento = new DateTime($fecha_vencimiento);
// 				$cierre = new DateTime($fecha_cierre);

// 				if($cierre > $vencimiento){
// 					$fecha_registro = $fecha_cierre;
// 				}
// 				elseif($cierre == $vencimiento){
// 					$fecha_registro = $fecha_cierre;
// 				}
// 				elseif($cierre < $vencimiento){
// 					$fecha_registro = $fecha_vencimiento;
// 				}

// 				$sql = "INSERT into `eventos` (`odt`,`comercio`,`afiliacion`,`direccion`,`colonia`,`municipio`,`estado`,`fecha_cierre`,`telefono`,`descripcion`, `servicio`,`fecha_alta`, `ejecutivo_callcenter`,`estatus`) 
// 				values ('$odt', '$comercio', '$afiliacion', '$direccion', '$colonia', '$ciudad', '$estado','$fecha_registro', '$tel', '$descripcion', '$servicio','$fecha_alta', '$ejecutivo_callcenter','ABIERTO')";
// 				// echo $sql;
// 				$con = $conexion->query($sql);
// 				if($con){
// 					echo '<br><label><center>SE REALIZO EL REGISTRO DEL EVENTO PARA LA "'.$odt.'" CON EXITO</center></label>';
// 				}

// 				if(!$con){
// 					echo '<br><label><center>EL EVENTO CON LA ODT "'.$odt.'" NO SE PUDO REGISTRAR, CONTACTE AL ADMINISTRADOR</center></label>';
// 				}
// 			}
// 			else{
// 				echo '<br><label><center>LA ODT "'.$odt.'" YA ESTA REGISTRADA</center></label>';
// 			}
// 		}
// 		unlink('bak_'.$archivo);
// 	}
// }
// else{
// 	echo '<br><label><center>NO HAZ SELECCIONADO NINGUN ARCHIVO</center></label>';
// }

?>