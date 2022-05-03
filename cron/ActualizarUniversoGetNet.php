<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../modelos/procesos_db.php');

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$fecha = date ( 'Y-m-d H:m:s' );
echo $fecha;  

//$eventoMasivo = new CargasMasivas();
$archivo =  'files/UNIVERSO HSBC.xlsx';

//SPOUT
$reader = ReaderEntityFactory::createReaderFromFile($archivo);
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

            $cells = $row->getCells();
            

            
            $tipo = $cells[0]->getValue() == 'TPV' ? 1 : 2; //$Procesos->getTipo( $hojaDeProductos[$indiceFila]['A'] );
            $noserie = $cells[2]->getValue(); //$hojaDeProductos[$indiceFila]['B'];
            $fabricante = $cells[3]->getValue(); //$Procesos->getModeloxNombre( $hojaDeProductos[$indiceFila]['C'] );
            $estatus = $cells[4]->getValue(); //$Procesos->getAplicativoxNombre( $cells[3]->getValue() );
			$cveBanco = $cells[5]->getValue();
			
            if ($estatus == 'ACTIVO')
			{
				$Estatus_Modelo = 3;
			} else if ($estatus == 'CANCELADO') {
				$Estatus_Modelo = 7;
			} else {
				$Estatus_Modelo = 3;
			}
           
            //$modelo = $cells[4]->getValue(); //$Procesos->getConectividadxNombre( $cells[4]->getValue() );

            //$date = DateTime::createFromFormat($format, $cells[6]->getValue() );
            $fechaAsignacion = date("Y-m-d H:i:s"); 


            $sql = "INSERT INTO elavon_universo (id,serie,fabricante,estatus,estatus_modelo,tipo,fecha_mod,modificado_por,cve_banco) 
						VALUES(NULL,'$noserie','$fabricante','$estatus',$Estatus_Modelo,$tipo,'$fechaAsignacion',1,'$cveBanco') 
						ON DUPLICATE KEY     
						UPDATE serie =	'$noserie'
						,fabricante = '$fabricante'
						,estatus = '$estatus'
						,estatus_modelo = $Estatus_Modelo
						,tipo =	$tipo
                        ,fecha_mod = '$fechaAsignacion'
						,modificado_por = 1
						,cve_banco= $cveBanco
						";

            $id = $Procesos->insert($sql,array());

            echo $noserie." ".$id." \n ";
            
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