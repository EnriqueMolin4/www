<?php 
session_start();
include '../modelos/DBConnection.php';

$connection = $db->getConnection ( 'sinttecom' ); ( 'dsd' );



$sql = "select codigo ,concepto nombre from accesorios  WHERE estatus=1 ";

try {
    $stmt = $connection->prepare ($sql);
    $stmt->execute ( array () );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => $e ];
}

echo json_encode($resultado);

?>