<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Dashboard implements IConnections {
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
	private static function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `warehouses`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: sfa_ordersdmin_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: sfa_ordersdmin_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function getTotalEventosbyStatus($params) {
		
		$sql = " SELECT te.nombre,COUNT(odt) total
                    FROM eventos e,tipo_estatus te
                    WHERE e.estatus IN (1,2,3)
                    AND e.estatus = te.id
                    GROUP BY e.estatus 
                ";
		
	   //AND DATE(e.fecha_vencimiento) =  DATE(NOW())
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getTotalEventosbyStatus();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

    function getTotalEventosbyMonth($params) {

        $sql = " SELECT 'Vencidos' Servicio,COUNT(odt) total
                    FROM eventos e,tipo_estatus te
                    WHERE e.estatus IN (1,2,10)
                    AND e.estatus = te.id
                    AND DATE(e.fecha_vencimiento) >  DATE(NOW())
                    
                    UNION ALL
                    
                    SELECT 'En Tiempo' Servicio,COUNT(odt) total
                    FROM eventos e,tipo_estatus te
                    WHERE e.estatus IN (1,2,10)
                    AND e.estatus = te.id
                    AND DATE(e.fecha_vencimiento) <=  DATE(NOW()) 
                ";
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getTotalEventosbyMonth();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
	
	function getBancos() {
		$sql = "select cve, banco nombre from bancos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getMunicipio($cp) {
		$sql = " select municipios.Id, municipios.nombre,cp_santander.territorial_banco,territorial_sinttecom from cp_santander,municipios 
		where municipios.id = cp_santander.ciudad 
		AND cp_santander.cp = $cp
		GRoup by municipios.Id, municipios.nombre,cp_santander.territorial_banco,territorial_sinttecom
		 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cp));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getMunicipio();	Functionality: Get Municipio;	Log:" . $e->getMessage () );
        }
	}

    function getServicioMes() {

        $sql = " SELECT 'Vencidos', count(*) Total FROM (
                    Select id,odt,fecha_vencimiento 
                    FROM eventos 
                    WHERE fecha_vencimiento BETWEEN DATE(DATE_SUB(NOW(),INTERVAL DAYOFMONTH(NOW())-1 DAY)) AND LAST_DAY( NOW() ) 
                    ) eventos
                    WHERE fecha_vencimiento < DATE(NOW())
                    
                    UNION ALL 
                    
                    SELECT 'A Tiempo', count(*) Total FROM (
                    Select id,odt,fecha_vencimiento 
                    FROM eventos 
                    WHERE fecha_vencimiento BETWEEN DATE(DATE_SUB(NOW(),INTERVAL DAYOFMONTH(NOW())-1 DAY)) AND LAST_DAY( NOW() ) 
                    ) eventos
                    WHERE fecha_vencimiento > DATE(NOW())
                ";
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getServicioMes();	Functionality: Get Municipio;	Log:" . $e->getMessage () );
        }
    }

    function getTotalServiciosMes() {

        $sql = " SELECT 'MesPasado', count(*) total 
                FROM eventos
                WHERE fecha_vencimiento BETWEEN DATE(DATE_SUB(NOW(),INTERVAL DAYOFMONTH(NOW())-1 DAY) - INTERVAL 1 MONTH ) AND LAST_DAY( NOW() - INTERVAL 1 MONTH ) 
                
                UNION ALL
                
                SELECT 'MesActual', count(*) total 
                FROM eventos
                WHERE fecha_vencimiento BETWEEN DATE(DATE_SUB(NOW(),INTERVAL DAYOFMONTH(NOW())-1 DAY) ) AND LAST_DAY( NOW() ) 
                ";
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getTotalServiciosMes();	Functionality: Get Municipio;	Log:" . $e->getMessage () );
        }
    }

    

}
//
include 'DBConnection.php';
$Dashboard = new Dashboard ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTotalEventosbyStatus') {

    $eventosStatus = $Dashboard->getTotalEventosbyStatus($params);
    $eventosMonth = $Dashboard->getTotalEventosbyMonth($params);
    $serviciosMes = $Dashboard->getTotalServiciosMes();
    

	echo json_encode(['eventosStatus' => $eventosStatus, 'eventosMonth' => $eventosMonth, 'serviciosMes' => $serviciosMes ]); //$val;
}




?>
