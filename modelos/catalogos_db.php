<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Catalogos implements IConnections {
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
			self::$logger->error ("File: catalogos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: validcivalidaciones_dbones_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }


    function getModelos($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value']) ) {   
			$where .=" WHERE ";
			$where .=" ( modelo LIKE '".$params['search']['value']."%' ";    
			$where .=" OR proveedor LIKE '".$params['search']['value']."%' ";
			$where .=" OR conectividad LIKE '".$params['search']['value']."%'  )";

		}


		$sql = "select *,getNameById(proveedor,'Proveedor') nombreProveedor,getNameById(estatus,'EstatusModelo') estatusNombre from modelos 
				$where
				group by id 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getComercio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getProveedores() {
		$sql = "select id,  nombre from tipo_proveedor_equipos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getProveedores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getConectividad() {

		$sql = "select id,  nombre from tipo_conectividad ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getConectividad();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }
    
    function getEstatusModelo() {
        $sql = "select id,  nombre from tipo_estatus_modelos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getEstatusModelo();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

}
//
include 'DBConnection.php';
$Catalogos = new Catalogos ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getModelos') {

    $rows = $Catalogos->getModelos($params,true);
    $rowsTotal = $Catalogos->getModelos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}


if($module == 'getProveedores') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Catalogos->getProveedores();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['cve']. " - ".$row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getConectividad') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Catalogos->getConectividad();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['cve']. " - ".$row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getEstatusModelo') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Catalogos->getEstatusModelo();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['cve']. " - ".$row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'grabarModelo') {
	
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );

	if($params['modeloid'] == '0') {
    		$prepareStatement = "INSERT INTO `modelos`
						( `modelo`,`proveedor`,`conectividad`,`no_largo`,`estatus`)
						VALUES
						(?,?,?,?,?);
					";
			$arrayString = array (
					$params['modelo'],
					$params['proveedor'],
					$params['conectividad'],
					$params['no_largo'] ,
					1
			);

			$id = $Catalogos->insert($prepareStatement,$arrayString);

			echo json_encode(['id'=> $id, 'fecha_creacion' => $createdDate ]);
	} else {

            $prepareStatement = "UPDATE  `modelos` SET  
                `modelo`=?,`proveedor`=?,`conectividad`=?,`no_largo`=?,`estatus`=?  
                 WHERE `id` = ?
            ";
            $arrayString = array (
                $params['modelo'],
                $params['proveedor'],
                $params['conectividad'],
                $params['no_largo'] ,
                $params['estatus'] ,
                $params['modeloid']
            );

            $id = $Catalogos->insert($prepareStatement,$arrayString);

		    echo json_encode(['id'=> 0, 'fecha_modificacion' => $createdDate ]);
	}
}





?>