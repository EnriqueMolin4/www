<?php 
include '../modelos/api_db.php';


$mensaje = '';
$resultado = 0;

$noguia = $_POST['noguia'];
$today = date('Y-m-d H:i:s');

$resultado =  $Api->getCveBancoTraspasos($noguia);

echo json_encode($resultado);

?>