<?php 
session_start();
include '../modelos/DBConnection.php';

$connection = $db->getConnection ( 'dsd' );

$tecnico = $_POST['tecnico'];
 

try {

    $sql = "SELECT comercio,responsable,afiliacion,telefono,direccion,colonia,ciudad,email,cve_banco FROM comercios where id in (SELECT comercio from eventos where tecnico = $tecnico ) ";
    $stmt = $connection->prepare ( $sql );
    $stmt->execute ( array () );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => 1 ];
}

echo json_encode($resultado);

?>