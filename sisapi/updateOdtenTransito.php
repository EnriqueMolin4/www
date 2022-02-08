<?php 

include '../modelos/api_db.php';
$odt = $_POST['odt'];
$tecnico = $_POST['tecnico'];
$estatus= 0;
$sql = "SELECT id from eventos where tecnico=410 AND estatus=20 ";
$exist = $Api->select($sql,$tecnico);

if(!$exist) {

    $sqlOdt = "UPDATE eventos SET estatus=20 WHERE  odt= ? ";
    $odts =  $Api->insert($sqlOdt,array ($odt));
    $estatus = 1;
}


 
 echo json_encode([ 'estatus' => $estatus ]);

?>