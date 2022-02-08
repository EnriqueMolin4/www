<?php 
include '../modelos/api_db.php';

//$eventoId = 13 ; //$_POST['eventoId'];
$odt = $_POST['odt'];
$userid = $_POST['userid'];
$hoy = strtotime("now");
$fecha = date ('Y-m-d H:i:s',$hoy );
$hora = date ('H:i:s',$hoy );

$resultado =  $Api->getEventoDetalle($odt,$userid);

if($resultado[0]['tecnico'] == '0') {
	
	switch ( $resultado[0]['estatus_servicio'] ) {
		case '13':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '14':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '15':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '16':
			$newStatus = 2;		
		break;
		
	}
	
	$query  = " UPDATE eventos SET tecnico=?,hora_llegada=?,estatus=?  WHERE odt=?";
	$arrayinput = array($userid,$hora,$newStatus,$odt);
	
	$Api->insert($query ,$arrayinput);
	
} else if( $resultado[0]['tecnico'] != $userid   ) {
	$resultado = null;
	
} else {

	switch ( $resultado[0]['estatus_servicio'] ) {
		case '13':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '14':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '15':
			$newStatus = 3;
			$hora = $resultado[0]['hora_llegada'];
		break;
		case '16':
			$newStatus = 2;		
		break;
		
	}
	
	$query  = " UPDATE eventos SET tecnico=?,hora_llegada=?,estatus=?  WHERE odt=?";
	$arrayinput = array($userid,$hora,$newStatus,$odt);
	
	$Api->insert($query ,$arrayinput);
}

//$tpvComercio = $Api->getTpvComercio($resultado[0]['comercioid'] );


//echo json_encode(['resultado' => $resultado, 'tpvComercio' => $tpvComercio ]);
echo json_encode($resultado);

?>