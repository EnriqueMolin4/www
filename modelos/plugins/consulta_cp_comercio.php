<?php

include '../conexion.php';

if(!empty($_POST['key_cp_com'])){
	$cp = trim($_POST['cp']);

	$con_cp = $conexion->query("SELECT * from cp_santander where cp like '$cp%'");

	$op = "";
	while($dato = mysqli_fetch_array($con_cp)){
		$op .= '<input onclick="datos_cp_comercio(this.value)" type="button" class="boton" value="'.$dato['cp'].'">';
	}
	echo $op;
}
if(!empty($_POST['key_find_dato'])){
	$cp = trim($_POST['cp']);
	$con_cp = $conexion->query("SELECT * from cp_santander where cp = '$cp'");
	$arr = [];
	if(mysqli_num_rows($con_cp) > 0){
		while($dato = mysqli_fetch_array($con_cp)){
			$arr[] = array(
				'cp' => $dato['cp'],
				'ciudad' => $dato['ciudad'],
				'estado' => $dato['estado'],
				'territorial_banco' => $dato['territorial_banco'],
				'territorial_sinttecom' => $dato['territorial_sinttecom']
			);
		}
		echo json_encode($arr);
	}
	else{
		echo '<br><label><center>EL CODIGO POSTAL NO SE ENCUENTRA EN EL REGISTRO</center></label>';
	}
}
?>