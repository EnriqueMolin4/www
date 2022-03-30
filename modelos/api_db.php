<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

date_default_timezone_set('America/Monterrey');


include 'IConnections.php';
class Api implements IConnections {
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
			self::$logger->api ("File: api_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			return $stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			self::$logger->api($prepareStatement." ".json_encode($arrayString) );
			 
		} catch ( PDOException $e ) {
			
			self::$logger->api ("File: api_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Traspasos;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {
			
			return self::execute_ins ( $prepareStatement, $arrayString );

    }
    
    function getInventarioId($noserie) {
		$sql = "SELECT id FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	function getInventarioInsumosId($noserie,$tecnico) {
		$sql = "SELECT id FROM inventario WHERE no_serie= ? AND id_ubicacion=? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($noserie,$tecnico));
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	private static function execute_qry($prepareStatement, $arrayString) {
		
		
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: execute_qry();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}

	function select($prepareStatement, $arrayString) {

		return self::execute_qry ( $prepareStatement, $arrayString );

	}
    
    function getComercioId($afiliacion) {
		$sql = "SELECT id FROM comercios WHERE afiliacion= '$afiliacion' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getComercioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getDefaultBancoCve() {
		$sql = "SELECT cve FROM bancos WHERE status= 1 AND `default`=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getDefaultBancoCve();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
    }
    
    function getInsumos($insumo,$tecnico,$cvebanco) {
		$sql = "SELECT id,cantidad FROM inventario_tecnico WHERE no_serie= '$insumo' and tecnico= $tecnico AND cve_banco='$cvebanco' LIMIT 1";
		self::$logger->api($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
    }
    
    function existEvento($odt,$afiliacion) {
		$sql = "SELECT id FROM eventos WHERE odt= '$odt' AND afiliacion='$afiliacion' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function estatusEvento($odt) {
		$sql = "SELECT estatus FROM eventos WHERE odt= '$odt'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: estatusEvento();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existItemInventario($noserie) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' ";
		 

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existItemInventarioAsignado($noserie,$ubicacion) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' and ubicacion = $ubicacion ";
		 

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existItemInventarioAsignado();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existInsumoInventario($tecnico,$tipo,$cveBanco) {
		
		$sql = "select cantidad from inventario_tecnico
				where tecnico = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco= '$cveBanco'
				
			";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existInsumoInventario();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	
	function existInsumoInventarioTecnico($noguia,$tecnico,$tipo,$cveBanco) {
		
		$sql = "select cantidad from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco = '$cvebanco'
				AND estatus = 0
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existInsumoInventarioTecnico();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getCveBancoTraspaso($noguia,$tecnico,$tipo) {
		
		$sql = "select cve_banco from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_serie = '$tipo'
				AND estatus = 0
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCveBancoTraspaso();	Functionality: Search CVeBanco;	Log:".  $e->getMessage () );
		}
	}
	
	
	
	function getCveBancoTraspasos($noserie) {
		
		$sql = "SELECT DISTINCT cve_banco codigo,banco nombre FROM traspasos,bancos  WHERE no_guia = ? AND  traspasos.cve_banco = bancos.cve ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($noserie));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCveBancoTraspasos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	
	}
	
	function getIdTraspaso($noguia,$tecnico,$tipo,$cveBanco) {
		
		$sql = "select id from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco = '$cve_banco'
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getIdTraspaso();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getIdInventario($noserie) {
		
		$sql = "select id from inventario
				where no_serie = '$noserie'
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getIdInventario();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function searchSims($sim) {
		
		$sql = "select i.id,i.no_serie sim,i.estatus,i.estatus_inventario, i.ubicacion,i.id_ubicacion,i.fecha_creacion fechacreacion,i.fecha_edicion fechaactualizacion 
				from inventario i
				WHERE i.tipo = 2 
				and RIGHT(i.no_serie,7) =  ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($sim));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchSims();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	
	}

	function searchItemElavon($item,$tipo) {
		if($tipo ==2) {

			$sql = "select  id, serie,fabricante,estatus,estatus_modelo  
					from elavon_universo
					WHERE  RIGHT(serie,7) =  ?
					AND tipo = ? ";
		} else {
			$sql = "select  id, serie,fabricante,estatus,estatus_modelo  
					from elavon_universo
					WHERE   serie =  ?
					AND tipo = ? ";
		}
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($item,$tipo));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:".  $e->getMessage () );
		}
	}
	
	function searchItemElavonAPP($item,$tipo) {
 
			$sql = "select  id, serie,fabricante,estatus,estatus_modelo ,tipo,cve_banco
					from elavon_universo
					WHERE   serie =  ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($item));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:".  $e->getMessage () );
		}
	}
	
	function existTPVInventarioTecnico($tecnico,$noserie) {
		$sql = " select * from 
				inventario 
				WHERE inventario.no_serie = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($noserie));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existTPVInventarioTecnico();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getLastTraspasoId() {
		$sql = " Select IFNULL(MAX(id),0)+1 last from traspasos ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getClaveInsumo($insumo) {
		$sql = "SELECT codigo FROM tipo_insumos WHERE nombre= '$insumo'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getClaveInsumo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getComerciofromOdt($odt) {
		$sql = " SELECT id FROM comercios WHERE afiliacion in (Select afiliacion from eventos where odt = '$odt') ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getComerciofromOdt();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getDeviceInfo($device) {

		$sql = "SELECT * FROM deviceinfo WHERE deviceid= '$device'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getDeviceInfo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getTraspasoInfo($noserie) {

		$sql = "SELECT * FROM traspasos  WHERE no_serie= '$noserie'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTraspasoInfo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getLogin($user,$pass) {
		
		$sql = "SELECT 
				cuentas.id id_tecnico,
				cuentas.user,
				pass,
				detalle_usuarios.nombre name,
				tipo_user,
				cuentas.correo,
				supervisor,
				cve,
				1 islog
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.correo = '$user' and pass = '$pass' 
				AND estatus=1 ";

		
		try {
			$stmt = self::$connection->prepare ($sql );<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

date_default_timezone_set('America/Monterrey');


include 'IConnections.php';
class Api implements IConnections {
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
			self::$logger->api ("File: api_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			return $stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			self::$logger->api ($prepareStatement." ".json_encode($arrayString) );
			 
		} catch ( PDOException $e ) {
			
			self::$logger->api ("File: api_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Traspasos;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {
			
			return self::execute_ins ( $prepareStatement, $arrayString );

    }
    
    function getInventarioId($noserie) {
		$sql = "SELECT id FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	function getInventarioInsumosId($noserie,$tecnico) {
		$sql = "SELECT id FROM inventario WHERE no_serie= ? AND id_ubicacion=? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($noserie,$tecnico));
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	private static function execute_qry($prepareStatement, $arrayString) {
		
		
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: execute_qry();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}

	function select($prepareStatement, $arrayString) {

		return self::execute_qry ( $prepareStatement, $arrayString );

	}
    
    function getComercioId($afiliacion) {
		$sql = "SELECT id FROM comercios WHERE afiliacion= '$afiliacion' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getComercioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getDefaultBancoCve() {
		$sql = "SELECT cve FROM bancos WHERE status= 1 AND `default`=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getDefaultBancoCve();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
    }
    
    function getInsumos($insumo,$tecnico,$cvebanco) {
		$sql = "SELECT id,cantidad FROM inventario_tecnico WHERE no_serie= '$insumo'  and tecnico= $tecnico AND cve_banco='$cvebanco' LIMIT 1";
		self::$logger->api ($sql);
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
    }
    
    function existEvento($odt,$afiliacion) {
		$sql = "SELECT id FROM eventos WHERE odt= '$odt' AND afiliacion='$afiliacion' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function estatusEvento($odt) {
		$sql = "SELECT estatus FROM eventos WHERE odt= '$odt'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: estatusEvento();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existItemInventario($noserie) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' ";
		 

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existItemInventarioAsignado($noserie,$ubicacion) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' and ubicacion = $ubicacion ";
		 

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existItemInventarioAsignado();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function existInsumoInventario($tecnico,$tipo,$cveBanco) {
		 
		$sql = "select cantidad from inventario_tecnico
				where tecnico = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco= '$cveBanco'
				
			";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existInsumoInventario();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	
	function existInsumoInventarioTecnico($noguia,$tecnico,$tipo,$cvebanco) {
		
		$sql = "select cantidad from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco = '$cvebanco'
				AND estatus = 0
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existInsumoInventarioTecnico();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getCveBancoTraspaso($noguia,$tecnico,$tipo) {
		
		$sql = "select cve_banco from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_serie = '$tipo'
				AND estatus = 0
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCveBancoTraspaso();	Functionality: Search CVeBanco;	Log:".  $e->getMessage () );
		}
	}
	
	
	
	function getCveBancoTraspasos($noserie) {
		
		$sql = "SELECT DISTINCT cve_banco codigo,banco nombre FROM traspasos,bancos  WHERE no_guia = ? AND  traspasos.cve_banco = bancos.cve ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($noserie));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCveBancoTraspasos();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	
	}
	
	function getIdTraspaso($noguia,$tecnico,$tipo,$cveBanco) {
		
		$sql = "select id from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
				AND cve_banco = '$cve_banco'
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getIdTraspaso();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getIdInventario($noserie) {
		
		$sql = "select id from inventario
				where no_serie = '$noserie'
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getIdInventario();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function searchSims($sim) {
		
		$sql = "select i.id,i.no_serie sim,i.estatus,i.estatus_inventario, i.ubicacion,i.id_ubicacion,i.fecha_creacion fechacreacion,i.fecha_edicion fechaactualizacion 
				from inventario i
				WHERE i.tipo = 2 
				and RIGHT(i.no_serie,7) =  ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($sim));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchSims();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	
	}

	function searchItemElavon($item,$tipo) {
		if($tipo ==2) {

			$sql = "select  id, serie,fabricante,estatus,estatus_modelo  
					from elavon_universo
					WHERE  RIGHT(serie,7) =  ?
					AND tipo = ? ";
		} else {
			$sql = "select  id, serie,fabricante,estatus,estatus_modelo  
					from elavon_universo
					WHERE   serie =  ?
					AND tipo = ? ";
		}
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($item,$tipo));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:".  $e->getMessage () );
		}
	}
	
	function searchItemElavonAPP($item,$tipo) {
 
			$sql = "select  id, serie,fabricante,estatus,estatus_modelo ,tipo,cve_banco 
					from elavon_universo
					WHERE   serie =  ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($item));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:".  $e->getMessage () );
		}
	}
	
	function existTPVInventarioTecnico($tecnico,$noserie) {
		$sql = " select * from 
				inventario 
				WHERE inventario.no_serie = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($noserie));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: existTPVInventarioTecnico();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getLastTraspasoId() {
		$sql = " Select IFNULL(MAX(id),0)+1 last from traspasos ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getClaveInsumo($insumo) {
		$sql = "SELECT codigo FROM tipo_insumos WHERE nombre= '$insumo'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getClaveInsumo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getComerciofromOdt($odt) {
		$sql = " SELECT id FROM comercios WHERE afiliacion in (Select afiliacion from eventos where odt = '$odt') ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getComerciofromOdt();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getDeviceInfo($device) {

		$sql = "SELECT * FROM deviceinfo WHERE deviceid= '$device'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getDeviceInfo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getTraspasoInfo($noserie) {

		$sql = "SELECT * FROM traspasos  WHERE no_serie= '$noserie'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTraspasoInfo();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getLogin($user,$pass) {
		
		$sql = "SELECT 
				cuentas.id id_tecnico,
				cuentas.user,
				pass,
				detalle_usuarios.nombre name,
				tipo_user,
				cuentas.correo,
				supervisor,
				cve,
				1 islog
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.correo = '$user' and pass = '$pass' 
				AND estatus=1 ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getLogin();	Functionality: Search Login;	Log:".  $e->getMessage () );
		}
	}
	
	function getEventoDetalle($odt,$userid) {

		$sql = "SELECT  eventos.id idevento ,eventos.odt,ifnull(hora_llegada,'') hora_llegada ,
        ifnull(hora_salida,'') hora_salida, 
        eventos.afiliacion,
        ifnull(comercios.comercio,'Sin Comercio') comercio,
        ifnull(eventos.comercio,0) comercioid,
        tipo_servicio.nombre servicio, 
        eventos.tecnico idtecnico ,
        count(img.id) totalimg , 
        eventos.tipo_servicio servicioid ,
        CASE WHEN tipo_servicio.obligatorio = 1 THEN 1
		 WHEN tipo_servicio.obligatorio = 2 THEN 1
		 ELSE 0 END tpvinstaladorule,
		CASE WHEN tipo_servicio.obligatorio = 2 THEN 1
		 WHEN tipo_servicio.obligatorio = 3 THEN 1
		 ELSE 0 END tpvretiradorule,
		IFNULL(eventos.tpv_retirado,'') tpvretirado,
        IFNULL(eventos.tpv_instalado,'') tpvinstalado,
        DATE(fecha_vencimiento) fechavencimiento ,eventos.fecha_alta,
        CASE WHEN DATEDIFF(NOW(),fecha_vencimiento) > 2 THEN 'red'
            WHEN  DATEDIFF(NOW(),fecha_vencimiento) = 1  THEN 'orange'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 24 THEN 'yellow'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 5  THEN 'red' 
            ELSE 'green' 
        END color,
        eventos.descripcion as description,
        eventos.estatus,
		eventos.estatus_servicio,
        ifnull(eventos.receptor_servicio,'') receptorservicio,
        ifnull(eventos.rollos_instalar,0) rollosinstalar,
        ifnull(eventos.rollos_entregados,0) rollosentregados,
        eventos.folio_telecarga ,
        eventos.hora_ticket,
        eventos.id_caja,
        eventos.aplicativo,
        eventos.version	,
		eventos.tecnico,
		eventos.comentarios,
		eventos.sim_instalado,
		eventos.sim_retirado
        from eventos 
        LEFT JOIN comercios ON eventos.comercio = comercios.id
        LEFT JOIN img ON img.odt = eventos.odt  AND  img.tecnico = eventos.tecnico
        ,tipo_servicio
        WHERE eventos.odt = ?
        AND eventos.tipo_servicio = tipo_servicio.id
        GROUP BY eventos.odt,eventos.id ,eventos.afiliacion,comercios.comercio  
		";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getEventoDetalle();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getTpvComercio($comercio) {
		$sql = "SELECT no_serie FROM inventario where id_ubicacion IN (
			Select comercio from eventos where odt = ? )
			AND ubicacion= 2
			AND tipo=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($comercio));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTpvComercio();	Functionality: Search Configuracion;	Log:". $e->getMessage () );
		}
	}

	function getImagefromOdt($odt) {
		$sql = "SELECT dir_img FROM img  WHERE odt = ?  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getImagefromOdt();	Functionality: Search Img;	Log:". $e->getMessage () );
		}
	}

