<?php

include '../conexion.php';

if(!empty($_POST['cve']) and !empty($_POST['comercio']) and !empty($_POST['afiliacion']) and !empty($_POST['direccion']) and !empty($_POST['colonia']) and !empty($_POST['ciudad']) and !empty($_POST['estado']) and $_POST['tipo_comercio'] != 'SELECCIONA' and !empty($_POST['rfc']) and !empty($_POST['razon_social'])){
	
	$con_existe = $conexion->query("SELECT * from `comercios` where afiliacion = '$afiliacion' and cve_banco = '$cve'");
	$num = mysqli_num_rows($con_existe);
	$arr = mysqli_fetch_array($con_existe);

	if(!empty($_POST['cve'])){				  $cve = strtoupper(trim($_POST['cve']));}
	else{	$cve = strtoupper(trim($arr['cve_banco']));}
	if(!empty($_POST['comercio'])){			  $comercio = strtoupper(trim($_POST['comercio']));}
	else{	$comercio = strtoupper(trim($arr['comercio']));}
	if(!empty($_POST['propietario'])){		  $propietario = strtoupper(trim($_POST['propietario']));}
	else{	$propietario = strtoupper(trim($arr['propietario']));}
	if(!empty($_POST['estado'])){			  $estado = trim($_POST['estado']);}
	else{	$estado = trim($arr['estado']);	}
	if(!empty($_POST['responsable'])){		  $responsable = strtoupper(trim($_POST['responsable']));}
	else{	$responsable = strtoupper(trim($arr['responsable']));}
	if(!empty($_POST['tipo_comercio'])){	  $tipo_comercio = strtoupper(trim($_POST['tipo_comercio']));}
	else{	$tipo_comercio = strtoupper(trim($arr['tipo_comercio']));}
	if(!empty($_POST['ciudad'])){			  $ciudad = strtoupper(trim($_POST['ciudad']));}
	else{	$ciudad = strtoupper(trim($arr['ciudad']));}
	if(!empty($_POST['colonia'])){			  $colonia = strtoupper(trim($_POST['colonia']));}
	else{	$colonia = strtoupper(trim($arr['colonia']));}
	if(!empty($_POST['direccion'])){		  $direccion = strtoupper(trim($_POST['direccion']));}
	else{	$direccion = strtoupper(trim($arr['direccion']));}
	if(!empty($_POST['afiliacion'])){		  $afiliacion = strtoupper(trim($_POST['afiliacion']));}
	else{	$afiliacion = strtoupper(trim($arr['afiliacion']));}
	if(!empty($_POST['telefono'])){			  $telefono = strtoupper(trim($_POST['telefono']));}
	else{	$telefono = strtoupper(trim($arr['telefono']));}
	if(!empty($_POST['razon_social'])){		  $razon_social = strtoupper(trim($_POST['razon_social']));}
	else{	$razon_social = strtoupper(trim($arr['razon_social']));}
	if(!empty($_POST['email'])){			  $email = strtoupper(trim($_POST['email']));}
	else{	$email = trim($arr['email']);}
	if(!empty($_POST['hora_comida'])){		  $hora_comida = strtoupper(trim($_POST['hora_comida']));}
	else{	$hora_comida = strtoupper(trim($arr['hora_comida']));}
	if(!empty($_POST['hora_general'])){		  $hora_general = strtoupper(trim($_POST['hora_general']));}
	else{	$hora_general = strtoupper(trim($arr['hora_general']));}
	if(!empty($_POST['email_ejecutivo'])){	  $email_ejecutivo = strtoupper(trim($_POST['email_ejecutivo']));}
	else{	$email_ejecutivo = trim($arr['email_ejecutivo']);}
	if(!empty($_POST['rfc'])){				  $rfc = strtoupper(trim($_POST['rfc']));}
	else{	$rfc = strtoupper(trim($arr['rfc']));}
	if(!empty($_POST['cp'])){				  $cp = strtoupper(trim($_POST['cp']));}
	else{	$cp = strtoupper(trim($arr['cp']));}
	if(!empty($_POST['territorial_banco'])){  $territorial_banco = strtoupper(trim($_POST['territorial_banco']));}
	else{	$territorial_banco = strtoupper(trim($arr['territorial_banco']));}
	if(!empty($_POST['territorial_sinttecom'])){ $territorial_sinttecom = strtoupper(trim($_POST['territorial_sinttecom']));}
	else{	$territorial_sinttecom = strtoupper(trim($arr['territorial_sinttecom']));}


	if($num == 0){
		$in_comercio = "INSERT INTO `comercios`(`comercio`, `propietario`, `estado`, `responsable`, `tipo_comercio`, `ciudad`, `colonia`, `direccion`, `afiliacion`, `telefono`, `rfc`, `email`, `email_ejecutivo`, `territorial_banco`, `territorial_sinttecom`, `hora_general`, `hora_comida`, `razon_social`, `cve_banco`,`cp`) 
				VALUES('$comercio','$propietario','$estado','$responsable','$tipo_comercio','$ciudad','$colonia','$direccion','$afiliacion','$telefono', '$rfc', '$email', '$email_ejecutivo', '$territorial_banco', '$territorial_sinttecom', '$hora_general', '$hora_comida', '$razon_social', '$cve','$cp')";
		$con_comercio = $conexion->query($in_comercio);
		if($con_comercio){
			echo '<label>SE REGISTRO EL COMERCIO '.$comercio.' CON LA AFILIACION: '.$afiliacion.' Y CLAVE BANCARIA: '.$cve.'</label>';
		}
		else{
			echo '<label>ERROR AL ACTUALIZAR, PROBLEMAS CON LA CONEXION<br></label>';
		}
	}
	else{
		$arr_afiliacion = $arr['afiliacion'];
		$arr_cve_banco = $arr['cve_banco'];
		$sql_up = "UPDATE `comercios` SET `comercio` = 'EL PESCADO SANCHEZ', `propietario` = '$propietario', `estado` = '$estado', `tipo_comercio`, = '$tipo_comercio', `responsable`= '$responsable', `ciudad` = '$ciudad', `direccion` = '$direccion', `colonia` = '$colonia', `telefono` = '$telefono',`email` = '$email',`email_ejecutivo`= '$email_ejecutivo',`territorial_banco`= '$territorial_banco',`territorial_sinttecom`= '$territorial_sinttecom',`hora_general`= '$hora_general',`hora_comida`= '$hora_comida' WHERE afiliacion = '$arr_afiliacion' and cve_banco = '$arr_cve_banco'";
		$con_up = $conexion->query($sql_up);
		if($con_up){
			echo '<label>SE ACTUALIZO EL COMERCIO "'.$arr['comercio'].'" CON LA AFILIACION '.$arr['afiliacion'].' Y CLAVE BANCARIA '.$arr['cve_banco'].'</label>';
		}
		else{
			echo '<label>ERROR AL ACTUALIZAR, PROBLEMAS CON LA CONEXION<br></label>';
		}
	}
}
else{
	if(empty($_POST['cve'])){
		echo '<label>EL CAMPOS "CLAVE BANCARIA" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['comercio'])){
		echo '<label>EL CAMPOS "COMERCIO" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['afiliacion'])){
		echo '<label>EL CAMPOS "AFILIACION" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['direccion'])){
		echo '<label>EL CAMPOS "DIRECCION" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['colonia'])){
		echo '<label>EL CAMPOS "COLONIA" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['ciudad'])){
		echo '<label>EL CAMPOS "CIUDAD" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['estado'])){
		echo '<label>EL CAMPOS "ESTADOS" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['tipo_comercio'])){
		echo '<label>EL CAMPOS "TIPO COMERCIO" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['rfc'])){
		echo '<label>EL CAMPOS "R.F.C" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if(empty($_POST['razon_social'])){
		echo '<label>EL CAMPOS "RAZON SOCIAL" ES NECESARIO PARA EL REGISTRO.</label><br>';
	}
	if($_POST['tipo_comercio'] == 'SELECCIONA'){
		echo '<label>SELECCIONA UN TIPO DE COMERCIO, ES NECESARIO PARA EL DE REGISTRO.</label><br>';
	}
}

?>