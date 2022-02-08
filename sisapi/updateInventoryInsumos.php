<?php 

include '../modelos/api_db.php';
$odt = $_POST['odt'];
$tecnico = $_POST['tecnico'];
$insumos = json_decode($_POST['insumos']);
 
$msg = ' Se enviaron los insumos';
$counter = 0;
$hoy = strtotime("now");
$fecha = date ('Y-m-d H:i:s',$hoy );
	
$result = json_encode([ 'odt' => $odt, 'tecnico' => $tecnico, 'insumos' => $insumos ]);
//Save odt
file_put_contents("json/insumos_".$tecnico."_".$fecha.".json",$result);

/*
foreach( $insumos as $insumo)
{
    $sqlHist = " SELECT * FROM inventario_tecnico WHERE no_serie=? AND tecnico=? ";
    $inv = $Api->select($sqlHist,$insumo['codigo'],$tecnico);
    $newInv = (int) $inv['cantidad'] - (int) $insumo['qty'];

    $sql = "UPDATE inventario_tecnico SET cantidad=? WHERE tecnico=? and no_serie=? ";
    $resultado =  $Api->insert($sql,array ($newInv,$tecnico,$insumo['codigo']));

    //Add to historial
    
    $datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
	
    $question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
    $sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 

    $arrayString = array (
        $inv[0]['id'],
        $fecha,
        'RETIRADO TECNICO',
        $inv[0]['ubicacion'],
        $insumo['codigo'],
        $item[0]['tipo'],
        1,
        $id_ubicacion,
        $user
    );
    *
} */
//$sql = "UPDATE eventos SET estatus=? WHERE odt=?";

//$resultado =  $Api->select($sql,array ($estatus,$odt));

$sqlOdt = "SELECT odt from eventos where tecnico = ?
AND eventos.fecha_alta > date(DATE_ADD(NOW(), INTERVAL -10 day)) AND estatus=2 ";

$odts =  $Api->select($sqlOdt,array ($tecnico));
 
 echo json_encode(['msg' => $msg, 'insumos' => $insumos, 'estatus' => 1,'odt' => $odts,'sql' => $sqlOdt ]);

?>