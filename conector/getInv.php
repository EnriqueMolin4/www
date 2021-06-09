<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$params = [ 'StatusId'=>'17','PageSize'=>'300'];
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
        $existeInv = $Procesos->existeInventario($inv->NO_SERIE);

        $estatus_modelo = $inv->ESTADO == 'USADA' ? 3 : 5;
        if($inv->MARCA != 'SIM') {

            $modelo = $Procesos->getModeloId($inv->MODELO);
            $conectividad = $Procesos->getConectividadId($inv->CONECTIVIDAD);
            $tipo= 1;

        } else {
            $modelo = $Procesos->getCarrierId($inv->MODELO);
            $conectividad = 0;
            $tipo=2;
        }
        $format = "Y-m-d\TH:i:s";
        $fecha = date('Y-m-d H:i:s');

        if($existe) {
            echo "<p>Ya Existe en ELAVON UNIVERSO</p>";

        } else {
            echo "<p>No Existe en ELAVON UNIVERSO</p>";

            //ALINEAR con ctalgo de estatus modelo
           

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
        
          // $Procesos->insert($sql,$arrayString);
        }

        if( $existeInv) {

            $sql = "UPDATE inventario 
                        SET  modelo=?,conectividad=?,tipo=?,fecha_edicion=?
                        WHERE no_serie=?" ;
            $arrayString = array (
                $modelo['id'],
                $conectividad['id'],
                $tipo,
                $fecha,
                $inv->NO_SERIE
            );

          //  $id =  $Procesos->insert($sql,$arrayString);

        } else {
            $prepareStatement = "INSERT INTO `inventario`
						( `tipo`,`cve_banco`,`no_serie`,`modelo`,`conectividad`,`estatus`,`estatus_inventario`,
						`cantidad`,`ubicacion`,`creado_por`,`fecha_entrada`,`fecha_creacion`,`fecha_edicion`,`modificado_por`)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					";
            $arrayString = array (
                    $tipo,
                    '037',
                    $inv->NO_SERIE,
                    $modelo['id'],
                    $conectividad['id'],
                    $estatus_modelo,
                    1,
                    1,
                    1,
                    1,
                    $fecha,
                    $fecha,
                    $fecha,
                    1
            );

         //   $Procesos->insert($prepareStatement,$arrayString);
        }
}
    






?>