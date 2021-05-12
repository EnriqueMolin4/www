<?php 

include '../modelos/api_db.php';

$tecnico = $_POST['tecnico'];

$resultado =  $Api->getTraspasosTecnico($tecnico);


echo json_encode($resultado);

?>