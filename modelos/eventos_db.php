<?php
session_start();
ini_set('memory_limit', '128M');
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');
include 'IConnections.php';
class Eventos implements IConnections {
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
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos` limit 1" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private  static function execute_ins($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );
		//self::$logger->error ($prepareStatement ." ".json_encode( $arrayString ));

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
		}
	}

	private static function execute_bulkins($prepareStatement, $arrayString) {

		
		self::$connection->beginTransaction();
		$stmt = self::$connection->prepare ( $prepareStatement );
		try {
			
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_bulkins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
		self::$connection->commit();
		
	}

	function select($prepareStatement, $arrayString){
		
		return self::execute_sel ( $prepareStatement, $arrayString);
	}

	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}

	function insertBulk($prepareStatement, $arrayString) {

		return self::execute_bulkins ( $prepareStatement, $arrayString );
	
	}
	
	function getEstados() {
		
		$sql = "select * from estados";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getEstadoNombre(){
    	$sql = "select * from estados";

    	try {
    		$stmt = self::$connection->prepare ($sql);
    		$stmt->execute();
    		return $stmt->fetchAll ( PDO::FETCH_ASSOC);
    	} catch (PDOException $e) {
 			self::$logger->error ("File: eventos_db.php; 	Method Name: getEstadoNombre(); Functionality: Get Products Price From PriceLists; Log:" . $e->getMessage ());   		
    	}
    }
    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$userId = $_SESSION['userid'];
		$valid = $_SESSION['validacion'];
		$territorial = $_SESSION['territorial'];
		$evidencias = $params['evidencias'];
		$territorio = isset($params['territorialF']) ? $params['territorialF'] : array(); //filtro territorial
		
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
		$filter = "";
		$param = "";
		$where = "";
		$cveBanco = $_SESSION['cve_user'];
		//$userValidacion = $_SESSION['validacion'];

		//echo $userValidacion;

		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}				   
		$inicio = $params['fechaVen_inicio'];
		$fin = $params['fechaVen_fin'];

		if ($_SESSION['tipo_user'] == 'callcenter') {

			if ($_SESSION['validacion'] == '0') {
				$where .= " AND e.agente_cierre = $userId";
			}else
			{
				$where .= "";
			}
			
		}

		if($params['estatusSearch'] !=0 ) {
			$where .= " AND e.estatus=".$params['estatusSearch'];
		}
   
    	if($params['tipoevento'] !=0 ) {
			$where .= " AND e.tipo_servicio=".$params['tipoevento'];
		}
		
		if($_SESSION['tipo_user'] == 'VO' || $_SESSION['tipo_user'] == 'supVO' ) {
			 $where .= " AND e.servicioid= '15'";
		}
   
		if($_SESSION['tipo_user'] == 'supOp' ) {
			 $where .= " AND cp_territorios.territorio_id IN ('$territorial') ";
		}
		//filtro territorial
		if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'supervisor'){

			if( $params['territorialF'] != 0 )
			{
				//$where .= " AND cp_territorios.territorio_id = ".$params['territorialF'];
				$where .= " AND cp_territorios.territorio_id = $territorio ";
			}
		}

		//filtro tecnico
		if($params['tecnicof'] != 0){
			$where .=" AND e.tecnico =".$params['tecnicof'];
		}

		if($params['bancof'] != 0)
		{
			$where .= " AND e.cve_banco = ".$params['bancof'];
		}

		if($evidencias == '1') {
			$where .= " AND img.totalImg > 0 ";
		}
	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( e.odt LIKE '".$params['search']['value']."%' ";    
			$where .=" OR e.afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR e.comercio LIKE '".$params['search']['value']."%' ";
			$where .=" OR e.servicio LIKE '".$params['search']['value']."%'  ";
			$where .=" OR e.estatus LIKE '".$params['search']['value']."%'  )";

		}
    
     

		$sql = "SELECT e.id,
				e.odt,
				e.cve_banco,
				e.afiliacion,
				CASE WHEN e.cve_banco = '' THEN 'Sin Clave' ELSE GetNameById(e.cve_banco,'CveBanco') END cveBancoNombre,
				c.comercio  comercio ,
				CASE WHEN e.tipo_servicio = '' THEN 0 ELSE GetNameById(e.tipo_servicio,'TipoServicio') END servicio, 
				CASE WHEN e.servicio = '' THEN 0 ELSE GetNameById(e.servicio,'TipoSubServicio') END subservicio, 
				e.fecha_alta,
				e.fecha_atencion,
				e.fecha_cierre,
				e.fecha_vencimiento,
				CASE WHEN (e.fecha_cierre > e.fecha_vencimiento) THEN DATEDIFF(e.fecha_cierre, e.fecha_vencimiento) ELSE 0 END dias,
				e.estatus,
				e.estatus_servicio,
				CASE WHEN ee.nombre is null then GetNameById(e.estatus_servicio,'EstatusServicio') ELSE ee.nombre END nombreEstatusServicio,
				e.municipio,
				e.comentarios_cierre,
				CASE WHEN e.estatus = '' THEN '' ELSE GetNameById(e.estatus,'Estatus') END nombreEstatus,
				IFNULL(img.totalImg,0) totalImg,
				CONCAT(du.nombre,' ',IFNULL(du.apellidos,'')) tecnico,
				e.tipo_servicio,
				e.servicio servicioid,
				e.sync
				from eventos e
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = e.tecnico
				LEFT JOIN comercios c ON  e.comercio = c.id
				LEFT JOIN cp_territorios ON c.cp = cp_territorios.cp
				LEFT JOIN view_total_odt_img img ON img.odt = e.odt
				LEFT JOIN estatus_equivalencias ee ON ee.cve_banco = e.cve_banco AND ee.estatus_id = e.estatus AND ee.estatus_servicio = e.estatus_servicio
				WHERE date(e.fecha_alta) BETWEEN '$inicio' AND '$fin'
				$where
				group by id,img.totalImg,du.nombre,du.apellidos,ee.nombre
				$order
				$filter ";	
			//AND e.cve_banco IN ('$cveBanco')
			//self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getTotalTable() {

		$sql = "SELECT count(*) FROM eventos ";
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTotalTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
		$sql = "select eventos.*,
				GetNameById(tipocredito_vo,'TipoCredito') tipocreditoNombre,
				eventos.estado  estado,
				CASE WHEN cast(eventos.estado AS UNSIGNED) = 0 THEN eventos.estado ELSE GetNameById(eventos.estado,'Estado') END estadoNombre,
				municipio ,
				CASE WHEN cast(municipio AS UNSIGNED) = 0 THEN municipio ELSE GetNameById(municipio,'Municipio') END municipioNombre,
				CONCAT(u.nombre,' ',IFNULL(u.apellidos,'')) tecnicoNombre ,
				c.comercio comercioNombre ,
				ts.nombre servicioNombre,
				CASE WHEN servicio = '' OR  servicio is null THEN 0 ELSE GetNameById(servicio,'TipoSubServicio') END subservicioNombre  ,
				te.nombre  estatusNombre ,
				IFNULL(tpvIn.modelo,0)  tvpInModelo,
                IFNULL(tpvIn.conectividad,0) tvpInConectividad,
				IFNULL(tpvRe.modelo,0)  tvpReModelo,
                IFNULL(tpvRe.conectividad,0) tvpReConectividad,
				IFNULL(simIn.modelo,0) simInCarrier,
                IFNULL(simRe.modelo,0) simReCarrier,
				cevento.serie faltaserie,
				cevento.evidencia faltaevidencia,
				cevento.informacion faltainformacion,
				cevento.ubicacion faltaubicacion,
				cevento.aplica_exito,
				cevento.aplica_rechazo_2,
				ee.nombre nombreStatus
				from eventos 
				LEFT JOIN detalle_usuarios u ON u.cuenta_id = tecnico
				LEFT JOIN comercios c ON c.id = eventos.comercio
				LEFT JOIN estados e ON e.id = eventos.estado
				LEFT JOIN tipo_estatus te ON te.id = eventos.estatus
				LEFT JOIN tipo_servicio ts ON ts.id = eventos.tipo_servicio
				LEFT JOIN inventario tpvIn ON eventos.tpv_instalado = tpvIn.no_serie
				LEFT JOIN inventario tpvRe ON eventos.tpv_retirado = tpvRe.no_serie 
				LEFT JOIN inventario simIn ON eventos.sim_instalado= simIn.no_serie
				LEFT JOIN inventario simRe ON eventos.sim_retirado = simRe.no_serie
				LEFT JOIN checklist_evento cevento ON cevento.odt = eventos.odt AND cevento.tecnico = eventos.tecnico
				LEFT JOIN estatus_equivalencias ee ON ee.cve_banco = eventos.cve_banco AND ee.estatus_id = eventos.estatus AND ee.estatus_servicio = eventos.estatus_servicio
				where eventos.id = $id ";

				//self::$logger->error($sql);
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEvento();	Functionality: Get Evento By Id;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		//$sql = "select img.*,ev.nombre titulo from img 
		//      left join tipo_evidencias ev ON img.clasificador = ev.id where odt LIKE '%$id%' and tipo=1";
		$id = strtoupper($id);
		$sql = "select img.*,ev.nombre titulo from img  left join tipo_evidencias ev ON img.clasificador = ev.id where UPPER(odt) = UPPER('$id') and tipo=1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getDocsODT($id) {
		$sql = "select * from img where odt = '$id' and tipo=2";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getDocsODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt LIKE '%$id%' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getConsultaODT($odt) {
		$sql = "SELECT *,detalle_usuarios.nombre nombre_tecnico,
				GetNameById(tipo_servicio,'TipoServicio') servicioNombre,
				null subservicioNombre 
				from eventos 
				LEFT JOIN detalle_usuarios ON eventos.tecnico = detalle_usuarios.cuenta_id
				where odt = '$odt' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getConsultaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	/*Historia ODT//EVENTOS*/
	
	function getHistorialODT($params, $total){
		$start = $params['start'];
		$length = $params['length'];
		$filter = "";
		$param = "";
		
		$odt = $params['historiaOdt'];
		$query = "";
		$where = '';
		
		if($odt == '') {
			$odt = -1;
		}
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}
		
		if( !empty($params['search']['value'])) {
			$where .=" AND ";
			$where .=" (tipo_estatus.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR cuentas.correo LIKE '".$params['search']['value']."%' )";
		}
		
		$sql = "SELECT historial_eventos.fecha_movimiento, tipo_estatus.nombre,CONCAT(du.nombre,' ',du.apellidos)usuario, cuentas.correo 
				FROM `historial_eventos` 
				LEFT JOIN tipo_estatus ON tipo_estatus.id = historial_eventos.estatus_id 
				LEFT JOIN cuentas ON cuentas.id = historial_eventos.modified_by
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = historial_eventos.modified_by
				WHERE historial_eventos.odt = '$odt'
				$where 
				ORDER BY historial_eventos.id ASC ";

				//self::$logger->error($sql);
				
		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getHistorialODT();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}
	
	function getHistorialEventos($params, $total){
		$start = $params['start'];
		$length = $params['length'];
		$filter = "";
		$param = "";
		
		$odt = $params['historiaOdt'];
		$query = "";
		$where = '';
		
		if($odt == '') {
			$odt = -1;
		}
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}
		
		if( !empty($params['search']['value'])) {
			$where .=" AND ";
			$where .=" (tipo_estatus.nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR cuentas.correo LIKE '".$params['search']['value']."%' )";
		}
		
		$sql = "SELECT
		eventos.tpv_instalado SerieEntrada,
		eventos.aplicativo id_apli,
		tipo_aplicativo.nombre Aplicativo,
		eventos.producto,
		inventario.conectividad id_CN,
		tipo_conectividad.nombre Conectividad,
		eventos.tpv_retirado SerieSalida,
		eventos.sim_instalado SimEntrada,
		eventos.sim_retirado SimSalida,
		IFNULL(tpvIn.modelo, 0) tvpInModelo,
		IFNULL(tpvIn.conectividad, 0) tvpInConectividad,
		IFNULL(tpvRe.modelo, 0) tvpReModelo,
		IFNULL(tpvRe.conectividad, 0) tvpReConectividad,
		IFNULL(simIn.modelo, 0) simInCarrier,
		IFNULL(simRe.modelo, 0) simReCarrier, modelos.modelo,
		CONCAT(detalle_usuarios.nombre, '', detalle_usuarios.apellidos) usuario
			FROM
				eventos
			LEFT JOIN tipo_aplicativo ON tipo_aplicativo.id = eventos.aplicativo
			 JOIN inventario ON inventario.no_serie = eventos.tpv_instalado
			LEFT JOIN tipo_conectividad ON inventario.conectividad = tipo_conectividad.id
			LEFT JOIN inventario tpvIn ON
				eventos.tpv_instalado = tpvIn.no_serie
			LEFT JOIN inventario tpvRe ON
				eventos.tpv_retirado = tpvRe.no_serie
			LEFT JOIN inventario simIn ON
				eventos.sim_instalado = simIn.no_serie
			LEFT JOIN inventario simRe ON
				eventos.sim_retirado = simRe.no_serie
			LEFT JOIN modelos ON inventario.modelo = modelos.id
			LEFT JOIN detalle_usuarios ON detalle_usuarios.cuenta_id = eventos.modificado_por

				WHERE eventos.odt = '$odt'
				$where 
				$filter";

			//self::$logger->error($sql);
				
		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getHistorialEventos();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}
	
	/**/
	
	function getTipoServicios($tipo,$banco) {
		$where = "";
     if( $tipo != '0') {
       $where = " AND tipo = '$tipo' ";
     }

     if ($banco == '') {
     	$banco = '037';
     }
     
		$sql = "SELECT * from tipo_servicio WHERE status=1 AND cve_banco IN ($banco) $where";

		//self::$logger->error($sql);
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($banco));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getTipoServicios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoSubServicios($servicio) {
		
		   $sql = "SELECT * from tipo_subservicios  WHERE status=1 AND servicio_id = ?";
		   //self::$logger->error ($sql);
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array($servicio));
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getTipoSubServicios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		   }
	}

	function getTipoServiciosBanco($banco) {
		    
		$sql = "SELECT * from tipo_servicio where cve_banco = '$banco' AND tipo = 'rep'";

		//self::$logger->error($sql);
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getTipoServiciosBanco();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
 
	function getCveBanco($cvebanco) {
     
     if( $cvebanco != '0') {
       $where = " Where tipo = '$cvebanco' ";
     }
		  
     $sql = "SELECT * from bancos $where";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getCveBanco();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoFallas() {
		$sql = "SELECT * from tipo_falla ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getTipoFallas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoConectividad() {
		$sql = "SELECT * from tipo_conectividad ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getTipoConectividad();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getMunicipios($estado) {
		$sql = "SELECT * from municipios where estado=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($estado));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getMunicipios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getEquipos($id) {
		$sql = "SELECT id,no_serie from inventario where id_ubicacion=? AND tipo=1 ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEquipos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
 
	function getModelos($nserie,$cve_banco) {
		$sql = "SELECT id,modelo from modelos where estatus=1 AND cve_banco=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cve_banco));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getModelos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getListaModelos($cve_banco) {
		$sql = "SELECT id,modelo from modelos WHERE estatus=1 AND cve_banco =?";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cve_banco));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getListaModelos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getListaConectividad($cve_banco) {
		$sql = "SELECT id,nombre from tipo_conectividad WHERE estatus=1 AND cve_banco=?";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cve_banco));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getListaConectividad();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	
	function getTotalEventos() {
		$sql = "SELECT * Total from eventos";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getTotalEventos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getLastEventDate() {
		$sql = " Select fecha_creacion,odt from eventos 
				where id in ( SELECT id from eventos where fecha_creacion= (Select MAX(fecha_creacion) from eventos  ) ) ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch(PDO::FETCH_ASSOC);
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getLastEventDate();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getComercioBy($afilacion,$cve) {
		$sql = "SELECT *  from comercios where afiliacion=? and cve_banco=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($afilacion,$cve));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getComercioBy();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function createFechaCierre($tipo_comercio) {
		date("w") == 5 ? $viernes = 1 : $viernes = 0;
		$hora_cierre = '23:59:00';

		if(date("H") >=10) {
			if($viernes == 1 ) {
				if($tipo_comercio == '1') {
					$n_fecha = strtotime ( '+3 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				} else {
					$n_fecha = strtotime ( '+4 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				}
			} else {
				if($tipo_comercio == '1') {
					$n_fecha = strtotime ( '+1 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				} else {
					$n_fecha = strtotime ( '+2 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				}
			}
		} else {
			if($viernes == 1 ) {
				if($tipo_comercio == '1') {
					$n_fecha = strtotime ( '+0 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				} else {
					$n_fecha = strtotime ( '+3 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				}
			} else {
				if($tipo_comercio == '1') {
					$n_fecha = strtotime ( '+0 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				} else {
					$n_fecha = strtotime ( '+1 day' , strtotime ( date('Y-m-d') ) ) ;
					$n_fecha = date ( 'Y-m-d' , $n_fecha );
					$fecha_cierre = $n_fecha.' '.$hora_cierre;
				}
			}
		}

		return $fecha_cierre;
	}

	function buscarComercio($search) {
		//$cvebanco = $_SESSION['cve_user'];
		
		$sql = "SELECT c.id,cve_banco,c.afiliacion,c.comercio,c.direccion,c.colonia, 
				c.telefono,c.email,c.responsable,c.hora_general,c.hora_comida,c.estado estadoId ,e.nombre estado,c.ciudad ciudadId, m.nombre ciudad
				from comercios c 
				LEFT JOIN estados e ON  c.estado = e.id
				LEFT JOIN municipios m ON  c.ciudad = m.id 
				WHERE (cve_banco = '$search' OR afiliacion = '$search' OR comercio LIKE '%$search%')
				
				Group by c.id ";
				//AND cve_banco in ('$cvebanco')
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: buscarComercio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTecnicos() {
		$sql = "SELECT *, cuentas.id tecnicoId from cuentas,detalle_usuarios WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 AND cuentas.estatus=1 order By detalle_usuarios.nombre";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}
 
	function getUbicacion() {
		$sql = "SELECT id,nombre from tipo_ubicacion ORDER BY id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getUbicacion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getRechazos($tipo) {
		$sql = "SELECT * from tipo_rechazos WHERE tipo = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($tipo));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getRechazos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getCancelacion($tipo) {
		$sql = "SELECT * from tipo_cancelacion WHERE tipo = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($tipo));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getCancelacion();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function validateOdt($params) {
		$odt = $params['odt'];
		$afiliacion = $params['afiliacion'];

		$sql = "SELECT id,estatus,GetNameById(tecnico,'Tecnico') tecnico,tecnico tecnicoId,afiliacion,tipo_servicio,comercio ,count(*) existe,
		GetNameById(tipo_servicio,'TipoServicio') servicioNombre,CASE WHEN servicio = '' THEN '' ELSE GetNameById(servicio,'TipoSubServicio') END subservicioNombre,
		GetNameById(estatus_validacion,'EstatusValidacion') validacionNombre,descripcion,afiliacionamex,amex,id_caja,rollos_instalar,rollos_entregados
		from eventos WHERE odt = ?  AND afiliacion=? group by id ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt,$afiliacion));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: validateOdt();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getIdComercio($comercio) {
		

		$sql = "SELECT nombre from comercios WHERE nombre = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($comercio));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getIdComercio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getNumSerieTecnico($id) {
		$sql = "SELECT `id`, `producto`, `modelo_tpv`, `no_serie`, `fabricante`, `conect`, `ptid` FROM `almacen` WHERE  producto = 1 AND`id_ubicacion` = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getNumSerieTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getNumSerieSimTecnico($id) {
		$sql = "SELECT `id`, `producto`, `modelo_tpv`, `no_serie`, `fabricante`, `conect`, `ptid` FROM `almacen` WHERE producto= 2 AND `id_ubicacion` = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getNumSerieSimTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getNumSerieComercio($id) {
		$sql = "SELECT `id`, `producto`, `modelo_tpv`, `no_serie`, `fabricante`, `conect`, `ptid` FROM `almacen` WHERE `id_ubicacion` = ? ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getNumSerieComercio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTecnicosFilter() {
		$sql = "SELECT *, cuentas.id tecnicoId from cuentas,detalle_usuarios WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 AND cuentas.estatus=1 order By detalle_usuarios.nombre";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTecnicosFilter();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}
 
 	function getTipoEvento() {
 
     if($_SESSION['tipo_user'] == 'VO' || $_SESSION['tipo_user'] == 'supVO') {
       $sql = "SELECT * FROM `tipo_servicio` WHERE `status` = 1 AND tipo = 'vo' ";
     } else {
       $sql = "SELECT * FROM `tipo_servicio` WHERE `status` = 1 ";
     }
     
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array());
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTipoEvento();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	 }

 	function getEstatusEvento() {
 
		  $sql = "SELECT * FROM `tipo_estatus` WHERE `tipo` = 4 Order by id ";
	
		
		   
		   
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array());
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusEvento();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		   }
		}
		
 	function getEstatusServicio($cve_banco) {
 
		  //$sql = "SELECT * FROM `tipo_estatus` WHERE `tipo` = 12 Order by id ";
		  $sql = "SELECT tipo_estatus.id , CASE WHEN estatus_equivalencias.estatus_servicio is null THEN tipo_estatus.nombre ELSE estatus_equivalencias.nombre END nombre
					FROM tipo_estatus
					LEFT JOIN estatus_equivalencias ON tipo_estatus .id = estatus_equivalencias.estatus_servicio AND cve_banco = '$cve_banco'
					where tipo_estatus.tipo = 12";
	
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array());
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusServicio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		   }
	}
	

	function getEstatusCancelado() {
 
		  $sql = "SELECT * FROM `tipo_cancelacion`  Order by nombre ";
	
	   
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array());
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusCancelado();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		   }
	}
	
	function getEstatusRechazo($cvebanco) {
 
		  $sql = "SELECT * FROM `tipo_rechazos` WHERE tipo='r' AND cve_banco=?  Order by nombre ";
	

		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array($cvebanco));
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusRechazo();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		   }
	}

	function getProductos($cve_banco) {
 
		$sql = "SELECT * FROM `tipo_producto`  WHERE status = 1 and cve_banco=?  ";
  

		 try {
			 $stmt = self::$connection->prepare ($sql );
			 $stmt->execute (array($cve_banco));
			 return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		 } catch ( PDOException $e ) {
			 self::$logger->error ("File: eventos_db.php;	Method Name: getProductos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		 }
  	}

	
	
	function getEstatusSubRechazo() {
 
		  $sql = "SELECT * FROM `tipo_rechazos` WHERE tipo='s' AND cve_banco=? Order by nombre ";
	

		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array($cvebanco));
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusSubRechazo();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		   }
	}
	 
	 
	function getEventobyTecnico($id) {
		$sql = "select eventos.cve_banco,eventos.id, eventos.odt,afiliacion folio,fecha_alta,direccion,colonia,ticket,eventos.estatus,
				GetNameById(servicio,'TipoServicio') servicio,
				GetNameById(estado,'Estado') estadoNombre,
				GetNameById(municipio,'Municipio') municipioNombre,
				GetNameById(tecnico,'Tecnico') tecnicoNombre ,
				GetNameById(comercio,'Comercio') comercioNombre ,
				GetNameById(servicio,'TipoServicio') servicioNombre,
				GetNameById(estatus,'Estatus') estatusNombre ,
				ifnull(visita_tecnicos.id,0) existeFormulario
				from eventos 
				left join visita_tecnicos ON eventos.odt = visita_tecnicos.formulario->>'$.odt'
				where tecnico = $id 
				";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEventobyTecnico();	Functionality: Get Evento x Tecnico;	Log:" . $e->getMessage () );
        }
	}

	function getDetalleEvento($id) {
		$sql = "select eventos.id, odt,afiliacion folio,fecha_alta,descripcion,ticket,direccion,colonia,
				GetNameById(servicio,'TipoServicio') servicio,
				GetNameById(estado,'Estado') estadoNombre,
				GetNameById(municipio,'Municipio') municipioNombre,
				GetNameById(tecnico,'Tecnico') tecnicoNombre ,
				GetNameById(comercio,'Comercio') comercioNombre ,
				GetNameById(servicio,'TipoServicio') servicioNombre,
				GetNameById(estatus,'Estatus') estatusNombre ,
				ifnull(visita_tecnicos.id,0) formularioId,
				visita_tecnicos.formulario
				from eventos 
				LEFT JOIN visita_tecnicos
				ON eventos.odt = visita_tecnicos.formulario->>'$.odt'
				WHERE eventos.id = $id 
			";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
				
            self::$logger->error ("File: eventos_db.php;	Method Name: getDetalleEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getOdtEvento($id) {
		$sql = "select  odt 
				from eventos 
				WHERE id = $id 
			";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
				
            self::$logger->error ("File: eventos_db.php;	Method Name: getOdtEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
 
	function getFormularioEvento($id) {
		$sql = "select ifnull(visita_tecnicos.id,0) id
				from eventos 
				LEFT JOIN visita_tecnicos
				ON eventos.odt = visita_tecnicos.formulario->>'$.odt'
				WHERE eventos.id = $id 
			";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
				
            self::$logger->error ("File: eventos_db.php;	Method Name: getFormularioEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getImagesbyEvento($odt,$tipo) {
		$sql = "select id, dir_img,fecha 
				from img where odt = '$odt'  AND tipo= $tipo
			";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
				
            self::$logger->error ("File: eventos_db.php;	Method Name: getImagesbyEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getCreditos() {
		$sql = "SELECT * from tipo_credito WHERE estatus = 1 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array());
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getCreditos();	Functionality: Get Creditos;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: eventos_db.php;	Method Name: getClientesByAfiliacion();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getEstadoxNombre($estado) {
		$sql = "SELECT id FROM estados WHERE nombre LIKE '%$estado%' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEstadoxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getCiudadxNombre($ciudad,$estado) {
		$sql = "SELECT id FROM municipios WHERE nombre LIKE '%$ciudad%' AND estado = $estado Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getCiudadxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}
	
	function getServicioxNombre($servicio) {
		$sql = "SELECT id FROM tipo_servicio WHERE nombre LIKE '%$servicio%' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getSubServicioxNombre($servicio) {
		$sql = "SELECT id FROM tipo_subservicios WHERE nombre LIKE '%$servicio%' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getSubServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getEstatusxNombre($estatus) {
		$sql = "SELECT id FROM tipo_estatus WHERE nombre LIKE '%$estatus%' and tipo= 4 Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getEstatusServicioxNombre($estatus) {
		$sql = "SELECT id FROM tipo_estatus WHERE nombre LIKE '%$estatus%' and tipo= 12 Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getEstatusServicioxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}
	
	function getConectividadxNombre($connect) {
		$sql = "SELECT id FROM tipo_conectividad WHERE nombre LIKE '%$connect%' Limit 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getConectividadxNombre();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function existeEvento($odt) {
		$sql = "SELECT id,tecnico,afiliacion,estatus_servicio,comercio  FROM eventos WHERE odt = '$odt' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: existeEvento();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function GetTecnicoById($tecnico) {
		$sql = "SELECT CONCAT(IFNULL(nombre,''),' ',IFNULL(apellidos,'') ) nombre  FROM detalle_usuarios WHERE cuenta_id = '$tecnico' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: GetTecnicoById();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
        }
	}

	function getInventarioTecnico($tecnico,$producto) {
		
		$sql = "SELECT id,cantidad  FROM inventario_tecnico WHERE tecnico = ? AND producto = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($tecnico,$producto));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getInventarioTecnico();	Functionality: Get Inventario x tecnico;	Log:" . $e->getMessage () );
        }
	}
	
	function getScriptEvento($servicios,$conectividad) {
		
		$sql = "SELECT script  FROM scripts_eventos WHERE servicio_id = ?  ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($servicios));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getScriptEvento();	Functionality: Get Inventario x tecnico;	Log:" . $e->getMessage () );
        }
	}

	function getCamposObligatorios($servicio) {
		$sql = "SELECT *  FROM campos_obligatorios WHERE servicio_id = ?  ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($servicio));
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getCamposObligatorios();	Functionality: Get Inventario x tecnico;	Log:" . $e->getMessage () );
        }
	}

	function getInvNoserie($noserie) {

		$sql = "Select 
			i.no_serie,
			m.modelo modelo,
			em.nombre estatus,
			c.nombre conectividad,
			u.nombre ubicacion,
			ei.nombre estatus_inventario,
			i.id_ubicacion,
			i.conectividad conectividadId
			from inventario i
			LEFT JOIN modelos m ON m.id = i.modelo
			LEFT JOIN tipo_conectividad c ON c.id = i.conectividad
			LEFT JOIN tipo_estatus_modelos em ON em.id = i.estatus
			LEFT JOIN tipo_estatus_inventario ei ON ei.id = i.estatus_inventario
			LEFT JOIN tipo_ubicacion u ON u.id = i.ubicacion
			WHERE no_serie = '$noserie' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetch( PDO::FETCH_ASSOC );
			return  $result;
			 
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getInvNoserie();	Functionality: Get Evento By Id;	Log:" . $e->getMessage () );
        }
	}

	function getInvUniversoNoserie($noserie) {
		$sql = "select *  from elavon_universo  where serie = '$noserie' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getInvUniversoNoserie();	Functionality: Get Evento By Id;	Log:" . $e->getMessage () );
        }
	}

	function getInventarioNoserie($noserie,$tipo) {
		$sql = "select *  from inventario  where no_serie = '$noserie' and tipo = $tipo";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getInventarioNoserie();	Functionality: Get Evento By Id;	Log:" . $e->getMessage () );
        }
	}

	function getInventarioTecnicoNoserie($noserie) {
		$sql = "select *  from inventario_tecnico  where no_serie = '$noserie' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetch ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getInventarioTecnicoNoserie();	Functionality: Get Evento By Id;	Log:" . $e->getMessage () );
        }
	}

	function getVersion($cve_banco) {
 
		$sql = "SELECT * FROM `tipo_version`   WHERE estatus = 1 AND cve_banco=? Order by nombre ";

		 try {
			 $stmt = self::$connection->prepare ($sql );
			 $stmt->execute (array($cve_banco));
			 return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		 } catch ( PDOException $e ) {
			 self::$logger->error ("File: eventos_db.php;	Method Name: getVersion();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		 }
  }
  
  	function getAplicativo($cve_banco) {
 
		$sql = "SELECT * FROM `tipo_aplicativo`   WHERE estatus = 1 AND cve_banco=?  Order by nombre ";

		 try {
			 $stmt = self::$connection->prepare ($sql );
			 $stmt->execute (array($cve_banco));
			 $result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			 return $result;
		 } catch ( PDOException $e ) {
			 self::$logger->error ("File: eventos_db.php;	Method Name: getAplicativo();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		 }
  	}

  	function getInventarioId($noserie) {
		$sql = "SELECT id FROM inventario WHERE no_serie= '$noserie' ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getInventarioId();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function existHistorialMov($id,$mov) {
		$sql = "SELECT count(*) FROM historial WHERE inventario_id= ? AND tipo_movimiento=? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($id,$mov));
			$result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: existHistorialMov();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getOdtById($odtid)
	{
		$sql = "SELECT odt,cve_banco,bancos.banco FROM eventos,bancos WHERE eventos.id= '$odtid'  AND eventos.cve_banco = bancos.cve ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getOdtById();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}

	}
	function getOdtCveById($odtid)
	{
		$sql = "SELECT cve_banco FROM eventos WHERE id= '$odtid' ";

		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getOdtCveById();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}

	}

	function getModeloConectividad($noserie,$tipo) {
		$sql = "SELECT id datos FROM inventario WHERE no_serie= '$noserie' and tipo = $tipo ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getModeloConectividad();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getListaCarrier() {
		$sql = "SELECT id, nombre FROM carriers WHERE estatus= 1 ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			$result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getListaCarrier();	Functionality: Search Carriers;	Log:". $sql . $e->getMessage () );
		}
	}

	function getInfoExtra($odt) {

		$sql = "SELECT * FROM eventos_tpvretirado WHERE odt=? ";
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($odt));
			$result = $stmt->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getInfoExtra();	Functionality: Search Extras;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTipoSubServicio($serviciosList)
	{
	
		$sql = "SELECT tipo_subservicios.id, tipo_subservicios.nombre from tipo_subservicios WHERE tipo_subservicios.status= 1 AND  tipo_subservicios.servicio_id in ($serviciosList);";
		   //self::$logger->error ($sql);
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array($serviciosList));
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getTipoSubServicio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		   }

	}

	function getTipoSubServ()
	{
		$sql = "SELECT tipo_subservicios.id, tipo_subservicios.nombre from tipo_subservicios WHERE tipo_subservicios.status= 1";

		try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array());
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getTipoSubServ();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		   }
	}

	function getCausasCambio()
	{
		$sql = "SELECT id,nombre from tipo_causas_cambio ";
		    
		   try {
			   $stmt = self::$connection->prepare ($sql );
			   $stmt->execute (array());
			   return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		   } catch ( PDOException $e ) {
			   self::$logger->error ("File: eventos_db.php;	Method Name: getCausasCambio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		   }
	}

	//para el filtro de territorial de eventos
	function getTerritorialL()
	{
		$sql = "SELECT * FROM `territorios`   WHERE status = 1  Order by nombre ";

		 try {
			 $stmt = self::$connection->prepare ($sql );
			 $stmt->execute (array());
			 return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		 } catch ( PDOException $e ) {
			 self::$logger->error ("File: eventos_db.php;	Method Name: getTerritorialL();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		 }
	}

	function getBancos()
	{
		 $where = "";
		
		 if($_SESSION['tipo_user'] == 'CU') 
		 {
			$where .= " AND cve = '".$_SESSION['cve_user']."' ";
		 }
		
		$sql = " SELECT * FROM `bancos` WHERE status=1 ";//$where 

		try{
			$stmt = self::$connection->prepare($sql);
			$stmt->execute(array());
			return $stmt->fetchAll ( PDO::FETCH_ASSOC);
		} catch ( PDOException $e){
			self::$logger->error("File: eventos_db.php;	Method Name: getBancos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getFechaAtencion($odt)
	{
		$sql = "SELECT eventos.fecha_atencion FROM eventos WHERE eventos.odt = '$odt' ";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			$result = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
			return $result;
		} catch ( PDOException $e )
		{
			self::$logger->error ("File: eventos_db.php;	Method Name: getFechaAtencion();	Functionality: Search Extras;	Log:". $sql . $e->getMessage () );
		}
	}

	function getOdtenServicioTecnico($tecnico)
	{
		$sql = "SELECT * FROM eventos WHERE eventos.tecnico = ?  and estatus = 20";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute(array($tecnico));
			$result = $stmt->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch (PDOException $e) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getFechaAtencion();	Functionality: Search Extras;	Log:". $sql . $e->getMessage () );
		}

	}


	function getIncidenciasEventos($params, $total){
		$start = $params['start'];
		$length = $params['length'];
		$filter = "";
		$param = "";
		//$odt = $params['historiaOdt'];
		$query = "";
		$where = '';
		
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if ( $_SESSION['tipo_user'] == 'CA' ) 
		{
			$where .= " AND incidencia_odt.tipo = 'i' ";
		}
		
		if ( $_SESSION['tipo_user'] == 'supOp') {
			
			$where .= " AND incidencia_odt.tipo = 'e' ";
		}
		if( !empty($params['search']['value'])) {
			$where .=" AND ";
			$where .=" (incidencia_odt.odt LIKE '".$params['search']['value']."%' )";
			//$where .=" OR cuentas.correo LIKE '".$params['search']['value']."%' )";
		}
		
		$sql = "SELECT incidencia_odt.id, incidencia_odt.id_odt, incidencia_odt.odt,incidencia_odt.tipo,incidencia_odt.comentario_cc,incidencia_odt.comentario_solucion, incidencia_odt.fecha_alta,incidencia_odt.fecha_solucion, incidencia_odt.vobo, incidencia_odt.estatus 
				FROM `incidencia_odt`  WHERE incidencia_odt.odt IS NOT NULL
				$where 
				ORDER BY incidencia_odt.id ";

				//self::$logger->error($sql);
				
		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getIncidenciasEventos();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}

	function getDetalleIncidencia($params,$total)
	{
		$start = $params['start'];
		$length = $params['length'];
		$filter = "";
		$param = "";
		$query = "";
		$where = '';

		$id_inc = $params['inId'];

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {
			$where .=" AND ";
			$where .=" (diodt.subtipo_incidencia LIKE '".$params['search']['value']."%' )";
			//$where .=" OR cuentas.correo LIKE '".$params['search']['value']."%' )";
		}

		$sql="SELECT diodt.id, diodt.incidencia_id, diodt.subtipo_incidencia, diodt.estatus FROM detalle_incidencia_odt diodt WHERE diodt.incidencia_id = '$id_inc'";

		//self::$logger->error($sql);

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getDetalleIncidencia();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }

	}

	function getSubtipoIncidencia($id)
	{
		$sql = "SELECT incidencia_odt.tipo, GROUP_CONCAT(detalle_incidencia_odt.subtipo_incidencia) stIncidencia
				FROM detalle_incidencia_odt
				LEFT JOIN incidencia_odt ON detalle_incidencia_odt.incidencia_id = incidencia_odt.id
				WHERE detalle_incidencia_odt.incidencia_id = ? 
				GROUP BY incidencia_odt.tipo ";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: eventos_db.php;	Method Name: getSubtipoIncidencia();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}
	

	function existeIncidencia($odt, $tipo)
	{
		$sql = "SELECT odt,tipo FROM incidencia_odt WHERE odt = '$odt' AND tipo = '$tipo'";

		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll( PDO::FETCH_ASSOC );
		} catch ( PDOException $e) {
			self::$logger->error ("File: eventos_db.php;	Method Name: existeIncidencia();	Functionality: Get Historia;	Log:" . $e->getMessage () );
		}
	}


}
//
include 'DBConnection.php';
$Eventos = new Eventos ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getOdtById') {

	$rows = $Eventos->getOdtById($params['id']);

	echo json_encode($rows);
}
if($module == 'getOdtCveById') {

	$rows = $Eventos->getOdtCveById($params['id']);

	echo $rows;
}

if($module == 'getTable') {

    $rows = $Eventos->getTable($params,true);
    $rowsTotal = $Eventos->getTotalTable();
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  $rowsTotal, "recordsFiltered" => $rowsTotal );

	echo json_encode($data); //$val;
}

if($module == 'getTerritoriales')
{
	$val = '<option value="0">Seleccionar</option>';
    $rows = $Eventos->getTerritorialL();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}


if($module == 'getModeloConectividad') {
	$data = '';
	$rows = $Eventos->getModeloConectividad($params['noserie'],$params['tipo']);
	 

	echo json_encode($rows); //$val;
}

if($module == 'assignarTecnico') {
	$fecha_alta = date("Y-m-d H:i:s");

	if( $params['tecnico'] == '0') {
		$prepareStatement = "UPDATE `eventos` SET `tecnico`=?,`estatus`=?  WHERE `odt`=? ; ";
		$arrayString = array (
				0,
				2,
				$params['odtid'] 
		);

	} else {

		$prepareStatement = "UPDATE `eventos` SET `tecnico`=?  WHERE `odt`=? ; ";
		$arrayString = array (
				$params['tecnico'],
				$params['odtid'] 
		);
	}

	$Eventos->insert($prepareStatement,$arrayString);

	echo $params['tecnico'];

}

/*if($module == 'getTipoServicios') {
	$rows = $Eventos->getTipoServicios($params['tipo']);
	$val = '';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}*/

if($module == 'getTipoSubServicio') {

	$arr = $params['servicio_id'];

	$cadena = $arr;

	$cadena = str_replace("[", "", $cadena);
	$cadena = str_replace("]", "", $cadena);
	
	$in = implode(",", array_fill(0, count($arr), $cadena));

	$rows = $Eventos->getTipoSubServicio($in);
	print_r($rows);
	$val = '';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if ($module == 'getFechaAtencion')
{
	$odt = $params['odt'];

	$rows = $Eventos->getFechaAtencion($odt);

	echo $rows;
}


if($module == 'cambiarODT') {
	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	  
	 //Obtener ID de la odt original 
		$datosOldODT = $Eventos->existeEvento($params['oldODT']);
		$oldODTId = $datosOldODT[0]['id'];
	 
		
		$prepareStatement = "UPDATE `eventos` SET `odt`=?,`modificado_por`=?   WHERE `odt`=? ; ";
		$arrayString = array (
			$params['newODT'],
			$_SESSION['userid'],
			$params['oldODT']  
		);

		$Eventos->insert($prepareStatement,$arrayString);

		$prepareStatement = "UPDATE `img` SET `odt`=?  WHERE `odt`=? ; ";
		$arrayString = array (
				$params['newODT'],
				$params['oldODT'] 
		);

		//Renombrar Folder

		$oldFolder = $_SERVER["DOCUMENT_ROOT"].'/img/'.$params['oldODT'];

		$newFolder = $_SERVER["DOCUMENT_ROOT"].'/img/'.$params['newODT'];

		if (!file_exists($newFolder)) 
		{
			mkdir($newFolder, 0777, true);
		} else
		{
			chmod($newFolder, 0777);
		}

		if (rename($oldFolder, $newFolder)) 
		{
			echo 'Se subió el archivo';
		}
		else
		{
			echo 'No se subió el archivo';
		}


		$Eventos->insert($prepareStatement,$arrayString);


		$prepareStatement = "INSERT INTO `cambio_odt`
						( `old_odt`,`new_odt`,`ultima_act`,`modificado_por`)
						VALUES
						(?,?,?,?);
					";
		$arrayString = array (
				$params['oldODT'] ,
				$params['newODT'],
				$fecha_alta,
				$_SESSION['userid']
		);
	
		$id = 	$Eventos->insert($prepareStatement,$arrayString);
		
		


		//Historico ODT Antigua
		$prepareStatementHist = " INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`) 
								  VALUES 
								  (?,?,?,?,?);
								  ";
		
		$arrayStringHist = array (
			$oldODTId,
			$fecha_alta,
			17,
			$params['oldODT'],
			$user		
		);
		
		$Eventos->insert($prepareStatementHist,$arrayStringHist);
		
		//Historico ODT Nueva
		$prepareStatementHist = " INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`) 
								  VALUES 
								  (?,?,?,?,?);
								  ";
		
		$arrayStringHist = array (
			$oldODTId,
			$fecha_alta,
			17,
			$params['newODT'],
			$user		
		);
		
		$Eventos->insert($prepareStatementHist,$arrayStringHist);

		echo $id;
		
		
}

