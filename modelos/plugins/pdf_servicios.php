<?php
require("../conexion.php");
include 'FPDF/fpdf.php';

$con = $conexion->query("SELECT * from `rutas`");
// echo var_dump($dato = mysqli_fetch_array($con));
$pdf = new FPDF();
$fecha_alta = date("Y-m-d");


$linea_uno = 27;
$linea_dos = 33;
$linea_tres = 39;
$cont = 0;
while($dato = mysqli_fetch_array($con)){

		if($cont == 0){
			$pdf->AddPage();
			$linea_uno = 27;
			$linea_dos = 33;
			$linea_tres = 39;
			$linea_cuatro = 45;
		}

		// TIPO DE FUENTE EN LA TABLA
		$pdf->SetFont('Arial','',8);

		$pdf->SetXY(10,$linea_uno);
		$pdf->Cell(30,6,'Fecha: '.$fecha_alta,1,0,'C',0);
		
		$pdf->SetXY(40,$linea_uno);
		$pdf->Cell(40,6,'ODT: '.$dato['odt'],1,0,'C',0);

		$pdf->SetXY(80,$linea_uno);
		$pdf->Cell(40,6,'Ticket: '.$dato['ticket'],1,0,'C',0);

		$pdf->SetXY(120,$linea_uno);
		$pdf->Cell(40,6,'ID Equipo: '.$dato['id_equipo'],1,1,'C',0);

		$pdf->SetXY(160,$linea_uno);
		$pdf->Cell(40,6,'AMEX: '.$dato['afiliacion_amex'],1,1,'C',0);

		$pdf->SetXY(10,$linea_dos);
		$pdf->Cell(35,6,'Telefono: '.$dato['telefono'],'LRB',1,'C',0);

		$pdf->SetXY(45,$linea_dos);
		$pdf->Cell(80,6,'Tipo Servicio: '.$dato['tipo_servicio'],'LRB',1,'C',0);

		$pdf->SetXY(125,$linea_dos);
		$pdf->Cell(75,6,'Subtipo: '.$dato['sub_tipo'],'LRB',1,'C',0);

		$pdf->SetXY(10,$linea_tres);
		$pdf->MultiCell(190,4,'Descripcion: '.trim($dato['descripcion']),'LRBT');

		$salto = 12 + 20 + (int)round(strlen($dato['descripcion'])) / 13;
		
		$cont++;
		$linea_uno +=  $salto;
		$linea_dos +=  $salto;
		$linea_tres +=  $salto;
		$linea_cuatro +=  $salto;

		$cont == 4 ? $cont -= 4 :null;

	}
	$pdf->Output();
	$conexion->query("DELETE from rutas");
?>


