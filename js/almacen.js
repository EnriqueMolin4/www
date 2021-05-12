var infoAjax = 0;
$(document).ready(function() {
    $("#almacenlink").addClass("active");     
    getBancos();
    getModelosTPV();
    getCarriers();
    getInsumos();
    getConectividad();
    getFabricantes();
    getStatus()

    $("#almacen_producto").on("change", function() {
        $("#altatpv").show();
        $("#altaalmacen").show();
        $("#almacen-fabricante").val('0');
        $("#almacen-connect").val('0');
        $("#select-modelo_tpv").val('0');
        $("#select-carrier").val('0');
        $("#select-insumo").val('0');
        $("#almacen-ptid").val('');
		$("#fabricantebk").show();
		$("#connectbk").show();
		$("#ptidbk").show();

       
         switch ( $(this).val() ) {
             
             case '1':
              $("#carrierbk").hide();
              $("#tpvbk").show();
              $("#ptidbk").hide();
              $("#noseriebk").show();
              $("#cantidadbk").hide();
              $("#insumobk").hide();
              $("#tarimabk").show();
              $("#anaquelbk").show();
              $("#cajonbk").show();
              $("#almacen-ptid").attr('readonly',false);
              $("#almacen-ptid").attr('disabled',true);
             
             break;
             case '2':
              $("#fabricantebk").hide();
              $("#connectbk").hide();
              $("#carrierbk").show();
              $("#ptidbk").hide();
              $("#tarimabk").hide();
              $("#anaquelbk").hide();
              $("#cajonbk").hide();
              $("#tpvbk").hide();
              $("#noseriebk").show();
              $("#cantidadbk").hide();
              $("#insumobk").hide();
              $("#almacen-ptid").attr('readonly',true);
               
             break;
             case '3':
             $("#carrierbk").hide();
             $("#tpvbk").hide();
             $("#noseriebk").hide();
             $("#cantidadbk").show();
             $("#insumobk").show();
             $("#almacen-ptid").attr('readonly',true);
			 $("#fabricantebk").hide();
			 $("#connectbk").hide();
             $("#ptidbk").hide();
             $("#cajonbk").hide();
             break;
             default:
             $("#altatpv").hide();
             $("#altaalmacen").hide();
 
         }
    })
    
    $("#select-modelo_tpv").on('change', function() {
        var info = $(this).find(":selected").attr('data').split('_');
       console.log(info);
        $("#almacen-fabricante").val(info[1]);
        $("#almacen-connect").val(info[2]);
    })

    $("#btnAsignar").on('click', function() {

    
        if( $("#cve_banco").val() != '0'  ||  $("#almacen_producto").val() != '0' ||   $("#almacen-estatus").val() != 0 ||   $("#almacen-tarima").val() != 0 ||   $("#almacen-anaquel").val() != 0 ||   $("#almacen-cajon").val() != 0 ||   $("#select-insumo").val() != 0 )
        {
            
            var dn= { 
                module: 'altaAlmacen', cve_banco: $("#cve_banco").val(), 
                'tpv': $("#select-modelo_tpv").val(),  
                'connect': $("#almacen-connect").val(),  'carrier': $("#select-carrier").val(), 
                'insumo': $("#select-insumo").val() ,   'producto' : $("#almacen_producto").val(), 
                'cantidad': $("#almacen-cantidad").val(), 'noserie': $("#almacen-no_serie").val(), 
                'estatus': $("#select-estatus").val() ,  'tarima' : $("#almacen-tarima").val(), 
                'anaquel': $("#almacen-anaquel").val(),  'cajon' : $("#almacen-cajon").val() 
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
            alert("HACEN FALTA CAMPOS POR LLENAR");
        }
    })


    

        
} );

    

function getBancos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getBancos',
        cache: false,
        success: function(data){
        $("#cve_banco").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getModelosTPV() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getmodelostpv',
        cache: false,
        success: function(data){
        $("#select-modelo_tpv").html(data);            
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
        $("#select-carrier").html(data);            
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
        $("#select-insumo").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getFabricantes() {
    
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getFabricantes',
        cache: false,
        success: function(data){
        $("#almacen-fabricante").html(data);   
        $("#almacen-fabricante").val("0");           
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getConectividad() {
    $("#almacen-connect").html('');
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getConectividad',
        cache: false,
        success: function(data){
        $("#almacen-connect").html(data);
        $("#almacen-connect").val("0");                  
        },
        error: function(error){
            var demo = error;
        }
    });
}






function cleartext() {
    $("#cve_banco").val("0")
    $("#almacen_producto").val("0")
    $("#select-modelo_tpv").val("0")
    $("#almacen-no_serie").val("");
    $("#select-estatus").val("0")
    $("#almacen-tarima").val("");
    $("#almacen-anaquel").val("");
    $("#almacen-cajon").val("")
    $("#select-carrier").val("0")
    $("#select-insumo").val("0")
    $("#almacen-cantidad").val("")
}

function mostrarComercio(data) {
    $("#cve_banco").val(data.cve_banco)
    $("#comercio").val(data.comercio)
    $("#propietario").val(data.propietario)
    $("#estado").val(data.estado);
    $("#responsable").val(data.responsable)
    $("#tipo_comercio").val(data.tipo_comercio);
    $("#municipio").val(data.ciudad)
    $("#colonia").val(data.colonia)
    $("#afiliacion").val(data.afiliacion)
    $("#telefono").val(data.telefono)
    $("#direccion").val(data.direccion);
    $("#email").val(data.email)
    $("#hora_general").val(data.hora_general)
    $("#hora_comida").val(data.hora_comida)
    getEquipos();
}




function getProveedores() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getProveedores',
        cache: false,
        success: function(data){
        $("#almacen-proveedor").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getStatus() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getStatus',
        cache: false,
        success: function(data){
        $("#select-estatus").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

    
}

