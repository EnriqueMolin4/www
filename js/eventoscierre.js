var infoAjax = 0;
$(document).ready(function() {
        ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "eventoscierrelink")
		$("#btnRegistrar").attr('disabled',true);
        $("#fecha_atencion").attr('disabled',true);
        $("#hora_llegada").attr('disabled',true);
        $("#hora_salida").attr('disabled',true);
        $("#estatus").attr('disabled',true);
        $("#btnConsultar").attr('disabled',true);
        $("#sn-anteriorbk").hide();
		$("#sim-anteriorbk").hide();
        getRechazos()
        getSubRechazos();
        getCancelaciones();
        getModelos();
        getConectividad();
		getEstatusServicio();
		
		$("#servicio-aplicativo").on('change',function() {
			$(this).val($(this).val().toUpperCase());
		});  

        $("#fecha_atencion").datetimepicker({
            format:'Y-m-d H:i'
        });

        $("#hora_llegada").datetimepicker({
            datepicker:false,
            format:'H:i'
        });

        $("#hora_salida").datetimepicker({
            datepicker:false,
            format:'H:i'
        });

        $("#afiliacion").on('change', function() {
            if($("#odt").val().length > 7 && $("#afiliacion").val().length > 0 ) {
            $.toaster({
                message: 'Validando Afiliaci�n',
                title: 'Aviso',
                priority : 'warning'
            });   
            setTimeout(validateOdt,2000);
            } else {
				
				$.toaster({
                    message: 'Favor de Capturar los campos de ODT y Afiliacion',
                    title: 'Aviso',
                    priority : 'danger'
                }); 
			}
        }) 

        $("#odt").on('input', function() {
            console.log($("#afiliacion").val().length)
			if($("#odt").val().length > 7) {
				if(  $("#afiliacion").val().length > 0  ) {
					$.toaster({
						message: 'Validando ODT',
						title: 'Aviso',
						priority : 'warning'
					}); 
					setTimeout(validateOdt,2000);
				} else {
					
					$.toaster({
						message: 'Favor de Capturar la Afiliacion',
						title: 'Aviso',
						priority : 'danger'
					}); 
				}
			}
        })

        $("#servicio-sn").on('change', function() {
            var modelo = $(this).find(':selected').attr('data-id').split("-");
            $("#servicio-modelo").val(modelo[0]);
            $("#servicio-ptid").val(modelo[1]);
            $("#servicio-connect").val(modelo[2]);
        })

        $("#servicio-sn-anterior").on('change', function() {
			if( $(this).val() == '-1' ) {
				$("#sn-anteriorbk").show();
			} else {
				$("#sn-anteriorbk").hide();
			}
            var modelo = $(this).find(':selected').attr('data-id').split("-");
            $("#servicio-modelo-anterior").val(modelo[0]);
            $("#servicio-ptid-anterior").val(modelo[1]);
            $("#servicio-connect-anterior").val(modelo[2]);
        })
		
		$("#servicio-sim-anterior").on('change', function() {
			if( $(this).val() == '-1' ) {
				$("#sim-anteriorbk").show();
			} else {
				$("#sim-anteriorbk").hide();
			}
           
        })
		
		
        
        $.ajax({
            type: 'GET',
            url: 'modelos/eventos_db.php', // call your php file
            data: 'module=getTipoServicios&tipo=0',
            cache: false,
            success: function(data){
            $("#select-servicio-realizado").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });

        $("#btnConsultar").on('click', function() {
           
            if( validateInfo() > 0  ) {
                $.ajax({
                    type: 'GET',
                    url: 'modelos/eventos_db.php', // call your php file
                    data: 'module=getConsultaODT&odt='+$("#odt").val(),
                    cache: false,
                    success: function(data){
                    
                        var info = JSON.parse(data);
                        
                        var texto = "";
                        $.each(info, function(index,element) {
                            
                            var fecha_atencion = $("#fecha_atencion").val();
                            
                            $("#odtId").val(element.id);
                             

                            if(element.afiliacion != $("#afiliacion").val() ) {                          
                                
                                $.toaster({
                                    message: 'LA AFILIACION NO COINCIDE CON LA ODT',
                                    title: 'Aviso',
                                    priority : 'danger'
                                });   
                            } else if (element.estatus == 'CERRADO' ) { 
                                $.toaster({
                                    message: 'EL EVENTO ESTA CERRADO',
                                    title: 'Aviso',
                                    priority : 'danger'
                                });                          
                            } else if(element.tecnico === null ) {                          
                                
                                $.toaster({
                                    message: 'FALTA ASIGNAR UN TECNICO AL EVENTO',
                                    title: 'Aviso',
                                    priority : 'danger'
                                });   
                                
                            } else if( moment( fecha_atencion ).isAfter( element.fecha_cierre ) ) {                          
                                
                                $.toaster({
                                    message: 'EL EVENTO ESTA FUERA DE TIEMPO, FAVOR DE CAPTURAR LA CAUSA',
                                    title: 'Aviso',
                                    priority : 'danger'
                                });  
                                showByStatus( $("#estatus").val() )
                                $("#divFueraTiempo").show() 
                                console.log("pruebas")
								$("#btnRegistrar").attr('disabled',false);
                            } else {
                                //if(element.servicio != '15') {
                                  showByStatus( $("#estatus").val() )   
                                //}
								$("#btnRegistrar").attr('disabled',false);
                            }

                            $("#tecnico").val(element.nombre_tecnico);
                            $("#servicio").val(element.servicioNombre);
                            

                        })

                        
                    },
                    error: function(error){
                        var demo = error;
                    }
                });
            } else {
                $.toaster({
                    message: 'Falta Capturar Datos',
                    title: 'Aviso',
                    priority : 'danger'
                });

            }
        })

         $("#estatus").on("change",function() {

            /*showByStatus($(this).val())
            console.log($(this).val())
            switch ( $(this).val() ) {
                case '1':
                    console.log("1")
                    $("#serviciorealizado").show();
                    $("#serviciocancelado").hide();
                    $("#serviciorechazado").hide();
                break;
                case '2':
                    console.log("2")
                    $("#serviciocancelado").show();
                    $("#serviciorealizado").hide();
                    $("#serviciorechazado").hide();
                break;
                case '3':
                    console.log("3")
                    $("#serviciorechazado").show();
                    $("#serviciorealizado").hide();
                    $("#serviciocancelado").hide();
                break;
                default:
                    console.log("Default")
                    $("#serviciorechazado").hide();
                    $("#serviciorealizado").hide();
                    $("#serviciocancelado").hide();
            }*/
        }) 

        $("#btnRegistrar").on("click", function() {

			if( $("#servicio-rollosentregados").val().length == 0 ) {
				$("#servicio-rollosentregados").val('0');
			}
				var dnd = { module: 'grabarCierre',odt : $("#odt").val(),odtid : $("#odtId").val(), afiliacion: $("#afiliacion").val() , estatus: $("#estatus").val(), fueratiempo: $("#cierre_evento-causa_fuera_tiempo").val()
							,fechaatencion: $("#fecha_atencion").val(), horallegada: $("#hora_llegada").val(), horasalida: $("#hora_salida").val()
							,serviciorealizado: $("#select-servicio-realizado").val() , personarecibe: $("#cierre_evento-persona_servico").val() 
							,comentariocierre: $("#cierre_evento-comentarios").val(), motivocancelacion:$("#cierre_evento-motivo_cancelacion").val(),
							cveautorizacion: $("#cierre_evento-cve_autorizacion").val(), autorizo: $("#cierre_evento-autorizo").val(),
							tpv_instalado: $("#servicio-sn").val(), tpv_retirado: $("#servicio-sn-anterior").val(),sim_instalado: $("#servicio-sim").val(), 
							sim_retirado: $("#servicio-sim-anterior").val(),sim_retirado_manual: $("#servicio-sim-anterior-manual").val(),ptid: $("#servicio-ptid").val(),comercioid:$("#select-servicio-comercio").val(),
							connect:$("#servicio-connect").val(), tecnicoid: $("#tecnicoid").val(), rollosentregados: $("#servicio-rollosentregados").val(), 
							tvp_retirado_manual:$("#servicio-sn-anterior-manual").val(),producto: $("#servicio-producto").val(),aplicativo: $("#servicio-aplicativo").val(),version: $("#servicio-version").val(),afiliacionamex: $("#servicio-version").val(), idcaja: $("#idcaja").val(),idamex: $("#idamex").val() };
				
				$.ajax({
					type: 'GET',
					url: 'modelos/eventos_db.php', // call your php file
					data: dnd,
					cache: false,
					success: function(data){
						var info = JSON.parse(data);
						console.log(info.existe);
	 
						if(info.existe == 1) {
							
							$.toaster({
								message: 'La ODT '+info.odt+ ' ha sido cerrada con Estatus '+ info.estatusnombre,
								title: 'Cierre de Orden',
								priority : 'success'
							});
							cleartext();
						} else {
							$.toaster({
								message: 'Hay un error con la ODT '+info.odt+ ' Favor de validar',
								title: 'Cierre de Orden',
								priority : 'warning'
							});
						}
					
					}
				});
			
            
        })

        $("#servicio-sn").on('change', function() {
            
            
        })




        
    } );

