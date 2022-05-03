<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Usuarios implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection  ( 'sinttecom' );
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
			self::$logger->error ("File: bitacoraODT_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bitacoraODT_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function getEstados() {
		
		$sql = "select * from estados";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getTipoUser() {
		$where = "";
		
		if($_SESSION['tipo_user'] != 'admin') {
			
			$where .= " AND id in ( 3,12 ) ";
		}
		
		$sql = "select id,nombre from tipo_user where status=1 $where ";
		
		//self::$logger->error ($sql);
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getTipoUser();	Functionality: Get Products price From Users;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos() {
		
		$sql = "select id,banco from bancos where status=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getBancos();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
	}
	
	function getPlazas() {
		$sql = "select id,nombre from plazas where status=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getPlazas();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
	}


    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

	
		$filter = "";
		$param = "";
		$where = "";

		$banco = $params['banco'];
		
		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if ($banco > '0') {
			$where .= " AND eventos.cve_banco = $banco";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( odt LIKE '".$params['search']['value']."%' ) ";    
			//$where .=" OR comercios.comercio LIKE '".$params['search']['value']."%' ) ";
			
		}


		$sql = "SELECT eventos.odt, comercios.comercio, eventos.fecha_alta, tipo_estatus.nombre estatus,
				eventos.nivel, eventos.ultima_act, cuentas.correo modificado_por, eventos.tpv_instalado
				FROM eventos
				JOIN comercios ON comercios.afiliacion = eventos.afiliacion
				JOIN tipo_estatus ON tipo_estatus.id = eventos.estatus
				JOIN cuentas ON cuentas.id = eventos.modificado_por
				WHERE eventos.odt is not null
				$where 
				$filter ";

		//self::$logger->error ($sql);

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getHistoria($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$id= $params['tpv_instalado'];
		//$tipo = $params['tipo'];
		$query = "";
		$where = '';

		if($id == '') {
			$id = -1;
		}


		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}
		 if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( historial.tipo_movimiento LIKE '".$params['search']['value']."%' ";
			$where .=" OR tu.nombre LIKE '".$params['search']['value']."%'  )";
		}  

		$sql = " SELECT no_serie,fecha_movimiento, tipo_movimiento,
				CASE 
					WHEN tipo = '1' THEN 'TPV' 
					WHEN tipo = '2' THEN 'SIM' 
					WHEN tipo = '3' THEN 'INSUMOS' 
					WHEN tipo = '4' THEN 'ACCESORIOS' END producto,
				tipo_ubicacion.nombre ubicacionNombre,
				cuentas.correo
			FROM historial
			LEFT JOIN tipo_ubicacion ON tipo_ubicacion.id = historial.ubicacion
			LEFT JOIN cuentas ON cuentas.id = historial.modified_by 
			WHERE historial.no_serie = '$id'  "; 
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacora_db.php;	Method Name: getHistoria();	Functionality: Get Historia;	Log:" . $e->getMessage () );
        }
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {
		$sql = "select cuentas.id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre from cuentas,detalle_usuarios  where cuentas.id = detalle_usuarios.cuenta_id AND tipo_user in (1,11) AND cuentas.estatus = 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTerritorial() {
		$sql = "select  id,nombre from territorios ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getTerritorial();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function searchUser($usuario) {
		$sql = "select cuentas.Id,cuentas.tipo_user,cuentas.cve,cuentas.supervisor supervisor,
				detalle_usuarios.nombre,detalle_usuarios.apellidos,
				detalle_usuarios.email correo,cuentas.fecha_alta from cuentas,detalle_usuarios 
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				AND cuentas.correo = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($usuario));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getUser($id) {
		$sql = "select cuentas.Id,cuentas.tipo_user,cuentas.cve,cuentas.supervisor supervisor,
				detalle_usuarios.nombre,detalle_usuarios.apellidos,cuentas.user,cuentas.territorial,
				detalle_usuarios.email correo,cuentas.fecha_alta,cuentas.plaza from cuentas,detalle_usuarios 
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				AND cuentas.id = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getTerritorio($territorio) {
		$territorio = is_null($territorio) ? 0 : $territorio;
		$sql = "select  Id from territorios   
				WHERE nombre LIKE '%$territorio%' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getTerritorio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoUserId($tipo) {

		$sql = "select  Id from tipo_user   
				WHERE nombre LIKE '%$tipo%' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: bitacoraODT_db.php;	Method Name: getTipoUserId();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
}
//
include 'DBConnection.php';
$Usuario = new Usuarios ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Usuario->getTable($params,true);
    $rowsTotal = $Usuario->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getHistoria') {
    $rows = $Usuario->getHistoria($params,true);
    $rowsTotal = $Usuario->getHistoria($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}



if($module == 'existeuser') 
{
	$existe = $Usuario->searchUser($params['correo']);

	echo json_encode(['existe' => count($existe),'usuario' => $existe ]);
}


if($module == 'getSupervisores') {
	$rows = $Usuario->getSupervisores();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTipoUser') {

	$rows = $Usuario->getTipoUser();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getTerritorial') {

	$rows = $Usuario->getTerritorial();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getBancos') {

	$rows = $Usuario->getBancos();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['banco'] . '</option>';
	}
	echo $val;

}

if($module == 'getPlazas') {

	$rows = $Usuario->getPlazas();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getUser') {
	$user = $Usuario->getUser($params['id']);

	echo json_encode($user);
}

if($module == 'delUser') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`cuentas` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		0,
    	$params['id']
		
	);

	$Usuario->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'addUser') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`cuentas` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		1,
    	$params['id']
		
	);

	$Usuario->insert($prepareStatement,$arrayString);
	echo $params['id'];
}
 

?>