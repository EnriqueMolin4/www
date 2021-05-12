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
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
	
	function getTipoUser() {
		$where = "";
		
		if($_SESSION['tipo_user'] != 'admin') {
			
			$where .= " AND id in ( 3,12 ) ";
		}
		
		$sql = "select id,nombre from tipo_user where status=1 $where ";
		
		self::$logger->error ($sql);
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTipoUser();	Functionality: Get Products price From Users;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos() {
		
		$sql = "select id,banco from bancos where status=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getBancos();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
	}
	
	function getPlazas() {
		$sql = "select id,nombre from plazas where estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getPlazas();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
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
			$where .=" ( user LIKE '".$params['search']['value']."%' ";    
			$where .=" OR tipo_user LIKE '".$params['search']['value']."%' ";
			$where .=" OR detalle_usuarios.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR detalle_usuarios.email LIKE '%".$params['search']['value']."%'  )";

		}


		$sql = "select cuentas.id Id,cuentas.tipo_user,cuentas.cve,territorios.nombre territorial,
				CASE WHEN  detalle_usuarios.apellidos is null THEN detalle_usuarios.nombre ELSE CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) END nombre,
				detalle_usuarios.email correo,cuentas.fecha_alta, cuentas.estatus,GetNameById(cuentas.tipo_user,'TipoUser') TipoUser from cuentas 
				LEFT JOIN territorios ON  cuentas.territorial = territorios.id
				,detalle_usuarios
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				$where 
				$order
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getComercio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {
		$sql = "select cuentas.id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre from cuentas,detalle_usuarios  where cuentas.id = detalle_usuarios.cuenta_id AND tipo_user in (1,11) AND cuentas.estatus = 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTerritorial() {
		$sql = "select  id,nombre from territorios ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTerritorial();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getAlmacen($plaza) {
		$sql = " Select tipo_ubicacion.id,tipo_ubicacion.nombre from tipo_ubicacion,plazas_almacen
				WHERE tipo_ubicacion.id = plazas_almacen.almacen_id
				AND almacen = 1
				AND plazas_almacen.plaza_id = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($plaza));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getAlmacen();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: usuarios_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: usuarios_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTerritorio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTipoUserId();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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


if($module == 'getevento') {
    
    $rows = $Usuario->getUsuario($params['userid']);
     
	echo json_encode($rows);

}

if($module == 'existeuser') {
	$existe = $Usuario->searchUser($params['correo']);

	echo json_encode(['existe' => count($existe),'usuario' => $existe ]);
}

if($module == 'nuevousuario') {
	$fecha_alta = date("Y-m-d H:i:s");
	$existe = $Usuario->searchUser($params['correo']);

	if(count($existe) == 0 ) {
		$prepareStatement = "INSERT INTO `cuentas`
		( `pass`,`supervisor`,`cve`,`tipo_user`,`nombre`,`correo`,`plaza`,`territorial`,`fecha_alta`)
		VALUES
		(?,?,?,?,?,?,?,?,?);
						";
		$arrayString = array (
			sha1($params['contrasena']),
			0,
			$params['negocio'],
			$params['tipo'],
			$params['nombre'],
			$params['correo'],
			$params['plaza'],
			$params['territorial'],
			$fecha_alta
		);

		$id = $Usuario->insert($prepareStatement,$arrayString);
		
		if($id == 0) {
			$envio = "problemas con el alta de usuarios";
		} else {
		$prepareStatement = "INSERT INTO `detalle_usuarios`
			( `nombre`,`apellidos`,`email`,`territorial`,`cuenta_id`)
			VALUES
			(?,?,?,?,?);
			";
			$arrayString = array (
				$params['nombre'],
				$params['apellidos'],
				$params['correo'],
				$params['territorial'],
				$id
			);

			$Usuario->insert($prepareStatement,$arrayString);
			$email = new envioEmail();

			$body = "Se a creado tu cuenta para el Sistema Sinttecom SAS <br /> Tus datos de acceso son  <br/> Usuario :".$params['correo']." <br/>"; 
			$body .= "Contraseña: ".$params['contrasena']." <br /> Acceso Sistema <a href='http://sinttecom.net'>Click Aqui</a>";
			$header = "Acceso Sistema Sinttecom SAS";

			$email->send($header,$body,$params['correo']);
			$envio = "Se Creo al  Usuario";
		} 
	} else {

		$prepareStatement = "UPDATE  `cuentas` SET `cve`=?,`tipo_user`=?,`nombre`=?,`fecha_alta`=?,`territorial`=?,`plaza`=? WHERE `id`=? ; ";
		$arrayString = array (
			$params['negocio'],
			$params['tipo'],
			$params['nombre'],
			$fecha_alta,
			$params['territorial'],
			$params['plaza'],
			$params['userid']
		);

		$id = $Usuario->insert($prepareStatement,$arrayString);

		if(!empty($params['contrasena'])) {
			$prepareStatement = "UPDATE  `cuentas` SET `pass`=? WHERE `id`=? ; ";
			$arrayString = array (
				sha1($params['contrasena']),
				$params['userid']
			);

			$Usuario->insert($prepareStatement,$arrayString);
		}		
		
		$prepareStatement = "UPDATE `detalle_usuarios` SET `nombre`=?,`apellidos`=?,`email`=?,`territorial`=? WHERE `cuenta_id`=? ; ";

		$arrayString = array (
			$params['nombre'],
			$params['apellidos'],
			$params['correo'],
			$params['territorial'],
			$params['userid']
		);

		$Usuario->insert($prepareStatement,$arrayString);		
		$envio = "El Usuario Ya Existe";
	}

	echo $envio;
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


if($module == 'getAlmacen') {

	$rows = $Usuario->getAlmacen($params['plaza']);
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
		$territorioExist = $Usuario->getTerritorio($territorial->getValue()) ;
		$territorio = $territorioExist ? $territorioExist : 0;
		$tipoExist = $Usuario->getTipoUserId($tipo);
		$tipoUsuario = $tipoExist ? $tipoExist : 0 ;
		$usuarioExiste = $Usuario->searchUser($email);
		
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
		
			$newUserId = $Usuario->insert($sql,$arrayString);

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
		
			$newDetalleId = $Usuario->insert($sql,$arrayString);

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

			$Usuario->insert($prepareStatement,$arrayString);
	
			
			$prepareStatement = "UPDATE `detalle_usuarios` SET `nombre`=?,`email`=?,`territorial`=?,`fecha_ingreso`=? WHERE `cuenta_id`=? ; ";

			$arrayString = array (
				$nombre,
				$email,
				$territorio,
				$fecha,
				$usuarioExiste[0]['Id']
			);

			$Usuario->insert($prepareStatement,$arrayString);		
		 
			array_push($Existe,$email) ;
		}

	}

	echo json_encode(["cantidad" => $numeroMayorDeFila,"existe" => $Existe,"Nuevo" => $Nuevo ]);
} 

?>