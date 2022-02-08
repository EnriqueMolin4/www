<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$odt = $_POST['odt'];

$servicio = $Api->getServicioIdOdt($odt);

$campos = $Api->getCamposObligatorios($servicio['subservicio']);


echo json_encode($campos);

?>