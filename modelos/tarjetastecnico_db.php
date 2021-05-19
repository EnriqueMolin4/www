<?php
session_start();
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('America/Monterrey');
include 'IConnections.php';
class Tarjetas implements IConnections {
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
			self::$logger->error ("File: catalogos_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private static function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: catalogos_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}

    private static function execute_upd($prepareStatement, $arrayString) {
		//self::$logger->error ($prepareStatement." Datos: ".json_encode($arrayString) );

		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			return $stmt->rowCount();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: execute_upd();	Functionality: Insert/Update Eventos;	Log:" . $prepareStatement . " ". $e->getMessage () );
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


		$sql = "SELECT tt.id,
                b.banco banco,
                CONCAT(du.nombre,' ',du.apellidos) tecnico,
                tt.num_tarjeta,
                tt.estatus,
                tt.creado_por 
                FROM tarjeta_tecnico tt
                JOIN detalle_usuarios du ON tt.tecnico_id = du.cuenta_id
                JOIN bancos b ON tt.banco_id = b.id
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

    function getTecnicos() {
		$sql = "SELECT *, cuentas.id tecnicoId 
                from cuentas,detalle_usuarios 
                WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 
				AND cuentas.estatus=1
                order By detalle_usuarios.nombre";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

    function getBancos() {
		$sql = "SELECT * FROM bancos WHERE status=1";
		
		
		try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute ();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: getBancos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

    function validarTarjeta($num)
    {
        $sql = " SELECT * FROM  tarjeta_tecnico WHERE num_tarjeta=? ";

        try {
			$stmt = self::$connection->prepare ($sql );
			$stmt->execute (array($num));
			return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: eventos_db.php;	Method Name: validarTarjeta();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
    }

    

}
//
include 'DBConnection.php';
$Tarjetas = new Tarjetas ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Tarjetas->getTable($params,true);
    $rowsTotal = $Tarjetas->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}


 

if($module == 'grabarTarjeta') {
	
	$format = "Y-m-d H:i:s";
	$createdDate = date ( $format );
    $banco= $params['banco'];
    $tecnico = $params['tecnico'];
    $id = $params['tarjetaId'];
    $numTarjeta = $params['numtarjeta'];
    $user = $_SESSION['userid'];
   

        if($id == '0') {

            $exist = $Tarjetas->validarTarjeta($numTarjeta);

            if(!$exist) {

                $prepareStatement = "INSERT INTO `tarjeta_tecnico`
                            ( `tecnico_id`,`num_tarjeta`,`banco_id`,`estatus`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`)
                            VALUES
                            (?,?,?,?,?,?,?,?);
                        ";
                $arrayString = array (
                    $tecnico,
                    $numTarjeta,
                    $banco,
                    1,
                    $user,
                    $createdDate,
                    $user,
                    $createdDate
                );

                $newId = $Tarjetas->insert($prepareStatement,$arrayString);
                $msg = $newId == 1 ? 'Se asigno la tarjeta con exito' : 'Fallo el registro';

                echo json_encode(['id'=> $newId, 'msg' => $msg, 'fecha_creacion' => $createdDate ]);

            } else {
                echo json_encode(['id'=> 0, 'msg' => 'La Tarjeta ya esta Asignada', 'fecha_modificacion' => $createdDate ]);
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

if($module == 'getBancos') {

    $rows = $Tarjetas->getBancos();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['banco'] . '</option>';
	}
	echo $val;
}

if($module == 'getTecnicos') {

    $rows = $Tarjetas->getTecnicos();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['tecnicoId'] . '">' . $row ['nombre'] .' '. $row ['apellidos']. '</option>';
	}
	echo $val;
}





?>