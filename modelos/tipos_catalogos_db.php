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
			self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

	function getTipoRechazo(){
		$sql = "SELECT tp.tipo,
				CASE WHEN tp.tipo = 'r' THEN 'RECHAZO' WHEN tp.tipo = 's' THEN 'SUBRECHAZO' END rechazo
				FROM
				tipo_rechazos tp
				GROUP BY tipo";
		
		try {
			 $stmt = self::$connection->prepare ($sql );
			 $stmt->execute (array());
			 $result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			 return $result;
		 } catch ( PDOException $e ) {
			 self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getTipoRechazo();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		 }
		
	}
	
    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
        $catalogo = $params['catalogo'];
        $banco = $params['banco'];

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
			$where .=" ( $catalogo.nombre LIKE '".$params['search']['value']."%' ) ";    

		}

		if ($banco != '0') {
			$where .= " AND $catalogo.cve_banco = $banco";
		}

        if($catalogo == "0") {
      
		    $sql = "SELECT id,nombre from tipo_user
				WHERE id = -1;
				$order
                $filter ";
        } else if($catalogo == 'tipo_producto') { 

			$sql = "SELECT $catalogo.id,$catalogo.nombre,$catalogo.status estatus, bancos.banco from $catalogo LEFT JOIN bancos ON bancos.cve = $catalogo.cve_banco
					WHERE $catalogo.nombre IS NOT NULL
            $where 
			$order
            $filter ";

		} else {
            $sql = "SELECT $catalogo.id,$catalogo.nombre,$catalogo.estatus,bancos.banco from $catalogo LEFT JOIN bancos ON bancos.cve = $catalogo.cve_banco
            		WHERE $catalogo.nombre IS NOT NULL
            $where 
			$order
            $filter ";
        }

        //self::$logger->error($sql);
	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}
	function getTableCR($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
        $catalogo = $params['catalogo'];

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
			$where .=" ( nombre LIKE '".$params['search']['value']."%' ) ";    

		}

        if($catalogo == "0") {
      
		    $sql = "SELECT id,nombre from tipo_user
				WHERE id = -1;
				$order
                $filter ";
        } else {
            $sql = "SELECT id,nombre,estatus from $catalogo
            $where 
			$order
            $filter ";
        }

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getTableCR();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}
	
	function getTableRechazos($params, $total){
		$start = $params['start'];
		$length = $params['length'];
		$catalogo = $params['catalogo'];
		$rechazoTipo = "";
		//$rechazoTipo = $params['tipo'];
		
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
		$where = " WHERE nombre IS NOT NULL";
		/*
		if($rechazoTipo == '0')
		{
			$where .= " ";
		}
		else if ($rechazoTipo == 'r')
		{
			$where .= " AND tipo = 'r' ";
		}
		else 
		{
			$where .= " AND tipo = 's' ";
		}*/
		
	
		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}
        

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}
		
		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( nombre LIKE '".$params['search']['value']."%' ) ";    

		}
		
		
			$sql = "SELECT id, nombre, descripcion, clave_elavon, tipo, estatus FROM $catalogo 
					$where
					$order
					$filter
					";
		
		
		//self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ){
			self::$logger->error ( "File: tipos_catalogos_db.php;      Method Name: getTableRechazos();      Functionality: Get Table;     Log:" . $e->getMessage () );
		}
		
		
		
	}
	
    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function searchParam($nombreP) {
		$params = $_REQUEST;

		$module = $params['module'];
		
		$table = $params['catalogo'];

		$sql = "select * from $table where nombre = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($nombreP));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: searchParam();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: buscarTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
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
            self::$logger->error ("File: tipos_catalogos_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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

if($module == 'getTableCR') {

    $rows = $Usuario->getTable($params,true);
    $rowsTotal = $Usuario->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getRechazosTable'){
	
	$rows = $Usuario->getTableRechazos($params,true);
	$rowsTotal = $Usuario->getTableRechazos($params, false);
	$data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' => count($rowsTotal), "recordsFiltered" => count($rowsTotal) );
	
	echo json_encode($data);
}

if($module == 'getTipoRechazos'){
	$rows = $Usuario->getTipoRechazo();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ){
		$val .= '<option value="' . $row ['tipo'] . '">' . $row ['rechazo'] . '</option>';
	}
	echo $val;
}

if($module == 'desEstatusr'){
	$catalogo = $params['catalogo'];

	$prepareStatement = "UPDATE $catalogo SET estatus = ? WHERE id = ?";

	$arrayString = array (
		0,
		$params['id']
	);
	$Usuario->insert($prepareStatement, $arrayString);
	echo $params['id'];

}


if($module == 'actEstatusr'){
	$catalogo = $params['catalogo'];

	$prepareStatement = "UPDATE $catalogo SET estatus = ? WHERE id = ?";

	$arrayString = array (
		1,
		$params['id']
	);
	$Usuario->insert($prepareStatement, $arrayString);
	echo $params['id'];

}

if($module == 'grabarRechazo'){
	$catalogo = $params['catalogo'];
	$nombre = $params['rechazo'];
	$descripcion = $params['descripcion'];
	$clave_elavon = $params['clave_elavon'];
	$tipo = $params['tipo'];
	$estatus = 1;
	$rId = $params['rId'];

	if ($rId == '0') 
	{
		$prepareStatement = "INSERT INTO $catalogo (`nombre`, `descripcion`, `clave_elavon`, `tipo`, `estatus`)
						VALUES (?, ?, ?, ?, ?);";

		$arrayString = array(
			$nombre,
			$descripcion,
			$clave_elavon,
			$tipo,
			$estatus
		);

		$newId = $Usuario->insert($prepareStatement,$arrayString);

		$msg = $newId == 1 ? 'Falló al crear el registro' : 'Se creó el registro';

		echo json_encode(['id' => $newId, 'msg' => $msg]);

	}
	else
	{
		$prepareStatement = "UPDATE $catalogo SET `nombre` = ?, `descripcion` = ?, `clave_elavon` = ?, `tipo` = ?
							WHERE `id` = ? 
							";

		$arrayString = array(
			$nombre,
			$descripcion,
			$clave_elavon,
			$tipo,
			$rId
		);

		$newId = $Usuario->insert($prepareStatement, $arrayString);
		$msg = $newId == 1 ? 'Falló al modificar el registro' : 'Se modificó el registro';

		echo json_encode(['id' => $newId, 'msg' => $msg]);

	}


}

if($module == 'getSupervisores') {
$rows = $Usuario->getSupervisores();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == "buscarTecnico") {
	$rows = $Usuario->buscarTecnico($params['term']);

	echo json_encode($rows);
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
    $catalogo = $params['catalogo'];
    $parametroid = $params['parametroid'];
    $statusid = $params['estatusid'] == '1' ? '0' : '1';


    $prepareStatement = "UPDATE $catalogo SET `estatus`=?  WHERE `id`=? ; ";
    $arrayString = array (
        $statusid,
        $parametroid
    );
	
    $id = 	$Usuario->insert($prepareStatement,$arrayString);
    
    echo 1;
}








?>