function showByStatus(estatus) {
    switch ( estatus ) {
        case '13':
            console.log("1")
            if($("#servicioTipo").val() != '15') {
                $("#serviciorealizado").show();
				if( $("#servicioTipo").val() == '5') {
                    $("#tvpMant").show();
                    $("#tvpCambios").hide();
                    $("#tvpSim").hide();
                    $("#tvpSN").show();
                    $("#tvpMod").hide();

                } else if ( $("#servicioTipo").val() == '9') {
                    $("#tvpCambios").show();
                    $("#tvpSim").show();
                    $("#tvpSN").show();
                    $("#tvpMod").show();
                
                } else if ( $("#servicioTipo").val() == '7' ) {
                    $("#tvpCambios").hide();
                    $("#tvpSim").hide();
                    $("#tvpSN").show();
                    $("#tvpMod").hide();

                } else if ( $("#servicioTipo").val() == '1'  ) {
					$("#tvpMant").hide();
                } else if ( $("#servicioTipo").val() == '19' ) {
					$("#tvpMant").show();
                    $("#tvpCambios").hide();
					$("#tvpSim").show();
                    $("#tvpSN").show();
					$("#tvpMod").hide();
				} else {
                    $("#tvpCambios").show();
                    $("#tvpSim").show();
				}
				
				
                
                
				
            }
            $("#serviciocancelado").hide();
            $("#serviciorechazado").hide();
			$("#servicio-rollosentregados").val('');
        break;
        case '14':
            console.log("2")
            $("#serviciocancelado").show();
            $("#serviciorealizado").hide();
            $("#serviciorechazado").hide();
			$("#servicio-rollosentregados").val('0');
        break;
        case '15':
            console.log("3")
            $("#serviciorechazado").show();
            $("#serviciorealizado").hide();
            $("#serviciocancelado").hide();
			$("#servicio-rollosentregados").val('0');
        break;
        default:
            console.log("Default")
            $("#serviciorechazado").hide();
            $("#serviciorealizado").hide();
            $("#serviciocancelado").hide();
			$("#servicio-rollosentregados").val('');
    }
}
function validateOdt() {
    var odt = $("#odt").val(); 
	var serviciorealizado = $("#select-servicio-realizado").val();
	
	if(serviciorealizado == '5') {
		$("#servicio-sn").attr("readonly",true);
		$("#servicio-sn-anterior").attr("readonly",true);
		$("#servicio-sim").attr("readonly",true);
		$("#servicio-sim-anterior").attr("readonly",true);
		$("#servicio-ptid").attr("readonly",true);
		$("#servicio-ptid-anterior").attr("readonly",true);
		$("#select-servicio-comercio").attr("readonly",true);
		$("#servicio-connect").attr("readonly",true);
		$("#servicio-producto").attr("readonly",true);
		$("#servicio-aplicativo").attr("readonly",true);
		$("#servicio-version").attr("readonly",true);
		$("idcaja").attr("readonly",true);
		$("idamex").attr("readonly",true);
		$("afiliacion_amex").attr("readonly",true);
	} else {
		$("#servicio-sn").attr("readonly",false);
		$("#servicio-sn-anterior").attr("readonly",false);
		$("#servicio-sim").attr("readonly",false);
		$("#servicio-sim-anterior").attr("readonly",false);
		$("#servicio-ptid").attr("readonly",false);
		$("#servicio-ptid-anterior").attr("readonly",false);
		$("#select-servicio-comercio").attr("readonly",false);
		$("#servicio-connect").attr("readonly",false);
		$("#servicio-producto").attr("readonly",false);
		$("#servicio-aplicativo").attr("readonly",false);
		$("#servicio-version").attr("readonly",false);
		$("idcaja").attr("readonly",false);
		$("idamex").attr("readonly",false);
		$("afiliacion_amex").attr("readonly",false);
	}

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=validateOdt&odt='+odt+"&afiliacion="+$("#afiliacion").val(),
        cache: false,
        success: function(data){
            
            var existe = JSON.parse(data);
            if(existe.length > 0 ) {
                $.each(existe, function(index,parameter) {
                    if(parameter.existe == 0 ) {
						$("#tecnico").val("")
						$("#fecha_atencion").val("");
						$("#hora_llegada").val("")
						$("#hora_salida").val("");
						$("#status").val("0")
						$("#cierre_evento-causa_fuera_tiempo").val("")
						$("#select-servicio-realizado").val("0")
						$("#servicio").val("")
						$("#cierre_evento-persona_servico").val("");
						$("#cierre_evento-comentarios").val("")
						$("#serviciorealizado").hide();
						$("#serviciocancelado").hide();
						$("#serviciorechazado").hide();
						$("#select-servicio-comercio").val("");
						$("#estatus_validacion").val("");
						$("$subservicio").val("");
						$("#servicio_descripcion").val("");
                        $.toaster({
                            message: 'La ODT no coincide con la afiliaci�n',
                            title: 'Aviso',
                            priority : 'danger'
                        });  
                    } 
                    $("#servicioTipo").val(parameter.tipo_servicio)
                    $("#select-servicio-comercio").val(parameter.comercio)
                    switch(parameter.estatus) {
                        case '2':
                            $("#fecha_atencion").removeAttr('disabled');
                            $("#hora_llegada").removeAttr('disabled');
                            $("#hora_salida").removeAttr('disabled');
                            $("#estatus").removeAttr('disabled');
                            $("#tecnico").val(parameter.tecnico);
                            $("#fecha_atencion").val(parameter.fecha_atencion);
                            $("#tecnicoid").val(parameter.tecnicoId);
                            $("#btnConsultar").removeAttr('disabled');
                            $("#odtId").val(parameter.id);
                            $("#afiliacion").val(parameter.afiliacion);
                            $("#servicio").val(parameter.servicioNombre);
                            $("#select-servicio-realizado").val(parameter.tipo_servicio)
                            $("#subservicio").val(parameter.subservicioNombre);
                            $("#afiliacion_amex").val(parameter.afiliacionamex);
                            $("#idamex").val(parameter.amex);
                            $("#idcaja").val(parameter.id_caja);
                            getNumSerieTecnico(parameter.tecnicoId)
                            getNumSerieSimTecnico(parameter.tecnicoId)
                            if(parameter.validacionNombre ==null) {
                                parameter.validacionNombre = 'No hay llamada de Validacion'
                            }
                            $("#estatus_validacion").val(parameter.validacionNombre)
                            $("#servicio_descripcion").val(parameter.descripcion)
                            $("#servicio-rollosinstalar").val(parameter.rollos_instalar)
                            $("#servicio-rollosentregados").val(parameter.rollos_entregados)
                           // if(parameter.tipo_servicio == '1' || parameter.tipo_servicio == '2' || parameter.tipo_servicio == '7' || parameter.tipo_servicio == '2') {
                                getNumSerieComercio(parameter.comercio);
                                getNumSerieSimComercio(parameter.comercio);
                            // }
                        break;
                        case '1':
                            if(parameter.tipo_servicio == '3') {
                              $("#fecha_atencion").removeAttr('disabled');
                              $("#hora_llegada").removeAttr('disabled');
                              $("#hora_salida").removeAttr('disabled');
                              $("#estatus").removeAttr('disabled');
                              $("#tecnico").val(parameter.tecnico);
							  $("#fecha_atencion").val(parameter.fecha_atencion);
                              $("#btnConsultar").removeAttr('disabled');
                              $("#odtId").val(parameter.id);
                              $("#afiliacion").val(parameter.afiliacion);
                              $("#servicio").val(parameter.servicio);
                              $("#subservicio").val(parameter.tipo_servicio);
                              $("#afiliacion_amex").val(parameter.afiliacionamex);
                              $("#idamex").val(parameter.amex);
                              $("#idcaja").val(parameter.id_caja);
                              if(parameter.validacionNombre == null) {
                                parameter.validacionNombre = 'No hay llamada de Validacion'
                            }
                            $("#estatus_validacion").val(parameter.validacionNombre)
                            $("#servicio_descripcion").val(parameter.descripcion)
                            $("#servicio-rollosinstalar").val(parameter.rollos_instalar)
                            $("#servicio-rollosentregados").val(parameter.rollos_entregados)
                              getNumSerieTecnico(parameter.tecnicoId)
                              getNumSerieSimTecnico(parameter.tecnicoId)
                              if(parameter.tipo_servicio == '1' || parameter.tipo_servicio == '2') {
                                    getNumSerieComercio(parameter.comercio);
                                    getNumSerieSimComercio(parameter.comercio);
                              }

                            } else {
							
								$("#tecnico").val("")
								$("#fecha_atencion").val("");
								$("#hora_llegada").val("")
								$("#hora_salida").val("");
								$("#status").val("0")
								$("#cierre_evento-causa_fuera_tiempo").val("")
								$("#select-servicio-realizado").val("0")
								$("#servicio").val("")
								$("#subservicio").val("");
								$("#cierre_evento-persona_servico").val("");
								$("#cierre_evento-comentarios").val("")
								$("#serviciorealizado").hide();
								$("#serviciocancelado").hide();
								$("#serviciorechazado").hide();
								$("#select-servicio-comercio").val("");
								$("#estatus_validacion").val("");
								$("#subservicio").val("");
								$("#servicio_descripcion").val("");
                              $.toaster({
                                  message: 'La ODT aun no se asigna ',
                                  title: 'Aviso',
                                  priority : 'danger'
                              }); 
                            }
                        break;
                        case '3':
							$("#tecnico").val("")
							$("#fecha_atencion").val("");
							$("#hora_llegada").val("")
							$("#hora_salida").val("");
							$("#status").val("0")
							$("#cierre_evento-causa_fuera_tiempo").val("")
							$("#select-servicio-realizado").val("0")
							$("#servicio").val("")
							$("#subservicio").val("");
							$("#cierre_evento-persona_servico").val("");
							$("#cierre_evento-comentarios").val("")
							$("#serviciorealizado").hide();
							$("#serviciocancelado").hide();
							$("#serviciorechazado").hide();
							$("#select-servicio-comercio").val("");
							$("#estatus_validacion").val("");
							$("#subservicio").val("");
							$("#servicio_descripcion").val("");
                            $.toaster({
                                message: 'La ODT Ya esta cerrada',
                                title: 'Aviso',
                                priority : 'danger'
                            });  
                        break;
						case '10':
                            $("#fecha_atencion").removeAttr('disabled');
                            $("#hora_llegada").removeAttr('disabled');
                            $("#hora_salida").removeAttr('disabled');
                            $("#estatus").removeAttr('disabled');
                            $("#tecnico").val(parameter.tecnico);
                            $("#fecha_atencion").val(parameter.fecha_atencion);
                            $("#tecnicoid").val(parameter.tecnicoId);
                            $("#btnConsultar").removeAttr('disabled');
                            $("#odtId").val(parameter.id);
                            $("#afiliacion").val(parameter.afiliacion);
                            $("#servicio").val(parameter.servicioNombre);
                            $("#select-servicio-realizado").val(parameter.tipo_servicio)
                            $("#subservicio").val(parameter.subservicioNombre);
                            $("#afiliacion_amex").val(parameter.afiliacionamex);
                            $("#idamex").val(parameter.amex);
                            $("#idcaja").val(parameter.id_caja);
                            getNumSerieTecnico(parameter.tecnicoId)
                            getNumSerieSimTecnico(parameter.tecnicoId)
                            if(parameter.validacionNombre ==null) {
                                parameter.validacionNombre = 'No hay llamada de Validacion'
                            }
                            $("#estatus_validacion").val(parameter.validacionNombre)
                            $("#servicio_descripcion").val(parameter.descripcion)
                            $("#servicio-rollosinstalar").val(parameter.rollos_instalar)
                            $("#servicio-rollosentregados").val(parameter.rollos_entregados)
                           // if(parameter.tipo_servicio == '1' || parameter.tipo_servicio == '2' || parameter.tipo_servicio == '7' || parameter.tipo_servicio == '2') {
                                getNumSerieComercio(parameter.comercio);
                                getNumSerieSimComercio(parameter.comercio);
                            // }
                        break;
                    }
                })
            } else {
				$("#tecnico").val("")
				$("#fecha_atencion").val("");
				$("#hora_llegada").val("")
				$("#hora_salida").val("");
				$("#status").val("0")
				$("#cierre_evento-causa_fuera_tiempo").val("")
				$("#select-servicio-realizado").val("0")
				$("#servicio").val("")
				$("#subservicio").val("");
				$("#cierre_evento-persona_servico").val("");
				$("#cierre_evento-comentarios").val("")
				$("#serviciorealizado").hide();
				$("#serviciocancelado").hide();
				$("#serviciorechazado").hide();
				$("#select-servicio-comercio").val("");
				$("#estatus_validacion").val("");
				$("#subservicio").val("");
				$("#servicio_descripcion").val("");
                $.toaster({
                    message: 'La ODT no coincide con la afiliaci�n',
                    title: 'Aviso',
                    priority : 'danger'
                });  
            }
        },
        error: function(error){
            
        }
    });
}    
      


