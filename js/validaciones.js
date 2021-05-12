var infoAjax = 0;
$(document).ready(function() {
        ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "validacioneslink")
        getTipoEvento();
        $("#fechaVen_inicio").datetimepicker({
            format:'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
            format:'Y-m-d'
        });
       
        $("#txtfecha_llamada").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#txthora_llamada").datetimepicker({
            datepicker:false,
            format:'H:i'
        });

        $('#validaciones').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            ajax: {
                url: 'modelos/validaciones_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable',
                    d.estatusSearch = $("#estatus_busqueda").val(),
                    d.tipoevento = $("#tipo_evento").val(),
                    d.fechaVen_inicio = $("#fechaVen_inicio").val(),
                    d.fechaVen_fin = $("#fechaVen_fin").val()
                }
            },
            columns : [
                { data: 'odt'},
                { data: 'afiliacion' },
                { data: 'ticket' },
                { data: 'servicioNombre' },
                { data: 'fecha_vencimiento' },
                { data: 'tecnicoNombre' },
                { data: 'validacionNombre'},
                { data: 'id'}
            ],
            aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "20%",
                    
                },
                {
                    "targets": [7],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="delCom"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                    }
                }
            ]
        });

        $(".searchEvento").on('change', function() {
            $('#validaciones').DataTable().ajax.reload();
        })

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

        $(document).on("click",".editCom", function() {
            var id = $(this).attr('data');
            $("#eventoId").val(id);
            
            $("#showEvento").modal({show: true, backdrop: false, keyboard: false})
        })

        $('#showEvento').on('show.bs.modal', function (e) {
                 getStatusValidacion();
                $.ajax({
                    type: 'GET',
                    url: 'modelos/validaciones_db.php', // call your php file
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
                    url: 'modelos/validaciones_db.php', // call your php file
                    data: 'module=getevento&eventoid='+$("#eventoId").val(),
                    cache: false,
                    success: function(data){
                    
                    var info = JSON.parse(data);

                    $.each(info, function(index, element) {
                            $("#odt").val(element.odt)
                            $("#afiliacion").val(element.afiliacion)
                            $("#tipo_servicio").val(element.TipoServicio);
                            $("#tipo_subservicio").val(element.TipoSubServicio);
                            $("#fecha_alta").val(element.fecha_alta);
                            $("#fecha_cierre").val(element.fecha_cierre);
                            $("#comercio").val(element.NombreComercio)
                            $("#colonia").val(element.colonia)
                            $("#ciudad").val(element.ciudadNombre)
                            $("#estado").val(element.estadoNombre)
                            $("#direccion").val(element.direccion)
                            $("#telefono").val(element.telefono)
                            $("#descripcion").val(element.descripcion);
                            $("#fecha_llamada").val(element.fecha_llamada)
                            $("#hora_llamada").val(element.hora_llamada)
                            $("#cmbestatus").val(element.EstatusValidacion)
							$("#toque").val(element.llamadas)
                             
                            if(  $("#estatus").val() == "0" ) {
                                $("#txtfecha_llamada").prop("disabled", "disabled");
                                $("#comentarios_validacion").prop("disabled", "disabled");
                                $("#txthora_llamada").prop("disabled", "disabled");
                                $("#txthora_llamada").prop("disabled", "disabled");
                                $("#cmbestatus").prop("disabled", "disabled");
                                $("#btnValidar").prop("disabled", "disabled");
                            } else {
                                $("#txtfecha_llamada").prop("disabled", false);
                                $("#comentarios_validacion").prop("disabled", false);
                                $("#txthora_llamada").prop("disabled", false);
                                $("#txthora_llamada").prop("disabled", false);
                                $("#cmbestatus").prop("disabled", false);
                                $("#btnValidar").prop("disabled", false);
                            }
                            
                            $("#comentarios_validacion").val(element.comentarios_validacion)
                    
                    })           
                    },
                    error: function(error){
                        var demo = error;
                        alert(error)
                    }
                });
				
				
				$.ajax({
                    type: 'GET',
                    url: 'modelos/validaciones_db.php', // call your php file
                    data: 'module=gethistoriavalidacion&eventoid='+$("#eventoId").val(),
                    cache: false,
                    success: function(data){
					var info = JSON.parse(data);
					
					var tabla = "<h5>Historico Validaciones</h5><table class='table table-striped'><thead><tr><th>Estatus</th><th>Fecha de llamada</th><th>Hora de llamada</th><th>Comentarios</th></tr></thead><tbody>";
					$.each(info,function(key, value) {
						tabla += "<tr><td>"+value.Estatus+"</td><td>"+value.fecha_llamada+"</td><td>"+value.hora_llamada+"</td><td>"+value.comentarios+"</td>";
					});
					
					tabla += "</tbody></table>";
					console.log(info);
                   $("#hist-validacion").html(tabla);            
                    },
                    error: function(error){
                        var demo = error;
                    }
                });
           
        })

        $('#showEvento').on('hide.bs.modal', function (e) {
           
                cleartext()
        });

        $(document).on("click","#btnUbicacion", function() {
            $("#showUbicacion").modal({show: true, backdrop: false, keyboard: false})
        })

        $(document).on("click","#btnAsignar", function() {
            
        })

        $('#showUbicacion').on('show.bs.modal', function (e) {
           // initMap()
           var latitud = parseFloat($("#latitud").val());
           var longitud = parseFloat($("#longitud").val());
           var cliente = {lat: latitud, lng: longitud};

           var map = new google.maps.Map(document.getElementById('mapa'), {
                center: cliente,
                zoom: 8
            });

            var marker = new google.maps.Marker({position: cliente, map: map});

 
        });

        $('#showUbicacion').on('hide.bs.modal', function (e) {
           
        });

        $(document).on("click","#btnImagenes", function() {
            $("#showImagenes").modal({show: true, backdrop: false, keyboard: false});
        })

        $('#showImagenes').on('show.bs.modal', function (e) {
            mostrarImagenes($("#odt").val())

        })
        
        $(document).on('click','.showImagen', function() {
                var path = $(this).attr('data').split('|');
                var img = '<img src="'+path[1]+'" width="100%" class="imgSelected">';
                
             
                $("#btnValidarImagen").attr('data',path[0]);
                $("#imagenSel").html(img);
        })

        $(document).on('click','.btnDelImage', function() {
            var idImg = $(this).attr('data');
            $.ajax({
                type: 'GET',
                url: 'modelos/validaciones_db.php', // call your php file
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
            $("#imagenSel").html("");
            $("#carruselFotos").html("")
        });
        
        $("#btnValidarImagen").on('click', function() {
            idImg=  $(this).attr('data') ;
            
            $.ajax({
                type: 'GET',
                url: 'modelos/validaciones_db.php', // call your php file
                data: { module: 'imgValidacion',idImg: idImg },
                cache: false,
                success: function(data){
                    if(data == "1") {
                        $.toaster({
                            message: 'Se valido con exito la imagen ',
                            title: 'Aviso',
                            priority : 'success'
                        });  
                        
                    }
                }
            });
            
        })

        $("#btnValidar").on('click', function() {
            
            var eventoId = $("#eventoId").val();
            var statusVal = $("#cmbestatus").val();
            var fechaLlamada = $("#txtfecha_llamada").val();
            var horaLlamada = $("#txthora_llamada").val();
            var comentarios_validacion = $("#comentarios_validacion").val();

            var dnd = { module: 'saveValidacion', eventoid: eventoId, statusval: statusVal, fechallamada: fechaLlamada, horallamada: horaLlamada, comentariosvalidacion: comentarios_validacion  };

            $.ajax({
                type: 'GET',
                url: 'modelos/validaciones_db.php', // call your php file
                data: dnd,
                cache: false,
                success: function(data){
                    if(data != "1") {
                        $.toaster({
                            message: 'Se Actualizo El Evento ',
                            title: 'Aviso',
                            priority : 'success'
                        });  
                        cleartext();
                        $("#showEvento").modal("hide");
                    }
                }
            });

        })

        $("#btnRotarImagen").on('click', function() {
            $(".imgSelected").toggleClass('rotate-90');
        })
        
    } );

