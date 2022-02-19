<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'modelos/conexion.php';

if( !empty($_SESSION['user']) ) {
	if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'supervisor') 
	{
		include 'nuevositio.php';
	} else {
		include 'principal.php';
	}
}
else{
	//include 'login.php';
	header("location: login.php?msg=".$_GET['msg']);
}
?>