if($module == 'cambiarFechasOdt')
{
	$fecha = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
 
	$sql = "UPDATE eventos SET fecha_alta=?, fecha_vencimiento=? where odt=? ;";

	$arrayString = array (
		$params['fechaAlta'],
		$params['fechaVen'],
		$params['odt']
	);

	$id = $Eventos->insert($sql, $arrayString);
	
	echo $id;


}

if($module == 'updSerie') {

	$tpv = $params['tpv'];
	$tipo = $params['tipo'];
	$dato = $params['dato'];

	$prepareStatementinvIn = "UPDATE `inventario` SET `$tipo`=?  WHERE `no_serie`=?; ";
		$arrayStringinvIn = array (
			$dato,
			$tpv
		);

	$Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);

	echo  "Se actualizo $tipo ";
}

if($module == 'getInfoExtra') {
	$rows = $Eventos->getInfoExtra($params['odt']);

	echo json_encode($rows);
}
if($module == 'getBancos') {
    $val = '<option value="0">Seleccionar Banco</option>';
    $rows = $Eventos->getBancos();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['cve'] . '">' . $row ['banco'] . '</option>';
	}
	echo $val;
}

if($module == 'getEstados') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Eventos->getEstados();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}
if($module == 'getEstadosNombre') {
    $val = '<option value="0" selected>Seleccionar</option>';
    $rows = $Eventos->getEstados();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['nombre'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}
if($module == 'getEquipos') {
    $val = '<option value="0">Otro</option>';
    $rows = $Eventos->getEquipos($params['comercio_id']);
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['no_serie'] . '">' . $row ['no_serie'] . '</option>';
	}
	echo $val;

}

