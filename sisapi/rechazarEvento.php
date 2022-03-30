<?php 
include '../modelos/api_db.php';

	$result = json_encode($_POST);

    $odt = trim($_POST['odt']);

    file_put_contents("json/reject_$odt.json",$result);

    $exist = 0;
    
    $tecnico = $_POST['userid'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $afiliacion = trim($_POST['afiliacion']);
    $comentarios = $_POST['comentarios'];
    $cve_banco = $_POST['cve_banco'];
    $receptor_servicio = $_POST['atendio'];
    $hora_salida = date('H:i:s', $hoy);
    $estatus = 21;
    $hoy = strtotime("now");
	$fecha = date ('Y-m-d H:i:s',$hoy );
	$tipoServicio = $Api->getServicioIdOdt($odt);
	
    $exist = $Api->existEvento($odt,$afiliacion);
	 
    if($exist) {

        //Save odt
        
        if($tipoServicio['estatus_servicio'] == '16' ) {
                    
            $sqlEvento = " UPDATE eventos SET latitud=?,longitud=?,tecnico=?,fecha_atencion=?,hora_salida=?,comentarios=?,`origen`=?,`modificado_por`=? WHERE id=? ";
            
            $arrayStringEvento = array(
                $latitud,
                $longitud,
                $tecnico,
                $fecha,
                $hora_salida,
                $comentarios,
                1,
                $tecnico,
                $exist
            );
            
            $res = $Api->insert($sqlEvento,$arrayStringEvento );
            
            
        } else {
            $exist = 0;
            $msg .= 'El Evento ya fue cerrado y no puede ser modificado';
        }
    
        $resultado =  ['status' => 1, 'error' => "Se Cargo Correctamente la Informacion ", 'odt' => $odt, 'afiliacion' => $afiliacion,'data' => $arrayStringEvento];

    } else {
        $resultado =  ['status' => 0, 'error' => "Hubo un error en la carga volver a intentar \n ".$msg, 'odt' => $odt, 'afiliacion' => $afiliacion, 'msg' => $datosODT ];
    }

    echo json_encode($resultado);

?>