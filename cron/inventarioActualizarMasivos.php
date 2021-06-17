<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
include('../modelos/procesos_db.php');

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


$processActive = $Procesos->getCargasEnProceso('IA');

if($processActive) {
    echo " $processActive Hay un proceso Ejecutandose \n ";
} else {
    $proceso = $Procesos->getOlderCargas('IA');

    if($proceso) {
        echo "Buscar Proceso mas Viejo ".$proceso['fecha_creacion'];
        $fecha = date ( 'Y-m-d H:m:s' );
        

        //$eventoMasivo = new CargasMasivas();
        $archivo =  'files/'.$proceso['archivo'];

        $spreadsheet = IOFactory::load($archivo);
        $hojaDeProductos= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        
        $user = $proceso['creado_por'];
        $consecutivo = 1;
        $counter = 0;
        $nocounter = 0;
        $insert_values = array();
        $fecha = date ( 'Y-m-d H:m:s' );
        $serieNoAct = array();
  
        $datosCargar = array();
        $format = "d/m/Y H:i:s";
        $numeroMayorDeFila = count($hojaDeProductos); 
        //Updatw PRoceso en ejecucion
        $sqlEvento = "UPDATE carga_archivos SET  procesar= ?,fecha_modificacion= ?,registros_total=? WHERE id = ?";

        $arrayStringEvento = array (
            1,
            $fecha,
            $numeroMayorDeFila,
            $proceso['id']
        );
        
        $Procesos->insert($sqlEvento,$arrayStringEvento);

        for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
            
            # Las columnas están en este orden:
            # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
            $NoSerie = $hojaDeProductos[$indiceFila]['B'];
            if(!is_null($NoSerie)  ) {
                //$counter++;
                 
                
                $Tipo = $Procesos->getTipo( $hojaDeProductos[$indiceFila]['A'] );
                $Modelo = $hojaDeProductos[$indiceFila]['C'];
                $Conectividad = $hojaDeProductos[$indiceFila]['D'];
                $Estatus = $hojaDeProductos[$indiceFila]['E'];
                $EstatusUbicacion = $hojaDeProductos[$indiceFila]['F'];
                $Ubicacion = $hojaDeProductos[$indiceFila]['G'];
                $UbicacionId = $hojaDeProductos[$indiceFila]['H'];
            

                $ModeloId = $Procesos->getModeloxNombre($Modelo);
                $ConectividadId = $Procesos->getConectividadxNombre($Conectividad);
                $EstatusId = $Procesos->getEstatusxNombre($Estatus);
                $Estatus_ubicacionId = $Procesos->getEstatusInvxNombre($EstatusUbicacion);
                $Ubicacion_Id = $Procesos->getAlmacenxNombre($Ubicacion);


                $fecha = date ( 'Y-m-d H:m:s' );
                $campoUpdate = " tipo=?, fecha_edicion=?  ";
                $new = 0;
                $arrayString = array(
                    $Tipo,
                    $fecha
                );



                if($Modelo) {
                    $campoUpdate .= " ,modelo=? ";
                    array_push($arrayString,$ModeloId);
                }

                if($Conectividad) {
                    $campoUpdate .= " ,conectividad=? ";
                    array_push($arrayString,$ConectividadId);
                }
                if($Estatus) {
                    $campoUpdate .= " ,estatus=? ";
                    array_push($arrayString,$EstatusId);
                }
                if($EstatusUbicacion) {
                    $campoUpdate .= " ,estatus_inventario=? ";
                    array_push($arrayString,$Estatus_ubicacionId);
                }
                if($Ubicacion_Id) {
                    $campoUpdate .= " ,ubicacion=? ";
                    array_push($arrayString,$Ubicacion_Id);
                }

                if($UbicacionId) {
                    $campoUpdate .= " ,id_ubicacion=? ";
                    array_push($arrayString,$UbicacionId);
                }

                array_push($arrayString,$NoSerie);

                $sql = "UPDATE inventario 
                        SET 
                        $campoUpdate
                        WHERE no_serie=?" ;

                $id =  $Procesos->update($sql,$arrayString);

               

                if( $id > 0 ) {
                    $counter++;

                    $invData = $Procesos->getInventarioData($NoSerie);

                    $sqlEvento = "UPDATE carga_archivos SET registros_procesados=? WHERE id = ?";

                    $arrayStringEvento = array (
                        $counter,
                        $proceso['id']
                    );

                    $Procesos->insert($sqlEvento,$arrayStringEvento);

                    $historial_estatus = '';

	switch ($EstatusId) {
		case '2':
			$historial_estatus = 'CAMBIO ESTATUS A OBSOLETO';
		break;
		case '3':
			$historial_estatus = 'CAMBIO ESTATUS A DISPONIBLE-USADO';
		break;
		case '5':
			$historial_estatus = 'CAMBIO ESTATUS A DISPONIBLE-NUEVO';
		break;
		case '6':
			$historial_estatus = 'CAMBIO ESTATUS A EN REPARACION';
		break;
		case '7':
			$historial_estatus = 'CAMBIO ESTATUS A DAÑADA';
		break;
		case '8':
			$historial_estatus = 'CAMBIO ESTATUS A IRREPARABLE';
		break;
		case '12':
			$historial_estatus = 'CAMBIO ESTATUS A EN TRANSITO';
		break;
		case '13':
			$historial_estatus = 'CAMBIO ESTATUS A INSTALADO';
		break;
		case '14':
			$historial_estatus = 'CAMBIO ESTATUS A EN PLAZA';
		break;
		case '15':
			$historial_estatus = 'CAMBIO ESTATUS A EN DIAGNOSTICO';
		break;
		case '16':
			$historial_estatus = 'CAMBIO ESTATUS A QUEBRANTO';
		break;
		case '17':
			$historial_estatus = 'CAMBIO ESTATUS A DESTRUCCION';
		break;
	}

                    $prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
					VALUES
					(?,?,?,?,?,?,?,?,?);
                    ";
                    $arrayString = array (
                            $invData['id'],
                            $fecha,
                            $historial_estatus,
                            $invData['ubicacion'],
                            $NoSerie,
                            $invData[0]['tipo'],
                            $invData['cantidad'],
                            $invData['id_ubicacion'],
                            $proceso['creado_por']
                    );

                   
                } else {
                    $nocounter++;
                    array_push($serieNoAct,["NoSerie" => $NoSerie ]);
                    $sqlEvento = "UPDATE carga_archivos SET registros_sinprocesar=? WHERE id = ?";

                    $arrayStringEvento = array (
                        $nocounter,
                        $proceso['id']
                    );

                    $Procesos->insert($sqlEvento,$arrayStringEvento);

                }
                
                    
                    
                
            }
        }

        
        $series = json_encode($serieNoAct);
        $sqlNoCarga = " INSERT INTO nocarga_archivos (archivo_id,odt) VALUES (?,?)";
                    
        $arrayString = array ( $proceso['id'], $series);
        
        $Procesos->insert($sqlNoCarga, $arrayString);

        //echo json_encode(["contador" => $counter, "datos" => $datosCargar]);
        //UPDATE PROCESO
        $fecha = date ( 'Y-m-d H:m:s' );

        $sqlEvento = "UPDATE carga_archivos SET  activo= ?,procesar= ?,fecha_modificacion= ? WHERE id = ?";

        $arrayStringEvento = array (
            0,
            0,
            $fecha,
            $proceso['id']
        );
    
        $Procesos->insert($sqlEvento,$arrayStringEvento);

       

    } else {
        echo "$fechaProceso Sin procesos de Inventario pendientes \n";
    }
}

?>
