<?php 
session_start();
include '../modelos/DBConnection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$sql = " SELECT  eventos.id idevento ,eventos.odt,ifnull(hora_llegada,'') hora_llegada ,
        ifnull(hora_salida,'') hora_salida, 
        eventos.afiliacion,
        ifnull(comercios.comercio,'Sin Comercio') comercio,
        ifnull(eventos.comercio,0) comercioid,
        tipo_servicio.nombre servicio, 
        eventos.tecnico idtecnico ,
        count(img.id) totalimg , 
        eventos.tipo_servicio servicioid ,
        CASE WHEN eventos.tipo_servicio = 19 THEN 0 WHEN  eventos.tipo_servicio = 21 THEN 0 WHEN  eventos.tipo_servicio = 24 THEN 0
        WHEN  eventos.tipo_servicio = 25 THEN 0 WHEN  eventos.tipo_servicio = 18  THEN 0 WHEN  eventos.tipo_servicio = 5  THEN 0  ELSE 1 END  tpvinstaladorule,
        CASE WHEN eventos.tipo_servicio = 19 THEN 1 WHEN  eventos.tipo_servicio = 2 THEN 1 WHEN  eventos.tipo_servicio = 21 THEN 1
        WHEN  eventos.tipo_servicio = 13 THEN 1 WHEN  eventos.tipo_servicio = 24 THEN 1 WHEN  eventos.tipo_servicio = 25 THEN 1
        WHEN  eventos.tipo_servicio = 26 THEN 1 WHEN  eventos.tipo_servicio = 18 THEN 1 ELSE 0 END  tpvretiradorule,
		eventos.servicio subservicioid,
        eventos.tpv_retirado tpvretirado,
        eventos.tpv_instalado tpvinstalado,
        DATE(fecha_vencimiento) fechavencimiento ,eventos.fecha_alta,
        CASE WHEN  curdate() > fecha_vencimiento THEN 'red'
            WHEN  DATEDIFF(NOW(),fecha_vencimiento) = 1  THEN 'orange'
		    WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 24 THEN 'yellow'
		    WHEN HOUR( TIMEDIFF(NOW(),fecha_vencimiento)) <= 5  THEN 'red' 
            ELSE 'green' 
        END color,
        eventos.descripcion as description,
        eventos.estatus,
        ifnull(eventos.receptor_servicio,'') receptorservicio,
        ifnull(eventos.rollos_instalar,0) rollosinstalar,
        ifnull(eventos.rollos_entregados,0) rollosentregados,
		comercios.colonia,
		comercios.direccion,
		comercios.cp,	
		comercios.ciudad,
		comercios.estado,
		ifnull(CONCAT( eventos.hora_atencion ,'|',eventos.hora_atencion_fin),'') horaatencion,
		ifnull(CONCAT( eventos.hora_comida ,'|',eventos.hora_comida_fin),'') horacomida,
        eventos.folio_telecarga ,
        eventos.hora_ticket,
        eventos.id_caja,
        eventos.aplicativo,
        eventos.version					
        from eventos 
        LEFT JOIN comercios ON eventos.comercio = comercios.id
	    LEFT JOIN img ON img.odt = eventos.odt  AND  img.tecnico = eventos.tecnico
        ,tipo_servicio
	    where eventos.tecnico =  ?
        and eventos.estatus= 2 
	    AND eventos.tipo_servicio = tipo_servicio.id
	    AND eventos.fecha_alta > date(DATE_ADD(NOW(), INTERVAL -10 day))
	    group by eventos.odt,eventos.id ,eventos.afiliacion,comercios.comercio order by fecha_vencimiento DESC";


try {
    $stmt = $connection->prepare ( $sql );
    $stmt->execute ( array ($tecnico) );
    $resultado = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   
} catch ( PDOException $e ) {
    $resultado = [ 'error' => $e ];
}

echo json_encode($resultado);

?>