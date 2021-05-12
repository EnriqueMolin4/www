<?php 
session_start();
include '../modelos/api_db.php';

$noguia = $_POST['noguia'];
$tecnico = $_POST['tecnico'];


$sql = "SELECT * FROM ( Select
        no_guia,
        tipo,
        no_serie,
        fecha_creacion,
        cantidad,
        tipo_traspaso,
        estatus,
        CASE WHEN tipo_traspaso = 1 AND estatus = 1 THEN 1 WHEN tipo_traspaso = 1 AND estatus = 0 THEN 0 WHEN tipo_traspaso = 0 AND estatus = 0  THEN 1   WHEN tipo_traspaso = 0 AND estatus = 1  THEN 0 END mostrar
        FROM traspasos
        WHERE cuenta_id = $tecnico
        AND no_guia = '$noguia' ) traspasos
        WHERE mostrar = 0 
        ";

       $resultado =  $Api->select($sql,array ());


echo json_encode($resultado);

?>