<?php 

include '../modelos/api_db.php';

 
$mensaje = '';



$tecnico = $_POST['tecnico'];
$insumo = $_POST['tipo'];
$qty = (int) $_POST['cantidad'];
$fecha = date ( 'Y-m-d H:m:s' );
$cve = $Api->getDefaultBancoCve();
$existeInventarioId = 0;
file_put_contents("json/insert_insumo.json",$tecnico."--".$insumo."--".$qty);
$tipo = $Api->getClaveInsumo($insumo);
$configuracion = $Api->getConfiguration('ValidarInventarioLocal');
$existInventarioGeneral = $Api->existItemInventario($insumo);
 


if( $existInventarioGeneral) {
	
	if( (int) $existInventarioGeneral['cantidad'] >= (int) $qty   ) {

		$existItem = $Api->existInsumoInventario($tecnico,$insumo);
		 
			if($existItem === "0" ) {
			
				if((int) $existItem >= 0) {

					$nuevovalor = (int) $existItem + $qty;
					$nuevaCant = (int) $existInventarioGeneral['cantidad'] - (int) $qty	;
						
						$sql = " UPDATE inventario_tecnico SET cantidad=?,fecha_modificacion=?  WHERE tecnico=? AND no_serie=?";
						$Api->insert($sql,  array( $nuevovalor,$fecha,$tecnico,$insumo));

						$sql = " UPDATE inventario  SET cantidad=?,fecha_edicion=?   WHERE id=?";
						$Api->insert($sql,  array($nuevaCant,$fecha ,$existInventarioGeneral['id']));
						$existeInventarioId =$existInventarioGeneral['id'];
						
						$status = 1;
						$error = 'Se Actualizo el Inventario del Tecnico';

					
				} else {
					
						$prepareStatement = "INSERT INTO `inventario_tecnico`
						( `tecnico`,`no_serie`,`cantidad`,`aceptada`,`creado_por`,`fecha_creacion`,`fecha_modificacion`)
						VALUES
						(?,?,?,?,?,?,?);
						";
								
						$new = $Api->insert($prepareStatement,  array($tecnico,$insumo,$qty,1,$tecnico,$fecha,$fecha));
						
						if($new) {
							$nuevaCant = (int) $existInventarioGeneral['cantidad'] - (int) $qty	;
							
							$sql = " UPDATE inventario  SET cantidad=?,fecha_edicion=?   WHERE id=?";
							$existeInventarioId = $Api->insert($sql,  array($nuevaCant,$fecha ,$existInventarioGeneral['id']));
						
						} 
			
					 
				}
			} else {
				
				if($existItem === false) {

					$prepareStatement = "INSERT INTO `inventario_tecnico`
						( `tecnico`,`no_serie`,`cantidad`,`aceptada`,`creado_por`,`fecha_creacion`,`fecha_modificacion`)
						VALUES
						(?,?,?,?,?,?,?);
						";
								
						$new = $Api->insert($prepareStatement,  array($tecnico,$insumo,$qty,1,$tecnico,$fecha,$fecha));
						
						if($new) {
							$nuevaCant = (int) $existInventarioGeneral['cantidad'] - (int) $qty	;
							
							$sql = " UPDATE inventario  SET cantidad=?,fecha_edicion=?   WHERE id=?";
							$existeInventarioId = $Api->insert($sql,  array($nuevaCant,$fecha ,$existInventarioGeneral['id']));
						
						} 

					
				} else {
					
					$nuevovalor = (int) $existItem + $qty;
					$nuevaCant = (int) $existInventarioGeneral['cantidad'] - (int) $qty	;
						
						$sql = " UPDATE inventario_tecnico SET cantidad=?,fecha_modificacion=?  WHERE tecnico=? AND no_serie=?";
						$Api->insert($sql,  array( $nuevovalor,$fecha,$tecnico,$insumo));

						$sql = " UPDATE inventario  SET cantidad=?,fecha_edicion=?   WHERE id=?";
						$Api->insert($sql,  array($nuevaCant,$fecha ,$existInventarioGeneral['id']));
						$existeInventarioId =$existInventarioGeneral['id'];
						
						$status = 1;
						$error = 'Se Actualizo el Inventario del Tecnico';	
			
					 
				}
			}

		if( $existeInventarioId != 0 ) { 

			$prepareStatement = "INSERT INTO `historial`
				( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
				VALUES
				(?,?,?,?,?,?,?,?);
			";
			$arrayString = array (
					$existeInventarioId,
					$fecha,
					'INV TECNICO',
					9,
					$insumo,
					3,
					$qty,
					$tecnico
			);

			$Api->insert($prepareStatement,$arrayString);
			
			$status = 1;
			$error = 'Se Actualizo el Inventario del Tecnico';
			
		} else {
			$status = 0;
			$error = 'Hay un error al cargar el Inventario del Tecnico';
		}

		

	} else {
		$status = 0;
		$error = 'No tiene la cantidad necesario de Insumos en Inventario General ';
	}

    $resultado =  ['status' => $status, 'error' => $error, 'cant' => $existItem  ];

} else {
    
    
    $resultado =  ['status' => 0, 'error' => 'No existe el Insumo en el Inventario General','existe' => $existItem];
    
}

echo json_encode($resultado);

?>