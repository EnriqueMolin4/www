var infoAjax = 0;
var tipofallas;
$(document).ready(function() {
    ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "nuevavolink")
    getTipoServicio();
    getEstados();
    getBancos('vo');
    getCreditos();
    //Create Ticket
	var d = new Date();
	var dia = d.getDate();
	var mes = d.getMonth();
	var anio = d.getFullYear().toString().substr(-2);
	var hora = d.getHours();
	var minutos = d.getMinutes();
	var segundos = d.getSeconds()
	$("#ticket").val("VO"+dia+mes+anio+hora+minutos+segundos);
	
    getTipoFallas().done(function(data) {
        tipofallas = data;
    })

    $("#hora_comida").datetimepicker({
        datepicker:false,
        format:'H:i'
    });
    
    $("#hora_comida_fin").datetimepicker({
        datepicker:false,
        format:'H:i'
    });

    $("#hora_atencion-in").datetimepicker({
        datepicker:false,
        format:'H:i'
    });
    
    $("#hora_atencion-fin").datetimepicker({
        datepicker:false,
        format:'H:i'
    });
	
	
    $("#excelMasivo").on('change', function() {
        /*var form_data = new FormData();
        var file_data = this.files[0];
        form_data.append('file', file_data);
        form_data.append('module','eventoMasivoVO');
        $.toaster({
            message: 'Inicia la Carga Masiva de Eventos',
            title: 'Aviso',
            priority : 'success'
        });  
        $.ajax({
            type: 'POST',
            url: 'modelos/eventos_db.php', // call your php file
            data: form_data,
            processData: false,
           contentType: false,
            success: function(data, textStatus, jqXHR){
                $.toaster({
                    message: 'Se Cargaron '+data+' Eventos',
                    title: 'Aviso',
                    priority : 'success'
                });  
                
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
           }
         }); */
    })

    $("#btnCargarExcel").on("click",function() {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivo");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','eventoMasivoVO');
        $.toaster({
            message: 'Inicia la Carga Masiva de Eventos',
            title: 'Aviso',
            priority : 'success'
        });  
        $.ajax({
            type: 'POST',
            url: 'modelos/eventos_db.php', // call your php file
            data: form_data,
            processData: false,
           contentType: false,
            success: function(data, textStatus, jqXHR){
                $.toaster({
                    message: 'Se Cargaron '+data+' Eventos',
                    title: 'Aviso',
                    priority : 'success'
                });  
                
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
           }
         });
    })

    $("btnNuevoEvento").on("click", function() {
        $("#newEvento").modal("show");
    })

    $("#estado").on("change", function() {
        getMunicipios();
    })

    $("#tipo_servicio").on("change", function() {
        console.log($(this).val());
        console.log(tipofallas);
        if( $(this).val() == "10") {
            $("#tipo_falla").html(tipofallas);
        } else  {
            var tipo = "<option value='0'>Otro</option>";
            $("#tipo_falla").html(tipo);
        }
    })

    $("#btnAsignar").on('click', function() {

      
        if( $("#afiliacion").val().length > 0 && $("#comercio").val().length > 0  && $("#direccion").val().length > 0 && $("#estado").val() != '0' && $("#municipio").val() != '0' &&  $("#tipo_servicio").val() != '0' && $("#telefono").val().length > 0  )
        {
            
            var dn= { module: 'nuevoEventoVO', cve_banco: $("#cve_banco").val(), afiliacion: $("#afiliacion").val(), comercio: $("#comercio").val() , 
        direccion: $("#direccion").val() , estado: $("#estado").val() , colonia: $("#colonia").val() , tipo_servicio: $("#tipo_servicio").val(), 
        tipo_falla: $("#tipo_falla").val() , equipo_instalado: $("#equipo_instalado").val() , municipio: $("#municipio").val() ,
        telefono: $("#telefono").val()  , ticket: $("#ticket").val(), 
        hora_atencion: $("#hora_atencion-in").val()+"|"+$("#hora_atencion-fin").val(), hora_comida: $("#hora_comida").val()+"|"+$("#hora_comida_fin").val() , 
        comentarios: $("#comentarios").val(), tipo_credito: $("#tipo_credito").val() };
            
            $.ajax({
                type: 'POST',
                url: 'modelos/eventos_db.php', // call your php file
                data: dn,
                cache: false,
                success: function(data){
                   
                    var info = JSON.parse(data);
                    if(info.error == '0') {
                      $.toaster({
                          message: 'Error en La Captura del Evento',
                          title: 'Aviso',
                          priority : 'danger'
                      });  
                    } else {
						
						var totalArchivos = $("#documentos")[0].files;
						console.log(totalArchivos);
						
						$.each(totalArchivos, function(index,element) {
							console.log(element);
							
							subirFotos(info.nuevaODT,element)
						});
						cleartext();
                        $("#numODT").html('<label>SU SERVICIO HA QUEDADO REGISTRADO CON EL NO. DE ODT: </label> '+info.nuevaODT);
                        $("#numFolio").html('<label>Folio: </label> '+info.folio);
						$("#showAvisos").modal("show"); 
                    }
                   
                },
                error: function(error){
                    var demo = error;
                }
            });
            
        } else {
            alert("HACEN FALTA CAMPOS POR LLENAR");
        }
    })

    $( "#buscarComercio" ).autocomplete({
        delay: 1000,
        source: function( request, response ) {
          $.ajax({
            url: "modelos/eventos_db.php",
            dataType: "json",
            data: {
              term: request.term,
              module: 'buscarComercio'
            },
            success: function( data ) {
                cleartext();
                response( $.map( data, function( item ) {
                                 
                    return {
                        label: item.comercio,
                        value: item.comercio,
                        data : item
                    }
                }));
            }
          });
        },
        messages: {
            noResults: '',
            results: function() {}
        },
        autoFocus: true,
        minLength: 2,
        select: function( event, ui ) {
            var info = ui.item.data;
            mostrarComercio(info)
            $(this).val(''); return false;
           
        }
      } );
    

        
} );

    
      function initMap() {
         
      }

