<?php
date_default_timezone_set('America/Monterrey');

include '../modelos/api_db.php';

    

    $odt = trim($_POST['odt']);
    $afiliacion = trim($_POST['afiliacion']);
	$hoy = strtotime("now");
	$fecha = date ('Y-m-d H:i:s',$hoy );
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

   
        $moveImage = move_uploaded_file($realImage, $folder.'/'.$fileName);
        if( $moveImage ) {
            
            //Existe el Evento
            $queryexist = "SELECT id from eventos where odt = ? ";
            
          
            $arrayString = array($odt);
			$exist =  $Api->insert($queryexist,$arrayString);
            
            if($exist) {

                $sqlEvento = " UPDATE eventos SET latitud=?,longitud=?,tecnico=? WHERE id=? ";
                $arrayStringEvento =  array($latitud,$longitud,$tecnico,$exist);
                $newId = $Api->insert($sqlEvento,$arrayStringEvento );

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
            
                $newId = $Api->insert($sqlEvento,$arrayStringEvento );
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

       
			$newId = $Api->insert($prepareStatement,$arrayString );
            $resultado =  ['status' => 1, 'error' => 'Se Cargo Correctamente la Imagen', 'odt' => $odt, 'afiliacion' => $afiliacion ];

        } else {
             
            $resultado =  ['status' => 0, 'error' => 'No Se subio el archivo '.$_FILES["photo"]["error"],'folder' => $folder,'upload' => $moveImage,'folderExist' => file_exists($folder) ];
        }
    
        

   


    echo json_encode($resultado);

?>