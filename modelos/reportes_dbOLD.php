<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');


require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

include 'IConnections.php';
class Reportes implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection ( 'sinttecom' );
		self::$logger=  $log;
	}
	function fetch() {
		if (isset ( self::$connection )) {
			return self::execute_sel ();
		} else {
			return array ();
		}
	}
	private function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
    function getEventos($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $tipo = $params['tipo_evento'];
        $estatus = $params['estatus_busqueda'];
        $filter = "";

        if($tipo != '0') {
            $filter .= " AND servicio = $tipo ";
        }

        if($estatus != '0') {
            $filter .= " AND estatus = $estatus ";
        }

        $sql = "SELECT GetNameById(cve_banco,'Banco') CveBancaria,GetNameById(servicio,'TipoServicio') servicio, afiliacion Folio, GetNameById(comercio,'Comercio') cliente, direccion  ,colonia,
                GetNameById(estado,'Estado') Estado,GetNameById(municipio,'Municipio') municipio,telefono,odt,REPLACE(REPLACE(descripcion, '\r', ''), '\n', '') descripcion,ticket,GetNameById(estatus,'Estatus') Estatus
                from eventos 
                WHERE fecha_alta BETWEEN ?  AND ? 
                $filter ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getEventos();	Functionality: Get VO Eventos;	Log:" . $e->getMessage () );
        }
	}

	function getVo($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $estatus = $params['estatus_busqueda'];
        $filter = "";

        if($estatus != '0') {
            $filter .= " AND estatus = $estatus ";
        }

        $sql = "SELECT GetNameById(cve_banco,'Banco') CveBancaria,GetNameById(servicio,'TipoServicio') servicio, afiliacion Folio, receptor_servicio cliente, direccion  ,colonia,
                GetNameById(estado,'Estado') Estado,GetNameById(municipio,'Municipio') municipio,telefono,odt,REPLACE(REPLACE(descripcion, '\r', ''), '\n', '') descripcion,ticket,
                GetNameById(estatus,'Estatus') Estatus
                from eventos where servicio= 15 
                AND fecha_alta BETWEEN ?  AND ? 
                $filter ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getVo();	Functionality: Get VO Eventos;	Log:" . $e->getMessage () );
        }
	}

    function getImagenesTecnico($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $tecnico = $params['tecnico'];
        $filter = "";

        if($tecnico != '0') {
            $filter .= " AND cuentas.id = $tecnico ";
        }

        $sql = "Select odt,nombre,fecha,dir_img from img,cuentas
                where img.tecnico = cuentas.id
                AND cuentas.nombre is not null
                AND fecha BETWEEN ?  AND ? 
                $filter ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getImagenesTecnico();	Functionality: Get Imagenes Tecnico;	Log:" . $e->getMessage () );
        }
    }
    
    function getInventarioCampo($params) {
        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];


        $sql = "Select 
				eventos.ODT,
				eventos.afiliacion,
				cuentas.nombre Tecnico,
				eventos.fecha_alta ,
				eventos.fecha_atencion ,
				evidencias.fecha  FechaEvidencias,
				eventos.tpv_retirado tpv_retirado, 
				eventos.tpv_instalado tpv_instalado,
				eventos.sim_retirado sim_retirado,
				eventos.sim_instalado sim_instalado,
				tipo_estatus.nombre Estatus, 
				tipo_servicio.nombre Servicio,
				tipo_subservicios.nombre SubServicio,
				evidencias.cantImagenes 
                from eventos
                LEFT JOIN tipo_subservicios ON eventos.servicio = tipo_subservicios.id
                LEFT JOIN tipo_servicio ON eventos.tipo_servicio = tipo_servicio.id ,cuentas,tipo_estatus,
                (SELECT odt,MAX(fecha) fecha,count(id) cantImagenes FROM img group by odt) evidencias
                WHERE eventos.odt = evidencias.odt
                AND eventos.tecnico = cuentas.id  
                AND eventos.estatus not in  (1)
                AND eventos.tecnico not in (128)
                AND eventos.estatus = tipo_estatus.id
                AND evidencias.fecha BETWEEN ?  AND ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getInventarioCampo();	Functionality: Get Imagenes Tecnico;	Log:" . $e->getMessage () );
        }
    }
    
}
//
include 'DBConnection.php';
$Reportes = new Reportes ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'reporte_vo') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eventosVO.csv"');
    
    $rows = $Reportes->getVo($params);
    echo 'CveBancaria,Servicio,Ticket,Folio,cliente,direccion,colonia,Estado,municipio,telefono,odt,descripcion,estatus'. PHP_EOL;

    foreach ($rows as $row ) {
     echo $row['CveBancaria'] . "," . $row['servicio'] . "," .$row['ticket'] . "," . $row['Folio'] . "," . $row['cliente']  . "," . $row['direccion'] . "," . $row['colonia'] . "," . $row['Estado'] . "," . $row['municipio']. "," . $row['telefono']. "," . $row['odt']. "," . $row['descripcion']. "," . $row['Estatus']. PHP_EOL;
    }


   
}

if($module == 'reporte_eventos') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eventos.csv"');
    
    $rows = $Reportes->getEventos($params);
    echo 'CveBancaria,Servicio,ODT,Folio,cliente,direccion,colonia,Estado,municipio,telefono,ticket,descripcion,estatus'. PHP_EOL;

    foreach ($rows as $row ) {
     echo $row['CveBancaria'] . ",". $row['servicio'] . "," .$row['odt'] . "," . $row['Folio'] . "," . $row['cliente']  . "," . $row['direccion'] . "," . $row['colonia'] . "," . $row['Estado'] . "," . $row['municipio']. "," . $row['telefono']. "," . $row['ticket']. "," . $row['descripcion']. "," . $row['Estatus']. PHP_EOL;
    }


   
}

if($module == 'reporte_inventarioCampo') {
    // output headers so that the file is downloaded rather than displayed
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="reporte_inventarioCampo.csv"');
    
    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');
       
    $output = fopen('php://output', 'w');

    $rows = $Reportes->getInventarioCampo($params);
  
    fputcsv($output, array('ODT','Afiliacion','Nombre','Fecha Alta','Fecha Atencion','Fecha Evidencias','TVP_Retirado','TVP_Instalado','SIM_Retirado','SIM_Instalado','Estatus','Servicio','SubServicio','Cant Imagenes'));

    foreach ($rows as $row) { 
        // generate csv lines from the inner arrays
        $row['tpv_retirado'] =  "=\"" .$row['tpv_retirado']. "\"";
        $row['tpv_instalado'] =  "=\"" .$row['tpv_instalado']. "\"";
        fputcsv($output, $row); 
    }
    // reset the file pointer to the start of the file
   exit();
   
}


if($module == 'reporte_imagenestecnico') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="imagenestecnico.csv"');
    
    $rows = $Reportes->getImagenesTecnico($params);
    echo 'Fecha,ODT,Tecnico,Imagen'. PHP_EOL;

    foreach ($rows as $row ) {
     echo $row['fecha'] . ",". $row['odt'] . "," .$row['nombre'] . "," . $row['dir_img'] . PHP_EOL;
    }


   
}


?>
