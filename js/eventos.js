var infoAjax = 0;
var scriptSinFiltro;
var tableEventos,PermisosEvento;
var validData = [];				 
$(document).ready(function() {
	var deg = 0;
    ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "eventoslink")
         $.datetimepicker.setLocale('es');
        getTipoEvento();
        getEstatusEvento();
		getEstatusServicio();
		getRechazos();
		getSubRechazos();
        getCancelado();
        getProductos();
		getAplicativo();
        getVersion();
        getModelos();
        getConectividad();
        getCarrier();
        getTerritoriosFilter();
        getTecnicosf();
        getBancosf();
        $("#fechaVen_inicio").datetimepicker({
			timepicker:false,
            format:'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
			timepicker:false,
            format:'Y-m-d'
        });

        $("#fecha_atencion").datetimepicker({
			timepicker:false,
            format:'Y-m-d'
        });


        tableEventos = $('#eventos').DataTable({
            order: [[ 8, "desc" ]],
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
			order: [[ 6, "ASC" ]],		  
            dom: 'lfrtiBp',
            buttons: [
                'pdf',
                'excelHtml5',
                'csv'
            ],
            ajax: {
                url: 'modelos/eventos_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable',
                    d.estatusSearch = $("#estatus_busqueda").val(),
                    d.tipoevento = $("#tipo_evento").val(),
                    d.fechaVen_inicio = $("#fechaVen_inicio").val(),
                    d.fechaVen_fin = $("#fechaVen_fin").val(),
                    d.evidencias = $('#evidencias').is(':checked') ? 1 : 0,
                    d.territorialF = $('#territorialF').val(),
                    d.tecnicof = $('#tecnicoF').val(),
                    d.bancof = $('#bancoF').val()
                }
            },
            columns : [
                { data: 'odt'},
                { data: 'afiliacion' },
                { data: 'cveBancoNombre' },
                { data: 'comercio' },
                { data: 'servicio' },
                { data: 'fecha_alta'},
                { data: 'fecha_vencimiento'},
				{ data: 'fecha_cierre'},
                { data: 'totalImg'},
                { data: 'tecnico'} ,
                { data: 'nombreEstatus' },
				{ data: 'nombreEstatusServicio' },
                { data: 'id'}
                  
            ],
            aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "15%",
                    
                },
                {
                    "targets": [ 1 ],
                    "visible": $("#tipo_user").val() == 'callcenter' ? false : true
                    
                },
                {
                    "targets": [12],
                    "mRender": function ( data,type, row ) {
                        var btnALL = '';
                        var btnCambiarEstatus = '<a href="#" title="Cambiar Estatus" class="btnCambiarEst" data="'+row.id+'"><i class="fas fa-undo fa-2x"></i></a>';
                        var btnInfo = '<a href="#" class="editCom" title="Información del evento" data="'+row.id+'"><i class="fas fa-edit fa-2x " style="color:#187CD0"></i></a>';
                        var btnCambiarOdt = '<a href="#" title="Cambiar ODT" class="chgODT" data="'+row.odt+'"><i class="fas fa-exchange-alt fa-2x " style="color:red"></i></a>';
                        var btnHistoria = '<a href="#" class="mostrarHistoria" data="'+row.odt+'"><i class="fas fa-history fa-2x" style="color:#C17137"></i> </a>';
                        var btnCerrar = '<a href="#" class="endEvent" title="Cerrar evento" data="'+row.id+'"><i class="far fa-calendar fa-2x " style="color:#E04242"></i></a>';
                        if(row.nombreEstatus==='Cerrado' && $("#tipo_user").val() == 'callcenterADM')
                        {
                            btnALL= btnCambiar+btnInfo+btnCambiarOdt+'<br>'+btnHistoria;  
                        } else if(row.sync = '0') {
                            btnALL= btnInfo+btnCerrar+btnCambiarOdt+btnHistoria;
                        }

                        return btnALL;
                    }
                }
            ],
            fixedColumns: true,
            rowCallback: function( row, data, index,full){
               if($("#tipo_user").val() != 'VO' ) {
                fnShowHide( 6,true )
                    var fechacompromiso = moment(data.fecha_vencimiento)
                    var now = moment();
                    var diff = moment.duration(fechacompromiso.diff(now));
                    var col = this.api().column(6).index('visible');
                    /*console.log('Evento '+fechacompromiso.format('YYYY-MM-DD'));
                    console.log('HOY '+now.format('YYYY-MM-DD'));
                    console.log('Diferencia Dias '+ fechacompromiso.diff(now,'days'))
                    console.log('Diferencia Horas '+ fechacompromiso.diff(now,'hours'))
                    console.log('dias '+diff.days())
                    console.log('horas '+diff.hours())
                    console.log(fechacompromiso.isBefore(now) );*/
                    if(fechacompromiso.isAfter(now) ) {
                        if( fechacompromiso.diff(now,'hours') > 24  && data.nombreEstatus != 'Exito'){
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#00cc66');
                        } else if ( fechacompromiso.diff(now,'hours') == 24 && data.nombreEstatus != 'Exito' ){
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ff6600');
                        } else if( fechacompromiso.diff(now,'hours') <= 24 ){
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ffff00');
                        } else if( fechacompromiso.diff(now,'hours') <= 5 ){
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ae2b2b');
                        } 
                    }

                    if(fechacompromiso.isBefore(now) && data.nombreEstatus != 'Exito' ) {
                        
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ae2b2b');
                        
                    }
                    //Semáforo no aplica para eventos cerrados
                    if(data.nombreEstatus == 'Cerrado')
                    {
                        $('td', row).eq(col).css('color', '#3F4044');
                        $('td', row).eq(col).css('background-color', '#fff');
                    }

                } else {
                    fnShowHide( 6,false )
                }
            }
        });

	
	$('#historia').DataTable({ 
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        searching: false,
        order: [[ 0, "ASC" ]],
        dom: 'lfrtiBp',
        buttons: [
            'pdf',
            'excelHtml5'
            
        ],
        ajax: {
            url: 'modelos/eventos_db.php',
            type: 'POST',
            data: function (d) {
                d.module = 'getHistorialodt',
                d.historiaOdt = $("#historiaOdt").val()
            }
        },
        columns : [
            { data: 'evento_id' },
            { data: 'fecha_movimiento' },
            { data: 'nombre' },
            { data: 'correo' }
        ]

    });

    $('#historiaevento').DataTable({ 
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
        processing: true,
        serverSide: true,
        searching: false,
        order: [[ 0, "ASC" ]],
        dom: 'lfrtiBp',
        buttons: [
            'pdf',
            'excelHtml5'
                ],

        ajax: {
        url: 'modelos/eventos_db.php',
        type: 'POST',
        data: function (d) {
            d.module = 'getHistorialEvento',
            d.historiaOdt = $("#historiaOdt").val()
            }
        },
        columns : [
            { data: 'SerieEntrada' },
            { data: 'Aplicativo' },
            { data: 'Conectividad' },
            { data: 'SerieSalida' },
            { data: 'SimEntrada'},
            { data: 'SimSalida'}
        ]

	});



        $(document).on("click",".mostrarHistoria", function() {
                
        
            var index = $(this).parent().parent().index() ;
            var data = tableEventos.row( index ).data()
            console.log(index)
            console.log(data)
            //getTecnicos();
            $("#historiaOdt").val(data.odt);


            //Details
            $("#hist-producto").val('TPV');
            $("#hist-noserie").val(data.no_serie);
            $("#hist-desde").val(data.ubicacion);
            $("#ubicacionId").val(data.ubicacionId);
            
            $("#showHistoria").modal("show");
                    
        
        })
		
	
        $('#showHistoria').on('show.bs.modal', function () {
            $(this).find('.modal-body').css({
                width: 'auto',
                height: 'auto',
                'max-height': '100%'
            });
            
            $('#historia').DataTable().ajax.reload();
            $('#historiaevento').DataTable().ajax.reload();
        })

		$("#evidencias").on("change", function() {
            
            if ( $(this).is(":checked") )  {
                $('#eventos').DataTable().ajax.reload();
            }
        })
		
        $(".searchEvento").on('change', function() {

            $('#eventos').DataTable().ajax.reload();
        })

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

        $(document).on("click", ".endEvent",function() {
            var id = $(this).attr('data');

            window.location.href = "eventoscierre.php?id="+id;
        })

        $(document).on("click",".editCom", function() {
            var id = $(this).attr('data');
            $("#eventoId").val(id);
            $("#showEvento").modal({show: true, backdrop: false, keyboard: false})
            
        })
  
        $(document).on("click",".btnCambiarEst", function(){

			var odt = $(this).attr('data');

			if (confirm("Se cambiará el estatus del evento a Abierto. ¿Estas seguro?")) 
			{
				var estatus = 16;

				$.ajax({
					type: 'GET',
					url: 'modelos/eventos_db.php',
					data: 'module=cambiarEstatusEvento&estatus='+estatus+"&odtid="+odt,
					cache: false,
					success: function(data){
						$.toaster({
							message: 'Se cambió el estatus con éxito',
							title: 'Aviso',
							priority: 'success'
						});
						tableEventos.ajax.reload();
					},
					error: function(error)
					{
						var demo = error;
					}
				}); 


			}
				else
			{
				 $.toaster({
							message: 'No se actualizó el estatus del evento ',
							title: 'Aviso',
							priority : 'warning'
						});  
			}


		})

        $(document).on("click",".chgODT", function() {
            var odt = $(this).attr('data');
            $("#old_odt").val(odt);
            $("#chgODT").modal({show: true, backdrop: false, keyboard: false})
        })
		
		$("#addDocuments").on("click", function() {
			var totalArchivos = $("#documentos")[0].files;
			var odt = $("#odt").val();
			console.log(totalArchivos);
			
			$.each(totalArchivos, function(index,element) {
				console.log(element);
				
				subirFotos(odt,element)
			});
			
			$("#documentos").val('');
			showDocumentos();
		})

        $('#showEvento').on('show.bs.modal', function (e) {
           
                $.ajax({
                    type: 'GET',
                    url: 'modelos/eventos_db.php', // call your php file
                    data: 'module=getstados',
                    cache: false,
                    success: function(data){
                    $("#estado").html(data);            
                    },
                    error: function(error){
                        var demo = error;
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: 'modelos/eventos_db.php', // call your php file
                    data: 'module=getevento&eventoid='+$("#eventoId").val(),
                    cache: false,
                    success: function(data){
                    
                        var info = JSON.parse(data);
                    
                        if(info == null ) {
                            $("#showEvento").modal('hide');
                            cleartext()
                            alert("Hay Problemas con los Datos")

                        } else {

                            $.each(info, function(index, element) {

                                // trae validaciones de Campos obligatorios
                                    camposObligatorios(element.tipo_servicio)
                                        .then( (data) => {
                                            PermisosEvento = data
                                        })
                                    
                                    //EXTRAS
                                    getInfoExtra(element.odt);

                                    $("#odt").val(element.odt)
                                    $("#afiliacion").val(element.afiliacion)
                                    $("#tipo_servicio").val(element.servicioNombre);
                                    $("#tipo_subservicio").val(element.subservicioNombre);
                                    $("#fecha_alta").val(element.fecha_alta);
                                    $("#fecha_vencimiento").val(element.fecha_vencimiento)
                                    $("#fecha_cierre").val(element.fecha_cierre);
                                    $("#servicioId").val(element.tipo_servicio);
                                    
                                    if(element.tipo_servicio == '15') {
                                    $("#comercio").val(element.cliente_vo)
                                    } else {
                                        $("#comercio").val(element.comercioNombre)
                                    }
                                    $("#receptor_servicio").val(element.receptor_servicio);
                                    $("#fecha_atencion").val(element.fecha_atencion);
                                    $("#colonia").val(element.colonia)
                                    $("#ciudad").val(element.municipioNombre)
                                    $("#estado").val(element.estadoNombre)
                                    $("#direccion").val(element.direccion)
                                    $("#telefono").val(element.telefono)
                                    $("#descripcion").val(element.descripcion);
                                    $("#hora_atencion").val(element.hora_atencion+" | "+element.hora_atencion_fin)
                                    $("#hora_llegada").val(element.hora_llegada)
                                    $("#hora_salida").val(element.hora_salida)
                                    $("#tecnico").val(element.tecnicoNombre)
                                    $("#tecnicoid").val(element.tecnico)
                                    $("#estatus").val(element.estatusNombre)
                                    $("#servicio").val(element.servicioNombre)
                                    $("#comentarios_tecnico").val(element.comentarios)
									$("#comentarios_validacion").val(element.comentarios_validacion)
                                    $("#servicio_final").val(element.serviciofinalNombre)
                                    $("#comentarios_cierre").val(element.comentarios_cierre)
                                    $("#fecha_asignacion").val(element.fecha_asignacion);
                                    $("#hora_comida").val(element.hora_comida+" | "+element.hora_comida_fin);
                                    $("#latitud").val( element.latitud );
                                    $("#longitud").val( element.longitud );
                                
                                    $("#tipo_credito").val(element.tipocreditoNombre);
                                    $("#tieneamex").val(element.tieneamex);
                                    $("#afiliacion_amex").val(element.afiliacionamex);
                                    $("#idamex").val(element.amex);
                                    $("#idcaja").val(element.id_caja);
                                    $("#tpv").val(element.tpv_instalado);
                                    $("#tpv_retirado").val(element.tpv_retirado); 
                                    $("#version").val(element.version);
                                    $("#aplicativo").val(element.aplicativo);
                                    $("#producto").val(element.producto);
                                    $("#rollos_instalar").val(element.rollos_instalar);
                                    $("#rollos_entregados").val(element.rollos_entregados);
                                    $("#sim_instalado").val(element.sim_instalado);
                                    $("#sim_retirado").val(element.sim_retirado);
                                    $("#estatus_servicio").val(element.estatus_servicio);

                                    //tipodeUsuario(element.estatus);
                                    
                                 /*   if (element.estatus_servicio == '13' )
                                    {
                                        if($("#tipo_user").val() == 'callcenterADM' ) {
                                            $("#estatus_servicio").attr("disabled",false);
                                        } else {
                                            $("#estatus_servicio").prop("disabled",true);
                                            $("#btnUpdateEvento").attr("disabled",true);
                                        }

                                    }  else {
                                        
                                    } */
                                   
                                    $("#folio_telecarga").val(element.folio_telecarga);
                                    $("#tpvInDataModelo").val(element.tvpInModelo);
                                    $("#tpvInDataConnect").val(element.tvpInConectividad);
                                    $("#tpvReDataModelo").val(element.tvpReModelo);
                                    $("#tpvReDataConnect").val(element.tvpReConectividad);
                                    $("#simInData").val(element.simInCarrier);
                                    $("#simReData").val(element.simReCarrier);

                                    var faltaserie = element.faltaserie === null ? 0 : element.faltaserie;
                                    var faltaevidencia = element.faltaevidencia === null ? 0 : element.faltaevidencia;
                                    var faltainformacion = element.faltainformacion === null ? 0 : element.faltainformacion;
                                    var faltaubicacion = element.faltaubicacion === null ? 0 : element.faltaubicacion;
                                    $("#faltaSerie").prop('checked',faltaserie == 0 ? false : true);
                                    $("#faltaEvidencia").prop('checked',faltaevidencia == 0 ? false : true);
                                    $("#faltaInformacion").prop('checked',faltainformacion == 0 ? false : true);
                                    $("#faltaUbicacion").prop('checked',faltaubicacion == 0 ? false : true);

                                    if(element.servicio == '15') {
                                        $("#labelAfiliacion").html('Folio');
                                        $("#col_tipocredito").show();
                                        $("#col_serviciofinal").hide();
                                    } else {
                                        $("#labelAfiliacion").html('Afiliacion');
                                        $("#col_tipocredito").hide();
                                        $("#col_serviciofinal").show();
                                    }
                                    /*
                                    if(element.tecnico =='0') {
                                        $("#btnReasignarTecnico").hide();
                                    } else {
                                        $("#btnReasignarTecnico").show();
                                    }

                                    if(element.estatus == '3' || element.estatus == '1' ) {
                                        $("#btnReasignarTecnico").hide();
                                    } else {
                                        $("#btnReasignarTecnico").show();
                                    } */
                                    
									$("#divBtnCV").show();
									$("#comentarios_valid").show();
                                    //getScriptEvento(element.servicio,element.tpv_instalado)
                                    //INTENTAR VALIDACIÓN AQUÍ
									
									if(element.estatus_servicio == '13')
									{
										$("#divBtnCV").show();
										$("#comentarios_valid").show();
										
									} else if (element.estatus_servicio == '14')
									{
										
									}else if (element.estatus_servicio == '15')
									{
										$("#divBtnCV").show();
										$("#comentarios_valid").show();
									}
                            })  
                        }         
                    },
                    error: function(error){
                        var demo = error;
                        alert(error)
                    }
                });
           
        })

        $("#estatus_servicio").on("change",function() {    
            var servicio = $("#servicioId").val();
            var noserie = $("#tpv").val();
            var modelo = $("#tpvInDataModelo").val();
            var conectividad = $("#tpvInDataConnect").val();

 

                if( $(this).val() == '1' || $(this).val() == '16' || $(this).val() == '0' ) {
                    $("#rowCancelado").hide();
                    $("#rowRechazos").hide();
                    $("#rowSubRechazos").hide();
                    $("#comentarios_cierre").val('');
                } else {

                   

                    if($(this).val() == '14' ) {
                        $("#btnUpdateEvento").attr('disabled',false);
                        //$("#btnUpdateEvento").attr('disabled',false);
                        //$("#divBtnCV").show();
                        $("#rowCancelado").show();
                        $("#rowRechazos").hide();
                        $("#rowSubRechazos").hide();
                        $("#comentarios_cierre").val('');

                    } else if($(this).val() == '15') { 
                        $("#btnUpdateEvento").attr('disabled',false);
                        //$("#btnComentValid").attr('disabled',false);
                        //$("#divBtnCV").show();
                        $("#rowCancelado").hide();
                        $("#rowRechazos").show();
                        $("#rowSubRechazos").show();
                        $("#comentarios_cierre").val('');
                        
                    } else if($(this).val() == '13') { 
                        $("#btnUpdateEvento").attr('disabled',false);
                        $("#rowCancelado").hide();
                        $("#rowRechazos").hide();
                        $("#rowSubRechazos").hide();
                        getScriptEvento(servicio,noserie,conectividad,modelo);
                        
                    } else {
                        $("#rowCancelado").hide();
                        $("#rowRechazos").hide();
                        $("#rowSubRechazos").hide();
                        $("#comentarios_cierre").val('');
                        //$("#btnUpdateEvento").attr('disabled',true);
                    }
                }
            
        })

        $("#btnComentValid").on('click', function() {
		  
		 
		  
            if( $('#comentarios_validacion').val().length > 0  )
			{
				var dn = { module : 'guardarComVal', comentario:$('#comentarios_validacion').val(), odt:$('#odt').val()};
			console.log(dn);
			$.ajax({ 
					type: 'POST',
					url : 'modelos/eventos_db.php',
					data: dn,
					cache: false,
					success: function(data){
						
					
					  $.toaster({
                            message: data,
                            title: 'Aviso',
                            priority : 'success'
                        }); 
						cleartext();
					},
					error: function(error){
						var demo = error;
					}
				});
				
			}else{
				$.toaster({
				message: 'Ingresa el comentario de validacion',
				title: 'Aviso',
				priority : 'danger'
                      });}
	
		
        })
        $("#btnReasignarTecnico").on("click",function() {
            $("#showReasignar").modal("show");
            getTecnicos(0)
        })

        $("#btnSubmitReasignar").on("click", function() {
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=assignarTecnico&tecnico='+$("#reasignartecnico").val()+"&odtid="+$("#odt").val(),
                cache: false,
                success: function(data){    
                       $("#tecnicoid").val(data);
                        $.toaster({
                            message: 'Se Reasigno el Tecnico',
                            title: 'Aviso',
                            priority : 'success'
                        });   
                    
					$("#tecnico").val( $("#reasignartecnico option:selected").text() );
                    $("#showReasignar").modal("hide");
                    $("#reasignartecnico").val('0');
                    //$('#showEvento').modal("hide");
                         
                },
                error: function(error){
                    var demo = error;
                }
            });
        })

        $("#btnChgODT").on("click", function() {
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=cambiarODT&oldODT='+$("#old_odt").val()+"&newODT="+$("#new_odt").val()+"&odtid="+$("#odt").val(),
                cache: false,
                success: function(data){    
                       
                        $.toaster({
                            message: 'Se Cambio la ODT '+$("#old_odt").val()+' por '+$("#new_odt").val(),
                            title: 'Aviso',
                            priority : 'success'
                        });   
                        
                    $("#chgODT").modal("hide");
                    $("#old_odt").val('');
                    $("#new_odt").val('');
                         
                },
                error: function(error){
                    var demo = error;
                }
            });
        })
        

        $('#showEvento').on('hide.bs.modal', function (e) {
           
                cleartext()
        });

        $("btnNuevoEvento").on("click", function() {
            $("#newEvento").modal("show");
        })

        $('#newEvento').on('show.bs.modal', function (e) {

        })

        $('#newEvento').on('hide.bs.modal', function (e) {

        })

        $(document).on("click","#btnUbicacion", function() {
            $("#showUbicacion").modal({show: true, backdrop: false, keyboard: false})
        })

        $('#showUbicacion').on('show.bs.modal', function (e) {
           // initMap()
           var latitud = $("#latitud").val().length > 0 ? parseFloat($("#latitud").val()) : 0;
           var longitud = $("#longitud").val().length > 0 ? parseFloat($("#longitud").val()) : 0;
           var cliente = {lat: latitud, lng: longitud};

           var map = new google.maps.Map(document.getElementById('mapa'), {
                center: cliente,
                zoom: 15
            });

            var marker = new google.maps.Marker({position: cliente, map: map});
            $("#ubicacionData").html("Ubicacion: "+latitud+" "+longitud+" Fecha Atencion: "+$("#fecha_atencion").val() );

 
        });

        $('#showUbicacion').on('hide.bs.modal', function (e) {
           
        });

        $(document).on("click","#btnImagenes", function() {
            //$("#showImagenes").modal({show: true, backdrop: false, keyboard: false});
			 var windowname = $("#odt").val();
            window.open("galeria_img.php?odt="+$("#odt").val() , windowname, "resizable=no, toolbar=no, scrollbars=no, menubar=no, status=no, directories=no ");
			
        })

        $('#showImagenes').on('show.bs.modal', function (e) {
           // mostrarImagenes( $("#odt").val() )

        })


        $(document).on('click','.btnDelImage', function() {
            var idImg = $(this).attr('data');
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: { module: 'imgDelete',idImg: idImg },
                cache: false,
                success: function(data){
                    if(data == "1") {
                        $.toaster({
                            message: 'Se borro con exito la imagen ',
                            title: 'Aviso',
                            priority : 'success'
                        });  
                        mostrarImagenes($("#odt").val())
                    }
                }
            });
        })

        $('#showImagenes').on('hide.bs.modal', function (e) {
           // $("#imagenSel").html("");
           // $("#carruselFotos").html("")
			 
        });
		
		$(document).on("click","#btnDocumentos", function() {
            $("#showDocumentos").modal({show: true, backdrop: false, keyboard: false});
        })

        $('#showDocumentos').on('show.bs.modal', function (e) {
           
            showDocumentos();

            
       
        })
		

		
		$('#showDocumentos').on('hide.bs.modal', function (e) {
            $("#imagenSel").html("");
            $("#carruselFotos").html("")
        });
		
		$("#btnUpdateEvento").on("click",function() {
            var validar = 0;
            var msg = '';

			var eventoId = $("#eventoId").val();
			var odt = $("#odt").val();
			var comentario = $("#comentarios_cierre").val();
			var estatus = $("#estatus_servicio").val();
            var foliotelecarga = $("#folio_telecarga").val();
            var version = $("#version").val();
            var aplicativo = $("#aplicativo").val();
            var receptorservicio = $("#receptor_servicio").val();
            var tecnico = 	$("#tecnicoid").val();
			
			//ODT checkbox
			var odtGetNet = $("#odtGetNet").is(":checked") ? 1 : 0;
			var odtNotificado = $("#odtNotificado").is(":checked") ? 1 : 0;
			var odtDescarga = $("#odtDescarga").is(":checked") ? 1 : 0;
			
			//TPV Retirado
			var tvpRetBateria = $("#tvpRetBateria").is(":checked") ? 1 : 0;
			var tvpRetEliminador = $("#tvpRetEliminador").is(":checked") ? 1 : 0;
			var tvpRetTapa = $("#tvpRetTapa").is(":checked") ? 1 : 0;
			var tvpRetCable = $("#tvpRetCable").is(":checked") ? 1 : 0;
			var tvpRetBase = $("#tvpRetBase").is(":checked") ? 1 : 0;
			
			// Rechazo
			var rechazo = $("#rechazo").is(":checked") ? 1 : 0;
			var subrechazo = $("#subrechazo").is(":checked") ? 1 : 0;
			var cancelado = $("#cancelado").is(":checked") ? 1 : 0;
			
			//DTOS ACtulizables
            var tpv = $("#tpv").val();
            var tvpInModelo = $("#tpvInDataModelo").val();
            var tpvInConnect = $("#tpvInDataConnect").val();
            var tpv_retirado = 	$("#tpv_retirado").val();
            var tvpReModelo = $("#tpvReDataModelo").val();
            var tpvReConnect = $("#tpvReDataConnect").val();
			var idcaja = 	$("#idcaja").val();
			var afiliacion_amex = 	$("#afiliacion_amex").val();
			var idamex = 	$("#idamex").val();
            var sim_instalado = 	$("#sim_instalado").val();
            var simInData = $("#simInData").val();
            var sim_retirado = 	$("#sim_retirado").val();
            var simReData = $("#simReData").val();
            var producto = 	$("#producto").val();

            //Rollos
            var rollosInstalar = $("#rollos_instalar").val();
            var rollosInstalados = $("#rollos_entregados").val();
            
            //Validar si es obligatorio la TVP INStalada
            if( PermisosEvento.tvp_instalada == '1') {
                
                if(tpv.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una terminal instalada al Evento \n ";
                }

            }

            //Validar si es obligatorio la TVP Retirada
            if( PermisosEvento.tpv_salida == '1') {
                
                if(tpv_retirado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una terminal retirada al Evento \n ";
                }

            }

            //Validar si es obligatorio la SIM Retirada
            if( PermisosEvento.sim_retirado == '1') {
                
                if(sim_retirado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una sim retirada al Evento \n ";
                }

            }

            //Validar si es obligatorio la SIM Instalado
            if( PermisosEvento.sim_instalado == '1') {
                
                if(sim_instalado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una sim instalada al Evento \n ";
                }

            }

            //Validar Rollos 
            if( PermisosEvento.rollos == '1') {

                if( rollosInstalar != rollosInstalados ) {
                    validar++;
                    msg += "La cant de rollos no coincide \n ";
                }
            }
			
            if(tecnico == 0 ) {
                validar++;
                msg += "Necesitas asignar un tecnico al Evento \n ";
            }

            if(comentario.length <= 200) {
                validar++;
                msg += "Se necesita mas información en las observaciones (minimo 200 caracteres) \n ";
            }

			if(validar == 0 ) {
				var dnd = { module: 'cerrarEvento',eventoId : eventoId, odt : odt,comentario: comentario,estatus:estatus,foliotelecarga:foliotelecarga, odtGetNet : odtGetNet, odtNotificado : odtNotificado,
							odtDescarga: odtDescarga, tvpRetBateria: tvpRetBateria, tvpRetEliminador: tvpRetEliminador, tvpRetTapa: tvpRetTapa, tvpRetCable: tvpRetCable, tvpRetBase: tvpRetBase,
							rechazo: rechazo, subrechazo: subrechazo,cancelado: cancelado,tpv:tpv,tpvRetirado : tpv_retirado,idCaja: idcaja,afiliacionAmex:afiliacion_amex ,idamex:idamex,
                            simInstalado:sim_instalado, simRetirado: sim_retirado,producto: producto,version: version,aplicativo:aplicativo,receptorservicio:receptorservicio, 
                            tvpInModelo:tvpInModelo,tpvInConnect:tpvInConnect ,tvpReModelo, tvpReModelo, tpvReConnect: tpvReConnect, simInData:simInData, simReData:simReData,tecnico:tecnico, 
                            rollosInstalar:rollosInstalar, rollosInstalados:rollosInstalados };
				
				 $.ajax({
					type: 'POST',
					url: 'modelos/eventos_db.php', // call your php file
					data: dnd,
					cache: false,
					success: function(data){    
							$('#eventos').DataTable().ajax.reload();
							$.toaster({
								message: 'Evento Cerrado',
								title: 'Aviso',
								priority : 'success'
							});   
							
							 $('#showEvento').modal("hide");
							 
					},
					error: function(error){
						var demo = error;
					}
				});
			} else {
				$.toaster({
					message: msg,
					title: 'Aviso',
					priority : 'danger'
				});   
			}
        });
        
        $("#tpv").on("change",function() {
            var tpv = $(this).val();
            if(tpv.length > 0) {
                result = validarTPV(tpv,1,'in')
                
            }
        })

        $("#tpv_retirado").on("change",function() {
            var tpv = $(this).val();
            if(tpv.length > 0) {
                validarTPV(tpv,1,'out')
                
            }
           
        })

        $("#sim_instalado").on("change",function() {
            var tpv = $(this).val();
            if(tpv.length > 0) {
                validarTPV(tpv,2,'in')
                 
            }
        })

        $("#sim_retirado").on("change", function() {
            var tpv = $(this).val();  
            var result;
            if(tpv.length > 0) {
                validarTPV(tpv,2,'out')
                
            }
        })

        
        
    } );

    function getModeloConectividad(tpv,tipo,donde) {

        $.ajax({
            type: 'GET',
            url: 'modelos/eventos_db.php', // call your php file
            data: 'module=getModeloConectividad&noserie='+tpv+"&tipo="+tipo,
            cache: false,
            success: function(data){
                var tpvDatos = JSON.parse(data);
                switch (tipo) {
                    case 1:
                        $("#tpvInDataModelo").val('0');
                        $("#tpvInDataConnect").val('0');
                        $("#tpvReDataModelo").val('0');
                        $("#tpvReDataConnect").val('0');
                        if(donde = 'in') {
                            $("#tpvInDataModelo").val();
                            $("#tpvInDataConnect").html(tpvDatos.dato);
                        } else if(donde = 'out') {
                            $("#tpvReDataModelo").html(tpvDatos.modelo);
                            $("#tpvReDataConnect").html(tpvDatos.connect);
                        }
                    break;
                    case 2 :
                        $("#simInData").val('0');
                        if(donde = 'in') {
                            $("#simInData").val(tpvDatos.modelo);
                        } else if(donde == 'out') {
                            $("#simReData").val(tpvDatos.modelo);
                        }
                    break;
                }

                
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function camposObligatorios(servicio) {

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=getCamposObligatorios&servicioid='+servicio,
                cache: false,
                dataType: "json",
                success: function(data) {
                    resolve(data)
                },
                error: function(error){
                    reject(error)
                }
            })  

        }) 

        
    }

    function validarTPV(tpv,tipo,donde) {
            result = 0;

            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=validarTPV&noserie='+tpv+"&tipo="+tipo,
                cache: false,
                success: function(data){
                    if(data != 'false' ) {
                        result = 1;    
                        var info = JSON.parse(data);
                        var modelo = info.modelo == null ? 0 : info.modelo;
                        var conectividad = info.conectividad == null ? 0 : info.conectividad;
                        if(tipo == 1) {
                            if(donde == 'in') {
                                $("#tpvInDataModelo").val(modelo);
                                $("#tpvInDataConnect").val(conectividad);
                            } else {
                                $("#tpvReDataModelo").val(modelo);
                                $("#tpvReDataConnect").val(conectividad);
                            }

                        } else if (tipo == 2) {
                            if(donde == 'in') {
                                $("#simInData").val(modelo)
                            } else {
                                $("#simReData").val(modelo)
                            }
                        }

                    } else {
                        tpv.val('');  
                        $.toaster({
                            message: 'La serie no es valida',
                            title: 'Aviso',
                            priority : 'danger'
                                  });
                            
                    }
                 
                    
                },
                error: function(error){
                    var demo = error;
                }
            });

            return result;

    }

    
      function initMap() {
         
      }
	  
      function getInfoExtra(odt) {

    

        $.ajax({
            type: 'POST',
            url: 'modelos/eventos_db.php', // call your php file
            data: 'module=getInfoExtra&odt='+odt,
            cache: false,
            dataType: "json",
            success: function(data) {
                var info =  data;

                var odtGetNet = info.getnet == '1' ? true : false;
                var odtNotificado = info.notificado == '1' ? true : false;
                var odtDescarga = info.descarga == '1' ? true : false;
                var tvpRetBateria = info.ret_batalla == '1' ? true : false;
                var tvpRetEliminador = info.ret_eliminador == '1' ? true : false;
                var tvpRetTapa = info.ret_tapa == '1' ? true : false;
                var tvpRetCable = info.ret_cable == '1' ? true : false;
                var tvpRetBase = info.ret_base == '1' ? true : false;

                $("#odtGetNet").prop( "checked", odtGetNet );
                $("#odtNotificado").prop( "checked", odtNotificado );
                $("#odtDescarga").prop( "checked", odtDescarga );

                $("#tvpRetBateria").prop( "checked", tvpRetBateria );
                $("#tvpRetEliminador").prop( "checked", tvpRetEliminador );
                $("#tvpRetTapa").prop( "checked", tvpRetTapa );
                $("#tvpRetCable").prop( "checked", tvpRetCable );
                $("#tvpRetBase").prop( "checked", tvpRetBase );


            },
            error: function(error){
                reject(error)
            }
        })  
    }

	  function tipodeUsuario(tipo) {

          $("#rowCancelado").hide();
          $("#rowRechazos").hide();
          $("#rowSubRechazos").hide();
          $("#btnUpdateEvento").attr('disabled',true);
          
		  if( $("#tipo_user").val() == 'callcenter' || $("#tipo_user").val() == 'admin'  ) {
			$("#rollos_entregados").attr('readonly',false);
			$("#comentarios_cierre").attr('readonly',false);
			//$("#btnUpdateEvento").attr('disabled',false);
            $("#estatus_servicio").attr('disabled',false)
            $("#folio_telecarga").attr('readonly',false)
            $("#producto").attr('disabled',false)
            $("#version").attr('readonly',false)
            $("#aplicativo").attr('readonly',false)
            $("#receptor_servicio").attr('readonly',false);

            $("#odtGetNet").attr('disabled',false)
            $("#odtNotificado").attr('disabled',false)
            $("#odtDescarga").attr('disabled',false)

            $("#tvpRetBateria").attr('disabled',false)
            $("#tvpRetEliminador").attr('disabled',false)
            $("#tvpRetTapa").attr('disabled',false)
            $("#tvpRetCable").attr('disabled',false)
            $("#tvpRetBase").attr('disabled',false)
			
            $("#tpv").attr('readonly',false)
            $("#tpv_retirado").attr('readonly',false)
			$("#idcaja").attr('readonly',false)
			$("#afiliacion_amex").attr('readonly',false)
			$("#idamex").attr('readonly',false)
			$("#sim_instalado").attr('readonly',false)
            $("#sim_retirado").attr('readonly',false)

            //HORAS
            $("#fecha_atencion").attr('readonly',false);
            $("#hora_llegada").attr('readonly',false);
            $("#hora_salida").attr('readonly',false);
            
			
		  } else {
			$("#rollos_entregados").attr('readonly',true);
			$("#comentarios_cierre").attr('readonly',true);
			$("#btnUpdateEvento").attr('disabled',true);
            $("#estatus_servicio").attr('disabled',true)
            $("#folio_telecarga").attr('readonly',true)
            $("#producto").attr('disabled',true)
            $("#version").attr('readonly',true)
            $("#aplicativo").attr('readonly',true)
            $("#receptor_servicio").attr('readonly',true);

            $("#odtGetNet").attr('disabled',true)
            $("#odtNotificado").attr('disabled',true)
            $("#odtDescarga").attr('disabled',true)

            $("#tvpRetBateria").attr('disabled',true)
            $("#tvpRetEliminador").attr('disabled',true)
            $("#tvpRetTapa").attr('disabled',true)
            $("#tvpRetCable").attr('disabled',true)
            $("#tvpRetBase").attr('disabled',true)
			
			$("#tpv").attr('readonly',true)
            $("#tpv_retirado").attr('readonly',true)
			$("#idcaja").attr('readonly',true)
			$("#afiliacion_amex").attr('readonly',true)
			$("#idamex").attr('readonly',true)
			$("#sim_instalado").attr('readonly',true)
			$("#sim_retirado").attr('readonly',true)
            
		  }
	  }

