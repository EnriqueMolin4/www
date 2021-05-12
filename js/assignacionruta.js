var infoAjax = 0;
$(document).ready(function() {
        ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "asignacionrutalink")
        getTipoEvento();
        $("#fechaVen_inicio").datetimepicker({
            format:'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
            format:'Y-m-d'
        });

        $(".searchEvento").on('change', function() {
            $('#assignaciones').DataTable().ajax.reload();
        })

        $('#assignaciones').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            order: [[ 6, "desc" ]],
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            ajax: {
                url: 'modelos/assignacionruta_db.php',
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
                { data: 'NombreComercio' },
                { data: 'estatus' },
                { data: 'TipoComercio' },
                { data: 'fecha_cierre'},
                { data: 'id'}
            ],
            aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "20%",
                    
                },
                {
                    "targets": [6],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="delCom"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                    }
                }
            ]
        });

      

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

        $(document).on("click",".editCom", function() {
            var id = $(this).attr('data');
            $("#eventoId").val(id);
            $("#showEvento").modal({show: true, backdrop: false, keyboard: false})
            
                $("#fecha_assignacion").datetimepicker();
        
                $("#fecha_viatico").datetimepicker({
     
                    format:'Y-m-d'
                });
        
                $("#fecha_destajo").datetimepicker({
   
                    format:'Y-m-d'
                });
        

                $.ajax({
                    type: 'GET',
                    url: 'modelos/assignacionruta_db.php', // call your php file
                    data: 'module=getevento&eventoid='+$("#eventoId").val(),
                    cache: false,
                    success: function(data){
                    
                    var info = JSON.parse(data);

                    $.each(info, function(index, element) {

                        if(element.servicio == '15') {
                            $("#contactolabel").html('Contacto por Cliente')   
                        } else {
                            $("#contactolabel").html('Contacto')   
                        }

                            $("#odt").val(element.odt)
                            $("#afiliacion").val(element.afiliacion)
                            $("#contacto").val(element.contacto);
                            $("#hora_general").val(element.hora_atencion +' | '+element.hora_atencion_fin)
                            $("#hora_comida").val(element.hora_comida)
							$("#contacto").val(element.NombreComercio);
                            $("#telefono").val(element.telefono)
                            $("#direccion").val(element.direccion);
							$("#colonia").val(element.colonia);
							$("#ciudad").val(element.municipioNombre);
							$("#estado").val(element.estadoNombre);
                            $("#fecha_alta").val(element.fecha_alta);
                            $("#fecha_cierre").val(element.fecha_cierre);
                            $("#servicio").val(element.TipoServicio)
                            $("#subservicio").val(element.Servicio)
                            $("#tipo_falla").val(element.TipoFalla)
                            $("#terminal").val(element.terminal)
                            $("#descripcion").val(element.descripcion);
                            $("#odtId").val(element.id);
                            $("#fecha_assignacion").val(element.fecha_asignacion);
                            $("#tecnico").val(element.tecnico);
                            $("#fecha_viatico").val(element.fecha_asig_viatico);
                            $("#importe_viatico").val(element.importe_viatico);
                            $("#comentarios_asig").val(element.comentarios_asig);
                            //eventoAsignado(element.fecha_asignacion);
							              getTecnicos(element.tecnico);
                            
                            
                    })           
                    },
                    error: function(error){
                        var demo = error;
                        alert(error)
                    }
                });
        })

        $('#showEvento').on('show.bs.modal', function (e) {
                
           
        })

        $('#showEvento').on('hide.bs.modal', function (e) {
           
                cleartext()
        });

        
        $(document).on("click","#btnAsignar", function() {
            if($("#tecnico").val() != '0' ) {

                var fechaViatico =  $("#fecha_viatico").val().length == 0 ? '000-00-00 00:00:00' : $("#fecha_viatico").val();
                var dnd = { module: 'grabarAsignacion',odt : $("#odt").val(),odtid : $("#odtId").val(), fechaasignacion: $("#fecha_assignacion").val(), 
                            tecnico: $("#tecnico").val(), fechaviatico: fechaViatico, importeviatico: $("#importe_viatico").val(), 
                            comentariosasig: $("#comentarios_asig").val() };

                $.ajax({
                    type: 'POST',
                    url: 'modelos/eventos_db.php', // call your php file
                    data: dnd,
                    cache: false,
                    success: function(data){
                       $('#assignaciones').DataTable().ajax.reload();
                        $.toaster({
                            message: 'La ODT '+ $("#odt").val() + ' ha sido Asignada ',
                            title: 'Assignacion',
                            priority : 'success'
                        });

                        $('#showEvento').modal('hide');
                    }
                });
            } else {
                $.toaster({
                    message: 'Falta Asignar Tecnico ',
                    title: 'Assignacion',
                    priority : 'danger'
                });
            }
            
        })

       
       


    } );

    
      


function cleartext() {
    $("#odt").val("")
    $("#afiliacion").val("")
    $("#contacto").val("");
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#fecha_alta").val("");
    $("#fecha_cierre").val("");
    $("#servicio").val("")
    $("#tipo_falla").val("")
    $("#terminal").val("")
    $("#descripcion").val("");

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

function getTecnicos(id) {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTecnicos',
        cache: true,
        success: function(data){
            console.log(data);
        $("#tecnico").html(data);
		$("#tecnico").val(id);		
        },
        error: function(error){
            var demo = error;
        }
    });
}

function eventoAsignado(fecha) {
    if(fecha.length > 0) {
        $("#fecha_assignacion").attr('disabled',true);
        $("#fecha_viatico").attr('disabled',true);
        $("#importe_viatico").attr('disabled',true);
        $("#comentarios_asig").attr('disabled',true);
        $("#tecnico").attr('disabled',true);
        $("#btnAsignar").attr('disabled',true);
    }
}

