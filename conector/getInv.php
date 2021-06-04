<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$params = [ 'StatusId'=>'15','PageSize'=>'300'];
$odt = $api->get('provider/api/units',$token->token,$params);

/* $json =  json_encode($odt);
echo $json->message; */
echo $odt->message ." <br>";
$page=1;
$total = $odt->result->meta->totalPages;
$currentPage = $odt->result->meta->page;


foreach($odt->result->data as $inv) {

    
        echo "<p>".$inv->NO_SERIE."</p>";
        echo "<p>".$inv->MODELO."</p>";
        echo "<p>".$inv->MARCA."</p>";
        echo "<p>".$inv->ESTATUS."</p>";
        echo "<p>".$inv->CONECTIVIDAD."</p>";
        echo "<p>".$inv->RESPONSABLE."</p>";
        $existe = $Procesos->existeUniversoElavon($inv->NO_SERIE);

        if($existe) {
            echo "<p>Ya Existe en ELAVON UNIVERSO</p>";

        } else {
            echo "<p>No Existe en ELAVON UNIVERSO</p>";

            //ALINEAR con ctalgo de estatus modelo
            $estatus_modelo = $inv->ESTADO == 'USADA' ? 3 : 5;
            $format = "Y-m-d\TH:i:s";
            $fecha = date('Y-m-d H:i:s');

            $datafieldsSeries = array('serie','fabricante','estatus','estatus_modelo','tipo','fecha_mod','modificado_por');

            $question_marks = implode(', ', array_fill(0, sizeof($datafieldsSeries), '?'));

            $sql = "INSERT INTO elavon_universo (" . implode(",", $datafieldsSeries ) . ") VALUES (".$question_marks.")"; 

            $arrayString = array (
                $inv->NO_SERIE,
                $inv->MARCA,
                'PERTENECE A ELAVON', 
                $estatus_modelo,
                1,
                $fecha,
                1
            );
        
           $Procesos->insert($sql,$arrayString);
        }
    
}





?>