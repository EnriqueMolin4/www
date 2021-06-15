<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$format = "Y-m-d\TH:i:s";
$fecha = date('Y-m-d H:i:s');
$odt = $_POST['odt'];

$eventos = $Procesos->getEventosCerrados($odt);

foreach($eventos as $evento) {
    
        
    $odt = $evento['odt'];
    $notificado = $evento['notificado'];
    $promociones = $evento['descarga'];
    $descarga_app = $evento['descarga'];
    $telefono1 = $evento['telefono'];
    $telefono2 = $evento['telefono'];
    $fechacierre =  date('d/m/Y H:i:s',strtotime( $evento['fecha_cierre'] ));
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
    
    $geolocalizacion = $Procesos->getGeolocalizacion($evento['afiliacion']);

    $latitud = $geolocalizacion['latitud'];
    $longitud = $geolocalizacion['longitud'];


    //
    $object = "provider/api/odts/Closure";



    $json = [ 
        'NOAR' => $odt,
        'tecnico' => $idtecnico,
        'notificado' => (bool) $notificado,
        'promociones' => (bool)$promociones,
        'descargaApp' =>(bool) $descarga_app,
        'telefono1' => '5884888332',
        'telefono2' => '5884888332',
        'fechaCierre' => $fechacierre,
        'atiende' => $atiende,
        'otorganteVobo' => $otorgante_vobo,
        'tipoAtencion' => 'PRESENCIAL',
        'rollos' => (int) 20,
        'getnet' => (int) $getnet,
        'caja' => (int) $caja,
        'causa' => (int) $causa,
        'comentario' => $comentario,
        'latitud' => floatval($latitud),
        'longitud' => floatval($longitud)
    ];

    if($evento['tipo_servicio'] == '8' || $evento['tipo_servicio'] == '14' || $evento['tipo_servicio'] == '33' || $evento['tipo_servicio'] == '45'   )
    {
        if(!empty($noserie) ) {

            $serieData = $Procesos->getSeriesData($noserie);
            $conectividad = $serieData['conectividad'];
            $modelo = $serieData['modelo'];
            $marca = $serieData['marca'];
            $aplicativo = '17'; //$evento['aplicativo'];
            $version = '1.10.7 Get Net'; //$eventos['nombreVersion'];
            $bateria = 1;
            $eliminador = 1;
            $tapa = 1;
            $cable = 1;
            $base = 1;
            $is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
            $afiliacionamex = $evento['afiliacionamex'];
            $conclusionesamex = '';

            $unidades = [
                'tipoUnidad' => 1,
                'noSerie' => $noserie,
                'noSim' => $simr,
                'conectividad' => (int) $conectividad,
                'aplicativo' => (int) $aplicativo,
                'version' => $version,
                'bateria' => (bool) $bateria,
                'eliminador' => (bool) $eliminador,
                'tapa' => (bool) $tapa,
                'cable' => (bool) $cable,
                'base' => (bool) $base,
                'isAmex' => (bool) $is_amex,
                'idAmex' => $idamex,
                'afiliacionAmex' => $afiliacionamex,
                'conclusionesAmex' => $conclusionesAmex,
                'marca' => (int) $marca,
                'modelo' => (int)  $modelo,
                'isInstalacionSim' => (bool) 1 //$isinstalacionSim
            ];

            $json['unidades'] =array($unidades) ;
        }

    } else {

        if(!empty($noserie) ) {

            $serieData = $Procesos->getSeriesData($noserie);
            $conectividad = $serieData['conectividad'];
            $modelo = $serieData['modelo'];
            $marca = $serieData['marca'];
            $aplicativo = '17'; //$evento['aplicativo'];
            $version = '1.10.7 Get Net'; //$eventos['version'];
            $bateria = 1;
            $eliminador = 1;
            $tapa = 1;
            $cable = 1;
            $base = 1;
            $is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
            $afiliacionamex = $evento['afiliacionamex'];
            $conclusionesamex = '';

            $unidades = [
                'tipoUnidad' => 1,
                'noSerie' => $noserie,
                'noSim' => $sim,
                'conectividad' => (int) $conectividad,
                'aplicativo' => (int) $aplicativo,
                'version' => $version,
                'bateria' => (bool) $bateria,
                'eliminador' => (bool) $eliminador,
                'tapa' => (bool) $tapa,
                'cable' => (bool) $cable,
                'base' => (bool) $base,
                'isAmex' => (bool) $is_amex,
                'idAmex' => $idamex,
                'afiliacionAmex' => $afiliacionamex,
                'conclusionesAmex' => $conclusionesAmex,
                'marca' => (int) $marca,
                'modelo' => (int)  $modelo,
                'isInstalacionSim' => (bool) 1 //$isinstalacionSim
            ];

            $json['unidades'] =array($unidades) ;
        }

        if(!empty($noserier) ) {

            $serieData = $Procesos->getSeriesData($noserier);
            $conectividad = $serieData['conectividad'];
            $modelo = $serieData['modelo'];
            $marca = $serieData['marca'];
            $aplicativo = '17'; //$evento['aplicativo'];
            $version = '1.10.7 Get Net'; //$eventos['version'];
            $bateria = 1;
            $eliminador = 1;
            $tapa = 1;
            $cable = 1;
            $base = 1;
            $is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
            $afiliacionamex = $evento['afiliacionamex'];
            $conclusionesamex = '';

            $unidades = [
                'tipoUnidad' => 2,
                'noSerie' => $noserier,
                'noSim' => $simr,
                'conectividad' => (int) $conectividad,
                'aplicativo' => (int) $aplicativo,
                'version' => $version,
                'bateria' => (bool) $bateria,
                'eliminador' => (bool) $eliminador,
                'tapa' => (bool) $tapa,
                'cable' => (bool) $cable,
                'base' => (bool) $base,
                'isAmex' => (bool) $is_amex,
                'idAmex' => $idamex,
                'afiliacionAmex' => $afiliacionamex,
                'conclusionesAmex' => $conclusionesAmex,
                'marca' => (int) $marca,
                'modelo' => (int)  $modelo,
                'isInstalacionSim' => (bool) 1 //$isinstalacionSim
            ];

            $json['unidades'][] =$unidades ;
        }
    }

    
        
        //echo json_encode($json);

         
        try {

        $cierre = $api->put($object,$token->token,$json);

        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $cierre= json_decode($responseBodyAsString);
        } catch (GuzzleHttp\Exception\ServerException  $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $cierre= json_decode($responseBodyAsString);
        }  
         
        if($cierre->result == '201') {

            $sql = " UPDATE eventos SET sync=1 WHERE odt=?";

            $arrayData = array($odt);

            $Procesos->insert($sql,$arrayData);
        }

         

        $images = $Procesos->getOdtImages($odt);
        $arrayImg = array();
        
        $imagesUp = $api->putImg("provider/api/files",$token->token,$images,$odt,$idtecnico);

        echo json_encode([ 'evento' => $cierre, 'img' => $imagesUp, 'json' => $json]);
    

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