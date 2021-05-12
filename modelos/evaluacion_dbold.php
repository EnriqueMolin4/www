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

	function getPreguntas()
	{
		//$salida = array();

		$sql = "SELECT * FROM preguntas";

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

if ($module == 'getPreguntasEv') 
{
	
	$salida = array();

	$preguntas = $Evaluacion->getPreguntas();

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
		
	
		echo json_encode($arrayString);
		
		$Evaluacion->insert($prepareStatement, $arrayString);
	}

	//$prepareStatementE = "UPDATE evaluaciones_tecnico SET fin=? WHERE tecnico_id=?";
	//$arrayStringE = array ($fecha_fin, $userT);
	//$Evaluacion->insert($prepareStatementE, $arrayStringE);
	
}
/*
	if ($module == 'inicio_evaluacion') 
	{
		$user = $_SESSION['userid'];
		$evaluacion_id = ['evid'];
		$fecha_inicio = date("Y:m:d H:i:s");
	
		echo '<h5>"'.$user.'"</h5><input type="text">"'.$evaluacion_id.'"</input><input type="text">"'.$fecha.'"</input>';
	}
*/

if ($module == 'subirEvaluacion') 
{
	$user = $_SESSION['userid'];
	$fecha_c = date("Y-m-d H:i:s");

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

/* 
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
 
				$dataFieldsR = array( 'id_pregunta', 'respuesta', 'correcta', 'estatus');
				$question_marksRespuestas = implode(', ', array_fill(0, sizeof($dataFieldsR), '?'));
				$sqlRespuestas = "INSERT INTO respuestas (" . implode(",", $dataFieldsR). ") VALUES (".$question_marksRespuestas.") WHERE id_pregunta = '$idp'";


				$arrayStringR = array (
					$idp,
					$R1->getValue(),
					$R2->getValue(),
					$R3->getValue(),
					$correcta->getValue(),
					1
				);

				array_push($datosCargarR, $arrayStringR);

				echo json_encode($arrayStringR);
				

				//$Evaluacion->insert($sqlRespuestas, $arrayStringR);
				


			}
			else
			{
				echo("ERROR !!!!!");
			}

		}

		echo json_encode(["contador" => $counter, "datos" => $datosCargarP]);
	}
*/
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


				}
				else
				{
					echo("ERROR !!!!!");
				}

			}

			echo json_encode(["contador" => $counter, "datos" => $datosCargarP]);
		}
?>