function getTipoServicio() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoServicios&tipo=vo',
        cache: false,
        success: function(data){
        $("#tipo_servicio").html(data); 
        $("#tipo_servicio").val('15');             
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getBancos(tipo) {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getCveBanco&cvebanco='+tipo,
        cache: false,
        success: function(data){
        $("#cve_banco").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getCreditos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getCreditos',
        cache: false,
        success: function(data){
        $("#tipo_credito").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

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

function getEquipos() {
    var cve = $("#cve_banco").val();
    var afiliacion = $("#afiliacion").val();

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEquipos&cve_banco='+cve+"&afiliacion="+afiliacion ,
        cache: false,
        success: function(data){
        $("#equipo_instalado").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });

}

function cleartext() {
    $("#cve_banco").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
 
    $("#tipo_falla").val("0");
    $("#tipo_servicio").val("0");
    $("#equipo_instalado").val("0")
    $("#municipio").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");

    $("#hora_atencion").val("")
    $("#hora_comida").val("")
    $("#comentarios").val("")


}

function mostrarComercio(data) {
    $("#cve_banco").val(data.cve_banco)
    $("#comercio").val(data.comercio)
    $("#propietario").val(data.propietario)
    //$("#estado").val(data.estado);
    $('#estado').val(data.estadoId); //append(new Option(data.estado, data.estadoId, true, true));
   
    $("#tipo_comercio").val(data.tipo_comercio);
    //$("#municipio").val(data.ciudad)
    $('#municipio').append(new Option(data.ciudad, data.ciudadId, true, true));
    $("#colonia").val(data.colonia)
    $("#afiliacion").val(data.afiliacion)
    $("#telefono").val(data.telefono)
    $("#direccion").val(data.direccion);
   
    $("#hora_general").val(data.hora_general)
    $("#hora_comida").val(data.hora_comida)
    getEquipos();
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
