<?php

session_start();
//ini_set('memory_limit', '512M')
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

date_default_timezone_set('America/Monterrey');
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'IConnections.php';
class Reportes implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection ( 'sinttecom' );
		self::$logger=  $log;
	}
	function fetch() {
		if (isset ( self::$connection )) {
			return self::execute_sel ();
		} else {
			return array ();
		}
	}
	private function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: reportes_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: reportes_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
    function getEventos($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $tipo = $params['tipo_evento'];
        $estatus = $params['estatus_busqueda'];
        $filter = "";

        if($tipo != '0') {
            $filter .= " AND servicio = $tipo ";
        }

        if($estatus != '0') {
            $filter .= " AND estatus = $estatus ";
        }

        $sql = "SELECT GetNameById(cve_banco,'Banco') CveBancaria,GetNameById(servicio,'TipoServicio') servicio, afiliacion Folio, GetNameById(comercio,'Comercio') cliente, direccion  ,colonia,
                GetNameById(estado,'Estado') Estado,GetNameById(municipio,'Municipio') municipio,telefono,odt,REPLACE(REPLACE(descripcion, '\r', ''), '\n', '') descripcion,ticket,GetNameById(estatus,'Estatus') Estatus
                from eventos 
                WHERE fecha_alta BETWEEN ?  AND ? 
                $filter ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getEventos();	Functionality: Get VO Eventos;	Log:" . $e->getMessage () );
        }
	}

	function getVo($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $estatus = $params['estatus_busqueda'];
        $filter = "";

        if($estatus != '0') {
            $filter .= " AND estatus = $estatus ";
        }

        $sql = "SELECT GetNameById(cve_banco,'Banco') CveBancaria,GetNameById(servicio,'TipoServicio') servicio, afiliacion Folio, receptor_servicio cliente, direccion  ,colonia,
                GetNameById(estado,'Estado') Estado,GetNameById(municipio,'Municipio') municipio,telefono,odt,REPLACE(REPLACE(descripcion, '\r', ''), '\n', '') descripcion,ticket,
                GetNameById(estatus,'Estatus') Estatus
                from eventos where servicio= 15 
                AND fecha_alta BETWEEN ?  AND ? 
                $filter ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getVo();	Functionality: Get VO Eventos;	Log:" . $e->getMessage () );
        }
	}

    function getImagenesTecnico($params) {

        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];
        $tecnico = $params['tecnico'];
        $filter = "";

        if($tecnico != '0') {
            $filter .= " AND tecnico = $tecnico ";
        }

        $sql = "Select *
				FROM view_odt_img
				WHERE ultima_act BETWEEN ?  AND ? 
                $filter ";
				
		self::$logger->error ($sql);
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getImagenesTecnico();	Functionality: Get Imagenes Tecnico;	Log:" . $e->getMessage () );
        }
    }
    
    function getInventarioCampo($params) {
        $inicio = $params['fechaVen_inicio'];
        $final = $params['fechaVen_fin'];


        $sql = "Select 
				eventos.ODT,
				eventos.afiliacion,
				cuentas.nombre Tecnico,
				eventos.fecha_alta ,
				eventos.fecha_atencion ,
				evidencias.fecha  FechaEvidencias,
				eventos.tpv_retirado tpv_retirado, 
				eventos.tpv_instalado tpv_instalado,
				eventos.sim_retirado sim_retirado,
				eventos.sim_instalado sim_instalado,
				tipo_estatus.nombre Estatus, 
				tipo_servicio.nombre Servicio,
				tipo_subservicios.nombre SubServicio,
				evidencias.cantImagenes 
                from eventos
                LEFT JOIN tipo_subservicios ON eventos.servicio = tipo_subservicios.id
                LEFT JOIN tipo_servicio ON eventos.tipo_servicio = tipo_servicio.id ,cuentas,tipo_estatus,
                (SELECT odt,MAX(fecha) fecha,count(id) cantImagenes FROM img group by odt) evidencias
                WHERE eventos.odt = evidencias.odt
                AND eventos.tecnico = cuentas.id  
                AND eventos.estatus not in  (1)
                AND eventos.tecnico not in (128)
                AND eventos.estatus = tipo_estatus.id
                AND evidencias.fecha BETWEEN ?  AND ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($inicio,$final));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getInventarioCampo();	Functionality: Get Imagenes Tecnico;	Log:" . $e->getMessage () );
        }
    }


    ////////REPORTE ALMACEN////
    function getubi() {
		
		
		$sql = "SELECT * from tipo_ubicacion where status=1 AND almacen=1  order by almacen DESC"; /* tipo_ubicacion */
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getubi();	Functionality: Get Ubicaciones;	Log:" . $e->getMessage () );
        }
	}
    function getEstatus() /*tipo_estatus_modelos*/
    {
		
		$sql = "select * from tipo_estatus_modelos WHERE estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getEstatus();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getubicacion() /* tipo_estatus_inventario*/
    {
		
		$sql = "select * from tipo_estatus_inventario where estatus=1";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: reportes_db.php;	Method Name: getubicacion();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
    }

    function getAlmaceninventario($params,$total) {

	/* 	$start = $params['start'];
		$length = $params['length']; */

		$filter = "";
		$param = "";
		$where = "";
        $queryInsumos = "";
		$ubicacion = is_null($params['tipo_ubicacion']) ? '0' : implode(', ',$params['tipo_ubicacion']) ;
		$estatus = is_null($params['tipo_estatus']) ? '0' : implode(', ',$params['tipo_estatus']);
		$producto = is_null($params['tipo_producto']) ? '0' : implode(', ',$params['tipo_producto']);
		$estatusubicacion = is_null( $params['tipo_estatusubicacion'] ) ? '0' : implode(', ',$params['tipo_estatusubicacion']) ;
		$almacen = $_SESSION['almacen'];
        $insumos = strpos($producto, 3);

        if( in_array(3,$params['tipo_producto'])  ) {

            $queryInsumos = " UNION ALL
                    SELECT 
                    'Insumos' tipoNombre,
                    no_serie,
                    NULL modelo,
                    'DISPONIBLE_NUEVO' estatus,
                    'EN PLAZA'  estatus_inventario,
                    CONCAT(du.nombre,' ',du.apellidos) ubicacion,
                    fecha_modificacion,
                    it.cantidad
                    FROM inventario_tecnico it, detalle_usuarios du
                    WHERE it.tecnico = du.cuenta_id
                    AND it.no_serie in (SELECT codigo FROM tipo_insumos)
            ";
        }

		if( $ubicacion != '0' ) {

            $where .= " AND inv.id_ubicacion in ( $ubicacion )";
		}

		if( $estatusubicacion != '0' ) {
			$where .= " AND inv.estatus_inventario in  ( $estatusubicacion )";
			if($_SESSION['tipo_user'] != 'AL') {
				
				//$where .= "  AND inv.id_ubicacion in  (Select id from cuentas where almacen = $almacen ) ";
				
			}
			
		}
		
		if( $estatus != '0' ) {
			$where .= " AND inv.id_estatus in  ( $estatus ) ";
		}

		if( $producto != '0' ) {
			$where .= " AND inv.tipo in ( $producto )";
		}

		/* if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length"; 
		} */

		if( !empty($params['search']['value'])) {   
			$where .=" AND ";
			$where .=" ( m.modelo LIKE '".$params['search']['value']."%' ";
			$where .=" OR inv.no_serie LIKE '".$params['search']['value']."%' ";
			$where .=" OR em.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR tu.nombre LIKE '".$params['search']['value']."%'  )";

		}
		
		if($_SESSION['tipo_user'] != 'admin' && $_SESSION['tipo_user'] != 'supervisor' && $_SESSION['tipo_user'] != 'CA' && $_SESSION['tipo_user'] != 'AN' && $_SESSION['tipo_user'] != 'AL') {
			$userId = $_SESSION['userid'] ;
			
			//$where .= " ( AND inv.id_ubicacion in  (Select id from cuentas where almacen = $almacen ) OR tu.id = $almacen )";
		}

		$sql = " SELECT 
						  CASE WHEN inv.tipo = '1' THEN 'TPV' WHEN inv.tipo = '2' THEN 'SIM' WHEN inv.tipo = '3' THEN 'Insumos' WHEN inv.tipo = '4' THEN 'Accesorios' END tipoNombre,
						  inv.no_serie,	
						   CASE WHEN inv.tipo = '1' THEN m.modelo WHEN inv.tipo = '2' THEN c.nombre WHEN  inv.tipo= 4 THEN a.concepto END modelo,
						   em.nombre estatus,
						   ei.nombre estatus_inventario,
						   CASE WHEN inv.ubicacion= 9 THEN CONCAT(du.nombre,' ',du.apellidos) ELSE tu.nombre END  ubicacion,
							inv.fecha_edicion fecha_modificacion,
							CASE WHEN inv.tipo = '1' THEN '1' WHEN inv.tipo = '2' THEN '1' ELSE inv.cantidad END cantidad
							FROM inventario inv
							LEFT JOIN modelos m  ON m.id = inv.modelo
							LEFT JOIN carriers c  ON c.id = inv.modelo
							LEFT JOIN accesorios a ON a.id = inv.modelo
							LEFT JOIN tipo_estatus_modelos em ON em.id = inv.estatus
							LEFT JOIN tipo_estatus_inventario ei ON ei.id = inv.estatus_inventario
							LEFT JOIN tipo_ubicacion tu ON tu.id = inv.id_ubicacion
							LEFT JOIN detalle_usuarios du ON du.cuenta_id = inv.id_ubicacion
							-- LEFT JOIN comercios c ON c.afiliacion = inv.id_ubicacion
							WHERE inv.no_serie is not null
                            $where
                            $queryInsumos
					        ORDER BY ubicacion ";


				
		self::$logger->error ($sql.' '.$estatusubicacion);
		
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: reportes_db.php;	Method Name: getAlmaceninventario();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    ///////REPORTE ALMACEN END////
    

    //REPORTEADOR DETALLE EVENTO
    
    function getDetEvento($params){

        $filter = "";
        $param = "";
        $where = "";

        $fecha_alta         = $params['fecha_alta'];
        $fecha_hasta        = $params['fecha_hasta'];
        $estado             = isset($params['estado']) ? $params['estado'] : array();
        $tipo_servicio      = isset($params['tipo_servicio']) ? $params['tipo_servicio'] : array();
        $tipo_subservicios  = isset($params['tipo_subservicio']) ? $params['tipo_subservicio'] : array();
        $estatus_servicio   = isset($params['estatus_servicio']) ? $params['estatus_servicio'] : array();
        $fecha_cierre       = $params['fecha_cierre'];
        $fecha_cierre_hasta       = $params['hasta_fc'];
    


        if( sizeof($estado) > 0) {

            $estadoList = implode(",", $estado);

            $where .= " AND c.estado in ($estadoList) ";
        }


        if ( sizeof($tipo_servicio) != '0')
        {
            $tiposervicio = implode(",",$tipo_servicio);
            $where .= " AND eventos.tipo_servicio in ($tiposervicio) ";
        }

        if ( sizeof($tipo_subservicios) != '0' )
        {
            $tiposubservicio = implode(",",$tipo_subservicios);
            $where .= " AND eventos.servicio IN ( $tiposubservicio) ";
        }

        if ( sizeof($estatus_servicio) > 0 ) 
        {
            $estatus_servicioList = implode(",",$estatus_servicio);
			if($estatus_servicioList != '0') {
				$where .= " AND eventos.estatus_servicio in ($estatus_servicioList) ";
			}
        } 

        if($fecha_alta != '') {
            $where .= " AND DATE(eventos.fecha_alta) >= '$fecha_alta' ";
        }

        if($fecha_hasta != '') {
            $where .= " AND DATE(eventos.fecha_alta) <= '$fecha_hasta' ";
        }

        if ($fecha_cierre != '') 
        {
            $where .= " AND DATE(eventos.fecha_cierre) >= '$fecha_cierre'  ";
        }

        if ($fecha_cierre_hasta != '') 
        {
            $where .= " AND DATE(eventos.fecha_cierre) <= '$fecha_cierre_hasta'  ";
        }

        $sql = "SELECT
                    eventos.odt,eventos.afiliacion,ts.nombre servicioNombre,tss.nombre subservicioNombre,eventos.fecha_alta,eventos.fecha_vencimiento,eventos.fecha_cierre,c.comercio,eventos.colonia,
                    eventos.municipio,eventos.estado,eventos.direccion,eventos.telefono,eventos.hora_atencion,eventos.hora_comida,eventos.fecha_asignacion,eventos.receptor_servicio,eventos.fecha_atencion,
                    eventos.hora_llegada,eventos.hora_salida,eventos.descripcion,ts.nombre nombreServicio,
                    CONCAT(u.nombre,' ',IFNULL(u.apellidos, '')) tecnicoNombre,
                    te.nombre estatus,eventos.id_caja,eventos.afiliacionamex,eventos.amex,tv.nombre version,ta.nombre aplicativo,eventos.producto,eventos.rollos_instalar,eventos.rollos_entregados,
                    eventos.tpv_instalado,eventos.tpv_retirado,eventos.sim_instalado,eventos.sim_retirado,eventos.comentarios,eventos.comentarios_cierre,eventos.comentarios_validacion,
                    eventos.folio_telecarga,
                CASE WHEN ce.serie = 1 THEN 'SI' ELSE 'NO' END FaltaSerie,
                CASE WHEN ce.evidencia = 1 THEN 'SI' ELSE 'NO' END FaltaEvidencia,  
                CASE WHEN ce.informacion = 1 THEN 'SI' ELSE 'NO' END FaltaInformacion,
                CASE WHEN ce.ubicacion = 1 THEN 'SI' ELSE 'NO' END FaltaUbicacion,
                CONCAT(du.nombre,' ',IFNULL(du.apellidos,'')) modificado_por
                FROM eventos
                JOIN detalle_usuarios u ON u.cuenta_id = eventos.tecnico
                JOIN comercios c ON c.id = eventos.comercio
                JOIN tipo_estatus te ON te.id = eventos.estatus
                JOIN tipo_servicio ts ON ts.id = eventos.tipo_servicio
                JOIN tipo_subservicios tss ON tss.id = eventos.servicio
                LEFT JOIN tipo_version tv ON tv.id = eventos.version
                LEFT JOIN tipo_aplicativo ta ON ta.id = eventos.aplicativo
                LEFT JOIN detalle_usuarios du ON du.cuenta_id = eventos.modificado_por
                LEFT JOIN checklist_evento ce ON eventos.odt = ce.odt
                -- LEFT JOIN inventario tpvIn on eventos.tpv_instalado = tpvIn.no_serie AND tpvIn.tipo =1
                -- LEFT JOIN inventario tpvRe ON eventos.tpv_retirado = tpvRe.no_serie AND tpvRe.tipo = 1
                -- WHERE eventos.fecha_alta BETWEEN '$fecha_alta' AND '$fecha_hasta'
                $where 
				 
                ";
        self::$logger->error ($sql);
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute();
            return $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) 
        {
            self::$logger->error ("File: reportes_db.php;   Method Name: getDetEvento(); Funcitonality: Get Report To CVS;    Log:" . $e->getMessage () );   
        }


    }

    function getEstatusServicio() {
 
        $sql = "SELECT * FROM `tipo_estatus` WHERE `tipo` = 12 Order by id ";
  
      
         
         
         try {
             $stmt = self::$connection->prepare ($sql );
             $stmt->execute (array());
             return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
         } catch ( PDOException $e ) {
             self::$logger->error ("File: reportes_db.php;	Method Name: getEstatusEvento();	Functionality: Search Products;	Log:". $sql . $e->getMessage () );
         }
  }
    
}
//
include 'DBConnection.php';

