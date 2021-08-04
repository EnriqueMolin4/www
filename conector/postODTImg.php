<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$format = "Y-m-d\TH:i:s";
$fecha = date('Y-m-d H:i:s');
$odt = $_GET['odt'];
echo $odt;

$eventos = $Procesos->getEventosTecnico($odt);

foreach($eventos as $evento) {
    
        
    $odt = $evento['odt'];
    $idtecnico = $evento['tecnico'];
   
         

    $images = $Procesos->getOdtImages($odt);
     
    $arrayImg = array();
    
    $imagesUp = $api->putImg("gntps/api/files",$token->token,$images,$odt,$idtecnico);

    echo json_encode([ 'img' => $imagesUp]);
    

}


?>