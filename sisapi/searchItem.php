<?php 
session_start();
include '../modelos/DBConnection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connection = $db->getConnection ( 'sinttecom' );

$tecnico = $_POST['tecnico'];
$noserie = $_POST['item'];


$sql = "select id
        from inventario_tecnico 
        WHERE tecnico = $tecnico
        AND aceptada= 0
        AND no_serie LIKE '%$noserie%'
        ";


try {
    $stmt = $connection->prepare ( $sql );
    $stmt->execute ( array () );
    $resultado = $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
    
} catch ( PDOException $e ) {
    $resultado = 0;
}

if($resultado) {
    $sql = " UPDATE inventario_tecnico SET aceptada = 1 WHERE id = $resultado ";

    try {
        $stmt = $connection->prepare ( $sql );
        $stmt->execute ( array () );
        $resultado = $resultado;
        
    } catch ( PDOException $e ) {
        $resultado = 0;
    }
} else {
    $resultado = 0;
}
 
echo $resultado;

?>