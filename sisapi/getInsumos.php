<?php 

include '../modelos/api_db.php';


$sqlInsumos = "SELECT id,nombre FROM tipo_insumos WHERE estatus=1 and id != 1";

$insumos = $Api->select($sqlInsumos, array());

echo json_encode(['status' => 1,'insumos' => $insumos]);

?>