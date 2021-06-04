<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$format = "Y-m-d\TH:i:s";
$fecha = date('Y-m-d H:i:s');

$eventos = $Procesos->getEventosCerrados();

foreach($eventos as $evento) {
    $json = array();
    $unidades = array();
    
    $odt = $evento['odt'];
    $notificado = $evento['notificado'];
    $promociones = 0;
    $descarga_app = 0;
    $telefono1 = $evento['telefono'];
    $telefono2 = $evento['telefono'];
    $fechacierre = $evento['fecha_cierre'];
    $atiende = $evento['receptor_servicio'];
    $otorgante_vobo = $evento['nombre']." ".$evento['apellidos'];
    $rollos = $evento['rollos_entregados'];
    $getnet = $evento['getnet'];
    $caja = $evento['id_caja'];
    $comentario = $evento['comentarios_cierre'];
    $no_ar = "12345";
    $idtecnico = $evento['user'];
    //DATOS SERIE
    $noserie = $evento['tpv_instalado'];
    $noserier = $evento['tpv_retirado'];
    $sim = $evento['sim_instalado'];
    $simr = $evento['sim_retirado'];
    $latitud = $evento['latitud'];
    $longitud = $evento['longitud'];

    if(!empty($noserie) ) {
    
        $serieData = $Procesos->getSeriesData($noserie);
        $conectividad = $serieData['conectividad'];
        $modelo = $serieData['modelo'];
        $marca = $serieData['marca'];
        $aplicativo = $evento['aplicativo'];
        $version = $eventos['version'];
        $bateria = 1;
        $eliminador = 1;
        $tapa = 1;
        $cable = 1;
        $base = 1;
        $is_amex = $evento['tieneamex'];
        $afiliacionamex = $evento['afiliacionamex'];
        $conclusionesamex = '';
    }

    //
    $object = "provider/api/odts/Closure";

    if( $evento['tipo_servicio'] == 1 ) {

        $json = [ 
            'NOAR' => $odt,
            'tecnico' => $idtecnico,
            'notificado' => (bool) $notificado,
            'promociones' => (bool)$promociones,
            'descargaApp' =>(bool) $descarga_app,
            'telefono1' => '5884888332',
            'telefono2' => '5884888332',
            'fechaCierra' => '25/05/2021 14:08:32',
            'atiende' => $atiende,
            'otorgnteVobo' => $otorgante_vobo,
            'tipoAtencion' => 'PRESENCIAL',
            'rollos' => (int) 20,
            'getnet' => (int) $getnet,
            'caja' => (int) $caja,
            'causa' => (int) $causa,
            'comentario' => $comentario,
            'latitud' => $latitud,
            'longitud' => $longitud
        ];

        $unidades = [
            'tipoUnidad' => 1,
            'noSerie' => $noserie,
            'noSim' => $sim,
            'conectividad' => $conectividad,
            'aplicativo' => $aplicativo,
            'version' => $version,
            'bateria' => $bateria,
            'eliminador' => $eliminador,
            'tapa' => $tapa,
            'cable' => $cable,
            'base' => $base,
            'isAmex' => (bool) $is_amex,
            'idAmex' => $idamex,
            'afiliacionAmex' => $afiliacionamex,
            'conclusionesAmex' => $conclusionesAmex,
            'marca' => $marca,
            'modelo' => $modelo,
            'isInstalacionSim' => (bool) $isinstalacionSim
        ];

        array_push($json,['unidades' => $unidades] );

    } else if($evento['tipo_servicio'] == 21 ) {
        $json = [
            'ATIENDE' => $atiende,
            'OTORGANTEVOBO' => $otorgante_vobo,
            'TIPOATENCION' => 'PRESENCIAL',
            'ROLLOS' => (int) 20,
            'GETNET' => (int) $getnet,
            'CAJA' => (int) $caja,
            'COMENTARIO' => "2021-05-20 DE 10:09:13 A 10:09:50 CIERRE PRESENCIAL, SINTTECOM, ATENDIÓ() AFILIACIÓN (#AFILIACION#) SE RETIRA TPV MODELO(V240M) SERIE(346292692) SIM (8952020520391360507) COMPAÑÍA DE SIM (Telcel) CONECTIVIDAD(#CONECTIVIDADRETIRO) SE RETIRA CON (CARGADOR Y PILA) SE DEJA COPIA DE HOJA DE SERVICIO TEL. #TELEFONO (051)",
            'NOAR' => $odt,
            'TECNICO' => 'android',
            'FECHACIERRE' => '25/05/2021 14:45:32',
            'NOSERIE' => $noserier,
            'NOSIM' => '8952020520391360507',
            'MARCA' => 'V240M',
            'MODELO' => 'VERIFONE',
            'CONECTIVIDAD' => 'BLUETHOOTH',
            'APLICATIVO' => 'DUAL',
            'VERSION' => true,
            'BATERIA' => true,
            'ELIMINADOR' => true,
            'TAPA' => true,
            'CABLE_AC' => true,
            'BASE' => true
        ];
    }


        try {

        $cierre = $api->put($object,$token->token,$json);

        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            echo $responseBodyAsString;
        }
        

        echo json_encode($cierre);

      //  $images = $Procesos->getOdtImages('1WL0R000002DOG2GAO');
        $arrayImg = array();
        
      //  $imagesUp = $api->putImg("provider/api/files",$token->token,$images,'1WL0R000002DOG2GAO','410');
    

}

/*$images = $Procesos->getOdtImages('BRUBAJAS7813318');
$arrayImg = array();
foreach ($images as $image) {

    $path = "../img/".$image['odt']."/".$image['dir_img'];
    $image_info = getimagesize($path);
    $name = explode(".",$image['dir_img']);
    //echo $api->putImg("provider/api/files",$token->token,$arrayImg,['Odt' => 'BRUBAJAS7813318']);
    array_push($arrayImg,[ 'name' => 'Odt', 'contents' => 'BRUBAJAS7813318']);
    
    array_push($arrayImg,['name'=> $name[0],'filename'=>$image['dir_img'],'Mime-Type'=> $image_info['mime'],'contents' =>  fopen( $path, 'rb' ) ] 
    array_push($arrayImg,);
}*/

//echo $api->putImg("provider/api/files",$token->token,$arrayImg,['Odt' => 'BRUBAJAS7813318']);





?>