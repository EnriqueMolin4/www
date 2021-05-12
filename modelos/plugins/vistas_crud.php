<?php
include '../conexion.php';

if($_POST['t_tabla'] == 'cve'){
	$n_banco = strtoupper(trim($_POST['n_banco']));
	$cve = strtoupper(trim($_POST['cve']));

	$sql = "INSERT into `bancos` (`banco`,`cve`) values ('$banco','$cve')";
}
elseif($_POST['t_tabla'] == 'cp'){
	$cp = trim(strtoupper($_POST['cp']));
	$cve = trim(strtoupper($_POST['cve']));
	$estado = trim(strtoupper($_POST['estado']));
	$ciudad = trim(strtoupper($_POST['ciudad']));
	$colonia = trim(strtoupper($_POST['colonia']));
	$t_sinttecom = trim(strtoupper($_POST['t_sinttecom']));
	$t_banco = trim(strtoupper($_POST['t_banco']));
	$t_atencion = trim(strtoupper($_POST['t_atencion']));

	$sql = "INSERT into `cp_santander` (`cp`,`cve`,`estado`,`ciudad`,`colonia`,`territorial_sinttecom`,`territorial_banco`,`tiempo_atencion`) values ('$cp','$cve','$estado','$ciudad','$colonia','$t_sinttecom','$t_banco','$t_atencion')";
}
elseif($_POST['t_tabla'] == 'insumo'){
	$insumo = trim(strtoupper($_POST['insumo']));

	$sql = "INSERT into `kit_bienvenida` (`nombre`) values ('$insumo')";
}
elseif($_POST['t_tabla'] == 'carrier'){
	$carrier = trim(strtoupper($_POST['carrier']));
	$longitud = trim(strtoupper($_POST['longitud']));

	$sql = "INSERT into `m_sim` (`m_sim`,`longitud`) values ('$carrier','$longitud')";
}
elseif($_POST['t_tabla'] != 'carrier' and $_POST['t_tabla'] != 'insumo' and $_POST['t_tabla'] != 'cp' and $_POST['t_tabla'] != 'cve'){
	echo '<br><label>ALERTA DE REGISTRO</label><br><br>';
	echo '<label><center>LA SECCION SOLICITADA NO EXISTE</center></label>';
}

if($con = $conexion->query($sql)){
	echo '<br><label>ALERTA DE REGISTRO</label><br><br>';
	echo '<label><center>SE RE ALIZO EL REGISTRO CON EXITO</center></label>';
}
else{
	echo '<br><label>ALERTA DE REGISTRO</label><br><br>';
	echo '<label><center>NO SE RE ALIZO EL REGISTRO, CONSULTA AL ADMINISTRADOR</center></label>';
}
?>
