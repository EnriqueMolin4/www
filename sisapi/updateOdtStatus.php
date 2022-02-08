<?php 

include '../modelos/api_db.php';

$odt = $_REQUEST['odt'];
$estatus = $_REQUEST['estatus'];
$msg = ' Se Hizo el Precierre (EN VALIDACION) ';
$counter = 0;
$hoy = strtotime("now");
$fecha = date ('Y-m-d H:i:s',$hoy );
	
$result = json_encode([ 'odt' => $odt, 'estatus' => $estatus, 'fecha' => $fecha ]);
//Save odt
file_put_contents("json/precierre_$odt.json",$result);

$sql = "UPDATE eventos SET estatus=? WHERE odt=?";

$resultado =  $Api->insert($sql,array ($estatus,$odt));
$eventoData = $Api->getEventoData($odt);
 
 //Grabar Historico Eventos
			 $datafieldsEventos = array('evento_id','fecha_movimiento','estatus_id','odt','modified_by'); 

			$question_marksEvento = implode(', ', array_fill(0, sizeof($datafieldsEventos), '?'));
			$sqlHist = "INSERT INTO historial_eventos (" . implode(",", $datafieldsEventos ) . ") VALUES (".$question_marksEvento.")";
			
			$arrayStringHistoria = array(
				$eventoData['id'],
				$fecha,
				$estatus,
				$odt,
				$eventoData['tecnico']
			);
			
			$Api->insert($sqlHist,$arrayStringHistoria);
		

 echo json_encode(['msg' => $msg, 'estatus' => 1, 'evento' => $arrayStringHistoria]);
?>