if($module == 'getModelos') {
    $val = '<option value="0">Seleccionar Modelos</option>';
    $rows = $Eventos->getModelos($params['modeloId'],$params['cve_banco']);
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['modelo'] . '</option>';
	}
	echo $val;

}

if($module == 'getHistorialodt'){
	$rows = $Eventos->getHistorialODT($params,true);
	$rowsTotal = $Eventos->getHistorialODT($params,false);
	$data = array(
			"draw"=>$_POST['draw'],
			"data" =>$rows, 
			'recordsTotal' => count($rowsTotal),
			"recordsFiltered" => count($rowsTotal) 
		);
	
	echo json_encode($data);
	
}

if($module == 'getHistorialEvento'){
	$rows = $Eventos->getHistorialEventos($params,true);
	$rowsTotal = $Eventos->getHistorialEventos($params,false);
	$data = array("draw"=>$_POST['draw'],"data" =>$rows, 'recordsTotal' => count($rowsTotal), "recordsFiltered" => count($rowsTotal) );
	
	echo json_encode($data);
	
}

if ($module == 'getIncidenciasEventos') {
	$rows = $Eventos->getIncidenciasEventos($params,true);
	$rowsTotal = $Eventos->getIncidenciasEventos($params,false);
	$data = array("draw"=>$_POST['draw'],"data" =>$rows, 'recordsTotal' => count($rowsTotal), "recordsFiltered" => count($rowsTotal) );
	
	echo json_encode($data);
}

if ($module == 'getDetalleIncidencia') {
	$rows = $Eventos->getDetalleIncidencia($params, true);
	$rowsTotal = $Eventos->getDetalleIncidencia($params,false);
	$data = array("draw"=>$_POST['draw'],"data"=>$rows,'recordsTotal' => count($rowsTotal), "recordsFiltered" => count($rowsTotal));

	echo json_encode($data);
}

if($module == 'getListaModelos') {
    $val = '<option value="0" selected>Seleccionar Modelos</option>';
    $rows = $Eventos->getListaModelos($params['cve_banco']);

    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['modelo'] . '</option>';
	}
	echo $val;

}

if($module == 'getListaConectividad') {
    $val = '<option value="0" selected>Seleccionar Conectividad</option>';
    $rows = $Eventos->getListaConectividad($params['cve_banco']);
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getListaCarrier') {
	
	$val = '<option value="0" selected>Seleccionar Carrier</option>';
    $rows = $Eventos->getListaCarrier();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getevento') {
    
    $rows = $Eventos->getEvento($params['eventoid']);
     
	echo json_encode($rows);

}

if($module == "getImagenesODT") {
	$estatus = 1;
	$userType = $_SESSION['tipo_user'];
	$odt = $params['odt'];
	$lstImagenes = array();
	$rows = $Eventos->getImagenesODT($params['odt']);
	if( file_exists($_SERVER["DOCUMENT_ROOT"].'/img/'.$odt) ) {
		//CORRECT
	} else if ( file_exists($_SERVER["DOCUMENT_ROOT"].'/img/'.strtoupper($odt)) ) {
		$odt = strtoupper($odt);
	}

	if(sizeof($rows) > 0 &&  file_exists($_SERVER["DOCUMENT_ROOT"].'/img/'.$odt)){
		$odtHistory = $Eventos->getHistoriaODT($odt,$_SESSION['user']);

		//if(sizeof($odtHistory) == 0 ) {
			//insertar a tabla historial_img
		//} else {
			$counter = 0;
			foreach($rows as $row ) {
				
				if( $userType == 'admin' || $userType == 'supervisor' || $userType == 'user' || $userType == 'callcenter' ) {
					//Update tabla img donde sea el mismo ODT 
				}

				$lstImagenes[$counter]['id'] = $row['id'];
				$lstImagenes[$counter]['path'] = 'img/'.$odt.'/'.$row['dir_img'];
				$lstImagenes[$counter]['imagen'] = $row['dir_img'];
				$lstImagenes[$counter]['odt'] = $row['odt'];
				$lstImagenes[$counter]['revisado'] = $row['revisado'];
				$lstImagenes[$counter]['supervisor'] = $row['supervisor'];
				$lstImagenes[$counter]['tecnico'] = $row['tecnico'];
				$lstImagenes[$counter]['userType'] = $userType;
				$lstImagenes[$counter]['fecha'] = $row['fecha'];
				$counter++;
			}

		//}
	} else {
		$estatus = 0;
	}

	echo json_encode(['estatus' => $estatus, 'imagenes' => $lstImagenes ]);
}

if($module == 'imgDelete') {
	$prepareStatement = "DELETE FROM  `img` WHERE id =?; ";

	$arrayString = array (
       $params['idImg']	
	);
		
	$Eventos->insert ( $prepareStatement, $arrayString );

	echo 1;

}

if($module == "getDocumentosODT") {
	$estatus = 1;
	$userType = $_SESSION['tipo_user'];
	$odt = $params['odt'];
	$lstDocs = array();
	$rows = $Eventos->getDocsODT($params['odt']);

	if(file_exists($_SERVER["DOCUMENT_ROOT"].'/docs/'.$params['odt'])){
		$odtHistory = $Eventos->getHistoriaODT($params['odt'],$_SESSION['user']);

		//if(sizeof($odtHistory) == 0 ) {
			//insertar a tabla historial_img
		//} else {
			$counter = 0;
			foreach($rows as $row ) {
				
				if( $userType == 'admin' || $userType == 'supervisor' || $userType == 'user' || $userType == 'callcenter' || $userType == 'VO' ) {
					//Update tabla img donde sea el mismo ODT 
				}

				$lstDocs[$counter]['path'] = 'docs/'.$odt.'/'.$row['dir_img'];
				$lstDocs[$counter]['imagen'] = $row['dir_img'];
				$lstDocs[$counter]['odt'] = $row['odt'];
				$lstDocs[$counter]['revisado'] = $row['revisado'];
				$lstDocs[$counter]['supervisor'] = $row['supervisor'];
				$lstDocs[$counter]['tecnico'] = $row['tecnico'];
				$lstDocs[$counter]['userType'] = $userType;
				$counter++;
			}

		//}
	} else {
		$estatus = 0;
	}

	echo json_encode(['estatus' => $estatus, 'imagenes' => $lstDocs ]);
	
}

if($module == 'getConsultaODT') {
    
	$rows = $Eventos->getConsultaODT($params['odt']);
	
     
	echo json_encode($rows);

}

