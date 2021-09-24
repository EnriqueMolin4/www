<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

date_default_timezone_set('America/Monterrey');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Almacen implements IConnections {
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
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: execute_sel();	Functionality: Insert;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Traspasos;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
    
	
	function getModelosTPV() {
		
		$sql = "select *,getNameById(proveedor,'Proveedor') proveedorNombre from modelos";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getModelosTPV();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	
	function getCarriers() {
		
		$sql = "select * from carriers";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getCarriers();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getStatus() {
		
		$sql = "select * from tipo_estatus_modelos WHERE estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getStatus();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
	
	function getStatusUbicacion() {
		
		$sql = "select * from tipo_estatus_inventario where estatus=1";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getStatusUbicacion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
	
	
    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";
		
		$estatus = $params['tipo_estatus'];
		$producto = $params['tipo_producto'];
		$almacen = $_SESSION['almacen'];

		
		if( $estatus != '0' ) {
			$where .= " AND estatus = '$estatus' ";
		}

		if( $producto != '0' ) {
			$where .= " AND  tipo = $producto ";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( serie LIKE '".$params['search']['value']."%' ";
			$where .=" OR fabricante LIKE '".$params['search']['value']."%' ";
			$where .=" OR estatus LIKE '".$params['search']['value']."%'  ) ";


		}

		$sql = " SELECT *
                 FROM elavon_universo
                 WHERE estatus_modelo != -1 
				 $where
				-- group by inv.id
                $filter ";
        self::$logger->error($sql);
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
    }
    
    function getTableTotal() {

        $sql = " SELECT count(*) Total FROM elavon_universo   ";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTableTotal();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
    }

    function getInventarioTecnico($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";
		$whereF = "";
		$tecnico = $params['tecnico'] ;
		$producto = $params['tipo_producto'];
		$estatus = $params['estatus'];
		$almacenId = $_SESSION['almacen'];


		if( $tecnico != '0' ) {
			$where .= " AND du.cuenta_id = $tecnico ";
		}

		if( $producto != '0' ) {
			$where .= " AND i.tipo = $producto ";
		}

		if( $estatus != '0' ) {
			$where .= " AND i.estatus = $estatus ";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( du.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR du.apellidos LIKE '".$params['search']['value']."%'  ";
			$where .=" OR it.no_serie LIKE '".$params['search']['value']."%'  )";
		}
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'supervisor' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN') { 
			$userId = $_SESSION['userid'] ;
			
			$where .= " AND it.tecnico in ( SELECT id FROM cuentas WHERE almacen in ($almacenId ) ) ";
		}


		$sql = "SELECT
				it.id,
				tecnico,
				CONCAT(du.nombre,' ',ifnull(du.apellidos,'')) nombreTecnico,
				CASE WHEN i.tipo= '1' THEN 'TPV' WHEN i.tipo = '2' THEN 'SIM' WHEN i.tipo = '3' THEN 'Insumos' END  producto,
				it.no_serie,
				it.cantidad,
				tm.nombre estatus,
				fecha_modificacion,
				i.estatus estatusId,
				ifnull(tp.estatus,0) estatustraspaso
				FROM inventario_tecnico it
								LEFT JOIN traspasos tp ON tp.no_serie = it.no_serie
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = it.tecnico, inventario i
				LEFT JOIN tipo_estatus_modelos tm ON i.estatus = tm.id
				WHERE it.no_serie = i.no_serie
				$where
				$filter ";



		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInventarioTecnico();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}

	}

	function getTipoServicios() {
		$sql = "SELECT * from tipo_servicio ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTipoServicios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoFallas() {
		$sql = "SELECT * from tipo_falla ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTipoFallas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	
	function getEquipos($cve,$afiliacion) {
		$sql = "SELECT id,no_serie from almacen where cve_banco=? AND afiliacion=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cve,$afiliacion));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getEquipos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	
	function getTotalEventos() {
		$sql = "SELECT * Total from eventos";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTotalEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	
    function getConectividad() {

		$sql = "select id,  nombre from tipo_conectividad ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getConectividad();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getFabricantes() {

		$sql = "select id,  nombre from tipo_proveedor_equipos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getFabricantes();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos() {

		$sql = "select id,  banco nombre from bancos where status= 1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getBancos();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
    }

	
	function getInsumos() {

		$sql = "select id,  nombre from tipo_insumos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInsumos();	Functionality: Get Insumos price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getCantidadInsumos($insumo) {
		$sql = "select id,cantidad from inventario where insumo = ? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($insumo));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getCantidadInsumos();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getCantidadInsumosTecnico($insumo,$tecnico) {
		$sql = "select id,cantidad from inventario_tecnico where insumo = ? and tecnico = ?";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($insumo,$tecnico));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getCantidadInsumosTecnico();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getubicacion() {
		
		
		$sql = "SELECT * from tipo_ubicacion where status=1  order by almacen DESC";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getubicacion();	Functionality: Get Ubicaciones;	Log:" . $e->getMessage () );
        }
	}

	function getHistoria($params,$total) {
		$start = $params['start'];
		$length = $params['length'];
		$where = "";
		$filter = "";
		$param = "";
		$id= $params['noSerie'];
		$tipo = $params['tipo'];
		$query = "";

		if($id == '') {
			$id = -1;
		}
		
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( m.modelo LIKE '".$params['search']['value']."%' ";
			$where .=" OR em.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR c.comercio LIKE '".$params['search']['value']."%'  ";
			$where .=" OR tu.nombre LIKE '".$params['search']['value']."%'  )";

		}

		$sql = "SELECT 
				historial.id ,
				fecha_movimiento,
                CASE WHEN tipo = '1' THEN 'TPV' WHEN tipo = '2' THEN 'SIM' WHEN tipo = '3' THEN 'INSUMOS' WHEN tipo = '4' THEN 'ACCESORIOS' END producto,
				cantidad,
				tipo_ubicacion.nombre ubicacionNombre,
				GetUbicacionId(id_ubicacion,ubicacion) id_ubicacion
				FROM historial
				LEFT JOIN tipo_ubicacion ON tipo_ubicacion.id = historial.ubicacion 
				WHERE  historial.no_serie = '$id' ";

		
		 
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getHistoria();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}

	function getTecnicos($territorio) {

		$almacen = $_SESSION['almacen'];
		$tipo = $_SESSION['tipo_user'];

		$where = '';

		if($tipo == 'admin' || $tipo == 'CA') {

		}  else {
			$where .= " AND cuentas.almacen  in ($almacen) ";
		}

		$sql = "SELECT *, cuentas.id tecnicoId, cuentas.territorial territorio , cuentas.almacen almacen 
				from cuentas,detalle_usuarios 
				WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 AND cuentas.estatus = 1  $where
				order By detalle_usuarios.nombre";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function buscarNoSerie($nom_serie,$tipo) {
		$sql = "SELECT count(*) existe from inventario  WHERE no_serie = '$nom_serie'  AND estatus = 5 AND ubicacion  = 1 AND tipo = $tipo ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: buscarNoSerie();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getinvInsumo($insumo) {
		$sql = "SELECT cantidad from inventario  WHERE insumo = $insumo AND ubicacion=1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getinvInsumo();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getAlmacen() {
		
		
		$sql = "SELECT id,nombre from tipo_ubicacion  WHERE almacen =1  ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getAlmacen();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInvId($noserie) {
		$sql = "SELECT id FROM inventario  WHERE no_serie = '$noserie'  ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInvId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTraspasos($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$tecnico = $params['tecnico'] ;
		$where = '';
		$almacen = $params['almacen'];

		if( $tecnico != '0' ) {
			$where .= " AND t1.cuenta_id = $tecnico ";
		}

		if( $almacen != '0' ) {
			$where .= " AND t1.origen = $almacen  OR t1.destino = $almacen ";
		}

	
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( t1.no_guia LIKE '".$params['search']['value']."%' ";
			$where .=" OR detalle_usuarios.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR detalle_usuarios.apellidos LIKE '".$params['search']['value']."%'  )";


		}
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'AL') {
			$userId = $_SESSION['userid'] ;
			$where .= " AND t1.cuenta_id in ( SELECT id FROM cuentas WHERE territorial in (Select territorial FROM cuentas WHERE id = $userId ) ) ";
		}
		
		$sql = "SELECT *, CASE WHEN trasp != total THEN 'ACEPTADO' ELSE 'EN TRANSITO' END estatus FROM ( SELECT 
				t1.no_guia,
				t1.codigo_rastreo,
				CASE WHEN GetNameById(t1.origen,'AlmacenTraspaso') IS NULL THEN  CONCAT(nombre,' ',ifnull(apellidos,''))  ELSE GetNameById(t1.origen,'AlmacenTraspaso')  END origen,
				CASE WHEN t1.destino = 0 THEN CONCAT(nombre,' ',ifnull(apellidos,''))  ELSE GetNameById(t1.destino,'AlmacenTraspaso') END destino,
				MAX(t1.fecha_creacion) fecha_creacion ,
				count(*) total,
				(Select count(*) total FROM traspasos t2 WHERE t2.no_guia= t1.no_guia and estatus = 0 ) trasp
				FROM traspasos t1
				LEFT JOIN detalle_usuarios ON t1.cuenta_id = detalle_usuarios.cuenta_id
				WHERE t1.id != -1 
				$where  
				GROUP BY t1.no_guia,t1.codigo_rastreo,t1.origen,t1.destino,nombre,apellidos ) traspasos ;
				$filter ";

		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTraspasos();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getProductosNoGuia($params,$total) {

		$noguia = $params['no_guia'];
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = '';

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( t.no_guia LIKE '".$params['search']['value']."%' ";
			$where .=" OR t.no_serie LIKE '".$params['search']['value']."%' )  ";

		}

		$sql = " SELECT t.id, t.tipo,
				 t.no_serie,
				 CASE WHEN t.tipo= 'TPV' THEN GetNameById(t.modelo,'Modelo') 
				 	  WHEN t.tipo = 'SIM' THEN GetNameById(t.modelo,'Carrier')  
				      WHEN t.tipo = 'INSUMO' THEN 'NO APLICA' END modelo,
				 CASE WHEN t.tipo = 'INSUMO' THEN t.cantidad ELSE 'NO APLICA' END cantidad,
				 CASE WHEN t.estatus = 1 THEN 'ACEPTADO' ELSE 'TRANSITO' END aceptada,
				 IFNULL(tn.notas,'') notas,
				 t.ultima_act,
				 t.origen,
				 t.destino
				 FROM traspasos t
				 LEFT JOIN traspaso_notas tn ON t.id = tn.traspaso_id
				 where t.no_guia = '$noguia' 
				 $where 
				 $filter ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getProductosNoGuia();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function existeGuia($guia,$noserie) {
		$sql = "SELECT id FROM traspasos  WHERE no_guia = '$guia' AND no_serie='$noserie' ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: existeGuia();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getUbicacionId($almacen) {
		$sql = "SELECT id FROM tipo_ubicacion  WHERE nombre = '$almacen' AND almacen=1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getUbicacionId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getModeloId($modelo) {

		$sql = "SELECT id FROM modelos WHERE modelo= '$modelo' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getModeloId();	Functionality: Search Modelos;	Log:". $sql . $e->getMessage () );
		}
	}

	function getCarrierId($modelo) {
		$sql = "SELECT id FROM carriers WHERE nombre= '$modelo' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getCarrierId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getConectividadId($conectividad) {
		$sql = "SELECT id FROM tipo_conectividad WHERE nombre= '$conectividad' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getConectividadId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existeInventario($serie) {
		$sql = " SELECT SUM(cantidad)   FROM inventario WHERE no_serie='$serie'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: existeInventario();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getEstatusId($estatus) {
		$sql = "SELECT id FROM tipo_estatus_modelos WHERE nombre= '$estatus' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getEstatusId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getAccesoriosId($acc) {
		$sql = "SELECT id FROM accesorios WHERE codigo= '$acc'  ";
		 
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getAccesoriosId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInventarioId($noserie) {
		$sql = "SELECT id FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getLastTraspasoId() {
		$sql = " Select IFNULL(MAX(id),0)+1 last from traspasos ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getLastTraspasoId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getInventarioInfo($noserie) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInventarioInfo();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getAlmacenId($almacen) {
		$sql = "SELECT id FROM tipo_ubicacion WHERE nombre= '$almacen' AND status=1 AND almacen=1";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getAlmacenId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getPlazaUser($user) {
		$sql = "SELECT plaza FROM cuentas WHERE id= $user AND status=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getPlazaUser();	Functionality: Search Plaza;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTraspasosbyId($id) {
		
		
		$sql = "SELECT * from traspasos  WHERE id =?  ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getTraspasosbyId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInventarioElavon($noserie) {
		$sql = "SELECT * FROM elavon_universo WHERE serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: inventarioelavon_db.php;	Method Name: getInventarioElavon();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
}
//
include 'DBConnection.php';
$Almacen = new Almacen ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Almacen->getTable($params,true);
    $rowsTotal = $Almacen->getTableTotal();
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  $rowsTotal, "recordsFiltered" => count($rows) );

	echo json_encode($data); //$val;
}

if($module == 'getInventarioTecnico') {

    $rows = $Almacen->getInventarioTecnico($params,true);
    $rowsTotal = $Almacen->getInventarioTecnico($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'agregarSerie') {

	$estatus = '0';
	$user = $_SESSION['userid'];
	$existe = $Almacen->getInventarioElavon($params['serie']);

	switch($params['estatus']) {
		case 'PERTENECE A ELAVON':
			$estatus == 3;
		break;
		case 'DESTRUIDA ¡NO INSTALAR!	':
			$estatus == 17;
		break;
		case 'QUEBRANTADA ¡NO INSTALAR!	':
			$estatus == 16;
		break;
		case 'PENDIENTE POR QUEBRANTAR':
			$estatus == 3;
		break;
		case 'CANCELADO':
			$estatus == 7;
		break;
		case 'ACTIVA':
			$estatus == 3;
		break;
	}


	if($existe) {
		$id = 0;

		$prepareStatement = "UPDATE `elavon_universo` set `fabricante` = ?,`estatus` = ? ,`estatus_modelo` = ?,`tipo` = ?,`modificado_por` = ?  where `id` = ? ";

			$arrayString = array (
				$params['fabricante'],
				$params['estatus'],
				$estatus,
				$params['tipo'],
				$user,
				$existe[0]['id']
			);

			$Almacen->insert($prepareStatement,$arrayString);

	} else {

		$prepareStatement = "INSERT INTO `elavon_universo`
				( `serie`,`fabricante`,`estatus`,`estatus_modelo`,`tipo`,`modificado_por`)
				VALUES (?,?,?,?,?,?); ";
			
		$arrayString = array (
				$params['serie'],
				$params['fabricante'],
				$params['estatus'],
				$estatus,
				$params['tipo'] ,
				$user
		);
	
		$id = $Almacen->insert($prepareStatement,$arrayString);
	}

	echo $id;
}


if($module == 'getStatus') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getStatus();
    foreach ( $rows as $row ) {
         
		$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getFabricantes') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getFabricantes();
    foreach ( $rows as $row ) {
         
		$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'altaAlmacen') {

	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$inventario = $Almacen->getCantidadInsumos($params['insumo']);

	if($params['producto'] == '3' && sizeof($inventario) > 0  ) {

		$total = (int)$inventario[0]['cantidad'] + (int)$params['cantidad'];
		$id = $inventario[0]['id'];

		$prepareStatement = "UPDATE `inventario` SET `cantidad` = ?,`modificado_por`= ? WHERE `id` = ? ;";

		$arrayString = array (
				$total,
				$user,
				$inventario[0]['id']
		);

		$Almacen->insert($prepareStatement,$arrayString);

	} else {

		$prepareStatement = "INSERT INTO `inventario`
						( `tipo`,`cve_banco`,`no_serie`,`modelo`,`conectividad`,`estatus`,`anaquel`,`caja`,`tarima`,
						`cantidad`,`carrier`,`ubicacion`,`insumo`,`creado_por`,`fecha_entrada`,`fecha_creacion`,`fecha_edicion`,`modificado_por`)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					";
		$arrayString = array (
				$params['producto'],
				$params['cve_banco'],
				$params['noserie'],
				$params['tpv'],
				$params['connect'],
				$params['estatus'] ,
				$params['anaquel'],
				$params['cajon'],
				$params['tarima'],
				$params['cantidad'],
				$params['carrier'],
				1,
				$params['insumo'] ,
				$user,
				$fecha_alta,
				$fecha_alta,
				$fecha_alta,
				$user
		);
	
		$id = $Almacen->insert($prepareStatement,$arrayString);

	}

	if($params['producto'] == '3') {
		$params['noserie'] = $id;
	}

	$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
	$arrayString = array (
			$id,
			$fecha_alta,
			'ALTA',
			1,
			$params['noserie'],
			$params['producto'],
			$params['cantidad'],
			NULL
	);

	$Almacen->insert($prepareStatement,$arrayString);
	
	echo json_encode(['id'=> $id,  'fecha_alta' => $fecha_alta ]);
} 


?>