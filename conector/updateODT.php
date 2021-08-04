<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/api.php';
require __DIR__ . '/../modelos/procesos_db.php';

$token = $api->getToken();
//echo $token->token;
 
$fechaObtener = date('Y-m-d');
$fechaFrom = '19/07/2021'; //date('d/m/Y', strtotime($fechaObtener. ' - 2 days'));
$fechaTo = '27/07/2021'; //date('d/m/Y', strtotime($fechaObtener. ' + 1 days'));
echo $fechaFrom." ".$fechaTo." \n "; 
$params = [ 'StartDate'=>$fechaFrom,'EndDate'=>$fechaTo,'IdStatusOdt'=> '1,3,13,31' ];
$odt = $api->get('gntps/api/odts/GetServicesProvider',$token->token,$params);

$json =  json_encode($odt);
//echo $json;
$format = "Y-m-d\TH:i:s";
$fecha = date('Y-m-d H:i:s');
//echo count($odt->result->data);
echo json_encode($odt->result->meta)." \n ";

$totalcount = $odt->result->meta->totalCount;
$pagesize = $odt->result->meta->pageSize;
$currentpage = $odt->result->meta->currentPage;
$totalpages = $odt->result->meta->totalPages;
$hasNextPage = $odt->result->meta->hasNextPage;
$hasPreviousPage = $odt->result->meta->hasPreviousPage;


