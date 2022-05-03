<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Territorial implements IConnections {
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
			self::$logger->error ("File: territorial_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: territorial_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }


    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$territorial = $params['territorial'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
        if($territorial == "0") {
            $territorial = "-1";
        }

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
			$where .=" ( cp LIKE '".$params['search']['value']."%' )";    

		}


		$sql = "select cp_territorios.id,cp_territorios.cp,territorios.nombre territorio FROM cp_territorios,territorios
				WHERE  cp_territorios.territorio_id = territorios.id
				AND territorio_id = $territorial
				$where 
				$order
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
		}
	}

	function getTableCP($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
		$territorio = $params['territorio'];

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
			$where .=" ( cp LIKE '".$params['search']['value']."%' ) ";  
			//$where .="  OR plazas.nombre LIKE '".$params['search']['value']."%' )";   

		}


        $sql = "SELECT cp,id
				FROM cp_territorios
				WHERE territorio_id = $territorio
				$where
				$order
				$filter ";

		//self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTableCP();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
		}
	}


	function  getTablePlaza($params,$total) {

		$start = $params['start'];
		$length = $params['length'];
		$territorial = $params['territorial'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
        if($territorial == "0") {
            $territorial = "-1";
        }

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
			$where .=" ( cp LIKE '".$params['search']['value']."%' )";    

		}


		$sql = "select territorio_plaza.id, plazas.nombre plaza FROM territorio_plaza,territorios,plazas
				WHERE  territorio_plaza.territorio_id = territorios.id
				AND territorio_plaza.plaza_id = plazas.id
				AND territorio_id = $territorial
				$where 
				$order
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTablePlaza();	Functionality: Get Table;	Log:".$sql . $e->getMessage () );
		}

	}
	
	function getTableTerritorios($params,$total) {

		$catalogo = $params['catalogo'];

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
			$where .=" ( nombre LIKE '".$params['search']['value']."%' )";    

		}

		
		$sql = " SELECT * FROM $catalogo 
				WHERE nombre IS NOT NULL
				$where
				$order
                $filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTableTerritorios();	Functionality: Get Territorios;	Log:".$sql . $e->getMessage () );
		}
	}

	function getTableCPT($params,$total)
	{
		$start = $params['start'];
		$length = $params['length'];
		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';
		$tid = $params['tid'];

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
			$where .=" ( cpt.cp LIKE '".$params['search']['value']."%' )";    

		}

		
		$sql = " SELECT cpt.id,cpt.cp, cpt.territorio_id, territorios.nombre, cpt.localidad
				FROM cp_territorios cpt
				LEFT JOIN territorios ON territorios.id = cpt.territorio_id
				WHERE cpt.cp IS NOT NULL AND cpt.territorio_id = $tid
				$where
				$order
                $filter ";

        //self::$logger->error($sql);

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTableTerritorios();	Functionality: Get Territorios;	Log:".$sql . $e->getMessage () );
		}
	}

	function getTableSupervisores($params,$total) {

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
			$where .=" ( nombre LIKE '".$params['search']['value']."%' )";    

		}


		$sql = "SELECT cuenta_id id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre 
				FROM cuentas,detalle_usuarios
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.tipo_user = 12 
				$where ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: territorial_db.php;	Method Name: getTableSupervisores();	Functionality: Get Territorios;	Log:".$sql . $e->getMessage () );
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
            self::$logger->error ("File: territorial_db.php;	Method Name: getTerritorios();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "SELECT cuenta_id id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre 
				FROM cuentas,detalle_usuarios
				WHERE cuentas.id = detalle_usuarios.cuenta_id
				AND cuentas.tipo_user = 12 ";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territorial_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getPlazas() {
		//$sql = "select id,user from cuentas  where tipo_user in (1,11) ";
		$sql = "SELECT * 
				FROM plazas ";

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: territorial_db.php;	Method Name: getPlazas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
            self::$logger->error ("File: territorial_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
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
			self::$logger->error ("File: territorial_db.php;	Method Name: buscarTecnico();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
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
            self::$logger->error ("File: territorial_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function searchParam($nombre) {
		$params = $_REQUEST;

		//$module = $params['module'];
		
		$table = $params['catalogo'];

		$sql = "select * from $table where nombre = ? ";

		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($nombre));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: parametros_db.php;	Method Name: searchParam();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

}
//
include 'DBConnection.php';
$Territorial = new Territorial ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Territorial->getTable($params,true);
    $rowsTotal = $Territorial->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getTableCP') {

    $rows = $Territorial->getTableCP($params,true);
    $rowsTotal = $Territorial->getTableCP($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getTablePlaza') {

	$rows = $Territorial->getTablePlaza($params,true);
    $rowsTotal = $Territorial->getTablePlaza($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;

}

if($module == 'getTableTerritorios') {

	$rows = $Territorial->getTableTerritorios($params,true);
    $rowsTotal = $Territorial->getTableTerritorios($params,false);
    $data = array("data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if ($module == 'getCPTerritorios') {
	
	$rows = $Territorial->getTableCPT($params,true);
	$rowsTotal = $Territorial->getTableCPT($params, false);
	$data = array("data"=>$rows,'recordsTotal'=>    count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data);
}


if($module == 'getTerritorios') {
	$rows = $Territorial->getTerritorios();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getSupervisores') {
	$rows = $Territorial->getSupervisores();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getPlazas') {
	$rows = $Territorial->getPlazas();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'addCP') {

    $prepareStatement = "INSERT INTO  `cp_territorios` ( `cp`,`territorio_id`)  VALUES (?,?) ; ";
    $arrayString = array (
            $params['cp'],
            $params['territorial']
    );
	
    $id = 	$Territorial->insert($prepareStatement,$arrayString);
    
    echo 1;
}

if($module == 'cpDelete') {
    $prepareStatement = "DELETE  FROM  `cp_territorios`  WHERE `id`=? ; ";
    $arrayString = array (
            $params['cpid']
    );
	
    $id = $Territorial->insert($prepareStatement,$arrayString);
    
    echo 1;
}


if ($module == 'grabarCatalogo') 
{
	
	$catalogo = $params['catalogo'];
	$nombre = $params['nombre'];
	
	$mensaje = '';
	$valido = 0;

	$existe = $Territorial->searchParam($nombre);
	if ($existe) 
	{
		$mensaje = "El registro ya existe";
		$valido++;
	}
	else
	{
		
		$prepareStatement = "INSERT INTO $catalogo (`nombre`) VALUES (?) ";
		$arrayString = array($nombre);
		$Territorial->insert($prepareStatement, $arrayString);
		$mensaje = "Registro agregado con éxito";

		
	}

	echo json_encode(['existe' => $existe,'msg' => $mensaje, 'valido' => $valido]);

}
	

if($module == 'TerritoriosMasivo') {
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
		$Territorio = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		

		

		$datafields = array('cp','territorio_id','creado_por','fecha_creacion'); 

		$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

		$sqlEvento = "INSERT INTO cp_territorios (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

        $arrayStringEvento = array (
            $CP->getValue(),
            $Territorio->getValue() ,
            $user,
            $FechaAlta
        );
		
        $newId = $Territorial->insert($sqlEvento,$arrayStringEvento);
        
        if($newId != 0) {
            array_push($plazaYaCargadas,["Plaza" => $Plaza->getValue(), "CP" => $CP->getValue() ]);
            $counter++;
            
        } else {
            
            array_push($plazaNoCargadas,$Plaza->getValue());
        }
		
	}
	
	echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "plazaCargados" => $counter, "plazaNoCargadas" => sizeof($plazaNoCargadas),"plazaYaCargadas" => $plazaYaCargadas]);

		
}


if($module == 'cpMasivo') {
	$counter = 0;
	$NoCargadas = array();
	$YaCargadas = array();
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
		$cp = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$territorio = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
		$localidad = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
	
		//$cp = (int) $cp;
		
		/*$datafields = array('cp','territorio_id','localidad'); 

		$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));*/

		$sqlEvento = "INSERT INTO cp_territorios(id,cp,territorio_id,localidad)
						VALUES(NULL,'$cp','$territorio','$localidad')
						ON DUPLICATE KEY
						UPDATE cp = '$cp'
						,territorio_id = '$territorio'
						,localidad = '$localidad' ";

       
		
        $newId = $Territorial->insert($sqlEvento,array());
        
        if($newId != 0) {
            array_push($YaCargadas,["CP" => $cp->getValue(), "Territorial" => $territorio->getValue() ]);
            $counter++;
            
        } else {
            
            array_push($NoCargadas,$cp->getValue());
        }
		
	}
	
	echo json_encode([ "registrosArchivo" =>$numeroMayorDeFila, "Cargados" => $counter, "NoCargadas" => sizeof($NoCargadas),"YaCargadas" => $YaCargadas]);

		
}




?>