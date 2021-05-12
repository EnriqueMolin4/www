<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function searchMenu($array,$type,$value) {
	foreach ($array as $key => $val) {
		if ($val[$type] === $value) {
			return true;
		}
	}
	return false;
}

function searchMenuEdit($array,$type,$value) {
	$result = 0;
	foreach ($array as $key => $val) {
		if ($val[$type] === $value) {
			//if($val['edit'] == '1') {
				$result = $val['edit'];
			//} 
		}
	}
	return $result;
}


if(isset($_SESSION['user']))
{
	if($_SESSION['user'] == '')
	{
		header("Location: login.php");
	}
	else
	{
		
		$tipouser = $_SESSION['tipo_user'];
		//if($tipouser == 'tecnico') {
		//	header("Location: index.php");
		//}
		//$cve = $_SESSION['cve'];
	}
}
else
{
	ob_start();
	//include './general/language_config.php';
	header("Location: login.php");
}
 ?>