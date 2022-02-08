<?php 

include '../modelos/api_db.php';

$user = $_POST['user'];
$pass = sha1($_POST['pass']);
$identifier = $_POST['identifier'];
$version = is_null($_POST['version']) ? 0 :  $_POST['version'];
$existDevice = 1;

$deviceInfo = $Api->getDeviceInfo($identifier);
//if( $version != '2.0.19'   ) {
//if($version == '0') {
	$resultado = [ 'error' => 2, 'data' => [],'version' => $version ];
//} else { 
	/*
	if($deviceInfo) {

		if( $deviceInfo[0]['user'] == $user ) {
			$fecha = date("Y-m-d H:i:s");

			$queryComercio = " UPDATE deviceinfo SET `fecha_modificacion`=? ,`version`=?  WHERE `id`=? ";
			$Api->insert($queryComercio,array($fecha,$version,$deviceInfo[0]['id']));
		
			$existDevice = 1;
		} else {
			$existDevice = 1;
		}
	
	} else {

		$fecha = date("Y-m-d H:i:s");

		$prepareStatement = "INSERT INTO `deviceinfo`
		( `user`,`deviceid`,`version`,`fecha_modificacion`)
		VALUES
		(?,?,?,?);
		";
		$arrayString = array (
			$user,
			$identifier,
			$version,
			$fecha
		);

		$id = $Api->insert($prepareStatement,$arrayString);
		$existDevice = 1;
	} */

	if($existDevice ) {

		$login = $Api->getLogin($user,$pass);
		$configuration = $Api->getConfiguraciones();

		if($login ) {
			$resultado = [ 'data' => $login, 'error' => 0 ,'info' => $login,'device' => $existDevice, 'configuracion' => $configuration];
		
		} else {
			$resultado = [ 'error' => 1, 'data' => [],'info' => $login,'device' => $existDevice ];
		}
	} else {
		$resultado = [ 'error' => 0, 'data' => [],'info' => $login,'device' => $existDevice ];
	}
 // }

echo json_encode($resultado);

?>