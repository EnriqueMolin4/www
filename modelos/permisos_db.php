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
			self::$logger->error ("File: permisos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: permisos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: permisos_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getTiposUsuarios() {
		$sql = "select  id,nombre from tipo_user where status = 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: getTiposUsuarios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getUsuariosTipos() {
		$sql = "select  id,nombre from tipo_user where status = 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: getUsuariosTipos();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}


	function getMenu() {
		$sql = "SELECT id, modulo FROM menu";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: getMenu();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}



    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
        $catalogo = $params['catalogo'];

        $orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
		$where = "";

	
		if(isset($orderField) ) 
		{
			$order .= " ORDER BY   $orderField   $orderDir";
		}
        

		if(isset($start) && $length != -1 && $total) 
		{
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( tipo_user.nombre LIKE '".$params['search']['value']."%'  ";
			$where .="   OR  menu.modulo LIKE '".$params['search']['value']."%' ) ";  

		}
		
		
		$sql = "SELECT modulousuario.id, tipo_user.nombre Usuario, menu.modulo Modulo, modulousuario.estatus
					FROM tipo_user
					JOIN modulousuario ON tipo_user.id = modulousuario.tipo_id
					JOIN menu WHERE menu.id = modulousuario.menu_id
					$where
					$order
					$filter ";

		
        if($catalogo == "0") 
		{
		    
        } else {
            $sql = " SELECT modulousuario.id, tipo_user.nombre Usuario, menu.modulo Modulo, modulousuario.estatus
					 FROM tipo_user
					 JOIN modulousuario ON tipo_user.id = modulousuario.tipo_id
					 JOIN menu ON menu.id = modulousuario.menu_id
					 WHERE tipo_user.id = $catalogo
			
            $where 
			$order
            $filter ";
        }

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: permisos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "select c.id, CONCAT(du.nombre,du.apellidos) nombre from cuentas c,detalle_usuarios du
                where c.id = du.cuenta_id
                and c.tipo_user in (12) order by du.nombre";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function searchPermiso($menu, $tusuario) 
	{
		$params = $_REQUEST;

		$module = $params['module'];
		
		$menu = $params['menu'];

		$tusuario = $params['user'];

		$sql = "  SELECT modulousuario.id, modulousuario.menu_id, modulousuario.tipo_id
		FROM modulousuario
		WHERE modulousuario.menu_id = ? and modulousuario.tipo_id = ? ";
		
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($menu, $tusuario));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: permisos_db.php;	Method Name: searchPermiso();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: permisos_db.php;	Method Name: buscarTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
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
            self::$logger->error ("File: permisos_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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



if($module == 'getMenu') {

	$rows = $Usuario->getMenu();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['modulo'] . '</option>';
	}
	echo $val;

}

//////////////////

if($module == 'existepermiso')
{
	$existe = $Usuario->searchPermiso($params['menu'], $params['user']);

	echo json_encode(['existe' => count($existe), 'menu' => $existe, 'usuario' => $existe]);
}

/////////////////

if($module == 'nuevopermiso')
{
	$fecha_alta = date("Y-m-d H:i:s");
	$userType = $_SESSION['userid'];
	$existe = $Usuario->searchPermiso($params['menu'], $params['user']);

	if(count($existe) == 0)
	{
		$prepareStatement = "INSERT INTO modulousuario
							(menu_id, 
							tipo_id, 
							edit, 
							estatus, 
							creado_por, 
							fecha_creacion)
							VALUES
							(?,?,?,?,?,?);";

		$arrayString = array (
				$params['menu'],
				$params['user'],
				1,
				1,
				$userType,
				$fecha_alta);

		$id = $Usuario->insert($prepareStatement, $arrayString);

		if($id == 0)
		{
			$envio = "Problemas con el alta del permiso";
		}

		$envio = "Se guardó el permiso";

		echo $envio;
	}
	else
	{
		
		 $envio = "Este permiso ya se asignó al rol";
		 
		 echo $envio ;
	}
}


/////////////////




if($module == 'getTipoUsuarios') {

	$rows = $Usuario->getTiposUsuarios();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getUsuariosTipos') {

	$rows = $Usuario->getUsuariosTipos();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'addParametro') 
{
    $table = $params['catalogo'];
	
	$existe= $Usuario->searchParam($params['parametro']);

	echo json_encode(['existe' => count($existe),'parametro' => $existe]);

	if (count($existe)==0)
	{
		$prepareStatement = "INSERT INTO $table( `nombre`,`estatus`)VALUES(?,?);";
		
		$arrayString = array ($params['parametro'],1);
	
    	$id = 	$Usuario->insert($prepareStatement,$arrayString);
	}
		else 
		{
			echo "<script type='text/javascript'>$.toaster({
				message: 'El Usuario Ya Existe',
				title: 'Aviso',
				priority : 'danger'
				})</script>";
		}

   
    
    
}

if($module == 'parametroUpdate') {
    //$catalogo = $params['catalogo'];
    $parametroid = $params['parametroid'];
    $statusid = $params['estatusid'] == '1' ? '0' : '1';


    $prepareStatement = "UPDATE modulousuario SET `estatus`=?  WHERE `id`=? ; ";
    $arrayString = array (
        $statusid,
        $parametroid
    );
	
    $id = 	$Usuario->insert($prepareStatement,$arrayString);
    
    echo 1;
}








?>