function getScriptEvento(servicio,noserie,conectividad,modelo) {
    var result = '';
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=scriptEvento&servicio_id='+servicio+'&noserie='+noserie+'&conectividad='+conectividad+'&modelo='+modelo,
        cache: false,
        success: function(data){    
            var info = JSON.parse(data);
           
            var script = info.script;
            script = script.replace("#MODELO#",$("#tpvInDataModelo option:selected" ).text() ) 
            script = script.replace("#MODELORETIRO#",$("#tpvReDataModelo option:selected" ).text() )
            script = script.replace("#CONECTIVIDAD#",$("#tpvInDataConnect option:selected" ).text() ) 
            script = script.replace("#CONECTIVIDADRETIRO#",$("#tpvReDataConnect option:selected" ).text() ) 
            script = script.replace("#SERIE#",$("#tpv").val() ) 
            script = script.replace("#SERIERETIRO#",$("#tpv_retirado").val() ) 
            script = script.replace("#PTID#",$("#tpv").val() ) 
            script = script.replace("#SIM#",$("#sim_instalado" ).val() )
            script = script.replace("#SIMRETIRO#",$("#sim_retirado" ).val() )
            script = script.replace("#CARRIER#",$("#simInData option:selected" ).text())
            script = script.replace("#CARRIERRETIRO#",$("#simReData option:selected" ).text()) 
            //data.replace("#CARRIER",$("#tpv").val() ) 
            script = script.replace("#CAJA#",$("#idcaja").val() ) 
            script = script.replace("#FT#",$("#folio_telecarga").val() ) 
            script = script.replace("#AMEX#",$("#tieneamex").val() )
            if($("#tieneamex").val() == 'SI') {
                script = script.replace("#AFAMEX#",$("#afiliacion_amex").val() )
                script = script.replace("#AMEXID#",$("#idamex").val() )
            } else {
                script = script.replace("#AFAMEX#",'' )
                script = script.replace("#AMEXID#",'' )
            }
            script = script.replace("#ROLLOS#",$("#rollos_entregados").val() )
            
            script = script.replace("#FECHAHORA",$("#fecha_atencion").val()+" DE "+$("#hora_llegada").val()+" A "+$("#hora_salida").val() )
            script = script.replace("#APP#",$("#aplicativo option:selected" ).text() ) 
            script = script.replace("#VERSION#",$("#version option:selected" ).text() ) 
            script = script.replace("#RECEPTORSERVICIO#",$("#receptor_servicio").val() )
            script = script.replace("#TELEFONO#", $("#telefono").val() )

            $("#comentarios_cierre").val(script);
                
        },
        error: function(error){
            var demo = error;
        }
    });
}

