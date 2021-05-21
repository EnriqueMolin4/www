<?php
session_start();
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Monterrey');
include('../librerias/cargamasivas.php');
include 'IConnections.php';
class Evaluacion implements IConnections {
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
			self::$logger->error ("File: evalucion_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: dashboard_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}

	function getPreguntas($id_tecnico)
	{
		//$salida = array();

		$sql = "SELECT preguntas.id, preguntas.pregunta, preguntas.evaluacion_id FROM preguntas LEFT JOIN evaluaciones_tecnico ON evaluaciones_tecnico.evaluacion_id = preguntas.evaluacion_id WHERE evaluaciones_tecnico.tecnico_id = '$id_tecnico'";
		self::$logger->error($sql);
		try 
		{
			$stmt = self:: $connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC);
		}
		catch ( PDOException $e )
		{
			self::$logger->error ("File: evaluacion_db.php;  	Method Name: getPreguntas();	Functionality: Get questions From Preguntas;	Log:" . $e->getMessage () );
		}
	}

	function getOpciones($pregunta_id)
	{
		$sql = "SELECT * FROM respuestas where id_pregunta = '$pregunta_id' ";

		try 
		{
			$stmt = self:: $connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC);
		}
		catch ( PDOException $e )
		{
			self::$logger->error ("File: evaluacion_db.php;  	Method Name: getOpciones();	Functionality: Get options From respuestas;	Log:" . $e->getMessage () );
		}
	}

	function getTable($params, $total)
	{
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

		if (!empty($params['search']['value']) && $total ) 
		{
			$where .=" AND ";
			$where .=" ( nombre LIKE '".$params['search']['value']."%' ";
			$where .=" OR descripcion LIKE '".$params['search']['value']."%' ) ";
		}

		$sql = " SELECT ev.id, ev.nombre, ev.descripcion, ev.fecha_creacion, ev.archivo, ev.fecha_modificacion 
				FROM `evaluaciones` ev 
				$where
				$order
				$filter
			";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: evaluacion_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

	function getTableTotal() {
		$sql = "select count(*)  from evaluaciones ";
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: evaluacion_db.php;	Method Name: getTableTotal();	Functionality: Get Table Total;	Log:" . $e->getMessage () );
		}
	}

	function evaluacionExiste($nombre)
	{
		$sql = "SELECT * FROM evaluaciones WHERE nombre = '$nombre' ";

		try {
		       	$stmt = self::$connection->prepare ($sql );
		        $stmt->execute ();
		        return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		        } catch ( PDOException $e ) {
		            self::$logger->error ("File: evaluacion_db.php;	Method Name: evaluacionExiste();	Functionality: Get Cliente By Afiliacion;	Log:" . $e->getMessage () );
		        }
	}


	function getTecnicos()
	{
		$sql = "SELECT *, cuentas.id tecnicoId from cuentas,detalle_usuarios WHERE cuentas.id = detalle_usuarios.cuenta_id AND tipo_user = 3 AND estatus = '1' order By detalle_usuarios.nombre";

		try
		{
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		catch ( PDOException $e )
		{
			self::$logger->error("File: evaluacion_db.php;	Method Name: getTecnicos();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
		}
	}

	function getEvaluaciones()
	{
		$sql= "SELECT evaluaciones.id, evaluaciones.nombre, evaluaciones.descripcion FROM evaluaciones";

		try 
		{
			$stmt = self::$connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		catch ( PDOException $e )
		{
			self::$logger->error("File: evaluacion_db.php; Method Name: getEvaluaciones();   Functionality: Search Products; Log:". $sql . $e->getMessage());
		}
	}
	
	function existeAsignacion($id_tecnico, $id_ev)
	{
		$sql = "SELECT * FROM evaluaciones_tecnico WHERE evaluaciones_tecnico.tecnico_id = '$id_tecnico' AND evaluaciones_tecnico.evaluacion_id = '$id_ev'";

		try 
		{
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0);
		} 
		catch ( PDOException $e) 
		{
			self::$logger->error ("File: evaluacion_db.php;	Method Name: existeAsignacion();	Functionality: Search Tecnico;	Log:". $sql . $e->getMessage () );
		}

	}

	function evaluacionValidate($id_tecnico)
	{
		$sql = "SELECT * FROM `evaluaciones_tecnico` WHERE tecnico_id = '$id_tecnico' ";

		try
		{
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return $result = $stmt->fetch ( PDO::FETCH_COLUMN, 0);
		}
		catch (PDOException $e)
		{
			self::$logger->error("File: evaluacion_db.php;  Method Name: evaluacionValidate();  Functionality: Search Ev;   Log: ". $sql . $e->getMessage());
		}
	}

	function getTableDetalle($params, $total)
	{
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

		if( !empty($params['search']['value'])  &&  $total) 
		{
			$where .=" WHERE ";
			$where .=" du.nombre LIKE '".$params['search']['value']."%' ";
			$where .="OR evaluaciones.nombre LIKE '".$params['search']['value']."%' ";

		}

		$sql = "SELECT et.id, et.tecnico_id, CONCAT(du.nombre,' ',ifnull(du.apellidos,'')) nombreTecnico, et.evaluacion_id, evaluaciones.nombre, et.inicio, et.fin
			FROM `evaluaciones_tecnico` et
			LEFT JOIN detalle_usuarios du ON du.cuenta_id = et.tecnico_id
			LEFT JOIN evaluaciones ON evaluaciones.id = et.evaluacion_id
			$where
			$order
			$filter
			";

		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: evaluacion_db.php;	Method Name: getTableDetalle();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}

	}


	function getDetalleEvaluacion($params, $total)
	{
			$start = $params['start'];
			$length = $params['length'];

			$filter = "";
			$param = "";
			$id = $params['id'];
			$where = '';

			if($id == '') {
			$id = -1;
			}
			

			if(isset($start) && $length != -1 && $total) {
				$filter .= " LIMIT  $start , $length";
			}

			if( !empty($params['search']['value'])  &&  $total) 
			{
				$where .=" AND ";
				$where .=" (pr.pregunta LIKE '".$params['search']['value']."%' ";
				$where .=" OR respuestas.respuesta LIKE '".$params['search']['value']."%' )";
			}

			$sql = " SELECT pr.id, pr.pregunta, respuestas.respuesta, respuestas.correcta 
					FROM preguntas pr 
					LEFT JOIN respuestas_tecnico ON pr.id = respuestas_tecnico.pregunta_id
					LEFT JOIN respuestas ON respuestas.id = respuestas_tecnico.respuesta_id 
					LEFT JOIN respuestas r ON r.id = respuestas_tecnico.respuesta_id 
					WHERE respuestas_tecnico.tecnico_id = '$id' 
					$where
					$filter
					";

			try {
				$stmt = self::$connection->prepare ($sql);
				$stmt->execute();
				return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
			} catch ( PDOException $e ) {
				self::$logger->error ("File: evaluacion_db.php;	Method Name: getTableDetalle();	Functionality: Get Table;	Log:" . $e->getMessage () );
			}

	}


	function getTotalEvaluaciones(){
		$sql = "SELECT COUNT(*) total FROM evaluaciones_tecnico WHERE inicio IS NOT NULL AND fin IS NOT NULL";

		try {
			$stmt = self::$connection->prepare($sql);
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e){
			self::$logger->error ("File: evaluacion_db.php;	  Method Name: getTotalEvaluaciones();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		}
	}

	function getNumCorrectas($id_tecnico)
	{
		$sql = "SELECT COUNT(correcta) total
				FROM respuestas
				LEFT JOIN respuestas_tecnico ON respuestas.id = respuestas_tecnico.respuesta_id
				WHERE respuestas.correcta = '1' AND respuestas_tecnico.tecnico_id = '$id_tecnico' ";


		try{
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: evaluacion_db.php;	  Method Name: getNumCorrectas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		}

	}

	function getNumErroneas($id_tecnico)
	{
		$sql = "SELECT count(correcta) totalE
				FROM respuestas
				LEFT JOIN respuestas_tecnico ON respuestas.id = respuestas_tecnico.respuesta_id
				WHERE respuestas.correcta = '0' AND respuestas_tecnico.tecnico_id = '$id_tecnico' ";

			
		try{
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ){
			self::$logger->error ("File: evaluacion_db.php;	  Method Name: getNumCorrectas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
		}
	}

	function getAciertosErroresNum($id_tecnico)
	{
		$sql = "SELECT 'correctas', count(*) total
				FROM respuestas
				LEFT JOIN respuestas_tecnico ON respuestas.id = respuestas_tecnico.respuesta_id
				WHERE respuestas.correcta = '1' AND respuestas_tecnico.tecnico_id = '$id_tecnico'
                
                UNION ALL
                
				SELECT 'incorrectas', count(*) total
				FROM respuestas
				LEFT JOIN respuestas_tecnico ON respuestas.id = respuestas_tecnico.respuesta_id
				WHERE respuestas.correcta = '0' AND respuestas_tecnico.tecnico_id = '$id_tecnico' ";

			self::$logger->error($sql);
			try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: evaluacion_db.php;	Method Name: AciertosErroresNum();	Functionality: Get AciertosErroresNum;	Log:" . $e->getMessage () );
        }
	}


}
//
include 'DBConnection.php';
$Evaluacion = new Evaluacion ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if ($module == 'getTable') 
{
	$rows = $Evaluacion->getTable($params, true);
	$rowsTotal = $Evaluacion->getTableTotal();
	$data = array("draw"=>$_POST["draw"],"data" =>$rows,'recordsTotal' => $rowsTotal, "recordsFiltered" => $rowsTotal);

	echo json_encode($data);
}

if ($module == 'getTableDetalle') 
{
	$rows = $Evaluacion->getTableDetalle($params, true);
	$rowsTotal = $Evaluacion->getTableDetalle($params, false);
	$data = array("draw"=>$_POST['draw'], "data" => $rows, 'recordsTotal'=> count($rowsTotal), "recordsFiltered" => count($rowsTotal));

	echo json_encode($data);
}


if ($module == 'getPreguntasEv') 
{
	$tecnico_id = $_SESSION['userid'];
	$salida = array();

	$preguntas = $Evaluacion->getPreguntas($tecnico_id);

	foreach ($preguntas as $pregunta) 
	{
		$evId = $pregunta['evaluacion_id'];
		$opciones = $Evaluacion->getOpciones($pregunta['id']);
		

		$salida[] = array(
				'id'	  	    =>  $pregunta['id'],
				'id_evaluacion' =>  $pregunta['evaluacion_id'],
				'pregunta'      =>  $pregunta['pregunta'],
				'opciones'	    =>  $opciones
				);
	
	}
	echo json_encode($salida);
	
}


if ($module == 'guardar_evaluacion') 
{
	$preguntas 	=    $params['preguntas'];
	$opciones 	=	 $params['radio'];
	$userT 		=    $_SESSION['userid'];
	$fecha_fin 	=    date("Y-m-d H:i:s");
	$evId 		=    $params['evid'];
	$numbers =  range(0, 50);

	
	for ($i=0; $i < count($preguntas); $i++) 
	{ 
		$pregunta = $preguntas[$i];
		$opcion = $opciones[$i+1];
		$eid = $evId[$i];

		//unset($opcion[0]);

		$prepareStatement = "INSERT INTO respuestas_tecnico (tecnico_id, pregunta_id, respuesta_id, evaluacion_id)
									VALUES (?,?,?,?)";
		
		$arrayString = array(
			$userT, 
			$pregunta,
			$opcion,
			$eid
		);
		
	
		//echo json_encode($arrayString);
		
		$Evaluacion->insert($prepareStatement, $arrayString);
		header("location: ../resultados_tecnico.php");
	}

	//$prepareStatementE = "UPDATE evaluaciones_tecnico SET fin=? WHERE tecnico_id=?";
	//$arrayStringE = array ($fecha_fin, $userT);
	//$Evaluacion->insert($prepareStatementE, $arrayStringE);
	
}

if ($module == 'inicio_evaluacion') 
{
	$user = $_SESSION['userid'];
	//$evaluacion_id = ['evid'];
	$fecha_inicio = date("Y:m:d H:i:s");

	$sql = "UPDATE evaluaciones_tecnico SET inicio=? WHERE tecnico_id=?";

	$array = array ($fecha_inicio, $user);

	$Evaluacion->insert($sql, $array);
	
}

if ($module == 'fin_evaluacion') 
{
	$user = $_SESSION['userid'];
	$fecha_fin = date("Y:m:d H:i:s");

	$sql = "UPDATE evaluaciones_tecnico SET fin=? WHERE tecnico_id=?";

	$array = array ($fecha_fin, $user);

	$Evaluacion->insert($sql, $array);

}


if ($module == 'subirEvaluacion') 
{
	$user = $_SESSION['userid'];
	$fecha_c = date("Y-m-d H:i:s");
	$id = 0;

	$existeEvaluacion = $Evaluacion->evaluacionExiste($params['nombre']);

	if ($existeEvaluacion) 
	{
		echo "LA EVALUACION YA EXISTE";
	}
	else
	{
		//echo "LA EVALUACION NO EXISTE";
		$prepareStatement = "INSERT INTO evaluaciones (nombre,descripcion,fecha_creacion) VALUES (?,?,?);";

			$arrayString = array (
			$params['nombre'],
			$params['descripcion'],
			$fecha_c
			);

		$id = $Evaluacion->insert($prepareStatement, $arrayString);

		if ($id) 
			{

				echo json_encode(['id' => $id]);
				
			}
			else{
				echo "NO SE SUBIÓ LA INFO";
			}
	}
	
}

if ($module == 'evaluacionMasivo') 
{
		$evaluacionMasivo = new CargasMasivas();
		$hojaDeProductos = $evaluacionMasivo->loadFile($_FILES);
		$user = $_SESSION['userid'];
		$consecutivo = 1;
		$counter = 0;
		$insert_values = array();
		$fecha = date ( 'Y-m-d H:m:s' );
		$id = $params['eid'];
		$nombreFile = $_FILES['file']['name'] ;

		$numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
		$letraMayorDeColumna = $hojaDeProductos->getHighestColumn();
		# Convertir la letra al número de columna correspondiente
		$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
		$datosCargarP = array(); 
		$datosCargarR = array();

		for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++)  
		{ 
			# Las columnas están en este orden:
			# Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
			$counter++;
			$Pregunta = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
			$R1 = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
			$R2 = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
			$R3 = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
			$correcta = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);

			$dataFieldsQ = array('evaluacion_id', 'pregunta', 'estatus');
			$question_marksPreguntas = implode(', ', array_fill(0, sizeof($dataFieldsQ), '?'));

			$sqlPreguntas = "INSERT INTO preguntas (" . implode(",", $dataFieldsQ) . ") VALUES (".$question_marksPreguntas.")";

			$arrayStringQ = array (
				$id,
				$Pregunta->getValue(),
				1
			);


			//echo json_encode($arrayStringQ);

			array_push($datosCargarP, $arrayStringQ);

			$idp = $Evaluacion->insert($sqlPreguntas, $arrayStringQ);

			if ($idp) 
			{
				echo("SE GUARDARON LAS PREGUNTAS!!");

				$sqlN = "UPDATE evaluaciones SET archivo=? WHERE id=? ";

				$arraySN = array (
					$nombreFile,
					$id
				);

				$Evaluacion->insert($sqlN, $arraySN);
 				/*
					$dataFieldsR = array( 'id_pregunta', 'respuesta', 'correcta', 'estatus');
					$question_marksRespuestas = implode(', ', array_fill(0, sizeof($dataFieldsR), '?'));


					$sqlRespuestas = "INSERT INTO respuestas (" . implode(",", $dataFieldsR). ") VALUES (".$question_marksRespuestas.") WHERE id_pregunta = '$idp'";

					$arrayStringR = array (
						$idp,
						$R1->getValue(),
						$R2->getValue(),
						$R3->getValue(),
						$correcta->getValue()
					);

					array_push($datosCargarR, $arrayStringR);

					echo json_encode($arrayStringR);
				

				//$Evaluacion->insert($sqlRespuestas, $arrayStringR);
				*/
			}
			else
			{
				echo("ERROR !!!!!");
			}

		}

		echo json_encode(["contador" => $counter, "datos" => $datosCargarP]);
}