function mostrarImagenes(odt) {
    $("#carruselFotos").html('')
    $("#btnValidarImagen").data('id','0');
    $("#imagenSel").html('');
    $.ajax({
        type: 'GET',
        url: 'modelos/validaciones_db.php', // call your php file
        data: 'module=getImagenesODT&odt='+odt,
        cache: false,
        success: function(data){
            var texto = "";
            var info = JSON.parse(data);
            var locacion = window.location;
            if(info['estatus'] == '1') {
                $.each(info['imagenes'], function(index, element) {
                    
                    texto = texto + '<div class="imagewrap"><a href="#" class="showImagen" data="'+element.id+'|'+locacion.origin+'/'+element.path+'"><img src="'+locacion.origin+'/'+element.path+'" width="100%"><button class="btn btn-primary button1 btnDelImage" data= "'+element.id+'">Borrar</button></button></a></div> '

                })

                $("#carruselFotos").html(texto);
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

function getStatusValidacion() {

    $.ajax({
        type: 'GET',
        url: 'modelos/validaciones_db.php', // call your php file
        data: { module: 'getStatusValidacion' },
        cache: false,
        success: function(data){
            $("#cmbestatus").html(data);
        }
    });

}


function cleartext() {
    $("#odt").val("")
    $("#afiliacion").val("")
    $("#eventoId").val("0");
    $("#cmbestatus").val("0");
    $("#fecha_llamada").val("");
    $("#hora_llamada").val("");
    $("#txtfecha_llamada").val("");
    $("#txthora_llamada").val("");
    $("#comentarios_validacion").val("");
    $("#estatus").val("");

}

