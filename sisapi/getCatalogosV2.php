<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$odt = $_POST['odt'];
$tecnico = $_POST['tecnico'];

$sqlAplicativo = "SELECT id,nombre FROM tipo_aplicativo WHERE estatus=1 ";

$aplicativo = $Api->select($sqlAplicativo, array());

$sqlEvidencias = "SELECT id,nombre FROM tipo_evidencias WHERE status=1 ";

$evidencias = $Api->select($sqlEvidencias, array());

$sqlVersion = "SELECT id,nombre FROM tipo_version WHERE estatus=1 ";

$version = $Api->select($sqlVersion, array());

$odtStatus = $Api->estatusEvento($odt);

$sqlKit = "SELECT kit_detalle.id,kit_detalle.codigo, kit.nombre kitnombre ,kit_detalle.nombre nombre,kit.tipo_servicio tiposervicio,valor, false seleccion  FROM kit ,kit_detalle WHERE kit.id = kit_detalle.kit_id AND kit.tipo_servicio = 1 AND kit.estatus= 1";

$kit = $Api->select($sqlKit, array($odtStatus));

$sqlTPV = "SELECT i.no_serie
FROM inventario i, inventario_tecnico it
WHERE i.no_serie = it.no_serie
AND it.aceptada = 1
AND i.tipo = 1 
AND i.id_ubicacion = it.tecnico
AND i.estatus in (3,5)
AND it.tecnico = ? ";

$tpv = $Api->select($sqlTPV, array($tecnico));

$sqlSIM = "SELECT i.no_serie
FROM inventario i, inventario_tecnico it
WHERE i.no_serie = it.no_serie
AND it.aceptada = 1
AND i.tipo = 2 
AND i.id_ubicacion = it.tecnico
AND it.tecnico = ? ";

$sims = $Api->select($sqlSIM, array($tecnico));

echo json_encode(['status' => 1,'aplicativo' => $aplicativo, 'evidencias' => $evidencias,'version' => $version,'kit' => $kit, 'tpv' => $tpv,'sims'=> $sims]);

?>