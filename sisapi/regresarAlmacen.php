<?php 

include '../modelos/api_db.php';

$connection = $db->getConnection ( 'sinttecom' ); 

//$eventoId = $_POST['eventoId'];
$noserie = $_POST['noserie'];
$tecnico = $_POST['tecnico'];
$fecha = date ( 'Y-m-d H:m:s' );

//$sql = "UPDATE  inventario_tecnico SET aceptada=0  WHERE aceptada=1 and tecnico= ? and no_serie = ? ";


//$Api->insert($sql, array($tecnico,$noserie));

$existeInventario = $Api->existItemInventario($noserie);

$sql = "UPDATE inventario SET estatus=7 WHERE no_serie = ? and id_ubicacion=? ";

$Api->insert($sql, array($noserie,$tecnico));



$prepareStatement = "INSERT INTO `historial`
    ( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`,`modified_by`)
    VALUES
    (?,?,?,?,?,?,?,?,?);
";

$arrayString = array (
        $existeInventario['id'],
        $fecha,
        'DAÑADA',
        9,
        $noserie,
        $existeInventario['tipo'],
        1,
        $tecnico,
        $tecnico
);

$Api->insert($prepareStatement,$arrayString);

echo 1;

?>