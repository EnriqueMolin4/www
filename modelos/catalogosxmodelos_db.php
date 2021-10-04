<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Modelos implements IConnections {
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
	private static function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getTipoUser();	Functionality: Get Products price From Users;	Log:" . $e->getMessage () );
        }
	}
	
	function getConectividad() {
		
		$sql = "select id,nombre from tipo_conectividad";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getConectividad();	Functionality: Get Conectividad;	Log:" . $e->getMessage () );
        }
	}
	
	function getPlazas() {
		$sql = "select id,nombre from plazas where estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getPlazas();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
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
			$where .=" WHERE ";
			$where .="( modelo LIKE '".$params['search']['value']."%' ";
			$where .="OR proveedor LIKE '".$params['search']['value']."%' ";
			$where .="OR conectividad LIKE '".$params['search']['value']."%' ";
			$where .="OR cve_banco LIKE '".$params['search']['value']."%' ";
			$where .="OR clave_elavon LIKE '".$params['search']['value']."%' )";           
		}


		$sql = "select modelos.id Id,modelos.modelo,modelos.proveedor,modelos.conectividad, modelos.no_largo, modelos.clave_elavon,modelos.cve_banco, modelos.estatus
				from modelos
				$where 
				$order
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}


	function getProveedor() {
		$sql = "select  id,nombre from tipo_proveedor_equipos ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getProveedor();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function searchModel($modelo) { //Si existe el usuario
		$sql = "SELECT modelos.id, modelos.modelo, modelos.proveedor, modelos.conectividad, modelos.no_largo, modelos.clave_elavon
				FROM modelos
				WHERE modelos.modelo = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($modelo));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: searchModel();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getModel($id) {
		$sql = "select modelos.id, modelos.modelo, modelos.proveedor, modelos.conectividad, modelos.no_largo, modelos.clave_elavon from modelos 
				WHERE modelos.id = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getModel();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getTerritorio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: catalogosxmodelos_db.php;	Method Name: getTipoUserId();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
}
//
include 'DBConnection.php';
$Modelo = new Modelos ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Modelo->getTable($params,true);
    $rowsTotal = $Modelo->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

//////////

if($module == 'getevento') {
    
    $rows = $Modelo->getevento($params['id']);
     
	echo json_encode($rows);

}
//////////

if($module == 'existemodel') 
{
	$existe = $Modelo->searchModel($params['modelo']);

	echo json_encode(['existe' => count($existe),'modelo' => $existe ]);
}

//////////
if($module == 'nuevomodelo') 
{
	$existe = $Modelo->searchModel($params['modelo']);

	if(count($existe) == 0 ) 
	{
		$prepareStatement = "INSERT INTO modelos
				(modelo, 
				proveedor, 
				conectividad, 
				no_largo, 
				clave_elavon, 
				estatus)
				VALUES
				(?,?,?,?,?,?);";

		$arrayString = array (
				$params['modelo'],
				$params['proveedor'],
				$params['conectividad'],
				$params['no_largo'],
				$params['clave_elavon'],
				1);

	  $id = $Modelo->insert($prepareStatement,$arrayString);

	  
	 
	  if($id == 0) 
	  	{
		echo "No se validó el modelo";
		}
		else { echo "Se agregó el modelo: ".$params['modelo']."" ;}

	} 
	else 
	{	
		$prepareStatement = "UPDATE modelos
							 SET   modelo		  = ?,
								   proveedor      = ?,
								   conectividad   = ?,
								   no_largo	      = ?,
								   clave_elavon   = ?
							 WHERE id             = ?;";
		
		$arrayString = array (
							$params['modelo'],
							$params['proveedor'],
							$params['conectividad'],
							$params['no_largo'],
							$params['clave_elavon'],
							$params['modelid']
		);

		$Modelo->insert($prepareStatement,$arrayString); 

		$envio = "Se guardaron los cambios al modelo: ".$params['modelo']."";
		
		echo  $envio;
		
	}
			
}