if($module == 'getTipoServicios') {
	$rows = $Eventos->getTipoServicios($params['tipo'], $params['cve']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTipoSubServicios') {
	$rows = $Eventos->getTipoSubServicios($params['servicio_id']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if ($module == 'getSubServ') {
	$rows = $Eventos->getTipoSubServ();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row){
		$val .= '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTipoServiciosBanco') {
	$rows = $Eventos->getTipoServiciosBanco($params['cve']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}


if($module == 'getCveBanco') {
  $rows = $Eventos->getCveBanco($params['cvebanco']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['banco'] . '</option>';
	} 
	echo $val;
}

if($module == 'getTipoFallas') {
	$rows = $Eventos->getTipoFallas();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTipoConectividad') {
	$rows = $Eventos->getTipoConectividad();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == "buscarComercio") {
	$rows = $Eventos->buscarComercio($params['term']);

	echo json_encode($rows);
}

if($module == 'getMunicipios') {
	
	$rows = $Eventos->getMunicipios($params['estado']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['Id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTecnicos') {
	
	$rows = $Eventos->getTecnicos();
	$val = '<option value="0">Quitar Asignacion</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnicoId'] . '">' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}
if($module == 'getTecnicosFiltro') {
	
	$rows = $Eventos->getTecnicosFilter();
	$val = '<option value="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnicoId'] . '">' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}

if($module == 'getUbicacion') {
	
	$rows = $Eventos->getUbicacion();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}


if($module == 'getRechazos') {
	
	$rows = $Eventos->getRechazos('r');
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getSubRechazos') {
	
	$rows = $Eventos->getRechazos('s');
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getCancelacion') {
	$rows = $Eventos->getCancelacion('c');
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'gettipoevento') {
  $rows = $Eventos->getTipoEvento();
	$val = '<option value="0">Todos</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getestatusevento') {
	$rows = $Eventos->getEstatusEvento();
	  $val = '<option value="0">Todos</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getEstatusServicio') {
	$rows = $Eventos->getEstatusServicio($params['cve_banco']);
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getEstatusCancelado') {
	$rows = $Eventos->getEstatusCancelado();
	  $val = '<option value="0">Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getEstatusRechazo') {
	$rows = $Eventos->getEstatusRechazo($params['cve_banco']);
	  $val = '<option value="0">Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getEstatusSubRechazo') {
	$rows = $Eventos->getEstatusSubRechazo($params['cve_banco']);
	  $val = '<option value="0">Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '" data-prog="'.$row['programado'].'" >' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getProductos') {
	$rows = $Eventos->getProductos($params['cve_banco']);
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getCreditos') {
	$rows = $Eventos->getCreditos();
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getVersion') {
	$rows = $Eventos->getVersion($params['cve_banco']);
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getAplicativo') {
	$rows = $Eventos->getAplicativo($params['cve_banco']);
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}


if($module == 'getCausasCambio') {
	$rows = $Eventos->getCausasCambio();
	  $val = '<option value="0" selected>Seleccionar</option>';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

if($module == 'getNumSerieTecnico') {
	$rows = $Eventos->getNumSerieTecnico($params['tecnico_id']);
	$val = '<option value="0" selected>Seleccionar</option>';
	
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['no_serie'] . '" data-id="'.$row['modelo_tpv'].'-'.$row['ptid'].'-'.$row['conect'].'">' . $row ['no_serie'] . '</option>';
	}
	
	
	echo $val;
}

if($module == 'getNumSerieSimTecnico') {
	$rows = $Eventos->getNumSerieSimTecnico($params['tecnico_id']);
	$val = '<option value="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['no_serie'] . '">' . $row ['no_serie'] . '</option>';
	}
	echo $val;
}


if($module == 'cambiarEstatusEvento') {

	$fecha = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];

	$prepareStatementinvIn = "UPDATE `eventos` SET `estatus`=?,`estatus_servicio`=?  WHERE `id`=?
							;
						";
		$arrayStringinvIn = array (
			1,
			16,
			$params['odtid'] 

		);

	$Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);

	$EventoData = $Eventos->getOdtEvento($params['odtid']);

	$prepareStatementHist = " INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`) 
								  VALUES 
								  (?,?,?,?,?);
								  ";
		
	$arrayStringHist = array (
		$params['odtid'],
		$fecha,
		18,
		$EventoData['odt'],
		$user		
	);
	
	$Eventos->insert($prepareStatementHist,$arrayStringHist);
}

if($module == 'validarTPV') {
	$noserie = $params['noserie'];
	$tipo = $params['tipo'];
	$tserie = $tipo == '1' ? 'TPV' : 'SIM';
	$fecha = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$afiliacion = $params['comercio'];
	$donde = $params['donde'];
	$permiso = $params['permiso'];
	$cveBanco = $params['cve_banco'];
	$comercioId = $Eventos->getComercioBy($afiliacion,$cveBanco);
	$inventarioElavon = $Eventos->getInvUniversoNoserie($noserie);

	if($inventarioElavon) {

		$inventarioGeneral = $Eventos->getInventarioNoserie($noserie,$tipo,$donde);

		if($inventarioGeneral) {

			if ($inventarioGeneral['tipo'] != $tipo ) { 
				$msg = $tipo == '1' ? ' La serie es de tipo SIM' : ' La serie es una TPV ';

				$inventarioGeneral = [ "modelo" => null, "conectividad" => null, 'status' => false ,'msg' => $msg ];
			
			 /*} else if( $inventarioGeneral['estatus'] != '13' && $donde == 'out')
			{
				$inventarioGeneral = [ "modelo" => null, "conectividad" => null, 'status' => false ,'msg' => 'La serie no tiene estatus  INSTALADA' ];

			} else if( $inventarioGeneral['estatus'] == '13' && $donde == 'in')
			{
				$inventarioGeneral = [ "modelo" => null, "conectividad" => null, 'status' => false ,'msg' => 'La serie  tiene estatus  INSTALADA' ]; */

			}  else  {

				if( $inventarioGeneral['id_ubicacion'] == '2' && $inventarioGeneral['id_ubicacion'] != $comercioId[0]['id']  && $tipo == '1' )
				{
					$inventarioGeneral = [ "modelo" => $inventarioGeneral['modelo'], "conectividad" =>  $inventarioGeneral['conectividad'], 'status' => false ,'msg' => 'Serie No Valida ya esta asignada en un comercio' ];
				} else 
				{
					$inventarioGeneral = [ "modelo" => $inventarioGeneral['modelo'], "conectividad" =>  $inventarioGeneral['conectividad'], 'status' => true ,'msg' => 'Serie Valida' ];
				}
			}
			
		} else {
			$inventarioGeneral = [ "modelo" => null, "conectividad" => null, 'status' => true ,'msg' => 'Serie Valida' ];
		}

		

	} else {

		$inventarioGeneral = [ "modelo" => null, "conectividad" => null, 'status' => false ,'msg' => 'Serie No Valida' ];
	}
	

	echo json_encode($inventarioGeneral);

}

if($module == 'nuevoEvento') {
	$consecutivo = 1;
	$existenEventos = $Eventos->getLastEventDate();
	$user = $_SESSION['userid'];
	$odtNew = $params['odt'];
	$fecha_alta = date("Y-m-d H:i:s");
	if( strlen($odtNew) ==  0 ) {
		if ($existenEventos) {
			//Generar Fechas de hoy y de la ultimo evento registrado
			$odt = explode("-",$existenEventos['odt']);
			$now = new DateTime(date('Y-m-d '));
			$ultima_FA = new DateTime( $existenEventos['fecha_creacion'] );
			//Validar si la fehca de hoy es mayor al ultimo evento
			if($now > $ultima_FA ) {
			} else {
				//if($hoy == $ultima_FA) {
					if(empty($odt[1])) {
						 
					} else {
						$oldConsecutivo = is_numeric($odt[1]) ? $odt[1] : $consecutivo;
						$consecutivo = $oldConsecutivo;
						$consecutivo++;
					}
				//}
				
			}  

		}

		
		$newODT =  date("dmy").'-'.$consecutivo;

	} else {
		$newODT = $odtNew;
	}

	
	//$ticket = date("YmdHis").'-'.$consecutivo;
	$datosComercios = $Eventos->getComercioBy($params['afiliacion'],$params['cve_banco'] );
  $error = 1;
  $hora_atencion = explode("|",$params['hora_atencion']);
  $hora_comida = explode("|",$params['hora_comida']);
  
	foreach($datosComercios as $datosComercio) {
   
		$fecha_cierre = $Eventos-> createFechaCierre($datosComercio['tipo_comercio'] );
   
	
		$prepareStatement = "INSERT INTO `eventos`
						( `afiliacion`,`odt`,`consecutivo`,`fecha_alta`,`fecha_vencimiento`,`telefono`,`hora_atencion`,`hora_atencion_fin`,
						`descripcion`,`terminal`,`tpv_instalado`,`folio_telecarga`,`tipo_servicio`,`servicio`,`ip_caja`,`territorio`,`estado`,`municipio`,`cve_banco`,
						`comercio`,`estatus`,`estatus_servicio`,`hora_comida`,`hora_comida_fin`,`tipo_falla`,`ticket`,`direccion`,`colonia`,`modificado_por`,
						`rollos_instalar`,`codigopostal`)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					";
			$arrayString = array (
					$datosComercio['afiliacion'],
					$newODT,
					$consecutivo,
					$fecha_alta,
					$fecha_cierre,
					$datosComercio['telefono'],
					$hora_atencion[0],
          			$hora_atencion[1],
					$params['comentarios'],
					$params['equipo_instalado'],
					$params['equipo_instalado'],
					0,
					$params['tipo_servicio'] ,
					$params['tipo_subservicio'],
					0,
					0,
					$datosComercio['estado'],
					$datosComercio['ciudad'],
					$datosComercio['cve_banco'],
					$datosComercio['id'],
					1,
					16,
					$hora_comida[0],
					$hora_comida[1],
					$params['tipo_falla'],
					$params['ticket'],
					$datosComercio['direccion'],
					$datosComercio['colonia'],
					$user,
					$params['cantidad'],
					$datosComercio['cp']

			);
	}
		$id = $Eventos->insert($prepareStatement,$arrayString);
  
		$prepareStatementHist = " INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`) 
								  VALUES 
								  (?,?,?,?,?);
								  ";
		
		$arrayStringHist = array (
			$id,
			$fecha_alta,
			16,
			$newODT,
			$user		
		);
		
		$Eventos->insert($prepareStatementHist,$arrayStringHist);
		
      if(is_null($id)) {
        $error = 0;
      }
			echo json_encode(['id'=> $id, 'nuevaODT' => $newODT, 'fecha_cierre' => $fecha_cierre, 'error' => $error]);
} 


if($module == 'nuevoEventoVO') {
	$consecutivo = 1;
	$existenEventos = $Eventos->getLastEventDate();

	if ($existenEventos) {
		//Generar Fechas de hoy y de la ultimo evento registrado
		$odt = explode("-",$existenEventos['odt']);
		$now = new DateTime(date('Y-m-d '));
		$ultima_FA = new DateTime( $existenEventos['fecha_alta'] );
		//Validar si la fehca de hoy es mayor al ultimo evento
		if($now > $ultima_FA ) {
		} else {
			//if($hoy == $ultima_FA) {
				$consecutivo = (int)$odt[1];
				$consecutivo++;
			//}
			
		}  

	}

	$fecha_alta = date("Y-m-d H:i:s");
	$newODT = date("dmy").'-'.$consecutivo;
	$ticket = date("YmdHis").'-'.$consecutivo;
	//$datosComercios = $Eventos->getComercioBy($params['afiliacion'],$params['cve_banco'] );
  $error = 1;
  $hora_atencion = explode("|",$params['hora_atencion']);
  $hora_comida = explode("|",$params['hora_comida']);
  
	//foreach($datosComercios as $datosComercio) {
   
		$fecha_cierre = $Eventos-> createFechaCierre(3);
   
	
		$prepareStatement = "INSERT INTO `eventos`
						( `afiliacion`,`odt`,`consecutivo`,`fecha_alta`,`fecha_cierre`,`tipo_servicio`,`telefono`,`hora_atencion`,`hora_atencion_fin`,
						`descripcion`,`terminal`,`folio_telecarga`,`servicio`,`ip_caja`,`territorio`,`estado`,`municipio`,`cve_banco`,
						`comercio`,`estatus`,`hora_comida`,`hora_comida_fin`,`tipo_falla`,`ticket`,`direccion`,`colonia`,`cliente_vo`,`tipocredito_vo`,`email_vo`)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					";
			$arrayString = array (
					$params['afiliacion'],
					$newODT,
					$consecutivo,
					$fecha_alta,
					$fecha_cierre,
					$params['tipo_servicio'] ,
					$params['telefono'],
					$hora_atencion[0],
          $hora_atencion[1],
		  			trim($params['comentarios']),
					0,
					0,
					0 ,
					0,
					0,
					$params['estado'],
					$params['municipio'],
					$params['cve_banco'],
					0, //$datosComercio['id'],
					1,
					$hora_comida[0],
          			$hora_comida[1],
					0,
					$params['ticket'],
					$params['direccion'],
					$params['colonia'],
					$params['comercio'],
					$params['tipo_credito'],
					''

			);
	//}
			$id = $Eventos->insert($prepareStatement,$arrayString);
			$prepareStatementHist = " INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`) 
								  VALUES 
								  (?,?,?,?,?);
								  ";

			$arrayStringHist = array (
				$id,
				$fecha_alta,
				16,
				$newODT,
				$user		
			);

			$Eventos->insert($prepareStatementHist,$arrayStringHist);
    if(is_null($id)) {
    	$error = 0;
	}

	if($error !=0 ) {
		$email = new envioEmail();

		$body = "Se a generado una nuevo evento  (Visita Ocular)<br/> "; 
		$body .= "Folio: ".$params['afiliacion']."<br/>";
		$body .= "ODT: ".$newODT."<br/>";
		$body .= "Ticket: ".$params['ticket']."<br/>"; 
		$body .= "Cliente: ".$params['comercio']."<br />";
		$body .= ": ".$params['comercio']."<br />";
		$body .= "Visitar  <a href='https://sinttecom.net' target='_blank'>Sinttecom SAS</a>";
		$header = "Nuevo Evento (VO)  Sinttecom SAS";

		$envio = $email->send($header,$body,"visitasoculares@sinttecom.com");

		
	}
	  

	echo json_encode(['id'=> $id, 'nuevaODT' => $newODT, 'folio' => $params['afiliacion'], 'error' => $error, 'correo' => $envio]);
} 

if($module == 'grabarCierre') {
	$fecha_c = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
	$odt = $params['odt']; 

		if($params['serviciorealizado'] == '5' || $params['serviciorealizado'] == '7' || $params['serviciorealizado'] == '9' ) {
			
			
		}	
	 

	$prepareStatement = "UPDATE `eventos` SET `estatus`=?,`fuera_tiempo`=?,`fecha_atencion`=?,`hora_salida`=?,`hora_llegada`=?,`receptor_servicio`=?,
						`estatus_servicio`=?,`comentarios_cierre`=?,`tpv_retirado`=?,`tpv_instalado`=?,`sim_retirado`=?,`sim_instalado`=?,`tvp_retirado_manual`=?,`sim_retirado_manual`=?,`ptid`=?,
						`rollos_entregados`=?,`producto`=?,`aplicativo`=?,`version`=?,`afiliacionamex`=?,`id_caja`=?,`amex`=?  WHERE `id`=? 
						 ;
					";
	$arrayString = array (
      3,
			$params['fueratiempo'],
			$params['fechaatencion'],
			$params['horasalida'],
			$params['horallegada'],
			$params['personarecibe'],
			$params['estatus'],
			$params['comentariocierre'],
			$params['tpv_retirado'],
			$params['tpv_instalado'],
			$params['sim_retirado'],
			$params['sim_instalado'],
			$params['tvp_retirado_manual'],
			$params['sim_retirado_manual'],
			$params['ptid'],
			$params['rollosentregados'],
			$params['producto'],
			$params['aplicativo'],
			$params['version'],
			$params['afiliacionamex'],
			$params['idcaja'],
			$params['idamex'],
			$params['odtid'] 

	);

	$id_upd = $Eventos->insert($prepareStatement,$arrayString);

	//HISTORIAL

	$prepareStatementHistE = "INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`)
							  VALUES
							  (?,?,?,?,?);  
							  ";

	$arrayStringHE = array(
		$id_upd,
		$fecha_c,
		3,
		$odt,
		$user

	);	
	
	$Eventos->insert($prepareStatementHistE, $arrayStringHE);

	//


	if($params['serviciorealizado'] == '1' || $params['serviciorealizado'] == '2' ) {
		//UPDATE ALMACEN TPV Comercio
		$prepareStatementinvIn = "UPDATE `almacen` SET `conect`=?,`ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?
							;
						";
		$arrayStringinvIn = array (
			$params['connect'],
			3,
			3,
			$params['comercioid'],
			$params['tpv_instalado'] 

		);
		$InventarioIn = $Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);
		//UPDATE ALMACEN SIM Comercio
		$prepareStatementinvIn = "UPDATE `almacen` SET `ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?; ";
		$arrayStringinvIn = array (
			3,
			3,
			$params['comercioid'],
			$params['sim_instalado'] 

		);
		$InventarioIn=$Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);
	}

	if($params['serviciorealizado'] == '2' ) {
		//UPDATE ALMACEN TPV Tecnico
		$prepareStatementinvOut = "UPDATE `almacen` SET `conect`=?,`ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?; ";

		$arrayStringinvOut = array (
		$params['connect'],
		2,
		2,
		$params['tecnicoid'],
		$params['tpv_retirado'] 
		);

		$InventarioOut=$Eventos->insert($prepareStatementinvOut,$arrayStringinvOut);
		//UPDATE ALMACEN SIM Tecnico
		$prepareStatementinvOut = "UPDATE `almacen` SET `ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?; ";

		$arrayStringinvOut = array (
		2,
		2,
		$params['tecnicoid'],
		$params['sim_retirado'] 
		);

		$InventarioOut= $Eventos->insert($prepareStatementinvOut,$arrayStringinvOut);
	} 

	if($params['serviciorealizado'] == '5' && $params['estatus'] == '1' ) {
		//Grabar Historico
		$fecha_alta = date("Y-m-d H:i:s");
		$inventarioTecnico = $Eventos->getInventarioTecnico($params['tecnicoid'],'3');
		$total = (int)$inventarioTecnico['cantidad'] - (int)$params['servicio-rollosentregados'];

		$prepareStatementinvOut = "INSERT INTO  `historial` (`fecha_movimiento`,`tipo_movimiento`,`producto`,`cantidad`,`ubicacion`,`id_ubicacion`,`modified_by`) VALUES (?,?,?,?,?,?,?) ";

		$arrayStringinvOut = array (
		$fecha_alta,
		'COMERCIO',
		'3',
		$params['servicio-rollosentregados'],
		2,
		$params['comercioid'],
		$_SESSION['userid']
		);


		$InventarioOut=$Eventos->insert($prepareStatementinvOut,$arrayStringinvOut);
		//UPDATE ALMACEN SIM Tecnico
		$prepareStatementinvOut = "UPDATE `inventario_tecnico` SET `cantidad`=?,`tecnico`=?,`producto`=?  WHERE `no_serie`=?; ";

		$arrayStringinvOut = array (
		$total,
		$params['tecnicoid'],
		1,
		$inventarioTecnico['id']
		);

		$Eventos->insert($prepareStatementinvOut,$arrayStringinvOut);
	} 

	if( $params['estatus'] == '2' || $params['estatus'] == '3' ) {
		$estatusOdt = '3';

		$prepareStatement = "UPDATE `eventos` SET `estatus`=?, `motivo_cancelacion`=?,`clave_autorizacion`=?,
							`autorizo`=?  WHERE `id`=? 
						 	;";
					
		$arrayString = array (
			$estatusOdt,
			$params['motivocancelacion'],
			$params['cveautorizacion'],
			$params['autorizo'],
			$params['odtid']
			

		);
		$Eventos->insert($prepareStatement,$arrayString);
	} 

	if($params['serviciorealizado'] == '19' || $params['serviciorealizado'] == '21' ) {
		//UPDATE ALMACEN TPV Comercio
		$prepareStatementinvIn = "UPDATE `almacen` SET `ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?
							;
						";
		$arrayStringinvIn = array (
			2,
			2,
			$params['tecnicoid'],
			$params['tpv_instalado'] 

		);
		$InventarioIn = $Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);
		//UPDATE ALMACEN SIM Comercio
		$prepareStatementinvIn = "UPDATE `almacen` SET `ubicacion`=?,`tipo_ubicacion`=?,`id_ubicacion`=?  WHERE `no_serie`=?; ";
		$arrayStringinvIn = array (
			3,
			3,
			$params['tecnicoid'],
			$params['sim_instalado'] 

		);
		$InventarioIn=$Eventos->insert($prepareStatementinvIn,$arrayStringinvIn);
	}
	
	switch ($params['estatus']) {
		case '2':
		$EstatusNombre = 'Cancelado';
		break;
		case '3':
		$EstatusNombre = 'Rechazo';
		break;
		default:
		$EstatusNombre = 'Exito';

	}
		echo json_encode(['odt'=> $params['odt'], 'existe' => 1, 'estatusnombre' => $EstatusNombre,'params' => $params ]);
}

