<?php 

include '../modelos/api_db.php';

	$result = json_encode($_POST);
	
    $odt = trim($_POST['odt']);
	//Save odt
	file_put_contents("json/insert_$odt.json",$result);
	
    $afiliacion = trim($_POST['afiliacion']);
    $fecha = date ( 'Y-m-d H:m:s' );
    $tecnico = $_POST['userid'];
   // $realImage = $_FILES['photo']['tmp_name'];
    $fileName = $_POST['name'];
    $comentarios = $_POST['comentarios'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $cve_banco = $_POST['cve_banco'];
    $tpv_retirado = !strlen( str_replace('-','',$_POST['tvpsalida']) ) ? null : str_replace('-','',$_POST['tvpsalida']); 
    $tvp_instalado = !strlen( str_replace('-','',$_POST['tvpentrada']) ) ? null : str_replace('-','',$_POST['tvpentrada']) ;  
    $servicio = 23;
    $subservicio = 69;
    $estatus = 10; //$_POST['estatus'];
    $fecha = date("Y-m-d H:i:s");
    $sim_entrada = !strlen( $_POST['simentrada'] ) ? null : $_POST['simentrada'];
    $sim_salida = !strlen( $_POST['simsalida'] ) ? null : $_POST['simsalida'];
    $rollos_entregados = $_POST['rollosentrega'];
    $rollos_instalar = $_POST['rollosinstalar'];
    $receptor_servicio = $_POST['atendio'];
    $hora_salida = $_POST['horasalida'];
	$hora_ticket = date("H:i", strtotime($_POST['horaticket']));
    $folio_telecarga = $_POST['foliotelecarga'];
    $id_caja = $_POST['idcaja'];
    $aplicativo = $_POST['aplicativo'];
    $version = $_POST['version'];

    
    
   
        //Existe el Evento
        
            
        $exist = $Api->existEvento($odt,$afiliacion);
        
        
        if($exist) {
            
                $comercioId = $Api->getComercioId($afiliacion);
                
                $query = " UPDATE eventos SET latitud=?,longitud=?,tecnico=?,tpv_retirado=?,tpv_instalado=?,estatus=?,sim_instalado=?,sim_retirado=?,fecha_atencion=?,receptor_servicio=?,rollos_entregados=?,hora_salida=?,comentarios=?,folio_telecarga=?,hora_ticket =?,id_caja=?,aplicativo=?,`version`=? WHERE id=? ";
                $Api->insert($query,array($latitud,$longitud,$tecnico,$tpv_retirado,$tvp_instalado,$estatus,$sim_entrada,$sim_salida,$fecha,$receptor_servicio,$rollos_entregados,$hora_salida,$comentarios,$folio_telecarga,$hora_ticket,$id_caja,$aplicativo,$version,$exist) );


        } else {
            //Grabar Evento 
            $datafields = array('odt','afiliacion','cve_banco','fecha_alta','fecha_atencion','comentarios','tipo_servicio','servicio','estatus','tecnico','tpv_retirado','tpv_instalado','receptor_servicio','rollos_entregados','latitud','longitud','hora_salida'); 

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
                $estatus,
                $tecnico,
                $tpv_retirado,
                $tvp_instalado,
                $receptor_servicio,
                $rollos_entrega,
                $latitud,
                $longitud,
				$hora_salida
            );
        
            $Api->insert($prepareStatement,$arrayString); 
        }

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
		
		//Actualizar Rollos 
		$invenInsumo = $Api->getInsumos('ROLS',$tecnico);
		$InsumoActual = max((int) $invenInsumo['cantidad'] - (int) $rollos_entregados,0);

		$queryRollos = " UPDATE inventario_tecnico SET cantidad=?,fecha_modificacion=? WHERE id =?";
		$Api->insert($queryRollos,array($InsumoActual,$fecha,$invenInsumo['id']));


		if(!empty($tvp_instalado)) {
			//Historia TVP Instalado
			if($tvp_instalado != 'No Legible') {
				
				$existeInventarioId = $Api->getInventarioId($tvp_instalado);
				
				$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
				$arrayString = array (
						$existeInventarioId,
						$fecha,
						'INSTALADO',
						2,
						$tvp_instalado,
						1,
						0,
						$comercioId
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
				( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
				VALUES
				(?,?,?,?,?,?,?,?);
			";
			$arrayString = array (
					$existeInventarioId,
					$fecha,
					'INSTALADO',
					2,
					$sim_entrada,
					2,
					0,
					$comercioId
			);

			$Api->insert($prepareStatement,$arrayString);
		}
		
		if(!empty($tpv_retirado)) {
			//RETIRADO
			if($tpv_retirado != 'No Legible') {
				
				$existeInventarioId = $Api->getInventarioId($tpv_retirado);
				//Historia TVP Retirado
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
						$tpv_retirado,
						1,
						1,
						$tecnico
				);

				$Api->insert($prepareStatement,$arrayString);
			}
		}
		
		if(!empty($sim_retirado)) {
			$existeInventarioId = $Api->getInventarioId($sim_retirado);
			//Historia SIM Retirado
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
					$sim_retirado,
					2,
					1,
					$tecnico
			);

			$Api->insert($prepareStatement,$arrayString);
		}
        
        $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Informacion', 'odt' => $odt, 'afiliacion' => $afiliacion  ];
    
        echo json_encode($resultado);

?>