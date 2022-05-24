var infoAjax = 0;
var tableInventario;
var usrPerm;
var fecha_hoy;
var tblEventosHist,tblInventarioHist,eventos,inventarios;                                                        
$(document).ready(function() {
    usrPerm = $("#userPerm").val();
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "almacenlink");
    getProcesosActivos();
    getModelos();
    getAplicativo();
    getConectividad();
    getUbicacion();
    getEstatus();
    getEstatusUbicacion();
    getCarriers();
    getBancos();
    getTecnicosxAlmacen();
    campos_tipo();

    $("#fechaVen_inicio").datetimepicker({
        format:'Y-m-d'
    });

    $("#fechaVen_fin").datetimepicker({
        format:'Y-m-d'
    });

    $(".searchInventario").on('change',function() {
        tableInventario.ajax.reload();
    })
   fecha_hoy =  moment().format('YYYY-MM-DD');
   //Inhabilitar entrada


//Tabla principal de la página
    tableInventario = $('#inventario').DataTable({
        "responsive" : true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "ASC" ]],        
        dom: 'lfrtiBp',
        buttons: [{
            extend: 'excel',
            title: 'Almacen_'+fecha_hoy,
            exportOptions: {
                orthogonal: 'sort',
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            },
            customizeData: function ( data ) {
                for (var i=0; i<data.body.length; i++){
                    for (var j=0; j<data.body[i].length; j++ )
                    {
                        data.body[i][j] = '\u200C' + data.body[i][j];
                    }
                }
            }               
            }],
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getTable',
                d.tipo_ubicacion = $("#tipo_ubicacion").val(),
                d.tipo_estatus = $("#tipo_estatus").val(),
                 d.tipo_estatusubicacion = $("#tipo_estatusubicacion").val(),
                d.tipo_producto = $("#tipo_producto").val(),
                d.tipo_modelo = $("#tipo_modelo").val(),
                d.tipo_conect = $("#tipo_conect").val(),
                d.tipo_carrier = $("#tipo_carrier").val(),
                d.banco = $("#banco").val()
            }
        },
        columns : [
            { data: 'banco'},
            { data: 'tipoNombre'},
            { data: 'no_serie',
                "render" : function (data, type, row, meta)
                {
                    var id;
                    
                    if(row.tipo == '1') 
                    {
                        id = data;
                    } 
                    else if (row.tipo == '2') 
                    {
                        id = data;
                    } 
                    else 
                    {
                        id = row.id;
                    }
                    if (type === 'display') 
                    {
                        data = '<a href="#" class="mostrarHistoria" title="Ver Historia" style="color:#187CD0;font-weight:bold;" data="'+id+' ">'+data+'</a>'
                    }

                    return data;
                }
                

            },
            { data: 'modelo' },
            { data: 'aplicativ'},
            { data: 'conect'},
            { data: 'estatus' },
            { data: 'estatus_inventario' },
            { data: 'ubicacion' },
            { data: 'fecha_edicion' },
            { data: 'cantidad' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [ 1 ],
                "width": "8%",
            },
            {
                "targets": [ 2 ],
                "width": "15%",
            },
            {
                "targets": [ 5 ],
                "width": "10%",
            },
            {
                "targets": [ 8 ],
                "width": "10%",
            },
            {
                "targets": [10],
                "width" : "8%",
            },
            {
                "targets": [11],
                "mRender": function ( data,type, row ) 
                {
                    var id;
                    var buttons = '';
                    
                    if(row.tipo == '1') 
                    {
                        id = row.no_serie;
                    } 
                    else if (row.tipo == '2') 
                    {
                        id = row.no_serie;
                    } 
                    else 
                    {
                        id = row.id;
                    }
                    
                    
                    
                    if(usrPerm == 'admin' || usrPerm == 'CA' || usrPerm == 'AN' || usrPerm == 'LA' ) {
                         buttons += ' <a href="#" title="Editar Serie"class="mostrarDetalle" data="'+id+' "><i class="fas fa-edit fa-2x " style="color:#187CD0"></i></a>';
                         //buttons += '<a href="#" class="btn btn-success mostrarHistoria" data="'+id+' ">Historia</a>';
                    } 

                    
                    return buttons;
                }
            }
        ],
        rowCallback: function( row, data, index,full){
           
             fnShowHide( 9,true )
                 var fechamodificacion = moment(data.fecha_edicion)
                 var now = moment();
                 var diff = moment.duration(fechamodificacion.diff(now));
                 var col = this.api().column(9).index('visible');

                 if(now.diff(fechamodificacion, 'days') >= 30  ) 
                 {
                 
                    $('td', row).eq(col).css('color', '#000');
                    $('td', row).eq(col).css('background-color', '#ae2b2b');
                 } else if(now.diff(fechamodificacion, 'days') >= 15) 
                 {
                    //$('td', row).eq(col).css('color', '#000');
                    $('td', row).eq(col).css('background-color', '#FFFF00');
                 }else{
                     $('td', row).eq(col).css('background-color', '#00CC66');
                 }

                 if(data.estatus == 'INSTALADO')
                 {
                    $('td', row).eq(col).css('background-color', '#fff');
                 }

         }
    });

    tblEventosHist = $("#table_eventos").DataTable({                             
        language: {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
     
        },
        searching: false,
        paging: false,
        info: false,
        scrollY: "200px",
        scrollCollapse: true,
        "columns": [
            { "data": "odt" },
            { "data": "ultima_mod" },
            { "data": "afiliacion" },
            { "data": "tpv_instalado" },
            { "data": "tpv_retirado" },
            { "data": "servicio" },
            { "data": "tecnico" },
            { "data": "modificado_por" }
            ]
    });

    tblInventarioHist = $("#table_inventario").DataTable({                  
        language: {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        searching: false,
        paging: false,
        info: false,
        serverSide: true,
        scrollY: "200px",
        scrollCollapse: true,
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getHistoria',
                d.noSerie = $("#noSerie").val()
            }
        },
        columns : [
            { data: 'fecha_movimiento'},
            { data: 'tipo_movimiento'},
            { data: 'ubicacionStatus'},
            { data: 'cantidad'},
            { data: 'modificadoPor' },
            { data: 'id_ubicacion'}
        ],
        fixedColumns: true
    });
    
    $("#btnProcesosActivos").on('click', function() {
        window.location.href = "p_cargasinventarioact.php";
    })

    $("#btnEntradaAlmacen").on("click",function() {

        var noserie = $("#txtNoSerieEntrada").val();

        if(noserie === "" ) {

            $.toaster({
                message: 'Favor de Poner un numero de serie',
                title: 'Aviso',
                priority : 'danger'
            }); 

        } else { 

            $.ajax({
                type: 'GET',
                url: 'modelos/almacen_db.php', // call your php file
                data: 'module=returnInvItem&noserie='+noserie,
                cache: false,
                success: function(data){
                    tableInventario.ajax.reload();
                    var info =  JSON.parse(data);

                    $.toaster({
                        message: info.texto,
                        title: 'Aviso',
                        priority : 'success'
                    }); 
                    
                },
                error: function(error){
                    var demo = error;
                }
            });
        }


        
    });

    $(document).on("click",".mostrarHistoria", function() {
            
        $("#table_serieinfo  tbody").empty();
        var index = $(this).parent().parent().index() ;
        var data = tableInventario.row( index ).data()
        console.log(index)
        console.log(data)
        getTecnicos();
        $("#noSerie").val(data.no_serie);

        var serie = $("#noSerie").val().toUpperCase();
            
            
        if(serie.length > 0 ) 
        {
                
            tblInventarioHist.ajax.reload();

            $.ajax({
                type: 'GET',
                url: 'modelos/almacen_db.php',
                data: 'module=getSerieH&serie='+serie,
                cahe: false,
                success: function(data)
                {
                
                    tblEventosHist
                        .clear()
                        .draw(); 

                    var info = JSON.parse(data);
                    
                    var infoSerie = info.inventario;
                    
                    $("#table_serieinfo").append('<tr><td>'+infoSerie.no_serie+'</td><td>'+infoSerie.modelo+'</td><td>'+infoSerie.conectividad+'</td><td>'+infoSerie.anaquel+'</td><td>'+infoSerie.caja+'</td><td>'+infoSerie.tarima+'</td><td>'+infoSerie.cve_banco+'</td></tr>');

                    tblEventosHist.rows.add(info.eventos)
                        .draw();
                    
                    $('#table_eventos').css("display","");
                   

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                } 
            });

            $('#showHistoria').modal("show");
        
        } else {
            $.toaster({
                message: 'Favor de capturar la serie',
                title: 'Aviso',
                priority : 'warning'
            });  
        }
       
    })
    
    $(document).on("click",".mostrarDetalle", function() {
         
        var index = $(this).parent().parent().index() ;
        var data = tableInventario.row( index ).data()
        console.log(data);
        //Numero de serie
        $("#det-noserie").val(data.no_serie);
        $("#tipo_prod").val(data.tipo);

        //Banco
        $("#det-banco option").filter(function(){
            return $(this).text() == data.banco;
        }).prop('selected', true);


        if(data.tipo == 1) {
            $("#divModelo").show();
            $("#divCarrier").hide();
            
            $("#det-modelo option").filter(function() {
            return $(this).text() == data.modelo;
            }).prop('selected', true);

            $("#divAplicativo").show();

            $("#det-aplicativo option").filter(function() {
                return $(this).text() == data.aplicativ;
                }).prop('selected', true);
         
        } else if(data.tipo == 2 ) {
            $("#divModelo").hide();
            $("#divAplicativo").hide();
            $("#divCarrier").show();
        
            
            $("#det-carrier option").filter(function() {
            return $(this).text() == data.modelo;
            }).prop('selected', true);
        }
        if(data.ubicacionId == 9 || data.estatus_inventario == 3)
        {
            $("#divTecnico").show();
        }
        else
        {
            $("#divTecnico").hide()
        }

        if(data.ubicacionId == 2 || data.estatus_inventario == 4)
        {
            $("#divComercio").show();
            $("#divAfiliacion").hide();
        }
        else
        {
            $("#divComercio").hide();
            $("#divAfiliacion").hide();
        }
        
        //Conectividad
        $("#det-conectividad option").filter(function() {
            return $(this).text() == data.conect;
          }).prop("selected", "selected");

        //Estatus
        $("#det-estatus option").filter(function() {
          return $(this).text() == data.estatus;
        }).prop('selected', true);
        
        //Estatus Inventario
        $("#det-estatus-inventario option").filter(function() {
          return $(this).text() == data.estatus_inventario;
        }).prop('selected', true);
        //tecnico
        $("#det-tecnico option").filter(function() {
            return $(this).text() == data.tecnco;
          }).prop('selected', true);
        
          //comercio
        $("#det-comercio").val(data.comercio);
        //Ubicación
        /*$("#det-ubicacion option").filter(function() {
          return $(this).text() == data.ubicacion;
        }).prop('selected', true); */
        $("#det-ubicacion").val(data.ubicacionId);
        
        
        //Cantidad
        $("#det-qty").val(data.cantidad);

        if(data.tipo == '3') {
            $("#det-qty").attr('readonly',false);
        } else {
            $("#det-qty").attr('readonly',true);
        }
       
        $("#ubicacion_id").val(data.id_ubicacion);

        $("#showDetalle").modal("show");
    })
    
    $('#showDetalle').on('hide.bs.modal', function () {
         cleartext();

    });

    $("#det-afiliacion").autocomplete({
        
        source: function( request, response){
            $.ajax({
                url: "modelos/almacen_db.php",
                type:"GET",
                dataType: "json",
                data: {
                    term: request.term,
                    module: 'buscarAfiliacion'
                },
                success: function( data ){
                    //cleartext();
                    response( $.map( data, function( item ){
                        return {
                            label: item.datos,
                            value: item.afiliacion,
                            data : item
                        }
                    }));
                },
                error: function(error) {
                    var demo = error;
                    
                }
            });
        }
        
    });
    
    $("#btnCambiarInv").on("click",function() {
        
        var noserie =           $("#det-noserie").val();
        var banco =             $("#det-banco").val();
        var modelo =            $("#det-modelo").val() == '0' ? $("#det-carrier").val() : $("#det-modelo").val();
        var tipo =              $("#tipo_prod").val();
        var aplicativo =        $("#det-aplicativo").val();
        var conectividad =      $("#det-conectividad").val();
        var estatus =           $("#det-estatus").val();
        var estatusinventario = $("#det-estatus-inventario").val();
        var ubicacion =         $("#det-ubicacion").val();
        var tecnico =           $("#det-tecnico").val();
        var comercio =          $("#det-comercio").val();
        var cantidad =          $("#det-qty").val();
        var afiliacion =        $("#det-afiliacion").val();
        var id_ubicacion =       $("#ubicacion_id").val();
        
        //Validar Ubicacion y Estatus
        valido = 0;
        var msg = '';
        
        if( estatusinventario == '1' ) {

            if(ubicacion == '1' || ubicacion == '7' || ubicacion == '8' || ubicacion == '10' || ubicacion == '11' || ubicacion == '14' || ubicacion == '13' || ubicacion == '15'  )
            {
                valido++;
            } else {
                msg += "La Ubicacion no coincide con el Estatus de Inventario EN ALMACEN";
            }
        } else if ( estatusinventario == '2') {

            if(ubicacion == '9' || ubicacion == '12' )
            {
                valido++;
            } else {
                msg += "La Ubicacion no coincide con el Estatus de Inventario EN TRANSITO";
            }
        } else if ( estatusinventario == '3') {

            if(ubicacion == '9' || ubicacion == '12' )
            {
                valido++;
            } else {
                msg += "La Ubicacion no coincide con el Estatus de Inventario EN PLAZA";
            }
        }  else if ( estatusinventario == '4') {

            if(ubicacion == '2'  )
            {
                valido++;
            } else {
                msg += "La Ubicacion no coincide con el Estatus de Inventario EN COMERCIO";
            }
		} else if (estatusinventario == '5') {
			
			if(ubicacion == '14')
			{
				valido++;
			} else {
				msg += "La Ubicacion no coincide con el estatus de Inventario EN LABORATORIO";
			}
        };
        
        if (valido > 0) {
            $.ajax({
                type: 'GET',
                url: 'modelos/almacen_db.php', // call your php file'
                data: 'module=updateInvProd&noserie='+noserie+'&banco='+banco+'&tipo='+tipo+'&modelo='+modelo+'&aplicativo='+aplicativo+'&conectividad='+conectividad+'&estatus='+estatus+'&ubicacion='+ubicacion+'&estatusinventario='+estatusinventario+'&tecnico='+tecnico+'&comercio='+comercio+'&afiliacion='+afiliacion+'&cantidad='+cantidad+'&id_ubicacion='+id_ubicacion,
                cache: false,
                success: function(data)
                {
                     tableInventario.ajax.reload();
                     $("#showDetalle").modal("hide");
                     
                     $.toaster({
                        message: data,
                        title: 'Aviso',
                        priority : 'info'
                    });  
                     
                     cleartext();
                },
                error: function(error){
                    var demo = error;
                    cleartext();
                }
            });
        } else {
            
            $.toaster({
                message: data,
                title: 'Aviso',
                priority : 'warning'
            });  
        }
    })

    $('#showHistoria').on('show.bs.modal', function () {
        $(this).find('.modal-body').css({
               width:'auto', //probably not needed
               height:'auto', //probably not needed 
               'max-height':'100%'
        });

        $('#historia').DataTable().ajax.reload();

    });

	//CARGA INVENTARIO MASIVA
	//
    $("#btnCargarExcelInventarios").on('click', function() 
    {
       
        var form_data = new FormData();
		var form_data_file = new FormData();
        var excelMasivo = $("#excelMasivoInventarios");
        var file_data = excelMasivo[0].files[0];
		//form data para guardar datos
        form_data.append('file', file_data);
		form_data.append('module','InventariosMasivo');
		
        //form data para mover/cargar el archivo
		form_data_file.append('file', file_data);
		form_data_file.append('module','cargarInventarioMasivo');
        
        if( document.getElementById("excelMasivoInventarios").files.length == 0)
		{
			$.toaster({
				message: 'No hay un archivo seleccionado.',
				title: 'Aviso',
				priority : 'danger'
			});
		}
		else
		{
			$.toaster({
				message: 'Inicia Carga de Series Inventario',
				title: 'Aviso',
				priority : 'warning'
			});
			
			
			$("#showAvisosCargas").modal("show");
			$("#bodyCargas").html('Cargando Información <br />');
			
			
			$.ajax({
				type: 'POST',
				url: 'modelos/almacen_db.php',
				data: form_data,
				processData: false,
				contentType: false,
				success: function(data, textStatus, jqXHR){
					console.log(data);
					var info = JSON.parse(data);
					
					if(info.inventarios.length > 0)
					{
						$("#bodyCargas").append(info.mensajeYaCargadas+" <br />");
						
						var message;
						
						$.each(info.inventarios,function(index,value){
							
							$.ajax({
								type: 'POST',
								url: 'modelos/almacen_db.php',//call your php file
								data: 'module=grabarInventario&info='+JSON.stringify(value),
								cache: false,
								success: function(data){
									message += data+" <br />";
									
									$("#bodyCargas").append(data+" <br /> ")
									
								},
								error: function(error){
									var demo = error;
								}
							});
							
						});
						
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/almacen_db.php', // call your php file
                            data: form_data_file,
                            processData: false,
                            contentType: false,

                            success: function(data, textStatus, jqXHR)
                            {
                                $.toaster({
                                message: 'Se cargó el archivo con éxito',
                                title: 'Aviso',
                                priority : 'success'
                                });  
                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                alert(textStatus)
                            }


                        });


						tableInventario.ajax.reload();
						document.getElementById('excelMasivoInventarios').value == null;
						
					} else {
						$("#bodyCargas").append(info.mensajeYaCargadas);
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert(textStatus)
				}
			});	
			
		}      
        
    })


    //UPDATE INVENTARIO MASIVA
    $("#btnUpdateExcelInventarios").on('click', function ()
    {
        var form_data = new FormData();
        var form_data_file = new FormData();
        var excelMasivo = $("#excelMasivoInventarios");
        var file_data = excelMasivo[0].files[0];
        
        //form data para guardar datos
        form_data.append('file', file_data);
        form_data.append('module', 'InventarioEditar');

        //form data para mover/cargar el archivo
        form_data_file.append('file', file_data);
        form_data_file.append('module','cargarInventarioEditar');

        
        if( document.getElementById("excelMasivoInventarios").files.length == 0 )
        {
            $.toaster({
                message: 'No hay un archivo seleccionado.',
                title: 'Aviso',
                priority: 'danger'
            });
        }
        else
        {

            $.toaster({
                message: 'Inicia actualización de Series Inventario',
                title: 'Aviso',
                priority : 'warning'
            });


            $("#showAvisosCargas").modal("show");
            $("#bodyCargas").html('Cargando Información <br />');


            $.ajax({
                type: 'POST',
                url: 'modelos/almacen_db.php', // call your php file
                data: form_data,
                processData: false,
                contentType: false,
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    var info = JSON.parse(data);

                    if(info.inventarios.length > 0)
                    {
                        $("#bodyCargas").append(info.mensajeYaCargadas+"<br />");
                        var message;
                        
                        $.each(info.inventarios, function(index, value)
                        {
                            $.ajax({
                                type: 'POST',
                                url: 'modelos/almacen_db.php', //call ur php file
                                data: 'module=UpdateInventario&info='+JSON.stringify(value),
                                cache: false,

                                success: function (data)
                                {
                                    message += data+"<br />";
                                    $("#bodyCargas").append(data+" <br /> ");
                                },
                                error: function(error)
                                {
                                    var demo = error;
                                }
                            });
                        });


                        $.ajax({
                            type: 'POST',
                            url: 'modelos/almacen_db.php', //
                            data: form_data_file,
                            processData: false,
                            contentType: false,

                            success: function(data, textStatus, jqXHR)
                            {
                                $.toaster({
                                    message: 'Se cargó el archivo con éxito',
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                alert(textStatus)
                            }

                        });

                        tableInventario.ajax.reload();
                        document.getElementById('excelMasivoInventarios').value=null;

                    } 
                    else
                    {
                        $("#bodyCargas").append(info.mensajeYaCargadas);
                    }
    
    
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus)
                }
                
    
            }); 

        }

    })

	 $("#btnAltaAlmacen").on("click", function() {
        window.location.href = "altaalmacen.php";
    })


     $("#banco").on("change",function(){
        var cve = $("#banco").val();

        getModelosBanco(cve);
        //getConectBanco(cve);

     });

     $("#tipo_producto").on("change",function(){
            var tp = $("#tipo_producto").val();

            if (tp == '2') 
            {
                $("#divCarrier").show();
            }
            else
            {
                $("#divCarrier").hide();
            }
     })

});

