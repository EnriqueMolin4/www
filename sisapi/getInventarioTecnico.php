<?php 
session_start();
include '../modelos/DBConnection.php';

$connection = $db->getConnection ( 'sinttecom' );

$tecnico = $_POST['tecnico'];




$sql = "select  distinct
    it.id,
    it.tecnico,
    CASE WHEN i.tipo = 1 THEN 'TPV' WHEN i.tipo = 2 THEN 'SIM' WHEN i.tipo = 3 THEN 'INSUMO' WHEN i.tipo=4 THEN 'ACESORIOS' ELSE 'INSUMO' END tipo,
    it.no_serie,
    CASE WHEN i.tipo = 1 THEN IFNULL(GetNameById(i.modelo,'Modelo'),'NA') WHEN i.tipo=2 THEN IFNULL(GetNameById(i.modelo,'Carrier'),'NA') ELSE  IFNULL(GetNameById(i.modelo,'Modelo'),'NA')  END modelo,
    IFNULL(GetNameById(i.conectividad,'Conectividad'),'NA') conectividad,
    CASE WHEN i.tipo = 1 THEN 1 ELSE it.cantidad END cantidad,
    it.no_guia,
    it.aceptada,
    it.notas,
    ifnull(tm.nombre,'DISPONIBLE') estatus,
    ifnull(tv.nombre,'EN PLAZA') estatus_inventario,
    it.creado_por,
    DATE(it.fecha_creacion) fecha_creacion,
    DATE(it.fecha_modificacion)  fecha_modificacion,
	CASE WHEN it.cantidad <= 15 THEN 'green' WHEN it.cantidad BETWEEN 16 AND 30 THEN 'yellow' WHEN it.cantidad > 30 THEN 'red' ELSE 'white'  END color,
	it.cve_banco,
	b.banco
    from inventario_tecnico it
    LEFT JOIN inventario i ON it.no_serie = i.no_serie  and i.cve_banco = it.cve_banco
    LEFT JOIN tipo_estatus_modelos tm ON  i.estatus  = tm.id 
    LEFT JOIN tipo_estatus_inventario tv  ON i.estatus_inventario = tv.id    
	LEFT JOIN bancos b ON b.cve = it.cve_banco
    WHERE it.tecnico = $tecnico
    AND it.aceptada= 1 
    ";


try {
    $stmt = $connection->prepare ( $sql );
    $stmt->execute ( array ($tecnico) );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => $e ];
}
 

echo json_encode($resultado);

?>