var infoAjax = 0;
var tableInventario;
$(document).ready(function() {
    
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "cargastecnicolink")
    showFields();
    getTecnicos();
    getCarriers();
    getInsumos();
    getAlmacen();

    $("#addtipo_traspaso").on("change",function() {
        var tipo = $(this).val();
        switch(tipo) {
            case '1':
                $(".showAlmacen").hide();
                $(".showTecnico").show();
                
            break;
            case '2':
                $(".showAlmacen").show();
                $(".showTecnico").hide();
                
            break;
            default:
                $(".showAlmacen").hide();
                $(".showTecnico").hide();
        }
    });

    $("#addtipo_producto").on("change", function() {
        var tipo = $(this).val();
        $("#btnAdd").attr('disabled',false);

        $(".showNoGuia").show();
        switch(tipo) {
            case '1':
                $(".showNoSerie").show();
                $(".showCarrier").hide();
                $(".showProduct").show();
                $(".showInsumo").hide();
                
            break;
            case '2':
                $(".showNoSerie").show();
                $(".showCarrier").show();
                $(".showProduct").show();
                $(".showInsumo").hide();
                
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

    $("#btnGrabar").on("click", function() {
        var error = 0;
        var message = '';

        if( $("#addtipo_traspaso").val() != '0' &&  $("#addtipo_producto").val() != '0'  &&  ( $("#add-tecnico").val() != '0' || $("#add-almacen").val() != '0' ) )
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
            }

            var inv = parseInt( $("#cant-insumo").val() );
            var cant = parseInt( $("#add_cantidad").val() );

            if( $("#addtipo_producto").val() == '3' && ( cant > inv ) ) {
                error++;
                message += ' La cantidad es mayor al inventario \n ';
            }

            if(error == 0) {
                var dn= { 
                    module: 'nuevoTraspaso', 'products': JSON.stringify(products), 
                    'tipoTraspaso': $("#addtipo_traspaso").val(), 'almacen' : $("#add-almacen").val(),
                    'tecnico': $("#add-tecnico").val(),  'carrier': $("#add-carrier").val(), 
                    'insumo': $("#add-insumo").val() ,   'producto' : $("#addtipo_producto").val(), 
                    'cantidad': $("#add_cantidad").val(), 'noserie': $("#add_no_serie").val(),
                    'noguia' : $("#add_no_guia").val()
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
});

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
            $("#tipo_estatus").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getTecnicos&ter=0',
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

function getAlmacen() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getAlmacen',
        cache: false,
        success: function(data){
        $("#add-almacen").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function showFields() {
    $(".showNoSerie").hide();
    $(".showCarrier").hide();
    $(".showInsumo").hide();   
    $(".showProduct").hide();
    $("#showHistoria").modal("show");
    $(".showNoGuia").hide();
    $(".showAlmacen").hide();
    $(".showTecnico").hide();
}






