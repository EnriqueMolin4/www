<?php 
session_start();
date_default_timezone_set('America/Monterrey');

include '../modelos/DBConnection.php';

    
    $connection = $db->getConnection ( 'dsd' );

    $odt = trim($_POST['odt']);
    $afiliacion = trim($_POST['afiliacion']);
    $fecha = date ( 'Y-m-d H:m:s' );
    $tecnico = $_POST['userid'];
    $realImage = $_FILES['photo']['tmp_name'];
    $fileName = $_POST['name'];
    $comentarios = $_POST['comentarios'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $cve_banco = $_POST['cve_banco'];
    //$estatus = $_POST['estatus'];
    $tipoevidencia = $_POST['tipoevidencia'];
   
    
    $folder = $_SERVER["DOCUMENT_ROOT"].'/img/'.$odt;

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    try {
            $moveImage = move_uploaded_file($realImage, $folder.'/'.$fileName);
        if( $moveImage ) {
            
            //Existe el Evento
            $queryexist = "SELECT id from eventos where odt = ? ";
            
            $stmt = $connection->prepare ($queryexist);
            $stmt->execute (array($odt));
			$exist =  $stmt->fetchColumn();
            
            if($exist) {

                $stmt = $connection->prepare (" UPDATE eventos SET latitud=?,longitud=?,tecnico=? WHERE id=?");
                $stmt->execute ( array($latitud,$longitud,$tecnico,$exist) );
                $newId = $exist;

            } else {
                //Grabar Evento 
                $datafields = array('odt','afiliacion','cve_banco','fecha_alta','fecha_atencion','comentarios','tipo_servicio','servicio','estatus','tecnico'); 

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
                    $estatus,
                    $tecnico
                 
                );
            
                $stmt = $connection->prepare ( $sqlEvento );
                $stmt->execute ( $arrayStringEvento );
                $stmt = $connection->query("SELECT LAST_INSERT_ID()");
                $newId =  $stmt->fetchColumn();
            }
            
            //Grabar Registro de Imagen
            $prepareStatement = "INSERT INTO `img`  ( `odt`,`fecha`,`dir_img`,`revisado`,`tecnico`,`tipo`,`clasificador`)
            VALUES
            (?,?,?,?,?,?,?);";
                $arrayString = array (
                    $odt,
                    $fecha,
                    $fileName,
                    0,
                    $tecnico,
                    1,
                    $tipoevidencia
                );

            $stmt = $connection->prepare ( $prepareStatement );
            $stmt->execute ( $arrayString );
			$stmt = $connection->query("SELECT LAST_INSERT_ID()");
			$newId =  $stmt->fetchColumn();

            $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Imagen', 'odt' => $odt, 'afiliacion' => $afiliacion ];

        } else {
             
            $resultado =  ['status' => 0, 'error' => 'No Se subio el archivo ' ];
        }
    
        

    } catch (Exception $e) {
        $error = 'File did not upload: ' . $e->getMessage();
        $resultado =  ['status' => 0, 'error' => $error ,'odt' => $odt, 'afiliacion' => $afiliacion ];
    }


    echo json_encode($resultado);

?>