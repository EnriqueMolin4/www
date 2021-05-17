<?php
//require 'vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;


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
        $RequestBody = [
            'client_id' => "aaede9ee-77bf-47c1-a551-f9b72637af82", 
            'client_secret' => "KLKK8gi^*(uK&0SWxNsB3*g5jLGiTX5ZKGw#aFLf4B3*tgjLOP",
            'grant_type' => "client_credentials", 
            'audience' => "https://sgse.microformas.com.mx/"
        ];

        $body = json_encode($RequestBody);
        $response = self::$client->request('POST', "GetServerTest/api/authenticate/token",[
            'cert' => [ '/home/webdeveloper/sitios/sinttecom/conector/cert.pem'],
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

    function putImg($object,$token,$params) {
        $path = '';
        $response = self::$client->request('POST', $object,[
            'headers' => [
            'Authorization' => 'Bearer VTl4tw6n7aA7uixf731yVGHohdCXJWhjyCg4nSZa5lEnIWfVxOksPBTyoNSn'
            ],
            'multipart' => $params
        ]);

       return  json_decode($response->getBody());
    }

    function put($object,$json) {
        $response = self::$client->request('POST', $object,[
            'headers' => [
            'Authorization' => 'Bearer VTl4tw6n7aA7uixf731yVGHohdCXJWhjyCg4nSZa5lEnIWfVxOksPBTyoNSn'
            ],
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