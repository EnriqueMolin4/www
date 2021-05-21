var infoAjax = 0;
$(document).ready(function() {
    getTipoEvento();
    getEstatusEvento();
    getTecnicos();
    getEstatus();
    getubicacion();
    getubi();

    //ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "eventoslink")
    
        $("#fechaVen_inicio").datetimepicker({
            format:'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
            format:'Y-m-d'
        });


        

})

    $('#tipo_producto').multiselect({includeSelectAllOption: true,
                    allSelectedText: 'Todos'});

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

function getTecnicos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTecnicos',
        cache: false,
        success: function(data){
        $("#tecnico").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

    
}

function getEstatus() 
{
    $.ajax({
        type: 'GET',
        url: 'modelos/reportes_db.php', // call your php file
        data: 'module=getEstatus',
        cache: false,
        success: function(data){
        $("#tipo_estatus").html(data);   
        $("#tipo_estatus").multiselect({
            nonSelectedText: 'Seleccionar',
            includeSelectAllOption: true,
            allSelectedText: 'Todos'
        })
        console.data;       
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getubicacion() 
{
    $.ajax({
        type: 'GET',
        url: 'modelos/reportes_db.php', // call your php file
        data: 'module=getubicacion',
        cache: false,
        success: function(data){
        $("#tipo_estatusubicacion").html(data);   
        $("#tipo_estatusubicacion").multiselect({
            nonSelectedText: 'Seleccionar',
            includeSelectAllOption: true,
            allSelectedText: 'Todos'
        });
        console.data;       
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getubi() 
{
    $.ajax({
        type: 'GET',
        url: 'modelos/reportes_db.php', // call your php file
        data: 'module=getubi',
        cache: false,
        success: function(data){
        $("#tipo_ubicacion").html(data);   
        $("#tipo_ubicacion").multiselect({
            nonSelectedText: 'Seleccionar',
            includeSelectAllOption: true,
            allSelectedText: 'Todos'
        });
        console.data;       
        },
        error: function(error){
            var demo = error;
        }
    });
}