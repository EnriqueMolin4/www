<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Plazas implements IConnections {
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
			self::$logger->error ("File: plazas_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: plazas_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
		$territorio = $params['territorio'];

		$filter = "";
		$param = "";
		$where = "";
		 
		if($territorio != '0') {
			$where .= " AND territorio_plaza.territorio_id = $territorio ";
		}

		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( territorios.nombre LIKE '".$params['search']['value']."%' ";  
			$where .="  OR plazas.nombre LIKE '".$params['search']['value']."%' )";   

		}


        $sql = "select  plazas.id,plazas.nombre ,plazas.estatus,GROUP_CONCAT(territorios.nombre) territorio
				FROM plazas
				LEFT JOIN territorio_plaza ON plazas.id = territorio_plaza.plaza_id
				LEFT JOIN territorios ON territorios.id = territorio_plaza.territorio_id
				WHERE plazas.id != 0
				$where
				GROUP BY  plazas.id,plazas.nombre ,plazas.estatus
				$order
				$filter ";

		//self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: plazas_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
		}
	}

	function getTableCP($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
		$plaza = $params['plazas'];

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
			$where .=" ( territorios.nombre LIKE '".$params['search']['value']."%' ";  
			$where .="  OR plazas.nombre LIKE '".$params['search']['value']."%' )";   

		}


        $sql = "SELECT cp,id
				FROM cp_plazas
				WHERE plaza_id = $plaza
				$where
				$order
				$filter ";

		self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: plazas_db.php;	Method Name: getTableCP();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
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
            self::$logger->error ("File: plazas_db.php;	Method Name: getTerritorios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTerritoriosSelected($id) {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "SELECT t.id, t.nombre,IFNULL(total,0) total FROM territorios t
				LEFT JOIN (SELECT territorio_id,COUNT(*)  total FROM territorio_plaza WHERE plaza_id = ? 
				GROUP BY territorio_id) plaza ON t.id = plaza.territorio_id; ";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: plazas_db.php;	Method Name: getTerritorios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: plazas_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: plazas_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: eventos_db.php;	Method Name: buscarComercio();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
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
            self::$logger->error ("File: plazas_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getPlazaDetails($id) {
		
		$sql = "SELECT plaza_id,territorio_id  
				FROM territorio_plaza 
				WHERE plaza_id= ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: plazas_db.php;	Method Name: getPlazaDetails();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }

	}

	function getCPbyPlaza($plaza) {

		$sql = "SELECT id,cp  
				FROM cp_plazas 
				WHERE plaza_id= ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: plazas_db.php;	Method Name: getCPbyPlaza();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

}
//
include 'DBConnection.php';
$Plazas = new Plazas ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Plazas->getTable($params,true);
    $rowsTotal = $Plazas->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getTableCP') {

    $rows = $Plazas->getTableCP($params,true);
    $rowsTotal = $Plazas->getTableCP($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}


if($module == 'getTerritorios') {
	$rows = $Plazas->getTerritorios();
		$val = '<option value="0">Seleccionar</option>';
		foreach ( $rows as $row ) {
			$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
		}
		echo $val;
}
	
if($module == 'getTerritoriosSelected') {
	$rows = $Plazas->getTerritoriosSelected($params['plazaId']);
		 $val = '';
		foreach ( $rows as $row ) {
			$selected = $row['total'] == '0' ? '' : 'selected';
			$val .=  "<option value='".$row ['id'] ."' ".$selected.">" . $row ['nombre'] . "</option>";
		}
		echo $val;
}


if($module == 'getPlazas') {
$rows = $Plazas->getPlazas();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getCPbyPlaza') {
	$rows = $Plazas->getCPbyPlaza($params['plazaId']);

}



if($module == 'addCP') {

    $prepareStatement = "INSERT INTO  `cp_plazas` ( `cp`,`territorio_id`)  VALUES (?,?) ; ";
    $arrayString = array (
            $params['cp'],
            $params['plazas']
    );
	
    $id = 	$Plazas->insert($prepareStatement,$arrayString);
    
    echo 1;
}

if($module == 'cpDelete') {
    $prepareStatement = "DELETE  FROM  `cp_plazas`  WHERE `id`=? ; ";
    $arrayString = array (
            $params['cpid']
    );
	
    $id = 	$Plazas->insert($prepareStatement,$arrayString);
    
    echo 1;
}


if($module == 'plazasMasivo') {
	$counter = 0;
	$plazaNoCargadas = array();
	$plazaYaCargadas = array();
	$eventoMasivo = new CargasMasivas();

	$hojaDeProductos = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
    $FechaAlta = date ( 'Y-m-d H:m:s' );
    $user = $_SESSION['userid'];
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$CP = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$Plaza = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		

		

		$datafields = array('cp','plaza_id','creado_por','fecha_creacion'); 

		$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

		$sqlEvento = "INSERT INTO cp_plazas (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

        $arrayStringEvento = array (
            $CP->getValue(),
            $Plaza->getValue() ,
            $user,
            $FechaAlta
        );
		
        $newId = $Plazas->insert($sqlEvento,$arrayStringEvento);
        
        if($newId != 0) {
            array_push($plazaYaCargadas,["Plaza" => $Plaza->getValue(), "CP" => $CP->getValue() ]);
            $counter++;
            
        } else {
            
            array_push($plazaNoCargadas,$Plaza->getValue());
        }
		
	}
	
	echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "plazaCargados" => $counter, "plazaNoCargadas" => sizeof($plazaNoCargadas),"plazaYaCargadas" => $plazaYaCargadas]);

		
}

if($module == 'getPlazaDetails') {

	$rows = $Plazas->getPlazaDetails($params['plazaId']);

	echo json_encode($rows);

}

if($module == 'saveNewPlaza') {

	$user = $_SESSION['userid'];
	$territorios = json_decode($params['territorios']);
	$plazaid = $params['plazaid'];
	$fecha = date ( 'Y-m-d H:m:s' );

	//DELETE ALL From PLAZA
	$prepareStatement = "DELETE FROM  `territorio_plaza` WHERE   `plaza_id`= ?  ; ";
	$arrayString = array ( $plazaid );
	
	$Plazas->insert($prepareStatement,$arrayString);

	foreach($territorios as $territorio) {

		$prepareStatement = "INSERT INTO  `territorio_plaza` ( `plaza_id`,`territorio_id`,`creado_por`,`fecha_creacion`)  VALUES (?,?,?,?) ; ";
		$arrayString = array (
				$plazaid,
				$territorio,
				$user,
				$fecha
		);
		
		$id = 	$Plazas->insert($prepareStatement,$arrayString);
	} 

	echo 1;
}

if($module == 'saveNewCPPlaza') {

	$cp = $params['cp'];
	$plazaid = $params['plazaid'];
	$fecha = date ( 'Y-m-d H:m:s' );
	$user = $_SESSION['userid'];

	$prepareStatement = "INSERT INTO  `cp_plazas` ( `cp`,`plaza_id`,`creado_por`,`fecha_creacion`)  VALUES (?,?,?,?) ; ";
	
	$arrayString = array (
		$cp,	
		$plazaid,
		$user,
		$fecha
	);
		
	$id = 	$Plazas->insert($prepareStatement,$arrayString);

	echo $id;

}

if($module == 'delCPPlaza') {
	 

	$prepareStatement = "DELETE  FROM  `cp_plazas`  WHERE `id`=? ; ";
    $arrayString = array (
            $params['cpid']
    );
	
    $Plazas->insert($prepareStatement,$arrayString);
    
    echo 1;


}





?>