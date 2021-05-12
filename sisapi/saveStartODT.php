<?php 
 

include '../modelos/api_db.php';

    $connection = $db->getConnection ( 'dsd' );

    $odt = trim($_POST['odt']);
    $tecnico = $_POST['userid'];
    $afiliacion = $_POST['afiliacion'];
    $horaentrada = $_POST['horaentrada'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $fecha = date ( 'Y-m-d H:m:s' );

            $exist = $Api->existEvento($odt,$afiliacion);

            if($exist) {

                $sql = " UPDATE eventos SET latitud=?,longitud=?,hora_llegada=?,fecha_atencion=?  WHERE id=?";
              
                $Api->insert($sql,  array($latitud,$longitud,$horaentrada,$fecha,$exist));

                $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Hora Inicio', 'odt' => $odt, 'tecnico' => $tecnico ];

            }  else {

                $error = 'No Existe ODT';
                $resultado =  ['status' => 0, 'error' => $error ,'odt' => $odt, 'tecnico' => $tecnico, 'existe' => $exist ];
            }
            


    echo json_encode($resultado);

?>