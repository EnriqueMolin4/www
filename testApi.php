<?php
include("conector/api.php");
include('modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$params = [ 'StartDate'=>'01/03/2021','EndDate'=>'15/03/2021','IdStatusOdt'=> 3];
//$odt = $api->get('provider/api/odts/GetServicesProvider',$token->token,$params);

//$json =  json_encode($odt->result->data);
//echo $json;
$eventos = $Procesos->getEventosCerrados();

foreach($eventos as $evento ) {

    echo dirname("/img//".$evento['odt']) . PHP_EOL;

}



?>