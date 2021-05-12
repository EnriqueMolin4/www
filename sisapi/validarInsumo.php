<?php 
session_start();
include '../modelos/api_db.php';


$mensaje = '';
$resultado = 0;

$noguia = $_POST['noguia'];
$tecnico = $_POST['tecnico'];
$tipo = $_POST['tipo'];
$qty = (int) $_POST['cantidad'];
$today = date('Y-m-d H:i:s');

$resultado =  $Api->existInsumoInventarioTecnico($noguia,$tecnico,$tipo);


if( $resultado == 0) {
	
	$mensaje = 2;
	
} else {
	if( $qty == (int) $resultado) {
		
		$sql = "UPDATE traspasos SET estatus = 1,ultima_act = '$today'
		where no_guia = '$noguia'
		AND cuenta_id = '$tecnico'
		AND no_Serie = '$tipo' ";
		

		$Api->insert($sql,array());
		
		$sql = "UPDATE inventario_tecnico SET aceptada = 1,fecha_modificacion= '$today'
		where tecnico = '$tecnico'
		AND no_serie = '$tipo' ";
		
		$Api->insert($sql,array());
		
		$IdTraspasos = $Api->getIdTraspaso($noguia,$tecnico,$tipo);
		
		$fecha = date ( 'Y-m-d H:m:s' );
		$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion');
		
		$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
		$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
	
		$arrayString = array (
			$IdTraspasos,
			$fecha,
			'ACEPTADO',
			9,
			$tipo,
			3,
			$qty,
			$tecnico
		);
		
		$Api->insert($sql,$arrayString);
		
		$mensaje = 1;
		
	} else {
		$mensaje = 0;
	}
}

echo  $mensaje;

?>