<?php 
session_start();
include '../modelos/api_db.php';

$noguia = $_POST['noguia'];
$tecnico = $_POST['tecnico'];


$sql = "SELECT * FROM ( Select
        traspasos.no_guia,
        traspasos.tipo,
        traspasos.no_serie,
        traspasos.fecha_creacion,
        traspasos.cantidad,
        traspasos.tipo_traspaso,
        traspasos.estatus,
        CASE WHEN traspasos.tipo_traspaso = 1 AND traspasos.estatus = 1 THEN 1 WHEN traspasos.tipo_traspaso = 1 AND traspasos.estatus = 0 THEN 0 WHEN traspasos.tipo_traspaso = 0 AND traspasos.estatus = 0  THEN 1   WHEN traspasos.tipo_traspaso = 0 AND traspasos.estatus = 1  THEN 0 END mostrar,
		bancos.banco banco
        FROM traspasos,bancos
        WHERE traspasos.cve_banco = bancos.cve
		AND cuenta_id = $tecnico
        AND no_guia = '$noguia' ) traspasos
        WHERE mostrar = 0 
        ";

       $resultado =  $Api->select($sql,array ());


echo json_encode($resultado);

?>