if($module == 'grabarAsignacion') {

	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE `eventos` SET `fecha_asignacion`=?,`tecnico`=?,`fecha_asig_viatico`=?,`importe_viatico`=?,
						`comentarios_asig`=?,`estatus`=? WHERE `id`=? 
						 ;
					";
	$arrayString = array (
			$params['fechaasignacion'],
			$params['tecnico'],
			$fecha_alta,
			$params['importeviatico'],
			$params['comentariosasig'],
      2,
			$params['odtid']
			
	);

	$Eventos->insert($prepareStatement,$arrayString);

	echo $params['odt'];
}

if($module == 'grabarValidaciones') {
	$prepareStatement = "UPDATE `eventos` SET `estatus_validacion`=?,`fecha_llamada`=?,`hora_llamada`=?,`comentarios_validacion`=?  WHERE `id`=? 
						 ;
					";
	$arrayString = array (
			$params['estatusvalidacion'],
			$params['fechallamada'],
			$params['horallamada'],
			$params['comentariosvalidacion'],
			$params['odtid'] 

	);

	$Eventos->insert($prepareStatement,$arrayString);

	echo $params['odt'];
}

if($module == 'guardarComVal')
{
	$comentario = $params['comentario'];
	$odt = $params['odt'];
	$codigoServicio = $params['codigo_rechazo'];
	$codigoServicio2 = $params['codigo_rechazo_2']; 
	$aplicaExito = $params['aplica_exito'];
	$aplicaRechazo = $params['aplica_rechazo'];
	$faltaSerie = $params['faltaserie'];
	$faltaUbicacion = $params['faltaubicacion'];
	$faltaInformacion = $params['faltainformacion'];
	$faltaEvidencia = $params['faltaevidencia'];
	$tecnico = $params['tecnico'];

	$user = $_SESSION['userid'];
	$fecha = date ( 'Y-m-d H:i:s' );
	$aviso = '';
	$comentario = $fecha." ".$comentario;
	$prepareStatement = "UPDATE `eventos` SET `comentarios_validacion`=?, `codigo_servicio`=?, `codigo_servicio_2`=? WHERE `odt`=?;";
	
	$arrayString = array ( $comentario, $codigoServicio ,$codigoServicio2 , $odt );
	
	$Eventos->insert($prepareStatement,$arrayString);

	$sqlChecklist = " INSERT INTO checklist_evento ( odt , tecnico, serie, evidencia, informacion, ubicacion, aplica_exito, aplica_rechazo_2, creado_por, fecha_creacion )
					  VALUES ('$odt','$tecnico','$faltaSerie','$faltaEvidencia','$faltaInformacion','$faltaUbicacion','$aplicaExito','$aplicaRechazo','$user','$fecha') 
					  ON DUPLICATE KEY UPDATE
						odt = '$odt',
						tecnico = $tecnico,
						serie = $faltaSerie,
						evidencia = $faltaEvidencia,
						informacion = $faltaInformacion,
						ubicacion = $faltaUbicacion,
						aplica_exito=$aplicaExito,
						aplica_rechazo_2=$aplicaRechazo,
						creado_por =$user,
						fecha_creacion ='$fecha'  ";

	$Eventos->insert($sqlChecklist, array());
	
	
	$aviso = "Se actualizó el comentario de validación";
	
	echo $aviso;
}

if($module == 'validateOdt') {
	$existenEvento = $Eventos->validateOdt($params);
	echo json_encode($existenEvento);
	//echo json_encode(['existe' => $existenEvento ]);
}


if($module == 'saveDoc') {
	if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
		$name = $_POST['name'];
		$fecha = date ( 'Y-m-d H:i:s' );
		$tecnico = $_SESSION['user'];
        $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION );
		$fileName = $_FILES['file']['name'];
		$folder = $_SERVER["DOCUMENT_ROOT"].'/docs/'.$name;
		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}

		if( move_uploaded_file($_FILES['file']['tmp_name'], $folder.'/'.$fileName) ) {
			echo 'EL Archivo '.$fileName.' se cargo correctamente.';
			$prepareStatement = "INSERT INTO `img`  ( `odt`,`fecha`,`dir_img`,`revisado`,`tecnico`,`tipo`)
			VALUES
			(?,?,?,?,?,?);";
				$arrayString = array (
					$name,
					$fecha,
					$fileName,
					0,
					$tecnico,
					2
				);
			$Eventos->insert ( $prepareStatement, $arrayString );

		} else {
			echo 'No se subio el Archivo';
		}
		
		
       // echo 'EL Archivo se cargo correctamente.  <br>';
    }
}

if($module == 'saveImageMobile') {

		$name = $_POST['name'];
		$fecha = date ( 'Y-m-d H:i:s' );
		$tecnico = $_SESSION['user'];
        $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION );
		$fileName = $_FILES['file']['name'];
		
		$folder = $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER["PHP_SELF"]).'/img/'.$name;
		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}

		if( move_uploaded_file($_FILES['file']['tmp_name'], $folder.'/'.$fileName) ) {
			echo 'EL Archivo '.$fileName.' se cargo correctamente.';
			$prepareStatement = "INSERT INTO `img`  ( `odt`,`fecha`,`dir_img`,`revisado`,`tecnico`,`tipo`)
			VALUES
			(?,?,?,?,?,?);";
				$arrayString = array (
					$name,
					$fecha,
					$fileName,
					0,
					$tecnico,
					1
				);
			$Eventos->insert ( $prepareStatement, $arrayString );

		} else {
			echo 'No se subio el Archivo';
		}
		
}

if($module == 'saveImage') {
	if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
		$name = $_POST['name'];
		$fecha = date ( 'Y-m-d H:i:s' );
		$tecnico = $_SESSION['userid'];
        $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION );
		$fileName = $_FILES['file']['name'];
		$folder = $_SERVER["DOCUMENT_ROOT"].'/img/'.$name;
		echo $folder;
		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}else {
			chmod($folder, 0777);
		}

		if( move_uploaded_file($_FILES['file']['tmp_name'], $folder.'/'.$fileName) ) {
			echo 'EL Archivo '.$fileName.' se cargó correctamente.';
			$prepareStatement = "INSERT INTO `img`  ( `odt`,`fecha`,`dir_img`,`revisado`,`tecnico`,`tipo`)
			VALUES
			(?,?,?,?,?,?);";
				$arrayString = array (
					$name,
					$fecha,
					$fileName,
					0,
					$tecnico,
					1
				);
			$Eventos->insert ( $prepareStatement, $arrayString );

		} else {
			echo 'No se subio el Archivo';
		}
		
		
       // echo 'EL Archivo se cargo correctamente.  <br>';
    }
}

if($module == "borrarImagen") {

	$prepareStatement = "DELETE FROM `img` WHERE odt =?,`dir_img`=?	; ";

	$arrayString = array (
		$params['odt'],
		$params['imagen']
	);
		
	$Eventos->insert ( $prepareStatement, $arrayString );

	echo 1;
}

if($module == "getEventobyTecnico") {
	$existenEvento = $Eventos->getEventobyTecnico($_SESSION['userid']);
	echo json_encode($existenEvento);
}

if($module == "getDetalleEvento") {
	$existenEvento = $Eventos->getDetalleEvento($params['eventoId']);
	echo json_encode($existenEvento);
}

if($module == "getImagesbyEvento") {
	$existenEvento = $Eventos->getImagesbyEvento($params['odt'],$params['tipo']);
	echo json_encode($existenEvento);
}

if($module =="saveVisitaTecnico") {
	$fecha = date ( 'Y-m-d H:i:s' );
	$id = $params['formularioId'];
 

	if($id == '0') {
		$prepareStatement = "INSERT INTO `visita_tecnicos`  ( `tipo_evento`,`formulario`,`user_id`,`fecha_creacion`,`fecha_modificacion`)
		VALUES
		(?,?,?,?,?);";
			$arrayString = array (
				'VO',
				json_encode($params),
				$_SESSION['userid'],
				$fecha,
				$fecha
			);
		$newId = $Eventos->insert ( $prepareStatement, $arrayString );
	} else {
		$prepareStatement = "UPDATE `visita_tecnicos` SET `formulario`=?,`fecha_modificacion`=?  WHERE `id`=? ; ";

		$arrayString = array (
			json_encode($params),
			$fecha,
			$id 
		);

		$Eventos->insert($prepareStatement,$arrayString);
		$newId = $id;
	}
	echo $newId;
}

if($module == "cambiarInConnect"){
	$fecha = date ( 'Y-m-d H:i:s' );
	$tpv = $params['tpv'];
	$conectividadIn = $params['tpvInConnect'];
	$aplicativoIn = $params['aplicativoIn'];
	$aplicativoIn = (int) $aplicativoIn;
	$message = '';

	$prepareStatement = "UPDATE inventario SET
						aplicativo=?,
						conectividad=?
						WHERE no_serie=? ;
						";
	$arrayString = array (
			$aplicativoIn,
			$conectividadIn,
			$tpv
	);

	$upd = $Eventos->insert($prepareStatement, $arrayString);

	print_r($arrayString);
	
	$message .= "Se actualizó la información de tpv en almacen";
	
	echo json_encode(['upd'=>$upd,'message' => $message]);

}

if($module == "cambiarReConnect"){
	$fecha = date ( 'Y-m-d H:i:s' );
	$tpv = $params['tpvRe'];
	$conectividadOut = $params['tpvReConnect'];
	$aplicativoOut = $params['aplicativoOut'];
	$message = '';

	$prepareStatement = "UPDATE inventario SET
						aplicativo=?,
						conectividad=?
						WHERE no_serie=? ;
						";
	$arrayString = array (
			$aplicativoOut,
			$conectividadOut,
			$tpv
	);

	$upd = $Eventos->insert($prepareStatement, $arrayString);

	
	$message .= "Se actualizó la información de tpv en almacen";
	
	echo json_encode(['upd'=>$upd,'message' => $message]);

}


if ($module== 'cambiarEstatusenTransito') {

	$fecha_transito = date ( 'Y-m-d H:i:s' );
	$status = $params['estatus'];
	$odt = $params['odtid'];
	$tecnico = $params['tecnico'];
	$user = $_SESSION['userid'];
	$msg= '';
	$result = 0;

	$evento = $Eventos->getOdtenServicioTecnico($tecnico);

	// cambiar el evento con Estatus EN TRANSITO
	$prepareStatement = "UPDATE eventos SET
						 estatus=?,
						 modificado_por=?,
						 fecha_transito=?,
						 WHERE tecnico=?
						 AND estatus= 20 ;
						 ";

	 $arrayString = array (
		2,
		$user,
		$fecha_transito,
		$tecnico
	 );

	 $Eventos->insert($prepareStatement, $arrayString);
	 
	 // Actualizar el evento seleccionado
	 
	$prepareStatement = "UPDATE eventos SET
						 estatus=?,
						 modificado_por=?,
						 fecha_transito=?
						 WHERE id=?;
						 ";

	 $arrayString = array (
		$status,
		$user,
		$fecha_transito,
		$odt
	 );

	 $upd = $Eventos->insert($prepareStatement, $arrayString);
	 
	 $result = 1;
	 
	echo $result;

}


if ($module== 'cambiarEstatusenRuta') {

	$fecha_ruta = date ( 'Y-m-d H:i:s' );
	$status = $params['estatus'];
	$odt = $params['odtid'];
	$tecnico = $params['tecnico'];
	$user = $_SESSION['userid'];
	$msg= '';
	$result = 0;

	$evento = $Eventos->getOdtenServicioTecnico($tecnico);

	// cambiar el evento con Estatus EN RUTA
	$prepareStatement = "UPDATE eventos SET
						 estatus=?,
						 modificado_por=?,
						 fecha_asignacion=?,
						 WHERE tecnico=?
						 AND estatus= 2 ;
						 ";

	 $arrayString = array (
		2,
		$user,
		$fecha_ruta,
		$tecnico
	 );

	 $Eventos->insert($prepareStatement, $arrayString);
	 
	 // Actualizar el evento seleccionado
	 
	$prepareStatement = "UPDATE eventos SET
						 estatus=?,
						 modificado_por=?,
						 fecha_asignacion=?
						 WHERE id=?;
						 ";

	 $arrayString = array (
		$status,
		$user,
		$fecha_ruta,
		$odt
	 );

	 $upd = $Eventos->insert($prepareStatement, $arrayString);
	 
	 $result = 1;
	 
	echo $result;

}


