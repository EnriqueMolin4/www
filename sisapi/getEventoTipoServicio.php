<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$odt = $_POST['odt'];

$sql = "SELECT id,nombre FROM eventos WHERE odt=? ";

$evento = $Api->getServicioOdt($odt);



echo json_encode(['evento' => $evento]);

?>