<?php 
session_start();
include '../modelos/api_db.php';

 

$tecnico = trim($_POST['tecnico']);
$noserie = trim($_POST['item']);
$noguia = trim($_POST['noguia']);
$resultado = 0;

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
    // Update inventario Traspasos
        $sql = " UPDATE inventario SET estatus_inventario= 3
                WHERE id_ubicacion = ?
                AND no_serie = ?
            ";
        $Api->insert($sql,array ($tecnico,$noserie));
        
        // Update inventario Tecnico
        $sql = " UPDATE inventario_tecnico SET aceptada = 1 
                WHERE no_serie = ?
                AND tecnico=?
            ";
        $Api->insert($sql,array ($noserie,$tecnico));

        $resultado = $id[0]['id'];
    } else {
        // Update inventario Traspasos
        $sql = " UPDATE inventario SET estatus_inventario= 2, ubicacion= 4
                WHERE  no_serie = ?
            ";
        $Api->insert($sql,array ($noserie));
        
        // Update inventario Tecnico
        $sql = " UPDATE inventario_tecnico  SET aceptada = 0
                WHERE no_serie = ?
                AND tecnico=?
            ";
        $Api->insert($sql,array ($noserie,$tecnico));

        $resultado = $id[0]['id'];
    }

} else {
    $resultado = 0;
}
 
echo $resultado;

?>