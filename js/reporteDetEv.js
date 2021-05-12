    var infoAjax = 0;
var tipofallas;

$(document).ready(function() {

    ResetLeftMenuClass("submenureportes", "ulsubmenureportes","reportedeteventolink")

    getTipoServicio();
    getEstados();
    getEstatusServicio();
    getTipoSubServicio();
	
	//Create Ticket
	var d = new Date();
	var dia = d.getDate();
	var mes = d.getMonth();
	var anio = d.getFullYear().toString().substr(-2);
	var hora = d.getHours();
	var minutos = d.getMinutes();
	var segundos = d.getSeconds()
	$("#ticket").val("VIS"+dia+mes+anio+hora+minutos+segundos);
	
    
    getTipoFallas().done(function(data) {
        tipofallas = data;
    })

        $("#fecha_alta").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#fecha_hasta").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#fecha_cierre").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#hasta_fc").datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });
/*

    $("#btnEnviarDetalle").on("click", function() {
        var fechaalta       = $("#fecha_alta").val();
        var fechahasta      = $("#fecha_hasta").val();
        var estadossel      = JSON.stringify( $("#estado").val() );
        var tiposervicio    = $("#tipo_servicio").val();
        var tiposubservicio = $("#tipo_subservicio").val();
        var estatussel      = JSON.stringify( $("#estatus_servicio").val() );
        var fechacierre     = $("#fecha_cierre").val();

        $.ajax({
            type: 'POST',
            url : 'modelos/reportes_db.php',
            data: { module: 'reporte_detevento', fechaAlta : fechaalta, fechaHasta : fechahasta, estadosSel : estadossel, tipoServicio : tiposervicio, tipoSubservicio : tiposubservicio, estatusSel : estatussel, fechaCierre : fechacierre },
            cache: false,
            success: function(data, textStatus, jqXHR){
                
            },
            error : function(jqXHR, textStatus, errorThrown){
                alert(data)
            }
        });

    })*/

    $("#tipo_servicio").on("change", function() {
        //console.log($(this).val());
        //console.log(tipofallas);
		getTipoSubServicio();
		var tipo = $("#tipo_servicio option:selected").text();
		/*if(tipo.search("INSTALACION") == 0) {
            $("#cantidad").val(20);
        } else {
            $("#cantidad").val(0);
        }
        if( $(this).val() == "10") {
            $("#tipo_falla").html(tipofallas);
        } else  {
            var tipo = "<option value='0'>Otro</option>";
            $("#tipo_falla").html(tipo);
        }*/
    })
  
} );

    
      function initMap() {
         
      }

function getTipoServicio() {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoServicios&tipo=rep',
        cache: false,
        success: function(data){
        $("#tipo_servicio").html(data);
        $("#tipo_servicio").multiselect({
                    nonSelectedText: 'Seleccionar', 
                    includeSelectAllOption: true,
                    allSelectedText: 'Todos'
                });
        //getTipoSubServicio();
        },
        error: function(error){
            var demo = error;
        }
    });




}

function getTipoSubServicio() {

    var servicios = JSON.stringify($("#tipo_servicio").val()); 
    //console.log(servicios);
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoSubServicio&servicio_id='+servicios,
        cache: false,
        success: function(data){
        $("#tipo_subservicio").html(data);  
        $("#tipo_subservicio").multiselect({
                nonSelectedText: 'Seleccionar', 
                includeSelectAllOption: true,
                allSelectedText: 'Todos'
            });   
          $('#tipo_subservicio').multiselect('rebuild');     
        },
        error: function(error){
            var demo = error;
        }
    });


}

/*$("#tipo_servicio").on('change', function() {

           
    $('#tipo_subservicio').multiselect('refresh');
    getTipoSubServicio();
})*/

function callback(response) {
    tipofallas = response;
    //use return_first variable here
  }

function getTipoFallas(tipofallas) {
     
    return $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoFallas',
        cache: false
    });

    
}



function getEstados() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEstados',
        cache: false,
        success: function(data){
        $("#estado").html(data); 
        //$('#estado').multiselect({nonSelectedText: 'Sin Seleccionar'});
        $('#estado').multiselect({
            nonSelectedText: 'Seleccionar',
            includeSelectAllOption: true,
            allSelectedText: 'Todos'
        });

        },
        error: function(error){
            var demo = error;
        }
    });
}

function getMunicipios() {
    var estado = $("#estado").val();

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getMunicipios&estado='+estado ,
        cache: false,
        success: function(data){
        $("#municipio").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getEquipos(id) {
    var cve = $("#cve_banco").val();
    var afiliacion = $("#afiliacion").val();

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEquipos&comercio_id='+id ,
        cache: false,
        success: function(data){
        $("#equipo_instalado").html(data);            
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
         $("#estatus_servicio").multiselect({
            nonSelectedText: 'Seleccionar',
            includeSelectAllOption: true,
            allSelectedText: 'Todos'
        });

            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function cleartext() {
    $("#odt").val("");
    $("#cve_banco").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_falla").val("0");
    $("#tipo_servicio").val("0");
    $("#tipo_subservicio").val("0");
    $("#equipo_instalado").val("0")
    $("#municipio").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#email").val("")
    $("#hora_atencion-in").val("");
    $("#hora_atencion-fin").val("")
    $("#hora_comida").val("")
    $("#hora_comida_fin").val("")
    $("#comentarios").val("");
    $("#ticket").val("");


}

function mostrarComercio(data) {
    $("#cve_banco").val(data.cve_banco)
    $("#comercio").val(data.comercio)
    $("#propietario").val(data.propietario)
    //$("#estado").val(data.estado);
    $('#estado').val(data.estadoId); //append(new Option(data.estado, data.estadoId, true, true));
    $("#responsable").val(data.responsable)
    $("#tipo_comercio").val(data.tipo_comercio);
    //$("#municipio").val(data.ciudad)
    $('#municipio').append(new Option(data.ciudad, data.ciudadId, true, true));
    $("#colonia").val(data.colonia)
    $("#afiliacion").val(data.afiliacion)
    $("#telefono").val(data.telefono)
    $("#direccion").val(data.direccion);
    $("#email").val(data.email)
    $("#hora_general").val(data.hora_general)
    $("#hora_comida").val(data.hora_comida)
    getEquipos(data.id);
}
