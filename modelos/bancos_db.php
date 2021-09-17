<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Bancos implements IConnections {
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
	private static function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `bancos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bancos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bancos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}

    private static function execute_upd($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			return $stmt->rowCount();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bancos_db.php;	Method Name: execute_upd();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
		}
	}

	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function update($prepareStatement, $arrayString) {
		return self::execute_upd ( $prepareStatement, $arrayString);
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

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( odt LIKE '".$params['search']['value']."%' ";    
			$where .=" OR eventos.afiliacion LIKE '".$params['search']['value']."%' ";
			$where .=" OR  eventos.receptor_servicio LIKE '".$params['search']['value']."%' )";

		}


		$sql = "SELECT * FROM bancos
				$where
				$filter ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bancos_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function validarCVE($cve,$id) {

        $where = '';

        if($id != '0') {
            $where .= 'AND id = ?';
        }

        $sql = "SELECT id,cve FROM bancos WHERE cve= ? $where ";

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute(array($cve,$id));
			return  $stmt->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: bancos_db.php;	Method Name: validarCVE;	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
    }

}
//
include 'DBConnection.php';
$Bancos = new Bancos ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Bancos->getTable($params,true);
    $rowsTotal = $Bancos->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}


 

if($module == 'grabarBanco') {
	
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );
    $banco= $params['banco'];
    $cve = $params['cve'];
    $id = $params['bancoId'];
    $user = $_SESSION['userid'];
   

        if($id == '0') {

            $existCVE = $Bancos->validarCVE($cve,$id);

            if($existCVE) {

                $prepareStatement = "INSERT INTO `bancos`
                            ( `banco`,`cve`,`tipo`,`estatus`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`)
                            VALUES
                            (?,?,?,?,?);
                        ";
                $arrayString = array (
                    $banco,
                    $cve,
                    'rep',
                    1,
                    $user,
                    $createdDate,
                    $user,
                    $createdDate
                );

                $newId = $Bancos->insert($prepareStatement,$arrayString);
                $msg = $newId == 1 ? 'Se creo el banco con exito' : 'Fallo al crear  el banco';

                echo json_encode(['id'=> $newId, 'msg' => $msg, 'fecha_creacion' => $createdDate ]);

            } else {
                echo json_encode(['id'=> 0, 'msg' => 'La clave de Banco ya Existe', 'fecha_modificacion' => $createdDate ]);
            }
        } else {

            $existCVE = $Bancos->validarCVE($cve,$id);

            if($existCVE ) {
                
                    $prepareStatement = "UPDATE  `bancos` SET  
                        `banco`=?,`cve`=?,`modificado_por`=?,`fecha_modificacion` =? 
                        WHERE `id` = ?
                    ";
                    $arrayString = array (
                        $banco,
                        $cve,
                        $user,
                        $createdDate,
                        $id
                    );

                    $newId = $Bancos->update($prepareStatement,$arrayString);
                    $msg = $newId == 1 ? 'Se modifico el banco con exito' : 'Fallo al modificar el banco';

                    echo json_encode(['id'=> $newId, 'msg' => $msg, 'fecha_modificacion' => $createdDate ]);

            } else {
                echo json_encode(['id'=> 0, 'msg' => 'La clave de Banco ya Existe', 'fecha_modificacion' => $createdDate ]);
            }
        }
   
}





?>