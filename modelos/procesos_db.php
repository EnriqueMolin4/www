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
			self::$logger->error ("File: procesos_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: procesos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
		}
	}

	private static function execute_upd($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			return $stmt->rowCount();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: execute_upd();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
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
			self::$logger->error ("File: procesos_db.php;	Method Name: getProcesos();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getOlderCargas($tipo) {
		
		$sql = "SELECT * from carga_archivos WHERE activo= 1 AND tipo =  ? AND  id = (SELECT MAX(id) FROM carga_archivos ) ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($tipo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC  );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getOlderCargas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

	function getCargasEnProceso($tipo) {
		
		$sql = "SELECT count(*) from carga_archivos WHERE activo= 1 AND procesar = 1 AND tipo = '$tipo' ";
		 
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($tipo));
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0  );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getCargasEnProceso();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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

	function getAplicativoxNombre($aplicativo) {
		$sql = "SELECT id FROM tipo_aplicativo WHERE nombre LIKE '%$aplicativo%' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getAplicativoxNombre();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	} 


	function getComercioxAfiliacion($afiliacion) {
		$sql = "SELECT id FROM comercios WHERE afiliacion = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($afiliacion));
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: procesos_db.php;	Method Name: getComercioxAfiliacion();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
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

	function getEventosCerrados($odt) {

		$sql = "SELECT *  ,tv.nombre nombreVersion
				FROM eventos 
				LEFT JOIN eventos_tpvretirado et ON et.odt = eventos.odt 
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = eventos.tecnico
				LEFT JOIN cuentas c ON c.id = eventos.tecnico
				LEFT JOIN tipo_version tv ON tv.id = eventos.version
				WHERE eventos.sync=0  AND eventos.odt=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($odt));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getEventosCerrados();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }

	}

	function getSeriesData($noserie) {

		$sql = "SELECT 
				i.no_serie,
				CASE WHEN i.tipo=1 THEN m.clave_elavon  ELSE 0 END modelo ,
				tc.clave_elavon conectividad, 
				pe.clave_elavon marca
				FROM inventario i
				LEFT JOIN tipo_conectividad tc ON tc.id = i.conectividad
				LEFT JOIN modelos m ON m.id = i.modelo
				LEFT JOIN tipo_proveedor_equipos pe ON pe.nombre = m.proveedor
				WHERE i.no_serie=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($noserie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getSeriesData();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getOdtImages($odt) {

		$sql = "SELECT *  FROM img WHERE odt = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($odt));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getOdtImages();	Functionality: Get Image by ODT;	Log:" . $e->getMessage () );
        }
	}
	 
	function existeUniversoElavon($serie) {
		$sql = " SELECT * FROM elavon_universo WHERE serie=? ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($serie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: existeUniversoElavon();	Functionality: Get Image by ODT;	Log:" . $e->getMessage () );
        }

	}

	function existeInventario($serie) {
		$sql = " SELECT * FROM inventario WHERE no_serie=? ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($serie));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: existeInventario();	Functionality: Get inventario;	Log:" . $e->getMessage () );
        }

	}

	function getModeloId($modelo) {
		$sql = " SELECT * FROM modelos WHERE modelo LIKE '%$modelo%' ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($modelo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getModeloId();	Functionality: Get inventario;	Log:" . $e->getMessage () );
        }

	}

	function getConectividadId($modelo) {
		$sql = " SELECT * FROM tipo_conectividad WHERE nombre=? ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($modelo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getConectividadId();	Functionality: Get inventario;	Log:" . $e->getMessage () );
        }

	}

	function getCarrierId($modelo) {
		$sql = " SELECT * FROM carriers  WHERE nombre=? ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($modelo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getCarrierId();	Functionality: Get inventario;	Log:" . $e->getMessage () );
        }

	}

	function getComercioId($afiliacion) {
		$sql = " SELECT * FROM comercios  WHERE afiliacion=? ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($afiliacion));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getComercioId();	Functionality: Get inventario;	Log:" . $e->getMessage () );
        }

	}

	function getGeolocalizacion($comercio) {
		$sql = "SELECT latitud,longitud  FROM comercios WHERE afiliacion = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($comercio));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: procesos_db.php;	Method Name: getGeolocalizacion();	Functionality: Get Geoocalizacion;	Log:" . $e->getMessage () );
        }
	}
}

include 'DBConnection.php';
$Procesos = new Procesos ( $db,$log );