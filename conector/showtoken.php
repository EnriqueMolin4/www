<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
echo $token->token;

?>