//Eliminar Evaluación 
	if ($module == 'delEvaluacion') 
	{
		$prepareStatement = "DELETE FROM evaluaciones WHERE id = ?";

		$arrayString = array ($params['id']);

		$del = $Evaluacion->insert( $prepareStatement, $arrayString );

		if ($del) 
		{
			echo "0";
			
		}
		else
		{
			//echo "1";
			$prepareStatement2 = "DELETE FROM preguntas WHERE evaluacion_id = ?";
			$arrayString2 = array ($params['id']);
			$del2 = $Evaluacion->insert( $prepareStatement2, $arrayString2 );
		}
		
	}

if ($module == 'getTecnicos') 
{
	$rows = $Evaluacion->getTecnicos();
	$val = ' ';
	foreach ($rows as $row) 
	{
		$val .= '<option value ="' . $row['tecnicoId'] . '">' . $row['nombre'] .' '. $row['apellidos'] . '</option>';
	}
	echo $val;
}


if ($module == 'getEvaluaciones') 
{
	$rows = $Evaluacion->getEvaluaciones();
	$val = '<option value="0">Seleccionar</option>';
	foreach ($rows as $row) 
	{
		$val .= '<option value ="' . $row['id'] . '">' . $row['nombre'] .'</option>';
	}
	echo $val;
}


