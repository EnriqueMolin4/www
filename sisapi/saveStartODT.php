<?php 
 

include '../modelos/api_db.php';

    $connection = $db->getConnection ( 'dsd' );
	
	$result = json_encode($_POST);
    $odt = trim($_POST['odt']);
	
	file_put_contents("json/insertSE_$odt.json",$result);
	
    $odt = trim($_POST['odt']);
    $tecnico = $_POST['userid'];
    $afiliacion = $_POST['afiliacion'];
    $horaentrada = $_POST['horaentrada'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $hoy = strtotime("now");
	$fecha = date ('Y-m-d H:i:s',$hoy );
	$horaentrada = date('H:i:s', $hoy);
    $estatus = $_POST['estatus'];

            $exist = $Api->existEvento($odt,$afiliacion);

            if($exist) {

                $sql = " UPDATE eventos SET latitud=?,longitud=?,hora_llegada=?,fecha_atencion=?,estatus=?  WHERE id=?";
              
                $Api->insert($sql,  array($latitud,$longitud,$horaentrada,$fecha,$estatus,$exist));

                $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Hora Inicio', 'odt' => $odt, 'tecnico' => $tecnico ];

            }  else {

                $error = 'No Existe ODT';
                $resultado =  ['status' => 0, 'error' => $error ,'odt' => $odt, 'tecnico' => $tecnico, 'existe' => $exist ];
            }
            


    echo json_encode($resultado);

?>