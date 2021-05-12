<?php 

include '../modelos/api_db.php';

//$eventoId = $_POST['eventoId'];
$sim = $_POST['sim'];
$tecnico = $_POST['tecnico'];
$tipo = $_POST['tipo'];
$afiliacion = $_POST['afiliacion'];
$usrSim = $_POST['userSim'];
$txt = '';
$estatus = 1;
$fecha = date ( 'Y-m-d H:m:s' );
$cve = $Api->getDefaultBancoCve();
$comercioId = $Api->getComercioId($afiliacion);
$resultado = $Api->searchSims($sim);
$buscarUniversoElavon = $Api->searchItemElavon($sim,2);
$estatusSIM = 0;

    
    if(!is_null($resultado[0])) {
        $simCompleto = $resultado[0]['sim'];

        if( $resultado[0]['id_ubicacion'] == $tecnico) {

            $estatusSIM=  $resultado[0]['estatus'];

            if( $resultado[0]['estatus'] == '6'  || $resultado[0]['estatus'] == '7' || $resultado[0]['estatus'] == '8'  || $resultado[0]['estatus'] == '16' || $resultado[0]['estatus'] == '17' ) {
                
                $txt .= 'No se puede usar el sim favor de comunicarse con el Supervidor';
                $estatus = 0;
                
            } else if( $resultado[0]['estatus'] == '13'  ) {
                $txt .= 'El Sim ya esta instalado favor de comunicarse con el Supervisor';
                $estatus = 0;
            } else if ( $resultado[0]['estatus'] == '3' || $resultado[0]['estatus'] == '5' ) {
                $txt .= 'El Sim esta disponible ';
                
            } else {
                $txt .= 'El Sim esta disponible ';
            }
            
        } else {
            
            if( is_null($buscarUniversoElavon[0]) ) {
                $txt .= 'El Sim no es del banco favor de comunicarse con el Supervisor';
                $estatus = 0;
                $simCompleto = 'NO ELEGIBLE';
            } else {
                $simCompleto = $buscarUniversoElavon[0]['serie'];
                if( $buscarUniversoElavon[0]['estatus_modelo'] == '3' ) {
                    $txt .= 'El Sim esta disponible';
                    $estatus = 1;
                } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '7' ) {
                    $txt .= 'El Sim esta Cancelado favor de comunicarse con el Supervisor';
                    $estatus = 0;
                    $simCompleto = 'NO ELEGIBLE';

                } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '17'   ) {
                    $txt .= 'El Sim esta Cancelado favor de comunicarse con el Supervisor';
                    $estatus = 0;
                    $simCompleto = 'NO ELEGIBLE';

                } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '16'   ) {
                    $txt .= 'El Sim esta Cancelado favor de comunicarse con el Supervisor';
                    $estatus = 0;
                    $simCompleto = 'NO ELEGIBLE';
                }
            }
                    
        }

    } else {

        if( is_null($buscarUniversoElavon[0]) ) {
            $txt .= 'El Sim no es del banco favor de comunicarse con el Supervisor' ;
            $estatus = 0;
            $simCompleto = 'NO ELEGIBLE';
        } else {
            $simCompleto = $buscarUniversoElavon[0]['serie'];
            if( $buscarUniversoElavon[0]['estatus_modelo'] == '3' ) {
                $txt .= 'El Sim esta '.$buscarUniversoElavon[0]['estatus'];
                $estatus = 1;
            } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '7' ) {
                $txt .= 'El Sim esta '.$buscarUniversoElavon[0]['estatus'];
                $estatus = 0;
                $simCompleto = 'NO ELEGIBLE';

            } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '17'   ) {
                $txt .= 'El Sim esta '.$buscarUniversoElavon[0]['estatus'];
                $estatus = 0;
                $simCompleto = 'NO ELEGIBLE';

            } else if( $buscarUniversoElavon[0]['estatus_modelo'] == '16'   ) {
                $txt .= 'El Sim esta '.$buscarUniversoElavon[0]['estatus'];
                $estatus = 0;
                $simCompleto = 'NO ELEGIBLE';
            }
        }
    }
    



$result = json_encode(['estatus' => $estatus,'txt' => $txt,'sim' => $simCompleto  ]);


echo $result;

?>