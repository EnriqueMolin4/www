<?php
!empty($_POST['pdf']) ? $pdf = $_POST['pdf'] : $pdf = '';
!empty($_POST['desde']) ? $desde = $_POST['desde'] : $desde = '';

if(!empty($desde)){
	if($pdf == 'ruta'){
		require_once 'importar_rutas.php';
	}
	if($pdf == 'papeleta'){
		require_once 'importar.php';
	}
	if(empty($pdf)){
		echo 'SELECCIONA QUE VAS A IMPRIMIR "RUTA" O "PAPELETA"';
	}
}
else{
	echo 'INDICA DESDE QUE FILA SE IMPRIMIRA';
}
?>