function cleartext() {
    $("#odt").val("")
    $("#afiliacion").val("")
    $("#tecnico").val("")
    $("#fecha_atencion").val("");
    $("#hora_llegada").val("")
    $("#hora_salida").val("");
    $("#status").val("0")
    $("#cierre_evento-causa_fuera_tiempo").val("")
    $("#select-servicio-realizado").val("0")
    $("#servicio").val("")
    $("#cierre_evento-persona_servico").val("");
    $("#cierre_evento-comentarios").val("")
    $("#serviciorealizado").hide();
    $("#serviciocancelado").hide();
    $("#serviciorechazado").hide();
    $("#select-servicio-comercio").val("");
	$("#estatus_validacion").val("");
	$("#subservicio").val("");
	$("#servicio_descripcion").val("");
	$("#estatus").val("0");
	servicio-sim-anterior*
	servicio-sn-anterior*
	$("#servicio-sim-anterior-manual").val("");
	$("#servicio-sn-anterior-manual").val("");
    $("#servicio-modelo-anterior").val("0");
	$("#servicio-ptid-anterior").val("");
	$("#servicio-connect-anterior").val("0");
	servicio-sim *
	servicio-sn*
	$("#servicio-modelo").val("0");
	$("#servicio-connect").val("0");
	$("#servicio-ptid").val("");
	$("#servicio-aplicativo").val("");
	$("#servicio-producto").val("");
	$("#servicio-version").val("");
	$("#afiliacion_amex").val("");
	$("#idcaja").val("");
	$("#idamex").val("");
	$("#servicio-rollosinstalar").val("");
	$("#servicio-rollosentregados").val("");
	

}

