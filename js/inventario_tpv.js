var inventario;
$(document).ready(function() {
    ResetLeftMenuClass("submenuinventarios", "ulsubmenuinventarios", "tpvlink")
        getUbicacion();
        $("#hist-tecnico").hide();
        inventario = $('#example').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            dom: 'lfrtiBp',
            buttons: [
                'pdf',
                'excelHtml5',
                'csv'
            ],
            ajax: {
                url: 'modelos/inventarios_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getInvTpv'
                }
            },
            columns : [
                { data: 'no_serie'},
                { data: 'modeloNombre' },
                { data: 'fabricanteNombre' },
                { data: 'conectNombre' },
                { data: 'fecha_alta'},
                { data: 'ubicacionNombre' },
                { data: 'id' }     
            ],
            aoColumnDefs: [
                {
                    "targets": [6],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="mostrarHistoria" data="'+row.no_serie+'"><i class="fas fa-history fa-2x" style="color:#C17137"></i></a>';
                    }
                }
            ]
        });

        $('#historia-tpv').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            dom: 'lfrtiBp',
            buttons: [
                'pdf',
                'excelHtml5',
                'csv'
            ],
            ajax: {
                url: 'modelos/inventarios_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getHistoricoTpv',
                    d.noSerie = $("#noSerie").val()
                }
            },
            columns : [
                { data: 'fecha_movimiento'},
                { data: 'tipo_movimiento' },
                { data: 'producto' },
                { data: 'no_serie' },
                { data: 'ubicacionNombre' },
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
            
            var id = $(this).attr('data');
            var index = $(this).parent().parent().index() ;
            var data = inventario.row( index ).data()
            console.log(index)
            console.log(data)
            getTecnicos();
            $("#noSerie").val(id);

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

            $('#historia-tpv').DataTable().ajax.reload();

        });

        $("#hist-hacia").on('change', function() {
            if($(this).val() == '2') {
                $("#hist-tecnico").show();
            } else {
                $("#hist-tecnico").hide();
            }
        })

        $("#btnTraspasar").on('click', function(){
            var hacia = $("#hist-hacia").val();
            var desde = $("#hist-desde").val();
            var tecnico = $("#hist-tecnico").val();
            var dn= { module: 'traspasar', producto: $("#hist-producto").val(), 'noserie': $("#hist-noserie").val(), 'desde': desde, 'hacia': hacia, 'tecnico': tecnico };
            console.log(dn)
            if(desde == hacia ) {
                $.toaster({
                    message: 'Traspaso no Valido',
                    title: 'Aviso',
                    priority : 'warning'
                });  
            } else {
                if(tecnico == '0' && hacia != '4' ) {
                    $.toaster({
                        message:'Necesitas seleccionar un tecnico',
                        title: 'Aviso',
                        priority : 'warning'
                    }); 
                } else {
                    $.ajax({
                        type: 'GET',
                        url: 'modelos/inventarios_db.php', // call your php file
                        data: dn,
                        cache: false,
                        success: function(data){
                            var info = JSON.parse(data);
                            mensaje = "EL Traspaso se hizo con Exito"
                            if(info.id == '0') {
                                mensaje = "Fallo el Traspaso"
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
                }
            }
        })

        $("#btnCargarExcel").on("click",function() {
            var form_data = new FormData();
            var excelMasivo = $("#excelMasivo");
            var file_data = excelMasivo[0].files[0];
            form_data.append('file', file_data);
            form_data.append('module','eventoMasivo');
            $.toaster({
                message: 'Inicia la Carga Masiva de Inventarios',
                title: 'Aviso',
                priority : 'success'
            });
            
            $("#showAvisosCargas").modal("show");
            $("#bodyCargas").html('Cargando Informacion')
            $.ajax({
                type: 'POST',
                url: 'modelos/inventarios_db.php', // call your php file
                data: form_data,
                processData: false,
               contentType: false,
                success: function(data, textStatus, jqXHR){

                    var info = JSON.parse(data);
                    $message1 = "Se Cargaron "+info.registrosCargados+" de "+info.registrosArchivo+" Eventos \n";

                    $.toaster({
                        message: 'Se Cargaron '+data+' Eventos',
                        title: 'Aviso',
                        priority : 'success'
                    });  
                    
                    $("#bodyCargas").html($message1)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    
               }
             });
        })

})

function cleartext() {
    $("#cvebancaria").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_comercio").val("");
    $("#ciudad").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#rfc").val("")
    $("#email").val("")
    $("#email_ejecutivo").val("")
    $("#territorial_banco").val("")
    $("#territorial_sinttecom").val("")
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#razon_social").val("")
    $("#cp").val("")

}

function getBancos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/comercios_db.php', // call your php file
        data: 'module=getbancos',
        cache: false,
        success: function(data){
        $("#cve_banco").html(data);            
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
            console.log(data);
        $("#hist-tecnico").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getUbicacion() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getUbicacion',
        cache: false,
        success: function(data){
            console.log(data);
        $("#hist-hacia").html(data); 
        $("#hist-desde").html(data);           
        },
        error: function(error){
            var demo = error;
        }
    });
} 

//# sourceURL=js/comercios.js
//# sourceMappingURL=js/comercios.js