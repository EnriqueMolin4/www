<?php
session_start();
include '../conexion.php';
$afiliacion = $_POST['afiliacion'];

if($_SESSION['tipo_user'] == 'user'){
	$cve = $_SESSION['cve'];
	$sql = "SELECT * from comercios where afiliacion like '%$afiliacion%' and cve_banco = '$cve'";
}
else{
	$sql = "SELECT * from comercios where afiliacion like '%$afiliacion%'";
}
sleep(.3);

$con = $conexion->query($sql);

if(mysqli_num_rows($con) > 0){
	while($dato = mysqli_fetch_array($con)){
		echo '<input style="width:12%;margin:.25%" type="button" cve="'.$dato['cve_banco'].'" class="boton" value="'.$dato['afiliacion'].'" onclick="ingresar_valor(this.value,this)">';
	}
}
else{
	return 0;
}

?>