<?php

$archivo = "R_SINTTECOM_".strtoupper($_POST['tabla']).".xlsx";

if(unlink($archivo)){
	echo $archivo.' BORRADO';
}

?>