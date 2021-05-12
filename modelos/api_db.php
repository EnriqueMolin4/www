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
	private function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Traspasos;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	private function execute_qry($prepareStatement, $arrayString) {
		
		
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: execute_qry();	Functionality: Insert;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: getComercioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getDefaultBancoCve() {
		$sql = "SELECT cve FROM bancos WHERE status= 1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getDefaultBancoCve();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
    }
    
    function getInsumos($insumo,$tecnico) {
		$sql = "SELECT id,cantidad FROM inventario_tecnico WHERE no_serie= '$insumo'  and tecnico= $tecnico LIMIT 1";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
    }
    
    function existEvento($odt,$afiliacion) {
		$sql = "SELECT id FROM eventos WHERE odt= '$odt' AND afiliacion='$afiliacion' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function estatusEvento($odt) {
		$sql = "SELECT estatus FROM eventos WHERE odt= '$odt'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: estatusEvento();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existItemInventario($noserie) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' ";
		 

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getInsumos();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existInsumoInventario($tecnico,$tipo) {
		
		$sql = "select cantidad from inventario_tecnico
				where tecnico = '$tecnico'
				AND no_Serie = '$tipo'
				
			";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: existInsumoInventario();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function existInsumoInventarioTecnico($noguia,$tecnico,$tipo) {
		
		$sql = "select cantidad from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
				AND estatus = 0
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: existInsumoInventarioTecnico();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getIdTraspaso($noguia,$tecnico,$tipo) {
		
		$sql = "select id from traspasos
				where no_guia = '$noguia'
				AND cuenta_id = '$tecnico'
				AND no_Serie = '$tipo'
        ";
 
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getIdTraspaso();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: searchSims();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function searchItemElavonAPP($item,$tipo) {
 
			$sql = "select  id, serie,fabricante,estatus,estatus_modelo ,tipo 
					from elavon_universo
					WHERE   serie =  ? ";
		 
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute (array($item));
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: searchItemElavon();	Functionality: Search Elavon;	Log:". $sql . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: existTPVInventarioTecnico();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getLastTraspasoId() {
		$sql = " Select IFNULL(MAX(id),0)+1 last from traspasos ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getClaveInsumo($insumo) {
		$sql = "SELECT codigo FROM tipo_insumos WHERE nombre= '$insumo'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getClaveInsumo();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getComerciofromOdt($odt) {
		$sql = " SELECT id FROM comercios WHERE afiliacion in (Select afiliacion from eventos where odt = '$odt') ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getComerciofromOdt();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getDeviceInfo($device) {

		$sql = "SELECT * FROM deviceinfo WHERE deviceid= '$device'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getDeviceInfo();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTraspasoInfo($noserie) {

		$sql = "SELECT * FROM traspasos  WHERE no_serie= '$noserie'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getTraspasoInfo();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getLogin($user,$pass) {
		
		$sql = "SELECT 
				cuentas.id id_tecnico,
				cuentas.user,
				pass,
				detalle_usuarios.nombre name,
				tipo_user,
				email,
				supervisor,
				cve,
				1 islog
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND email = '$user' and pass = '$pass' 
				AND estatus=1 ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getLogin();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
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
		eventos.tpv_retirado tpvretirado,
        eventos.tpv_instalado tpvinstalado,
        DATE(fecha_vencimiento) fechavencimiento ,eventos.fecha_alta,
        CASE WHEN DATEDIFF(NOW(),fecha_vencimiento) > 2 THEN 'red'
            WHEN  DATEDIFF(NOW(),fecha_vencimiento) = 1  THEN 'orange'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 24 THEN 'yellow'
            WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 5  THEN 'red' 
            ELSE 'green' 
        END color,
        eventos.descripcion as description,
        eventos.estatus,
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
			self::$logger->error ("File: api_db.php;	Method Name: getEventoDetalle();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getConfiguration($config) {

		$sql = "SELECT * FROM configuracion  WHERE nombre = '$config'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getConfiguration();	Functionality: Search Configuracion;	Log:". $sql . $e->getMessage () );
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
			self::$logger->error ("File: api_db.php;	Method Name: getTraspasosTecnico();	Functionality: Search Configuracion;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getCamposObligatorios($servicioid) {
		$sql = "SELECT * FROM campos_obligatorios  WHERE servicio_id = ?  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($servicioid));
			return $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: api_db.php;	Method Name: getCamposObligatorios();	Functionality: Search Configuracion;	Log:". $sql . $e->getMessage () );
		}
	}

	
	
}
//
include 'DBConnection.php';
$Api = new Api ( $db,$log );




?>