if($module == 'cerrarEvento') {

	
	$fecha = date ( 'Y-m-d H:i:s' );
	$evento_id = $params['eventoId'];
	$servicio_id = $params['servicioId'];
	$odt = $params['odt'];
	$comentario = $params['comentario'];
	$estatus = $params['estatus'];
	$user = $_SESSION['userid'];
	$tecnico = $params['tecnico'];

	$permisos = $Eventos->getCamposObligatorios($servicio_id);

	$odtGetNet = $params['odtGetNet'];
	$odtNotificado = $params['odtNotificado'];
	$odtDescarga = $params['odtDescarga'];
	
	$tvpRetBateria = $params['tvpRetBateria'];
	$tvpRetEliminador = $params['tvpRetEliminador'];
	$tvpRetTapa = $params['tvpRetTapa'];
	$tvpRetCable = $params['tvpRetCable'];
	$tvpRetBase = $params['tvpRetBase'];
	
	$rechazo = $params['rechazo'];
	$subrechazo = $params['subrechazo'];
	$cancelado = $params['cancelado'];
	
	//$tpv = strlen($params['tpv']) > 0 ? $params['tpv'] : null;
	$tpv = !strlen($params['tpv']) ? null : $params['tpv'];
	
	$tvpInModelo = $params['tvpInModelo'];
	$tpvInConnect = $params['tpvInConnect'];
	$tpvRetirado = !strlen($params['tpvRetirado']) ? null : $params['tpvRetirado'];
	$tvpReModelo = $params['tvpReModelo'];
	$tpvReConnect = $params['tpvReConnect'];
	$idcaja = $params['idCaja'];
	$afiliacionAmex = $params['afiliacionAmex'];
	$idamex = $params['idamex'];
	$simInstalado = !strlen($params['simInstalado']) ? null : $params['simInstalado'];
	$simInData = $params['simInData'];
	$simRetirado = !strlen($params['simRetirado'])  ? null : $params['simRetirado'];
	$simReData = $params['simReData'];
	$producto = $params['producto'];
	$producto_ret = $params['producto_ret'];
	$comentariocierre = $params['comentario'];

	$fechaatencion = $params['fechaatencion'];
	$horallegada = $params['horallegada'];
	$horasalida = $params['horasalida'];

	$version = $params['version'];
	$version_ret = $params['version_ret'];
    $aplicativo = $params['aplicativo'];
	$aplicativo_ret = $params['aplicativo_ret'];
	$receptorservicio = $params['receptorservicio'];
	$foliotelecarga = $params['foliotelecarga'];

	$rollosInstalar = empty($params['rollosInstalar']) ? 0 : $params['rollosInstalar'] ;
	$rollosInstalados = empty($params['rollosInstalados']) ? 0: $params['rollosInstalados'] ;

	$faltaSerie = $params['faltaSerie'];
	$faltaEvidencia = $params['faltaEvidencia'];
	$faltaInformacion = $params['faltaInformacion'];
	$faltaUbicacion = $params['faltaUbicacion'];

	$causacambio = $params['causacambio'];

	$codigo_rechazo = $params['codigo_rechazo'];
	$codigo_rechazo_2 = $params['codigo_rechazo_2'];
	$aplica_exito = $params['aplica_exito'];
	$aplica_rechazo = $params['aplica_rechazo'];

	//
	$tipo_atencion = $params['tipo_atencion'];
	$fecha_reprogramacion = empty($params['fecha_reprogramacion']) ? null : $params['fecha_reprogramacion'];
	
	$prepareStatement = "UPDATE `eventos` SET 
						`estatus`=?,
						`tecnico`=? ,
						`estatus_servicio`=?,
						`comentarios_cierre`=?,
						`fecha_cierre`=?,
						`tpv_instalado`=?,
						`tpv_retirado`=?,
						`id_caja`=?,
						`afiliacionamex`=?,
						`amex`=?,
						`sim_instalado`=?,
						`sim_retirado`=?,
						`modificado_por`=?,
						`producto`=? ,
						`producto_ret`=? ,
						`comentarios_cierre`=? ,
						`version`=? ,
						`version_ret`=? ,
						`aplicativo`=? ,
						`aplicativo_ret`=? ,
						`receptor_servicio`=? ,
						`folio_telecarga`=?,
						`rollos_instalar`=?,
						`rollos_entregados`=?,
						`fecha_atencion`=?,
						`hora_llegada`=?,
						`hora_salida`=?, 
						`causacambio`=?, 
						`rechazo`=?, 
						`subrechazo`=?, 
						`cancelado`=?,
						`codigo_servicio`=?,
						`codigo_servicio_2`=?,
						`tipo_atencion`=?,
						`fecha_programacion`=?
						 WHERE `odt`=? ; 
						 ";

	$arrayString = array (
		3,
		$tecnico,
		$estatus,
		$comentario,
		$fecha,
		$tpv,
		$tpvRetirado,
		$idcaja,
		$afiliacionAmex,
		$idamex,
		$simInstalado,
		$simRetirado,
		$user,
		$producto,
		$producto_ret,
		$comentariocierre,
		$version,
		$version_ret,
		$aplicativo,
		$aplicativo_ret,
		$receptorservicio,
		$foliotelecarga,
		$rollosInstalar,
		$rollosInstalados,
		$fechaatencion,
		$horallegada,
		$horasalida,
		$causacambio,
		$rechazo,
		$subrechazo,
		$cancelado,
		$codigo_rechazo,
		$codigo_rechazo_2,
		$tipo_atencion,
		$fecha_reprogramacion,
		$odt 
	);

	$Eventos->insert($prepareStatement,$arrayString);

	// INFO extras TPV RETIRADO

		$querySIM = " DELETE FROM eventos_tpvretirado  WHERE odt=?  ";
		$Eventos->insert($querySIM,array($odt));
								  
	$datafieldsTvpRetirado = array('odt','getnet','notificado','descarga','ret_batalla','ret_eliminador','ret_tapa','ret_cable','ret_base');
				
	$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTvpRetirado), '?'));

	$sql = "INSERT INTO eventos_tpvretirado (" . implode(",", $datafieldsTvpRetirado ) . ") VALUES (".$question_marks.")"; 

	$arrayString = array (
		$odt,
		$odtGetNet,
		$odtNotificado,
		$odtDescarga,
		$tvpRetBateria,
		$tvpRetEliminador,
		$tvpRetTapa,
		$tvpRetCable,
		$tvpRetBase
	);

	$Eventos->insert($sql,$arrayString);

	// INSERT Checklist de Eventos
	$sqlChecklist = "  INSERT INTO checklist_evento (odt, tecnico, serie, evidencia, informacion, ubicacion,aplica_exito,aplica_rechazo_2, creado_por,fecha_creacion) 
					   VALUES('$odt',$tecnico,$faltaSerie,$faltaEvidencia,$faltaInformacion,$faltaUbicacion,$aplica_exito,$aplica_rechazo,$user,'$fecha' ) 
					   ON DUPLICATE KEY UPDATE    
					   odt= '$odt',
					   tecnico= $tecnico,
					   serie= $faltaSerie,
					   evidencia=$faltaEvidencia,
					   informacion=$faltaInformacion,
					   ubicacion=$faltaUbicacion,
					   aplica_exito=$aplica_exito,
					   aplica_rechazo_2=$aplica_rechazo,
					   creado_por=$user ,
					   fecha_creacion='$fecha' 
					";
	$Eventos->insert($sqlChecklist,array());

	//Insert Into historial_eventos
		$prepareStatementHistE = "INSERT INTO `historial_eventos` (`evento_id`,`fecha_movimiento`,`estatus_id`,`odt`,`modified_by`)
								VALUES
								(?,?,?,?,?);  
							";

		
		$arrayStringHE = array(
			$evento_id,
			$fecha,
			$estatus,
			$odt,
			$user
		);
		

		$Eventos->insert($prepareStatementHistE, $arrayStringHE);
	
	if($estatus == '14' || $estatus == '15') 
	{
		if( $estatus == '15' && !is_null($fecha_reprogramacion) ){
			$nuevaFechaProg= $fecha_reprogramacion." 23:59:00";
			$sql = "UPDATE eventos SET fecha_vencimiento= ? ,estatus=?,estatus_servicio=?,fecha_atencion=?,hora_salida=?,hora_llegada=? WHERE odt=?";

			$resultado = $Procesos->insert($sql, array($nuevaFechaProg,2,16,NULL,NULL,NULL,$odt));
		}
		
	} else {
		
		//Validar inventarios TVP Instalada
		$datosTPV = $Eventos->getInvNoserie($tpv);
		$datosEvento = $Eventos->existeEvento($odt);
		$datosComercio = $Eventos->getClientesByAfiliacion($datosEvento[0]['afiliacion']);
		
		

			if($datosTPV) 
			{

				$queryTVP = " UPDATE inventario SET modelo=?,conectividad=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,modificado_por=?,fecha_edicion=? WHERE no_serie=?";
				$Eventos->insert($queryTVP,array($tvpInModelo,$tpvInConnect,4,2,$datosComercio[0]['id'],$_SESSION['userid'],$fecha,$tpv));
				// TVP INSTALADO QUITAR DEL INV TECNICO
				$queryTVP = " DELETE FROM inventario_tecnico  WHERE no_serie=? AND tecnico=?  ";
				$Eventos->insert($queryTVP,array($tpv,$datosEvento[0]['tecnico']));

			

			}  
			else 
			{

					$tpvElavon = $Eventos->getInvUniversoNoserie($tpv);

					if($tpvElavon['estatus_modelo'] != '17') {
						
						$datafieldsInv = array('tipo','cve_banco','no_serie','modelo','conectividad','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','modificado_por','fecha_entrada','fecha_creacion','fecha_edicion');
					
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInv), '?'));

						$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInv ) . ") VALUES (".$question_marks.")"; 
						$arrayString = array (
							$tpvElavon['tipo'],
							'037',
							$tpv,
							$tvpInModelo,
							$tpvInConnect,
							$tpvElavon['estatus_modelo'],
							4,
							1,
							2,
							$datosComercio[0]['id'],
							$user,
							$user,
							$fecha,
							$fecha,
							$fecha
						);

						$Eventos->insert($sql,$arrayString);
					}
			}
		

			//Existe 
			$existeInventarioId = $Eventos->getInventarioId($tpv);
			$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'INSTALADO');

			if($existeHistorialMov == '0') 
			{

				$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
					
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
				$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 

				$arrayString = array (
					$existeInventarioId,
					$fecha,
					'INSTALADO',
					2,
					$tpv,
					1,
					1,
					$datosComercio[0]['id'],
					$user
				);

				$Eventos->insert($sql,$arrayString);
			}
		

		

		//Validar inventarios TVP Retirado
		if ( strlen($tpvRetirado) > 0 ) 
		{

			$datosTPVRet = $Eventos->getInvNoserie($tpvRetirado);
			$tpvElavon = $Eventos->getInvUniversoNoserie($tpvRetirado);
			$tpvInvTecnico = $Eventos->getInventarioTecnicoNoserie($tpvRetirado);
			$existeInventarioId = $Eventos->getInventarioId($tpvRetirado);
			//Existe en Elavon Universo
			if($tpvElavon) {
				//Existe en INventario
				if($datosTPVRet) 
				{

					if( $datosTPVRet['id_ubicacion'] !=  $tecnico ) {

						$queryTVP = " UPDATE inventario SET modelo=?,conectividad=?,estatus=?,estatus_inventario=?,ubicacion=?,id_ubicacion=?,modificado_por=?,fecha_edicion=? WHERE no_serie=?";
						$Eventos->insert($queryTVP,array($tvpReModelo,$tpvReConnect,15,3,9,$tecnico,$user,$fecha,$tpvRetirado));

						//GRABAR Historial RETIRO de COMERCIO
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRADO');

						if($existeHistorialMov == '0') {

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
						
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'RETIRADO',
								2,
								$tpvRetirado,
								1,
								1,
								$datosEvento[0]['comercio'],
								$user
							);
						
							$Eventos->insert($sql,$arrayString);
						}
					
					} 

			

					$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

					$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
					$arrayString = array (
						$datosEvento[0]['tecnico'],
						$tpvRetirado,
						1,
						0,
						1,
						$datosEvento[0]['tecnico'],
						$fecha,
						$fecha
					);

					$existId = $Eventos->insert($sql,$arrayString);

					if($existId) {
						//GRABAR Historial Entrada INventario Tecnico
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'ENTRADA INV TECNICO');

						if($existeHistorialMov == '0') {

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
						
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'ENTRADA INV TECNICO',
								9,
								$tpvRetirado,
								1,
								1,
								$tecnico,
								$user
							);
						
							$Eventos->insert($sql,$arrayString);
						}
					}
					
				
				} else {

					if($tpvElavon['estatus_modelo'] != '17') 
					{
						$datafieldsInventarios = array('tipo','no_serie','modelo','conectividad','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','fecha_entrada','fecha_creacion','fecha_edicion','modificado_por','cve_banco');
							
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInventarios), '?'));
						$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInventarios ) . ") VALUES (".$question_marks.")"; 

						$arrayStringD = array (
							1,
							$tpvRetirado,
							$tvpReModelo,
							$tpvReConnect,
							15,
							3,
							1,
							9,
							$datosEvento[0]['tecnico'],
							$user,
							$fecha,
							$fecha,
							$fecha,
							$user,
							$datosComercio[0]['cve_banco']
						);

						$id = $Eventos->insert($sql,$arrayStringD);

						//GRABAR Historial RETIRO de COMERCIO
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRADO');

						if($existeHistorialMov == '0') {

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
						
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'RETIRADO',
								2,
								$tpvRetirado,
								1,
								1,
								$datosEvento[0]['comercio'],
								$user
							);
						
							$Eventos->insert($sql,$arrayString);
						}

						$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
						
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

						$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
						$arrayString = array (
							$datosEvento[0]['tecnico'],
							$tpvRetirado,
							1,
							0,
							1,
							$datosEvento[0]['tecnico'],
							$fecha,
							$fecha
						);

						$Eventos->insert($sql,$arrayString);

						//GRABAR Historial Entrada INventario Tecnico
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'ENTRADA INV TECNICO');

						if($existeHistorialMov == '0') {

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")";
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'ENTRADA INV TECNICO',
								9,
								$tpvRetirado,
								1,
								1,
								$tecnico,
								$user
							);
						
							$Eventos->insert($sql,$arrayString);
						}

					}

					
				}

			}
	
		}

		
		
		//Validar inventarios SIM Instalada
		if( strlen($simInstalado) > 0 ) 
		{

			//GRABAR Historial RETIRO de COMERCIO
			$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'INSTALADO');

			if($existeHistorialMov == '0') 
			{

				$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
					
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
				$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
			
				$arrayString = array (
					$existeInventarioId,
					$fecha,
					'INSTALADO',
					2,
					$simInstalado,
					1,
					1,
					$datosEvento[0]['comercio'],
					$user
				);
			
				$Eventos->insert($sql,$arrayString);
			}

			$datosSIM = $Eventos->getInvNoserie($simInstalado);
			$simElavon = $Eventos->getInvUniversoNoserie($simInstalado);
			$simInvTecnico = $Eventos->getInventarioTecnicoNoserie($simInstalado);
			$existeInventarioId = $Eventos->getInventarioId($simInstalado);
			//Existe en Elavon
			if($simElavon) 
			{

				if($datosSIM) 
				{

					$querySIM = " UPDATE inventario SET modelo=?,estatus_inventario=?,ubicacion=?,modificado_por=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
					$Eventos->insert($querySIM,array($simInData,4,2,$_SESSION['userid'],$datosComercio[0]['id'],$fecha,$simInstalado));				
					
					// TVP INSTALADO QUITAR DEL INV TECNICO
					$querySIM = " DELETE FROM inventario_tecnico  WHERE no_serie=? AND tecnico=?  ";
					$Eventos->insert($querySIM,array($simInstalado,$datosEvento[0]['tecnico']));
					//Grabar Historia
					$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRADO TECNICO');

					if($existeHistorialMov == '0') 
					{

						$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
						
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
						$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
					
						$arrayString = array (
							$existeInventarioId,
							$fecha,
							'RETIRADO TECNICO',
							2,
							$simInstalado,
							2,
							1,
							$datosEvento[0]['tecnico'],
							$user
						);
					
						$Eventos->insert($sql,$arrayString); 
					}

				}  else {
					
					if($simElavon['estatus_modelo'] != '17') 
					{
						
						$datafieldsInv = array('tipo','cve_banco','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','modificado_por','fecha_entrada','fecha_creacion','fecha_edicion');
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInv), '?'));

						$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInv ) . ") VALUES (".$question_marks.")"; 
						$arrayString = array (
							$simElavon['tipo'],
							'037',
							$simInstalado,
							$simInData,
							$simElavon['estatus_modelo'],
							4,
							1,
							2,
							$datosComercio[0]['id'],
							$user,
							$user,
							$fecha,
							$fecha,
							$fecha
						);

						$Eventos->insert($sql,$arrayString);
						//Grabar Historia
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRADO TECNICO');

						if($existeHistorialMov == '0') 
						{

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
							
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
						
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'RETIRADO TECNICO',
								2,
								$simInstalado,
								2,
								1,
								$datosEvento[0]['tecnico'],
								$user
							);
						
							$Eventos->insert($sql,$arrayString); 
						}
					}
				}
			}	
			
		}
		
		
			//Validar inventarios SIM Retirado
		if( strlen($simRetirado) > 0 ) 
		{

				//GRABAR Historial RETIRO de COMERCIO
				$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRO COMERCIO');

				if($existeHistorialMov == '0') 
				{

					$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
						
					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
					$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
				
					$arrayString = array (
						$existeInventarioId,
						$fecha,
						'RETIRO COMERCIO',
						2,
						$tpvRetirado,
						1,
						1,
						$datosEvento[0]['comercio'],
						$user
					);
				
					$Eventos->insert($sql,$arrayString);
				}

				$datosSIM = $Eventos->getInvNoserie($simRetirado);
				$simElavon = $Eventos->getInvUniversoNoserie($simRetirado);
				$simInvTecnico = $Eventos->getInventarioTecnicoNoserie($simRetirado);
				$existeInventarioId = $Eventos->getInventarioId($simRetirado);

				if($simElavon) {

					if($datosSIM) {

						$queryTVP = " UPDATE inventario SET modelo=?,estatus=?,estatus_inventario=?,ubicacion=?,modificado_por=?,id_ubicacion=?,fecha_edicion=? WHERE no_serie=?";
						$Eventos->insert($queryTVP,array($simReData,15,3,9,$_SESSION['userid'],$datosEvento[0]['tecnico'],$fecha,$simRetirado));

						$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
							
						$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));

						//GRABAR Historial RETIRO de COMERCIO
						$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'RETIRADO');

						if($existeHistorialMov == '0') 
						{

							$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
								
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
							$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
						
							$arrayString = array (
								$existeInventarioId,
								$fecha,
								'ENTRADA INV TECNICO',
								9,
								$tpvRetirado,
								1,
								1,
								$tecnico,
								$user
							);
						
							$Eventos->insert($sql,$arrayString);
						}

					} else 
					{

						$simElavon = $Eventos->getInvUniversoNoserie($simRetirado);

						if($simElavon['estatus_modelo'] != '17') 
						{
							
							$datafieldsInv = array('tipo','cve_banco','no_serie','modelo','estatus','estatus_inventario','cantidad','ubicacion','id_ubicacion','creado_por','modificado_por','fecha_entrada','fecha_creacion','fecha_edicion');
						
							$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInv), '?'));

							$sql = "INSERT INTO inventario (" . implode(",", $datafieldsInv ) . ") VALUES (".$question_marks.")"; 
							$arrayString = array (
								$simElavon['tipo'],
								'037',
								$simRetirado,
								$simReData,
								$simElavon['estatus_modelo'],
								3,
								1,
								9,
								$tecnico,
								$user,
								$user,
								$fecha,
								$fecha,
								$fecha
							);

							$Eventos->insert($sql,$arrayString);

							//GRABAR Historial RETIRO de COMERCIO
							$existeHistorialMov = $Eventos->existHistorialMov($existeInventarioId,'ENTRADA INV TECNICO');

							if($existeHistorialMov == '0') 
							{

								$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
									
								$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
								$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
							
								$arrayString = array (
									$existeInventarioId,
									$fecha,
									'ENTRADA INV TECNICO',
									9,
									$tpvRetirado,
									1,
									1,
									$tecnico,
									$user
								);
							
								$Eventos->insert($sql,$arrayString);
							}

							
						}
					}

					$datafieldsInvTecnico = array('tecnico','no_serie','cantidad','no_guia','aceptada','creado_por','fecha_creacion','fecha_modificacion');
					$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInvTecnico), '?'));
					
					$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInvTecnico ) . ") VALUES (".$question_marks.")"; 
					$arrayString = array (
						$datosEvento[0]['tecnico'],
						$simRetirado,
						1,
						0,
						1,
						$datosEvento[0]['tecnico'],
						$fecha,
						$fecha
					);

					$Eventos->insert($sql,$arrayString);
				}

		}
		
		 
	}
		


} 

