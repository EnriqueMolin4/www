<?php 

include '../modelos/api_db.php'; 

//$eventoId = $_POST['eventoId'];
$noserie = trim(str_replace('-','',$_POST['noserie']));
$tecnico = $_POST['tecnico'];
$tipo = $_POST['tipo'];
$afiliacion = $_POST['afiliacion'];
$servicio = $_POST['servicio'];
$txt = '';
$estatus = 1;
$estatusTPV = 0;
$fecha = date("Y-m-d H:i:s");
$cve = $Api->getDefaultBancoCve();

file_put_contents("json/search_tpv_".$afiliacion.".json",$tecnico."--".$noserie."--".$tipo."--".$afiliacion."--".$servicio);

$comercioId = $Api->getComercioId($afiliacion);
$resultado = $Api->existTPVInventarioTecnico($tecnico,$noserie);
$buscarUniversoElavon = $Api->searchItemElavon($noserie,1);


	if(!is_null($resultado[0])) {
		
		$estatusTPV = $resultado[0]['estatus'];

		if( $resultado[0]['id_ubicacion'] == $tecnico) {


			if( $resultado[0]['estatus'] == '6'  || $resultado[0]['estatus'] == '7' || $resultado[0]['estatus'] == '8'  || $resultado[0]['estatus'] == '16' || $resultado[0]['estatus'] == '17' ) {
				
				$txt .= 'No se puede usar el TPV favor de comunicarse con el Supervidor';
				$estatus = 0;

				//Si el eSttus es Quebranto,
				
			} else if( $resultado[0]['estatus'] == '13'  ) {
				$txt .= 'El TPV ya esta instalado favor de comunicarse con el Supervisor';
				$estatus = 0;
			} else if ( $resultado[0]['estatus'] == '3' || $resultado[0]['estatus'] == '5' ) {
				$txt .= 'El TPV esta disponible ';
				
			} 
			
		} else if( $resultado[0]['id_ubicacion'] == $comercioId ) {
			
			
			$txt .= 'El TPV ya esta instalado en el Cliente ';
			$estatus = 1;
			

		} else if( $resultado[0]['id_ubicacion'] != "0" && $resultado[0]['ubicacion'] != '1' ) {

			$txt .= 'El TPV ya esta instalado con otro cliente favor de comunicarse con el Supervisor';
			$estatus = 0;
		
		} else {

			if(is_null($buscarUniversoElavon[0])) {

				$txt .= 'El TPV no es del banco favor de comunicarse con el Supervisor';
                $estatus = 0;
				$simCompleto = 'NO LEGIBLE';
				
			} else {

				$estatusTPV = $buscarUniversoElavon[0]['estatus'];

				if( $buscarUniversoElavon[0]['estatus_modelo'] == '3' ) {
                    $txt .= 'El TPV  esta disponible';
                    $estatus = 1;

                } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '17'   ) {
                    $txt .= "El TPV tiene estatus DESTRUIDA ¡NO INSTALAR! favor de comunicarse con el Supervisor";
                    $estatus = 0;
                    $simCompleto = 'NO LEGIBLE';

                } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '16'   ) {
                    $txt .= 'El TPV tiene estatus QUEBRANTADA ¡NO INSTALAR! favor de comunicarse con el Supervisor';
                    $estatus = 0;
                    $simCompleto = 'NO LEGIBLE';
				}
				
				
			}

			
		}
	} else {
		
		if($tipo == 'salida') {

			if(is_null($buscarUniversoElavon[0])) {

				$txt .= 'El TPV no es del banco favor de comunicarse con el Supervisor';
				$estatus = 0;
				$simCompleto = 'NO LEGIBLE';
				
			} else {

				$estatusTPV = $buscarUniversoElavon[0]['estatus'];

				if( $buscarUniversoElavon[0]['estatus_modelo'] == '3' ) {
					$txt .= 'El TPV  esta disponible';
					$estatus = 1;

				} else if( $buscarUniversoElavon[0]['estatus_modelo'] == '17'   ) {
					$txt .= "El TPV tiene estatus DESTRUIDA ¡NO INSTALAR! favor de comunicarse con el Supervisor";
					$estatus = 0;
					$simCompleto = 'NO LEGIBLE';

				} else if( $buscarUniversoElavon[0]['estatus_modelo'] == '16'   ) {
					$txt .= 'El TPV tiene estatus QUEBRANTADA ¡NO INSTALAR! favor de comunicarse con el Supervisor';
					$estatus = 0;
					$simCompleto = 'NO LEGIBLE';
				}

				if( $buscarUniversoElavon[0]['estatus_modelo'] == '16'  || $buscarUniversoElavon[0]['estatus_modelo'] == '17'  ) {

					$newGuia = $Api->getLastTraspasoId();
					$Guia = str_pad($newGuia, 12, '0', STR_PAD_LEFT);

					$datafieldsInventarios = array('tipo','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
		
					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
					$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
		
					$arrayString = array (
						1,
						$noserie,
						0,
						$buscarUniversoElavon[0]['estatus_modelo'],
						3,
						1,
						9,
						$tecnico,
						$tecnico,
						$fecha,
						$fecha,
						$fecha,
						$cve 
					);

					$existeInventarioId = $Api->insert($sql,$arrayString);

					$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');

					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

					$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
					$arrayString = array (
						$tecnico,
						$noserie,
						1,
						$Guia,
						1,
						$tecnico,
						$fecha,
						$fecha
					);
					$Api->insert($sql,$arrayString); 

					$prepareStatement = "INSERT INTO `historial`
						( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
						VALUES
						(?,?,?,?,?,?,?,?);
					";
					$arrayString = array (
							$existeInventarioId,
							$fecha,
							'RETIRADO',
							9,
							$noserie,
							1,
							1,
							$tecnico
					);

					$Api->insert($prepareStatement,$arrayString);

				}

				
				
				
			}
		} else {

			//if($servicio == '5' || $servicio == '7' ) {

				$datafieldsInventarios = array('tipo','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
		
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
				$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
	
				$arrayString = array (
					1,
					$noserie,
					0,
					$buscarUniversoElavon[0]['estatus_modelo'],
					4,
					1,
					2,
					$comercioId,
					$comercioId,
					$fecha,
					$fecha,
					$fecha,
					$cve 
				);

				$existeInventarioId = $Api->insert($sql,$arrayString);

				$prepareStatement = "INSERT INTO `historial`
						( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
						VALUES
						(?,?,?,?,?,?,?,?);
					";
				$arrayString = array (
						$existeInventarioId,
						$fecha,
						'EN CLIENTE',
						2,
						$noserie,
						1,
						1,
						$comercioId
				);

				$Api->insert($prepareStatement,$arrayString);

				$txt .= 'El TPV es Valido';
				$estatus = 1;
				$estatusTPV = $buscarUniversoElavon[0]['estatus'];



			/*} else {
				$txt .= 'El TPV tiene conflicto contacte al Supervisor 1';
				$estatus = 0;
				$estatusTPV = 'NO LEGIBLE';
			} */
		}
	}



$result = json_encode(['estatus' => $estatus,'txt' => $txt,'tpv' =>$tipo,'estatusTPV' => $estatusTPV, 'comercio' => $comercioId, 'idubicacion' => $resultado[0]['id_ubicacion'] ]);


echo $result;

?>