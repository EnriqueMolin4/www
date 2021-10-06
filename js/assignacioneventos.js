var infoAjax = 0;
var tableAsignaciones;
$(document).ready(function() {
        ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "asignacioneventoslink")
		 $.datetimepicker.setLocale('es');
        getTipoEvento();
        getSupervisores();
        getEstados();
        //getTecnicos();
        $("#fechaVen_inicio").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $(".searchEvento").on('change', function() {
            $('#assignaciones').DataTable().ajax.reload();
        })

        tableAsignaciones = $('#assignaciones').DataTable({
            "responsive": true,
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            order: [[ 6, "desc" ]],
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            ajax: {
                url: 'modelos/assignacioneventos_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable',
                    d.estatusSearch = $("#estatus_busqueda").val(),
                    d.tipoevento = $("#tipo_evento").val(),
                    d.fechaVen_inicio = $("#fechaVen_inicio").val(),
                    d.fechaVen_fin = $("#fechaVen_fin").val(),
                    d.ciudade = $("#ciudad_e").val(),
                    d.supervisores = $("#supervisores").val()
                }
            },
            columns : [
                { data: 'odt'},
                { data: 'afiliacion' },
                { data: 'NombreComercio' },
                { data: 'estatus' },
                { data: 'TipoComercio' },
                { data: 'fecha_vencimiento'},
                { data: 'cp' },
                { data: 'comercio_id' },
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
                        return '<a href="#" class="btn btn-success btnInfo" data="'+row.id+'">Detalle</a>';
                    }
                },
                {
                    "targets": [8],
                    "mRender": function ( data,type, row ) {
                        return '<div class="checkbox"> <label><input type="checkbox"></label></div>';
                    }
                }
            ]
        });

        $("#btnAsignarTecnico").on('click',function(){ 
            var alerta = '';
            var dtAsig = $("#assignaciones").DataTable();
            var data = dtAsig.rows().data();
            var total = 0;
            var error = 0;
            var datos=[];

            if( $("#tecnico_asig").val() == '0') {
                alerta += "Favor de Seleccionar un Tecnico \n";
                error++;
            } 

            $.each(data, function(index,value) {
                if( dtAsig.cell(index,8).nodes().to$().find('input').is(":checked") ) {
                    total++;

                    var valueToPush = new Object();
					valueToPush["ID"] = value.id;
                    valueToPush["ODT"] = value.odt;
                    valueToPush["Tecnico"] = $("#tecnico_asig").val();
                    datos.push(valueToPush);
                }
            })

            if(total == 0) {
                alerta += "Favor de Seleccionar Eventos para asignar \n";
                error++;
            } 
            
            if(error == 0) {
                alerta = "Se Asignaron correctamente los Eventos \n";
                $.ajax({
                    type: 'POST',
                    url: 'modelos/assignacioneventos_db.php', // call your php file
                    data: 'module=AsignarTecnicos&odt='+JSON.stringify( datos ),
                    cache: false,
                    success: function(data){
                        if(data > 0 ) {
                            tableAsignaciones.ajax.reload();
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

        $("#supervisores").on("change", function() {
            getTecnicos();
        })

        $(document).on("click",".btnInfo", function() {
            var id = $(this).attr('data');
            $("#eventoId").val(id);
            $("#showEvento").modal({show: true, backdrop: false, keyboard: false})
        })

        $('#showEvento').on('show.bs.modal', function (e) {
           
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
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
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=getevento&eventoid='+$("#eventoId").val(),
                cache: false,
                success: function(data){
                
                var info = JSON.parse(data);

                $.each(info, function(index, element) {

                        $("#odt").val(element.odt)
                        $("#afiliacion").val(element.afiliacion)
                        $("#tipo_servicio").val(element.servicioNombre);
                        $("#tipo_subservicio").val(element.subservicioNombre);
                        $("#fecha_alta").val(element.fecha_alta);
                        $("#fecha_cierre").val(element.fecha_vencimiento);
                        
                        if(element.tipo_servicio == '15') {
                        $("#comercio").val(element.cliente_vo)
                        } else {
                            $("#comercio").val(element.comercioNombre)
                        }
                        $("#receptor_servicio").val(element.receptor_servicio);
                        $("#fecha_atencion").val(element.fecha_atencion);
                        $("#colonia").val(element.colonia)
                        $("#ciudad").val(element.municipioNombre)
                        $("#estado").val(element.estadoNombre)
                        $("#direccion").val(element.direccion)
                        $("#telefono").val(element.telefono)
                        $("#descripcion").val(element.descripcion);
                        $("#hora_atencion").val(element.hora_atencion+" | "+element.hora_atencion_fin)
                        $("#hora_llegada").val(element.hora_llegada)
                        $("#hora_salida").val(element.hora_salida)
                        $("#tecnico").val(element.tecnicoNombre)
                        $("#estatus").val(element.estatusNombre)
                        $("#servicio").val(element.servicioNombre)
                        
                        $("#servicio_final").val(element.serviciofinalNombre)
                        $("#comentarios_cierre").val(element.comentarios)
                        $("#fecha_asignacion").val(element.fecha_asignacion);
                        $("#hora_comida").val(element.hora_comida+" | "+element.hora_comida_fin);
                        $("#latitud").val( element.latitud );
                        $("#longitud").val( element.longitud );
                       
                        $("#tipo_credito").val(element.tipocreditoNombre);
                        $("#afiliacion_amex").val(element.afiliacionamex);
                        $("#idamex").val(element.amex);
                        $("#idcaja").val(element.id_caja);
                        $("#tpv").val(element.tpv_instalado);
                        $("#tpv_retirado").val(element.tpv_retirado); 
                        $("#version").val(element.version);
                        $("#aplicativo").val(element.aplicativo);
                        $("#producto").val(element.producto);
                        $("#rollos_instalar").val(element.rollos_instalar);
                        $("#rollos_entregados").val(element.rollos_entregados);
                        $("#sim_instalado").val(element.sim_instalado);
                        $("#sim_retirado").val(element.sim_retirado);
                        if(element.servicio == '15') {
                            $("#labelAfiliacion").html('Folio');
                            $("#col_tipocredito").show();
                            $("#col_serviciofinal").hide();
                        } else {
                            $("#labelAfiliacion").html('Afiliacion');
                            $("#col_tipocredito").hide();
                            $("#col_serviciofinal").show();
                        }

                        if(element.tecnico =='0') {
                            $("#btnReasignarTecnico").hide();
                        } else {
                            $("#btnReasignarTecnico").show();
                        }

                        if(element.estatus == '3' || element.estatus == '1' ) {
                            $("#btnReasignarTecnico").hide();
                        } else {
                            $("#btnReasignarTecnico").show();
                        }
                        

                })           
                },
                error: function(error){
                    var demo = error;
                    alert(error)
                }
            });
       
    })

  /*       $( "#tecnico_asig" ).autocomplete({
            source: function( request, response ) {
              $.ajax( {
                url: "modelos/assignacioneventos_db.php",
                dataType: "jsonp",
                data: {
                  term: request.term,
                  module: 'buscarTecnico'
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                                      
                        return {
                            label: item.nombre+' '+item.apellidos,
                            value: item.id,
                            data : item
                        }
                    }));
                }
              } );
            },
            messages: {
                noResults: '',
                results: function() {}
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ) {
                var info = ui.item.data;
                $("#tecnico_id").val(info.id);
            }
          } ); */

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

        $(".refreshDataTable").on('change', function() {
            refreshTable();
        })

        $("#btnCargarExcelAsignaciones").on('click', function() {

             
                var form_data = new FormData();
                var excelMasivo = $("#excelMasivoAsignacion");
                var file_data = excelMasivo[0].files[0];
                form_data.append('file', file_data);
                form_data.append('module','eventoMasivoAssignacion');
                form_data.append('territorial',$("#supervisores").val());
                $.toaster({
                    message: 'Inicia la Carga de Asignacion Masiva de Eventos',
                    title: 'Aviso',
                    priority : 'success'
                }); 
                
                $("#showAvisosCargas").modal("show");
                $("#bodyCargas").html('Cargando Informacion')
        
                $.ajax({
                    type: 'POST',
                    url: 'modelos/assignacioneventos_db.php', // call your php file
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(data, textStatus, jqXHR){
                        var info = JSON.parse(data);
                        $message1 = '<h4>Se Cargaron '+info.registrosCargados+' de '+info.registrosArchivo+' Eventos </h4><br> '
                       

                        $message1 += '<h4>Las Siguientes ODT ya estan Asignadas</h4> <br>'
                        if(info.odtYaAsignadas.length > 0 ) {
                            var tec = '';
                            var odtTecnicos = info.odtYaAsignadas;
                            $.each(odtTecnicos, function(index,value) {
                                $message1 += value+"<br>";
                            })
                            
                        }

                        $message1 += '<h4>Las siguientes ODT no estan Registradas en el Sistema</h4> <br>';
                        if(info.odtNoCargadas.length > 0 ) {
                            var tec = '';
                            var odtTecnicos = info.odtNoCargadas;
                            $.each(odtTecnicos, function(index,value) {
                                $message1 += value+'<br>';
                            })
                            
                        }

                        
        
                        //alert($message1);
                    
        
                        $("#bodyCargas").html($message1)
                    
                        
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(data)
                }
                });
            
        })


        $("#estado_e").on("change", function() {
            getMunicipios();
        }) 

       


});

    
function refreshTable() {
    tableAsignaciones.ajax.reload();
}      


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

function getEstados()
{
    $.ajax({
        type: 'GET',
        url: 'modelos/assignacioneventos_db.php',
        data: 'module=getEstados',
        cache: false,
        success: function(data){
            console.log(data);
            $("#estado_e").html(data);

        },
        error: function(error)
        {
            var demo = error;
        }
    });
}

function getMunicipios()
{
    var estado = $("#estado_e").val();
    $.ajax({
        type: 'GET',
        url: 'modelos/assignacioneventos_db.php',
        data: 'module=getMunicipios&estado='+estado,
        cache: false,
        success: function(data){
            $("#ciudad_e").html(data);
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



function getTecnicos() {

    var supervisores = $("#supervisores").val();

    $.ajax({
        type: 'GET',
        url: 'modelos/assignacioneventos_db.php', // call your php file
        data: 'module=getTecnicos&supervisores='+supervisores,
        cache: true,
        success: function(data){
            console.log(data);
        $("#tecnico_asig").html(data);
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getSupervisores() {
    $.ajax({
        type: 'GET',
        url: 'modelos/assignacioneventos_db.php', // call your php file
        data: 'module=getSupervisores',
        cache: true,
        success: function(data){
            console.log(data);
        $("#supervisores").html(data);
		 getTecnicos();	
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

