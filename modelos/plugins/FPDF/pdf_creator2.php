<?php

header("location: $_SERVER");

require("../conexion.php");
require('FPDF/fpdf.php');

$con = $conexion->query("SELECT * from recivos");

$pdf = new FPDF();
$fecha_alta = date("Y-m-d");

while($dato = mysqli_fetch_array($con)){

	$pdf->AddPage();
	// COLOR DE FONDO PARA LA CELDA
	$pdf->SetFillColor(232,232,232);
	// TIPO DE FUENTE EN LA TABLA
	$pdf->SetFont('Arial','',8);

	$pdf->SetX(110);
	$pdf->Cell(40,6,$fecha_alta,0,0,'C',0);

	$pdf->Ln();
	$pdf->SetX(135);
	$pdf->Cell(40,6,$dato['odt'],0,0,'C',0);

	$pdf->Ln(39);
	$pdf->SetX(45);
	$pdf->Cell(5,6,utf8_encode($dato['servicio']),0,0,'C',0);

	$pdf->Ln(15);
	$pdf->SetX(3);
	$pdf->Cell(35,6,$dato['afiliacion'],0,0,'C',0);
	$pdf->SetX(45);
	$pdf->Cell(60,6,$dato['comercio'],0,0,'C',0);
	$pdf->SetX(125);
	$pdf->Cell(80,4,$dato['direccion'],0,0,'C',0);
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(3);
	$pdf->Cell(55,9,$dato['colonia'],0,0,'C',0);
	$pdf->SetX(65);
	$pdf->Cell(55,9,$dato['ciudad'],0,0,'C',0);
	$pdf->SetX(130);
	$pdf->Cell(55,9,$dato['estado'],0,0,'C',0);

	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(5);
	$pdf->Cell(20,9,$dato['cp'],0,0,'C',0);
	$pdf->SetX(65);
	$pdf->Cell(55,9,$dato['tel_campo'],0,0,'C',0);
	$pdf->SetX(130);
	$pdf->Cell(55,9,$dato['email'],0,0,'C',0);
}

$pdf->Output();

?>