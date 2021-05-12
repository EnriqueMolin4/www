<?php 
session_start();
include '../modelos/api_db.php';

$connection = $db->getConnection ( 'sinttecom' ); 

//$eventoId = $_POST['eventoId'];
$noserie = $_POST['noserie'];
$tecnico = $_POST['tecnico'];

//$sql = "UPDATE  inventario_tecnico SET aceptada=0  WHERE aceptada=1 and tecnico= ? and no_serie = ? ";


//$Api->insert($sql, array($tecnico,$noserie));

$sql = "UPDATE inventario SET estatus=7 WHERE no_serie = ? and id_ubicacion=? ";

$Api->insert($sql, array($noserie,$tecnico));

echo 1;

?>