function campos_tipo()
{
    var ei = document.getElementById("det-estatus-inventario").value;

    if (ei == "1") 
    {
        $("#divTecnico").hide();
        $("#divComercio").hide();
        $("#divAfiliacion").hide();
    }
    if (ei == "3") 
    {
        $("#divTecnico").show();
        $("#divComercio").hide();
    }
    if (ei == "4") {
        $("#divTecnico").hide();
        $("#divComercio").hide();
        $("#divAfiliacion").show();
    }

}


function getProcesosActivos() {


    $.ajax({
        type: 'GET',
        url: 'modelos/procesos_in.php', // call your php file
        data: 'module=getProcesosActivos&tipo=IA' ,
        cache: false,
        success: function(data){
        $("#processBadge").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function fnShowHide( colId,status )
{
    var table = $('#inventario').DataTable();
    table.column( colId ).visible( status ); 
}


function getModelos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getModelos',
        cache: false,
        success: function(data){
             
            $("#det-modelo").html(data);
            tableInventario.ajax.reload();
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getAplicativo() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getAplicativo',
        cache: false,
        success: function(data){
             
            $("#det-aplicativo").html(data);
            //tableInventario.ajax.reload();
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getCarriers() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getCarriers',
        cache: false,
        success: function(data){
             
            $("#det-carrier").html(data);
            $("#tipo_carrier").html(data);
            
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getConectividad() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getConectividad',
        cache: false,
        success: function(data){
             
            $("#det-conectividad").html(data);
            $("#tipo_conect").html(data)
            
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getUbicacion() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getubicacion',
        cache: false,
        success: function(data){
            $("#tipo_ubicacion").html(data); 
            $("#det-ubicacion").html(data);
            tableInventario.ajax.reload();
            if($("#userPerm").val() == 'almacen' || $("#userPerm").val() == 'AL' ) {
                $("#tipo_ubicacion").attr('disabled',true);
                
            } else {
                $("#tipo_ubicacion").attr('disabled',false);
            }
        },
        error: function(error){
            var demo = error;
        }
    });
}


function getEstatus() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getStatus',
        cache: false,
        success: function(data){
            $("#tipo_estatus").html(data);
            $("#det-estatus").html(data);
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getEstatusUbicacion() {

    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getStatusUbicacion',
        cache: false,
        success: function(data){
            $("#tipo_estatusubicacion").html(data);
            $("#det-estatus-inventario").html(data);
             
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTecnicos',
        cache: false,
        success: function(data){
            console.log(data);
        $("#hist-tecnico").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicosxAlmacen() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getTecnicosxAlmacen',
        cache: false,
        success: function(data){
            console.log(data);
        $("#det-tecnico").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getBancos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getBancos',
        cache: false,
        success: function(data){
            //console.log(data);
        $("#banco").html(data);
        $("#det-banco").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getModelosBanco(cve_banco){
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getListaModelos&cve_banco='+cve_banco,
        cache: true,
        success: function(data){
            console.log(data);
      
        $("#tipo_modelo").html(data);      
          
        },
        error: function(error){
            var demo = error;
        }
    });
}

 function getConectBanco(cve_banco) {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getListaConectividad&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              //$("#tipo_conect").html(data);          
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

function cleartext() 
{ 
    $("#det-noserie").val("");
    $("#det-modelo").val("0");
    $("#det-aplicativo").val("0");
    $("#det-carrier").val('0');
    $("#det-conectividad").val("0");
    $("#det-estatus").val("0");
    $("#det-estatus-inventario").val("0");
    $("#det-ubicacion").val("0");
    $("#det-qty").val("0");
    $("#correo").val("")
    $("#proveedor").val("0");
    $("#det-tecnico").val("0");
    $("#det-comercio").val("");
    $("#det-afiliacion").val("");

}