function validateInfo() {
    var error = 0;
    var result = true;

    if($("#odt").val().length == 0 ) {
        error = error + 1;
    }

    if($("#afiliacion").val().length == 0 ) {
        error = error + 1;
    }

    if($("#hora_llegada").val().length == 0 ) {
        error = error + 1;
    }

    if($("#hora_salida").val().length == 0 ) {
        error = error + 1;
    }

    if($("#estatus").val()  == "0" ) {
        error = error + 1;
    }

    if( error > 0) {
        result = false
    }

    return result;
}

function getRechazos() {

        $.ajax({
            type: 'GET',
            url: 'modelos/eventos_db.php', // call your php file
            data: 'module=getRechazos',
            cache: false,
            success: function(data){
            $("#cierre_evento-motivo_rechazo").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    
}

function getSubRechazos() {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getSubRechazos',
        cache: false,
        success: function(data){
        $("#cierre_evento-motivo_subrechazo").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}



function getCancelaciones() {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getCancelacion',
        cache: false,
        success: function(data){
        $("#cierre_evento-motivo_cancelacion").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function getModelos() {
    
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getModelos',
        cache: false,
        success: function(data){
        $("#servicio-modelo").html(data);  
        $("#servicio-modelo-anterior").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getNumSerieTecnico(idTecnico) {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getNumSerieTecnico&tecnico_id='+idTecnico,
        cache: false,
        success: function(data){
            $("#servicio-sn").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function getNumSerieComercio(idComercio) {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getNumSerieTecnico&tecnico_id='+idComercio,
        cache: false,
        success: function(data){
			data += '<option value="-1">Otro</option>';
            $("#servicio-sn-anterior").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function getNumSerieSimTecnico(idTecnico) {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getNumSerieSimTecnico&tecnico_id='+idTecnico,
        cache: false,
        success: function(data){
            $("#servicio-sim").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function getNumSerieSimComercio(idComercio) {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getNumSerieSimTecnico&tecnico_id='+idComercio,
        cache: false,
        success: function(data){
			data += '<option value="-1">Otro</option>';
            $("#servicio-sim-anterior").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}


function getConectividad() {
    
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoConectividad',
        cache: false,
        success: function(data){
            $("#servicio-connect").html(data); 
            $("#servicio-connect-anterior").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getEstatusServicio() {
    
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEstatusServicio',
        cache: false,
        success: function(data){
            $("#estatus").html(data); 
                      
        },
        error: function(error){
            var demo = error;
        }
    });
}


//# sourceURL=js/eventoscierre.js