<?php
//require 'vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;


class Api {
    private static $client;
    
    function __construct() {

        self::$client = new Client([
            'base_uri' => 'https://sgse.microformas.com.mx/' 
        ]);
    }

    function getToken() {
        
      //  $json = json_encode(["client_id" => "aaede9ee-77bf-47c1-a551-f9b72637af82", "client_secret" => "KLKK8gi^*(uK&0SWxNsB3*g5jLGiTX5ZKGw#aFLf4B3*tgjLOP","grant_type" => "client_credentials", "audience" => "https://sgse.microformas.com.mx/" ]);
    //echo $json;
        //DESARROLLO
        /*$RequestBody = [
            'client_id' => "aaede9ee-77bf-47c1-a551-f9b72637af82", 
            'client_secret' => "KLKK8gi^*(uK&0SWxNsB3*g5jLGiTX5ZKGw#aFLf4B3*tgjLOP",
            'grant_type' => "client_credentials", 
            'audience' => "https://sgse.microformas.com.mx/"
        ]; */
		
		$RequestBody = [
            'client_id' => "66c0b1e6-07ba-444c-8e6c-43b4c8d675d3", 
            'client_secret' => 'Wpqzma!f&T?Jpuabn#B*6#z#$s=2HWkeM#aAt5rCNZF9bwxCE^rpnqR9bkWG2hjv',
            'grant_type' => "client_credentials", 
            'audience' => "https://sgse.microformas.com.mx/"
        ]; 

        $body = json_encode($RequestBody);
        $response = self::$client->request('POST', "getnetproviders/api/authenticate/token",[
            'cert' => [ '/var/www/html/conector/cert.pem'],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            'body'    => $body 
        ]);

       return  json_decode($response->getBody());
    }
    
    function get($object,$token,$params) {
        
        $response = self::$client->request('GET', $object,[
            'headers' => [ 'Authorization' => 'Bearer '.$token],
            'query' =>  $params
        ]);

       return  json_decode($response->getBody());
    }

    function putImg($object,$token,$imgs,$odt,$tecnico) {
        
        $arrayImg = array();
        $arrayImgs = array();
        $result = '';
        
        foreach ($imgs as $image) {
            array_push($arrayImg, [ 'name' => 'Odt', 'contents' => $odt]);
            array_push($arrayImg, [ 'name' => 'Tecnico', 'contents' => 'android']);
            $path = $_SERVER['DOCUMENT_ROOT']."/img/".$image['odt']."/".$image['dir_img'];
             
            $image_info = getimagesize($path);
            $name = explode(".",$image['dir_img']);

            array_push($arrayImg,['name'=> 'Archivos', 'contents' => Psr7\Utils::tryFopen( $path, 'r' )]); 
          

            try {
                $response = self::$client->request('POST', $object,[
                    'multipart' => $arrayImg,
                    'headers' => [ 'Authorization' => 'Bearer '.$token]
                ]);
                
            } catch (GuzzleHttp\Exception\ClientException $exception) {
                $response = $exception->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                echo $responseBodyAsString;
            } catch (GuzzleHttp\Exception\ServerException  $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
            }  
           
           // $result = json_decode($response->getBody());
           $result= $response->getBody();
           $arrayImg= array();
        }



        //array_push($arrayImg, [ 'name' => 'Archivos', 'contents' => $arrayImgs]);

       

       return  json_decode($result);
    }

    function put($object,$token,$json) {

        $response = self::$client->request('POST', $object,[
            'headers' => [ 'Authorization' => 'Bearer '.$token],
            'json' => $json
        ]);

       return  json_decode($response->getBody());
    }
}


$api = new Api ();

/*$branches = $api->get('branch');

foreach($branches as $branch) {
    foreach($branch as $info) {
        echo $info->Name;
    }
}*/