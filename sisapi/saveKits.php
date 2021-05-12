<?php 

include '../modelos/api_db.php';

   
    $data = json_decode($_POST['data']);
    $odt = trim($_POST['odt']);
    $tecnico = $_POST['tecnico'];
    $comercio = $Api->getComerciofromOdt($odt);

    foreach($data as $dat) {
        
        if( $dat->codigo  != 'ROLS') {
            $fecha = date ( 'Y-m-d H:m:s' );

            $invenInsumo = $Api->getInsumos($dat->codigo,$tecnico);
            $InsumoActual = max((int) $invenInsumo['cantidad'] - (int) $dat->valor,0);

            $queryRollos = " UPDATE inventario_tecnico SET cantidad=?,fecha_modificacion=? WHERE id =?";
            $Api->insert($queryRollos,array($InsumoActual,$fecha,$invenInsumo['id']));

            if($invenInsumo['id']) {

                $prepareStatement = "INSERT INTO `historial`
				( `inventario_id`,`fecha_movimiento`,`tipo_movimiento`,`ubicacion`,`no_serie`,`tipo`,`cantidad`,`id_ubicacion`)
				VALUES
				(?,?,?,?,?,?,?,?);
                ";
                $arrayString = array (
                        $invenInsumo['id'],
                        $fecha,
                        'EN CLIENTE',
                        2,
                        $dat->codigo,
                        3,
                        1,
                        $comercio
                );

                $Api->insert($prepareStatement,$arrayString);

            }  
        }
    }

        
    $resultado =  ['estatus' => 1, 'error' => 'Se Cargo Correctamente la Informacion', 'data' => $data];

    echo json_encode($resultado);

?>