if($module=="scriptEvento") {
	$servicio = $params['servicio_id'];
	$noserie = $params['noserie'];
	$conectividad = $params['conectividad'];
	$modelo = $params['modelo'];

	$script = $Eventos->getScriptEvento($servicio,$conectividad); 

	//$newScript = str_replace("#MODELO",$modelo,$script['script']);

	echo json_encode($script);
}

if($module=='getCamposObligatorios') {

	$rows = $Eventos->getCamposObligatorios($params['servicioid']);
	echo json_encode($rows);
}

if($module == 'eventoMasivo') {
	
	$target_dir = "../cron/files/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$uploadOk = 1;
	$fecha = date ( 'Y-m-d H:i:s' );
	$cveBanco = $params['cveBanco'];

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
			 
			$datafieldsCargar = array('tipo','archivo','creado_por','fecha_creacion','fecha_modificacion', 'cve_banco');
			
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCargar), '?'));
			$sql = "INSERT INTO carga_archivos (" . implode(",", $datafieldsCargar ) . ") VALUES (".$question_marks.")"; 
	
			$arrayString = array (
				'E',
				$_FILES["file"]["name"],
				$_SESSION['userid'],
				$fecha,
				$fecha,
				$cveBanco
			);
		
			$id = $Eventos->insert($sql,$arrayString);
			echo "Se Cargo el Archivo. $id  $cveBanco ".$target_file;

		} else {
			echo "No se puede cargar el Archivo. " ;
		}
	}
}
/*
if($module == 'eventoMasivo') {

	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);
	$user = $_SESSION['userid'];
	$consecutivo = 1;
	$counter = 0;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:i:s' );
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
	$datosCargar = array();
	$format = "d/m/Y H:i:s";


	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$ODT = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		if(!is_null($ODT->getValue())  ) {
			$counter++;
			//$ODT = str_replace( ' ', '', $ODT->getValue() );
			$Ticket = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
			$Afiliacion = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
			$Comercio = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
			$Direccion = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
			$Colonia = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
			$Ciudad = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
			$Estado = $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
			$FechaAlta = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
			$FechaVencimiento = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
			/*
			$date = DateTime::createFromFormat($format, $FechaAlta->getFormattedValue());
			$FechaAlta = $date->format("Y-m-d H:i:s");
			
			$date = DateTime::createFromFormat($format, $FechaVencimiento->getFormattedValue());
			$FechaVencimiento = $date->format("Y-m-d H:i:s");
			 
			
			$FechaAlta = str_replace('/','-',$FechaAlta->getFormattedValue());
			$FechaAlta =  date('Y-m-d H:i:s', strtotime($FechaAlta));
			$FechaVencimiento = str_replace('/','-',$FechaVencimiento->getFormattedValue());
			$FechaVencimiento =  date('Y-m-d H:i:s', strtotime($FechaVencimiento));

			$Descripcion = $hojaDeProductos->getCellByColumnAndRow(11, $indiceFila);
			$Observaciones = $hojaDeProductos->getCellByColumnAndRow(12, $indiceFila);
			$Telefono = $hojaDeProductos->getCellByColumnAndRow(13, $indiceFila);
			$TipoComercio = $hojaDeProductos->getCellByColumnAndRow(14, $indiceFila);
			$Nivel = $hojaDeProductos->getCellByColumnAndRow(15, $indiceFila);
			$servicio = $hojaDeProductos->getCellByColumnAndRow(16, $indiceFila);
			$TipoServicio = $Eventos->getServicioxNombre($servicio);
			$SubServicio = $hojaDeProductos->getCellByColumnAndRow(17, $indiceFila)->getValue();
			$SubtipoServicio = $SubServicio = '' ? 0 : $Eventos->getSubServicioxNombre( $SubServicio );
			$Propietario = $hojaDeProductos->getCellByColumnAndRow(18, $indiceFila);
			$Tecnico = $hojaDeProductos->getCellByColumnAndRow(19, $indiceFila);
			$Proveedor = $hojaDeProductos->getCellByColumnAndRow(20, $indiceFila);
			$EstatusServicio = $hojaDeProductos->getCellByColumnAndRow(21, $indiceFila)->getValue();
			$EstatusServicio = $EstatusServicio = '' ? 0 : $Eventos->getEstatusServicioxNombre($EstatusServicio);
			
			$FechaAtencionProveedor = $hojaDeProductos->getCellByColumnAndRow(22, $indiceFila);
			if($FechaAtencionProveedor->getFormattedValue() == "" ) {
				$FechaAtencionProveedor = NULL;
			} else {
				
				$date = DateTime::createFromFormat($format, $FechaAtencionProveedor);
				$FechaAtencionProveedor = $date->format("Y-m-d H:i:s");
				
			}
			$FechaCierreSistema = $hojaDeProductos->getCellByColumnAndRow(23, $indiceFila);
			if($FechaCierreSistema->getFormattedValue() != "" || $FechaCierreSistema->getFormattedValue() == null ) {
				$FechaCierreSistema == NULL;
			} else {
				$FechaCierreSistema = date('Y-m-d H:i:s', strtotime($FechaCierreSistema));
				
			}
			$FechaAltaSistema = $hojaDeProductos->getCellByColumnAndRow(24, $indiceFila);
			if($FechaAltaSistema->getFormattedValue() == "") {
				$FechaAltaSistema = NULL;
			} else {
				$FechaAltaSistema = date('Y-m-d H:i:s', strtotime($FechaAltaSistema));
			 
			}
			$CodigoPostal = $hojaDeProductos->getCellByColumnAndRow(25, $indiceFila);
			$Conclusiones = $hojaDeProductos->getCellByColumnAndRow(26, $indiceFila);
			$Conectividad = $hojaDeProductos->getCellByColumnAndRow(27, $indiceFila)->getValue();
			$Conectividad = $Conectividad = '' ? 0 : $Eventos->getConectividadxNombre($Conectividad);
			$Modelo = $hojaDeProductos->getCellByColumnAndRow(28, $indiceFila);
			$IdEquipo = $hojaDeProductos->getCellByColumnAndRow(29, $indiceFila);
			$IdCaja = $hojaDeProductos->getCellByColumnAndRow(30, $indiceFila);
			$RFC = $hojaDeProductos->getCellByColumnAndRow(31, $indiceFila); //NO
			$RazonSocial = $hojaDeProductos->getCellByColumnAndRow(32, $indiceFila); //NO
			$DiasAtencion = $hojaDeProductos->getCellByColumnAndRow(33, $indiceFila); //NO
			$GetNet = $hojaDeProductos->getCellByColumnAndRow(34, $indiceFila); //NO
			$SLASistema = $hojaDeProductos->getCellByColumnAndRow(35, $indiceFila);
			$Nivel2 = $hojaDeProductos->getCellByColumnAndRow(36, $indiceFila);
			$TelefonosenCampo = $hojaDeProductos->getCellByColumnAndRow(37, $indiceFila);
			$Canal = $hojaDeProductos->getCellByColumnAndRow(38, $indiceFila);
			$AfiliacionAmex = $hojaDeProductos->getCellByColumnAndRow(39, $indiceFila);
			$IdAmex = $hojaDeProductos->getCellByColumnAndRow(40, $indiceFila);
			$Producto = $hojaDeProductos->getCellByColumnAndRow(41, $indiceFila);
			$MotivoCancelacion = $hojaDeProductos->getCellByColumnAndRow(42, $indiceFila); //NO
			$MotivoRechazo = $hojaDeProductos->getCellByColumnAndRow(43, $indiceFila); //NO
			$Email = $hojaDeProductos->getCellByColumnAndRow(44, $indiceFila); //NO
			$Rollosainstalar = $hojaDeProductos->getCellByColumnAndRow(45, $indiceFila);
			$Rollosainstalar = is_null($Rollosainstalar->getValue()) ? 0 : $Rollosainstalar->getValue();
			$NumSerieTerminalEntra = $hojaDeProductos->getCellByColumnAndRow(46, $indiceFila);
			$NumSerieTerminalSale = $hojaDeProductos->getCellByColumnAndRow(47, $indiceFila);
			$NumSerieTerminalmto = $hojaDeProductos->getCellByColumnAndRow(48, $indiceFila);
			$NumSerieSimSale = $hojaDeProductos->getCellByColumnAndRow(49, $indiceFila);
			$NumSerieSimEntra = $hojaDeProductos->getCellByColumnAndRow(50, $indiceFila);
			$VersionSW = $hojaDeProductos->getCellByColumnAndRow(51, $indiceFila);
			$Cargador = $hojaDeProductos->getCellByColumnAndRow(52, $indiceFila);
			$Base = $hojaDeProductos->getCellByColumnAndRow(53, $indiceFila);
			$RollosEntregados = $hojaDeProductos->getCellByColumnAndRow(54, $indiceFila);
			//$RolloEntregados = is_null($RolloEntregados->getValue()) ? 0 : $RolloEntregados;
			$Cablecorriente = $hojaDeProductos->getCellByColumnAndRow(55, $indiceFila);
			$Zona = $hojaDeProductos->getCellByColumnAndRow(56, $indiceFila);
			$MarcaTerminalSale = $hojaDeProductos->getCellByColumnAndRow(57, $indiceFila);//NO
			$ModeloTerminalSale = $hojaDeProductos->getCellByColumnAndRow(58, $indiceFila);//NO
			$CorreoEjecutivo = $hojaDeProductos->getCellByColumnAndRow(59, $indiceFila);//NO
			$Rechazo = $hojaDeProductos->getCellByColumnAndRow(60, $indiceFila);//NO
			$Contacto1 = $hojaDeProductos->getCellByColumnAndRow(61, $indiceFila);//NO
			$Atiendeencomercio = $hojaDeProductos->getCellByColumnAndRow(62, $indiceFila);//NO
			$TidAmexCierre = $hojaDeProductos->getCellByColumnAndRow(63, $indiceFila);
			$AfiliacionAmexCierre = $hojaDeProductos->getCellByColumnAndRow(64, $indiceFila);
			$Codigo = $hojaDeProductos->getCellByColumnAndRow(65, $indiceFila);//NO
			$TieneAmex = $hojaDeProductos->getCellByColumnAndRow(66, $indiceFila);
			$ActReferencias = $hojaDeProductos->getCellByColumnAndRow(67, $indiceFila);//NO
			$Tipo_A_b = $hojaDeProductos->getCellByColumnAndRow(68, $indiceFila);//NO
			$DomicilioAlterno = $hojaDeProductos->getCellByColumnAndRow(69, $indiceFila);
			$TipoCarga = $hojaDeProductos->getCellByColumnAndRow(70, $indiceFila);
			$AreaCarga = $hojaDeProductos->getCellByColumnAndRow(71, $indiceFila);
			$AltaPor = $hojaDeProductos->getCellByColumnAndRow(72, $indiceFila);
			$tipoComercio = $TipoComercio == 'NORMAL' ? 1 : 2;
			$clienteExiste = $Eventos->getClientesByAfiliacion($Afiliacion->getValue());
			
			if( sizeof($clienteExiste) == 0 ) {
				
				//$estado = $Eventos->getEstadoxNombre($Estado);
				//$ciudad = $Eventos->getCiudadxNombre($Ciudad,$estado);
				$datafieldsCustomers = array('comercio','propietario','estado','responsable','tipo_comercio','ciudad','colonia',
				'afiliacion','telefono','direccion','rfc','email','email_ejecutivo','territorial_banco',
				'razon_social','cve_banco','cp','estatus','activo','fecha_alta');
		
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCustomers), '?'));

				$sql = "INSERT INTO comercios (" . implode(",", $datafieldsCustomers ) . ") VALUES (".$question_marks.")"; 

				$arrayString = array (
					$Comercio,
					$Propietario,
					$Estado, 
					$Atiendeencomercio,
					$tipoComercio,
					$Ciudad,
					$Colonia,
					$Afiliacion,
					$Telefono,
					$Direccion,
					$RFC,
					$Email,
					$CorreoEjecutivo,
					$Zona,
					$RazonSocial,
					'037',
					$CodigoPostal,
					1,
					1,
					$fecha 
				);
			
				$newCustomerId = $Eventos->insert($sql,$arrayString);
				

				
		
				//$newId = $Eventos->insert($sql,$arrayString);

			}  else {
				$newCustomerId = $clienteExiste[0]['id'];

				$sqlEvento = "UPDATE comercios SET comercio=?,direccion=?,colonia=?,cp=?  WHERE id = ?";

				$arrayString = array (
					$Comercio,
					$Direccion,
					$Colonia, 
					$CodigoPostal,
					$newCustomerId
				);
			
				$Eventos->insert($sqlEvento,$arrayString);

			}

			if($TipoServicio == 0) {
				$datafieldsTipoServicio = array('nombre','tipo','status');
		
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTipoServicio), '?'));

				$sql = "INSERT INTO tipo_servicio (" . implode(",", $datafieldsTipoServicio ) . ") VALUES (".$question_marks.")"; 

				$arrayString = array (
					$servicio,
					'rep',
					1
				);
			
				$newTipoServicioId = $Eventos->insert($sql,$arrayString);
			} else {
				$newTipoServicioId = $TipoServicio;
			}

			$existeEvento = $Eventos->existeEvento($ODT);


			if(sizeof($existeEvento) == '0') {
				$fecha = date ( 'Y-m-d H:i:s' );

				$datafields = array('odt','afiliacion','comercio','direccion','colonia','municipio','estado','consecutivo',
				'fecha_alta','fecha_vencimiento','descripcion','comentarios','telefono','nivel','tipo_servicio','servicio',
				'estatus_servicio','comentarios_cierre','amex','email',
				'rollos_instalar','tpv_instalado','tpv_retirado','sim_retirado','sim_instalado','cargador','base',
				'cable','cve_banco','estatus','afiliacionamex','tieneamex','clave_autorizacion',
				'actreferencias','domicilioalterno','id_caja','tipocarga','slafijo','telfonoscampo','producto','modificado_por'); 

				$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

				$sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

				$arrayStringEvento = array (
					$ODT->getValue() ,
					$Afiliacion->getValue() ,
					$newCustomerId,
					$Direccion->getValue() ,
					$Colonia->getValue(),
					$Ciudad->getValue(),
					$Estado->getValue(),
					0,
					$FechaAlta,
					$FechaVencimiento,
					$Descripcion->getValue(),
					$Observaciones->getValue(),
					$Telefono->getValue(),
					$Nivel->getValue(),
					$newTipoServicioId ,
					$SubtipoServicio,
					16, 
					$Conclusiones->getValue() ,
					$IdAmex->getValue(),
					$Email->getValue() ,
					$Rollosainstalar,
					$NumSerieTerminalEntra->getValue() ,
					$NumSerieTerminalSale->getValue() ,
					$NumSerieSimSale->getValue() ,
					$NumSerieSimEntra->getValue(),
					$Cargador->getValue(),
					$Base->getValue() ,
					$Cablecorriente->getValue() ,
					'037',
					$EstatusServicio,
					$AfiliacionAmex->getValue(),
					$TieneAmex->getValue(),
					$Codigo->getValue(),
					$ActReferencias->getValue(),
					$DomicilioAlterno->getValue(),
					$IdCaja->getValue(),
					$TipoCarga->getValue(),
					$SLASistema->getValue(),
					$TelefonosenCampo ->getValue(),
					$Producto->getValue(),
					$user

				);
				array_push($datosCargar,$arrayStringEvento);
				
				$newId = $Eventos->insert($sqlEvento,$arrayStringEvento);
				
				//GRABAR HISTORIA EVENTOS 
				
				$datafieldsHistoria = array('evento_id','fecha_movimiento','estatus_id','odt', 'modified_by');
				
				$question_marksHistoria = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
				
				$sqlHistoria = "INSERT INTO historial_eventos(" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marksHistoria.")";
				
				$arrayStringHistoria = array ($newId, $fecha, 16, $ODT, $user );
				
				$Eventos->insert($sqlHistoria, $arrayStringHistoria);
				//END GRABAR HISTORIA EVENTOS
				
				
			} else {

				if($existeEvento[0]['estatus_servicio'] == '16' ) {
					$sqlEvento = "UPDATE eventos SET  fecha_alta= ?,fecha_vencimiento= ? WHERE id = ?";

					$arrayStringEvento = array (
						$FechaAlta,
						$FechaVencimiento,
						$existeEvento[0]['id']

					);
				
					$newId = $Eventos->insert($sqlEvento,$arrayStringEvento);
				}
			}
		//}
	//}
	echo json_encode(["contador" => $counter, "datos" => $datosCargar]);

		
}  */

