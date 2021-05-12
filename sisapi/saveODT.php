<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../modelos/DBConnection.php';

    $connection = $db->getConnection ( 'dsd' );

    $odt = trim($_POST['odt']);
    $afiliacion = trim($_POST['afiliacion']);
    $fecha = date ( 'Y-m-d H:m:s' );
    $tecnico = $_POST['userid'];
    $comentarios = $_POST['comentarios'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $cve_banco = $_POST['cve_banco'];
    $tpv_retirado = $_POST['tvpsalida'];
    $tvp_instalado = $_POST['tvpentrada'];

    try {
      
            //Existe el Evento
            $queryexist = "SELECT id from eventos where odt = ? ";
            
            $stmt = $connection->prepare ($queryexist);
            $stmt->execute (array($odt));
			$exist =  $stmt->fetchColumn();
            
            if($exist) {

                $stmt = $connection->prepare (" UPDATE eventos SET latitud=?,longitud=?,tecnico=?,fecha_alta=?,fecha_atencion=?,comentarios=?,tpv_retirado=?,tpv_instalado=? WHERE id=?");
                $stmt->execute ( array($latitud,$longitud,$tecnico,$fecha,$fecha,$comentarios,$tpv_retirado, $tvp_instalado,$exist) );
               

            } else {
                //Grabar Evento 
                $datafields = array('odt','afiliacion','cve_banco','fecha_alta','fecha_atencion','comentarios','tipo_servicio','servicio','estatus','tecnico','tpv_retirado','tpv_instalado'); 

                $question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

                $sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

                $arrayStringEvento = array (
                    $odt ,
                    $afiliacion ,
                    $cve_banco,
                    $fecha, 
                    $fecha,
                    $comentarios,
                    22,
                    68,
                    2,
                    $tecnico,
                    $tpv_retirado,
                    $tvp_instalado
                );
            
                $stmt = $connection->prepare ( $sqlEvento );
                $stmt->execute ( $arrayStringEvento );
                $stmt = $connection->query("SELECT LAST_INSERT_ID()");
                $newId =  $stmt->fetchColumn();
            }
            
            $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Imagen', 'odt' => $odt, 'afiliacion' => $afiliacion ];

        
    } catch (Exception $e) {
        $error = 'Informacio de ODT no se cargo: ' . $e->getMessage();
        $resultado =  ['status' => 0, 'error' => $error ,'odt' => $odt, 'afiliacion' => $afiliacion ];
    }


    echo json_encode($resultado);

?>