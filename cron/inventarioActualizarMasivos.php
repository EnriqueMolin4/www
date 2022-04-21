<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

require __DIR__.'/../modelos/procesos_db.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


$processActive = $Procesos->getCargasEnProceso('IA');

if($processActive) {
    echo " $processActive Hay un proceso Ejecutandose \n ";
} else {
    $proceso = $Procesos->getOlderCargas('IA');

    if($proceso) {
        echo "Buscar Proceso mas Viejo ".$proceso['fecha_creacion']." \n ";
        $fecha = date ( 'Y-m-d H:m:s' );
        
		    //$archivo =  '/var/www/html/cron/files/'.$proceso['archivo'];
        //$eventoMasivo = new CargasMasivas();
        $archivo =  '/var/www/dev.sinttecom.net/cron/files/'.$proceso['archivo'];

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
                 
                
                $Tipo = $hojaDeProductos[$indiceFila]['A']; //$Procesos->getTipo( $hojaDeProductos[$indiceFila]['A'] );
                $Modelo = $hojaDeProductos[$indiceFila]['C'];
                $Aplicativo = $hojaDeProductos[$indiceFila]['D'];
                $Conectividad = $hojaDeProductos[$indiceFila]['E'];
                $Estatus = $hojaDeProductos[$indiceFila]['F'];
                $EstatusUbicacion = $hojaDeProductos[$indiceFila]['G'];
                $Ubicacion = $hojaDeProductos[$indiceFila]['H'];
                $UbicacionId = $hojaDeProductos[$indiceFila]['I'];
				$CveBanco = str_pad($hojaDeProductos[$indiceFila]['J'],3,'0',STR_PAD_LEFT);
            

                $ModeloId = $Tipo == '1' ? $Procesos->getModeloxNombre($Modelo,$CveBanco) : $Procesos->getCarriersxNombre($Modelo,$CveBanco);
                //echo $Tipo." ".$NoSerie." ".$Modelo." ".$ModeloId." \n ";
                $AplicativoId = $Procesos->getAplicativoxNombre($Aplicativo,$CveBanco);
                $ConectividadId = $Procesos->getConectividadxNombre($Conectividad,$CveBanco);
                $EstatusId = $Procesos->getEstatusxNombre($Estatus);
                $Estatus_ubicacionId = $Procesos->getEstatusInvxNombre($EstatusUbicacion);
                

                if($Estatus_ubicacionId == "5" || $Estatus_ubicacionId == "1" ) {
                    $UbicacionId = 1;
                    $Ubicacion_Id = $Procesos->getAlmacenxNombre($Ubicacion);
                } 

                if($Estatus_ubicacionId == "3" ) {
                    $Ubicacion_Id =  $UbicacionId;
					$UbicacionId = 9;
                     
                } 
                
                


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
                    $campoUpdate .= " ,id_ubicacion=? ";
                    array_push($arrayString,$Ubicacion_Id);
                }

                if($UbicacionId) {
                    $campoUpdate .= " ,ubicacion=? ";
                    array_push($arrayString,$UbicacionId);
                }

                array_push($arrayString,$NoSerie);

                $sql = "UPDATE inventario 
                        SET 
                        $campoUpdate
                        WHERE no_serie=?" ;
                
                

                $id =  $Procesos->update($sql,$arrayString);
                
                echo $id." ".$NoSerie." \n ";

                if($UbicacionId == '3') {

                    $prepareStatement = "INSERT INTO `inventario_tecnico`
                    ( `tecnico`,`no_serie`,`cantidad`,`creado_por`,`fecha_creacion`,`fecha_modificacion`,`cve_banco`)
                    VALUES (?,?,?,?,?,?);
                    ";
                    $arrayString = array (
                            $Ubicacion_Id,
                            $NoSerie,
                            1,
							              1,
                            $fecha,
                            $fecha,
							              $CveBanco
                    );

                    $Procesos->insert($prepareStatement,$arrayString);
					
					          echo $prepareStatement;
					          echo json_encode($arrayString);
                }
               

                if( $id > 0 ) {
                    $counter++;

                    

                    $invData = $Procesos->getInventarioData($NoSerie,$CveBanco);

                    $sqlEvento = "UPDATE carga_archivos SET registros_procesados=? WHERE id = ?";

                    $arrayStringEvento = array (
                        $counter,
                        $proceso['id']
                    );

                    $Procesos->insert($sqlEvento,$arrayStringEvento);

                    $prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`,`cve_banco`)
					VALUES
					(?,?,?,?,?,?,?,?,?,?);
                    ";
                    $arrayString = array (
                            $invData['id'],
                            $fecha,
                            'CAMBIO ESTATUS',
                            $invData['ubicacion'],
                            $NoSerie,
                            $invData[0]['tipo'],
                            $invData['cantidad'],
                            $invData['id_ubicacion'],
                            $proceso['creado_por'],
							$CveBanco
                    );

                    $Procesos->insert($prepareStatement,$arrayString);

                   
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
