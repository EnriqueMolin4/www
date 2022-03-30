<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$odt = $_POST['odt'];
$cve_banco = $Api->getcveBanco($odt);
$servicio = $Api->getServicioIdOdt($odt);

$campos = $Api->getCamposObligatorios($servicio['subservicio'],$cve_banco['cve_banco']);


echo json_encode($campos);

?>