/* if($module == 'eventoMasivoAssignacion') {

	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:i:s' );
	$FechaAlta = date('Y-m-d');
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$Tecnico = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$TipoCarga = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$ODT = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Afiliacion = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
		$Comercio = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
		$Direccion = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		$Colonia = $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
		$Ciudad = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		$CodigoPostal = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
		$CodigoPostal = is_null($CodigoPostal->getValue()) ? 0 : $CodigoPostal;
		$FechaVencimiento = $hojaDeProductos->getCellByColumnAndRow(11, $indiceFila);
		$FechaVencimientoFinal = $FechaVencimiento->getFormattedValue();
		$Descripcion = $hojaDeProductos->getCellByColumnAndRow(12, $indiceFila);
		$Telefono = $hojaDeProductos->getCellByColumnAndRow(13, $indiceFila);
		
		$servicio = $hojaDeProductos->getCellByColumnAndRow(14, $indiceFila);
		$TipoServicio = $Eventos->getServicioxNombre($servicio);
		// $FechaAlta = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		// $FechaAlta = str_replace('/','-',$FechaAlta);
		// $FechaAlta =  date('Y-m-d H:i:s', strtotime($FechaAlta));

		$FechaVencimiento = date("d-m-Y", strtotime($FechaVencimientoFinal));
		$FechaVencimiento =  date('Y-m-d H:i:s', strtotime('+23 hour',strtotime($FechaVencimiento)) );
		
		$clienteExiste = $Eventos->getClientesByAfiliacion($Afiliacion->getValue());
		
		if( sizeof($clienteExiste) == 0 ) {
			
			//$estado = $Eventos->getEstadoxNombre($Estado);
			//$ciudad = $Eventos->getCiudadxNombre($Ciudad,$estado);
			$datafieldsCustomers = array('afiliacion','comercio','direccion','colonia','ciudad','cp','cve_banco','estatus','activo','fecha_alta');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCustomers), '?'));

			$sql = "INSERT INTO comercios (" . implode(",", $datafieldsCustomers ) . ") VALUES (".$question_marks.")"; 

			$arrayString = array (
				$Afiliacion,
				$Comercio,
				$Direccion,
				$Colonia,
				$Ciudad,
				$CodigoPostal, 
				'037',
				1,
				1,
				$fecha 
			);
		
			$newCustomerId = $Eventos->insert($sql,$arrayString);
			

			
	
			//$newId = $Eventos->insert($sql,$arrayString);

		}  else {
			$newCustomerId = $clienteExiste[0]['id'];
		}

		if(!$TipoServicio ) {
			$datafieldsTipoServicio = array('nombre','tipo','status');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTipoServicio), '?'));

			$sql = "INSERT INTO tipo_servicio (" . implode(",", $datafieldsTipoServicio ) . ") VALUES (".$question_marks.")"; 

			$arrayString = array (
				$servicio,
				'rep',
				1
			);
		
			$newTipoServicioId = $Eventos->insert($sql,$arrayString);
		} else {
			$newTipoServicioId = $TipoServicio;
		}

		$existeEvento = $Eventos->existeEvento($ODT);


		if($existeEvento == '0') {
			$datafields = array('tecnico','odt','afiliacion','comercio','direccion','colonia','municipio','codigopostal','fecha_alta',
			'fecha_vencimiento','descripcion','telefono','tipo_servicio','cve_banco','estatus'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

			$sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

			$arrayStringEvento = array (
				$Tecnico,
				$ODT ,
				$Afiliacion ,
				$newCustomerId,
				$Direccion ,
				$Colonia,
				$Ciudad,
				$CodigoPostal,
				$FechaAlta,
				$FechaVencimiento,
				$Descripcion,
				$Telefono,
				$newTipoServicioId,
				'037',
				2
			);
		
			$newId = $Eventos->insert($sqlEvento,$arrayStringEvento);
		} else {
			//PEndiente si se envian eventos nuevos 
			// $sqlEvento = "UPDATE eventos SET  fecha_vencimiento= ?  WHERE id = ?";

			// $arrayStringEvento = array (
			// 	$FechaVencimiento,
			// 	$existeEvento

			// );
		
			// $newId = $Eventos->insert($sqlEvento,$arrayStringEvento);
		}
	}
	
	echo $numeroMayorDeFila;

		
} */

if($module == 'eventoMasivoAssignacion') {
	$counter = 0;
	$odtNoCargadas = array();
	$odtYaCargadas = array();
	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:i:s' );
	$FechaAlta = date('Y-m-d');
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$Tecnico = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$TipoCarga = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$ODT = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Afiliacion = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
		$Comercio = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
		$Direccion = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		$Colonia = $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
		$Ciudad = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		$CodigoPostal = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
		$CodigoPostal = is_null($CodigoPostal->getValue()) ? 0 : $CodigoPostal;
		$FechaVencimiento = $hojaDeProductos->getCellByColumnAndRow(11, $indiceFila);
		$FechaVencimientoFinal = $FechaVencimiento->getFormattedValue();
		$Descripcion = $hojaDeProductos->getCellByColumnAndRow(12, $indiceFila);
		$Telefono = $hojaDeProductos->getCellByColumnAndRow(13, $indiceFila);
		
		$servicio = $hojaDeProductos->getCellByColumnAndRow(14, $indiceFila);
		$TipoServicio = $Eventos->getServicioxNombre($servicio);
		// $FechaAlta = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		// $FechaAlta = str_replace('/','-',$FechaAlta);
		// $FechaAlta =  date('Y-m-d H:i:s', strtotime($FechaAlta));
		$Rollos = $hojaDeProductos->getCellByColumnAndRow(15, $indiceFila);

		$FechaVencimiento = date("d-m-Y", strtotime($FechaVencimientoFinal));
		$FechaVencimiento =  date('Y-m-d H:i:s', strtotime('+23 hour',strtotime($FechaVencimiento)) );
		
		$clienteExiste = $Eventos->getClientesByAfiliacion($Afiliacion->getValue());
		
		if( sizeof($clienteExiste) == 0 ) {
			
			//$estado = $Eventos->getEstadoxNombre($Estado);
			//$ciudad = $Eventos->getCiudadxNombre($Ciudad,$estado);
			$datafieldsCustomers = array('afiliacion','comercio','direccion','colonia','ciudad','cp','cve_banco','estatus','activo','fecha_alta');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCustomers), '?'));

			$sql = "INSERT INTO comercios (" . implode(",", $datafieldsCustomers ) . ") VALUES (".$question_marks.")"; 

			$arrayString = array (
				$Afiliacion,
				$Comercio,
				$Direccion,
				$Colonia,
				$Ciudad,
				$CodigoPostal, 
				'037',
				1,
				1,
				$fecha 
			);
		
			$newCustomerId = $Eventos->insert($sql,$arrayString);
			

			
	
			//$newId = $Eventos->insert($sql,$arrayString);

		}  else {
			$newCustomerId = $clienteExiste[0]['id'];
		}

		if(!$TipoServicio ) {
			$datafieldsTipoServicio = array('nombre','tipo','status');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsTipoServicio), '?'));

			$sql = "INSERT INTO tipo_servicio (" . implode(",", $datafieldsTipoServicio ) . ") VALUES (".$question_marks.")"; 

			$arrayString = array (
				$servicio,
				'rep',
				1
			);
		
			$newTipoServicioId = $Eventos->insert($sql,$arrayString);
		} else {
			$newTipoServicioId = $TipoServicio;
		}

		$existeEvento = $Eventos->existeEvento($ODT);


		if($existeEvento) {
			if($Tecnico->getValue() != $existeEvento[0]['tecnico']) {

				$nombreTecnico = $Eventos->GetTecnicoById('Busqueda '.$existeEvento[0]['tecnico']);

			} else {
				$nombreTecnico = $Eventos->GetTecnicoById($Tecnico->getValue());
			}
			array_push($odtYaCargadas,["ODT" => $ODT->getValue(), "Tecnico" => $nombreTecnico ]);
			//PEndiente si se envian eventos nuevos 
			// $sqlEvento = "UPDATE eventos SET  fecha_vencimiento= ?  WHERE id = ?";

			// $arrayStringEvento = array (
			// 	$FechaVencimiento,
			// 	$existeEvento

			// );
		
			// $newId = $Eventos->insert($sqlEvento,$arrayStringEvento);

			
			 
		} else {

			$datafields = array('tecnico','odt','afiliacion','comercio','direccion','colonia','municipio','codigopostal','fecha_alta',
			'fecha_vencimiento','fecha_asignacion','descripcion','telefono','tipo_servicio','cve_banco','estatus','rollos_instalar'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

			$sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

			$arrayStringEvento = array (
				$Tecnico->getValue(),
				$ODT ,
				$Afiliacion ,
				$newCustomerId,
				$Direccion ,
				$Colonia,
				$Ciudad,
				$CodigoPostal,
				$FechaAlta,
				$FechaVencimiento,
				$fecha,
				$Descripcion,
				$Telefono,
				$newTipoServicioId,
				'037',
				2,
				$Rollos
			);
		
			$newId = $Eventos->insert($sqlEvento,$arrayStringEvento);
			
			if($newId != 0) {
				$counter++;
				
			} else {
				
				array_push($odtNoCargadas,$ODT->getValue());
			}
		}
	}
	
	echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "registrosCargados" => $counter, "odtNoCargadas" => $odtNoCargadas,"odtYaCargadas" => $odtYaCargadas,'existeEvento'=> $existeEvento]);

		
}

if ($module == 'grabarIncidencia') {
	
	$user = $_SESSION['userid'];
	$fecha_alta = date('Y-m-d H:m:s');
	$id_odt = $params['id'];
	$odt = $params['odt'];
	$tipo = $params['tipo'];
	if ($tipo == 'e') 
	{
		$t = 'Evidencia';
	}
	else
	{
		$t = 'Inventario';
	}
	$comentarioE = $params['comentarioCallCenter1'];
	$comentarioI = $params['comentarioCallCenter2'];
	$incidenciaE = json_decode( $params['inc1'] );
	$incidenciaI = json_decode( $params['inc2'] );

	$existeIncidencia = $Eventos->existeIncidencia($odt,$tipo);

	
	if ($tipo == 'e') {
		$comentario = $comentarioE;
	}
	else
	{
		$comentario = $comentarioI;
	}


	if (!$existeIncidencia) {
		
		$prepareStatement = "INSERT INTO `incidencia_odt` (`id_odt`,`odt`, `tipo`, `comentario_cc`, `fecha_alta`, `creado_por`, `estatus`) 
		                     VALUES(?,?,?,?,?,?,?);";

		$arrayString = array(
				$id_odt,
				$odt,
				$tipo,
				$comentario,
				$fecha_alta,
				$user,
				1
		);

		$id = $Eventos->insert($prepareStatement,$arrayString);

		if ($id) {
			
			if ($tipo == 'e') {

				foreach ($incidenciaE as $incEvento) {
					
					$prepareStatementE = "INSERT INTO `detalle_incidencia_odt` (`incidencia_id`, `subtipo_incidencia`, `estatus`,`fecha_alta`)
											VALUES(?,?,?,?);";

					$arrayStringE = array(
								$id,
								$incEvento,
								1,
								$fecha_alta
					);

					$Eventos->insert($prepareStatementE, $arrayStringE);
				}
			}

			if ($tipo == 'i') {

				foreach ($incidenciaI as $incInventario) {
					
					$prepareStatementI = "INSERT INTO `detalle_incidencia_odt` (`incidencia_id`, `subtipo_incidencia`, `estatus`,`fecha_alta`)
											VALUES(?,?,?,?);";

					$arrayStringI = array(
								$id,
								$incInventario,
								1,
								$fecha_alta
					);

					$Eventos->insert($prepareStatementI, $arrayStringI);

				}
			}

			
			

		}else
		{
			echo "ERROR CON EL REGISTRO";
			
		}
		$msg = 'Se generó la incidencia';
	}
	else
	{
		$msg= 'La odt ya cuenta con incidencia del tipo '.$t;
		$id = '0';
	}

	echo json_encode(['id'=> $id, 'msg' => $msg, 'existe' => $existeIncidencia ]);

}

if($module == 'delIncidencia') {

	$fecha_atencion = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE `detalle_incidencia_odt` SET `estatus` = ?, `fecha_atencion` = ? WHERE id = ?;";
	$arrayString = array (
		0,
		$fecha_atencion,
    	$params['id']
		
	);

	$Eventos->insert($prepareStatement,$arrayString);
	echo $params['id'];

	$prepareStatement2 = "UPDATE `incidencia_odt` SET `estatus` = ? WHERE id = ?";

	$arrayString2 = array (
		0,
		$params['inc_id']
	);

	$Eventos->insert($prepareStatement2, $arrayString2);

}

if($module == 'addIncidencia') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE `detalle_incidencia_odt` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		1,
    	$params['id']
		
	);

	$Eventos->insert($prepareStatement,$arrayString);
	echo $params['id'];

	$prepareStatement2 = "UPDATE `incidencia_odt` SET `estatus` = ? WHERE id = ?";

	$arrayString2 = array (
		1,
		$params['inc_id']
	);

	$Eventos->insert($prepareStatement2, $arrayString2);
}

if ($module == 'solucionIncidencia') 
{
	$fecha_solucion = date("Y-m-d H:i:s");
	$id_incidencia = $params['id'];
	$prepareStatement = "UPDATE `incidencia_odt` SET `comentario_solucion` = ?, `fecha_solucion` = ?, `estatus` = ? WHERE id = ?";

	$arrayString = array (
		$params['comentario'],
		$fecha_solucion,
		0,
		$params['id']
	);
	$id = $Eventos->insert($prepareStatement, $arrayString);

	var_dump($arrayString);
	

	
		
		$prepareStatement2 = "UPDATE `detalle_incidencia_odt` SET `estatus` = ?, `fecha_atencion` = ? WHERE `incidencia_id` = ?";

		$arrayString2 = array (
				0,
				$fecha_solucion,
		    	$id_incidencia
				
			);

		$Eventos->insert($prepareStatement2,$arrayString2);
			
	
		var_dump($arrayString2);
	

}

if ($module == 'voboIncidencia') {
	
	$fecha_solucion = date("Y-m-d H:i:s");
	$id_incidencia = $params['idIn'];


	$prepareStatement = "UPDATE `incidencia_odt` SET `vobo` = ? WHERE id = ?";

	$arrayString = array (
		1,
		$id_incidencia
	);

	$Eventos->insert($prepareStatement,$arrayString);

	$prepareStatement2 = "UPDATE `detalle_incidencia_odt` SET `estatus` = ? WHERE `incidencia_id` = ?";

	$arrayString2 = array (
				0,
		    	$id_incidencia
				
			);
	$Eventos->insert($prepareStatement2,$arrayString2);

}
if ($module == 'voboIncidenciaBack') {
	
	$fecha_solucion = date("Y-m-d H:i:s");
	$id_incidencia = $params['idIn'];


	$prepareStatement = "UPDATE `incidencia_odt` SET `vobo` = ? WHERE id = ?";

	$arrayString = array (
		0,
		$id_incidencia
	);

	$Eventos->insert($prepareStatement,$arrayString);

	$prepareStatement2 = "UPDATE `detalle_incidencia_odt` SET `estatus` = ? WHERE `incidencia_id` = ?";

	$arrayString2 = array (
				1,
		    	$id_incidencia
				
			);
	$Eventos->insert($prepareStatement2,$arrayString2);

}


if ($module == 'getSubtipoIncidencia') 
{
	$tipos = $Eventos->getSubtipoIncidencia($params['id']);

	echo json_encode($tipos);
}

if ($module == 'agregarsubIncidencia') {
	
	$fecha_alta = date("Y-m-d H:m:s");
	$id_incidencia = $params['id'];
	$tipo = $params['tipo'];
	$comentarioAlta = $params['comentarioCallCenter'];
	$incidenciaE = json_decode( $params['inc1'] );
	$incidenciaI = json_decode( $params['inc2'] );

	$prepareStatement ="UPDATE `incidencia_odt` SET `comentario_cc` = ?, `estatus` = ? WHERE `id` = ?;";

	$arrayString = array(
			$comentarioAlta, 
			1, 
			$id_incidencia
		);

	 $Eventos->insert($prepareStatement,$arrayString);

		
		if ($tipo == 'e') {

			foreach ($incidenciaE as $incEvento) {
				
				$prepareStatementE = "INSERT INTO `detalle_incidencia_odt` (`incidencia_id`, `subtipo_incidencia`, `estatus`,`fecha_alta`)
										VALUES(?,?,?,?);";

				$arrayStringE = array(
							$id_incidencia,
							$incEvento,
							1,
							$fecha_alta
				);

				$Eventos->insert($prepareStatementE, $arrayStringE);
			}
		}

		if ($tipo == 'i') {

			foreach ($incidenciaI as $incInventario) {
				
				$prepareStatementI = "INSERT INTO `detalle_incidencia_odt` (`incidencia_id`, `subtipo_incidencia`, `estatus`,`fecha_alta`)
										VALUES(?,?,?,?);";

				$arrayStringI = array(
							$id_incidencia,
							$incInventario,
							1,
							$fecha_alta
				);

				$Eventos->insert($prepareStatementI, $arrayStringI);

			}
		}
	
}

if ($module == 'existeIncidencia') {
	
	$existe = $Eventos->existeIncidencia($params['odt'],$params['tipo']);

	echo json_encode($existe);

}

?>