if ($module == 'guardar_asignaciones') 
{
	$user = $_SESSION['userid'];
		
	if ( isset($params['tecnicos']) ) 
	{
		$tecnicos = json_decode($params['tecnicos']);
		//$tecnicos = $params['tecnicos'];
		//$tecnicosList = implode(",", $tecnicos);
		
	}

	if ( isset($params['evaluaciones']) )
	{
		//$evaluaciones = $params['evaluaciones'];
		$evaluaciones = json_decode($params['evaluaciones']);

	}
	

	
	foreach ($tecnicos as $tecnico) 
	{
		//var_dump($tecnico);
		//var_dump($evaluaciones);
		$existeAsig = $Evaluacion->existeAsignacion($tecnico, $evaluaciones);

		$sql = "INSERT INTO evaluaciones_tecnico( tecnico_id, evaluacion_id ) VALUES ( ?,?)";

		$arrayString = array ( $tecnico, $evaluaciones);

		if (!$existeAsig) 
		{
			//Si no existe
			$id = $Evaluacion->insert($sql, $arrayString);
		}
		else
		{
			$id = 0;
			echo "YA EXISTE LA ASIGNACION";
		}	

		if ($id) 
		{
			echo "TRUE";
		}
				else
				{
					echo "FALSE";
				}

	}
	
}

