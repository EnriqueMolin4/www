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
		Select 'rollos' tipo,ifnull(inventario_tecnico.cantidad,0) total from inventario_tecnico  where  tecnico = $tecnico AND inventario_tecnico.no_serie = 'ROLS';
        ";

       $resultado =  $Api->select($sql,array ());
 
		foreach($resultado as $rst) {
			
			$total =  $rst['total']; 
			
			switch($rst['tipo']) {
				
				case 'tpv' :
				if($rst['total'] == '0') {
					$msg = $msg."No tienes terminales en tu inventario \n ";
					
				}  
				
				$totalTPV = (int) $total;
				break;
				case 'sims' :
				if($rst['total'] == '0') {
					$msg = $msg."No tienes sims en tu inventario \n ";
					
				}  
				
				$totalSIM = (int) $total;
				break;
				case 'rollos' :
				if($rst['total'] == '0') {
					$msg = $msg."No tienes rollos en tu inventario \n ";
					
				}  
				
				$totalRollos = (int) $total;
				break;
				
			}
			
			
			 
		}

 echo json_encode(['total' => $counter, 'msg' => $msg, 'totalTPV' => $totalTPV, 'totalSIM' => $totalSIM, 'totalROLLOS' => $totalRollos]);

?>