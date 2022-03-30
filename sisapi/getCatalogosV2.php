<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$odt = $_REQUEST['odt'];
$tecnico = $_REQUEST['tecnico'];
$odtServicios =  $Api->getServicioOdt( $odt );

$cve_banco = $Api->getcveBanco($odt);

$sqlAplicativo = "SELECT id,nombre FROM tipo_aplicativo WHERE estatus=1 and cve_banco=?";

$aplicativo = $Api->select($sqlAplicativo, array($cve_banco['cve_banco']));
array_unshift($aplicativo,["id" => 0,"nombre" => 'Seleccionar Aplicativo']);

$sqlEvidencias = "SELECT id,nombre FROM tipo_evidencias WHERE status=1 ";

$evidencias = $Api->select($sqlEvidencias, array());
array_unshift($evidencias,["id" => 0,"nombre" => 'Seleccionar']);

$sqlVersion = "SELECT id,nombre FROM tipo_version WHERE estatus=1 and cve_banco=?  ";

$version = $Api->select($sqlVersion, array($cve_banco['cve_banco']));
//array_unshift($version,["id" => 0,"nombre" => 'Seleccionar Version']);

$odtStatus = $Api->estatusEvento($odt);

$sqlKit = "SELECT kit_detalle.id,kit_detalle.codigo, kit.nombre kitnombre ,kit_detalle.nombre nombre,kit.tipo_servicio tiposervicio,valor, false seleccion  FROM kit ,kit_detalle WHERE kit.id = kit_detalle.kit_id AND kit.tipo_servicio = 1 AND kit.estatus= 1";

$kit = $Api->select($sqlKit, array($odtStatus));

//Mostrar TPV dependiendo del tipo de servicio
// 0 == sin filtro 1 solo nuevas , 2 solo usadas
$whereTPV = '';

if ( $odtServicios['tipo_terminal'] == '1'  )
{
    $whereTPV= ' AND i.estatus= 5 ';
} else if ( $odtServicios['tipo_terminal'] == '2' ) {
    $whereTPV= ' AND i.estatus= 3 ';
} else {
    $whereTPV= ' AND i.estatus IN (3,5) ';
}

$sqlTPV = "SELECT i.no_serie
FROM inventario i, inventario_tecnico it
WHERE i.no_serie = it.no_serie
AND it.aceptada = 1
AND i.tipo = 1 
AND i.id_ubicacion = it.tecnico
$whereTPV
AND it.tecnico = ? 
AND it.cve_banco = ? ";



$tpv = $Api->select($sqlTPV, array($tecnico,$cve_banco['cve_banco']));

$sqlTpvComercio = " SELECT no_serie FROM inventario where id_ubicacion IN (
    Select comercio from eventos where odt = ? )
    AND ubicacion= 2
    AND tipo=1 
	AND cve_banco=?";

$tpvComercio = $Api->select($sqlTpvComercio, array($odt,$cve_banco['cve_banco']));


$sqlSIM = "SELECT i.no_serie
FROM inventario i, inventario_tecnico it
WHERE i.no_serie = it.no_serie
AND it.aceptada = 1
AND i.tipo = 2 
AND i.id_ubicacion = it.tecnico
AND it.tecnico = ? 
AND i.cve_banco=?";

$sims = $Api->select($sqlSIM, array($tecnico,$cve_banco['cve_banco']));

$sqlCausas = "SELECT id,nombre FROM tipo_causas_cambio";

$causas = $Api->select($sqlCausas,array() );
array_unshift($causas,["id" => 0,"nombre" => 'Seleccionar']);

echo json_encode(['status' => 1,'aplicativo' => $aplicativo, 'evidencias' => $evidencias,'version' => $version,'kit' => $kit, 'tpv' => $tpv,'sims'=> $sims, 'tpvComercio' => $tpvComercio,'causas'=> $causas, 'cvebanco' => $cve_banco['cve_banco'] ]);

?>