var infoAjax = 0;
var tableInventario;
var usrPerm;
$(document).ready(function() {
    usrPerm = $("#userPerm").val();
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "almacenlink");
    getModelos();
    getConectividad();
    getUbicacion();
    getEstatus();
	getEstatusUbicacion();
	getCarriers();

    $("#fechaVen_inicio").datetimepicker({
        format:'Y-m-d'
    });

    $("#fechaVen_fin").datetimepicker({
        format:'Y-m-d'
    });

    $(".searchInventario").on('change',function() {
        tableInventario.ajax.reload();
    })

   //Inhabilitar entrada


//Tabla principal de la página
    tableInventario = $('#inventario').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "ASC" ]],		  
        dom: 'lfrtiBp',
        buttons: [
            'pdf',
            'excelHtml5',
            'csv'
        ],
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getTableInsumos',
                d.tipo_producto = $("#tipo_producto").val()
            }
        },
        columns : [
            { data: 'tipoNombre'},
            { data: 'producto'},
            { data: 'estatus' },
            { data: 'ubi'},
            { data: 'fecha_edicion' },
            { data: 'fecha_creacion' },
            { data: 'cantidad' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [ 0 ],
                "width": "8%",
            },
            {
                "targets": [ 1 ],
                "width": "15%",
            },
            {
                "targets": [7],
                "mRender": function ( data,type, row ) 
                {
                    var id;
					var buttons = '';
					
                        id = row.id;
                    
					if(usrPerm == 'admin' || usrPerm == 'CA' || usrPerm == 'AN' ) {
						 //buttons += ' <a href="#" class="btn btn-warning mostrarDetalle" data="'+id+' ">Editar</a>';
						 buttons += '<a href="#" title="Historia" class="mostrarHistoria" data="'+id+' "><i class="fas fa-history fa-2x" style="color:#C17137"></i></a>';
					} 

					
                    return buttons;
                }
            }
        ]
    });


    $('#historia').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        lengthMenu: [[5], [5]],
        order: [[ 0, "ASC" ]],		
        dom: 'lfrtiBp',
        buttons: [
            'pdf',
            'excelHtml5',
            'csv'
        ],
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getHistoriaInsumos',
                d.noSerie = $("#noSerie").val(),
                d.tipo = $("#tipo_producto").val(),
                d.tecnicoId = $("#ubicacionId").val()
            }
        },
        columns : [
            { data: 'fecha_movimiento'},
            { data: 'producto' },
            { data: 'cantidad' },
            { data: 'ubicacionNombre' },
            { data: 'id_ubicacion'},
            { data: 'id'}     
        ],
        aoColumnDefs: [
            {
                "targets": [5],
                "visible": false,
                "searchable": false
            }
        ]
    });
	

    $(document).on("click",".mostrarHistoria", function() {
            
       
        var index = $(this).parent().parent().index() ;
        var data = tableInventario.row( index ).data()
        console.log(index)
        console.log(data)
        getTecnicos();
        $("#noSerie").val(data.id);

        //Details
        $("#hist-producto").val('TPV');
        $("#hist-noserie").val(data.no_serie);
        $("#hist-desde").val(data.ubicacion);
        $("#ubicacionId").val(data.ubicacionId);
        
        $("#showHistoria").modal("show");
       
    })
	
	$(document).on("click",".mostrarDetalle", function() {
		 
		var index = $(this).parent().parent().index() ;
        var data = tableInventario.row( index ).data()
        //Numero de serie
        $("#det-noserie").val(data.no_serie);

		if(data.tipo == 1) {
			$("#divModelo").show();
			$("#divCarrier").hide();
			
			$("#det-modelo option").filter(function() {
            return $(this).text() == data.modelo;
			}).prop('selected', true);
		 
		} else if(data.tipo == 2 ) {
			$("#divModelo").hide();
			$("#divCarrier").show();
		
			
			$("#det-carrier option").filter(function() {
            return $(this).text() == data.modelo;
			}).prop('selected', true);
		}
        //Modelo
        

        //Conectividad
        $("#det-conectividad option").filter(function() {
            return $(this).text() == data.conect
          }).prop("selected", "selected");

        //Estatus
		$("#det-estatus option").filter(function() {
		  return $(this).text() == data.estatus;
        }).prop('selected', true);
        
		//Estatus Inventario
		$("#det-estatus-inventario option").filter(function() {
		  return $(this).text() == data.estatus_inventario;
        }).prop('selected', true);
        
		//Ubicación
		$("#det-ubicacion option").filter(function() {
		  return $(this).text() == data.ubicacion;
        }).prop('selected', true);
        
        //Cantidad
        $("#det-qty").val(data.cantidad);

        if(data.tipo == '3') {
            $("#det-qty").attr('readonly',false);
        } else {
            $("#det-qty").attr('readonly',true);
        }
       
        $("#ubicacionId").val(data.id_ubicacion);

		$("#showDetalle").modal("show");
	})
	
	$('#showDetalle').on('hide.bs.modal', function () {
         cleartext();

    });
	
	$("#btnCambiarInv").on("click",function() {
		
        var noserie =           $("#det-noserie").val();
        var modelo =            $("#det-modelo").val() == '0' ? $("#det-carrier").val() : $("#det-modelo").val();
        var conectividad =      $("#det-conectividad").val();
		var estatus =           $("#det-estatus").val();
		var estatusinventario = $("#det-estatus-inventario").val();
        var ubicacion =         $("#det-ubicacion").val();
        var cantidad =          $("#det-qty").val();
        //var ubicacionId =       $("#ubicacionId").val();
		
		$.ajax({
			type: 'GET',
			url: 'modelos/almacen_db.php', // call your php file
			data: 'module=updateInvProd&noserie='+noserie+'&modelo='+modelo+'&conectividad='+conectividad+'&estatus='+estatus+'&ubicacion='+ubicacion+'&estatusinventario='+estatusinventario+'&cantidad='+cantidad,
			cache: false,
            success: function(data)
            {
				 tableInventario.ajax.reload();
                 $("#showDetalle").modal("hide");
                 
                 $.toaster({
                    message: 'Se guardaron los cambios',
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
	})

    $('#showHistoria').on('show.bs.modal', function () {
        $(this).find('.modal-body').css({
               width:'auto', //probably not needed
               height:'auto', //probably not needed 
               'max-height':'100%'
        });

        $('#historia').DataTable().ajax.reload();

    });

//
    //CARGA DE INVENTARIO MASIVA
    //
    $("#btnCargarExcelInventarios").on('click', function() 
    {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivoInventarios");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','InventariosMasivo');
        //form_data.append('module','cargarInventarioMasivo');

        if( document.getElementById("excelMasivoInventarios").files.length == 0 )
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
                message: 'Inicia carga de inventario.',
                title: 'Aviso',
                priority : 'success'
                });

            $("#showAvisosCargas").modal("show");
            $("#bodyCargas").html('Cargando Informacion <br /> ');


            $.ajax({
                type: 'POST',
                url: 'modelos/almacen_db.php', // call your php file
                data: form_data,
                processData: false,
                contentType: false,
                success: function(data, textStatus, jqXHR){
                    var info = JSON.parse(data);
    
                    if(info.inventarios.length > 0) 
                    {
                        $("#bodyCargas").append(info.mensajeYaCargadas+" <br />  ");
    
                        var message ;
                        
                         $.each(info.inventarios,function(index,value) {
                           
                        
                            $.ajax({
                                type: 'POST',
                                url: 'modelos/almacen_db.php', // call your php file
                                data: 'module=grabarInventario&info='+JSON.stringify(value),
                                cache: false,
                                success: function(data){
                                    message += data+"  <br />  ";
    
                                    $("#bodyCargas").append(data+" <br />  ");
                                
                                },
                                error: function(error){
                                    var demo = error;
                                }
                            });
                        })
    
                        tableInventario.ajax.reload(); 
                        document.getElementById('excelMasivoInventarios').value= null;
    
                    } else {
                        $("#bodyCargas").append(info.mensajeYaCargadas);
                    }
                 
    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
               }
            });


        }       
    })


    
    
    //
    //ACTUALIZACIÓN DE INFORMACIÓN DE SERIES MASIVA
    //
    $("#btnUpdateExcelInventarios").on('click', function ()
    {
        var form_data = new FormData();
	    var excelMasivo = $("#excelMasivoInventarios");
        var file_data = excelMasivo[0].files[0];
        
        form_data.append('file', file_data);
        form_data.append('module', 'InventarioEditar');
        
        if( document.getElementById("excelMasivoInventarios").files.length == 0 )
        {
            console.log("No se seleccionó un archivo");
            $.toaster({
                message: 'No hay un archivo seleccionado.',
                title: 'Aviso',
                priority : 'danger'
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
            $("#bodyCargas").html('Actualizando Información <br /> ');
        
        $.ajax({
            type: 'POST',
		    url: 'modelos/almacen_db.php', // call your php file
		    data: form_data,
		    processData: false,
            contentType: false,
            
        
            success: function(data, textStatus, jqXHR)
            {
                var info = JSON.parse(data);

                if(info.inventarios.length > 0)
                {
                    $("#bodyCargas").append(info.mensajeYaCargadas+" <br / ");

                    var message;

                    $.each(info.inventarios, function(index, value)
				{
					
					$.ajax({ 
						type: 'POST',
						url: 'modelos/almacen_db.php', // call your php file
						data: 'module=UpdateInventario&info='+JSON.stringify(value),
						cache: false, 
						
						success: function (data)
						{
							message += data+" <br />";
							
                            $("#bodyCargas").append(data+" <br /> ");

                           
                            
						},
						error: function(error)
						{
							var demo = error;
						}
						
					});
					
                });
                
                tableInventario.ajax.reload();

                
                document.getElementById('excelMasivoInventarios').value= null;

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

});
function fnShowHide( colId,status )
{
    var table = $('#inventario').DataTable();
    table.column( colId ).visible( status ); 
}

//Llamada a la función que tiene la información de los modelos
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

//Llamada a la función que tiene la información de los carriers
function getCarriers() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getCarriers',
        cache: false,
        success: function(data){
             
			$("#det-carrier").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

//Llamada a la función que tiene la información de tipos de conectividad
function getConectividad() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getConectividad',
        cache: false,
        success: function(data){
             
            $("#det-conectividad").html(data);
			
			
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

function cleartext() /* Función que limpia los campos del formulario */
{ 
    $("#det-noserie").val("");
    $("#det-modelo").val("0");
	$("#det-carrier").val('0');
    $("#det-conectividad").val("0");
    $("#det-estatus").val("0");
    $("#det-estatus-inventario").val("0");
    $("#det-ubicacion").val("0");
    $("#det-qty").val("0");
    $("#correo").val("")
    $("#proveedor").val("0");

}