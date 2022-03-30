<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

date_default_timezone_set('America/Monterrey');

require __DIR__.'/../modelos/procesos_db.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


$processActive = $Procesos->getCargasEnProceso("E");
$fechaProceso = date ( 'Y-m-d H:i:s' );
echo "############## $fechaProceso ###########";
if($processActive) {
    echo "$fechaProceso $processActive Hay un proceso de Eventos Ejecutandose \n ";
} else {
    $proceso = $Procesos->getOlderCargas('E');

    if($proceso) {
        echo "$fechaProceso Buscar Proceso de Eventos mas Viejo E ".$proceso['fecha_creacion']." \n ";
        $fecha = date ( 'Y-m-d H:i:s' );
        
    
        

        //$eventoMasivo = new CargasMasivas();
        $archivo =  '/var/www/dev.sinttecom.net/cron/files/'.$proceso['archivo'];
        #ARCHIVOS LOCAL
        //$archivo = '/home/webdeveloper/sitios/sinttecom/cron/files/'.$proceso['archivo'];
        $spreadsheet = IOFactory::load($archivo);
        $hojaDeProductos= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        
        $user = $proceso['creado_por'];
        $consecutivo = 1;
        $counter = 0;
        $nocounter = 0;
        $insert_values = array();
        $fecha = date ( 'Y-m-d H:i:s' );
        $odtYaCargadas = array();
        $cveBanco = $proceso['cve_banco'];
  
        $datosCargar = array();
        $format = "d/m/Y H:i";
        $numeroMayorDeFila = count($hojaDeProductos); 
        //Updatw PRoceso en ejecucion
        $sqlEvento = "UPDATE carga_archivos SET  procesar= ?,fecha_modificacion= ?,registros_total=? WHERE id = ?";

        $arrayStringEvento = array (
            1,
            $fecha,
            $numeroMayorDeFila,
            $proceso['id']
        );
        
        $Procesos->insert($sqlEvento,$arrayStringEvento);

        for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
            
            # Las columnas están en este orden:
            # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
            
            $ODT = $hojaDeProductos[$indiceFila]['A'];
            if(!is_null($ODT)  ) {
                $counter++;
                if ( $cveBanco == '037') {

                    $Ticket = $hojaDeProductos[$indiceFila]['B'];
                    $Afiliacion = $hojaDeProductos[$indiceFila]['C'];
                    $Comercio = $hojaDeProductos[$indiceFila]['D'];
                    $Direccion = $hojaDeProductos[$indiceFila]['E'];
                    $Colonia = $hojaDeProductos[$indiceFila]['F'];
                    $Ciudad = $hojaDeProductos[$indiceFila]['G'];
                    $Estado = $hojaDeProductos[$indiceFila]['H'];
                    $FechaAlta = $hojaDeProductos[$indiceFila]['I'] ;
                    $FechaVencimiento = $hojaDeProductos[$indiceFila]['J'] ; 
                    
                    $date = DateTime::createFromFormat($format, $FechaAlta);
                    echo $FechaAlta;
                    $FechaAlta = $date->format("Y-m-d H:i:s");
                    
                    $date = DateTime::createFromFormat($format, $FechaVencimiento);
                    $FechaVencimiento = $date->format("Y-m-d H:i:s"); 
                    
        
                    $Descripcion = $hojaDeProductos[$indiceFila]['K'];  
                    $Observaciones = $hojaDeProductos[$indiceFila]['L']; 
                    $Telefono = str_replace(' ', '', $hojaDeProductos[$indiceFila]['M']); 
                    $TipoComercio = $hojaDeProductos[$indiceFila]['N']; 
                    $Nivel = $hojaDeProductos[$indiceFila]['O']; 
                    $servicio = $hojaDeProductos[$indiceFila]['P'];
                    $TipoServicio = $Procesos->getServicioxNombre($servicio);
                    $SubServicio = $hojaDeProductos[$indiceFila]['Q'];
                    $SubtipoServicio = $SubServicio = '' ? 0 : $Procesos->getSubServicioxNombre( $SubServicio );
                    $Propietario = $hojaDeProductos[$indiceFila]['R'];
                    $Tecnico = $hojaDeProductos[$indiceFila]['S'];
                    $Proveedor = $hojaDeProductos[$indiceFila]['T'];  
                    $EstatusServicio =  $hojaDeProductos[$indiceFila]['U']; 
                    $EstatusServicio = $EstatusServicio = '' ? 0 : $Procesos->getEstatusServicioxNombre($EstatusServicio);
                    
                    $FechaAtencionProveedor = $hojaDeProductos[$indiceFila]['V']; 
                    if($FechaAtencionProveedor == "" ) {
                        $FechaAtencionProveedor = NULL;
                    } else {
                        
                        $date = DateTime::createFromFormat($format, $FechaAtencionProveedor);
                        $FechaAtencionProveedor = $date->format("Y-m-d H:i:s");
                        
                    }
                    $FechaCierreSistema = $hojaDeProductos[$indiceFila]['W']; 
                    if($FechaCierreSistema != "" || $FechaCierreSistema == null ) {
                        $FechaCierreSistema == NULL;
                    } else {
                        $FechaCierreSistema = date('Y-m-d H:i:s', strtotime($FechaCierreSistema));
                        
                    }
                    $FechaAltaSistema = $hojaDeProductos[$indiceFila]['X'];  
                    if($FechaAltaSistema == "") {
                        $FechaAltaSistema = NULL;
                    } else {
                        $FechaAltaSistema = date('Y-m-d H:i:s', strtotime($FechaAltaSistema));
                    
                    }
                    $CodigoPostal = $hojaDeProductos[$indiceFila]['Y']; 
                    $Conclusiones = $hojaDeProductos[$indiceFila]['Z']; 
                    $Conectividad = $hojaDeProductos[$indiceFila]['AA']; 
                    $Conectividad = $Conectividad = '' ? 0 : $Procesos->getConectividadxNombre($Conectividad);
                    $Modelo = $hojaDeProductos[$indiceFila]['AB']; 
                    $IdEquipo = $hojaDeProductos[$indiceFila]['AC'];
                    $IdCaja = $hojaDeProductos[$indiceFila]['AD']; 
                    $RFC = $hojaDeProductos[$indiceFila]['AE'];  //NO
                    $RazonSocial = $hojaDeProductos[$indiceFila]['AF'];//NO
                    $DiasAtencion = $hojaDeProductos[$indiceFila]['AG'];  //NO
                    $GetNet = $hojaDeProductos[$indiceFila]['AH'];   //NO
                    $SLASistema = $hojaDeProductos[$indiceFila]['AI'];  
                    $Nivel2 = $hojaDeProductos[$indiceFila]['AJ']; 
                    $TelefonosenCampo = $hojaDeProductos[$indiceFila]['AK'];  
                    $Canal = $hojaDeProductos[$indiceFila]['AL'];
                    $AfiliacionAmex = $hojaDeProductos[$indiceFila]['AM']; 
                    $IdAmex = $hojaDeProductos[$indiceFila]['AN']; 
                    $Producto = $hojaDeProductos[$indiceFila]['AO'];
                    $MotivoCancelacion = $hojaDeProductos[$indiceFila]['AP'];  //NO
                    $MotivoRechazo = $hojaDeProductos[$indiceFila]['AQ'];//NO
                    $Email = $hojaDeProductos[$indiceFila]['AR'];//NO
                    $Rollosainstalar = $hojaDeProductos[$indiceFila]['AS'];
                    $Rollosainstalar = is_null($Rollosainstalar) ? 0 : $Rollosainstalar;
                    $NumSerieTerminalEntra = $hojaDeProductos[$indiceFila]['AT'];
                    $NumSerieTerminalSale = $hojaDeProductos[$indiceFila]['AU']; 
                    $NumSerieTerminalmto = $hojaDeProductos[$indiceFila]['AV'];
                    $NumSerieSimSale = $hojaDeProductos[$indiceFila]['AW'];
                    $NumSerieSimEntra = $hojaDeProductos[$indiceFila]['AX']; 
                    $VersionSW = $hojaDeProductos[$indiceFila]['AY'];
                    $Cargador = $hojaDeProductos[$indiceFila]['AZ'];
                    $Base = $hojaDeProductos[$indiceFila]['BA'];
                    $RollosEntregados = $hojaDeProductos[$indiceFila]['BB']; 
    
                    $Cablecorriente = $hojaDeProductos[$indiceFila]['BC']; 
                    $Zona = $hojaDeProductos[$indiceFila]['BD'];
                    $MarcaTerminalSale = $hojaDeProductos[$indiceFila]['BE']; //NO
                    $ModeloTerminalSale = $hojaDeProductos[$indiceFila]['BF']; //NO
                    $CorreoEjecutivo = $hojaDeProductos[$indiceFila]['BG']; //NO
                    $Rechazo = $hojaDeProductos[$indiceFila]['BH']; //NO
                    $Contacto1 = $hojaDeProductos[$indiceFila]['BI']; //NO
                    $Atiendeencomercio = $hojaDeProductos[$indiceFila]['BJ'];//NO
                    $TidAmexCierre = $hojaDeProductos[$indiceFila]['BK'];
                    $AfiliacionAmexCierre = $hojaDeProductos[$indiceFila]['BL'];
                    $Codigo = $hojaDeProductos[$indiceFila]['BM']; //NO
                    $TieneAmex = $hojaDeProductos[$indiceFila]['BN']; 
                    $ActReferencias = $hojaDeProductos[$indiceFila]['BO']; //NO
                    $Tipo_A_b = $hojaDeProductos[$indiceFila]['BP']; //NO
                    $DomicilioAlterno = $hojaDeProductos[$indiceFila]['BQ'];
                    $TipoCarga = $hojaDeProductos[$indiceFila]['BR'];
                    $AreaCarga = $hojaDeProductos[$indiceFila]['BS'];
                    $AltaPor = $hojaDeProductos[$indiceFila]['BT'];
                    $tipoComercio = $TipoComercio == 'NORMAL' ? 1 : 2;
                    $clienteExiste = $Procesos->getClientesByAfiliacion($Afiliacion);
                
                } else if ( $cveBanco == '038' ) {
                    $format = "d/m/Y H:i";

                    $Ticket = $hojaDeProductos[$indiceFila]['B'];
                    $Afiliacion = $hojaDeProductos[$indiceFila]['Q'];
                    $Comercio = $hojaDeProductos[$indiceFila]['AF'];
                    $Direccion = $hojaDeProductos[$indiceFila]['AI'];
                    $Colonia = $hojaDeProductos[$indiceFila]['AJ'];
                    $Ciudad = $hojaDeProductos[$indiceFila]['AH'];
                    $Estado = $hojaDeProductos[$indiceFila]['AG'];
                    $FechaAlta = $hojaDeProductos[$indiceFila]['C'] ;
                    $FechaVencimiento = $hojaDeProductos[$indiceFila]['J'] ; 
                    
                    $date = DateTime::createFromFormat($format, $FechaAlta);
                    echo $FechaAlta;
                    $FechaAlta = $date->format("Y-m-d H:i:s");
                    
                    $date = DateTime::createFromFormat($format, $FechaVencimiento);
                    $FechaVencimiento = $date->format("Y-m-d H:i:s"); 
                    
        
                    $Descripcion = $hojaDeProductos[$indiceFila]['AT'];  
                    $Observaciones = $hojaDeProductos[$indiceFila]['AY']; 
                    $Telefono = str_replace(' ', '', $hojaDeProductos[$indiceFila]['AL']); 
                    $TipoComercio = 'NORMAL'; //$hojaDeProductos[$indiceFila]['N']; 
                    $Nivel = ''; //$hojaDeProductos[$indiceFila]['O']; 
                    $SubServicio = $hojaDeProductos[$indiceFila]['F'];
					## SUBSERVICIO NOMBRE
					echo "NOMBRE: ".$SubServicio." \n ";					
                    $SubtipoServicio = $SubServicio = '' ? 0 : $Procesos->getSubServicioxNombre( $SubServicio );
					## SUBSERVICIO ID
					echo "ID: ".$SubtipoServicio." \n ";
                    $TipoServicio = $Procesos->getServiciobySubservicio($SubServicio);
                    
                    $Propietario = 0; //$hojaDeProductos[$indiceFila]['R'];
                    $Tecnico = 0; //$hojaDeProductos[$indiceFila]['S'];
                    $Proveedor = $hojaDeProductos[$indiceFila]['V'];  
                    $EstatusServicio =  $hojaDeProductos[$indiceFila]['G']; 
                    $EstatusServicio = $EstatusServicio = '' ? 0 : $Procesos->getEstatusServicioxNombre($EstatusServicio,$cveBanco);
                    $EstatusServicio = $EstatusServicio['estatus_servicio'];
                    $FechaAtencionProveedor = $hojaDeProductos[$indiceFila]['BL']; 
                    if($FechaAtencionProveedor == "" ) {
                        $FechaAtencionProveedor = NULL;
                    } else {
                        
                        $date = DateTime::createFromFormat($format, $FechaAtencionProveedor);
                        $FechaAtencionProveedor = $date->format("Y-m-d H:i:s");
                        
                    }
                    $FechaCierreSistema = $hojaDeProductos[$indiceFila]['AV']; 
                    if($FechaCierreSistema != "" || $FechaCierreSistema == null ) {
                        $FechaCierreSistema == NULL;
                    } else {
                        $FechaCierreSistema = date('Y-m-d H:i:s', strtotime($FechaCierreSistema));
                        
                    }
                    $FechaAltaSistema = $fecha; //$hojaDeProductos[$indiceFila]['X'];  
                     
                    $CodigoPostal = $hojaDeProductos[$indiceFila]['AK']; 
                    $Conclusiones = ''; //$hojaDeProductos[$indiceFila]['Z']; 
                    $Conectividad = NULL; 
                    
                    $Modelo = NULL; 
                    $IdEquipo = NULL;
                    $IdCaja = NULL; 
                    $RFC = NULL;  //NO
                    $RazonSocial = NULL;//NO
                    $DiasAtencion = NULL;  //NO
                    $GetNet = NULL;   //NO
                    $SLASistema = NULL;  
                    $Nivel2 = NULL; 
                    $TelefonosenCampo = NULL;  
                    $Canal = NULL;
                    $AfiliacionAmex = NULL; 
                    $IdAmex = ''; 
                    $Producto = NULL;
                    $MotivoCancelacion = NULL;  //NO
                    $MotivoRechazo = NULL;//NO
                    $Email = NULL;
                    $Rollosainstalar = 5;
                    $NumSerieTerminalEntra = NULL;
                    $NumSerieTerminalSale = NULL;
                    $NumSerieTerminalmto = NULL;
                    $NumSerieSimSale = NULL;
                    $NumSerieSimEntra = NULL; 
                    $VersionSW = NULL;
                    $Cargador = NULL;
                    $Base = NULL;
                    $RollosEntregados = NULL; 
                    $Atiendeencomercio = $hojaDeProductos[$indiceFila]['AE'];
                    $Cablecorriente = NULL;
                    $Zona = NULL;
                    $CorreoEjecutivo = NULL;
                    $Codigo = NULL;
                    $ActReferencias = NULL;
                     
                    $TidAmexCierre = NULL;
                    $AfiliacionAmexCierre = NULL;
                    
                    $TieneAmex = NULL;
                    
                    $DomicilioAlterno = NULL;
                    $TipoCarga = NULL;
                    $AreaCarga = NULL;
                    $AltaPor = NULL;
                    $tipoComercio = $TipoComercio == 'NORMAL' ? 1 : 2;
                    $clienteExiste = $Procesos->getClientesByAfiliacion($Afiliacion);
                }
                 
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
                        $tipoComercio,
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
                        $cveBanco,
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
                    $fecha = date ( 'Y-m-d H:i:s' );

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
                        $SubtipoServicio,
                        $EstatusServicio, 
                        $Conclusiones ,
                        $IdAmex,
                        $Email ,
                        $Rollosainstalar,
                        $NumSerieTerminalEntra ,
                        $NumSerieTerminalSale ,
                        $NumSerieSimSale ,
                        $NumSerieSimEntra,
                        $Cargador,
                        $Base ,
                        $Cablecorriente ,
                        $cveBanco,
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
                    array_push($datosCargar,$arrayStringEvento);
                    
                    $newId = $Procesos->insert($sqlEvento,$arrayStringEvento);
                    
                    //GRABAR HISTORIA EVENTOS 
                    
                    $datafieldsHistoria = array('evento_id','fecha_movimiento','estatus_id','odt', 'modified_by');
                    
                    $question_marksHistoria = implode(', ', array_fill(0, sizeof($datafieldsHistoria), '?'));
                    
                    $sqlHistoria = "INSERT INTO historial_eventos(" . implode(",", $datafieldsHistoria ) . ") VALUES (".$question_marksHistoria.")";
                    
                    $arrayStringHistoria = array ($newId, $fecha, 16, $ODT, $user );
                    
                    $Procesos->insert($sqlHistoria, $arrayStringHistoria);
                    //END GRABAR HISTORIA EVENTOS

                    $sqlEvento = "UPDATE carga_archivos SET registros_procesados=? WHERE id = ?";

                    $arrayStringEvento = array (
                        $counter,
                        $proceso['id']
                    );

                    $Procesos->insert($sqlEvento,$arrayStringEvento);
                    
                    
                } else {
                    $nocounter++;

                    $sqlEvento = "UPDATE carga_archivos SET registros_sinprocesar=? WHERE id = ?";

                    $arrayStringEvento = array (
                        $nocounter,
                        $proceso['id']
                    );
                    
                    $Procesos->insert($sqlEvento,$arrayStringEvento);

                    array_push($odtYaCargadas,["ODT" => $ODT ]);
					### Existe Evento
					echo "EXISTE EVENTO: ".$existeEvento[0]['estatus_servicio']." \n ";
                    if($existeEvento[0]['estatus_servicio'] == '13' || $existeEvento[0]['estatus_servicio'] == '14' || $existeEvento[0]['estatus_servicio'] == '15' || $existeEvento[0]['estatus_servicio'] == '16' ) {
                        $sqlEvento = "UPDATE eventos SET  'tipo_servicio'=?,'servicio'=?, fecha_alta= ?,fecha_vencimiento= ? WHERE odt = ?";

                        $arrayStringEvento = array (
                            $newTipoServicioId ,
                            $SubtipoServicio,
                            $FechaAlta,
                            $FechaVencimiento,
                            $ODT

                        );
                    
                        $newId = $Procesos->insert($sqlEvento,$arrayStringEvento);
						echo "UPDATE ".json_encode($arrayStringEvento)." \n ";
                    }
                }  
            }
        }
        
        //echo json_encode(["contador" => $counter, "datos" => $datosCargar]);
        //UPDATE PROCESO
        $fecha = date ( 'Y-m-d H:i:s' );

        $sqlEvento = "UPDATE carga_archivos SET  activo= ?,procesar= ?,fecha_modificacion= ? WHERE id = ?";

        $arrayStringEvento = array (
            0,
            0,
            $fecha,
            $proceso['id']
        );
    
        $Procesos->insert($sqlEvento,$arrayStringEvento);

        //INSERT Ya CARGADOS
        $odts = json_encode($odtYaCargadas);
        $sqlNoCarga = "INSERT INTO nocarga_archivos (archivo_id,odt) VALUES (?,?)";
                    
        $arrayString = array ( $proceso['id'], $odts );
        
        $Procesos->insert($sqlNoCarga, $arrayString);

    } else {
        echo "$fechaProceso Sin procesos de Eventos pendientes \n";
    }
}

?>