$Reportes = new Reportes ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'reporte_vo') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eventosVO.csv"');
    
    $rows = $Reportes->getVo($params);
    echo 'CveBancaria,Servicio,Ticket,Folio,cliente,direccion,colonia,Estado,municipio,telefono,odt,descripcion,estatus'. PHP_EOL;

    foreach ($rows as $row ) {
     echo $row['CveBancaria'] . "," . $row['servicio'] . "," .$row['ticket'] . "," . $row['Folio'] . "," . $row['cliente']  . "," . $row['direccion'] . "," . $row['colonia'] . "," . $row['Estado'] . "," . $row['municipio']. "," . $row['telefono']. "," . $row['odt']. "," . $row['descripcion']. "," . $row['Estatus']. PHP_EOL;
    }


   
}

if($module == 'reporte_eventos') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eventos.csv"');
    
    $rows = $Reportes->getEventos($params);
    echo 'CveBancaria,Servicio,ODT,Folio,cliente,direccion,colonia,Estado,municipio,telefono,ticket,descripcion,estatus'. PHP_EOL;

    foreach ($rows as $row ) {
     echo $row['CveBancaria'] . ",". $row['servicio'] . "," .$row['odt'] . "," . $row['Folio'] . "," . $row['cliente']  . "," . $row['direccion'] . "," . $row['colonia'] . "," . $row['Estado'] . "," . $row['municipio']. "," . $row['telefono']. "," . $row['ticket']. "," . $row['descripcion']. "," . $row['Estatus']. PHP_EOL;
    }
   
}