function mostrarImagenes(odt) {
    $("#carruselFotos").html('')
    $("#btnValidarImagen").data('id','0');
     
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getImagenesODT&odt='+odt,
        cache: false,
        success: function(data){
            var texto = "";
            var info = JSON.parse(data);
            var locacion = window.location;
            if(info['estatus'] == '1') {
                $.each(info['imagenes'], function(index, element) {
                    
                    texto = texto + '<img src="'+locacion.origin+'/'+element.path+'" width="80%" class="zoomImgs"><button class="btn btn-primary button1 btnDelImage" data= "'+element.id+'">Borrar</button></button>'

                })

                $("#carruselFotos").html(texto);
				zoomifyc.init($('#carruselFotos img'));
            } else {
            
                $.toaster({
                    message: 'LA ODT NO TIENE IMAGENES REGISTRADAS',
                    title: 'Aviso',
                    priority : 'danger'
                });      
            }
                    
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function fnShowHide( colId,status )
{
    var table = $('#eventos').DataTable();
    table.column( colId ).visible( status ); 
}
      	  
function showDocumentos() {
	$("#carruselDocs").html('');
	$.ajax({
		type: 'GET',
		url: 'modelos/eventos_db.php', // call your php file
		data: 'module=getDocumentosODT&odt='+$("#odt").val(),
		cache: false,
		success: function(data){
			var texto = "";
			var info = JSON.parse(data);
			if(info['estatus'] == '1') {
				$.each(info['imagenes'], function(index, element) {

					texto = texto + '<div><a href="'+element.path+'"  data="'+element.path+'">'+element.imagen+'</a></div> '

				})

				$("#carruselDocs").html(texto);
			} else {
               
                $.toaster({
                    message: 'LA ODT NO TIENE DOCUMENTOS REGISTRADOS',
                    title: 'Aviso',
                    priority : 'danger'
                });    
			}
				 
		},
		error: function(error){
			var demo = error;
		}
	});

	
}

function getTecnicos(id) {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTecnicos',
        cache: true,
        success: function(data){
            console.log(data);
        
        $("#reasignartecnico").html(data);
		$("#reasignartecnico").val(id);		
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicosf(id) {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTecnicosFiltro',
        cache: true,
        success: function(data){
            console.log(data);
        
        $("#tecnicoF").html(data);
		$("#tecnicoF").val(id);		
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
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#estatus_servicio").html(data);
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getCancelado() {
	
	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEstatusCancelado',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#cancelado").html(data);
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
	

}

function getRechazos() {
	
	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEstatusRechazo',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#rechazo").html(data);
		 	
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
        data: 'module=getEstatusSubRechazo',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#subrechazo").html(data);
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
	

}

function getProductos() {
	
	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getProductos',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#producto").html(data);
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
	

}

function subirFotos(odt,file) {
	//var odt = $("#odt").val();
	var file_data = file; //$("#fileToUpload")[0].files[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('name',odt);
	form_data.append('module','saveDoc');

	$.ajax({
		type: 'POST',
		url: 'modelos/eventos_db.php', // call your php file
		data: form_data,
		processData: false,
		contentType: false,
		success: function(data, textStatus, jqXHR){
			//$("#avisos").html(data);
			$.toaster({
				message: data,
				title: 'Aviso',
				priority : 'warning'
			});  
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(data)
	   }
	 });
}

function getTipoServicio() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=gettiposervicio',
        cache: false,
        success: function(data){
        $("#tipo_servicio").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTipoSubServicio() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=gettiposubservicio',
        cache: false,
        success: function(data){
        $("#tipo_subservicio").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTipoEvento() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=gettipoevento',
        cache: false,
        success: function(data){
        $("#tipo_evento").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTerritoriosFilter(){
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTerritoriales',
        cache: false,
        success: function(data){
            $("#territorialF").html(data);
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getEstatusEvento() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getestatusevento',
        cache: false,
        success: function(data){
        $("#estatus_busqueda").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getVersion() {

	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getVersion',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#version").html(data);
		 
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getBancosf() {

	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getBancos',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#bancoF").html(data);
		 
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getAplicativo() {

	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getAplicativo',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#aplicativo").html(data);
		 
		 	
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
        data: 'module=getListaModelos',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#tpvInDataModelo").html(data);
         $("#tpvReDataModelo").html(data);
		 
		 	
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
        data: 'module=getListaConectividad',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#tpvInDataConnect").html(data);
         $("#tpvReDataConnect").html(data);
		 
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getCarrier() {

	$.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getListaCarrier',
        cache: true,
        success: function(data){
            console.log(data);
        
         $("#simInData").html(data);
         $("#simReData").html(data);
		 
		 	
        },
        error: function(error){
            var demo = error;
        }
    });
}

function cleartext() {
    $("#odt").val("")
    $("#afiliacion").val("")
    $("#tipo_servicio").val("");
    $("#tipo_subservicio").val("");
    $("#fecha_alta").val("");
    $("#fecha_vencimiento").val("")
    $("#fecha_cierre").val("");
    $("#comercio").val("")
    $("#receptor_servicio").val("");
    $("#fecha_atencion").val("");
    $("#colonia").val("")
    $("#ciudad").val("")
    $("#estado").val("")
    $("#direccion").val("")
    $("#telefono").val("")
    $("#descripcion").val("");
    $("#hora_atencion").val("")
    $("#hora_llegada").val("")
    $("#hora_salida").val("")
    $("#tecnico").val("")
    $("#estatus").val("")
    $("#servicio").val("")
    $("#comentarios_tecnico").val("")
    $("#servicio_final").val("")
    $("#comentarios_cierre").val("")
    $("#fecha_asignacion").val("");
    $("#hora_comida").val("");
    $("#latitud").val("" );
    $("#longitud").val("");

    $("#tipo_credito").val("");
    $("#afiliacion_amex").val("");
    $("#idamex").val("");
    $("#idcaja").val("");
    $("#tpv").val("");
    $("#tpv_retirado").val(""); 
    $("#version").val("");
    $("#aplicativo").val("");
    $("#producto").val("");
    $("#rollos_instalar").val("");
    $("#rollos_entregados").val("");
    $("#sim_instalado").val("");
    $("#sim_retirado").val("");
    $("#estatus_servicio").val("");
    $("#folio_telecarga").val("");

 

}

