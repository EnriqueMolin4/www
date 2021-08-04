<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$estatus = $_POST['estatus'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];
 
$fechaObtener = date('d/m/Y');
/* $params = [ 'StartDate'=>$fechaIni,'EndDate'=>$fechaFin,'IdStatusOdt'=> $estatus ];
$odtFirst = $api->get('gntps/api/odts/GetServicesProvider',$token->token,$params);
$pageNumber = $odtFirst->result->meta->totalCount; */

$params = [ 'StartDate'=>$fechaIni,'EndDate'=>$fechaFin,'IdStatusOdt'=> $estatus ];
$odt = $api->get('gntps/api/odts/GetServicesProvider',$token->token,$params);

$datos = array();

foreach($odt->result->data as $object) {
    $sinttecom = $Procesos->getDatosSerieSGS($object->ODT);
    $datos[] = [ 'objeto' => $object, 'sinttecom' => $sinttecom ] ;
}

echo json_encode([ 'datos' => $datos,'meta' => $odt->result->meta]);




?>