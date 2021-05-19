<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/cargamasivas.php');
include 'IConnections.php';
class Inventarios implements IConnections {
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
			self::$logger->error ("File: sfa_ordersdmin_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: sfa_ordersdmin_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
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
            self::$logger->error ("File: comercios_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

    
    function getInvTpv($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( no_serie LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ubicacion LIKE '".$params['search']['value']."%'  ";
			$where .=" OR fabricante LIKE '".$params['search']['value']."%'  ";
			$where .=" OR conect LIKE '%".$params['search']['value']."%'  ";
			$where .=" OR modelo_tpv LIKE '".$params['search']['value']."%' ) ";
		}


		$sql = "select *,getNameById(modelo_tpv,'Modelo') modeloNombre,getNameById(fabricante,'Proveedor') fabricanteNombre,
				CASE WHEN ubicacion = 1 THEN 'ALMACEN GENERAL'
				WHEN ubicacion = 2 THEN getNameById(id_ubicacion,'Tecnico')
				WHEN ubicacion = 3 THEN getNameById(id_ubicacion,'Comercio') END ubicacionNombre,
				getNameById(conect,'Conectividad') conectNombre from almacen
                WHERE producto= '1'
				$where
				group by id 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
    }
    
    function getInvSim($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( no_serie LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ubicacion LIKE '".$params['search']['value']."%'  ";
			$where .=" OR carrier LIKE '".$params['search']['value']."%' ) ";
		}


        $sql = "select *,getNameById(carrier,'Carrier') carrierNombre,getNameById(ubicacion,'Almacen') almacenNombre from almacen
                WHERE producto= '2'
				$where
				group by id 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getInvInsumos($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( insumos LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ubicacion LIKE '".$params['search']['value']."%' ) ";
		}


		$sql = "select *,getNameById(ubicacion,'Almacen') almacenNombre, getNameById(insumo,'TipoInsumo') insumoNombre 
				from almacen
                WHERE producto= '3'
				$where
				group by id 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getHistoricoTpv($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( tipo_movimiento LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ubicacion LIKE '".$params['search']['value']."%' ) ";
		}


		$sql = "select *,
				CASE WHEN ubicacion = 1 THEN 'ALMACEN GENERAL'
				WHEN ubicacion = 2 THEN 'Tecnico'
				WHEN ubicacion = 3 THEN 'Comercio' END ubicacionNombre,
				id_ubicacion 
				from historial
				WHERE ( producto= '1' OR  producto = 'TPV' )
				AND no_serie = ? 
				$where
				group by id 
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute(array( $params['noSerie']));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getHistoricoTpv();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getHistoricoInsumos($params,$total) {
		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

	

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( tipo_movimiento LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ubicacion LIKE '".$params['search']['value']."%' ) ";
		}


		$sql = "select historial.id,historial.cantidad,historial.fecha_movimiento,historial.tipo_movimiento, 
				almacen.producto,almacen.insumo,
				CASE WHEN historial.ubicacion = 1 THEN 'ALMACEN GENERAL'
				WHEN historial.ubicacion = 2 THEN 'Tecnico'
				WHEN historial.ubicacion = 3 THEN 'Comercio' END ubicacionNombre,
				tipo_insumos.nombre insumoNombre,
				historial.id_ubicacion 
				from historial,tipo_insumos,almacen
				WHERE ( almacen.producto= '3' OR  almacen.producto = 'Insumos' )
				AND almacen.id= ?
				AND almacen.insumo = tipo_insumos.id
				AND almacen.id = historial.no_serie
				$where
				group by historial.id 
				$filter
				";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute(array( $params['noSerie']));
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: comercios_db.php;	Method Name: getHistoricoTpv();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getCantidadInsumos($insumo) {
		$sql = "select id,cantidad from almacen where id = ? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($insumo));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getCantidadInsumos();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getFabricanteByName($fabricante) {
		$sql = "select id from tipo_proveedor_equipos where nombre LIKE '%$fabricante%' ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getFabricanteByName();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getConectividadByName($fabricante) {
		$sql = "select id from tipo_conectividad where nombre LIKE '%$fabricante%' ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getConectividadByName();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getModeloByName($modelo) {
		$sql = "select id from modelos where modelo LIKE '%$modelo%' ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getModeloByName();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function existeEquipo($NumSerie) {
		$sql = "select id from inventario where no_serie =? ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($NumSerie));
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: existeEquipo();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getUbicacionByName($Ubicacion) {
		$sql = "select id from tipo_ubicacion where nombre LIKE '%$Ubicacion%' ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: catalogos_db.php;	Method Name: getUbicacionByName();	Functionality: Get Insumos quantity;	Log:" . $e->getMessage () );
        }
	}

	function getTecnicos() {
		$sql = "SELECT *, cuentas.id tecnicoId from cuentas,detalle_usuarios WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 order By detalle_usuarios.nombre";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

}
//
include 'DBConnection.php';
$Inventarios = new Inventarios ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getInvSim') {

    $rows = $Inventarios->getInvSim($params,true);
    $rowsTotal = $Inventarios->getInvSim($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getInvTpv') {

    $rows = $Inventarios->getInvTpv($params,true);
    $rowsTotal = $Inventarios->getInvTpv($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getHistoricoTpv') {

    $rows = $Inventarios->getHistoricoTpv($params,true);
    $rowsTotal = $Inventarios->getHistoricoTpv($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getInvInsumos') {

    $rows = $Inventarios->getInvInsumos($params,true);
    $rowsTotal = $Inventarios->getInvInsumos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getHistoricoInsumos') {

    $rows = $Inventarios->getHistoricoInsumos($params,true);
    $rowsTotal = $Inventarios->getHistoricoInsumos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'traspasar') {

	$fecha_alta = date("Y-m-d H:i:s");
	$user = $_SESSION['userid'];
  	$tipoTraspaso = '';
  
	$prepareStatement = "INSERT INTO `historial`
		( `fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
		VALUES (?,?,?,?,?,?,?); ";
            
    switch($params['hacia']) {
      case "1":
      $tipoTraspaso = 'ALMACENES';
      break;
      case "2":
      $tipoTraspaso = 'TECNICOS';
      break;
      case "3":
      $tipoTraspaso = 'COMERCIO';
      break;
      case "4":
      $tipoTraspaso = 'LABORATORIO';
      break;
      default:
      $tipoTraspaso = 'Error';
      
    }
    
		$arrayString = array (
				$fecha_alta,
				$tipoTraspaso,
				$params['hacia'],
				$params['noserie'],
				$params['producto'],
				$params['cantidad'],
				$params['tecnico'] 
		);
	
		$id = $Inventarios->insert($prepareStatement,$arrayString);

		$prepareStatement = "UPDATE `almacen` set `ubicacion` = ?, `tipo_ubicacion` = ?, `id_ubicacion` = ? where `no_serie` = ? ";

		$arrayString = array (
			$params['hacia'],
			$params['hacia'],
			$params['tecnico'],
			$params['noserie']
		);

		$Inventarios->insert($prepareStatement,$arrayString);

		echo json_encode(['id'=> $id,  'fecha_alta' => $fecha_alta ]);
}

if($module == 'traspasarinsumos') 
	{

		$fecha_alta = date("Y-m-d H:i:s");
		$user = $_SESSION['userid'];
		  $tipoTraspaso = '';
	  
		$prepareStatement = "INSERT INTO `historial`
			( `fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`producto`,`cantidad`,`id_ubicacion`)
			VALUES (?,?,?,?,?,?,?); ";
				
		switch($params['hacia']) {
		  case "1":
		  $tipoTraspaso = 'ALMACENES';
		  break;
		  case "2":
		  $tipoTraspaso = 'TECNICOS';
		  break;
		  case "3":
		  $tipoTraspaso = 'COMERCIO';
		  break;
		  case "4":
		  $tipoTraspaso = 'LABORATORIO';
		  break;
		  default:
		  $tipoTraspaso = 'Error';
		  
		}
		
		$arrayString = array (
				$fecha_alta,
				$tipoTraspaso,
				$params['hacia'],
				$params['producto'],
				$params['insumo'],
				$params['cantidad'],
				$params['tecnico'] 
		);
	
		$id = $Inventarios->insert($prepareStatement,$arrayString);

		if($id > 0 ) {
			$inventario = $Inventarios->getCantidadInsumos($params['producto']) ;

			$total = (int)$inventario[0]['cantidad'] - (int)$params['cantidad'];

			$prepareStatement = "UPDATE `almacen` set `cantidad` = ?  where `id` = ? ";

			$arrayString = array (
				$total,
				$params['producto']
			);

			$Inventarios->insert($prepareStatement,$arrayString);

		}

		echo json_encode(['id'=> $id,  'fecha_alta' => $fecha_alta ]);
}

if($module == 'getTecnicos') {
	
	$rows = $Inventarios->getTecnicos();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnicoId'] . '">' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}

if($module == 'inventarioCargaMasiva') {
	$counter = 0;
	$counterEdit = 0;

	$inventarioMasivo = new CargasMasivas();

	$hojaDeProductos = $inventarioMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	
	$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
		# Las columnas están en este orden:
		# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
		$FechaEntrada = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
		$FechaEntradaFinal = $FechaEntrada->getFormattedValue();
		$Fabricante = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
		$Conectividad = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
		$Modelo = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
		$Anaquel = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
		$Caja = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
		$Tarima = $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
		$SerieGenerica = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);
		$NumSerie = $hojaDeProductos->getCellByColumnAndRow(10, $indiceFila);
		$Ubicacion = $hojaDeProductos->getCellByColumnAndRow(12, $indiceFila);
		$EstatusUbicacion = $hojaDeProductos->getCellByColumnAndRow(13, $indiceFila);

	
		$FechaEntradaFinal = date("Y-m-d", strtotime($FechaEntradaFinal));
		//$FechaVencimiento =  date('Y-m-d H:m:s', strtotime('+23 hour',strtotime($FechaVencimiento)) );
		//Buscar Id de Catalogos
		$Modelo = $Inventarios->getModeloByName($Modelo);
		$Ubicacion = $Inventarios->getUbicacionByName($Ubicacion);



		$existeEvento = $Inventarios->existeEquipo($NumSerie);


		if($existeEvento > 0 ) {
			$sqlInv = "UPDATE inventario SET  modelo= ?,serie_generica= ?,anaquel= ?,
			caja= ?,tarima= ?,estatus= ?,ubicacion= ?,fecha_entrada= ?,
			fecha_creacion= ?,fecha_edicion=? WHERE id = ?";

			$arrayStringInv = array (
				$Modelo,
				$SerieGenerica->getValue() ,
				$Anaquel->getValue() ,
				$Caja->getValue(),
				$Tarima->getValue(),
				$EstatusUbicacion->getValue(),
				$Ubicacion,
				$FechaEntradaFinal,
				$fecha,
				$fecha,
				$existeEvento
			);

			$Inventarios->insert($sqlInv,$arrayStringInv);
			$counterEdit++;
						
			 
		} else {

			$datafields = array('no_serie','modelo','serie_generica','anaquel','caja','tarima','estatus','ubicacion',
			'fecha_entrada','fecha_creacion','fecha_edicion'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

			$sqlInv = "INSERT INTO inventario (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

			$arrayStringInv = array (
				$NumSerie->getValue(),
				$Modelo,
				$SerieGenerica->getValue() ,
				$Anaquel->getValue() ,
				$Caja->getValue(),
				$Tarima->getValue(),
				$EstatusUbicacion->getValue(),
				$Ubicacion,
				$FechaEntradaFinal,
				$fecha,
				$fecha
			);
		
			$newId = $Inventarios->insert($sqlInv,$arrayStringInv);
			$counter++;
			
		}
	}
	$totalRegistros = $numeroMayorDeFila -1;
	 
	echo json_encode([ "registrosArchivo" =>$totalRegistros, "registrosCargados" => $counter, "registrosEditados" => $counterEdit]);

		
}
?>