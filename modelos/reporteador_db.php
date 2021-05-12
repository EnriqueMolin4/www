<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Reporteador implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection ( 'dsd' );
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
			self::$logger->error ("File: validaciones_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: validaciones_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function getEventFields() {
		
		$sql = "DESCRIBE eventos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reporteador_db.php;	Method Name: getEventFields();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getInventoryFields() {
		
		$sql = "DESCRIBE inventario ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reporteador_db.php;	Method Name: getInventoryFields();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getHistorialFields() {
		
		$sql = "DESCRIBE historial ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reporteador_db.php;	Method Name: getHistorialFields();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }



}
//
include 'DBConnection.php';
$Reportes = new Reporteador ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getEventFields') {

    $rows = $Reportes->getEventFields( );
    $val = '';
    foreach ( $rows as $row ) {
        $val .=  '<option value="' . $row ['Field'] . '">' . $row ['Field'] . '</option>';
    }
    echo $val;
}

if($module == 'getInventoryFields') {

    $rows = $Reportes->getInventoryFields( );
    $val = '';
    foreach ( $rows as $row ) {
        $val .=  '<option value="' . $row ['Field'] . '">' . $row ['Field'] . '</option>';
    }
    echo $val;
}

if($module == 'getHistorialFields') {

    $rows = $Reportes->getHistorialFields( );
    $val = '';
    foreach ( $rows as $row ) {
        $val .=  '<option value="' . $row ['Field'] . '">' . $row ['Field'] . '</option>';
    }
    echo $val;
}



?>