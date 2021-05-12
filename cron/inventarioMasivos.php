<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
include('../modelos/procesos_db.php');

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


$processActive = $Procesos->getCargasEnProceso('I');

if($processActive) {
    echo " $processActive Hay un proceso de Inventario Ejecutandose \n ";
} else {
    $proceso = $Procesos->getOlderCargas('I');

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
                $Linea = $hojaDeProductos[$indiceFila]['C'];
                $Modelo = $hojaDeProductos[$indiceFila]['D'];
                $Conectividad = $hojaDeProductos[$indiceFila]['E'];
                $Estatus = $hojaDeProductos[$indiceFila]['F'];
                $Anaquel = $hojaDeProductos[$indiceFila]['G'];
                $Caja = $hojaDeProductos[$indiceFila]['H'];
                $Tarima = $hojaDeProductos[$indiceFila]['I'];
                $Cantidad = $hojaDeProductos[$indiceFila]['J'];
                $CveBanco = $hojaDeProductos[$indiceFila]['K'];
                $Almacen = $hojaDeProductos[$indiceFila]['L'];
            

                $ModeloId = $Procesos->getModeloxNombre($Modelo);
                $ConectividadId = $Procesos->getConectividadxNombre($Conectividad);
                $EstatusId = $Procesos->getEstatusxNombre($Estatus);
                $AlmacenId = $Procesos->getAlmacenxNombre($Almacen);

                $existeElavon = $Procesos->getInventarioElavonData($NoSerie);
                
                if($existeElavon) {

                    $existe = $Procesos->getInventarioData($NoSerie);

                    
                    if(!$existe) {

                        $datafieldsInventarios = array('tipo','cve_banco','no_serie','modelo','conectividad','estatus','estatus_inventario','anaquel','caja','tarima','cantidad','linea','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion');
                        $question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));

                        $sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 

                        $arrayString = array (
                            $Tipo,
                            $CveBanco,
                            $NoSerie,
                            $ModeloId,
                            $ConectividadId,
                            $EstatusId,
                            1,
                            $Anaquel,
                            $Caja,
                            $Tarima,
                            $Cantidad,
                            $Linea,
                            1,
                            $AlmacenId,
                            $proceso['creado_por'],
                            $fecha,
                            $fecha,
                            $fecha
                        );


                        

                        $id =  $Procesos->insert($sql,$arrayString);

                    

                        if( $id > 0 ) {
                            $counter++;

                            $invData = $Procesos->getInventarioData($NoSerie);

                            $sqlEvento = "UPDATE carga_archivos SET registros_procesados=? WHERE id = ?";

                            $arrayStringEvento = array (
                                $counter,
                                $proceso['id']
                            );

                            $Procesos->insert($sqlEvento,$arrayStringEvento);

                            $prepareStatement = "INSERT INTO `historial`
                            ( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
                            VALUES
                            (?,?,?,?,?,?,?,?,?);
                            ";
                            $arrayString = array (
                                    $invData['id'],
                                    $fecha,
                                    'ENTRADA ALMACEN',
                                    $invData['ubicacion'],
                                    $NoSerie,
                                    $invData['tipo'],
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
