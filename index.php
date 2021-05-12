<?php

session_start();

include 'modelos/conexion.php';

if( !empty($_SESSION['user']) ) 
{
	if($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'supervisor') 
	{
		include 'nuevositio.php';
	} else 
	{
		include 'principal.php';
	}
}
else
{
	//include 'login.php';
	header("location: login.php?msg=".$_GET['msg']);

}
?>