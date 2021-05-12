<?php
include 'modelos/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SINTTECOM</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<script type="text/javascript" src="view/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="view/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="view/js/nueva_contra.js"></script>
	<script type="text/javascript" src="view/js/login.js"></script>
	<script type="text/javascript" src="ajax/logueo.js"></script>
	<script type="text/javascript" src="ajax/renovar-contra.js"></script>
	<link rel="stylesheet" type="text/css" href="view/css/login.css">
</head>
<body>

	<div id="logueo">
	<br>
		<p>Sistema de Administracion de Servicios para Terminales<br>
		Punto de Venta y Control de Inventarios</p>
	<!-- <img src="view/img/back_login.jpg"> -->
		<form method="POST" action="sesiones/validacion.php">
			<input type="text" placeholder="USUARIO" name="user" id="user"><br>
			<input type="password" placeholder="CONTRASEÑA" name="pass" id="pass"><br>
			<button type="submit" class="boton">ENVIAR</button>
			<input class="boton" type="button" id="nueva-contra" value="NUEVA CONTRASEÑA">
		</form>

		<div id="renovar-contra">
			<a>X</a>
			<input type="text" placeholder="USUARIO" id="user-contra">
			<input type="text" placeholder="CONTRASEA ACTUAL" id="vieja-contra">
			<input type="text" placeholder="NUEVA CONTRASEÑA" id="actualizar-contra">
			<!-- <input type="text" placeholder="CORREO" id="correo-contra"> -->
			<br>
			<input class="boton" id="renovar-contra-button" type="button" value="ENVIAR">
		</div>
		<!-- <input type="button" id="correo" onclick="tomar_imagen()" class="boton" value="IMAGENES"> -->
	</div>
<script type="text/javascript">
	function tomar_imagen(){
		$.ajax({
		    url: "sesiones/validacion.php",
		    type: "post",
			data: "&user=correo&pass=correo",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			window.location.res;
			location.reload();
		});
	}
</script>
<style type="text/css">
	#correo{
		position:absolute;
		left:0;
		bottom:0;
		width:200px;
		padding-right: 35px;
		padding-left: 35px;
		padding-bottom: 15px;
		padding-top: 15px;
		text-align: center;
	}
	#logueo{
		background-image: url("view/img/back_login.jpg");
		background-repeat:no-repeat;
		background-size: 160% 100%;
		overflow:hidden;
	}
	#logueo p{
		color:#b35900;
		margin-left:20px;
		font-family:helvetica;
		font-weight: 900;
		font-size: 15px
	}
	#logueo > img{
		z-index: -1;
		width:120%;
		height:100%;
		position: absolute;
		top:0px;
		left:0px;
	}
</style>
</body>
</html>
