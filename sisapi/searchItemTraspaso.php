<?php 
include '../modelos/api_db.php';

 

$tecnico = trim($_POST['tecnico']);
$noserie = trim($_POST['item']);
$noguia = trim($_POST['noguia']);
$resultado = 0;
$qty = 1;



//Buscar el No Serie en el Traspaso
$sql = "Select id from traspasos
        WHERE no_guia = '$noguia'
        AND cuenta_id = $tecnico
        AND no_serie = '$noserie'
        ";

$id =  $Api->select($sql,array ());

$traspasoData = $Api->getTraspasoInfo($noserie);

if($id) {
    // Update Estatus Traspasos
    $sql = " UPDATE traspasos SET estatus = 1 
            WHERE no_guia = ?
            AND cuenta_id = ?
            AND no_serie = ?
           ";
	$Api->insert($sql,array ($noguia,$tecnico,$noserie));

    if($traspasoData[0]['tipo_traspaso'] == '0') {
        $tipo_movimiento = 'ACEPTADO';
    // Update inventario Traspasos
        $sql = " UPDATE inventario SET estatus_inventario= 3,ubicacion=9
                WHERE id_ubicacion = ?
                AND no_serie = ?
            ";
        $Api->insert($sql,array ($tecnico,$noserie));
        
        // Update inventario Tecnico
        $sql = " UPDATE inventario_tecnico SET aceptada = 1 , no_guia = ?
                WHERE no_serie = ?
                AND tecnico=?
            ";
        $Api->insert($sql,array ($noguia,$noserie,$tecnico));

        $resultado = $id[0]['id'];
    } else {

        $tipo_movimiento = 'RETORNO DAÑADA';
        // Update inventario Traspasos
        $sql = " UPDATE inventario SET estatus_inventario= 2, ubicacion= 4
                WHERE  no_serie = ?
            ";
        $Api->insert($sql,array ($noserie));
        
        // Update inventario Tecnico
        $sql = " UPDATE inventario_tecnico  SET aceptada = 0, no_guia = ?
                WHERE no_serie = ?
                AND tecnico=?
            ";
        $Api->insert($sql,array ($noguia,$noserie,$tecnico));

        $resultado = $id[0]['id'];
        
    }

    switch($traspasoData[0]['tipo']) {

        case 'TPV';
        $tipo = 1;
        break;
        case 'SIM';
        $tipo = 2;
        break;
        case 'INSUMO';
        $tipo = 3;
        break;
        default:
        $tipo = 1;

    } 

    $fecha = date ( 'Y-m-d H:m:s' );
    $IdInventario = $Api->getIdInventario($noserie);

    $datafieldsHistoria = array('inventario_id','fecha_movimiento','tipo_movimiento','ubicacion','no_serie','tipo','cantidad','id_ubicacion','modified_by');
    
    $question_marks = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
    $sql = "INSERT INTO historial (" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marks.")"; 

    $arrayString = array (
        $IdInventario,
        $fecha,
        $tipo_movimiento,
        9,
        $noserie,
        $tipo,
        $qty,
        $tecnico,
        $tecnico
    );
    
    $Api->insert($sql,$arrayString);

} else {
    $resultado = 0;
}
 
echo $resultado;

?>