$params = [ 'StartDate'=>$fechaFrom,'EndDate'=>$fechaTo,'IdStatusOdt'=> '1,3,13,31','PageSize'=> $totalcount ];
$odt = $api->get('gntps/api/odts/GetServicesProvider',$token->token,$params);
echo "TOTAL a BAJAR ".count($odt->result->data)." \n ";
echo $fecha."---- INICIO DESCARGA ODT  en Total son $totalcount  \n ";
foreach ($odt->result->data as $object) {
  // echo $object->TIPO_COMERCIO_2." \n ";
    //echo json_encode($object);
  
    $user = 1;
    $ODT = $object->ODT;
    $Afiliacion = $object->AFILIACION;
    $Comercio = $object->COMERCIO;
    $Direccion = $object->DIRECCION;
    $Colonia = $object->COLONIA;
    $Ciudad = $object->POBLACION;
    $Estado = $object->ESTADO;
	$Id_ar = $object->ID_AR;

    $date = DateTime::createFromFormat($format, $object->FECHA_ALTA);
    $FechaAlta = $date->format("Y-m-d H:i:s");
    
    $date = DateTime::createFromFormat($format, $object->FECHA_VENCIMIENTO );
    $FechaVencimiento = $date->format("Y-m-d H:i:s"); 
	$FechaCierreSistema = NULL;					   
    

    $Descripcion = $object->DESCRIPCION;  
    $Observaciones = $object->OBSERVACIONES; 
    $Telefono = $object->TELEFONO; 
    $Canal = $object->CANAL;
    $Nivel = $object->NIVEL;
    $CodigoAfiliacion = $object->CODIGO_AFILIACION;
    $TipoServicio = $Procesos->getServicioxNombre( $object->TIPO_SERVICIO );
    $SubServicio = $object->SUB_TIPO_SERVICIO = '' ? 0 : $Procesos->getSubServicioxNombre( $object->SUB_TIPO_SERVICIO ); ;
    $CriterioCambio = $object->CRITERIO_CAMBIO;   
    $IdTecnico = $object->ID_TECNICO;
    $Proveedor = $object->PROVEEDOR;
    $EstatusServicio =  $object->ESTATUS_SERVICIO; 
   
    if($object->FECHA_ATENCION_PROVEEDOR == "" ) {
        $FechaAtencionProveedor = NULL;
    } else {
        
        $date = DateTime::createFromFormat($format, $object->FECHA_ATENCION_PROVEEDOR);
        $FechaAtencionProveedor = $date->format("Y-m-d H:i:s");
        
    }

   
    if( $object->FECHA_CIERRE_SISTEMA != "" || $object->FECHA_CIERRE_SISTEMA == null ) {
        $FechaCierreSistema == NULL;
    } else {
        $FechaCierreSistema = date('Y-m-d H:i:s', strtotime($object->FECHA_CIERRE_SISTEMA));
        
    }
     
    if($object->FECHA_ALTA_SISTEMA == "") {
        $FechaAltaSistema = NULL;
    } else {
        $FechaAltaSistema = date('Y-m-d H:i:s', strtotime($object->FECHA_ALTA_SISTEMA));
    
    }
    $CodigoPostal = $object->CODIGO_POSTAL; 
    $Conclusiones = $object->CONCLUSIONES; 
    $Conectividad = $object->CONECTIVIDAD; 
    $Modelo = $object->MODELO; 
    $IdEquipo = $object->EQUIPO;
    $IdCaja = $object->CAJA; 
    $RFC = $object->RFC;  //NO
    $RazonSocial = $object->RAZON_SOCIAL;//NO
    $HorasVencidas = $object->HORAS_VENCIDAS; //NO
    $GetNet = $object->VESTIDURAS_GETNET; //NO
    $SLASistema = $object->SLA_FIJO;  
    $Nivel2 = $object->NIVEL_SLA; //NO 
    $TelefonosenCampo = $object->TELEFONOS_EN_CAMPO;  
    $TipoComercio = $object->TIPO_COMERCIO_2 == 'NORMAL' ? 1 : 0;
    $AfiliacionAmex = $object->AFILIACION_AMEX; 
    $IdAmex = $object->IDAMEX; 
    $Producto = $Procesos->getProductoxNombre( $object->PRODUCTO );
    $MotivoCancelacion = $object->MOTIVO_CANCELACION;  //NO
    $MotivoRechazo = $object->MOTIVO_CANCELACION;//NO
    $Email = $object->EMAIL;//NO 
    $Rollosainstalar = is_null($object->ROLLOS_A_INSTALAR) ? 0 : $object->ROLLOS_A_INSTALAR;
    $NumSerieTerminalEntra = $object->NUM_SERIE_TERMINAL_ENTRA;
    $NumSerieTerminalSale = $object->NUM_SERIE_TERMINAL_SALE; 
    $NumSerieTerminalmto = $object->NUM_SERIE_TERMINAL_MTO;
    $NumSerieSimSale = $object->NUM_SERIE_SIM_SALE;
    $NumSerieSimEntra = $object->NUM_SERIE_SIM_ENTRA; 
    $Divisa = $object->DIVISA;
    $Cargador = $object->CARGADOR;
    $Base = $object->BASE;
    $RollosEntregados = 0; //$object->ROLLOS_ENTREGADOS; 
    $Cablecorriente = $object->CABLE_CORRIENTE; 
    $Zona = $object->ZONA;
    $MarcaTerminalSale = $object->MODELO_INSTALADO; //NO
    $ModeloTerminalSale = $object->MODELO_TERMINAL_SALE; //NO
    $CorreoEjecutivo = $object->CORREO_EJECUTIVO; //NO
    $Rechazo = $object->RECHAZO; //NO
    $Contacto1 = $object->CONTACTO1; //NO
    $Atiendeencomercio = $object->ATIENDE_EN_COMERCIO;//NO
    $TidAmexCierre = $object->TID_AMEX_CIERRE;
    $AfiliacionAmexCierre = $object->AFILIACION_AMEX_CIERRE;
    $Codigo = $object->CODIGO; //NO
    $TieneAmex = $object->TIENE_AMEX; 
    $ActReferencias = $object->ACT_REFERENCIAS; //NO
    $Tipo_A_b = $object->TIPO_A_B; //NO
    $DomicilioAlterno = $object->DIRECCION_ALTERNA_COMERCIO;
    $CantidadArchivos = $object->CANTIDAD_ARCHIVOS;
    $AreaCarga = $object->AREA_CARGA;
    $AltaPor = $object->ALTA_POR;
    $TipoCarga = $object->TIPO_CARGA;
    $CerradoPor = $object->CERRADO_POR;
    $VoltajeNeutro = $object->VOLTAJE_NEUTRO;
    $FechaInicioSlaInv = $object->FECHA_INICIO_SLA_INV;
		$FechaMovInventario = $object->FECHA_MOV_INVENTARIO;
		$NivelSlaInventario = $object->NIVEL_SLA_INVENTARIO;
		$DiaSlaAdmin= $object->DIAS_SLA_ADMIN;
		$DiasSlaGlobal = $object->DIAS_SLA_GLOBAL;
		$Comentarios = $object->COMENTARIOS;
		$AreaCierre = $object->AREA_CIERRA;

    $clienteExiste = $Procesos->getClientesByAfiliacion($Afiliacion);
    
   
    if( sizeof($clienteExiste) == 0 ) {
                    
      //$estado = $Procesos->getEstadoxNombre($Estado);
      //$ciudad = $Procesos->getCiudadxNombre($Ciudad,$estado);
      $datafieldsCustomers = array('comercio','estado','responsable','tipo_comercio','ciudad','colonia',
      'afiliacion','telefono','direccion','rfc','email','email_ejecutivo','territorial_banco',
      'razon_social','cve_banco','cp','estatus','activo','fecha_alta');

      $question_marks = implode(', ', array_fill(0, sizeof($datafieldsCustomers), '?'));

      $sql = "INSERT INTO comercios (" . implode(",", $datafieldsCustomers ) . ") VALUES (".$question_marks.")"; 

      $arrayString = array (
          $Comercio,
          $Estado, 
          $Atiendeencomercio,
          $TipoComercio,
          $Ciudad,
          $Colonia,
          $Afiliacion,
          $Telefono,
          $Direccion,
          $RFC,
          $Email,
          $CorreoEjecutivo,
          $Zona,
          $RazonSocial,
          '037',
          $CodigoPostal,
          1,
          1,
          $fecha 
      );
  
     $newCustomerId = $Procesos->insert($sql,$arrayString);
      

    }  else {
        $newCustomerId = $clienteExiste[0]['id'];

        $sqlEvento = "UPDATE comercios SET comercio=?,direccion=?,colonia=?,cp=?  WHERE id = ?";

        $arrayString = array (
            $Comercio,
            $Direccion,
            $Colonia, 
            $CodigoPostal,
            $newCustomerId
        );
    
        $Procesos->insert($sqlEvento,$arrayString);

    }
    
    if($TipoServicio == 0) {
        $datafieldsTipoServicio = array('nombre','tipo','status');

        $question_marks = implode(', ', array_fill(0, sizeof($datafieldsTipoServicio), '?'));

        $sql = "INSERT INTO tipo_servicio (" . implode(",", $datafieldsTipoServicio ) . ") VALUES (".$question_marks.")"; 

        $arrayString = array (
            $servicio,
            'rep',
            1
        );
    
        $newTipoServicioId = $Procesos->insert($sql,$arrayString);
    } else {
        $newTipoServicioId = $TipoServicio;
    }
	
    $existeEvento = $Procesos->existeEvento($ODT);
	echo $Id_ar."".$ODT." ".$object->TIPO_SERVICIO." ".$FechaAlta." ".sizeof($existeEvento)." \n";
	
	
    if(sizeof($existeEvento) == '0') {
      $fecha = date ( 'Y-m-d H:m:s' );

      $datafields = array('odt','afiliacion','comercio','direccion','colonia','municipio','estado','consecutivo',
      'fecha_alta','fecha_vencimiento','descripcion','comentarios','telefono','nivel','tipo_servicio','servicio',
      'estatus_servicio','comentarios_cierre','amex','email',
      'rollos_instalar','tpv_instalado','tpv_retirado','sim_retirado','sim_instalado','cargador','base',
      'cable','cve_banco','estatus','afiliacionamex','tieneamex','clave_autorizacion',
      'actreferencias','domicilioalterno','id_caja','tipocarga','slafijo','telfonoscampo','producto','modificado_por'); 

      $question_marksEvento = implode(', ', array_fill(0, sizeof($datafields), '?'));

      $sqlEvento = "INSERT INTO eventos (" . implode(",", $datafields ) . ") VALUES (".$question_marksEvento.")";

      $arrayStringEvento = array (
          $ODT ,
          $Afiliacion ,
          $newCustomerId,
          $Direccion ,
          $Colonia,
          $Ciudad,
          $Estado,
          0,
          $FechaAlta,
          $FechaVencimiento,
          $Descripcion,
          $Observaciones,
          $Telefono,
          $Nivel,
          $newTipoServicioId ,
          $SubServicio,
          16, 
          $Conclusiones ,
          $IdAmex,
          $Email ,
          $Rollosainstalar,
          NULL,
          NULL,
          NULL,
          NULL,
          $Cargador,
          $Base ,
          $Cablecorriente ,
          '037',
          1,
          $AfiliacionAmex,
          $TieneAmex,
          $Codigo,
          $ActReferencias,
          $DomicilioAlterno,
          $IdCaja,
          $TipoCarga,
          $SLASistema,
          $TelefonosenCampo ,
          $Producto,
          $user

      );
 
      
       $newId = $Procesos->insert($sqlEvento,$arrayStringEvento);
      
      if($newId) {
            echo $ODT." ".$object->TIPO_SERVICIO." ".$FechaAlta." \n ";
            //GRABAR HISTORIA EVENTOS 
            
            $datafieldsHistoria = array('evento_id','fecha_movimiento','estatus_id','odt', 'modified_by');
            
            $question_marksHistoria = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
            
            $sqlHistoria = "INSERT INTO historial_eventos(" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marksHistoria.")";
            
            $arrayStringHistoria = array ($newId, $fecha, 16, $ODT, $user );
            
            $Procesos->insert($sqlHistoria, $arrayStringHistoria);
          
    }  
      
      
  } else {
	  
	  if($ODT == 'ROLLOSJUL211037421') { 
	  echo "FECHA ALTA SISTEMA: ".$FechaAltaSistema." \n ";
	  echo "FECHAS Alta SGS: ".$existeEvento[0]['fecha_alta']." Fecha Alta SAES: ".$FechaAlta." \n ";
	  echo "FECHAS Vencimiento SGS: ".$existeEvento[0]['fecha_vencimiento']." Fecha Vencimiento SAES: ".$FechaVencimiento." \n ";
	  }
	  
  }

}

echo $fecha."---- FIN DESCARGA ODT  ";

?>