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
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Traspasos;	Log:" . $prepareStatement . json_encode($arrayString) ." " . $e->getMessage () );
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
            self::$logger->error ("File: almacen_db.php;	Method Name: getModelosTPV();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	
	function getCarriers() {
		
		$sql = "select * from carriers";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getCarriers();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getStatus() {
		
		$sql = "select * from tipo_estatus_modelos WHERE estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getStatusModelos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
	function getStatusUbicacion() {
		
		$sql = "select * from tipo_estatus_inventario where estatus=1";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getStatusUbicacion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
	
	/*Función que realiza la consulta que se muestra en el grid principal de Almacén */
    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";
		$ubicacion = $params['tipo_ubicacion'] ;
		$estatus = $params['tipo_estatus'];
		$producto = $params['tipo_producto'];
		$estatusubicacion = $params['tipo_estatusubicacion'];
		$almacen = $_SESSION['almacen'];
		$bancos = $params['banco'];

		if( $bancos != '0' ) {
			$where .= " AND b.id = $bancos ";
		}  

		if( $ubicacion != '0' ) {
			$where .= " AND tu2.id = $ubicacion ";
		} else {
			
			if( $_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'CA' || $_SESSION['tipo_user'] == 'almacen'  )
			{
				
			} else {
				$where .= " AND tu2.id = -1 ";
			}
			
		}

		if( $estatusubicacion != '0' ) {
			
			$where .= " AND ei.id = $estatusubicacion ";

			if($_SESSION['tipo_user'] != 'admin' ) //
			{
				if($_SESSION['tipo_user'] != 'AL' && $_SESSION['tipo_user'] != 'CA') {
					
					$where .= "  AND inv.id_ubicacion in  (Select id from cuentas where almacen = $almacen AND estatus=1) ";	
				}
			}
			
		}
		
		if( $estatus != '0' ) {
			$where .= " AND em.id = $estatus ";
		} 

		if( $producto != '0' ) {
			$where .= " AND inv.tipo = $producto ";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( m.modelo LIKE '".$params['search']['value']."%' ";
			$where .=" OR inv.no_serie LIKE '".$params['search']['value']."%' ";
			$where .=" OR em.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR b.banco LIKE '".$params['search']['value']."%'  ";
			$where .=" OR tu.nombre LIKE '".$params['search']['value']."%'  )"; 

		}
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'supervisor' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'AL') 
		{
			$userId = $_SESSION['userid'] ;
			
			//$where .= " ( AND inv.id_ubicacion in  (Select id from cuentas where almacen = $almacen ) OR tu.id = $almacen )";
		}


		$sql = "Select 
				inv.id,
				inv.tipo,
				CASE WHEN inv.tipo = '1' THEN 'TPV' WHEN inv.tipo = '2' THEN 'SIM' WHEN inv.tipo = '3' THEN 'Insumos' WHEN inv.tipo = '4' THEN 'Accesorios' END tipoNombre,
				inv.no_serie,	
				CASE WHEN inv.tipo = '1' THEN m.modelo WHEN inv.tipo = '2' THEN c.nombre WHEN  inv.tipo= 4 THEN a.concepto END modelo,
				tc.nombre conect,
				em.nombre estatus,
				ei.nombre estatus_inventario,
				-- GetUbicacionId(inv.id_ubicacion,inv.ubicacion) ubicacion,
				-- GetNameById(inv.ubicacion,'AlmacenTraspaso') ubicacion,
				-- CASE WHEN inv.estatus_inventario = 1  THEN tu.nombre WHEN inv.estatus_inventario = 3  THEN CONCAT(du.nombre,'',du.apellidos)  WHEN inv.estatus_inventario = 2  THEN CONCAT(du.nombre,'',du.apellidos)  WHEN inv.estatus_inventario = 4  THEN cm.comercio END ubicacion,
				-- tu.nombre ubicacion,
				CASE WHEN inv.ubicacion = 1 THEN tu2.nombre  ELSE tu.nombre END ubicacion,
				inv.ubicacion ubicacionId,
				inv.fecha_edicion,
				inv.fecha_entrada,
				inv.id_ubicacion,
				CASE WHEN inv.tipo = '1' THEN '1' WHEN inv.tipo = '2' THEN '1' ELSE inv.cantidad END cantidad,
				b.banco, 
				inv.cve_banco
				FROM inventario inv
				LEFT JOIN modelos m  ON m.id = inv.modelo
				LEFT JOIN tipo_conectividad tc ON tc.id = inv.conectividad
				LEFT JOIN carriers c  ON c.id = inv.modelo
				LEFT JOIN accesorios a ON a.id = inv.modelo
				LEFT JOIN tipo_estatus_modelos em ON em.id = inv.estatus
				LEFT JOIN tipo_estatus_inventario ei ON ei.id = inv.estatus_inventario
				LEFT JOIN tipo_ubicacion tu ON tu.id = inv.ubicacion
				LEFT JOIN tipo_ubicacion tu2 ON tu2.id = inv.id_ubicacion
				LEFT JOIN comercios cm ON cm.id = inv.id_ubicacion
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = inv.id_ubicacion
				LEFT JOIN bancos b ON inv.cve_banco = b.cve
				-- LEFT JOIN comercios c ON c.afiliacion = inv.id_ubicacion
				WHERE inv.no_serie is not null
				$where
				-- group by inv.id
				$filter ";
			 		
				self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getTableInsumos($params,$total)
	{
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";
		
		$producto = $params['tipo_producto'];
		
		$almacen = $_SESSION['almacen'];

		if( $producto != '0' ) {
			$where .= " WHERE ins.tipo = $producto ";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND "; //
			$where .=" ( ins.producto LIKE '".$params['search']['value']."%') ";

		}
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'supervisor' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'AL') 
		{
			$userId = $_SESSION['userid'] ;
			
			//$where .= " ( AND inv.id_ubicacion in  (Select id from cuentas where almacen = $almacen ) OR tu.id = $almacen )";
		}


		$sql = "Select 
				ins.id,
				ins.tipo,
				CASE WHEN ins.tipo = '1' THEN 'TPV' WHEN ins.tipo = '2' THEN 'SIM' WHEN ins.tipo = '3' THEN 'Insumos' WHEN ins.tipo = '4' THEN 'Accesorios' END tipoNombre,
				ins.producto,		
				em.nombre estatus,
				tu.nombre ubi,
				ins.fecha_edicion,
				ins.fecha_creacion,
				ins.cantidad
				FROM inventario_insumos ins
				LEFT JOIN accesorios a ON a.id = ins.producto
				LEFT JOIN tipo_estatus_modelos em ON em.id = ins.estatus
				LEFT JOIN tipo_ubicacion tu ON tu.id = ins.almacen_id
				WHERE ins.tipo is not null
				$where
				group by ins.id
				$filter ";
			 		
				
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTableInsumos();	Functionality: Get Table;	Log:" . $e->getMessage () );
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
		} else {
			$where .= " AND du.cuenta_id = -1 ";
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
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'supervisor' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'supOp' ) { 
			$userId = $_SESSION['userid'] ;
			
			$where .= " AND it.tecnico in ( SELECT id FROM cuentas WHERE almacen in ($almacenId ) AND estatus=1 ) ";
		}


		$sql = "SELECT DISTINCT
				it.id,
				tecnico,
				CONCAT(du.nombre,' ',ifnull(du.apellidos,'')) nombreTecnico,
				CASE WHEN i.tipo= '1' THEN 'TPV' WHEN i.tipo = '2' THEN 'SIM' WHEN i.tipo = '3' THEN 'Insumos' END  producto,
				it.no_serie,
				it.cantidad,
				m.modelo,
				tm.nombre estatus,
				fecha_modificacion,
				i.estatus estatusId,
				ifnull(tp.estatus,1) estatustraspaso
				FROM inventario_tecnico it
				LEFT JOIN traspasos tp ON tp.no_serie = it.no_serie
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = it.tecnico, inventario i
				LEFT JOIN tipo_estatus_modelos tm ON i.estatus = tm.id
				LEFT JOIN modelos m ON i.modelo = m.id						  
				WHERE it.no_serie = i.no_serie
				$where
				$filter ";
 

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getInventarioTecnico();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}

	}

	function getTipoServicios() {
		$sql = "SELECT * from tipo_servicio ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getTipoServicios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoFallas() {
		$sql = "SELECT * from tipo_falla ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getTipoServicios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	
	function getEquipos($cve,$afiliacion) {
		$sql = "SELECT id,no_serie from almacen where cve_banco=? AND afiliacion=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cve,$afiliacion));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getEquipos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	
	function getTotalEventos() {
		$sql = "SELECT * Total from eventos";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getTotalEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	/* Consulta que toma la información de los tipos de conectividad */
    function getConectividad() {

		$sql = "select id, nombre from tipo_conectividad ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getConectividad();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getVersion()
	{
		$sql = "SELECT * FROM `tipo_version`";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e) {
			self::$logger->error("File: almacen_db.php;	Method Name: getVersion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		}
	}

	function getPlazas()
	{
		$sql = "SELECT * FROM `plazas` ";

		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e) {
			self::$logger->error("File: almacen_db.php;	Method Name: getPlazas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage ());
		}
	}

	/* Consulta que toma la información de los modelos  */
	function getModelos() {

		$sql = "select id, modelo from modelos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getModelos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getFabricantes() {

		$sql = "select id,  nombre from tipo_proveedor_equipos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getFabricantes();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos() {

		$sql = "select id,  banco nombre from bancos where status= 1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getBancos();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
    }

	
	function getInsumos() {

		$sql = "select id,  nombre from tipo_insumos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getInsumos();	Functionality: Get Insumos price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getInsumosId($id) {

		$sql = "select id,  nombre from tipo_insumos WHERE id = ? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getInsumos();	Functionality: Get Insumos price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getCantidadInsumos($insumo) {
		$sql = "select id,cantidad from inventario where insumo = ? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($insumo));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getCantidadInsumos();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getCantidadInsumosTecnico($insumo,$tecnico) {
		$sql = "select id,cantidad from inventario_tecnico where no_serie = ? and tecnico = ?";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($insumo,$tecnico));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getCantidadInsumos();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getubicacion() {
		

		$sql = "SELECT * from tipo_ubicacion where status=1   order by almacen DESC";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getubicacion();	Functionality: Get Ubicaciones;	Log:" . $e->getMessage () );
        }
	}

	function getHistoria($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
			  
		$id= $params['noSerie'];
						  
			  
		$where = '';

		if($id == '') {
			$id = -1;
		}																	
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( tu.nombre LIKE '".$params['search']['value']."%' ";
																	 
			$where .=" OR c.comercio LIKE '".$params['search']['value']."%'  ";
			$where .=" OR du.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR du.apellidos LIKE '".$params['search']['value']."%'  )";

		}

		$sql = "SELECT 
				  
		h.fecha_movimiento,
		h.tipo_movimiento,
		tu.nombre ubicacionStatus,
		h.cantidad,
		h.ubicacion,
		CASE WHEN h.ubicacion = 1 THEN tu.nombre 
			 WHEN h.ubicacion = 2 THEN c.comercio 
			 WHEN h.ubicacion = 9 THEN CONCAT(du.nombre,' ' ,du.apellidos)
			 WHEN h.ubicacion = 12 THEN CONCAT(du.nombre,' ' ,du.apellidos)
			 WHEN h.ubicacion = 4 THEN c.comercio
		END id_ubicacion,
		h.modified_by,
		CONCAT(du2.nombre,' ' ,du2.apellidos) modificadoPor
		FROM historial h 
		LEFT JOIN tipo_estatus_inventario te ON te.id = h.ubicacion
		LEFT JOIN tipo_ubicacion tu ON tu.id = h.ubicacion
		LEFT JOIN comercios c ON c.id = h.id_ubicacion
		LEFT JOIN detalle_usuarios du ON du.cuenta_id = h.id_ubicacion
		LEFT JOIN detalle_usuarios du2 ON du2.cuenta_id = h.modified_by
		WHERE no_serie = '$id' 
		$where ";

		
		 
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getHistoria();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaInsumos($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$id= $params['noSerie'];
		$tipo = $params['tipo'];
		$query = "";
		$where = '';

		if($id == '') {
			$id = -1;
		}

		if($params['tecnicoId']) {
			$where .= " AND id_ubicacion = ".$params['tecnicoId']  ;
		}
		
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( tipo_ubicacion.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR id_ubicacion LIKE '".$params['search']['value']."%'  )";

		}

		$sql = "SELECT 
				historial.id ,
				fecha_movimiento,
                CASE WHEN tipo = '3' THEN 'INSUMOS' WHEN tipo = '4' THEN 'ACCESORIOS' END producto,
				cantidad,
				tipo_ubicacion.nombre ubicacionNombre,
				id_ubicacion ubicacionId,
				GetUbicacionId(id_ubicacion,ubicacion) id_ubicacion
				FROM historial
				LEFT JOIN tipo_ubicacion ON tipo_ubicacion.id = historial.ubicacion 
				WHERE  historial.inventario_id = '$id' 
				$where ";

		
		 
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getHistoriaInsumos();	Functionality: Get Historia;	Log:" . $e->getMessage () );
		}
	}
		
	function getTecnicos() {
		$supervisor = "";
		
		if($_SESSION['tipo_user'] == 'admin') {
			
		} else {
			$supervisor = " AND st.supervisor_id =".$_SESSION['userid'];
		}
		 


		$sql = "Select du.nombre,du.apellidos,pt.tecnico_id,st.territorio_id,st.supervisor_id
				FROM cuentas c,detalle_usuarios du 
				RIGHT JOIN plaza_tecnico pt ON du.cuenta_id = pt.tecnico_id
				RIGHT JOIN territorio_plaza tp ON pt.plaza_id = tp.plaza_id
				RIGHT JOIN supervisor_territorio st ON st.territorio_id = tp.territorio_id
				WHERE du.cuenta_id is not null 
				AND c.id = c.cuenta_id
				AND c.estatus=1
				$supervisor 
				ORDER BY du.nombre,du.apellidos
				";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($supervisor));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getTecnicosxAlmacen() {
		
		$userid = $_SESSION['userid'];
		$where = '';
		
		
		if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'AN' || $_SESSION['tipo_user'] == 'AL' || $_SESSION['tipo_user'] == 'CA' || $_SESSION['tipo_user'] == 'supervisor') {
			
			$where = " ";
		} else {
			
			$where = " AND st.supervisor_id = $userid ";
		}
		
		
		$sql = " Select DISTINCT
				du.nombre,
				du.apellidos,
				pt.tecnico_id,
				pt.plaza_id,
				ta.territorio_id
				FROM cuentas c,detalle_usuarios du,plaza_tecnico pt,territorio_plaza ta, supervisor_territorio st
				WHERE c.id = du.cuenta_id
				AND c.estatus=1
				AND pt.plaza_id = ta.plaza_id
				AND du.cuenta_id= pt.tecnico_id
                AND ta.territorio_id = st.territorio_id
				$where
				ORDER BY du.nombre,du.apellidos
				";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($userid));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTecnicosxAlmacen();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
				
				
	}

	function buscarNoSerie($nom_serie,$tipo) {
		$sql = "SELECT count(*) existe from inventario  WHERE no_serie = '$nom_serie'  AND estatus = 5 AND ubicacion  = 1 AND tipo = $tipo ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: buscarNoSerie();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getinvInsumo($insumo) {
		$sql = "SELECT cantidad from inventario  WHERE insumo = $insumo AND ubicacion=1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetch();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getinvInsumo();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getAlmacen() {
		
		$where = '';
	
		if( $_SESSION['tipo_user'] != 'almacen' ) {
			$where = ' AND id = 13';
		}
		
		$sql = "SELECT id,nombre from tipo_ubicacion  WHERE almacen =1  $where ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getAlmacen();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInvId($noserie) {
		$sql = "SELECT id FROM inventario  WHERE no_serie = '$noserie'  ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getinvInsumo();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
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
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'AL' && $_SESSION['tipo_user'] != 'almacen') {
			$userId = $_SESSION['userid'] ;
			$where .= " AND t1.cuenta_id in ( SELECT id FROM cuentas WHERE territorial in (Select territorial FROM cuentas WHERE id = $userId ) AND estatus=1 ) ";
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
			self::$logger->error ("File: almacen_db.php;	Method Name: getTraspasos();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
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
			self::$logger->error ("File: almacen_db.php;	Method Name: getProductosNoGuia();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function existeGuia($guia,$noserie) {
		$sql = "SELECT id FROM traspasos  WHERE no_guia = '$guia' AND no_serie='$noserie' ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: existeGuia();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getUbicacionId($almacen) {
		$sql = "SELECT id FROM tipo_ubicacion  WHERE nombre = '$almacen' AND almacen=1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getUbicacionId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function getModeloId($modelo) 
	{

		$sql = "SELECT id FROM modelos WHERE modelo= '$modelo' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getModeloId();	Functionality: Search Modelos;	Log:". $sql . $e->getMessage () );
		}
	}

	function getCarrierId($modelo) {
		$sql = "SELECT id FROM carriers WHERE nombre= '$modelo' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getCarrierId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getConectividadId($conectividad) {
		$sql = "SELECT id FROM tipo_conectividad WHERE nombre= '$conectividad' AND estatus=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getConectividadId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getEstatusInvId($estatus_ubicacion)
	{
		$sql = "SELECT id FROM tipo_estatus_inventario WHERE nombre = '$estatus_ubicacion' AND estatus=1 ";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute ();
			return $result = $stmt ->fetch ( PDO::FETCH_COLUMN, 0);
		} catch ( PDOException $e){
			self::$logger->error ("File: almacen_db.php;     Method Name: getEstatusInvId();    Functionality: Search Carriers; Log:". $sql . $e->getMessage ());
		}
	}


	function existeInventario($serie) {
		$sql = " SELECT SUM(cantidad)   FROM inventario WHERE no_serie='$serie'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: existeInventario();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existeInventarioInsumos($serie,$almacenId) {
		$sql = " SELECT SUM(cantidad)   FROM inventario WHERE no_serie='$serie' AND ubicacion = $almacenId  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: existeInventario();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getEstatusId($estatus) {
		$sql = "SELECT id FROM tipo_estatus_modelos WHERE nombre= '$estatus'  ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getEstatusId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getAccesoriosId($acc) {
		$sql = "SELECT id FROM accesorios WHERE codigo= '$acc'  ";
		 
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getAccesoriosId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInventarioId($noserie,$almacen) {
		$sql = "SELECT id FROM inventario WHERE no_serie= '$noserie' AND ubicacion= $almacen  AND estatus_inventario = 1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getLastTraspasoId() {
		$sql = " Select IFNULL(MAX(id),0)+1 last from traspasos ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getLastTraspasoId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getInventarioInfo($noserie) {
		$sql = "SELECT * FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getInventarioInfo();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}
	
	function getAlmacenId($almacen) {
		$sql = "SELECT id FROM tipo_ubicacion WHERE nombre= '$almacen' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getAlmacenId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getPlazaUser($user) {
		$sql = "SELECT plaza FROM cuentas WHERE id= $user AND status=1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getPlazaUser();	Functionality: Search Plaza;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTraspasosbyId($id) {
		
		
		$sql = "SELECT * from traspasos  WHERE id =?  ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTraspasosbyId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}

	function validateElavonUniverso($noserie) {
		
		
		$sql = "SELECT ifnull(count(*),0) from elavon_universo  WHERE serie = '$noserie'  ";
		
		self::$logger->error ($sql);
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($noserie));
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: almacen_db.php;	Method Name: getTraspasosbyId();	Functionality: Search No_Serie;	Log:". $sql . $e->getMessage () );
		}
	}
	
	//Existencia de serie para reporte
	function getSerie($serie) 
	{
		$sql = " SELECT inventario.no_serie, eventos.tpv_retirado, eventos.tpv_instalado, eventos.sim_instalado, eventos.sim_retirado
					FROM inventario
					LEFT JOIN eventos 
						ON eventos.tpv_retirado = '$serie'
						OR eventos.tpv_instalado =  '$serie'
						OR eventos.sim_instalado =  '$serie'
						OR eventos.sim_retirado = '$serie'
					WHERE inventario.no_serie = '$serie' ";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getSerie();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}


	//Existencia de serie para reporte
	function getSerieInfo($serie) 
	{
		$sql = " SELECT  
		i.no_serie,
		IFNULL(m.modelo ,'') modelo ,
		IFNULL(tc.nombre ,'') conectividad,
		IFNULL(i.anaquel,'') anaquel,
		IFNULL(i.caja,'') caja,
		IFNULL(i.tarima,'') tarima,
		IFNULL(i.cve_banco,'') cve_banco
		FROM inventario i
		LEFT JOIN modelos m ON m.id = i.modelo
		LEFT JOIN tipo_conectividad tc ON tc.id = i.conectividad
		WHERE i.no_serie = '$serie' ";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getSerieInfo();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getSeriesTpvSimEventos($serie)
	{
		$sql = " SELECT odt,ultima_act ultima_mod,afiliacion,tpv_instalado,tpv_retirado,ts.nombre servicio,CONCAT(c.nombre,c.apellidos) tecnico ,CONCAT(cm.nombre,cm.apellidos) modificado_por
				  FROM `eventos`
				  LEFT JOIN tipo_servicio ts ON ts.id = tipo_servicio
				  LEFT JOIN detalle_usuarios  c ON c.cuenta_id = modificado_por
				  LEFT JOIN detalle_usuarios cm ON cm.cuenta_id = modificado_por
				  WHERE ( 
					`tpv_retirado` = '$serie' 
					 OR `tpv_instalado` = '$serie' 
					 OR `sim_instalado` = '$serie' 
					 OR `sim_retirado` = '$serie') ";
				
		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch ( PDOException $e ) {
			self::$logger->error("File: almacen_db.php;		Method Name: getSeriesTpvSimEventos();     Functionality: Get Series;   Log:" . $e->getMessage());
		}
	
	}
	
	
	function getSeriesTpvSimInventario($serie)
	{
		$sql = " SELECT no_serie,m.modelo modelo,tc.nombre conectividad,em.nombre estatus,ei.nombre estatus_inventario,anaquel,caja,tarima,cantidad,tu.nombre ubicacion,
				CASE WHEN ubicacion = 2 THEN com.comercio
				WHEN ubicacion = 9   THEN CONCAT(du.nombre,du.apellidos) ELSE tua.nombre END ubicacionNombre, 
				CONCAT(dum.nombre,dum.apellidos) quien_modifica,modificado_por, fecha_edicion 
				FROM inventario 
				LEFT JOIN modelos m ON m.id =inventario.modelo
				LEFT JOIN tipo_conectividad tc ON tc.id = inventario.conectividad
				LEFT JOIN tipo_estatus_modelos em ON em.id = inventario.estatus
				LEFT JOIN tipo_estatus_inventario ei ON ei.id = estatus_inventario
				LEFT JOIN tipo_ubicacion tu ON tu.id =  ubicacion AND tu.almacen = 0
				LEFT JOIN tipo_ubicacion tua ON tu.id =  id_ubicacion AND tua.almacen = 1
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = id_ubicacion 
				LEFT JOIN detalle_usuarios dum ON dum.cuenta_id = modificado_por
				LEFT JOIN comercios com ON com.id = id_ubicacion 
				WHERE no_serie = '$serie';";
				
		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch ( PDOException $e ) {
			self::$logger->error("File: almacen_db.php;		Method Name: getSeriesTpvSimInventario();     Functionality: Get Series;   Log:" . $e->getMessage());
		}
	
	}

	function getTecnicoxPlaza($plaza) {

		$sql = " SELECT detalle_usuarios.cuenta_id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre FROM cuentas,detalle_usuarios 
				 WHERE cuentas.id = detalle_usuarios.cuenta_id
				 AND plaza=? 
				 AND cuentas.estatus=1
			   ";
			   
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array($plaza));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getTecnicoxPlaza();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getPeticionesTable($params,$total) 
	{

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$query = "";
		$where = '';
		$isActive = $params['active'];
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" where ";
			$where .=" ( du.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR du.apellidos LIKE '".$params['search']['value']."%'  )";

		}

		if ( $isActive == '0' ) 
		{
			$where .=" WHERE p.IsActive = $isActive";
		}elseif ($isActive == '1') 
		{
			$where .=" WHERE p.IsActive = $isActive";
		}

		$sql = "SELECT 
				p.id,
				p.IsActive activa,
				p.creado_por,
				p.fecha_creacion,
				p.modificado_por,
				CONCAT(du.nombre,' ',du.apellidos) creadopor
				FROM peticiones p
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = p.creado_por
				$where
				$filter  ";

		
		 
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getPeticionesTable();	Functionality: Get Historia;	Log:" . $e->getMessage () );
		}
	}

	function getSupervisores() {

		$sql = "  SELECT detalle_usuarios.cuenta_id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre 
				  FROM cuentas,detalle_usuarios 
					WHERE cuentas.id = detalle_usuarios.cuenta_id
					AND cuentas.tipo_user = 12
					AND cuentas.estatus = 1
							
			   ";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getdetallePeticiones($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$query = "";
		$where = '';
		$peticion = $params['peticion'];

		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" where ";
			$where .=" ( ti.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR tc.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR tv.nombre LIKE '".$params['search']['value']."%' ) ";

		}

		$sql = "Select 
				peticiones_id,
				CONCAT(du.nombre,' ',du.apellidos) tecnico,
				CASE WHEN dp.tipo = 1 THEN 'TPV' WHEN dp.tipo = 2 THEN 'SIM' WHEN dp.tipo = 3 THEN 'INSUMO' END tipo,
				ti.nombre insumo ,
				tc.nombre conectividad,
				tp.nombre producto,
				dp.cantidad,
				dp.id,
				dp.tipo tipoid
				FROM detalle_peticiones dp
				LEFT JOIN detalle_usuarios du ON  dp.tecnico_id = du.cuenta_id
				LEFT JOIN tipo_insumos ti ON dp.insumo = ti.id
				LEFT JOIN tipo_conectividad tc  ON dp.conectividad = tc.id
				LEFT JOIN tipo_producto tp ON dp.producto = tp.id
				WHERE dp.peticiones_id = $peticion
				$where
				$filter  ";

		
		 
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getdetallePeticiones();	Functionality: Get Historia;	Log:" . $e->getMessage () );
		}
	}

	function validarSerie($noserie,$tipo) {

		$where = '';
		$tipoUser = $_SESSION['tipo_user'];
		$almacen = $_SESSION['almacen'];

		if( $tipoUser == 'CA' || $tipoUser == 'admin' || $tipoUser == 'AL' ) {

		} else {
			$where .= " AND ubicacion_id = $almacen ";
		}

		if ($tipo == '1') {

			$sql = "  SELECT no_serie,m.modelo ,count(i.id) total
				  FROM inventario i
				  LEFT JOIN modelos m ON m.id = i.modelo 
				  WHERE i.no_serie = ?
				  AND i.ubicacion = 1
				  AND i.tipo = ?
				  $where	
				  group by no_serie,m.modelo			
			   ";
		} else {
			$sql = "  SELECT no_serie,m.nombre modelo ,count(i.id) total
				  FROM inventario i
				  LEFT JOIN carriers m ON m.id = i.modelo 
				  WHERE i.no_serie = ?
				  AND i.ubicacion = 1
				  AND i.tipo = ?
				  $where	
				  group by no_serie,m.nombre			
			   ";
		}
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array($noserie,$tipo));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: validarSerie();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function detallePeticion($peticion) {


		$sql = "  SELECT CONCAT(du.nombre,' ',du.apellidos) supervisor, p.IsActive,
					CONCAT(du2.nombre,' ',du2.apellidos) creadopor,p.fecha_creacion,supervisor_id
					FROM peticiones p,
					detalle_usuarios du, 
					detalle_usuarios du2 
					WHERE   p.supervisor_id = du.cuenta_id
					AND p.creado_por = du2.cuenta_id
					AND p.id = ?
				 				
			   ";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array($peticion));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: detallePeticion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getNoSeriePeticion($id) {

		$sql = "  SELECT no_series
					FROM detalle_peticiones dp
					WHERE  dp.id = ?
				 				
			   ";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array($id));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getNoSeriePeticion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getDetallePeticion($peticionId) {

		$sql = " SELECT * FROM detalle_peticiones
				WHERE peticiones_id = ? ";
		
		try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array($peticionId));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getDetallePeticion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }

	}

	function getProducto() {
		$sql = " SELECT * FROM tipo_producto WHERE status= 1";
		
		try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: almacen_db.php;	Method Name: getDetallePeticion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	function getProveedores() {
		return array();
	}
}
//
include 'DBConnection.php';
$Almacen = new Almacen ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Almacen->getTable($params,true);
    $rowsTotal = $Almacen->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getTableInsumos'){

	$rows = $Almacen->getTableInsumos($params,true);
    $rowsTotal = $Almacen->getTableInsumos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );
	


	echo json_encode($data); //$val;
	
}

