<?php 
session_start();
include '../modelos/DBConnection.php';

$connection = $db->getConnection ( 'sinttecom' );

$tecnico = $_POST['tecnico'];

/*$sql = "select eventos.id, odt,eventos.afiliacion folio,fecha_alta,descripcion,ticket,direccion,colonia,
        GetNameById(servicio,'TipoServicio') servicio,
        GetNameById(estado,'Estado') estadoNombre,
        GetNameById(municipio,'Municipio') municipioNombre,
        GetNameById(tecnico,'Tecnico') tecnicoNombre ,
        GetNameById(comercio,'Comercio') comercioNombre ,
        GetNameById(servicio,'TipoServicio') servicioNombre,
        GetNameById(estatus,'Estatus') estatusNombre ,
        ifnull(visita_tecnicos.id,0) formularioId,
        visita_tecnicos.formulario
        from eventos 
        LEFT JOIN visita_tecnicos
        ON eventos.odt = visita_tecnicos.formulario->>'$.odt'
        WHERE eventos.id = $id "; */

$sql = "SELECT  eventos.id idevento ,eventos.odt,ifnull(hora_llegada,'') hora_llegada ,
        ifnull(hora_salida,'') hora_salida, 
        eventos.afiliacion,
        ifnull(comercios.comercio,'Sin Comercio') comercio,
        ifnull(eventos.comercio,0) comercioid,
        tipo_servicio.nombre servicio, 
        eventos.tecnico idtecnico ,
        count(img.id) totalimg , eventos.tipo_servicio servicioid ,
        eventos.tpv_retirado tpvretirado,
        eventos.tpv_instalado tpvinstalado	 	
        from eventos 
          LEFT JOIN comercios ON eventos.comercio = comercios.id
	  LEFT JOIN img ON img.odt = eventos.odt  AND  img.tecnico = eventos.tecnico
          ,tipo_servicio
	  where eventos.tecnico = $tecnico 
          and eventos.estatus=2 
	  AND eventos.tipo_servicio = tipo_servicio.id
	  -- AND date(eventos.fecha_alta) >= date(NOW())
	  group by eventos.odt,eventos.id ,eventos.afiliacion,comercios.comercio ";


try {
    $stmt = $connection->prepare ( $sql );
    $stmt->execute ( array () );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => $e ];
}

echo json_encode($resultado);

?>