<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Validaciones implements IConnections {
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
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: validaciones_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: validaciones_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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


    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

		$inicio = $params['fechaVen_inicio'];
		$fin = $params['fechaVen_fin'];


   
    	if($params['tipoevento'] !=0 ) {
			$where .= " AND eventos.servicio=".$params['tipoevento'];
		}
		
		if($_SESSION['tipo_user'] == 'VO') {
			 $where .= " AND eventos.servicio= '15'";
		}

		if($_SESSION['tipo_user'] == 'supVO') {
			 $where .= " AND eventos.servicio= '15'";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( eventos.odt LIKE '".$params['search']['value']."%' ";    
			$where .=" OR eventos.afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR ts.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR te.nombre LIKE '".$params['search']['value']."%'  )";

		}


		$sql = "select eventos.*,
				ts.nombre servicioNombre, 
				te.nombre validacionNombre,
				u.nombre tecnicoNombre 
				from eventos 
				LEFT JOIN detalle_usuarios u ON u.cuenta_id = tecnico
				LEFT JOIN tipo_estatus te ON te.id = eventos.estatus
				LEFT JOIN tipo_servicio ts ON ts.id = eventos.tipo_servicio
				WHERE eventos.estatus in (10)
				AND date(eventos.fecha_alta) BETWEEN '$inicio' AND '$fin' 
				$where
				group by eventos.id ,u.nombre,u.apellidos 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: validaciones_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:". $e->getMessage () );
		}
	}

    function getEvento($id) {
		$sql = "select eventos.*,
				CASE WHEN eventos.comercio = '0' THEN cliente_vo  ELSE c.comercio END NombreComercio,
				te.nombre EstatusValidacion,
				ts.nombre TipoServicio,
				tss.nombre TipoSubServicio,
				tf.nombre TipoFalla,
				du.nombre tecnicoNombre,
				CASE WHEN cast(eventos.municipio AS UNSIGNED) = 0 THEN eventos.municipio ELSE getNameById(eventos.municipio,'Municipio') END ciudadNombre ,
				CASE WHEN cast(eventos.estado AS UNSIGNED) = 0 THEN eventos.estado ELSE  getNameById(eventos.estado,'Estado') END estadoNombre,
				(SELECT count(id) llamadas from eventos_validacion where evento_id = eventos.id ) llamadas 
				from eventos 
				LEFT JOIN tipo_servicio ts ON ts.id = eventos.tipo_servicio
				LEFT JOIN tipo_subservicios tss ON tss.id = eventos.servicio
				LEFT JOIN tipo_falla tf ON tf.id = tipo_falla
				LEFT JOIN comercios c ON c.id = eventos.comercio
				LEFT JOIN tipo_estatus te ON te.id = estatus_validacion
				LEFT JOIN detalle_usuarios du ON du.cuenta_id = eventos.tecnico
				where eventos.id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: validaciones_db.php;	Method Name: getComercio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function gethistoriavalidacion($id) {
		$sql = "select getNameById(estatus,'EstatusValidacion') Estatus, fecha_llamada,hora_llamada,comentarios from eventos_validacion where evento_id='$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: validaciones_db.php;	Method Name: gethistoriavalidacion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' and tipo=1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: validaciones_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: validaciones_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	
	function getStatusValidacion() {
		$sql = " SELECT id, nombre   
			FROM tipo_estatus
			WHERE  tipo= 5 ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: validaciones_db.php;	Method Name: getStatusValidacion();	Functionality: Get Estatus Validacion;	Log:" . $e->getMessage () );
        }
	}

}
//
include 'DBConnection.php';
$Validacion = new Validaciones ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Validacion->getTable($params,true);
    $rowsTotal = $Validacion->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getstados') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Validacion->getEstados();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getevento') {
    
    $rows = $Validacion->getEvento($params['eventoid']);
     
	echo json_encode($rows);

}

if($module == "getImagenesODT") {
	$estatus = 1;
	$userType = $_SESSION['tipo_user'];
	$odt = $params['odt'];
	$lstImagenes = array();
	$rows = $Validacion->getImagenesODT($params['odt']);

	if(sizeof($rows) > 0 && file_exists($_SERVER["DOCUMENT_ROOT"].'/img/'.$params['odt'])){
		$odtHistory = $Validacion->getHistoriaODT($params['odt'],$_SESSION['user']);

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
				$counter++;
			}

		//}
	} else {
		$estatus = 0;
	}

	echo json_encode(['estatus' => $estatus, 'imagenes' => $lstImagenes ]);
}



if($module == "saveValidacion") {
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );
	$creado = 0;
	$prepareStatement = "INSERT INTO `eventos_validacion` ( `evento_id`,`estatus`,`fecha_llamada`,`hora_llamada`,`comentarios`)
						VALUES (?,?,?,?,?); ";

	$arrayString = array (
			$params['eventoid'],
			$params['statusval'],
			$params['fechallamada'],
			$params['horallamada'],
			$params['comentariosvalidacion']	
	);
		
	$creado =  $Validacion->insert ( $prepareStatement, $arrayString );

	//Actualizar el campo de estatus_validacion de la tabla eventos
	if($creado != 0 ) {
		$prepareStatement = "UPDATE `eventos` SET `estatus_validacion`=? WHERE `id`=? ";

		$arrayString = array (
			$params['statusval'],
			$params['eventoid']	
		);
			
		$Validacion->insert ( $prepareStatement, $arrayString );
	}

	echo $creado;
}

if($module == "imgValidacion") {
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );
  	$user = $user = $_SESSION['userid'];

	$prepareStatement = "UPDATE  `img` SET revisado = 1,fecha_modificacion = ?, supervisor=? WHERE id =?; ";

	$arrayString = array (
       $createdDate,
       $user,
       $params['idImg']	
	);
		
	$Validacion->insert ( $prepareStatement, $arrayString );

	echo 1;
}

if($module == 'imgDelete') {
	$prepareStatement = "DELETE FROM  `img` WHERE id =?; ";

	$arrayString = array (
       $params['idImg']	
	);
		
	$Validacion->insert ( $prepareStatement, $arrayString );

	echo 1;

}

if($module == "getStatusValidacion") {
	$val = '<option value="0">Seleccionar</option>';
	$rows = $Validacion->getStatusValidacion();

	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == "gethistoriavalidacion") {
	$rows = $Validacion->getHistoriaValidacion($params['eventoid']);
	echo json_encode($rows);
}



?>