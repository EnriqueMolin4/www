<?php
include '../conexion.php';

$con = $conexion->query("SELECT * from rutas");
$fecha = date("Y-m-d");

$cont = 0;
while($dato = mysqli_fetch_array($con)){
	if($cont <= 8){
		$doc .= '<div id="fecha">FECHA: '.$fecha.'</div>';
		$doc .= '<div id="odt">ODT: '.$dato['odt'].'</div>';
		$doc .= '<div id="ticket">TICKET: '.$dato['ticket'].'</div>';
		$doc .= '<div id="id-equipo">ID EQUIPO: '.$dato['id_equipo'].'</div>';
		$doc .= '<div id="amex">AMEX: '.$dato['afiliacion_amex'].'</div>';
		$doc .= '<div id="telefono">TELEFONO: '.$dato['telefono'].'</div>';
		$doc .= '<div id="tipo">TIPO SERIVIO: '.$dato['tipo_servicio'].'</div>';
		$doc .=	'<div id="subtipo">SUBTIPO: '.$dato['sub_tipo'].'</div>';
		$doc .= '<div id="descripcion">DESCRIPCION: '.$dato['descripcion'].'</div>';
	}
	if($cont == 8){
		$cont = $cont - 8;
		$doc .= '<br>';
	}
	$cont++;
}

include 'mpdf/mpdf.php';

$mpdf = new mPDF('c','A4');
$css = file_get_contents('css/style-rutas.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($doc);
$mpdf->Output('rutas.pdf','I');

?>
