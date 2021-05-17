<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
include("api.php");
include('../modelos/procesos_db.php');

$token = $api->getToken();
//echo $token->token;

$params = [ 'StartDate'=>'01/03/2021','EndDate'=>'15/03/2021','IdStatusOdt'=> 3];
$odt = $api->get('provider/api/odts/GetServicesProvider',$token->token,$params);

$json =  json_encode($odt);
//echo $json;
$format = "Y-m-d\TH:i:s";
$fecha = date('Y-m-d H:i:s');

foreach ($odt->result->data as $object) {
   // echo $object->ID_AR;
    $user = 1;
    $ODT = $object->ODT;
    $Afiliacion = $object->AFILIACION;
    $Comercio = $object->COMERCIO;
    $Direccion = $object->DIRECCION;
    $Colonia = $object->COLONIA;
    $Ciudad = $object->POBLACION;
    $Estado = $object->ESTADO;

    $date = DateTime::createFromFormat($format, $object->FECHA_ALTA);
    $FechaAlta = $date->format("Y-m-d H:i:s");
    
    $date = DateTime::createFromFormat($format, $object->FECHA_VENCIMIENTO );
    $FechaVencimiento = $date->format("Y-m-d H:i:s"); 
    

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
    $TipoComercio = $object->TIPO_COMERCIO_2;
    $AfiliacionAmex = $object->AFILIACION_AMEX; 
    $IdAmex = $object->IDAMEX; 
    $Producto = $object->PRODUCTO;
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
    $RollosEntregados = $object->ROLLOS_ENTREGADOS; 
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
    $TipoCarga = $object->TIPO_CARGO;
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
      $datafieldsCustomers = array('comercio','propietario','estado','responsable','tipo_comercio','ciudad','colonia',
      'afiliacion','telefono','direccion','rfc','email','email_ejecutivo','territorial_banco',
      'razon_social','cve_banco','cp','estatus','activo','fecha_alta');

      $question_marks = implode(', ', array_fill(0, sizeof($datafieldsCustomers), '?'));

      $sql = "INSERT INTO comercios (" . implode(",", $datafieldsCustomers ) . ") VALUES (".$question_marks.")"; 

      $arrayString = array (
          $Comercio,
          $Propietario,
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
      

      

      //$newId = $Procesos->insert($sql,$arrayString);

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
     // array_push($datosCargar,$arrayStringEvento);
      
      $newId = $Procesos->insert($sqlEvento,$arrayStringEvento);
      
      if($newId) {
            //GRABAR HISTORIA EVENTOS 
            
            $datafieldsHistoria = array('evento_id','fecha_movimiento','estatus_id','odt', 'modified_by');
            
            $question_marksHistoria = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
            
            $sqlHistoria = "INSERT INTO historial_eventos(" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marksHistoria.")";
            
            $arrayStringHistoria = array ($newId, $fecha, 16, $ODT, $user );
            
            $Procesos->insert($sqlHistoria, $arrayStringHistoria);
            //END GRABAR HISTORIA EVENTOS

            /* $sqlEvento = "UPDATE carga_archivos SET registros_procesados=? WHERE id = ?";

            $arrayStringEvento = array (
                $counter,
                $proceso['id']
            );

            $Procesos->insert($sqlEvento,$arrayStringEvento); */
    }
      
      
  } else {
      $nocounter++;


      array_push($odtYaCargadas,["ODT" => $ODT ]);

      /* if($existeEvento[0]['estatus_servicio'] == '16' && $existeEvento[0]['estatus'] == '1' ) {
          $sqlEvento = "UPDATE eventos SET  fecha_alta= ?,fecha_vencimiento= ? WHERE id = ?";

          $arrayStringEvento = array (
              $FechaAlta,
              $FechaVencimiento,
              $existeEvento[0]['id']

          );
      
         // $newId = $Procesos->insert($sqlEvento,$arrayStringEvento);
      } */
  }  

}


?>