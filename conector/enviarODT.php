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
$odt = $_REQUEST['odt'];
$evidencia = $_REQUEST['evidencia'];
 //echo $odt;

$eventos = $Procesos->getEventosCerrados($odt);

foreach($eventos as $evento) {
    //echo json_encode($evento);
        
    //$odt = $evento['odt'];
    $notificado = $evento['notificado'];
    $promociones = $evento['descarga'];
    $descarga_app = $evento['descarga'];
    $telefono1 = $evento['telefono1'];
    $telefono2 = $evento['telefono1'];
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
	$aplicativo = (int) $evento['aplicativoId'];
	$aplicativoret = (int) $evento['aplicativoretId'];
	$version =   $evento['version'] == 0 ? 'PROGAASU4' : $evento['nombreVersion'] ;
	$versionret = empty( $evento['nombreVersionr'] ) ? 'PROGAASU4' : $evento['nombreVersionr'] ;
    
    $geolocalizacion = $Procesos->getGeolocalizacion($evento['afiliacion']);

    $latitud = isset($geolocalizacion['latitud']) ? $geolocalizacion['latitud'] : $evento['latitud'] ;
    $longitud = isset($geolocalizacion['longitud']) ? $geolocalizacion['longitud'] : $evento['longitud'];
    $causacambio = $evento['causacambio'] == '0' ? '1' : $evento['causacambio'];
	$rechazo = $evento['rechazoSgs'];
    $subrechazo = $evento['subrechazoSgs'];
    $cancelacion = $evento['canceladoSgs'];
	$tipoevento = $Procesos->getCamposObligatorios($evento['tipo_servicio']);
	

    //
    $object = "gntps/api/odts/Closure";


	if($evento['estatus_servicio'] == '15' )
    {
        
		$object = "gntps/api/Odts/Rejection";
		 
		$json = [
                "fecCierre" => $fechacierre,
                "causaRechazo" => (int) $rechazo,
                "subrechazo" => (int) $subrechazo,
                "tipoAtencion" => 9,
                "atiende" => $atiende,
                "conclusiones"  => $comentario,
                "noAr" => $odt,
                "tecnico" => $idtecnico,
        ];

    } else if( $evento['estatus_servicio'] == '14' ) {
        
        $object = "gntps/api/Odts/Cancellation";

        $json = [
            "noAr" => $odt,
            "tecnico" => $idtecnico,
            "idCausaCancelacion" => (int) $cancelacion,
			"comentario" => $comentario

        ];

    } else {
		
		$json = [ 
			'noAr' => $odt,
			'tecnico' => $idtecnico,
			'notificado' => (bool) $notificado,
			'promociones' => (bool)$promociones,
			'descargaApp' =>(bool) $descarga_app,
			'telefono1' => $telefono1,
			'telefono2' => $telefono2,
			'fechaCierre' => $fechacierre,
			'atiende' => $atiende,
			'otorganteVobo' => $otorgante_vobo,
			'tipoAtencion' => 'PRESENCIAL',
			'rollos' => (int) $rollos,
			'getnet' => (int) $getnet,
			'caja' => (int) $caja,
			'causa' => (int) $causacambio,
			'comentario' => $comentario,
			'latitud' => floatval($latitud),
			'longitud' => floatval($longitud)
		];

		if($tipoevento['tvp_instalada'] == '1' || $tipoevento['tvp_salida'] == '1') 
		{
			
			if($evento['tipo_servicio'] == '8' || $evento['tipo_servicio'] == '14' || $evento['tipo_servicio'] == '33' || $evento['tipo_servicio'] == '45'   )
			{
				if(!empty($noserie) ) {

					$serieData = $Procesos->getSeriesData($noserie);
					$conectividad = $serieData['conectividad'];
					$modelo = $serieData['modelo'];
					$marca = $serieData['marca'];
					$aplicativo = $aplicativo == '0' ? '17' : $aplicativo;
					 
					$bateria = 1;
					$eliminador = 1;
					$tapa = 1;
					$cable = 1;
					$base = 1;
					$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
					$afiliacionamex = $evento['afiliacionamex'];
					$conclusionesamex =  $evento['tieneamex'] == 'NO'  ? "" : "OK";
					$idamex = $evento['amex'];

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
						'conclusionesAmex' => $conclusionesamex,
						'marca' => (int) $marca,
						'modelo' => (int)  $modelo,
						'isInstalacionSim' => is_null($sim) ? false : true //$isinstalacionSim
					];

					$json['unidades'] =array($unidades) ;
				}
				
				if(empty($noserier) ) {
					
					 

						$serieData = $Procesos->getSeriesData($noserier);
						$conectividad = $serieData['conectividad'];
						$modelo = $serieData['modelo'];
						$marca = $serieData['marca'];
						$aplicativo = $aplicativoret == '0' ? '17' : $aplicativoret;
						$isretirosim = is_null($simr) ? false : true; 
						$bateria = 1;
						$eliminador = 1;
						$tapa = 1;
						$cable = 1;
						$base = 1;
						$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
						$afiliacionamex = $evento['afiliacionamex'];
						$conclusionesamex =  $evento['tieneamex'] == 'NO'  ? "" : "OK";
						$idamex = $evento['amex'];
						

						$unidades = [
							'tipoUnidad' => 2,
							'IsRetiroSim' => $isretirosim,
							'noSerie' => $noserier,
							'noSim' => $simr,
							'conectividad' => (int) $conectividad,
							'aplicativo' => (int) $aplicativo,
							'version' => $versionret,
							'bateria' => (bool) $bateria,
							'eliminador' => (bool) $eliminador,
							'tapa' => (bool) $tapa,
							'cable' => (bool) $cable,
							'base' => (bool) $base,
							'isAmex' => (bool) $is_amex,
							'idAmex' => $idamex,
							'afiliacionAmex' => $afiliacionamex,
							'conclusionesAmex' => $conclusionesamex,
							'marca' => (int) $marca,
							'modelo' => (int)  $modelo,
							'isInstalacionSim' => is_null($simr) ? false : true  //$isinstalacionSim
						];

						$json['unidades'][] =$unidades ;
					
				}

			} else {

				if(!empty($noserie) ) {

					$serieData = $Procesos->getSeriesData($noserie);
					$conectividad = $serieData['conectividad'];
					$modelo = $serieData['modelo'];
					$marca = $serieData['marca'];
					$aplicativo = $aplicativo == '0' ? '17' : $aplicativo;
					
					$bateria = 1;
					$eliminador = 1;
					$tapa = 1;
					$cable = 1;
					$base = 1;
					$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
					$afiliacionamex = $evento['afiliacionamex'];
					$conclusionesamex = $evento['tieneamex'] == 'NO'  ? "" : "OK";
					$idamex = $evento['amex'];

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
						'conclusionesAmex' => $conclusionesamex,
						'marca' => (int) $marca,
						'modelo' => (int)  $modelo,
						'isInstalacionSim' => is_null($sim) ? false : true //$isinstalacionSim
					];

					$json['unidades'] =array($unidades) ;
				}

				if(!empty($noserier) ) {

					$serieData = $Procesos->getSeriesData($noserier);
					$conectividad = $serieData['conectividad'];
					$modelo = $serieData['modelo'];
					$marca = $serieData['marca'];
					$aplicativo = $aplicativoret == '0' ? '17' : $aplicativoret;
					 
					$bateria = 1;
					$eliminador = 1;
					$tapa = 1;
					$cable = 1;
					$base = 1;
					$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
					$afiliacionamex = $evento['afiliacionamex'];
					$conclusionesamex =  $evento['tieneamex'] == 'NO'  ? "" : "OK";
					$idamex = $evento['amex'];
					$isretirosim = is_null($simr) ? false : true;

					$unidades = [
						'tipoUnidad' => 2,
						'IsRetiroSim' => $isretirosim,
						'noSerie' => $noserier,
						'noSim' => $simr,
						'conectividad' => (int) $conectividad,
						'aplicativo' => (int) $aplicativo,
						'version' => $versionret,
						'bateria' => (bool) $bateria,
						'eliminador' => (bool) $eliminador,
						'tapa' => (bool) $tapa,
						'cable' => (bool) $cable,
						'base' => (bool) $base,
						'isAmex' => (bool) $is_amex,
						'idAmex' => $idamex,
						'afiliacionAmex' => $afiliacionamex,
						'conclusionesAmex' => $conclusionesamex,
						'marca' => (int) $marca,
						'modelo' => (int)  $modelo,
						'isInstalacionSim' => is_null($simr) ? false : true  //$isinstalacionSim
					];

					$json['unidades'][] =$unidades ;
				}
			}
		} else if ( $tipoevento['sim_instalado'] == '1' || $tipoevento['sim_retirado'] == '1' ) {
			
			

					$serieData = $Procesos->getSeriesData($noserie);
					$conectividad = $serieData['conectividad'];
					$modelo = $serieData['modelo'];
					$marca = $serieData['marca'];
					$aplicativo = $aplicativo == '0' ? '17' : $aplicativo;
					 
					$bateria = 1;
					$eliminador = 1;
					$tapa = 1;
					$cable = 1;
					$base = 1;
					$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
					$afiliacionamex = $evento['afiliacionamex'];
					$conclusionesamex = $evento['tieneamex'] == 'NO'  ? "" : "OK";
					$idamex = $evento['amex'];

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
						'conclusionesAmex' => $conclusionesamex,
						'marca' => (int) $marca,
						'modelo' => (int)  $modelo,
						'isInstalacionSim' => is_null($sim) ? false : true //$isinstalacionSim
					];

					$json['unidades'] =array($unidades) ;
				

				

					$serieData = $Procesos->getSeriesData($noserier);
					$conectividad = $serieData['conectividad'];
					$modelo = $serieData['modelo'];
					$marca = $serieData['marca'];
					$aplicativo = $aplicativoret == '0' ? '17' : $aplicativoret;
					 
					$bateria = 1;
					$eliminador = 1;
					$tapa = 1;
					$cable = 1;
					$base = 1;
					$is_amex = $evento['tieneamex'] == 'NO' ? 0 : 1;
					$afiliacionamex = $evento['afiliacionamex'];
					$conclusionesamex =  $evento['tieneamex'] == 'NO'  ? "" : "OK";
					$idamex = $evento['amex'];
					$isretirosim = is_null($simr) ? false : true;

					$unidades = [
						'tipoUnidad' => 2,
						'IsRetiroSim' => $isretirosim,
						'noSerie' => $noserier,
						'noSim' => $simr,
						'conectividad' => (int) $conectividad,
						'aplicativo' => (int) $aplicativo,
						'version' => $versionret,
						'bateria' => (bool) $bateria,
						'eliminador' => (bool) $eliminador,
						'tapa' => (bool) $tapa,
						'cable' => (bool) $cable,
						'base' => (bool) $base,
						'isAmex' => (bool) $is_amex,
						'idAmex' => $idamex,
						'afiliacionAmex' => $afiliacionamex,
						'conclusionesAmex' => $conclusionesamex,
						'marca' => (int) $marca,
						'modelo' => (int)  $modelo,
						'isInstalacionSim' => is_null($simr) ? false : true  //$isinstalacionSim
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

         /*
        $images = $Procesos->getOdtImages($odt);
        $arrayImg = array();
		*/
		
		if($evidencia == '1') {
			echo "Se Envian Evidencias  \n <br>";
			$images = $Procesos->getOdtImages($odt);
			$arrayImg = array();
			$imagesUp = $api->putImg("gntps/api/files",$token->token,$images,$odt,$idtecnico);
			
		}
		echo "<a href='index.html'>REGRESAR</a>";
		echo "<br>";
		echo "<br>";
        
        
		// echo $token->token." \n <br> ";
         $resultado = json_encode([ 'evento' => $cierre, 'img' => $imagesUp, 'json' => $json]);
		  echo $resultado. " \n \n <br>  <br> ";
		echo "ENDPOINT: ".$object." \n <br>";
		echo "MENSAJE ENDPOINT: ".$cierre->message." \n <br>";
		echo " RESULTADO: ".$cierre->result->status." \n <br>";
		 
		if($cierre->result->status == 400) 
		{
				$msg = " LA ODT presenta algunos campos erroneos \n <br> ";
			   foreach($cierre->result->messages as $message) {
					$msg .= $message;
			   }

			  
		} else if($cierre->result == 201) {
			
			$msg = 'Se envio la odt '+$odt+' con Exito';

		} else if ($cierre->result->status == 410 ) {

			foreach ($cierre->result->messages as $message) {
				$msg .= $message." \n <br> ";
			}

			
	    } else if ($cierre->result->status == 404 ) {

			foreach ($cierre->result->messages as $message) {
				$msg .= $message." \n <br> ";
			}

			
	    } else {

			$msg = $cierre->result;
		}
		
		echo $msg. " \n <br> ";
		
		 
		 
		foreach ($json as $key => $value) {  // another way to get keys and values.
			if($key == 'unidades') {
				foreach ($value as $key => $value) {
					echo "<b>Unidad $key</b><br>";
					foreach($value as $key => $value) {
						echo "<b>$key</b>" .' ' . $value. " \n <br> ";
					}
					
				}
			} else {
				echo "<b>$key</b>" .' ' . $value. " \n <br> ";
			}
		}
		
		//echo json_encode([ 'evento' => $cierre, 'img' => $imagesUp, 'json' => $json, 'msg' => $msg]);
}







?>