if($module == 'getProveedor') {

	$rows = $Modelo->getProveedor();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['nombre'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getConectividad') {

	$rows = $Modelo->getConectividad();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['nombre'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getModel') {
	$Model = $Modelo->getModel($params['id']);

	echo json_encode($Model);
}

if($module == 'delModel') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE `modelos` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		0,
    	$params['id']
		
	);

	$Modelo->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'addModel') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`modelos` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		1,
    	$params['id']
		
	);

	$Modelo->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'masivoUsers') {

	$eventoMasivo = new CargasMasivas();

	$hojaDeUsuarios = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$numeroMayorDeFila = $hojaDeUsuarios->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeUsuarios->getHighestColumn(); // Letra
	$Existe = array();
	$Nuevo = array();
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

		$proveedor = $hojaDeUsuarios->getCellByColumnAndRow(1, $indiceFila);
		$nombre = $hojaDeUsuarios->getCellByColumnAndRow(2, $indiceFila);
		$email = $hojaDeUsuarios->getCellByColumnAndRow(3, $indiceFila);
		$password = $hojaDeUsuarios->getCellByColumnAndRow(4, $indiceFila);
		$segurosocial = $hojaDeUsuarios->getCellByColumnAndRow(5, $indiceFila);
		$fechaNacimiento = $hojaDeUsuarios->getCellByColumnAndRow(6, $indiceFila);
		$rfc = $hojaDeUsuarios->getCellByColumnAndRow(7, $indiceFila);
		$fechaIngreso = $hojaDeUsuarios->getCellByColumnAndRow(9, $indiceFila);
		$telefono = $hojaDeUsuarios->getCellByColumnAndRow(8, $indiceFila);
		$tipo = $hojaDeUsuarios->getCellByColumnAndRow(10, $indiceFila);
		$territorial = $hojaDeUsuarios->getCellByColumnAndRow(11, $indiceFila);
		$cve = $hojaDeUsuarios->getCellByColumnAndRow(12, $indiceFila);

		//$fechaNacimiento = str_replace('/','-',$fechaNacimiento);
		//$fechaNacimiento =  date('Y-m-d H:m:s', strtotime($fechaNacimiento));
		//$fechaIngreso = str_replace('/','-',$fechaIngreso);
		//$fechaIngreso =  date('Y-m-d H:m:s', strtotime($fechaIngreso));
		$territorioExist = $Modelo->getTerritorio($territorial->getValue()) ;
		$territorio = $territorioExist ? $territorioExist : 0;
		$tipoExist = $Modelo->getTipoUserId($tipo);
		$tipoUsuario = $tipoExist ? $tipoExist : 0 ;
		$usuarioExiste = $Modelo->searchModel($email);
		
		if( sizeof($usuarioExiste) == 0 ) {

			$datafieldsCuentas = array('pass','tipo_user','cve','nombre','correo','fecha_alta','estatus','supervisor','territorial');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCuentas), '?'));

			$sql = "INSERT INTO cuentas (" . implode(",", $datafieldsCuentas ) . ") VALUES (".$question_marks.")"; 
			
			$arrayString = array (
				sha1($password),
				$tipoUsuario,
				'037',
				$nombre, 
				$email,
				$fecha,
				1,
				0,
				$territorio
			);
		
			$newUserId = $Modelo->insert($sql,$arrayString);

			//ALta Detalle Usuarios
			$datafieldsdetalle = array('nombre','telefono','email','cuenta_id');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsdetalle), '?'));

			$sql = "INSERT INTO detalle_usuarios (" . implode(",", $datafieldsdetalle ) . ") VALUES (".$question_marks.")"; 
			
			$arrayString = array (
				$nombre,
				$telefono, 
				$email,
				$newUserId
			);
		
			$newDetalleId = $Modelo->insert($sql,$arrayString);

			array_push($Nuevo,$email) ;
		}  else {

			$prepareStatement = "UPDATE  `cuentas` SET `cve`=?,`tipo_user`=?,`nombre`=?,`fecha_alta`=?,`territorial`=?,`pass`=?  WHERE `id`=? ; ";
			$arrayString = array (
				$cve,
				$tipoUsuario,
				$nombre,
				$fecha,
				$territorio,
				sha1($password),
				$usuarioExiste[0]['Id']
			);

			$Modelo->insert($prepareStatement,$arrayString);
	
			
			$prepareStatement = "UPDATE `detalle_usuarios` SET `nombre`=?,`email`=?,`territorial`=?,`fecha_ingreso`=? WHERE `cuenta_id`=? ; ";

			$arrayString = array (
				$nombre,
				$email,
				$territorio,
				$fecha,
				$usuarioExiste[0]['Id']
			);

			$Modelo->insert($prepareStatement,$arrayString);		
		 
			array_push($Existe,$email) ;
		}

	}

	echo json_encode(["cantidad" => $numeroMayorDeFila,"existe" => $Existe,"Nuevo" => $Nuevo ]);
} 

?>