if($module == 'reporte_inventarioCampo') {


    $rows = $Reportes->getInventarioCampo($params);
    $headers = array('ODT','Afiliacion','Nombre','Fecha Alta','Fecha Atencion','Fecha Evidencias','TVP_Retirado','TVP_Instalado','SIM_Retirado','SIM_Instalado','Estatus','Servicio','SubServicio','Cant Imagenes');

        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Sistema SAE")
            ->setLastModifiedBy('SAE')
            ->setTitle('Archivo exportado desde MySQL')
            ->setDescription('Un archivo de Excel exportado desde MySQL por SAE');

        # Como ya hay una hoja por defecto, la obtenemos, no la creamos
        $hojaDeProductos = $documento->getActiveSheet();
        //$hojaDeProductos->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        $hojaDeProductos->setTitle('InventarioCampo');

        $hojaDeProductos->fromArray($headers, null, 'A1');
        $numeroDeFila = 2;

        foreach($rows as $fields) {
            
            $totalCol = sizeof($fields);
            $counter = 1;
            foreach($fields as $index => $value) {
                $hojaDeProductos->setCellValueByColumnAndRow($counter, $numeroDeFila, $value);
                $counter++;
            }
            $numeroDeFila++;
        }

        // Get sheet dimension
        $sheet_dimension = $hojaDeProductos->calculateWorksheetDimension();

        // Apply text format to numbers
        $hojaDeProductos->getStyle($sheet_dimension)->getNumberFormat()->setFormatCode('#');
                
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documento, 'Csv');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="InventarioCampo_'. date('YmdHms').'.csv"');
        $writer->save('php://output');
        exit;
   
}


