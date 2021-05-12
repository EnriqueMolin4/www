<?php 
include '../modelos/api_db.php';

//$eventoId = 13 ; //$_POST['eventoId'];
$odt = $_POST['odt'];
$userid = $_POST['userid'];

$resultado =  $Api->getEventoDetalle($odt,$userid);

if($resultado[0]['tecnico'] == '0') {
	  $query  = " UPDATE eventos SET tecnico=?,estatus=?  WHERE odt=?";
	  $Api->insert($query ,array($userid,2,$odt));
} else if( $resultado[0]['tecnico'] != $userid   ) {
	$resultado = null;
}


echo json_encode($resultado);

?>