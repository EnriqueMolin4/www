<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Territorial implements IConnections {
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
			self::$logger->error ("File: territoriosplazas_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territoriosplazas_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }


    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$territorial = $params['territorial'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
        if($territorial == "0") {
            $territorial = "-1";
        }

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
			$where .=" AND ";
			$where .=" ( cp LIKE '".$params['search']['value']."%' )";    

		}


		$sql = "select * FROM cp_territorios
                WHERE  territorio_id = $territorial
				$where 
				$order
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
		}
	}


	function getTerritorios() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "select * FROM territorios";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getTerritorios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getPlazas() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "select * FROM plazas";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getPlazas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getAlmacenes() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "select * FROM tipo_ubicacion where almacen= 1";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getAlmacenes();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getplazaTerritorio($territorio){
        $sql = "select * FROM tipo_ubicacion where almacen= 1";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getAlmacenes();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getplazaAlmacen($params,$total) {

        $start = $params['start'];
		$length = $params['length'];
        $almacen = $params['almacen'];
        $plaza = $params['plaza'];

        $orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
        $where = "";
        
        if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
        }
        
        if($almacen != '0') {
            $where .= " AND tipo_ubicacion.id = $almacen ";
        }

        if($plaza != '0') {
            $where .= " AND plazas_almacen.plaza_id = $plaza ";
        }
        

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
        }
        
        if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( tipo_ubicacion.nombre  LIKE '".$params['search']['value']."%' ";    
			$where .=" OR plazas.nombre LIKE '%".$params['search']['value']."%'  )";

		}
        
        $sql = " Select plazas.id id, tipo_ubicacion.id almacen_id,plazas.id plaza_id,tipo_ubicacion.nombre Almacen, plazas.nombre Plaza 
                FROM plazas,plazas_almacen,tipo_ubicacion
                WHERE plazas_almacen.almacen_id = tipo_ubicacion.id
                AND plazas.id = plazas_almacen.plaza_id
                AND tipo_ubicacion.almacen = 1 
                $where
                $order 
                $filter ";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getplazaAlmacen();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function buscarTecnico($search) {

		$sql = "SELECT  c.id, IFNULL(CONCAT(du.nombre, ' ',du.apellidos),c.nombre)   nombre from cuentas c, detalle_usuarios du
                where c.id = du.cuenta_id
                AND c.tipo_user = 3
				AND (du.nombre = '$search' OR du.apellidos = '$search' OR du.email LIKE '%$search%')
				 ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territoriosplazas_db.php;	Method Name: buscarComercio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getUser($id) {
		$sql = "select cuentas.Id,cuentas.tipo_user,cuentas.cve,cuentas.supervisor supervisor,
				detalle_usuarios.nombre,detalle_usuarios.apellidos,cuentas.user,
				detalle_usuarios.email correo,cuentas.fecha_alta from cuentas,detalle_usuarios 
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				AND cuentas.id = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territoriosplazas_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

}
//
include 'DBConnection.php';
$Territorial = new Territorial ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Territorial->getTable($params,true);
    $rowsTotal = $Territorial->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}





if($module == 'getTerritorios') {
$rows = $Territorial->getTerritorios();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getPlazas') {
    $rows = $Territorial->getPlazas();
        $val = '<option value="0">Seleccionar</option>';
        foreach ( $rows as $row ) {
            $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
        }
        echo $val;
}

if($module == 'getAlmacenes') {
    $rows = $Territorial->getAlmacenes();
        $val = '<option value="0">Seleccionar</option>';
        foreach ( $rows as $row ) {
            $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
        }
        echo $val;
}

if($module == 'getplazaTerritorio') {
        
    $rows = $Territorial->getplazaTerritorio($params['territorio']);
    $val = '<option value="0">Seleccionar</option>';
    foreach ( $rows as $row ) {
        $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
    }
    
    echo $val;

}

if($module == 'getplazaAlmacen') {
    
    $rows = $Territorial->getplazaAlmacen($params,true);
    $rowsTotal = $Territorial->getplazaAlmacen($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;    
    
}



if($module == 'addCP') {

    $prepareStatement = "INSERT INTO  `cp_territorios` ( `cp`,`territorio_id`)  VALUES (?,?) ; ";
    $arrayString = array (
            $params['cp'],
            $params['territorial']
    );
	
    $id = 	$Territorial->insert($prepareStatement,$arrayString);
    
    echo 1;
}

if($module == 'cpDelete') {
    $prepareStatement = "DELETE  FROM  `cp_territorios`  WHERE `id`=? ; ";
    $arrayString = array (
            $params['cpid']
    );
	
    $id = 	$Territorial->insert($prepareStatement,$arrayString);
    
    echo 1;
}








?>