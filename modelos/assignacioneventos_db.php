<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/cargamasivas.php');
include 'IConnections.php';
class Assignacion implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection ( 'sinttecom' ); ( 'dsd' );
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
			self::$logger->error ("File: assignacioneventos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: assignacioneventos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }


    function getMunicipios($estado) {
		$sql = "SELECT * from municipios where estado=? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($estado));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getMunicipios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$typeUser = $_SESSION['tipo_user'];

		$userId = $params['supervisores'];

		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
		$where = "";

		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}
		
		if($_SESSION['tipo_user'] != 'admin' || $_SESSION['tipo_user'] != 'supervisor' ) {
			if($params['supervisores'] != '0') {
				$where .= " AND territorial.territorio_id = $userId " ;
			} else {
				$where .= " AND territorial.territorio_id = -1 " ;
			}
		}

		$inicio = $params['fechaVen_inicio'];
		$fin = $params['fechaVen_fin'];

				
		if($params['tipoevento'] !=0 ) {
			$where .= " AND eventos.servicio=".$params['tipoevento'];
		}

		

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" (eventos.odt LIKE '".$params['search']['value']."%' ";    
			$where .=" OR eventos.afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR  eventos.receptor_servicio LIKE '".$params['search']['value']."%')";

		}

		 if ($params['ciudade'] != '0' ) 
		{
			$where .= " AND territorial.ciudad LIKE '".$params['ciudade']."%'";
			
		}

		$sql = "SELECT eventos.id,eventos.odt,eventos.afiliacion,eventos.fecha_vencimiento,tipo_estatus.nombre estatus,eventos.comercio comercio_id,eventos.estado,
				 territorial.NombreComercio,
				CASE WHEN territorial.tipo_comercio IS NULL THEN 'NA' ELSE getNameById(territorial.tipo_comercio,'TipoComercio') END TipoComercio ,territorial.cp, territorial.ciudad
				from eventos 
				LEFT JOIN tipo_estatus ON eventos.estatus = tipo_estatus.id
				INNER JOIN (  select cp_territorios.territorio_id,cp_territorios.cp,comercios.ciudad, comercios.comercio NombreComercio,comercios.tipo_comercio,comercios.afiliacion FROM cuentas,cp_territorios,comercios
				WHERE cuentas.territorial = cp_territorios.territorio_id 
				AND tipo_user =12 AND comercios.cp = cp_territorios.cp 
				GROUP BY cp_territorios.territorio_id, cp_territorios.cp,comercios.ciudad,comercios.comercio, comercios.tipo_comercio, comercios.afiliacion) territorial ON territorial.afiliacion = eventos.afiliacion
				WHERE date(eventos.fecha_alta) BETWEEN '$inicio' AND '$fin' AND eventos.estatus IN (1,16)
				$where
				$order
				$filter ";
		
		//self::$logger->error($sql);
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
		$sql = "select eventos.id,eventos.rollos_instalar,
				eventos.servicio,eventos.odt,eventos.receptor_servicio,eventos.afiliacion,eventos.hora_comida,eventos.telefono,eventos.direccion,eventos.fecha_alta,
				eventos.fecha_cierre,eventos.terminal,eventos.descripcion,getNameById(tipo_servicio,'TipoServicio') TipoServicio,getNameById(servicio,'TipoSubServicio') Servicio,
				getNameById(tipo_falla,'TipoFalla') TipoFalla,hora_general,responsable contacto,fecha_asignacion ,fecha_asig_viatico,importe_viatico,
				CASE WHEN cast(eventos.estado AS UNSIGNED) = 0 THEN eventos.estado ELSE GetNameById(eventos.estado,'Estado') END estadoNombre,
				CASE WHEN eventos.comercio = '0' THEN eventos.cliente_vo  ELSE getNameById(eventos.comercio,'Comercio') END NombreComercio,
				municipio,eventos.colonia ,
				CASE WHEN cast(municipio AS UNSIGNED) = 0 THEN  municipio ELSE GetNameById(municipio,'Municipio') END municipioNombre
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
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function buscarTecnico($search) {

		$sql = "SELECT du.nombre,du.apellidos from cuentas,detalle_usuarios du
				WHERE cuentas.id = du.cuenta_id
				and cuentas.tipo_user=1
				AND (du.apellidos = '%$search%' OR du.nombre LIKE '%$search%')
				Group by du.id ";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: assignacioneventos_db.php;	Method Name: buscarTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getTecnicosbyId($userId) {
		//$userId = $_SESSION['userid'];
		
		
		
		$sql = "SELECT cuentas.id,du.nombre,du.apellidos from cuentas,detalle_usuarios du
				WHERE cuentas.id = du.cuenta_id
				and cuentas.tipo_user=3 
				and cuentas.id = $userId 
				ORDER BY du.nombre,du.apellidos ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getTecnicosbyId();	Functionality: Get Tecnicos x supervisor;	Log:" . $e->getMessage () );
        }
	}

	function getTecnicos($userId) {
		//$userId = $_SESSION['userid'];
		if($userId == '0') {
			$userId = -1;
			}

		$sql = "SELECT cuentas.id,du.nombre,du.apellidos from cuentas,detalle_usuarios du
				WHERE cuentas.id = du.cuenta_id
				and cuentas.tipo_user=3 
				and cuentas.territorial = $userId 
				ORDER BY du.nombre,du.apellidos ";

		//self::$logger->error($sql);
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getTecnicos();	Functionality: Get Tecnicos x supervisor;	Log:" . $e->getMessage () );
        }
	}
	
	
	function getTecnicosS($user) {
		
		$sql = "SELECT cuentas.id,du.nombre,du.apellidos from cuentas,detalle_usuarios du
				WHERE cuentas.id = du.cuenta_id
				and cuentas.tipo_user=3 
				ORDER BY du.nombre,du.apellidos ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getTecnicosS();	Functionality: Get Tecnicos x supervisor;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {

		$user = $_SESSION['userid'];
		$where = "";
		

		if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'supervisor' ) {
			
		} else {
			$where .= " AND cuentas.id =  $user ";
		}

		$sql = "SELECT cuentas.id,du.nombre,du.apellidos,cuentas.territorial from cuentas,detalle_usuarios du
				WHERE cuentas.id = du.cuenta_id
				and cuentas.tipo_user=12 
				$where
				ORDER BY  du.nombre
				 ";
		//self::$logger->error ($sql);
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: getSupervisores();	Functionality: Get Supervisores;	Log:" . $e->getMessage () );
        }
	}

	function existeEvento($odt) {
		$sql = "SELECT id,tecnico,estatus  FROM eventos WHERE odt = '$odt' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: assignacioneventos_db.php;	Method Name: existeEvento();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
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

if($module == 'getEstados') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Assignacion->getEstados();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getMunicipios') {
	
	$rows = $Assignacion->getMunicipios($params['estado']);
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['nombre'] . '">' . $row ['nombre'] . '</option>';
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

	$Assignacion->insert($prepareStatement,$arrayString);

	echo $params['odt'];
}

