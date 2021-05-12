<?php 

include '../modelos/api_db.php';

$tecnico = $_POST['tecnico'];
$msg = '';
$counter = 0;
$totalTPV = 0;
$totlSIM = 0;
$totalRollos= 0;

$sql = "Select 'tpv' tipo,count(*) total  from inventario_tecnico,inventario  where  inventario.no_serie = inventario_tecnico.no_serie AND tecnico = $tecnico AND tipo = 1 AND inventario.estatus in (3,5)
		UNION ALL
		Select 'sims' tipo,count(*) total from inventario_tecnico,inventario where inventario.no_serie = inventario_tecnico.no_serie AND tecnico = $tecnico AND tipo = 2
		UNION ALL
		Select 'rollos' tipo,inventario_tecnico.cantidad total from inventario_tecnico,inventario where inventario.no_serie = inventario_tecnico.no_serie AND tecnico = $tecnico AND inventario_tecnico.no_serie = 'ROLS';
        ";

       $resultado =  $Api->select($sql,array ());
 
		foreach($resultado as $rst) {
			
			$total =  $rst['total']; 
			
			if ( $total == 0 && $rst['tipo'] == 'tpv' ) {
				$counter++;
				$msg = $msg."No tienes terminales en tu inventario \n ";
				$totalTPV = (int) $total;
			} else {
				$totalTPV = (int) $total;
			}
			
			if( $total == 0 && $rst['tipo'] == 'sims' ) {
				//$counter++;
				$msg = $msg."No tienes sims en tu inventario \n ";
				$totalSIM = (int) $total;
			} else {
				$totalSIM = (int) $total;
			}
			
			if( $total == 0 && $rst['tipo'] == 'rollos') {
				$counter++;
				$msg = $msg."No tienes rollos en tu inventario \n ";
				$totalRollos= (int) $total;
			} else {
				$totalRollos = (int) $total;
			}
			 
		}

 echo json_encode(['total' => $counter, 'msg' => $msg, 'totalTPV' => $totalTPV, 'totalSIM' => $totalSIM, 'totalROLLOS' => $totalRollos]);

?>