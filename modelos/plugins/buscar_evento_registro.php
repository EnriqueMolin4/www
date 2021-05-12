<?php

include 'conexion.php';
!empty($_POST['afiliacion']) ? $afiliacion = $_POST['afiliacion'] : $afiliacion = '';
!empty($_POST['odt']) ? $odt = $_POST['odt'] : $odt = '';
!empty($_POST['afili_odt']) ? $afili_odt = trim($_POST['afili_odt']) : $afili_odt = '';

if(!empty($afiliacion)){
	$con = $conexion->query("SELECT * from `eventos` where afiliacion = '$afiliacion' and estatus != 'CERRADO'");
	if(mysqli_num_rows($con) > 0){
		while($dato = mysqli_fetch_array($con)){
			echo '<input type="button" class="boton" afiliacion="'.$dato['afiliacion'].'"class="opcion_odt" value="'.$dato['odt'].'" onclick="buscar_odt_evento(this.value,this)">';
		}	
	}
	else{
		echo '<strong>LA AFILIACION NO TIENE EVENTOS REGISTRADOS</strong>';
	}
}

if(!empty($odt) and !empty($afili_odt)){
	$con = $conexion->query("SELECT * from `eventos` where odt like '%$odt%' and afiliacion like '%$afili_odt%'");

	while($dato = mysqli_fetch_array($con)){
		echo '<input type="button" class="boton" afiliacion="'.$dato['afiliacion'].'"class="opcion_odt" value="'.$dato['odt'].'" onclick="buscar_odt_evento(this.value,this)">';
	}
}
