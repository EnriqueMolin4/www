var inventario;
$(document).ready(function() {
    ResetLeftMenuClass("submenuinventarios", "ulsubmenuinventarios", "insumoslink")
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
                    d.module = 'getInvInsumos'
                }
            },
            columns : [
                { data: 'insumoNombre'},
                { data: 'cantidad' },
                { data: 'fecha_alta' },
                { data: 'almacenNombre' },
                { data: 'id' }     
            ],
            aoColumnDefs: [
                {
                    "targets": [4],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="mostrarHistoria" data="'+data+'"><i class="fas fa-history fa-2x" style="color:#C17137"></i></a>';
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
            scrollY:        "200px",
            scrollCollapse: true,
            paging:         false,
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
                    d.module = 'getHistoricoInsumos',
                    d.noSerie = $("#noSerie").val()
                }
            },
            columns : [
                { data: 'fecha_movimiento'},
                { data: 'tipo_movimiento' },
                { data: 'insumoNombre' },
                { data: 'cantidad' },
                { data: 'ubicacionNombre' }   
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
            $("#hist-insumo").val(data.insumoNombre);
            $("#hist-desde").val(data.ubicacion);
            $("#hist-id").val(data)
            
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
           
            var dn= { module: 'traspasarinsumos', cantidad: $("#hist-cantidad").val(), 'noserie': $("#noSerie").val(), 'desde': desde, 'hacia': hacia, 'tecnico': tecnico };
            console.log(dn)
            if(desde == '1' && hacia =='1') {
                
            } else {
                if(tecnico == '0') {
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
                                $('#historia-tpv').DataTable().ajax.reload();
                                $('#example').DataTable().ajax.reload();
                                $("#showHistoria").modal("hide");
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