if ($module == 'validar_evaluacion') 
{
	$user = $_SESSION['userid'];
	

	$id = $Evaluacion->evaluacionValidate($user);

	if ($id) 
	{
		//Si existe
		echo json_encode(['id'=> $id]);
		//echo "TRUE";
	}
	else
	{
		//Si no existe
		echo json_encode(['id'=> 0]);
		//echo "FALSE";

	}
	

}

if ($module == 'getDetalleEvaluacion') 
{
	$rows = $Evaluacion->getDetalleEvaluacion($params, true);
	$rowsTotal = $Evaluacion->getDetalleEvaluacion($params, false);
	$data = array("draw"=>$_POST['draw'], "data" => $rows, 'recordsTotal' => count($rowsTotal), "recordsFiltered" =>count($rowsTotal));

	echo json_encode($data);
}

if ($module == 'getTotalEvaluaciones') 
{
	$rows = $Evaluacion->getTotalEvaluaciones();

	$val ='';

	foreach ($rows as $row) {
		$val = $row['total'];
	}
	echo $val;
}

if ($module == 'getCorrectasNum') 
{
	$tecnico = $params['id_tecnico'];

	$rows = $Evaluacion->getNumCorrectas($tecnico);

	$val ='';

	foreach ($rows as $row) {
		$val .= $row['total'];
	}

	echo $val;
}

if ($module == 'getErroneasNum') {
	$tecnico = $params['id_tecnico'];
	$rows = $Evaluacion->getNumErroneas($tecnico);
	$val ='';

	foreach ($rows as $row) {
		$val .= $row['totalE'];
	}

	echo $val;
}


//CHART
//
if ($module == 'aciertosErrores') 
{
	$aciertosErrores = $Evaluacion->getAciertosErroresNum($params['id_tecnico']);

	echo json_encode(['aciertosErrores' => $aciertosErrores]);
}

?>
