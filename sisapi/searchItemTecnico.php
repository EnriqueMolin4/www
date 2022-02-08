<?php 

include '../modelos/api_db.php';


    $connection = $db->getConnection ( 'dsd' );

    $tecnico = $_POST['tecnico'];
    $noserie = preg_replace( "/\r|\n/", "",str_replace('-','',$_POST['noserie'])); 
    $fecha = date ( 'Y-m-d H:m:s' );
    $cve = $Api->getDefaultBancoCve();
	$buscarUniversoElavon = $Api->searchItemElavonAPP($noserie,1);
	$configuracion = $Api->getConfiguration('ValidarInventarioLocal');
	$tecnicoData = $Api->getTecnicoInfo($tecnico);
	if( strlen($noserie) > 0 ) {
		file_put_contents("json/search_tpv_".$noserie."_".$fecha.".json",$tecnico."--".$noserie);

		if($configuracion['valor_numerico'] == '1') {
			
            $existItem = $Api->existItemInventario($noserie);
            file_put_contents("search_tpvDemo.json",json_encode($existItem));
            if($existItem) {

                //$sql = " UPDATE eventos SET latitud=?,longitud=?,hora_llegada=?,fecha_atencion=?  WHERE id=?";
                //$Api->insert($sql,  array($latitud,$longitud,$horaentrada,$fecha,$exist));
                if($existItem['id_ubicacion'] == $tecnico ) {
                    $resultado =  ['status' => 1,'id' => $existItem['id']  , 'error' => 'Ya lo tienes asignado en tu inventario', 'tecnico' => $tecnico,'existe' => $existItem['id_ubicacion']  ];
                } else {
					if($existItem['id_ubicacion'] == $tecnicoData['almacen']) {
						 $sql = " UPDATE inventario  SET ubicacion=?,id_ubicacion=?,estatus_inventario=?,fecha_edicion=?   WHERE id=?";
						$Api->insert($sql,  array(9,$tecnico,3,$fecha,$existItem['id']));
						
						$prepareStatement = "INSERT INTO `inventario_tecnico`
						( `tecnico`,`no_serie`,`cantidad`,`aceptada`,`creado_por`,`fecha_creacion`,`fecha_modificacion`)
						VALUES
						(?,?,?,?,?,?,?);
						";
								
                        $newInvT = $Api->insert($prepareStatement,  array($tecnico,$noserie,1,1,$tecnico,$fecha,$fecha)); 
                        
                        $prepareStatement = "INSERT INTO `historial`
                            ( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
                            VALUES
                            (?,?,?,?,?,?,?,?);
                        ";
                        $arrayString = array (
                                $newInvT,
                                $fecha,
                                'INV TECNICO',
                                9,
                                $noserie,
                                $existItem['tipo'],
                                1,
                                $tecnico
                        );

                        $Api->insert($prepareStatement,$arrayString); 
					
						$resultado =  ['status' => 1,'id' => $existItem['id']  , 'error' => 'La terminal se asigno a tu inventario', 'tecnico' => $tecnico,'existe' => $existItem['id_ubicacion']  ];
					} else {
						$resultado =  ['status' => 0,'id' => $existItem['id']  , 'error' => 'La terminal ya esta asignada a otro Tecnico', 'tecnico' => $tecnico,'existe' => $existItem['id_ubicacion']  ];
					}
                }

            }  else {

                $resultado =  ['status' => 1, 'id' => 0 , 'tecnico' => $tecnico, 'existe' => 0 , 'error' => 'No la Encuentra en el inventario'];
 
            }
		} else {
			
			if($buscarUniversoElavon){
				
				$itemAsignado = $Api->existItemInventarioAsignado($noserie,9);

				if($itemAsignado) 
				{
					$resultado =  ['status' => 1,'id' => 0  , 'tecnico' => $tecnico, 'existe' => $tecnico , 'error' => 'La serie la tiene asignada otro Tecnico \n comunicarse con Adminsitracion' ];
				} else {

					$existItem = $Api->existInsumoInventario($tecnico,$noserie);
			
					 if($existItem) {
						 
						  $resultado =  ['status' => 1,'id' => $existItem['id']  , 'error' => 'Ya lo tienes asignado en tu inventario', 'tecnico' => $tecnico,'existe' => $existItem['id_ubicacion']  ];
						  
					 } else {
							$existeInvGeneral = $Api->existItemInventario($noserie);
							
							if($existeInvGeneral) {
								
								$queryTVP = " UPDATE inventario SET estatus_inventario=?,ubicacion=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
								$Api->insert($queryTVP,array(3,9,$tecnico,$fecha,$noserie));
								$existeInventarioId= 1;
								
							} else {
								$cve = $Api->getDefaultBancoCve();
								$datafieldsInventarios = array('tipo','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
							
								$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
								$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 

								$arrayString = array (
									$buscarUniversoElavon[0]['tipo'],
									$noserie,
									0,
									3,
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
							} 
							
							if($existeInventarioId ) {
							
								$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','aceptada','creado_por','fecha_creacion','fecha_modificacion');

								$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

								$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
								$arrayString = array (
									$tecnico,
									$noserie,
									1,
									1,
									$tecnico,
									$fecha,
									$fecha
								);
								
								$Api->insert($sql,$arrayString); 

								$prepareStatement = "INSERT INTO `historial`
									( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
									VALUES
									(?,?,?,?,?,?,?,?,?);
								";
								
								$arrayString = array (
										$existeInventarioId,
										$fecha,
										'ENTRADA',
										9,
										$noserie,
										1,
										1,
										$tecnico,
										$tecnico
								);

								$Api->insert($prepareStatement,$arrayString);
								
								 $resultado =  ['status' => 1, 'id' => 0 , 'tecnico' => $tecnico, 'existe' => $tecnico , 'error' => 'Se agrego al Inventario'];
							} else {
								$resultado =  ['status' => 0, 'id' => 0 , 'tecnico' => $tecnico, 'existe' => $tecnico , 'error' => 'No Existe en Elavon Universo'];
							}
					 }

				}  
			} else {
				$resultado =  ['status' => 1,'id' => 0  , 'tecnico' => $tecnico, 'existe' => $tecnico , 'error' => 'No existe en Elavon Universo','existeElavon' => $buscarUniversoElavon ];
			}
			
		}
            
	} else {
		$resultado =  ['status' => 1,'id' => 0  , 'tecnico' => $tecnico, 'existe' => $tecnico , 'error' => 'Favor de Capturar la serie,sim ' ];
	}

    echo json_encode($resultado);

?>