	function getConfiguration($config) {

		$sql = "SELECT * FROM configuracion  WHERE nombre = '$config'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getConfiguration();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}

	function getServicioOdt($odt) {

		$sql = "SELECT 
				e.tipo_servicio,
				IFNULL(co.sim_instalado,0) sim_instalado,
				IFNULL(co.sim_retirado,0) sim_retirado,
				IFNULL(co.rollos,0) rollos,
				IFNULL(co.hora_ticket,0) hora_ticket,
				IFNULL(co.folio_telecarga,0) folio_telecarga,
				IFNULL(co.id_caja,0) id_caja,
				IFNULL(co.aplicativo,0) aplicativo,
				IFNULL(co.version,0) version,
				IFNULL(co.tvp_instalada,0) tvp_instalada,
				IFNULL(co.tvp_salida,0) tvp_salida,
				ts.tipo_terminal
				FROM eventos e 
				LEFT JOIN campos_obligatorios co ON  e.tipo_servicio = co.servicio_id
				LEFT JOIN tipo_servicio ts ON ts.id = e.tipo_servicio
				WHERE e.odt = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getServicioOdt();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	
	
	function getTraspasosTecnico($tecnico) {

			/*$sql = " Select traspaso.no_guia,traspaso.codigo_rastreo,traspaso.origen,traspaso.destino, traspaso.cuenta_id,traspaso.tipo_traspaso, traspaso.total, traspasoNoActivo.total totalnoactivo,traspaso.fecha_creacion from 
			(
            Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
                    WHERE cuenta_id = $tecnico       
            GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspaso,
			(
				Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
						WHERE cuenta_id = $tecnico 
						AND estatus = 0      
				GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspasoNoActivo 
			WHERE traspaso.no_guia = traspasoNoActivo.no_guia;  "; */
			
			$sql = "Select traspaso.no_guia,traspaso.codigo_rastreo,traspaso.origen,traspaso.destino, traspaso.cuenta_id,traspaso.tipo_traspaso, traspaso.total, ifnull(traspasoNoActivo.total,0) totalnoactivo,traspaso.fecha_creacion from 
			(
            Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
                    WHERE cuenta_id = $tecnico   
                     
            GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspaso LEFT JOIN 
			(
				Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
						WHERE cuenta_id = $tecnico 
						AND estatus = 1     
				GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspasoNoActivo 
			ON traspaso.no_guia = traspasoNoActivo.no_guia; ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTraspasosTecnico();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	function getCamposObligatorios($servicioid,$cvebanco) {
		$sql = "SELECT * FROM campos_obligatorios  WHERE subservicio_id = ? and cve_banco=?  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($servicioid,$cvebanco));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCamposObligatorios();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	function getTecnicoInfo($tecnico) {
		
		$sql = "SELECT 
				cuentas.id id_tecnico,
				cuentas.plaza,
				cuentas.territorial,cuentas.almacen,
				detalle_usuarios.nombre name,
				tipo_user,
				email,
				supervisor,
				cve 
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.id = '$tecnico' ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getLogin();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getEventoData($odt) {
		
		$sql = "SELECT id,tecnico FROM eventos WHERE odt= '$odt' ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getEventoData();	Functionality: Search Eventos;	Log: ".$sql." ".  $e->getMessage () );
		}
	}
	
	function getServicioIdOdt($odt) {
		
		$sql = " SELECT eventos.tipo_servicio,eventos.servicio subservicio,eventos.odt,tipo_servicio.tipo_terminal,eventos.estatus_servicio 
				 FROM eventos,tipo_servicio 
				 WHERE eventos.tipo_servicio = tipo_servicio.id  AND eventos.odt= ? ";
				 

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getServicioIdOdt();	Functionality: Search Eventos;	Log: ".$sql." ".  $e->getMessage () );
		}
	}
	
	function getConfiguraciones() {
		
		$sql = "SELECT * FROM configuracion ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getConfiguraciones();	Functionality: GET Configuracion;	Log: ".  $e->getMessage () );
		}
	}
	
	function getcveBanco($odt)
	{
		
		$sql = "SELECT cve_banco FROM eventos  where odt=? ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getcveBanco();	Functionality: GET CveBanco;	Log: ".  $e->getMessage () );
		}
		
	}
	
	function getInventarioTecnico($tecnico)
	{
		$sql = "SELECT cve_banco FROM eventos  where odt=? ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioTecnico();	Functionality: GET CveBanco;	Log: ".  $e->getMessage () );
		}
	}
	
	
	
}
//
include 'DBConnection.php';
$Api = new Api ( $db,$log );




