<?php 
 
include '../modelos/api_db.php';


$mensaje = '';
$resultado = 0;

$noguia = $_POST['noguia'];
$tecnico = $_POST['tecnico'];
$tipo = $_POST['tipo'];
$qty = (int) $_POST['cantidad'];
$today = date('Y-m-d H:i:s');
$cve_banco = $_POST['cvebanco'];

$resultado =  $Api->existInsumoInventarioTecnico($noguia,$tecnico,$tipo,$cve_banco);


if( $resultado == 0) {
	
	$mensaje = 2;
	
} else {
	if( $qty == (int) $resultado) {
		
		$cantAnt = $Api->existInsumoInventario($tecnico,$tipo,$cve_banco);

		$nuevaQty = (int) $cantAnt + $qty; 

		$sql = "UPDATE traspasos SET estatus = 1,ultima_act = '$today'
		where no_guia = '$noguia'
		AND cuenta_id = '$tecnico'
		AND no_Serie = '$tipo' 
		AND cve_banco = '$cve_banco' ";
		

		$Api->insert($sql,array());
		
		/* $sql = "UPDATE inventario_tecnico SET aceptada = 1,fecha_modificacion= '$today'
		where tecnico = '$tecnico'
		AND no_serie = '$tipo' "; */

		$aceptada = 1;
		$notas = "";

		/*$sql = " INSERT INTO inventario_tecnico (id,tecnico,no_serie,cantidad,no_guia,aceptada,notas,creado_por,fecha_creacion,fecha_modificacion) 
				VALUES (NULL,$tecnico,'$tipo',$qty,'$noguia',$aceptada,'$notas',$tecnico,'$today','$today') 
				ON DUPLICATE KEY     
				UPDATE cantidad = $nuevaQty
				,aceptada = $aceptada
				,fecha_modificacion = '$today'  ";
		
		$Api->insert($sql,array()); */
		
		$fecha = date ( 'Y-m-d H:m:s' );
			
			$existInv = $Api->getInsumos($tipo,$tecnico,$cve_banco);
			 
			if($existInv) {
				$newTotal = (int) $qty + $existInv['cantidad'];
				
				$sql = " UPDATE inventario_tecnico SET aceptada = 1 , no_guia = ?, cantidad=? ,fecha_modificacion=?
					WHERE no_serie = ?
					AND tecnico=?
				";
				
				$Api->insert($sql,array ($noguia,$newTotal,$fecha,$tipo,$tecnico));
				
				
			} else {
			
				$datafieldsInv = array('tecnico','no_serie','cantidad','no_guia','aceptada','notas','cve_banco','creado_por','fecha_creacion','fecha_modificacion');
		
				$question_marks = implode(', ', array_fill(0, sizeof($datafieldsInv), '?'));
				$sql = "INSERT INTO inventario_tecnico (" . implode(",", $datafieldsInv ) . ") VALUES (".$question_marks.")"; 

				$arrayString = array (
					$tecnico,
					$tipo,
					$qty,
					$noguia,
					1,
					NULL,
					$cve_banco,
					$tecnico,
					$fecha,
					$fecha
				);
				
				$Api->insert($sql,$arrayString);
				
			}
		
		$IdTraspasos = $Api->getIdTraspaso($noguia,$tecnico,$tipo,$cve_banco);
		
		$fecha = date ( 'Y-m-d H:m:s' );
		$datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
		
		$question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
		$sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 
	
		$arrayString = array (
			$IdTraspasos,
			$fecha,
			'ACEPTADO',
			9,
			$tipo,
			3,
			$qty,
			$tecnico,
			$tecnico
		);
		
		$Api->insert($sql,$arrayString);
		
		$mensaje = 1;
		
	} else {
		$mensaje = 0;
	}
}

echo  $mensaje;

?>