<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../modelos/procesos_db.php');

require __DIR__ . '/../vendor/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;



$fecha = date ( 'Y-m-d H:m:s' );
echo $fecha;  

//$eventoMasivo = new CargasMasivas();
$archivo =  '/var/www/dev.sinttecom.net/cron/files/Base Instalada.xlsx';

//SPOUT
$reader = ReaderFactory::create(Type::XLSX);
$reader->setShouldFormatDates(true);
$reader->open($archivo);

$user = 1;
$consecutivo = 1;
$counter = 0;
$nocounter = 0;
$insert_values = array();
$fecha = date ( 'Y-m-d H:m:s' );
$serieNoAct = array();

$datosCargar = array();
$format = "d/m/Y";

foreach ($reader->getSheetIterator() as $sheet) {
    foreach ($sheet->getRowIterator() as $rowNumber => $row) {
        // do stuff with the row
        if ($rowNumber > 1) {

            //$cells = $row->getCells();
            
              
            
            $tipo = $Procesos->getTipo( $row[0] );
            $noserie = $row[1]; //$cells[1]->getValue(); //$hojaDeProductos[$indiceFila]['B'];
            if($tipo == '1' ) {
            
              $modelo =  $Procesos->getModeloxNombre( $row[2] ) ? $Procesos->getModeloxNombre( $row[2] ) : 0 ;
            } else {
              $modelo =  $Procesos->getCarriersxNombre( $row[2] ) ? $Procesos->getCarriersxNombre( $row[2] ) : 0 ;
            }
            $aplicativo = $Procesos->getAplicativoxNombre( $row[3] ) ?  $Procesos->getAplicativoxNombre( $row[3] ) : 0 ;
            $conectividad = $Procesos->getConectividadxNombre( $row[4] ) ? $Procesos->getConectividadxNombre( $row[4] ) :0 ;
            echo " Conectividad: $row[4] ". $conectividad ." \n ";
            echo " MODELO: $row[2] ". $modelo." \n ";
            $date = DateTime::createFromFormat($format, $row[6] );
            $fechaAsignacion = $date->format("Y-m-d H:i:s"); 

            $comercioId = $Procesos->getComercioId( $row[7] ) ; //!empty( $row[7] ) ? [ 'id' => 0] : 
            $odt = $row[8];
            
            $existeSerieInventario = $Procesos->getInventarioData($noserie);

            
            
            // UPDATE INVENTARIO
            
            if($existeSerieInventario) {
            
               // echo "Existe Serie $noserie en La BD: ".json_encode($existeSerieInventario)." \n ";
                
                $sql = "UPDATE inventario 
                SET tipo=?,modelo=?,conectividad=?,ubicacion=?,id_ubicacion=?,estatus=?,estatus_inventario=?
                WHERE no_serie=?" ;
    
                $arrayString = array (
                    $tipo,
                    $modelo,
                    $conectividad,
                    2,
                    $comercioId['id'],
                    13,
                    4,
                    $noserie
                );
                
                echo "UPDATE inventario ".json_encode($arrayString). " \n ";
              //  echo "Registros a Actualizar ".json_encode($arrayString)." \n ";
  
                $Procesos->insert($sql,$arrayString);
            } else {
                echo "No Existe Serie $noserie en La BD: \n ";
                
                $prepareStatement = "INSERT INTO `inventario`
    						( `tipo`,`cve_banco`,`no_serie`,`modelo`,`conectividad`,`estatus`,`estatus_inventario`,
    						`cantidad`,`ubicacion`,`id_ubicacion`,`creado_por`,`fecha_entrada`,`fecha_creacion`,`fecha_edicion`,`modificado_por`)
    						VALUES
    						(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
    					";
                $arrayString = array (
                        $tipo,
                        '037',
                        $noserie,
                        $modelo,
                        $conectividad,
                        13,
                        4,
                        1,
                        2,
                        $comercioId['id'],
                        1,
                        $fecha,
                        $fecha,
                        $fecha,
                        1
                );
                
                echo "INSERTAR A INV ".json_encode($arrayString). " \n ";
                $Procesos->insert($prepareStatement,$arrayString);
                
                $sqlDelete = "DELETE FROM historial WHERE no_serie=? AND tipo_movimiento=? ";
                $ArrayDelete = array($noserie,'INSTALADA');
                $Procesos->insert($sqlDelete,$ArrayDelete);
                
                $datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
  							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
  							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
  						
  							$arrayString = array (
  								0,
  								$fechaAsignacion,
  								'INSTALADA',
  								2,
  								$noserie,
  								$tipo,
  								1,
  								$comercioId['id'],
  								1
  							);
  						  echo json_encode($arrayString). " \n ";
  							$Procesos->insert($sql,$arrayString);
         
            }
            
            //UPDATE eventos
            $sql = "UPDATE eventos 
            SET tpv_instalado=?,ultima_act=?
            WHERE odt=?" ;
            
            $existeEvento = $Procesos->existeEvento($odt);
           

            if($existeEvento) {
                // echo "Existe Evento en La BD: ".json_encode($existeEvento)." \n ";
            
                //  echo "Existe ODT ".$odt." \n ";
                  $arrayString = array (
                      $noserie,
                      $fechaAsignacion,
                      $odt
                  );
  
                  $Procesos->insert($sql,$arrayString);
              
            } else {
            
                echo "No Existe Evento $odt en La BD:  \n ";
                
                
            }
        }

    }
}

$reader->close();

/*
$inputFileType = IOFactory::identify($archivo);
$reader = IOFactory::createReader($inputFileType);

try {
$spreadsheet = IOFactory::load($archivo);
} catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e ) {
    echo 'Error loading file: '.$e->getMessage();
}
$hojaDeProductos= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$user = $proceso['creado_por'];
$consecutivo = 1;
$counter = 0;
$nocounter = 0;
$insert_values = array();
$fecha = date ( 'Y-m-d H:m:s' );
$serieNoAct = array();

$datosCargar = array();
$format = "d/m/Y";
$numeroMayorDeFila = count($hojaDeProductos); 

for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

    $tipo = $Procesos->getTipo( $hojaDeProductos[$indiceFila]['A'] );
    $noserie = $hojaDeProductos[$indiceFila]['B'];
    $modelo = $Procesos->getModeloxNombre( $hojaDeProductos[$indiceFila]['C'] );
    $aplicativo = $Procesos->getAplicativoxNombre( $hojaDeProductos[$indiceFila]['D'] );
    $conectividad = $Procesos->getConectividadxNombre( $hojaDeProductos[$indiceFile]['E']);

    $date = DateTime::createFromFormat($format, $hojaDeProductos[$indiceFila]['G']);
    $fechaAsignacion = $date->format("Y-m-d H:i:s"); 

    $comercioId = $Procesos->getComercioId( $hojaDeProductos[$indiceFila]['H'] );
    $odt = $hojaDeProductos[$indiceFila]['I'];

    echo $noserie." <br>";
    // UPDATE INVENTARIO
    $sql = "UPDATE inventario 
    SET tipo=?,modelo=?,conectividad=?,ubicacion=?,id_ubicacion=?
    WHERE no_serie=?" ;

    $arrayString = array (
        $tipo,
        $modelo,
        $conectividad,
        2,
        $comercioId,
        $noserie
    );

    $Procesos->insert($sql,$arrayString);
    
    //UPDATE eventos
    $sql = "UPDATE eventos 
    SET tpv_instalado=?,ultima_act=?
    WHERE odt=?" ;

    if(!empty($odt))
    {
        echo "Existe ODT ".$odt." <br>";
        $arrayString = array (
            $noserie,
            $fechaAsignacion,
            $odt
        );

        $Procesos->insert($sql,$arrayString);
    }

}
*/
?>