if($module == 'reporte_imagenestecnico') {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="imagenestecnico.csv"');
    
    $rows = $Reportes->getImagenesTecnico($params);
    echo 'FechaAtencion,FechImagen,ODT,Tecnico,Imagen,TipoEvidencia'. PHP_EOL;

    foreach ($rows as $row ) {
    echo $row['fecha_atencion'] . ",".$row['fechaImagen'] . ",'". $row['odt'] . "," .$row['nombre'] . "," . $row['dir_img'] . "," . $row['tipoevidencia'] . PHP_EOL;
    } 
 

   
}

if($module == 'getubi') {
    $val = '';
    $rows = $Reportes->getubi();
	$almacen = $_SESSION['almacen'];
	$isAdmin= 0;
		
	if($_SESSION['tipo_user'] == 'admin' ||  $_SESSION['tipo_user'] == 'CA' || $_SESSION['tipo_user'] == 'AN') { 
		$isAdmin = 1;
	}
    foreach ( $rows as $row ) {
		if($isAdmin == 1 ) {
			$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
		} else {
			if($row ['almacen'] == '1') {
				if($row['id'] == $almacen ) {
				$val .=  '<option value="' . $row ['id'] . '" selected>' . $row ['nombre'] . '</option>';
				}
			}  
		
		}
	}
	echo $val;

}

