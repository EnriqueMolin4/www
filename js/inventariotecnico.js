var infoAjax = 0;
var tableInventario;
var fecha_hoy;

$(document).ready(function() {
    
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "cargastecnicolink")
    getTecnicos( $("#almacenId").val() );
    getCarriers();
    getInsumos();
    getEstatus();

    $(".searchInventario").on('change',function() {
        tableInventario.ajax.reload();
    })

    fecha_hoy = moment().format('YYYY-MM-DD');   


    tableInventario = $('#inventario').DataTable({
        "responsive": true,
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
            title: 'Inventario_Tecnico'+fecha_hoy,
            exportOptions: {
                orthogonal: 'sort',
                columns: [0,1,2,3,4,5,6,7,8]
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
                d.module = 'getInventarioTecnico',
                d.tecnico = $("#tecnico").val(),
                d.tipo_producto = $("#tipo_producto").val(),
                d.estatus = $("#estatus").val()
            }
        },
        columns : [
            { data: 'nombreTecnico'},
            { data: 'producto'},
            { data: 'no_serie'},
			{ data: 'modelo'},
            { data: 'conectividad'},
            { data: 'aplicativo'},
            { data: 'cantidad' },
            { data: 'estatus' },
            { data: 'fecha_modificacion' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [9],
                "mRender": function ( data,type, row ) {
                    var id;
                    var estatus = '';
                    if(row.tipo == '1') {
                        id = row.no_serie;
                    } else if (row.tipo == '2') {
                        id = row.no_serie;
                    } else {
                        id = row.id;
                        tecnico = row.nombreTecnico;
                    }

                    if(row.estatusId == '7' || row.estatusId == '16' || row.estatusId == '17' ) {
                        if(row.estatustraspaso == '1') {
                        estatus = '<input type="checkbox" id="chk_"'+row.id+'">';
                        }
                    }

                    return '<a href="#" class="btn btn-success mostrarHistoria" data="'+id+tecnico+' ">Detalle</a> '+estatus;
                }
            }
        ],
        rowCallback: function( row, data, index,full){
           
             fnShowHide( 5,true )
                 var fechamodificacion = moment(data.fecha_modificacion)
                 var now = moment();
                 var diff = moment.duration(fechamodificacion.diff(now));
                 var col = this.api().column(8).index('visible');

                 if(now.diff(fechamodificacion, 'days') >= 30  ) 
                 {
                 
                    $('td', row).eq(col).css('color', '#000');
                    $('td', row).eq(col).css('background-color', '#ae2b2b');
                 } else if(now.diff(fechamodificacion, 'days') >= 15)
                 {
                    $('td', row).eq(col).css('background-color', '#FFFF00');
                 }else{
                    $('td', row).eq(col).css('background-color', '#00CC66');
                 }
         }
    });

    $("#btnGrabar").on('click',function() {
        var alerta = '';
        var dtAsig = $("#inventario").DataTable();
        var data = dtAsig.rows().data();
        var total = 0;
        var error = 0;
        var datos=[];
		var noGuia = $("#noGuia").val();
		var codigoRastreo = $("#codigoRastreo").val();

        if( $("#tecnico").val() == '0') {
            alerta += "Favor de Seleccionar una Tecnico \n";
            error++;
        } 

        $.each(data, function(index,value) {
            if( dtAsig.cell(index,6).nodes().to$().find('input').is(":checked") ) {
                total++;
                var valueToPush = new Object();  
                valueToPush["NoSerie"] = value.no_serie;
                valueToPush["Tecnico"] = $("#tecnico").val();
                valueToPush["Producto"] = value.producto;
                datos.push(valueToPush);
            }
        })

        if(total == 0) {
            alerta += "Favor de Seleccionar Eventos para asignar \n";
            error++;
        }
        
        if(error == 0) {
            alerta = "Se Asignaron correctamente las TPV \n";
            $.ajax({
                type: 'POST',
                url: 'modelos/almacen_db.php', // call your php file
                data: 'module=crearRetornos&noserie='+JSON.stringify( datos )+"&tecnico="+$("#tecnico_asig").val()+"&noGuia="+noGuia+"&codigoRastreo="+codigoRastreo,
                cache: false,
                success: function(data){
                    if(data > 0 ) {
                        tableInventario.ajax.reload();
                        alert(alerta)
                    } else {
                        alert ("Fallo el cambio de Estatus" );
                    }
                                        
                },
                error: function(error){
                    var demo = error;
                }
            });
            
        } else {
           
            alert(alerta);
           
        }
        
        
    })

    $("#btnCrearTraspasoDaÃ±ado").on('click',function(){ 
        var alerta = '';
        var dtAsig = $("#inventario").DataTable();
        var data = dtAsig.rows().data();
        var total = 0;
        var error = 0;
        var datos=[];

       

        $.each(data, function(index,value) {
            if( dtAsig.cell(index,6).nodes().to$().find('input').is(":checked") ) {
                total++;                 
            }
        })

        if(total == 0) {
            alerta += "Favor de Seleccionar Eventos para asignar \n";
            error++;
        } 
		
		if($("#tecnico").val() == '0') {
			alerta += "Favor de Seleccionar EventoUn Tecnico \n";
			error++;
		}
        
        if(error == 0) {
            var tecnicoNombre = $("#tecnico option:selected").text();
            $("#desdeEnvio").html(tecnicoNombre)
            $("#showTraspaso").modal('show');
        } else {
           
            alert(alerta);
           
        }


        
    })

    $("#btnAltaInventarioTecnico").on("click", function() {
        $(".showNoSerie").hide();
        $(".showCarrier").hide();
        $(".showInsumo").hide();   
        $(".showProduct").hide();
        $("#showHistoria").modal("show");
        $(".showNoGuia").hide();
       
    })
	
	$('#historia').DataTable({
        "responsive": true,
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
                d.module = 'getHistoriaIT',
                d.noSerie = $("#noSerie").val(),
                d.tipo = $("#tipo_producto").val(),
                d.tecnicoId = $("#tecnicoId").val()
                //d.tecnicoNomb = $("#Tec").val()
            }
        },
        columns : [
            { data: 'fecha_movimiento'},
            { data: 'tipo_movimiento' },
            { data: 'cantidad' },
            { data: 'ubicacionStatus' },
            { data: 'id_ubicacion'},
            { data: 'id_ubicacion'}     
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
        //getTecnicos();
        $("#noSerie").val(data.no_serie);
        $("#tecnicoId").val(data.tecnico);
        //Details
        $("#hist-producto").val('TPV');
        $("#hist-noserie").val(data.no_serie);
        $("#hist-desde").val(data.ubicacion);
        
        $("#showHistoria").modal("show");
       
    })

    $('#showHistoria').on('show.bs.modal', function () {
        
        $(this).find('.modal-body').css({
               width:'auto', //probably not needed
               height:'auto', //probably not needed 
               'max-height':'100%'
        });

         $('#historia').DataTable().ajax.reload();

    });

    $("#add-tecnico").on("change", function() {
        var territorio = $("#add-tecnico").find(':selected').data("id");

        if(territorio != '0' && territorio != '4' ) {
            $(".showNoGuia").show();
        } else {
            $(".showNoGuia").hide();
        }
    })

    $("#addtipo_producto").on("change", function() {
        var tipo = $(this).val();
        $("#btnAdd").attr('disabled',false);
        var territorio = $("#add-tecnico").find(':selected').data("id") 

        switch(tipo) {
            case '1':
                $(".showNoSerie").show();
                $(".showCarrier").hide();
                $(".showProduct").show();
                
            break;
            case '2':
                $(".showNoSerie").show();
                $(".showCarrier").show();
                $(".showProduct").show();
                
            break;
            case '3':
                $(".showNoSerie").hide();
                $(".showCarrier").hide();
                $(".showInsumo").show();
                $(".showProduct").hide();
            break;
            default:
                $(".showNoSerie").hide();
                $(".showCarrier").hide();
                $(".showInsumo").hide();
                $(".showProduct").hide();
        }

        if(territorio != '0' && territorio != '4' ) {
            $(".showNoGuia").show();
        } else {
            $(".showNoGuia").hide();
        }
    })

    $("#add-insumo").on('change',function() {

        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getinvInsumo&insumo='+$(this).val(),
            cache: false,
            success: function(data){
                var info = JSON.parse(data);
                $("#cant-insumo").val(info.cantidad);            
            },
            error: function(error){
                var demo = error;
            }
        });
    })

    $( "#add_no_serie" ).on('change', function() {
        var error= 0;
        var no_serie = $(this).val();
        var tipo = $("#addtipo_producto").val();
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=buscarNoSerie&term='+$(this).val()+"&tipo="+tipo,
            cache: false,
            success: function(data){
                var info = JSON.parse(data);
               if(no_serie.length > 0 ) { 
                   var schBuscar = $( "#add-product" ).val();
                   if( schBuscar.search(no_serie+"\n") == -1 ) {
                        if( parseInt(info[0].existe) == 0 ) {
                        alert("el No Serie no esta en en inventario");
                         
                        } else {
                        $("#add-product").append( no_serie+"\n" )
                            $("#btnAdd").attr('disabled',false);
                             
                        }
                        $("#add_no_serie").val('');
                   } else {
                       alert('Ya esta agregado');
                   }
               }  
            },
            error: function(error){
                var demo = error;
            }
        });

    });

    $("#btnAdd").on("click", function() {
        var error = 0;
        var message = '';

        if( $("#addtipo_producto").val() != '0'  &&  $("#add-tecnico").val() != '0' )
        {
            switch( $("#addtipo_producto").val() ) {
                case '1':
                    
                    var oldProducts = $("#add-product").val().split('\n');
                    var products = oldProducts.filter(function(v){return v!==''});
                    var totalP = products.length;
                    $("#add_cantidad").val(0);
                    if( totalP == 0  )
                    {
                        error++;
                        message += ' Agregar el No Serie  \n ';
                    } 
                break;
                case '2':
                    $("#add_cantidad").val(0);
                    if( totalP == 0 )
                    {
                        error++;
                        message += ' Agregar el No Serie  \n ';
                    } 
                break;
                case '3':
                    if( $("#add_cantidad").val().length == 0  && $("#add-insumo").val() == '0' )
                    {
                        error++;
                        message += ' Agregar la cantidad y el tipo de insumo \n ';
                    } 
                break;
                case '3':
                    if( $("#add_cantidad").val().length == 0  && $("#add-insumo").val() == '0' )
                    {
                        error++;
                        message += ' Agregar la cantidad de Accesorios \n ';
                    } 
                break;
            }

            var inv = parseInt( $("#cant-insumo").val() );
            var cant = parseInt( $("#add_cantidad").val() );

            if( ( $("#addtipo_producto").val() == '3' || $("#addtipo_producto").val() == '4')  && ( cant > inv ) ) {
                error++;
                message += ' La cantidad es mayor al inventario \n ';
            }

            if(error == 0) {
                var dn= { 
                    module: 'altaInvTecnico', 'products': JSON.stringify(products),  
                    'tecnico': $("#add-tecnico").val(),  'carrier': $("#add-carrier").val(), 
                    'insumo': $("#add-insumo").val() ,   'producto' : $("#addtipo_producto").val(), 
                    'cantidad': $("#add_cantidad").val(), 'noserie': $("#add_no_serie").val(),
                    'noguia' : $("#add_no_guia").val(), 'territorio': $("#add-tecnico").find(':selected').data("id")
                };
            
                $.ajax({
                    type: 'POST',
                    url: 'modelos/almacen_db.php', // call your php file
                    data: dn,
                    cache: false,
                    success: function(data){
                        var info = JSON.parse(data);
                        mensaje = "Se agrego con Exito al Inventario"
                        if(info.id == '0') {
                            mensaje = "Fallo la carga l Inventario"
                        } else {
                            cleartext();
                        }

                        $.toaster({
                            message: mensaje,
                            title: 'Aviso',
                            priority : 'success'
                        }); 

                    
                    },
                    error: function(error){
                        var demo = error;
                    }
                });
            } else {
                alert(message);
            }
            
        } else {
            alert("HACEN FALTA SELECCIONAR TIPO y TECNICO");
        }
    })

    $("#btnCancel").on('click', function() {
        cleartext();
    })
//BotÃ³n Entrada AlmacÃ©n
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
});

function fnShowHide( colId,status )
{
    var table = $('#inventario').DataTable();
    table.column( colId ).visible( status ); 
}

function cleartext() {
    $("#addtipo_producto").val(0);
    $("#add-tecnico").val(0);
    $("#add_no_serie").val('');
    $("#add-carrier").val('');
    $("#add-insumo").val('');
    $("#add-cantidad").val('');
    $("#cant-insumo").val('');
    $("#add-product").val('');

}

function getUbicacion() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getubicacion',
        cache: false,
        success: function(data){
            $("#tipo_ubicacion").html(data);            
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
            $("#estatus").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicos(ter) {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getTecnicosxAlmacen&ter='+ter,
        cache: false,
        success: function(data){
           
        $("#tecnico").html(data);   
        $("#add-tecnico").html(data);         
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
        $("#add-carrier").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getInsumos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getInsumos',
        cache: false,
        success: function(data){
        $("#add-insumo").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}






