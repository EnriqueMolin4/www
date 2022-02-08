<?php 
include '../modelos/api_db.php';

	$result = json_encode($_POST);

    $odt = trim($_POST['odt']);
	
	//Save odt
	file_put_contents("json/insert_$odt.json",$result);
	
    $afiliacion = trim($_POST['afiliacion']);
    $hoy = strtotime("now");
	$fecha = date ('Y-m-d H:i:s',$hoy );
	$tipoServicio = $Api->getServicioIdOdt($odt);
	
    $tecnico = $_POST['userid'];
   // $realImage = $_FILES['photo']['tmp_name'];
    $fileName = isset($_POST['name']) ? $_POST['name'] : '';
    $comentarios = $_POST['comentarios'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $cve_banco = $_POST['cve_banco'];
    $tpv_retirado = !strlen( str_replace('-','',$_POST['tvpsalida']) ) ? null : str_replace('-','',$_POST['tvpsalida']); 
    $tvp_instalado = !strlen( str_replace('-','',$_POST['tvpentrada']) ) ? null : str_replace('-','',$_POST['tvpentrada']) ;  
	$tvp_instalado = $tvp_instalado == '0' ? null : $tvp_instalado;
    $servicio = 23;
    $subservicio = 69;
    $estatus = 10; //$_POST['estatus'];
    
    $sim_entradaIn = !strlen( $_POST['simentrada'] ) ? null : $_POST['simentrada'];
	$sim_entrada = $sim_entradaIn == "No Legible" ? "ILEGIBLE" : $sim_entradaIn;
    $sim_salidaIn = !strlen( $_POST['simsalida'] ) ? null : $_POST['simsalida'];
	$sim_salida = $sim_salidaIn == "No Legible" ? "ILEGIBLE" : $sim_salidaIn;
    $rollos_entregados = (int) $_POST['rollosentrega'];
    $rollos_instalar = (int) $_POST['rollosinstalar'];
    $receptor_servicio = $_POST['atendio'];
    $hora_salida = date('H:i:s', $hoy);
	$hora_ticket = date("H:i", strtotime($_POST['horaticket']));
    $folio_telecarga = $_POST['foliotelecarga'];
    $id_caja = $_POST['idcaja'];
    $aplicativo = empty($_POST['aplicativo']) ? 0 : explode('-',$_POST['aplicativo'])[0];
    $version = (int) isset($_POST['version']) ? $_POST['version'] : 0;
	$aplicativo_ret = empty($_POST['aplicativo_ret']) ? 0 : explode('-',$_POST['aplicativo_ret'])[0];
    $version_ret = (int) isset($_POST['version_ret']) ? $_POST['version_ret'] : 0;
	$cargaimg = $_POST['cargaimg'];
	$exist = 0;
	$causacambio = isset($_POST['causacambio']) ? (int) $_POST['causacambio'] : 0 ;
	$causacambio = explode("-",$causacambio)[0]; 
	$simComercio = $_POST['simComercio'];
	$permisos = $Api->getCamposObligatorios($tipoServicio['tipo_servicio']);

	 
    
    
   
        //Existe el Evento
        
            
        $exist = $Api->existEvento($odt,$afiliacion);
		$datosODT = $Api->getEventoDetalle($odt,$tecnico);
		$comercioId = $Api->getComercioId($afiliacion);
		$odtServicioId = $Api->getServicioOdt($odt);
        
		//SI USa el mismo sim se copia al REtirado
		if($exist) {

			
			if($simComercio) {
				$newsim_salida = is_null($sim_salida) ? $sim_entrada : $sim_salida; 
			}			

			if($datosODT[0]['estatus_servicio'] == '16' ) {
				
					$sqlEvento = " UPDATE eventos SET latitud=?,longitud=?,tecnico=?,tpv_retirado=?,tpv_instalado=?,sim_instalado=?,sim_retirado=?,fecha_atencion=?,receptor_servicio=?,rollos_entregados=?,hora_salida=?,comentarios=?,folio_telecarga=?,hora_ticket =?,id_caja=?,aplicativo=?,`version`=?,aplicativo_ret=?,`version_ret`=?,`origen`=?,`causacambio`=?,`modificado_por`=? WHERE id=? ";
					
					$arrayStringEvento = array(
						$latitud,
						$longitud,
						$tecnico,
						$tpv_retirado,
						$tvp_instalado,
						$sim_entrada,
						$newsim_salida,
						$fecha,
						$receptor_servicio,
						$rollos_entregados,
						$hora_salida,
						$comentarios,
						$folio_telecarga,
						$hora_ticket,
						$id_caja,
						$aplicativo,
						$version,
						$aplicativo_ret,
						$version_ret,
						1,
						$causacambio,
						$tecnico,
						$exist
					);
					
					$res = $Api->insert($sqlEvento,$arrayStringEvento );
					 
					
			} else {
				$exist = 0;
				$msg .= 'El Evento ya fue cerrado y no puede ser modificado';
			}
					
				

		} else {
			//Grabar Evento  
			$datafields = array('odt','afiliacion','cve_banco','fecha_alta','fecha_atencion','comentarios','tipo_servicio','servicio','tecnico','tpv_retirado','tpv_instalado','receptor_servicio','rollos_entregados','latitud','longitud','hora_salida','origen','causacambio'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

			$sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

			$arrayStringEvento = array (
				$odt ,
				$afiliacion ,
				$cve_banco,
				$fecha, 
				$fecha,
				$comentarios,
				$servicio,
				$subservicio,
				$tecnico,
				$tpv_retirado,
				$tvp_instalado,
				$receptor_servicio,
				$rollos_entrega,
				$latitud,
				$longitud,
				$hora_salida,
				1,
				$causacambio
			);
		
			$exist = $Api->insert($sqlEvento,$arrayStringEvento); 
		}
		
		if($exist != 0) {
			//Grabar Historico Eventos
			 $datafieldsEventos = array('evento_id','fecha_movimiento','estatus_id','odt','modified_by'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafieldsEventos), '?'));
			$sqlHist = "INSERT INTO historial_eventos (" . implode(",", $datafieldsEventos ) . ") VALUES (".$question_marksEvento.")";
			
			$arrayStringHistoria = array(
				$exist,
				$fecha,
				10,
				$odt,
				$tecnico
			);
			
			$Api->insert($sqlHist,$arrayStringHistoria);


			
			//GRabar Geolocalizacion del Comercio
			$queryComercio = " UPDATE comercios SET latitud=?,longitud=?   WHERE afiliacion=? ";
			$Api->insert($queryComercio,array($latitud,$longitud,$afiliacion));
			
			//ACtualizar Inventarios e Historia
			if($tvp_instalado != 'No Legible') {
				 // TVP INSTALADO
				 $queryTVP = " UPDATE inventario SET estatus=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
				 $Api->insert($queryTVP,array(13,4,2,$comercioId,$fecha,$tvp_instalado));
				// TVP INSTALADO QUITAR DEL INV TECNICO
				$queryTVP = " DELETE FROM inventario_tecnico  WHERE no_serie=? AND tecnico=?  ";
				$Api->insert($queryTVP,array($tvp_instalado,$tecnico));
			}
			
			if($tpv_retirado != 'No Legible') {
				// TVP RETIRADO			
				if(!empty($tpv_retirado)) {
					
					$buscarUniversoElavon = $Api->searchItemElavonAPP($tpv_retirado,1);
					
					if($buscarUniversoElavon) {
						$existeTVPInventario = $Api->getInventarioId($tpv_retirado);
					
						if($existeTVPInventario) {
							
						 $queryTVP = " UPDATE inventario SET estatus=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
						 $Api->insert($queryTVP,array(15,3,9,$tecnico,$fecha,$tpv_retirado));
						 
						} else {
							
							$datafieldsInventarios = array('tipo','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
					
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
							$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
				
							$arrayString = array (
								1,
								$tpv_retirado,
								0,
								15,
								3,
								1,
								9,
								$tecnico,
								$tecnico,
								$fecha,
								$fecha,
								$fecha,
								$cve_banco
							);

							$id = $Api->insert($sql,$arrayString);
						}
							// TVP RETIRADO AGREGAR AL INV TECNICO
						$newGuia = $Api->getLastTraspasoId();
						$Guia = str_pad($newGuia, 12, '0', STR_PAD_LEFT);
						
						$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
				
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

						$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
						$arrayString = array (
							$tecnico,
							$tpv_retirado,
							1,
							$Guia,
							1,
							$tecnico,
							$fecha,
							$fecha
						);
						$Api->insert($sql,$arrayString);
					}
				}
				
			}
			
			// SIM INSTALADO
			
			$querySim = " UPDATE inventario SET estatus=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
			$Api->insert($querySim,array(13,4,2,$comercioId,$fecha,$sim_entrada));
			// SIM  INSTALADO QUITAR DEL INV TECNICO
			$querySIM = " DELETE FROM inventario_tecnico  WHERE no_serie=? AND tecnico=? ";
			$Api->insert($querySIM,array($sim_entrada,$tecnico));
			
			// SIM RETIRADO	
			if(!empty($sim_salida)) {
				$existeTVPInventario = $Api->getInventarioId($sim_salida);
				
				if($existeTVPInventario) {
					
					 $queryTVP = " UPDATE inventario SET estatus=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
					 $Api->insert($queryTVP,array(15,3,9,$tecnico,$fecha,$sim_salida));
				} else {
					$datafieldsInventarios = array('tipo','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
			
					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
					$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
		
					$arrayString = array (
						2,
						$sim_salida,
						0,
						15,
						3,
						1,
						9,
						$tecnico,
						$tecnico,
						$fecha,
						$fecha,
						$fecha,
						$cve_banco 
					);

					$id = $Api->insert($sql,$arrayString);
				}
				// SIM RETIRADO AGREGAR AL INV TECNICO
				$newGuia = $Api->getLastTraspasoId();
				$Guia = str_pad($newGuia, 12, '0', STR_PAD_LEFT);
				
				$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');

				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

				$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
				$arrayString = array (
					$tecnico,
					$sim_salida,
					1,
					$Guia,
					1,
					$tecnico,
					$fecha,
					$fecha
				);
				$Api->insert($sql,$arrayString); 
			}
			
			if( $rollos_entregados > 0  && $datosODT[0]['estatus'] == '20' ) {

				//Actualizar Rollos 
				$invenInsumo = $Api->getInsumos('ROLS',$tecnico);
				$InsumoActual = max((int) $invenInsumo['cantidad'] - (int) $rollos_entregados,0);

				$queryRollos = " UPDATE inventario_tecnico SET cantidad=?,fecha_modificacion=? WHERE id =?";
				$Api->insert($queryRollos,array($InsumoActual,$fecha,$invenInsumo['id']));
				
					
				$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
					VALUES
					(?,?,?,?,?,?,?,?,?);
				";
				$arrayString = array (
						$invenInsumo['id'],
						$fecha,
						'RETIRADO',
						9,
						'ROLS',
						3,
						$rollos_entregados,
						$tecnico,
						$tecnico
				);

				$Api->insert($prepareStatement,$arrayString);
			}


			if(!empty($tvp_instalado)) {
				//Historia TVP Instalado
				if($tvp_instalado != 'No Legible') {
					
					$existeInventarioId = $Api->getInventarioId($tvp_instalado);
					
					$prepareStatement = "INSERT INTO `historial`
						( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
						VALUES
						(?,?,?,?,?,?,?,?,?);
					";
					$arrayString = array (
							$existeInventarioId,
							$fecha,
							'INSTALADO',
							2,
							$tvp_instalado,
							1,
							1,
							$comercioId,
							$tecnico
					);

					$Api->insert($prepareStatement,$arrayString);
				}
			}
			
			if(!empty($sim_entrada)) {
				$existeInventarioId = $Api->getInventarioId($sim_entrada);
				//Historia SIM Instalado
				if($existeInventarioId) {
					$existeInventarioId=0;
				}
				
				$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
					VALUES
					(?,?,?,?,?,?,?,?,?);
				";
				$arrayString = array (
						$existeInventarioId,
						$fecha,
						'INSTALADO',
						2,
						$sim_entrada,
						2,
						1,
						$comercioId,
						$tecnico
				);

				$Api->insert($prepareStatement,$arrayString);
			}
			
			if(!empty($tpv_retirado)) {
				//RETIRADO
				if($tpv_retirado != 'No Legible') {
					
					$existeInventarioId = $Api->getInventarioId($tpv_retirado);
					//Historia TVP Retirado
					$prepareStatement = "INSERT INTO `historial`
						( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
						VALUES
						(?,?,?,?,?,?,?,?,?);
					";
					$arrayString = array (
							$existeInventarioId,
							$fecha,
							'RETIRADO',
							9,
							$tpv_retirado,
							1,
							1,
							$tecnico,
							$tecnico
					);

					$Api->insert($prepareStatement,$arrayString);
				}
			}
			
			if(!empty($sim_retirado)) {
				$existeInventarioId = $Api->getInventarioId($sim_retirado);
				//Historia SIM Retirado
				$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
					VALUES
					(?,?,?,?,?,?,?,?,?);
				";
				$arrayString = array (
						$existeInventarioId,
						$fecha,
						'RETIRADO',
						9,
						$sim_retirado,
						2,
						1,
						$tecnico,
						$tecnico
				);

				$Api->insert($prepareStatement,$arrayString);
			}
			
			$resultado =  ['status' => 1, 'error' => "Se Cargo Correctamente la Informacion ", 'odt' => $odt, 'afiliacion' => $afiliacion,'data' => $arrayStringEvento, 'exist' => $res];
		
		} else {
			$resultado =  ['status' => 0, 'error' => "Hubo un error en la carga volver a intentar \n ".$msg, 'odt' => $odt, 'afiliacion' => $afiliacion, 'msg' => $datosODT ];
		}
		
        echo json_encode($resultado);

?>