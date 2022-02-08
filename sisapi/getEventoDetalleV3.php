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
	if( $resultado[0]['estatus'] == '1' || $resultado[0]['estatus'] == '2') {
		$query  = " UPDATE eventos SET tecnico=?,hora_llegada=?,estatus=?  WHERE odt=?";
		$arrayinput = array($userid,$hora,2,$odt);
	} else {
	  $query  = " UPDATE eventos SET tecnico=?,estatus=?  WHERE odt=?";
	  $arrayinput = array($userid,2,$odt);
	}
	  $Api->insert($query ,$arrayinput);
} else if( $resultado[0]['tecnico'] != $userid   ) {
	$resultado = null;
}

	if( $resultado[0]['estatus'] == '1' || $resultado[0]['estatus'] == '2') {
		$query  = " UPDATE eventos SET tecnico=?,hora_llegada=?,estatus=?  WHERE odt=?";
		$arrayinput = array($userid,$hora,2,$odt);
	} else {
	  $query  = " UPDATE eventos SET tecnico=?,estatus=?  WHERE odt=?";
	  $arrayinput = array($userid,2,$odt);
	}
	
	$Api->insert($query ,$arrayinput);

$tpvComercio = $Api->getTpvComercio($odt);
$imgOdt = $Api->getImagefromOdt($odt);


echo json_encode(['resultado' => $resultado, 'tpvComercio' => $tpvComercio, 'imgs' => $imgOdt ]);
//echo json_encode($resultado);

?>