<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Assignacion implements IConnections {
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
			self::$logger->error ("File: assignacionruta_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: assignacionruta_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: assignacionruta_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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

		if($params['estatusSearch'] !=0 ) {
			$where .= " AND eventos.estatus=".$params['estatusSearch'];
		}
   
    	if($params['tipoevento'] !=0 ) {
			$where .= " AND eventos.servicio=".$params['tipoevento'];
		}
		
		if($_SESSION['tipo_user'] == 'VO' || $_SESSION['tipo_user'] == 'supVO' ) {
			 $where .= " AND eventos.servicio= '15'";
		}


		
		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( odt LIKE '".$params['search']['value']."%' ";    
			$where .=" OR eventos.afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR  eventos.receptor_servicio LIKE '".$params['search']['value']."%' )";

		}


		$sql = "select eventos.id,eventos.odt,eventos.afiliacion,eventos.fecha_cierre,eventos.estatus,
        		CASE WHEN eventos.comercio = '0' THEN eventos.cliente_vo ELSE ANY_VALUE(comercios.comercio)  END NombreComercio,
        		CASE WHEN comercios.tipo_comercio IS NULL THEN 'NA' ELSE getNameById(ANY_VALUE(comercios.tipo_comercio),'TipoComercio') END TipoComercio,
				getNameById(ANY_VALUE(eventos.tecnico),'Tecnico') NombreTecnico   
				from eventos 
				LEFT JOIN comercios ON  eventos.afiliacion = comercios.afiliacion
				WHERE date(eventos.fecha_alta) BETWEEN '$inicio' AND '$fin' 
				AND eventos.estatus = 1
				$where
				 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: assignacionruta_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
		$sql = "select eventos.id,
				eventos.servicio,eventos.odt,eventos.receptor_servicio,eventos.afiliacion,eventos.hora_atencion,eventos.hora_atencion_fin,CONCAT(eventos.hora_atencion,'|',eventos.hora_atencion_fin) hora_general,CONCAT(eventos.hora_comida,'|',eventos.hora_comida_fin) hora_comida,eventos.telefono,eventos.direccion,eventos.fecha_alta,
				eventos.fecha_cierre,eventos.terminal,eventos.descripcion,getNameById(tipo_servicio,'TipoServicio') TipoServicio,getNameById(servicio,'TipoSubServicio') Servicio,
				getNameById(tipo_falla,'TipoFalla') TipoFalla,hora_general,responsable contacto,fecha_asignacion ,fecha_asig_viatico,importe_viatico,
				eventos.estado estadoNombre,
				CASE WHEN eventos.comercio = '0' THEN eventos.cliente_vo  ELSE getNameById(eventos.comercio,'Comercio') END NombreComercio,
				municipio,eventos.colonia ,municipio municipioNombre
				from eventos
				LEFT JOIN comercios  on eventos.afiliacion = comercios.afiliacion
				where eventos.id = $id
				group by eventos.id,eventos.odt,eventos.afiliacion,eventos.hora_comida,eventos.telefono,eventos.direccion,
				eventos.fecha_alta,eventos.fecha_cierre,eventos.terminal,eventos.descripcion,eventos.servicio,tipo_falla,hora_general,
				responsable,fecha_asignacion ,fecha_asig_viatico,importe_viatico ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacionruta_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacionruta_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacionruta_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

}
//
include 'DBConnection.php';
$Assignacion = new Assignacion ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Assignacion->getTable($params,true);
    $rowsTotal = $Assignacion->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getstados') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Assignacion->getEstados();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getevento') {
    
    $rows = $Assignacion->getEvento($params['eventoid']);
     
	

	echo json_encode($rows); //$val;

}



if($module == "getImagenesODT") {
	$estatus = 1;
	$userType = $_SESSION['tipo_user'];
	$odt = $params['odt'];
	$lstImagenes = array();
	$rows = $Assignacion->getImagenesODT($params['odt']);

	if(file_exists('imgs_con/imgs/'.$params['odt'])){
		$odtHistory = $Assignacion->getHistoriaODT($params['odt'],$_SESSION['user']);

		if(sizeof($odtHistory) == 0 ) {
			//insertar a tabla historial_img
		} else {
			$counter = 0;
			foreach($rows as $row ) {
				
				if( $userType == 'admin' || $userType == 'supervisor' || $userType == 'user' || $userType == 'callcenter' ) {
					//Update tabla img donde sea el mismo ODT 
				}

				$lstImagenes[$counter]['path'] = 'modelos/imgs_con/imgs/'.$odt.'/bak_'.$row['dir_img'];
				$lstImagenes[$counter]['imagen'] = $row['dir_img'];
				$lstImagenes[$counter]['revisado'] = $row['revisado'];
				$lstImagenes[$counter]['supervisor'] = $row['supervisor'];
				$lstImagenes[$counter]['tecnico'] = $row['tecnico'];
				$lstImagenes[$counter]['userType'] = $userType;
				$counter++;
			}

		}
	} else {
		$estatus = 0;
	}

	echo json_encode(['estatus' => $estatus, 'imagenes' => $lstImagenes ]);
}

if($module == 'grabarAsignacion') {
	$prepareStatement = "UPDATE `eventos` SET `fecha_asignacion`=?,`tecnico`=?,`fecha_asig_viatico`=?,`importe_viatico`=?,
						`comentarios_asig`=?,`estatus`=? WHERE `id`=? 
						 ;
					";
	$arrayString = array (
			$params['fechaasignacion'],
			$params['tecnico'],
			$params['fechaviatico'],
			$params['importeviatico'],
			$params['comentariosasig'],
      2,
			$params['odtid']
			
	);

	$Eventos->insert($prepareStatement,$arrayString);

	echo $params['odt'];
}


?>