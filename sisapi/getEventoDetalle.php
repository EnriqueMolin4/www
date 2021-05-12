<?php 
session_start();
include '../modelos/DBConnection.php';

$connection = $db->getConnection ( 'dsd' );

$eventoId = 13 ; //$_POST['eventoId'];

$sql = "select eventos.id, odt,afiliacion folio,fecha_alta,descripcion,ticket,direccion,colonia,
servicio,
GetNameById(estado,'Estado') estadoNombre,
GetNameById(municipio,'Municipio') municipioNombre,
GetNameById(tecnico,'Tecnico') tecnicoNombre ,
GetNameById(comercio,'Comercio') comercioNombre ,
GetNameById(servicio,'TipoServicio') servicioNombre,
GetNameById(estatus,'Estatus') estatusNombre ,
visita_tecnicos.id formularioId,
visita_tecnicos.formulario
from eventos LEFT JOIN visita_tecnicos on eventos.odt = visita_tecnicos.formulario->>'$.odt'
WHERE eventos.id = $eventoId 
";

try {
    $stmt = $connection->prepare ($sql);
    $stmt->execute ( array () );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => $e ];
}

echo json_encode($resultado);

?>