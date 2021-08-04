var infoAjax = 0;
var tipofallas;
$(document).ready(function() {

	ResetLeftMenuClass("submenureportes", "ulsubmenureportes", "repodtlink")
    getTipoServicio();
    getEstados();
    getEstatusServicio();
	
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

    $("#btnCargarExcel").on("click",function() {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivo");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','eventoMasivo');
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
				var info = JSON.parse(data);
                $.toaster({
                    message: 'Se Cargaron '+info.contador+' Eventos',
                    title: 'Aviso',
                    priority : 'success'
                });  
                
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus)
           }
         });
    })
	
	$("#btnCargarExcelAsignaciones").on('click', function() {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivoAsignacion");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','eventoMasivoAssignacion');
        $.toaster({
            message: 'Inicia la Carga de Asignacion Masiva de Eventos',
            title: 'Aviso',
            priority : 'success'
        }); 
        
        $("#showAvisosCargas").modal("show");
        $("#bodyCargas").html('Cargando Informacion')

        $.ajax({
            type: 'POST',
            url: 'modelos/eventos_db.php', // call your php file
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR){
                var info = JSON.parse(data);
                $message1 = "Se Cargaron "+info.registrosCargados+" de "+info.registrosArchivo+" Eventos \n";
                if(info.odtYaCargadas.length > 0 ) {
                    var tec = '';
                    var odtTecnicos = info.odtYaCargadas;
                    $.each(odtTecnicos, function(index,value) {
                        tec += value.ODT+ " Asignada a "+value.Tecnico+ " <br /> ";
                    })
                    $message1 += "Las siguientes ODT ya estan Asignadas: <br /> "+tec
                }

                //alert($message1);
               

                $("#bodyCargas").html($message1)
               
                
                
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
		getTipoSubServicio();
		var tipo = $("#tipo_servicio option:selected").text();
		if(tipo.search("INSTALACION") == 0) {
            $("#cantidad").val(20);
        } else {
            $("#cantidad").val(0);
        }
       /* if( $(this).val() == "10") {
            $("#tipo_falla").html(tipofallas);
        } else  {
            var tipo = "<option value='0'>Otro</option>";
            $("#tipo_falla").html(tipo);
        }*/
    })

    $("#btnAsignar").on('click', function() {

         
        if( $("#tipo_servicio").val() != '0' && $("#telefono").val().length > 0 && $("#hora_atencion-in").val().length > 0 && $("#hora_atencion-fin").val().length > 0 &&  $("#hora_comida").val().length > 0 &&  $("#hora_comida_fin").val().length > 0  )
        {
            $("#btnAsignar").attr('disabled',true);
            var coments = cleanWordPaste($("#comentarios").val());
            var dn= { module: 'nuevoEvento',odt: $("#odt").val(), cve_banco: $("#cve_banco").val(), afiliacion: $("#afiliacion").val(), comercio: $("#comercio").val() , 
        direccion: $("#direccion").val() , estado: $("#estado").val() , colonia: $("#colonia").val() , tipo_servicio: $("#tipo_servicio").val(), tipo_subservicio: $("#tipo_subservicio").val(), 
        tipo_falla: 0 /*$("#tipo_falla").val()*/ , equipo_instalado: $("#equipo_instalado").val() , municipio: $("#municipio").val() ,
        telefono: $("#telefono").val() , email: $("#email").val(), responsable: $("#responsable").val() , ticket: $("#ticket").val(), 
        hora_atencion: $("#hora_atencion-in").val()+"|"+$("#hora_atencion-fin").val(), hora_comida: $("#hora_comida").val()+"|"+$("#hora_comida_fin").val() , comentarios: coments,cantidad: $("#cantidad").val() };
            
            $.ajax({
                type: 'POST',
                url: 'modelos/eventos_db.php', // call your php file
                data: dn,
                cache: false,
                success: function(data){
                    $("#btnAsignar").attr('disabled',false);
                    var info = JSON.parse(data);
                    if(info.error == '0') {
                      $.toaster({
                          message: 'Error en La Captura del Evento',
                          title: 'Aviso',
                          priority : 'danger'
                      });  
                    } else {
                     cleartext();
                    $("#numODT").html('<label>SU SERVICIO HA QUEDADO REGISTRADO CON EL NO. DE ODT: </label> '+info.nuevaODT);
                    $("#odtFechaLimite").html('<label>SU FECHA Y HORA LIMITE PARA LA ATENCION ES: </label>'+info.fecha_cierre+'<br><br><label style="color:#ff0000;">FAVOR DE PROPORCIONAR AL CLIENTE ESTOS DATOS PARA SU SEGUIMIENTO</label>');            
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
		minLength: 4,
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


function cleanWordPaste( in_word_text ) {
 var tmp = document.createElement("DIV");
 tmp.innerHTML = in_word_text;
 var newString = tmp.textContent||tmp.innerText;
 // this next piece converts line breaks into break tags
 // and removes the seemingly endless crap code
 newString  = newString.replace(/\n\n/g, "<br />").replace(/.*<!--.*-->/g,"");
 // this next piece removes any break tags (up to 10) at beginning
 for ( i=0; i<10; i++ ) {
  if ( newString.substr(0,6)=="<br />" ) { 
   newString = newString.replace("<br />", ""); 
  }
 }
 return newString;
}

function getTipoServicio() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoServicios&tipo=rep',
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
        data: 'module=getTipoSubServicios&servicio_id='+$("#tipo_servicio").val(),
        cache: false,
        success: function(data){
        $("#tipo_subservicio").html(data);            
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
