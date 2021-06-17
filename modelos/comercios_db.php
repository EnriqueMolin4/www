<?php
session_start();
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Comercios implements IConnections {
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
			$stmt = self::$connection->prepare ( "SELECT * FROM `warehouses`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function getEstados($cp) {
		
		$sql = " select estados.id,estados.nombre FROM cp_santander,estados
					WHERE cp_santander.estado = estados.id
					AND cp_santander.cp = $cp
					group by estados.id ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos() {
		$sql = "select cve, banco nombre from bancos ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getBancos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getMunicipio($cp) {
		$sql = " select municipios.Id, municipios.nombre,cp_santander.territorial_banco,territorial_sinttecom from cp_santander,municipios 
		where municipios.id = cp_santander.ciudad 
		AND cp_santander.cp = $cp
		GRoup by municipios.Id, municipios.nombre,cp_santander.territorial_banco,territorial_sinttecom
		 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($cp));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getMunicipio();	Functionality: Get Municipio;	Log:" . $e->getMessage () );
        }
	}

    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

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
			$where .=" AND ";
			$where .=" ( comercio LIKE '".$params['search']['value']."%' ";    
			$where .=" OR afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR cve_banco LIKE '".$params['search']['value']."%' ";
			$where .=" OR responsable LIKE '".$params['search']['value']."%'  ";
			$where .=" OR telefono LIKE '".$params['search']['value']."%'  ";
			$where .=" OR email LIKE '".$params['search']['value']."%'  ";
            $where .=" OR territorial_sinttecom LIKE '".$params['search']['value']."%'  ";
			$where .=" OR territorial_banco LIKE '".$params['search']['value']."%' ) ";
		}

    	$sql = "select comercios.*,tipo_comercio.nombre TipoComercio,bancos.cve nombreBanco 
            from comercios
            LEFT JOIN tipo_comercio ON comercios.tipo_comercio = tipo_comercio.id ,bancos
            WHERE  bancos.cve = comercios.cve_banco
			$where
			$order
            $filter
            ";
	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}
	
	function getTableTotal() {
		$sql = "select count(*)  from comercios ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getTableTotal();	Functionality: Get Table Total;	Log:" . $e->getMessage () );
		}
	}

    function getComercio($id) {
        $sql = "select * from comercios where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: comercios_db.php;	Method Name: getComercio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

}
//
include 'DBConnection.php';
$Comercios = new Comercios ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Comercios->getTable($params,true);
    $rowsTotal = $Comercios->getTableTotal();
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  $rowsTotal, "recordsFiltered" => $rowsTotal );

	echo json_encode($data); //$val;
}

if($module == 'getestado') {
	$rows = $Comercios->getEstados($params['cp']);
	$val = '';
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '" selected>' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getbancos') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Comercios->getBancos();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['cve'] . '">' . $row ['cve']. " - ".$row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getcomercio') {
    
    $rows = $Comercios->getComercio($params['comercioid']);
     
	echo json_encode($rows);

}

if($module == 'getmunicipio') {
    
    $val = '';
    $rows = $Comercios->getMunicipio($params['cp']);
    /* foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['Id'] . '" selected>' . $row ['nombre'] . '</option>';
	} */
	echo json_encode($rows);
}

if($module == 'grabarComercio') {
	
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );

	if($params['comercioid'] == '0') {
    		$prepareStatement = "INSERT INTO `comercios`
						( `comercio`,`propietario`,`estado`,`responsable`,`tipo_comercio`,`ciudad`,`colonia`,`afiliacion`,
						`telefono`,`direccion`,`rfc`,`email`,`email_ejecutivo`,`territorial_banco`,`territorial_sinttecom`,`hora_general`,`hora_comida`,
						`razon_social`,`cve_banco`,`cp`,`estatus`,`fecha_alta`)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					";
			$arrayString = array (
					$params['comercio'],
					$params['propietario'],
					$params['estado'],
					$params['responsable'] ,
					$params['tipo_comercio'],
					$params['ciudad'],
					$params['colonia'],
					$params['afiliacion'],
					$params['telefono'],
					$params['direccion'],
					$params['rfc'],
					$params['email_comercio'],
					$params['email_ejecutivo'],
					$params['territorial_banco'],
					$params['territorial_sinttecom'],
					$params['hora_general'],
					$params['hora_comida'],
					$params['razon_social'],
					$params['cve_banco'],
					$params['cp'],
					1,
					$createdDate
			);

			$id = $Comercios->insert($prepareStatement,$arrayString);

			echo json_encode(['id'=> $id, 'fecha_creacion' => $createdDate ]);
	} else {
		$prepareStatement = "UPDATE  `comercios` SET  `comercio`=?,`propietario`=?,`estado`=?,`responsable`=?,`tipo_comercio`=?,`ciudad`=?,
		`colonia`=?,`afiliacion`=?, `telefono`=?,`direccion`=?,`rfc`=?,`email`=?,`email_ejecutivo`=?,`territorial_banco`=?,`territorial_sinttecom`=?,
		`hora_general`=?,`hora_comida`=?, `razon_social`=?,`cve_banco`=?,`cp`=?,`estatus`=?  WHERE `id` = ?
		 ";
		$arrayString = array (
			$params['comercio'],
			$params['propietario'],
			$params['estado'],
			$params['responsable'] ,
			$params['tipo_comercio'],
			$params['ciudad'],
			$params['colonia'],
			$params['afiliacion'],
			$params['telefono'],
			$params['direccion'],
			$params['rfc'],
			$params['email_comercio'],
			$params['email_ejecutivo'],
			$params['territorial_banco'],
			$params['territorial_sinttecom'],
			$params['hora_general'],
			$params['hora_comida'],
			$params['razon_social'],
			$params['cve_banco'],
			$params['cp'],
			1,
			$params['comercioid']
		);

		$id = $Comercios->insert($prepareStatement,$arrayString);

		echo json_encode(['id'=> 0, 'fecha_modificacion' => $createdDate ]);
	}
}

if($module == 'delCom') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`comercios` SET `activo` = ? WHERE id = ?;
					";
	$arrayString = array (
		0,
    	$params['id']
		
	);

	$Comercios->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'actCom') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`comercios` SET `activo` = ? WHERE id = ?;
					";
	$arrayString = array (
		1,
    	$params['id']
		
	);

	$Comercios->insert($prepareStatement,$arrayString);
	echo $params['id'];
}


?>
