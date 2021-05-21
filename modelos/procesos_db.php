<?php
include 'IConnections.php';

class Procesos implements IConnections {
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
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
		}
	}

	private static function execute_upd($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			return $stmt->rowCount();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_upd();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
		}
	}

	function insert($prepareStatement, $arrayString) {

		return self::execute_ins ( $prepareStatement, $arrayString );

	}

	function update($prepareStatement, $arrayString) {
		return self::execute_upd ( $prepareStatement, $arrayString);
	}

	function getCargasEventos($activo,$tipo) {
		
		$sql = "SELECT * from carga_archivos WHERE activo= ? AND tipo=? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($activo,$tipo));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getCargasEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

	function getProcesos($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$tipo  = $params['tipo'];
		if($tipo == 'I') {
			$tipo = " 'I','IA' ";
		}
		if($tipo == 'E') {
			
			$tipo = " 'E' ";
		}

        $orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
		$where = "";

	
		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}
        

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" WHERE ";
			$where .=" ( nombre LIKE '".$params['search']['value']."%' ) ";    

		}

        $sql = " SELECT 
				 ca.id,
				 ca.archivo,
				 ca.registros_total,
				 ca.registros_procesados,
				 ca.registros_sinprocesar,
				 ca.fecha_modificacion,
				 CONCAT(du.nombre,' ',du.apellidos) nombre
				 FROM carga_archivos ca, detalle_usuarios  du
				 WHERE ca.creado_por = du.cuenta_id 
				 AND ca.tipo in ($tipo) ";
	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute(array($tipo));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: parametros_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getOlderCargas($tipo) {
		
		$sql = "SELECT * from carga_archivos WHERE activo= 1 AND tipo =  ? AND  id = (SELECT MAX(id) FROM carga_archivos ) ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($tipo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC  );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getCargasEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

	function getCargasEnProceso($tipo) {
		
		$sql = "SELECT count(*) from carga_archivos WHERE activo= 1 AND procesar = 1 AND tipo = '$tipo' ";
		 
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($tipo));
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0  );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getCargasEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

	function getClientesByAfiliacion($afiliacion) {
		$sql = "SELECT 
				id,
				comercio,
				propietario,
				estado, 
				ciudad, 
				colonia, 
				afiliacion, 
				telefono, 
				direccion,
				rfc, 
				email, 
				territorial_banco, 
				razon_social,
			    cve_banco,
				cp
				FROM comercios WHERE afiliacion= $afiliacion";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getClientesByAfiliacion();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getServicioxNombre($servicio) {
		$sql = "SELECT id FROM tipo_servicio WHERE nombre = '$servicio' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getSubServicioxNombre($servicio) {
		$sql = "SELECT id FROM tipo_subservicios WHERE nombre = '$servicio' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getSubServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getEstatusServicioxNombre($estatus) {
		$sql = "SELECT id FROM tipo_estatus WHERE nombre LIKE '%$estatus%' and tipo= 12 Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getEstatusServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getConectividadxNombre($connect) {
		$sql = "SELECT id FROM tipo_conectividad WHERE nombre LIKE '%$connect%' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getConectividadxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getModeloxNombre($modelo) 
	{

		$sql = "SELECT id FROM modelos WHERE modelo LIKE '%$modelo%' LIMIT 1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getModeloxNombre();	Functionality: Search Modelos;	Log:". $sql . $e->getMessage () );
		}
	}
	function getCarriersxNombre($modelo) 
	{

		$sql = "SELECT id FROM carriers WHERE nombre LIKE '%$modelo%' LIMIT 1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getCarriersxNombre();	Functionality: Search Modelos;	Log:". $sql . $e->getMessage () );
		}
	}
	function getEstatusxNombre($estatus) {
		$sql = "SELECT id FROM tipo_estatus_modelos WHERE nombre= '$estatus' LIMIT 1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getEstatusxNombre();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getEstatusInvxNombre($estatus_ubicacion)
	{
		$sql = "SELECT id FROM tipo_estatus_inventario WHERE nombre LIKE '%$estatus_ubicacion%' AND estatus=1 ";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute ();
			return $result = $stmt ->fetch ( PDO::FETCH_COLUMN, 0);
		} catch ( PDOException $e){
			self::$logger->error ("File: procesos_db.php;     Method Name: getEstatusInvxNombre();    Functionality: Search Carriers; Log:". $sql . $e->getMessage ());
		}
	}


	function getAlmacenxNombre($almacen) {
		$sql = "SELECT id FROM tipo_ubicacion WHERE nombre LIKE '%$almacen%' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getAlmacenxNombre();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existeEvento($odt) {
		$sql = "SELECT id,tecnico,afiliacion,estatus_servicio  FROM eventos WHERE odt = '$odt' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: existeEvento();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getODTNoProcesados($id) {

		$sql = "SELECT odt FROM nocarga_archivos WHERE archivo_id = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getODTNoProcesados();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getInventarioData($serie) {
		$sql = "SELECT *  FROM inventario WHERE no_serie = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($serie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getInventarioData();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getInventarioElavonData($serie) {
		$sql = "SELECT *  FROM elavon_universo WHERE serie = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($serie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getInventarioElavonData();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getTipo($tipo) {
		$resultado = 1;

		switch($tipo) {
			case 'TPV':
				$resultado = 1;
			break;
			case 'SIM':
				$resultado = 2;
			break;
			case 'INSUMOS':
				$resultado = 3;
			break;
		}

		return  $resultado;
	}

	function getEventosCerrados() {

		$sql = "SELECT *  FROM eventos WHERE estatus_servicio in (13,14,15,16) AND sync=0 ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($serie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getInventarioElavonData();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }

	}
}

include 'DBConnection.php';
$Procesos = new Procesos ( $db,$log );