if($module == 'getEstatus') {
    $val = '';
    $rows = $Reportes->getEstatus();
    foreach ( $rows as $row ) {
         
		$val .=  '<option value="' . $row ['id'] . '"  >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getubicacion') {
    $val = '';
    $rows = $Reportes->getubicacion();
	$almacen = $_SESSION['almacen'];
	$isAdmin= 0;
		
    if($_SESSION['tipo_user'] == 'admin' ||  $_SESSION['tipo_user'] == 'CA' || $_SESSION['tipo_user'] == 'AN') 
    { 
		$isAdmin = 1;
	}
    foreach ( $rows as $row ) {
        if($isAdmin == 1 ) 
        {
			$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
		} else {
			if($row ['almacen'] == '1') {
				if($row['id'] == $almacen ) {
				$val .=  '<option value="' . $row ['id'] . '" selected>' . $row ['nombre'] . '</option>';
				}
			}  
		
		}
	}
    echo $val;
    
    

}

if($module == 'getEstatusServicio') {
	$rows = $Reportes->getEstatusServicio();
	  $val = '';
	  foreach ( $rows as $row ) {
		  $val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	  }
	  echo $val;
  
}

/* if($module == 'getAlmaceninventario') 
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Reporte_Almacen.csv"');
    $rows = $Reportes->getAlmaceninventario($params);
    echo 'TipoNombre,No_Serie,Modelo,Estatus,Estatus_Inventario,Ubicacion,Fecha_Edicion,Cantidad,Id'.PHP_EOL;
    foreach ($rows as $row)
    {
        echo $row['tipoNombre'] . "," . $row['no_serie'] . "," . $row['modelo'] . "," . $row['estatus'] . "," . $row['estatus_inventario'] . "," . $row['ubicacion'] . "," . $row['fecha_edicion'] . "," . $row['cantidad'] . "," . $row['id'] . PHP_EOL;
    }
    /*$rowsTotal = $Reportes->getAlmaceninventario($params,false);*/
    /*$data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );
	//echo json_encode($data); //$val;
} */


if($module == 'reporte_almaceninv') {


    $rows = $Reportes->getAlmaceninventario($params, true);
    //$headers = array('TipoNombre','No_Serie','Modelo','Estatus','Estatus_Inventario','Ubicacion','Fecha_Edicion','Cantidad','Id');
    $headers = array('TipoNombre','No_Serie','Modelo','Estatus','Estatus_Inventario','Ubicacion','Fecha_Actualización','Cantidad');

        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Sistema SAE")
            ->setLastModifiedBy('SAE')
            ->setTitle('Archivo exportado desde MySQL')
            ->setDescription('Un archivo de Excel exportado desde MySQL por SAE');

        # Como ya hay una hoja por defecto, la obtenemos, no la creamos
        $hojaDeProductos = $documento->getActiveSheet();
        //$hojaDeProductos->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        $hojaDeProductos->setTitle('InventarioAlmacen');
		
		// Get sheet dimension
        $sheet_dimension = $hojaDeProductos->calculateWorksheetDimension();

        // Apply text format to numbers 
        $hojaDeProductos->getStyle('A1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		
        $hojaDeProductos->fromArray($headers, null, 'A1');
        $numeroDeFila = 2;

        foreach($rows as $fields) {
            
            $totalCol = sizeof($fields);
            $counter = 1;
            foreach($fields as $index => $value) {
				 
				$value = $counter == 2 ? "'$value" : $value;
                $hojaDeProductos->setCellValueByColumnAndRow($counter, $numeroDeFila, $value);
				 
                $counter++;
            }
            $numeroDeFila++;
        }

        
                
        //$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documento, 'Csv');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($documento);
        //header('Content-Type: text/csv');
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="InventarioAlmacen_'. date('YmdHms').'.xls"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Cache-Control: private",false);
        $writer->save('php://output');
        exit;
   
}


if ( $module == 'reporte_detevento' ) {

    $rows = $Reportes->getDetEvento($params, true);



    $headers = array ('ODT', 'AFILIACION', 'SERVICIO', 'SUBSERVICIO', 'FECHA ALTA', 'FECHA VENCMIENTO', 'FECHA CIERRE', 'COMERCIO', 'COLONIA', 'CIUDAD', 'ESTADO', 'DIRECCION', 'TELEFONO','HORA ATENCION','HORA COMIDA','FECHA ASIGNACION','QUIEN ATENDIO','FECHA ATENCION','HORA LLEGADA','HORA SALIDA', 'DESCRIPCION','SERVICIO SOLICITADO', 'TECNICO', 'ESTATUS','ID CAJA','AFILIACION AMEX','AMEX','VERSION','APLICATIVO','PRODUCTO','ROLLOS A INSTALAR','ROLLOS ENTREGADOS', 'TPV INSTALADA', 'TPV RETIRADA','SIM INSTALADO','SIM RETIRADO', 'COMENTARIOS TECNICO','COMENTARIOS CIERRE','COMENTARIOS VALIDACION','FOLIO TELECARGA','FALTA SERIE','FALTA EVIDENCIA','FALTA INFORMACION','FALTA UBICACION', 'CAMBIO DE ESTATUS POR');

        $documento = new Spreadsheet();
        $documento 
            ->getProperties()
            ->setCreator("Sistema SAE")
            ->setLastModifiedBy('SEA')
            ->setTitle('Archivo explorado desde MySQL') 
            ->setDescription('Un archivo de Excel exportado desde MySQL por SAE');   

        # Como ya hay una hoja por defecto, la obtenemos, no la creamos
    
        $hojaDeProductos = $documento->getActiveSheet();

        $hojaDeProductos->setTitle('DetalleEventos');

        $sheet_dimension = $hojaDeProductos->calculateWorksheetDimension();

        $hojaDeProductos->getStyle('Al')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $hojaDeProductos->fromArray($headers, null, 'A1');
        $numeroDeFila = 2;

        foreach ($rows as $fields) 
        {
            $counter = 1;
            foreach ($fields as $index => $value) {
                $value = $counter == 2 ? "'$value" : $value;
                $hojaDeProductos->setCellValueByColumnAndRow($counter, $numeroDeFila, $value);
                $counter++;
            }
            $numeroDeFila++;
        }

        //$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documento, 'Excel5');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($documento);
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="DetalleEventos_'.date('YmdHms').'.xls"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Cache-Control: private",false);
        $writer->save('php://output');
        exit;

}


?>