?>
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getLogin();	Functionality: Search Login;	Log:".  $e->getMessage () );
		}
	}
	
	function getEventoDetalle($odt,$userid) {

		$sql = "SELECT  eventos.id idevento ,eventos.odt,ifnull(hora_llegada,'') hora_llegada ,
        ifnull(hora_salida,'') hora_salida, 
        eventos.afiliacion,
        ifnull(comercios.comercio,'Sin Comercio') comercio,
        ifnull(eventos.comercio,0) comercioid,
        tipo_servicio.nombre servicio, 
        eventos.tecnico idtecnico ,
        count(img.id) totalimg , 
        eventos.tipo_servicio servicioid ,
        CASE WHEN tipo_servicio.obligatorio = 1 THEN 1
		 WHEN tipo_servicio.obligatorio = 2 THEN 1
		 ELSE 0 END tpvinstaladorule,
		CASE WHEN tipo_servicio.obligatorio = 2 THEN 1
		 WHEN tipo_servicio.obligatorio = 3 THEN 1
		 ELSE 0 END tpvretiradorule,
		IFNULL(eventos.tpv_retirado,'') tpvretirado,
        IFNULL(eventos.tpv_instalado,'') tpvinstalado,
        DATE(fecha_vencimiento) fechavencimiento ,eventos.fecha_alta,
        CASE WHEN DATEDIFF(NOW(),fecha_vencimiento) > 2 THEN 'red'
            WHEN  DATEDIFF(NOW(),fecha_vencimiento) = 1  THEN 'orange'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 24 THEN 'yellow'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 5  THEN 'red' 
            ELSE 'green' 
        END color,
        eventos.descripcion as description,
        eventos.estatus,
		eventos.estatus_servicio,
        ifnull(eventos.receptor_servicio,'') receptorservicio,
        ifnull(eventos.rollos_instalar,0) rollosinstalar,
        ifnull(eventos.rollos_entregados,0) rollosentregados,
        eventos.folio_telecarga ,
        eventos.hora_ticket,
        eventos.id_caja,
        eventos.aplicativo,
        eventos.version	,
		eventos.tecnico,
		eventos.comentarios,
		eventos.sim_instalado,
		eventos.sim_retirado
        from eventos 
        LEFT JOIN comercios ON eventos.comercio = comercios.id
        LEFT JOIN img ON img.odt = eventos.odt  AND  img.tecnico = eventos.tecnico
        ,tipo_servicio
        WHERE eventos.odt = ?
        AND eventos.tipo_servicio = tipo_servicio.id
        GROUP BY eventos.odt,eventos.id ,eventos.afiliacion,comercios.comercio  
		";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getEventoDetalle();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}
	
	function getTpvComercio($comercio) {
		$sql = "SELECT no_serie FROM inventario where id_ubicacion IN (
			Select comercio from eventos where odt = ? )
			AND ubicacion= 2
			AND tipo=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($comercio));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTpvComercio();	Functionality: Search Configuracion;	Log:". $e->getMessage () );
		}
	}

	function getImagefromOdt($odt) {
		$sql = "SELECT dir_img FROM img  WHERE odt = ?  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getImagefromOdt();	Functionality: Search Img;	Log:". $e->getMessage () );
		}
	}

	function getConfiguration($config) {

		$sql = "SELECT * FROM configuracion  WHERE nombre = '$config'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getConfiguration();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}

	function getServicioOdt($odt) {

		$sql = "SELECT 
				e.tipo_servicio,
				IFNULL(co.sim_instalado,0) sim_instalado,
				IFNULL(co.sim_retirado,0) sim_retirado,
				IFNULL(co.rollos,0) rollos,
				IFNULL(co.hora_ticket,0) hora_ticket,
				IFNULL(co.folio_telecarga,0) folio_telecarga,
				IFNULL(co.id_caja,0) id_caja,
				IFNULL(co.aplicativo,0) aplicativo,
				IFNULL(co.version,0) version,
				IFNULL(co.tvp_instalada,0) tvp_instalada,
				IFNULL(co.tvp_salida,0) tvp_salida
				FROM eventos e 
				LEFT JOIN campos_obligatorios co ON  e.tipo_servicio = co.servicio_id
				WHERE e.odt = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getServicioOdt();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	
	
	function getTraspasosTecnico($tecnico) {

			/*$sql = " Select traspaso.no_guia,traspaso.codigo_rastreo,traspaso.origen,traspaso.destino, traspaso.cuenta_id,traspaso.tipo_traspaso, traspaso.total, traspasoNoActivo.total totalnoactivo,traspaso.fecha_creacion from 
			(
            Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
                    WHERE cuenta_id = $tecnico       
            GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspaso,
			(
				Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
						WHERE cuenta_id = $tecnico 
						AND estatus = 0      
				GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspasoNoActivo 
			WHERE traspaso.no_guia = traspasoNoActivo.no_guia;  "; */
			
			$sql = "Select traspaso.no_guia,traspaso.codigo_rastreo,traspaso.origen,traspaso.destino, traspaso.cuenta_id,traspaso.tipo_traspaso, traspaso.total, ifnull(traspasoNoActivo.total,0) totalnoactivo,traspaso.fecha_creacion from 
			(
            Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
                    WHERE cuenta_id = $tecnico   
                     
            GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspaso LEFT JOIN 
			(
				Select no_guia,codigo_rastreo,origen,destino,cuenta_id ,count(estatus) total,tipo_traspaso,MAX(fecha_creacion) fecha_creacion from traspasos
						WHERE cuenta_id = $tecnico 
						AND estatus = 1     
				GROUP BY no_guia,codigo_rastreo,origen,destino,cuenta_id,tipo_traspaso
			) traspasoNoActivo 
			ON traspaso.no_guia = traspasoNoActivo.no_guia; ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getTraspasosTecnico();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	function getCamposObligatorios($servicioid,$cvebanco) {
		$sql = "SELECT * FROM campos_obligatorios  WHERE subservicio_id = ? and cve_banco = ? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($servicioid,$cvebanco));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getCamposObligatorios();	Functionality: Search Configuracion;	Log:".  $e->getMessage () );
		}
	}
	
	function getTecnicoInfo($tecnico) {
		
		$sql = "SELECT 
				cuentas.id id_tecnico,
				cuentas.plaza,
				cuentas.territorial,cuentas.almacen,
				detalle_usuarios.nombre name,
				tipo_user,
				email,
				supervisor,
				cve 
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.id = '$tecnico' ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getLogin();	Functionality: Search Carriers;	Log:".  $e->getMessage () );
		}
	}

	function getEventoData($odt) {
		
		$sql = "SELECT id,tecnico FROM eventos WHERE odt= '$odt' ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getEventoData();	Functionality: Search Eventos;	Log: ".$sql." ".  $e->getMessage () );
		}
	}
	
	function getServicioIdOdt($odt) {
		
		$sql = " SELECT eventos.tipo_servicio,eventos.servicio subservicio,eventos.odt,tipo_servicio.tipo_terminal, eventos.estatus_servicio
				 FROM eventos,tipo_servicio 
				 WHERE eventos.tipo_servicio = tipo_servicio.id  AND eventos.odt= ? ";
				 

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getServicioIdOdt();	Functionality: Search Eventos;	Log: ".$sql." ".  $e->getMessage () );
		}
	}
	
	function getConfiguraciones() {
		
		$sql = "SELECT * FROM configuracion ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getConfiguraciones();	Functionality: GET Configuracion;	Log: ".  $e->getMessage () );
		}
	}


	function getcveBanco($odt)
	{
		
		$sql = "SELECT cve_banco FROM eventos  where odt=? ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getcveBanco();	Functionality: GET CveBanco;	Log: ".  $e->getMessage () );
		}
		
	}

	function getInventarioTecnico($tecnico)
	{
		$sql = "SELECT cve_banco FROM eventos  where odt=? ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->api ("File: api_db.php;	Method Name: getInventarioTecnico();	Functionality: GET CveBanco;	Log: ".  $e->getMessage () );
		}
	}



	
	
	
}
//
include 'DBConnection.php';
$Api = new Api ( $db,$log );




?>