if($module == 'getProducto') {
	$rows = $Almacen->getProducto();
	$val = '<option value="0"> Seleccionar </option>';
	
	foreach ( $rows as $row) {
		$val .= '<option value="' . $row['id'] . '" >' . $row['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getdetallePeticiones') {

	$rows = $Almacen->getdetallePeticiones($params,true);
    $rowsTotal = $Almacen->getdetallePeticiones($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}

if($module == 'getNoSeriePeticion') {
	$rows = $Almacen->getNoSeriePeticion($params['id']);

	echo $rows['no_series'];
}

if($module == 'grabardetallePeticion') {
	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$id = $params['id'];
	$noseries = $params['noseries'];

	$prepareStatement = "UPDATE `detalle_peticiones` SET `no_series` = ?,`modificado_por`= ?,`fecha_modificacion`= ? WHERE `id` = ? ;";

	$arrayString = array (
		$noseries,
		$user,
		$fecha_alta,
		$id
	);

	$Almacen->insert($prepareStatement,$arrayString);

}

if($module == 'getInventarioTecnico') {

    $rows = $Almacen->getInventarioTecnico($params,true);
    $rowsTotal = $Almacen->getInventarioTecnico($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getVersion') {

	$val = '<option value="0"> Seleccionar </option>';
	$rows = $Almacen->getVersion();
	foreach ( $rows as $row) {
		$val .= '<option value="' . $row['id'] . '" >' . $row['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getPlazas'){
	$val = '<option value="0"> Seleccionar </option>';
	$rows = $Almacen->getPlazas();
	foreach ($rows as $row) {
		$val .= '<option value="' . $row['id'] . '" >' . $row['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTecnicos') {
	
	$rows = $Almacen->getTecnicos();
	$val = '<option value="0" data-id="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnico_id'] . '"  data-id="'. $row['territorio_id'] .'" >' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}

if($module == 'getTecnicosxAlmacen') {
	
	$rows = $Almacen->getTecnicosxAlmacen();
	$val = '<option value="0" data-id="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnico_id'] . '"  data-id="'. $row['territorio_id'] .'" >' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}
	

if($module == 'getSupervisores') {

	$rows = $Almacen->getSupervisores();
	$val = '<option value="0" data-id="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['cuenta_id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getubicacion') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getubicacion();
	$almacen = $_SESSION['almacen'];
	$isAdmin= 0;
		
	if($_SESSION['tipo_user'] == 'admin' ||  $_SESSION['tipo_user'] == 'CA' || $_SESSION['tipo_user'] == 'AN') { 
		$isAdmin = 1;
	}
    foreach ( $rows as $row ) {
		if($isAdmin == 1 ) {
			$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
		} else {
			if($row ['almacen'] == '1') {
				if($row['id'] == $almacen ) {
				$val .=  '<option value="' . $row ['id'] . '" selected>' . $row ['nombre'] . '</option>';
				}
			}  
		
		}
	}
	echo $val;

}

if($module == 'getBancos') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getBancos();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getModelos') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getModelos();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['modelo'] . '</option>';
	}
	echo $val;

}


if($module == 'getHistoria') {
    $rows = $Almacen->getHistoria($params,true);
    $rowsTotal = $Almacen->getHistoria($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}

if($module == 'getPeticiones') {

	
	$rows = $Almacen->getPeticionesTable($params,true);
    $rowsTotal = $Almacen->getPeticionesTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val
}

if ($module == 'borrarPeticion') 
{
	$prepareStatement = "DELETE FROM peticiones WHERE id = ? ";

	$arrayString = array($params['id']);

	$del = $Almacen->insert($prepareStatement, $arrayString);

	if ($del) 
	{
		echo "0";

	}
	else
	{
		$prepareStatement2 = "DELETE FROM detalle_peticiones WHERE peticiones_id=?";
		$arrayString2 = array( $params['id'] );

		$del2 = $Almacen->insert($prepareStatement2, $arrayString2);
	}
}

if($module == 'getHistoriaInsumos') {

    $rows = $Almacen->getHistoriaInsumos($params,true);
    $rowsTotal = $Almacen->getHistoriaInsumos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}
if($module == 'getTraspasos') {
	$rows = $Almacen->getTraspasos($params,true);
    $rowsTotal = $Almacen->getTraspasos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getProductosNoGuia') {

	$rows = $Almacen->getProductosNoGuia($params,true);
	$rowsTotal = $Almacen->getProductosNoGuia($params,false);
	$data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}

if($module == 'getConectividad') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getConectividad();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getProveedores') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getProveedores();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getmodelostpv') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getModelosTPV();
    foreach ( $rows as $row ) {
        $data = $row['modelo'].'_'.$row['proveedor'].'_'.$row['conectividad'].'_'.$row['no_largo'];
		$val .=  '<option data="'.$data.'" value="' . $row ['id'] . '"  >' . $row ['modelo'] . '</option>';
	}
	echo $val;

}

if($module == 'getCarriers') {
    $val = '<option value="0" selected>Seleccionar</option>';
    $rows = $Almacen->getCarriers();
    foreach ( $rows as $row ) {
         
		$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getStatus') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getStatus();
    foreach ( $rows as $row ) {
         
		$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getStatusUbicacion') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getStatusUbicacion();
    foreach ( $rows as $row ) {
        if($_SESSION['tipo_user'] == 'AL' || $_SESSION['tipo_user'] == 'AN' || $_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'CA' ) { 
			$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
		} else {
			
			if( $row ['id'] == '2' ||  $row ['id'] == '3') {
				$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
			}
		}
	}
	echo $val;

}

if($module == 'getInsumos') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getInsumos();
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

if($module == 'getAlmacen') {
	$val = '<option value="0">Seleccionar</option>';
    $rows = $Almacen->getAlmacen();
    foreach ( $rows as $row ) {
		$tipo = $_SESSION['tipo_user'];
		$almacen = $_SESSION['almacen'];
		
		if($tipo == 'admin' || $tipo == 'CA' || $tipo == 'AL' || $tipo == 'AN') {
			$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
		}  else { 
			if($row['id'] == $almacen ) {
				$val .=  '<option value="' . $row ['id'] . '"  selected>' . $row ['nombre'] . '</option>';
			}
		}
         
		
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

if($module == 'updateInvProd') 
{
	$fecha_alta = date("Y-m-d H:i:s");
	$fecha = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	
	$prepareStatement = "UPDATE `inventario` 
						SET `modelo` = ?, 
							`conectividad` = ?, 
							`estatus` = ?,
							`ubicacion` = ?,  
							`estatus_inventario` = ?,
							`cantidad` = ?, 
							`modificado_por` = ?,
							`fecha_edicion` = ?
						WHERE `no_serie` = ? ";

	$arrayString = array (
			$params['modelo'],
			$params['conectividad'],
			$params['estatus'],
			$params['ubicacion'],
			$params['estatusinventario'],
			$params['cantidad'],
			$user,
			$fecha,
			$params['noserie']
	);
	
	$id = $Almacen->insert($prepareStatement,$arrayString);
	if($id != 0)
	{
		echo json_encode(["msg" => "No se actualizaron los datos", "data" => json_encode($arrayString),'id' => $id ]);
	}
	else
	{
		
		
		if($params['estatusinventario'] == '1' || $params['estatusinventario'] == '4' ) {
			$querySIM = " DELETE FROM inventario_tecnico  WHERE no_serie=?";

			$arrayString = array (
				$params['noserie']
			);

			$Almacen->insert($querySIM,$arrayString);
			
			
		}
		
		$getIdInv = $Almacen->getInventarioInfo($params['noserie']);
	
		$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
					VALUES
					(?,?,?,?,?,?,?,?,?);
				";
		$arrayString = array (
				$getIdInv[0]['id'],
				$fecha_alta,
				'CAMBIO ESTATUS',
				$params['ubicacion'],
				$params['noserie'],
				$getIdInv[0]['tipo'],
				$params['cantidad'],
				$getIdInv[0]['id_ubicacion'],
				$user
		);

		$Almacen->insert($prepareStatement,$arrayString);
		
		echo "Se actualizaron los datos";
	}
	
	
	
	 
	

}


if($module == 'altaInvTecnico') {
	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$noguia = $params['noguia'];
	$products = json_decode($params['products']);
	$inventarioTecnico = $Almacen->getCantidadInsumosTecnico($params['insumo'],$params['tecnico']);
	$inventario = $Almacen->getCantidadInsumos($params['insumo']);
	

	if($params['producto'] == '3' && sizeof($inventario) > 0  ) {

		$total = (int)$inventario[0]['cantidad'] - (int)$params['cantidad'];
		$totalInv =(int)$inventarioTecnico[0]['cantidad'] + (int)$params['cantidad'];
		$id = $inventario[0]['id'];

		$prepareStatement = "UPDATE `inventario` SET `cantidad` = ? WHERE `id` = ? ;";

		$arrayString = array (
				$total,
				$inventario[0]['id']
		);

		$Almacen->insert($prepareStatement,$arrayString);

		if(sizeof($inventarioTecnico) > 0 ) {
			
			$prepareStatement = "UPDATE `inventario_tecnico` SET `cantidad` = ? WHERE `id` = ? ;";

			$arrayString = array (
					$totalInv,
					$inventarioTecnico[0]['id']
			);

			$Almacen->insert($prepareStatement,$arrayString);
			//$id = $inventarioTecnico[0]['id'];

		} else {
			$prepareStatement = "INSERT INTO `inventario_tecnico`
						( `tecnico`,`producto`,`no_serie`,`insumo`,`cantidad`,`fecha_modificacion`)
						VALUES
						(?,?,?,?,?,?);
					";
			$arrayString = array (
					$params['tecnico'],
					$params['producto'],
					$params['no_serie'],
					$params['insumo'],
					$params['cantidad'],
					$fecha_alta
			);
		
			 $Almacen->insert($prepareStatement,$arrayString);
		}

		$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
		$arrayString = array (
				$id,
				$fecha_alta,
				'CARGA TECNICO',
				9,
				0,
				$params['producto'],
				$params['cantidad'],
				$params['tecnico']
		);

		$Almacen->insert($prepareStatement,$arrayString);

		

	} else {
		
		foreach($products AS $product ) {
			$inventarioId = $Almacen->getInvId($product);

			$prepareStatement = "UPDATE `inventario` SET `ubicacion` = ?, `id_ubicacion` = ?, `fecha_edicion` = ? WHERE `no_serie` = ? ;";

			$arrayString = array (
					4,
					$params['tecnico'],
					$fecha_alta,
					$product
					
			);

			$Almacen->insert($prepareStatement,$arrayString);

			$prepareStatement = "INSERT INTO `inventario_tecnico`
							( `tecnico`,`producto`,`no_serie`,`no_guia`,`insumo`,`cantidad`,`fecha_modificacion`)
							VALUES
							(?,?,?,?,?,?,?);
						";
			$arrayString = array (
					$params['tecnico'],
					$params['producto'],
					$product,
					$noguia,
					$params['insumo'],
					$params['cantidad'],
					$fecha_alta
			);
		
			$id = $Almacen->insert($prepareStatement,$arrayString);

			$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
			$arrayString = array (
					$inventarioId,
					$fecha_alta,
					'CARGA TECNICO',
					4,
					$product,
					$params['producto'],
					$params['cantidad'],
					$params['tecnico']
			);

			$Almacen->insert($prepareStatement,$arrayString);
		}

	}

	/*if($params['producto'] == '3') {
		$params['noserie'] = $id;
	}

	if( strlen($noguia) > 0 ) {
		$prepareStatement = "INSERT INTO `traspasos`
					( `no_guia`,`cuenta_id`,`estatus`,`fecha_creacion`,`ultima_act`)
					VALUES
					(?,?,?,?,?);
				";
		$arrayString = array (
				$noguia,
				$params['tecnico'],
				'TRANSITO',
				$fecha_alta,
				$fecha_alta
		);

		$Almacen->insert($prepareStatement,$arrayString);
	}*/
	
	echo json_encode(['id'=> $id,  'fecha_alta' => $fecha_alta ]);

}

if($module == 'nuevoTraspaso'){

	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$noguia = $params['noguia'];
	$tipo = $params['tipoTraspaso'];
	$products = json_decode($params['products']);
	$inventario = $Almacen->getCantidadInsumos($params['insumo']);
	$ub = $tipo == '1' ? $params['tecnico']	 : $params['almacen'];

	if($params['producto'] == '3' && sizeof($inventario) > 0  ) {

		$total = (int)$inventario[0]['cantidad'] - (int)$params['cantidad'];
	//	$totalInv =(int)$inventarioTecnico[0]['cantidad'] + (int)$params['cantidad'];
		$id = $inventario[0]['id'];

		// Actualizar Inventario
		$prepareStatement = "UPDATE `inventario` SET `cantidad` = ? WHERE `id` = ? ;";

		$arrayString = array (
				$total,
				$inventario[0]['id']
		);

		$Almacen->insert($prepareStatement,$arrayString);

		// Agregar a Traspasos
		$prepareStatement = "INSERT INTO `traspasos`
					( `tipo`,`no_guia`,`cuenta_id`,`estatus`,`fecha_creacion`,`ultima_act`)
					VALUES
					(?,?,?,?,?,?);
				";
		$arrayString = array (
				$tipo,
				$noguia,
				$ub,
				'TRANSITO',
				$fecha_alta,
				$fecha_alta
		);

		$traspasoId = $Almacen->insert($prepareStatement,$arrayString);

		$prepareStatement = "INSERT INTO `traspasos_detalle`
					( `traspaso_id`,`no_serie`,`producto`,`cantidad`,`estatus`,`fecha_creacion`,`ultima_act`)
					VALUES
					(?,?,?,?,?,?,?);
				";
		$arrayString = array (
				$traspasoId,
				0,
				$params['producto'],
				$params['cantidad'],
				'TRASPASO',
				$fecha_alta,
				$fecha_alta,
		);

		$Almacen->insert($prepareStatement,$arrayString);

		//INSERTAR EN HISTORICO
		$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
		$arrayString = array (
				$id,
				$fecha_alta,
				'TRASPASO',
				4,
				0,
				$params['producto'],
				$params['cantidad'],
				$ub
		);

		$Almacen->insert($prepareStatement,$arrayString);
	} else {
		
		// Agregar a Traspasos
		$prepareStatement = "INSERT INTO `traspasos`
					( `tipo`,`no_guia`,`cuenta_id`,`estatus`,`fecha_creacion`,`ultima_act`)
					VALUES
					(?,?,?,?,?,?);
				";
		$arrayString = array (
				$tipo,
				$noguia,
				$ub,
				'TRANSITO',
				$fecha_alta,
				$fecha_alta
		);

		$idTraspaso = $Almacen->insert($prepareStatement,$arrayString);

		foreach($products AS $product ) {
			$inventarioId = $Almacen->getInvId($product);

			$prepareStatement = "UPDATE `inventario` SET `ubicacion` = ?, `id_ubicacion` = ?, `fecha_edicion` = ? WHERE `no_serie` = ? ;";

			$arrayString = array (
					4,
					$params['tecnico'],
					$fecha_alta,
					$product
					
			);

			$Almacen->insert($prepareStatement,$arrayString);

			$prepareStatement = "INSERT INTO `traspasos_detalle`
					( `traspaso_id`,`no_serie`,`estatus`,`fecha_creacion`,`ultima_act`)
					VALUES
					(?,?,?,?,?);
				";
			$arrayString = array (
					$idTraspaso,
					$product,
					'TRASPASO',
					$fecha_alta,
					$fecha_alta,
			);

			$Almacen->insert($prepareStatement,$arrayString);

			$prepareStatement = "INSERT INTO `historial`
					( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
					VALUES
					(?,?,?,?,?,?,?,?);
				";
			$arrayString = array (
					$inventarioId,
					$fecha_alta,
					'TRASPASO',
					4,
					$product,
					$params['producto'],
					$params['cantidad'],
					$ub
			);

			$Almacen->insert($prepareStatement,$arrayString);
		}
	}

	echo json_encode(['id'=> $id,  'fecha_alta' => $fecha_alta ]);
}


if($module == 'crearRetornos') {
	$noGuia = $_POST['noGuia'];
	$codigoRastreo = $_POST['codigoRastreo'];
	$tecnico = $_POST['tecnico'];
	$noseries  = json_decode($_POST['noserie']);
	$fecha_alta = date("Y-m-d H:i:s");
	

	foreach($noseries as $noserie ) {

		$plaza =$Almacen->getPlazaUser($noserie->Tecnico);

		$cantAnterior = $Almacen->getInventarioInfo($noserie->NoSerie);

		$datafieldsTraspasos = array('tipo','no_serie','modelo','cantidad','no_guia','codigo_rastreo','origen','destino','cuenta_id','estatus','fecha_creacion','ultima_act');
			
		$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTraspasos), '?'));

		$sql = "INSERT INTO traspasos (" . implode(",", $datafieldsTraspasos ) . ") VALUES (".$question_marks.")"; 

		$arrayString = array (
			$noserie->Producto,
			$noserie->NoSerie,
			$cantAnterior[0]['modelo'],
			1,
			$noGuia,
			$codigoRastreo,
			$noserie->Tecnico,
			$plaza,
			0,
			0,
			$fecha_alta,
			$fecha_alta
		);

		
		$id = $Almacen->insert($sql,$arrayString);
	}
	
	
	echo 1;
}

if($module == 'buscarNoSerie') {
	$inventario = $Almacen->buscarNoSerie($params['term'],$params['tipo']);

	echo json_encode($inventario);
}

if($module == 'getinvInsumo') {
	$inventario = $Almacen->getinvInsumo($params['insumo']);

	echo json_encode($inventario);
}

if($module == 'returnInvItem') {

	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$almacenId = $_SESSION['almacen'];
	$item = $Almacen->getInventarioInfo($params['noserie']);

	if($item ) {

		if($item[0]['ubicacion'] == $almacenId  ) {

			if($item[0]['tipo'] == '1'  || $item[0]['tipo'] == '2' ) { 
			
				$sql = " UPDATE `inventario` SET `estatus_inventario`=?,`ubicacion`=?,`id_ubicacion`=?,`modificado_por`=?,`fecha_edicion`=? WHERE `id`=? "; 
		
				$arrayString = array (
					1,
					1,
					1,
					$user,
					$fecha_alta,
					$item[0]['id']
				);

				$Almacen->insert($sql,$arrayString);
			
				$resultado = ['status' => 0, 'texto' => 'Ya lo tienes en tu inventario' ];
			} 

		} else {

			$sql = " UPDATE `inventario` SET `estatus_inventario`=?,`ubicacion`=?,`id_ubicacion`=?,`modificado_por`=?,`fecha_edicion`=? WHERE `id`=? "; 
		
			$arrayString = array (
				1,
				$almacenId,
				$almacenId,
				$user,
				$fecha_alta,
				$item[0]['id']
			);

			$Almacen->insert($sql,$arrayString);

			//Borrar del Inventario del Tecnico
		//	if($item[0]['estatus_inventario'] == '3') {

				$query = " DELETE FROM inventario_tecnico  WHERE no_serie=?   ";
				$Almacen->insert($query,array($params['noserie'] ));
		//	}
		

			//GRABAR HISTORIA 
			
			$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
			$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$item[0]['id'],
				$fecha_alta,
				'ENTRADA',
				$almacenId,
				$params['noserie'],
				$item[0]['tipo'],
				1,
				0,
				$user
			);
		
			$Almacen->insert($sql,$arrayString);

			$resultado = ['status' => 1, 'texto' => 'SE Agrego con Exito', 'item' => $item ];

		}

	} else {
		$resultado = ['status' => 0, 'texto' => 'No existe en  el inventario' ];
	}

	echo json_encode($resultado);

}

if($module == 'aceptarTraspaso') {

	$traspaso = $Almacen->getTraspasosbyId($params['traspasoId']);

	$fecha = date ( 'Y-m-d H:m:s' );
	$sql = " UPDATE `inventario` SET `estatus_inventario`=?,`ubicacion`=?,`fecha_edicion`=? ,`id_ubicacion`=? WHERE `no_serie`=? "; 

	$arrayString = array (
		$traspaso[0]['destino'],
		1,
		$fecha,
		0,
		$traspaso[0]['no_serie']
	);

	$Almacen->insert($sql,$arrayString);

	//Borrar del Inventario Tecnico 
	$sql = " DELETE FROM  `inventario_tecnico`  WHERE `no_serie`=? "; 

	$arrayString = array (
		$traspaso[0]['no_serie']
	);

	$Almacen->insert($sql,$arrayString);

	echo json_encode(['traspaso' => $traspaso[0] ]);

}


if($module == 'TraspasosMasivo') {
	$counter = 0;
	$GuiaNoCargadas = array();
	$GuiaYaCargadas = array();
	$mensajeYaCargadas = '';
	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$FechaAlta = date('Y-m-d');
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
	$allTraspasos = array();
	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$Clave = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$Serie = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		$Serie = trim(utf8_decode($Serie->getValue())," \t\n\r\0\x0B\xA0");
		$Modelo = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$Cantidad = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Origen = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
		$Destino = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
		$Tecnico = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		$Guia =   $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
		$Guia =   trim(utf8_decode($Guia->getValue())," \t\n\r\0\x0B\xA0");
		$CodigoRastreo = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		$CodigoRastreo =   trim(utf8_decode($CodigoRastreo->getValue())," \t\n\r\0\x0B\xA0");
		$Fecha = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
		$FechaFinal = $Fecha->getFormattedValue();
		$OrigenId = $Almacen->getUbicacionId($Origen->getValue());

		if($Guia == '') {
			$newGuia = $Almacen->getLastTraspasoId();
			$Guia = str_pad($newGuia, 12, '0', STR_PAD_LEFT);
		}
		$existeNoSerie = $Almacen->getInventarioId($Serie,$OrigenId);
		
		if($existeNoSerie) {
		
			$FechaEntrada = date("d-m-Y", strtotime($FechaFinal));

			
			$DestinoId = $Almacen->getUbicacionId($Destino->getValue());
			$DestinoId = $DestinoId ? $DestinoId :  0 ;
			if($Clave->getValue() == 'TPV' )  {
				$ModeloId = $Almacen->getModeloId($Modelo->getValue());
				$CantidadQty = 1;
			} else if ( $Clave->getValue() == 'SIM' )  {
				$ModeloId = $Almacen->getCarrierId($Modelo->getValue());
				$CantidadQty = 1;
			} else {
				$ModeloId = 0;
				$CantidadQty = $Cantidad->getValue();
			}

			$Tecnico = is_null($Tecnico->getValue()) ? 0 : $Tecnico->getValue();

			if(!is_null($Clave->getValue())  ) {
			
				$existeGuia = $Almacen->existeGuia($Guia,$Serie);

				if(!$existeGuia) {

					

				//	$sql = "INSERT INTO traspasos (" . implode(",", $datafieldsTraspasos ) . ") VALUES (".$question_marks.")"; 

					$arrayString = array (
						$Clave->getValue(),
						$Serie,
						$ModeloId,
						$CantidadQty,
						$Guia,
						$CodigoRastreo,
						$OrigenId,
						$DestinoId,
						$Tecnico,
						0,
						$fecha,
						$fecha
					);

					array_push($allTraspasos,$arrayString);
				//	$id = $Almacen->insert($sql,$arrayString);

				/*	if($id != 0) {
						$counter++;
						
					} else {
						
						array_push($GuiaNoCargadas,$ODT->getValue());
					}
				*/	
				} else {
					//array_push($GuiaYaCargadas," No se Cargo el Traspaso de Tipo $Clave->getValue() y numero de guia $Serie  el producto $Serie " );
					$mensajeYaCargadas .= " Ya existe Tipo $Clave y numero de serie  $Serie  el producto $Serie <br />  " ;
				}
			} 
		} else {
			$mensajeYaCargadas .= " No existe el num serie  $Serie  En el Inventario <br />  " ;
		}
	}

	echo json_encode(['traspasos' => $allTraspasos, 'mensajeYaCargadas' => $mensajeYaCargadas ]);
	//echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "registrosCargados" => $counter, "guiaNoCargadas" => $GuiaNoCargadas,"guiaYaCargadas" => $GuiYaCargadas]);

		
}

if($module == 'grabarTraspaso') {

	 
	$info = json_decode($params['info']);
	$cantAnterior = $Almacen->existeInventario($info[1]);

	$datafieldsTraspasos = array('tipo','no_serie','modelo','cantidad','no_guia','codigo_rastreo','origen','destino','cuenta_id','estatus','fecha_creacion','ultima_act');
		
	$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTraspasos), '?'));

	$sql = "INSERT INTO traspasos (" . implode(",", $datafieldsTraspasos ) . ") VALUES (".$question_marks.")"; 

	$arrayString = array (
		$info[0],
		$info[1],
		$info[2],
		$info[3],
		$info[4],
		$info[5],
		$info[6],
		$info[7],
		$info[8],
		$info[9],
		$info[10],
		$info[11]
	);

	
	 $id = $Almacen->insert($sql,$arrayString);

	
	if($id > 0 ) {

		//AGREGAR registro al inventario del Tecnico
		if($info[8] != '0') {
			//Actualizar Estatus inventario 
			if($info[0] == 'INSUMO' || $info[0] == 'ACCESORIOS' ) {
				$newQty = $cantAnterior - (int) $info[3];
			} else {
				$newQty = $info[3];
			}

			$fecha = date ( 'Y-m-d H:m:s' );
			$sql = " UPDATE `inventario` SET `estatus_inventario`=?,`ubicacion`=?,`id_ubicacion`=?,`cantidad`=?,`fecha_edicion`=? WHERE `no_serie`=? "; 
	
			$arrayString = array (
				2,
				4,
				$info[8],
				$newQty,
				$fecha,
				$info[1]
			);
	
			$Almacen->insert($sql,$arrayString);

			$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

			$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
			$arrayString = array (
				$info[8],
				$info[1],
				$info[3],
				$info[4],
				0,
				$_SESSION['userid'],
				$info[10],
				$info[11]
			);

			$Almacen->insert($sql,$arrayString);
		

			//GRABAR HISTORIA 

			
			switch($info[0]) {
				case 'TPV':
					$TipoS = 1;
				break;
				case 'SIM':
					$TipoS = 2;
				break;
				case 'INSUMO':
					$TipoS = 3;
				break;
				case 'ACCESORIOS':
					$TipoS = 4;
				break;
				default:
					$TipoS = $info[0];
			}
			
			$fecha = date ( 'Y-m-d H:m:s' );
			$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
			$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$id,
				$fecha,
				'TRASPASO',
				4,
				$info[1],
				$TipoS,
				$info[3],
				$info[8]
			);
		
			$Almacen->insert($sql,$arrayString);

		}

		echo " Se Cargo el Traspaso de Tipo $info[0] y numero de serie $info[1]  en la guia $info[4] ";
	} else {
		echo " No se Cargo el Traspaso de Tipo $info[0] y numero de guia $info[1]  en la guia $info[4] ";
	}
	
	
}