if($module == 'buscarTecnico') {
	$rows = $Assignacion->buscarTecnico($params['term']);

	echo json_encode($rows);
}

if($module == 'getTecnicos') {
	$rows = $Assignacion->getTecnicos($params['supervisores']);
	$options = '<option value="0">Seleccionar Tecnico</option>';
	foreach($rows as $row) {
		$options .= '<option value="'.$row['id'].'">'.$row['nombre'].' '.$row['apellidos'].'</option>';
	}
	echo $options;
}

if($module == 'getTecnicosS') {

	$rows = $Assignacion->getTecnicosS();
	$options = '<option value="0">Seleccionar Tecnico</option>';
	foreach($rows as $row) {
		$options .= '<option value="'.$row['id'].'">'.$row['nombre'].' '.$row['apellidos'].'</option>';
	}
	echo $options;
}

if($module == 'getSupervisores') {
	$rows = $Assignacion->getSupervisores();
	$options = '<option value="0" selected>Seleccionar Supervisor</option>';
	$selected = "";
	foreach($rows as $row) {

	
		$options .= '<option value="'.$row['territorial'].'" '.$selected.'>'.$row['nombre'].' '.$row['apellidos'].'</option>';
	}
	echo $options;
}

if($module == 'eventoMasivoAssignacion') {
	$counter = 0;
	$odtNoCargadas = array();
	$odtCargadas = array();
	$odtYaCargadas = array();
	$odtYaAsignadas = array();
	$eventoMasivo = new CargasMasivas();
	$user = $_SESSION['userid'];
	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);
	
	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$FechaAlta = date('Y-m-d');
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$Tecnico = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$ODT = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		
		
		


		$existeEvento = $Assignacion->existeEvento($ODT);


		if($existeEvento) {

			if( $existeEvento[0]['estatus'] == '1' || $existeEvento[0]['estatus'] == '16') {
				$now = date("Y-m-d H:i:s");
				$sqlEvento = "UPDATE  eventos  SET tecnico=?,estatus=?,fecha_asignacion=? WHERE id=? ";

				$arrayStringEvento = array (
					$Tecnico->getValue(),
					2,
					$now,
					$existeEvento[0]['id']
				);
			
				$newId = $Assignacion->insert($sqlEvento,$arrayStringEvento);
				
				//HISTORIAL_EVENTOS
					$sqlHistorial = "INSERT INTO historial_eventos SET evento_id=?,fecha_movimiento=?,estatus_id=?,odt=?,modified_by=?";
					
					$arrayStringHistoria = array(
						$existeEvento[0]['id'],
						$now,
						2,
						$ODT,
						$user	
					);
					
					$Assignacion->insert($sqlHistorial, $arrayStringHistoria);
				//
				
				$counter++;

				array_push($odtCargadas,$ODT->getValue());
				
			}  else { 
				$tecnico = $Assignacion->getTecnicosbyId($existeEvento[0]['tecnico']) ;
				$nombreTecnico = sizeof($tecnico) > 0 ? $tecnico[0]['nombre'] : '';
				array_push($odtYaAsignadas,$ODT->getValue()." Tecnico  ".$existeEvento[0]['tecnico']." ".$nombreTecnico);
			} 
			 
		}   else {
			array_push($odtNoCargadas,$ODT->getValue());
		}
	}
	
	echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "registrosCargados" => $counter, "odtCargadas" => $odtCargadas, "odtNoCargadas" => $odtNoCargadas,'odtYaAsignadas' =>$odtYaAsignadas]);

		
}

if($module == 'AsignarTecnicos') {

	$eventos = json_decode($params['odt']);
	$count= 0;
	$fecha = date ( 'Y-m-d H:m:s' );
	$user = $_SESSION['userid'];
	foreach($eventos as $evento) {
		
		$sqlEvento = "UPDATE  eventos  SET  tecnico=?,estatus=?,fecha_asignacion=?  WHERE odt=? ";

		$arrayStringEvento = array (
			$evento->Tecnico,
			2,
			$fecha,
			$evento->ODT
		);

		$newId = $Assignacion->insert($sqlEvento,$arrayStringEvento);
		
		
		$sqlHist = "INSERT INTO historial_eventos SET evento_id=?,fecha_movimiento=?,estatus_id=?,odt=?,modified_by=?";
		
		$arrayStringHistoria = array(
			$evento->ID,
			$fecha,
			2,
			$evento->ODT,
			$user
		);
		
		$Assignacion->insert($sqlHist,$arrayStringHistoria);
		
		$count++;
	}

	echo $count;
}