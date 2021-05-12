<?php

include '../conexion.php';
echo 'sisisis';
$con = $conexion->query("SELECT * from `nuevas_imgs`");
$odt = [];
while($dato = mysqli_fetch_array($con)){
// 	if(!in_array($dato['odt'],$odt)){
// 		$odt[] = $dato['odt'];
// 	}
echo $dato['alerta'];
}

?>