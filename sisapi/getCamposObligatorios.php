<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$servicio = $_POST['servicioid'];

$campos = $Api->getCamposObligatorios($servicio);


echo json_encode($campos);

?>