/*Grabar peticion*/
if( $module == 'guardarPeticion' )
{
	$info = json_decode($params['array'], true);
	$fecha = date("Y-m-d H:i:s");
	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	
	$prepareStatement = "INSERT INTO `peticiones` SET `supervisor_id`=?,`creado_por`=?,`fecha_creacion`=?,`modificado_por`=?,`fecha_modificacion`=? ;
					";
	
	$arrayString = array (
			$user,
			$user,
			$fecha_alta,
			$user,
			$fecha
			
	);
	
	$id = $Almacen->insert($prepareStatement,$arrayString);

	if ($id)
	{
		echo "SE GUARDARON LOS DATOS";
		$prepareStatementDet = "INSERT INTO `detalle_peticiones` 
					(`peticiones_id`,`tecnico_id`,`tipo`,`insumo`,`conectividad`,`producto`,`cantidad`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`)
					 VALUES
					 (?,?,?,?,?,?,?,?,?,?,?);
					 ";
					 
		foreach ($info as $data) 
		{
			

			$arrayStringDet = array(
				$id,
				$data['tecnico'],
				$data['tipo'],
				$data['insumo'],
				$data['conectividad'],
				$data['producto'],
				$data['cantidad'],
				$user,
				$fecha_alta,
				$user,
				$fecha
					
  
			);

			$det = $Almacen->insert($prepareStatementDet, $arrayStringDet);
		}
	}
		echo $id;
}
/**/

/*Validar NoSerie */
if( $module == 'validarSerie') {

	$rows = $Almacen->validarSerie($params['serie'],$params['tipo']);

	echo json_encode($rows);
}

if($module == 'detallePeticion') {

	$rows = $Almacen->detallePeticion($params['peticionId']);

	echo json_encode($rows);
}

if($module == 'generarEnvio') {

	$peticion = $Almacen->detallePeticion( $params['peticionId'] );
	$peticiondetalle = $Almacen->getDetallePeticion($params['peticionId']);
	$user = $_SESSION['userid'];

	foreach($peticiondetalle as $detalle) {
		
		$fecha = date("Y-m-d H:i:s");

		//cantidad x tipo
		if($detalle['tipo'] == '3') {
			$cant = $detalle['cantidad'];
			$tipo = 'INSUMOS';
		} else if ($detalle['tipo'] == '1' ) {
			$cant = 1;
			$tipo = 'TPV';
		} else if ($detalle['tipo'] == '2' ) {
			$cant = 1;
			$tipo = 'SIM';
		}


		if ($detalle['tipo'] == '3' ) {

			$tipoInsumo = $Almacen->getInsumosId($detalle['insumo']);

			$datafieldsTraspasos = array('tipo','no_serie','modelo','cantidad','no_guia','codigo_rastreo','origen','destino','cuenta_id','estatus','fecha_creacion','ultima_act');
		
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTraspasos), '?'));

			$sql = "INSERT INTO traspasos (" . implode(",", $datafieldsTraspasos ) . ") VALUES (".$question_marks.")"; 

			$arrayString = array (
				$tipo,
				$tipoInsumo['nombre'],
				0,
				$cant,
				$params['no_guia'],
				$params['codigo_rastreo'],
				1,
				0,
				$detalle['tecnico_id'],
				0,
				$fecha,
				$fecha
			);

			
			$id = $Almacen->insert($sql,$arrayString);

			//Modificar inventario general
			$item = $Almacen->getInventarioInfo($tipoInsumo['nombre']);
			$nuevaCant = (int) $item['cantidad'] - (int) $cant;

			$sql = " UPDATE `inventario` SET `cantidad`=?,`modificado_por`=?,`fecha_edicion`=? WHERE `id`=? "; 
		
			$arrayString = array (
				$nuevaCant,
				$user,
				$fecha,
				$item[0]['id']
			);

			$Almacen->insert($sql,$arrayString);

			//Grabar en Inventario Tecnico
			$invTecnico = $Almacen->getCantidadInsumosTecnico($tipoInsumo['nombre'],$detalle['tecnico_id']);

			if($invTecnico) {
				$nuevaCant = (int) $invTecnico[0]['cantidad'] - (int) $qty;
				$sql = " UPDATE `inventario_tecnico` SET `cantidad`=?,`fecha_edicion`=? WHERE `id`=? "; 
		
				$arrayString = array (
					$nuevaCant,
					$fecha,
					$invTecnico[0]['id']
				);

			} else {

				$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
				
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

				$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
				$arrayString = array (
					$detalle['tecnico_id'],
					$tipoInsumo['nombre'],
					$cant,
					$params['no_guia'],
					0,
					$user,
					$fecha,
					$fecha
				);
			}


			$newIdInv = $Almacen->insert($sql,$arrayString);

			//GRABAR HISTORIA 
			
			$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
			$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$newIdInv,
				$fecha,
				'TRASPASO',
				1,
				$noserie->NoSerie,
				$item[0]['tipo'],
				$cant,
				$detalle['tecnico_id'],
				$user
			);
		
			$Almacen->insert($sql,$arrayString);

		} else {

			$noSeries = json_decode( $detalle['no_series'] );

			foreach($noSeries as $noserie) {
				$fecha = date("Y-m-d H:i:s");
				$inventario = $Almacen->getInventarioInfo( $noserie->NoSerie );

				

				$datafieldsTraspasos = array('tipo','no_serie','modelo','cantidad','no_guia','codigo_rastreo','origen','destino','cuenta_id','estatus','fecha_creacion','ultima_act');
			
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTraspasos), '?'));

				$sql = "INSERT INTO traspasos (" . implode(",", $datafieldsTraspasos ) . ") VALUES (".$question_marks.")"; 

				$arrayString = array (
					$tipo,
					$noserie->NoSerie,
					$inventario[0]['modelo'],
					$cant,
					$params['no_guia'],
					$params['codigo_rastreo'],
					1,
					0,
					$detalle['tecnico_id'],
					0,
					$fecha,
					$fecha
				);

				
				$id = $Almacen->insert($sql,$arrayString);

				//Modificar inventario general
				$item = $Almacen->getInventarioInfo($noserie->NoSerie);

				$sql = " UPDATE `inventario` SET `estatus_inventario`=?,`ubicacion`=?,`id_ubicacion`=?,`modificado_por`=?,`fecha_edicion`=? WHERE `id`=? "; 
			
				$arrayString = array (
					2,
					4,
					$detalle['tecnico_id'],
					$user,
					$fecha,
					$item[0]['id']
				);

				$Almacen->insert($sql,$arrayString);

				//Grabar en Inventario Tecnico
				$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
				
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

				$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
				$arrayString = array (
					$detalle['tecnico_id'],
					$noserie->NoSerie,
					$cant,
					$params['no_guia'],
					0,
					$user,
					$fecha,
					$fecha
				);

				$Almacen->insert($sql,$arrayString);

				//GRABAR HISTORIA 
				
				$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
				
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
				$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
			
				$arrayString = array (
					$item[0]['id'],
					$fecha,
					'TRASPASO',
					1,
					$noserie->NoSerie,
					$item[0]['tipo'],
					$cant,
					$detalle['tecnico_id'],
					$user
				);
			
				$Almacen->insert($sql,$arrayString);

			}
		}
	
	}
	
		// Cerrar Peticion
		$sql = " UPDATE `peticiones` SET `IsActive`=?  WHERE `id`=? "; 
		
		$arrayString = array (
			1,
			$params['peticionId']
		);

		$Almacen->insert($sql,$arrayString);

	echo 1;
}

if( $module == 'getTecnicoxPlaza') {

	$val = '<option value="0"> Seleccionar </option>';
	$rows = $Almacen->getTecnicoxPlaza($params['plaza']);

	foreach ($rows as $row) {
		$val .= '<option value="' . $row['cuenta_id'] . '" >' . $row['nombre'] . '</option>';
	}
	echo $val;

	echo json_encode($rows);
}

if($module == 'cargarInventarioMasivo') {
	$target_dir = "../cron/files/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$uploadOk = 1;
	$fecha = date ( 'Y-m-d H:m:s' );

	if($imageFileType != "csv" && $imageFileType != "xls" && $imageFileType != "xlsx" ) {
  		echo "Error solo archivos CSV o XSL";
  		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
  		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			 
			$datafieldsCargar = array('tipo','archivo','creado_por','fecha_creacion','fecha_modificacion');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCargar), '?'));
			$sql = "INSERT INTO carga_archivos (" . implode(",", $datafieldsCargar ) . ") VALUES (".$question_marks.")"; 
	
			$arrayString = array (
				'I',
				$_FILES["file"]["name"],
				$_SESSION['userid'],
				$fecha,
				$fecha
			);
		
			$id = $Almacen->insert($sql,$arrayString);
			echo "Se Cargo el Archivo. $id ".$target_file;

		} else {
			echo "No se puede cargar el Archivo. " ;
		}
	}
}

if($module == 'InventariosMasivo') {
	$counter = 0;
	$GuiaNoCargadas = array();
	$GuiaYaCargadas = array();
	$mensajeYaCargadas = '';
	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$FechaAlta = date('Y-m-d');
	
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
	$allInventarios = array();
	$exist = 0;
	$yaExiste = 0;

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) 
	{
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$Tipo = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		
		$No_serie = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		$No_serie = trim(utf8_decode($No_serie->getValue())," \t\n\r\0\x0B\xA0");
		$No_serie = preg_replace( '/[^a-z0-9 ]/i', '', $No_serie);
		
		$Linea = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);

		$Modelo = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Conectividad = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);

		$Estatus = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);

		$Anaquel = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		$Caja =   $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
		$Tarima = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		$Cantidad = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
		$cveBanco = $hojaDeProductos->getCellByColumnAndRow(11, $indiceFila);
		$almacen = $hojaDeProductos->getCellByColumnAndRow(12, $indiceFila);
		
		$almacenId = $Almacen->getAlmacenId(trim($almacen->getValue()));
		$EstatusId = $Almacen->getEstatusId(trim($Estatus->getValue()));
		
		//Validar que tenga permisos para cargar en otros almacenes
		$valido = 0;

		if ($_SESSION['almacen'] != $almacenId) 
		{

			if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'CA') 
			{

			} 
			else 
			{
				$valido = 1;
			}

		}

		if($valido == 0) 
		{


				if($Tipo->getValue() == '1' )  
				{
					$ModeloExiste = $Almacen->getModeloId(trim($Modelo->getValue()));
					$ModeloId = is_null( $ModeloExiste ) ? 0 :  $ModeloExiste  ;
					
					$ConectividadId = $Almacen->getConectividadId(trim($Conectividad->getValue()));
					$CantidadQty = 1;
				} 
				else if ( $Tipo->getValue() == '2' )  
				{
					$ModeloExiste = $Almacen->getCarrierId(trim($Modelo->getValue()));
					$ModeloId = is_null($ModeloExiste) ? 0 : $ModeloExiste;
					$ConectividadId = 0;
					$CantidadQty = 1;
				} 
				else if ( $Tipo->getValue() == '3' )  
				{
					$ModeloId = 0;
					$ConectividadId = 0;
					$CantidadQty = $Cantidad->getValue();
				} 
				else 
				{
					$AccesorioExiste = $Almacen->getAccesoriosId($No_serie);
					$ModeloId = $AccesorioExiste; //is_null($AccesorioExiste ) ? 0 : $AccesorioExiste ;
					$ConectividadId=0;
					$CantidadQty = $Cantidad->getValue();
				}
				

				if(!is_null($No_serie)  ) 
				{
				
					$existeNoSerie = $Almacen->existeInventario($No_serie);
					
						if($Tipo == '1' || $Tipo == '2') 
						{
							$newQty = 1;
							if(is_null($existeNoSerie)) 
							{
								$yaExiste = 0 ;
							} else 
							{
								$yaExiste++;
							}
						} 
						else 
						{
							$inventarioInsumo = $Almacen->existeInventarioInsumos($No_serie,$almacenId);
							 
							$oldQty = $inventarioInsumo  ?  $inventarioInsumo : 0 ;
							$newQty = (int)  $oldQty  + (int) $CantidadQty;
						}

						if($yaExiste == 0) {

							
							$arrayString = array (
								$Tipo->getValue(),
								$No_serie,
								$Linea->getValue(),
								$ModeloId,
								$ConectividadId,
								$EstatusId,
								$Anaquel->getValue(),
								$Caja->getValue(),
								$Tarima->getValue(),
								$newQty,
								1,
								$almacenId,
								$_SESSION['userid'],
								$fecha,
								$fecha,
								$fecha,
								$existeNoSerie,
								$CantidadQty,
								$cveBanco->getValue()
							);

							array_push($allInventarios,$arrayString);
							

						} 
						else 
						{
							//array_push($GuiaYaCargadas," No se Cargo el Traspaso de Tipo $Clave->getValue() y numero de guia $Serie  el producto $Serie " );
							$mensajeYaCargadas .= " Ya existe El Num de serie $No_serie  de TPV o SIM <br />" ;
							$yaExiste = 0;
						}
					
				} 
				else 
				{
					$mensajeYaCargadas .= " Se necesita un Num de serie <br />  " ;
				}
			

		} 
		else 
		{

			$mensajeYaCargadas .= " No tienes permisos para cargar al almacen $almacen   <br />" ;
		}
			
	}

	echo json_encode(['inventarios' => $allInventarios, 'mensajeYaCargadas' => $mensajeYaCargadas,'valid' =>$valido ]);
	//echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "registrosCargados" => $counter, "guiaNoCargadas" => $GuiaNoCargadas,"guiaYaCargadas" => $GuiYaCargadas]);

		
}

if($module == 'grabarInventario') 
{

	$info = json_decode($params['info']);
	$new = 0;

	/// validar Elavon Universo
	$existElavonUniverso = $Almacen->validateElavonUniverso($info[1]);

	if( $info[0] == '3' || $info[0] == '4'  ) {
		$existElavonUniverso = 1;
	}

	if( $existElavonUniverso == '0' ) 
	{
		echo " $info[1] No existe en Universo Elavon ";
	} 
	else 
	{
	
		$datafieldsInventarios = array('tipo','no_serie','linea','modelo','conectividad','estatus','estatus_inventario','anaquel','caja','tarima','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','cve_banco');
			
		$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));

		if($info[0] == '1' || $info[0] == '2' ) 
		{
			$new = 1;

		} 
		else if(is_null($info[16])  ) 
		{
			$new = 1;
		} 
		else 
		{
			$new= 2;
		}
			
		if($new == 1) 
		{
			$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$info[0],
				$info[1],
				$info[2],
				$info[3],
				$info[4],
				$info[5],
				1,
				$info[6],
				$info[7],
				$info[8],
				$info[9],
				$info[10],
				$info[11],
				$info[12],
				$info[13],
				$info[14],
				$info[15],
				$info[18]
			);

			$id = $Almacen->insert($sql,$arrayString);

			//GRABAR HISTORIA 
			$fecha = date ( 'Y-m-d H:m:s' );
			$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
			$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$id,
				$fecha,
				'ENTRADA',
				1,
				$info[1],
				$info[0],
				$info[9],
				$info[11],
				$info[12]
			);
		
			$Almacen->insert($sql,$arrayString);

		} 
		else if($new == 2) 
		{
			$fecha = date ( 'Y-m-d H:m:s' );
			$id = $Almacen->getInventarioId($info[1],$info[10]);

			$sql = " UPDATE `inventario` SET `cantidad`=?,`fecha_edicion`=? WHERE `id`=? "; 
		
			$arrayString = array (
				$info[9],
				$fecha,
				$id
			);

			$Almacen->insert($sql,$arrayString);

			//GRABAR HISTORIA 
			$fecha = date ( 'Y-m-d H:m:s' );
			$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
			$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
		
			$arrayString = array (
				$id,
				$fecha,
				'ENTRADA ACT',
				1,
				$info[1],
				$info[0],
				$info[17],
				$info[11],
				$info[12]
			);
		
			$Almacen->insert($sql,$arrayString);
		}


		 

		if($id > 0 ) 
		{
			echo " $id Se Cargo al Inventario un producto de Tipo $info[0] y numero de serie $info[1]  ";
		} 
		else 
		{
			echo " $id  No se Cargo el Inventario  de Tipo $info[0] y numero serie $info[1]  modelo $info[3] ";
		}
	} 
	
}


if($module == 'InventarioElavon') 
{
	$counter = 0;
	$GuiaNoCargadas = array();
	$GuiaYaCargadas = array();
	$mensajeYaCargadas = '';
	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$FechaAlta = date('Y-m-d');
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
	$allInventarios = array();
	$exist = 0;
	$yaExiste = 0;

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) 
	{
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		 
		$No_serie = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$No_serie = trim(utf8_decode($No_serie->getValue())," \t\n\r\0\x0B\xA0");
		$No_serie = preg_replace( '/[^a-z0-9 ]/i', '', $No_serie);
		$Fabricante = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		$Estatus = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$Estatus_Modelo = 3;
		
		//Validar que tenga permisos para cargar en otros almacenes
		$valido = 0;
 

		if($valido == 0) 
		{


				if($Fabricante->getValue() == 'TELCEL' || $Fabricante->getValue() == 'MOVISTAR' || $Fabricante->getValue() == 'M2M' || $Fabricante->getValue() == 'AT&T' || $Fabricante->getValue() == 'M2M Local
				' || $Fabricante->getValue() == 'UNO'  )  
				{
					$Tipo = 2;
					 
				} 
				else 
				{
					$Tipo = 1;
				}

				if($Estatus->getValue() == 'CANCELADO') {
					$Estatus_Modelo = 7;
				} else if($Estatus == 'ACTIVA') {
					$Estatus_Modelo = 3;
				} else if($Estatus == 'PERTENECE A ELAVON') {
					$Estatus_Modelo = 3;
				} else if($Estatus == 'QUEBRANTADA ¡NO INSTALAR!') {
					$Estatus_Modelo = 16;
				}
				

				if(!is_null($No_serie)  ) 
				{
				
					
				/*	$existeNoSerie = $Almacen->validateElavonUniverso($No_serie);
					if($existeNoSerie == '0') {
						$yaExiste = 0 ;
					} else {
						$yaExiste++;
					}
						
					if($yaExiste == 0) 
					{

						
						$arrayString = array (
							$No_serie,
							$Fabricante->getValue(),
							$Estatus->getValue(),
							$Estatus_Modelo,
							$Tipo,
							0
							
						);

						 
						//$mensajeYaCargadas .= " Se va a agregar El Num de serie $No_serie  de TPV o SIM <br />" ;

					} else { 
						; 
						$arrayString = array (
							$No_serie,
							$Fabricante->getValue(),
							$Estatus->getValue(),
							$Estatus_Modelo,
							$Tipo,
							1
							
						);*/
						$fab = $Fabricante->getValue();
						$est = $Estatus->getValue();
						$fecha =date ( 'Y-m-d H:m:s' );
						
						$sql = "INSERT INTO elavon_universo (id,serie,fabricante,estatus,estatus_modelo,tipo,modificado_por) 
						VALUES(NULL,'$No_serie','$fab','$est',$Estatus_Modelo,$Tipo,1) 
						ON DUPLICATE KEY     
						UPDATE serie =	'$No_serie'
						,fabricante = '$fab'
						,estatus = '$est'
						,estatus_modelo = $Estatus_Modelo
						,tipo =	$Tipo
						,modificado_por = 1
						";

						$id = $Almacen->insert($sql,array());

						

						$mensajeYaCargadas .= " Se Actualizo El Num de serie $No_serie $fab <br />" ;
					//	$yaExiste = 0;
					//}

					array_push($allInventarios,$id);
					
				} else 
				{
					//$mensajeYaCargadas .= " Se necesita un Num de serie <br />  " ;
				}
			

		} else 
		{

			//$mensajeYaCargadas .= " No tienes permisos para cargar al almacen $almacen   <br />" ;
		}
			
	}

	echo json_encode(['inventarios' => $allInventarios, 'mensajeYaCargadas' => $mensajeYaCargadas,'valid' =>1 ]);
	//echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "registrosCargados" => $counter, "guiaNoCargadas" => $GuiaNoCargadas,"guiaYaCargadas" => $GuiYaCargadas]);

		
}

if($module == 'grabarInventarioElavon') 
{

	$info = json_decode($params['info']);
	$new = 0;
	$arrayString = null;
	/*if($info[5] == '0') 
	{ */
		$datafieldsInventarios = array('id','serie','fabricante','estatus','estatus_modelo','tipo','modificado_por');
				
		$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
 
		$sql = "INSERT INTO elavon_universo (" . implode(",", $datafieldsInventarios ) . ") 
				VALUES(NULL,'$info[0]','$info[1]','$info[2]',$info[3],$info[4],1) 
				ON DUPLICATE KEY     
				UPDATE serie =	'$info[0]'
				,fabricante = '$info[1]'
				,estatus = '$info[2]'
				,estatus_modelo = $info[3]
				,tipo =	$info[4]
				,modificado_por = 1
				";

		$id = $Almacen->insert($sql,$arrayString);
		/*$sql = "INSERT INTO elavon_universo (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 
			
				$arrayString = array (
					$info[0],
					$info[1],
					$info[2],
					$info[3],
					$info[4],
					1
				);
	

		$id = $Almacen->insert($sql,$arrayString);
		$msg = "Agrego en ";
		
	} 
	else 
	{

		$sql = " UPDATE `elavon_universo` SET `fabricante`=?,`estatus`=?,`estatus_modelo`=?,`estatus`=? WHERE `serie`=? "; 
		
		$arrayString = array (
			$info[1],
			$info[2],
			$info[3],
			$info[4],
			$info[0]
		);

		$Almacen->insert($sql,$arrayString);
		$id= 1;
		$msg = "Actualizo en ";
	} */
	 

	//if($id > 0 ) {
		echo " Se Actualizo Elavon Universo el numero de serie $info[0] del Fabricante $info[1]  ";
	//} else {
	//	echo " No se Cargo a Elavon Universo el numero de serie $info[0] del Fabricante $info[1] ";
	// }
	
}

if($module == 'getSerie')
{
	$rows = $Almacen->getSerie($params['serie']);
	
	echo json_encode($rows);
}

//Reporte TPV, SIM

if($module == 'getSeriesIE') 
{
	$array_eventos = $Almacen->getSeriesTpvSimEventos($params['serie']);
	$array_inventario = $Almacen->getSerieInfo($params['serie']);
	
	echo json_encode(['eventos' => $array_eventos, 'inventario' => $array_inventario]);
}

if($module == 'cargarInventarioEditar') {
	$target_dir = "../cron/files/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$uploadOk = 1;
	$fecha = date ( 'Y-m-d H:m:s' );

	if($imageFileType != "csv" && $imageFileType != "xls" && $imageFileType != "xlsx" ) {
  		echo "Error solo archivos CSV o XSL";
  		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
  		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			 
			$datafieldsCargar = array('tipo','archivo','creado_por','fecha_creacion','fecha_modificacion');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCargar), '?'));
			$sql = "INSERT INTO carga_archivos (" . implode(",", $datafieldsCargar ) . ") VALUES (".$question_marks.")"; 
	
			$arrayString = array (
				'IA',
				$_FILES["file"]["name"],
				$_SESSION['userid'],
				$fecha,
				$fecha
			);
		
			$id = $Almacen->insert($sql,$arrayString);
			echo "Se Cargo el Archivo. $id ".$target_file;

		} else {
			echo "No se puede cargar el Archivo. " ;
		}
	}
}
//Actualizar info series TPV y SIM
if ($module == 'InventarioEditar')
{
	$counter = 0;
	$GuiaNoCargadas = array();
	$GuiaYaCargadas = array();
	$mensajeYaCargadas = '';
	$eventoMasivo = new CargasMasivas();
	
	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);
	
	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s ' );
	$FechaAlta = date('Y-m-d');
	
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); //Númerico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); //Letra
	
	# Convertir la letra al numero de fila correspondiente 
	$numeroMayorDeColumna =  \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
	$allInventarios = array();
	$exist = 0;
	$yaExiste = 0;
	
	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++)
	{
		$Tipo = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		
		$No_serie = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		$No_serie = trim(utf8_decode($No_serie->getValue())," \t\n\r\0\x0B\xA0");
		$No_serie = preg_replace( '/[^a-z0-9 ]/i', '', $No_serie);
		
		$Modelo = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$Conectividad = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Estatus = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
		$Estatus_ubicacion = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
		$ubicacion = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		
		$ModeloId = $Almacen->getModeloId($Modelo->getValue());
		$ConectividadId = $Almacen->getConectividadId($Conectividad->getValue());
		$EstatusId = $Almacen->getEstatusId($Estatus->getValue());
		$Estatus_ubicacionId = $Almacen->getEstatusInvId($Estatus_ubicacion->getValue());
		$ubicacionId = $Almacen->getAlmacenId($ubicacion->getValue());
		
		$valido = 0;
		
		/*if ($_SESSION['almacen'] != $almacenId)
		{
			if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'CA')
			{
				//
			}
			else
			{
				$valido = 1;
			}
			
		}*/
		
		if ($valido == 0)
		{
			/*if($Tipo->getValue() == 'TPV')
			{
				$TipoId = "1";
			}
			else if ($Tipo->getValue() == 'SIM')
			{
				$TipoId = "2";
			} */
			$TipoId =$Tipo->getValue();
			
			if (!is_null($No_serie))
			{
				//$existeNoSerie = $Almacen->existeInventario($No_serie);
				
				$arrayString = array (
				$TipoId,
				$No_serie,
				$ModeloId,
				$ConectividadId,
				$EstatusId,
				$Estatus_ubicacionId,
				$ubicacionId
				);
				
				array_push($allInventarios, $arrayString);
					
			}
			else
			{
				$mensajeYaCargadas .= " Se necesita un Num de serie <br /> " ;
			}
			
		}
		else
		{
			$mensajeYaCargadas .= " No tienes permisos para cargar al almacen <br />";
		}
		
		
	}
	echo json_encode(['inventarios' => $allInventarios, 'mensajeYaCargadas' => $mensajeYaCargadas, 'valid' => $valido]);
	
}


if ($module == 'UpdateInventario')
{
	$info = json_decode($params['info']);
	$fecha = date ( 'Y-m-d H:m:s' );
	$campoUpdate = " tipo=?, fecha_edicion=?  ";
	$new = 0;
	$arrayString = array(
		$info[0],
		$fecha
	);



	 if($info[2]) {
		 $campoUpdate .= " ,modelo=? ";
		 array_push($arrayString,$info[2]);
	 }

	 if($info[3]) {
		$campoUpdate .= " ,conectividad=? ";
		array_push($arrayString,$info[3]);
	 }
	 if($info[4]) {
		$campoUpdate .= " ,estatus=? ";
		array_push($arrayString,$info[4]);
	 }
	 if($info[5]) {
		$campoUpdate .= " ,estatus_inventario=? ";
		array_push($arrayString,$info[5]);
	 }
	 if($info[6]) {
		$campoUpdate .= " ,ubicacion=? ";
		array_push($arrayString,$info[6]);
	 }

	 array_push($arrayString,$info[1]);

	$sql = "UPDATE inventario 
			SET 
			$campoUpdate
			WHERE no_serie=?" ;

	

	$id = $Almacen->insert($sql,$arrayString);
	
	$msg = "actualizó en ";
	
	if ($id < 0)
	{
		echo " No se $msg Inventario el numero de serie $info[1] de tipo $info[0]  ";
	}
	else
	{
		echo " Se $msg Inventario el numero de serie $info[1] de tipo $info[0]  ";
	}
}

?>
