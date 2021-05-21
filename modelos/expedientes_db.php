<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Expedientes implements IConnections {
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
			self::$logger->error ("File: expedientes_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: expedientes_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
    }
    
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

    }
    
    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$filter = "";
		$param = "";
		$where = "";

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( e.nombre LIKE '".$params['search']['value']."%' ";    
			$where .=" OR e.correo LIKE '".$params['search']['value']."%' ";
			$where .=" OR e.curp LIKE '".$params['search']['value']."%' ";
            $where .=" OR e.rfc LIKE '".$params['search']['value']."%'  ";
            $where .=" OR e.nss LIKE '".$params['search']['value']."%'  ";
            $where .=" OR e.escolaridad LIKE '".$params['search']['value']."%'  ";
            $where .=" OR e.puesto LIKE '".$params['search']['value']."%' ) ";

		}
    
     

		$sql = "SELECT * FROM expedientes e
				$where
				order by e.id 
				$filter ";

		//self::$logger->error ($sql);
		//self::$logger->error($sql);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: expedientes_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}
	

    function getExpediente($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: expedientes_db.php;	Method Name: getComercio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
  

}
//
include 'DBConnection.php';
$Catalogos = new Expedientes ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Catalogos->getTable($params,true);
    $rowsTotal = $Catalogos->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}



if($module == 'getConectividad') {
    $val = '<option value="0">Seleccionar</option>';
    $rows = $Catalogos->getConectividad();
    foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['cve']. " - ".$row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'saveExpediente') {
	$nombre = $params["exp_nombre"];
	$fechaIngreso = $params["doc_ingreso"];
	$fechaAlta = $params["doc_alta"];
	$capacitacion = $params["doc_capacitacion"];
	$fechaUniforme = $params["doc_uniforme"];
	$talla = $params["doc_talla"];
	$curriculum = isset($params["doc_curriculum"]) ? 1 : 0 ;
	$acta = isset($params["doc_acta"]) ? 1 : 0 ;
	$curp = isset($params["doc_curp"]) ? 1 : 0 ;
	$indentidad = isset($params["doc_ident"]) ? 1 : 0 ;
	$domicilio = isset($params["doc_domicilio"]) ? 1 : 0 ;
	$nss = isset($params["doc_nss"]) ? 1 : 0 ;
	$rfc = isset($params["doc_rfc"]) ? 1 : 0 ;
	$laboral = isset($params["doc_laboral"]) ? 1 : 0 ;
	$personal = isset($params["doc_personal"]) ? 1 : 0 ;
	$referencias = isset($params["doc_referencias"]) ? 1 : 0 ;
	$infonavit = isset($params["doc_infonavit"]) ? 1 : 0 ;
	$cartasegtrabajo = isset($params["doc_segtrabajo"]) ? 1 : 0 ;
	$imss = isset($params["doc_imss"]) ? 1 : 0 ;
	$nomina = isset($params["doc_nomina"]) ? 1 : 0 ;
	$contratolaboral = isset($params["doc_contratolaboral"]) ? 1 : 0 ;
	$confidencialidad = isset($params["doc_confidencialidad"]) ? 1 : 0 ;
	$reglamento = isset($params["doc_reglamento"]) ? 1 : 0 ;
	$psicometrico = isset($params["doc_psicometrico"]) ? 1 : 0 ;
	$evaluacion = isset($params["doc_evaluacion"]) ? 1 : 0 ;
	$antidoping = isset($params["doc_antidoping"]) ? 1 : 0 ;
	$conciliacion = isset($params["doc_conciliacion"]) ? 1 : 0 ;
	$menores = isset($params["doc_menores"]) ? 1 : 0 ;
	$banco = $params["doc_banco"];
	$cuenta = $params["doc_cuenta"];
	$clabe = $params["doc_clabe"];
	$tarjeta = $params["doc_tarjeta"];
	$beneficiario = $params["doc_nombrebeneficiario"];
	$parentesco = $params["doc_parentesco"];
	$rfcbeneficiario = $params["doc_rfcbeneficiario"];
	$curp = $params["doc_curpbeneficiario"];
	$fechabaja = $params["doc_fechabaja"];
	$motivonaja = $params["doc_motivobaja"];
	$reingreso = $params["doc_reingreso"];
	$acta = $params["doc_acta"];

			
	echo json_encode(["data" => $params]);
}

if($module == 'grabarModelo') {
	
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );

	if($params['modeloid'] == '0') {
    		$prepareStatement = "INSERT INTO `modelos`
						( `modelo`,`proveedor`,`conectividad`,`no_largo`,`estatus`)
						VALUES
						(?,?,?,?,?);
					";
			$arrayString = array (
					$params['modelo'],
					$params['proveedor'],
					$params['conectividad'],
					$params['no_largo'] ,
					1
			);

			$id = $Catalogos->insert($prepareStatement,$arrayString);

			echo json_encode(['id'=> $id, 'fecha_creacion' => $createdDate ]);
	} else {

            $prepareStatement = "UPDATE  `modelos` SET  
                `modelo`=?,`proveedor`=?,`conectividad`=?,`no_largo`=?,`estatus`=?  
                 WHERE `id` = ?
            ";
            $arrayString = array (
                $params['modelo'],
                $params['proveedor'],
                $params['conectividad'],
                $params['no_largo'] ,
                $params['estatus'] ,
                $params['modeloid']
            );

            $id = $Catalogos->insert($prepareStatement,$arrayString);

		    echo json_encode(['id'=> 0, 'fecha_modificacion' => $createdDate ]);
	}
}





?>