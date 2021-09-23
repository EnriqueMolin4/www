        getBancos();
		
		$("#comercio").on('change',function() {
			$(this).val($(this).val().toUpperCase());
		})
		
        $('#example').DataTable({
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
                url: 'modelos/comercios_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable'
                }
            },
            columns : [
                { data: 'cve_banco'},
                { data: 'comercio' },
                { data: 'afiliacion' },
                { data: 'responsable' },
                { data: 'TipoComercio' },
                { data: 'territorial_banco'},
                { data: 'territorial_sinttecom'},
                { data: 'telefono'},
                { data: 'id'}   
            ],aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "10%",
                    
                },
                {
                    "targets": [8], 
                    "mRender": function ( data,type, row ) {    
                        return '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:#187CD0;"></i></a><a href="#" class="delCom"><i class="fas fa-times fa-2x" style="color:#F5425D;"></i></a>';
                    }
                }
            ]
        });

        $("#btnRegistrar").on('click', function() {

            var data = { 
                'module' : 'grabarComercio',
                'comercioid': $("#comercioId").val(),
                'cve_banco': $("#cve_banco").val(),
                'comercio': $("#comercio").val() ,
                'propietario' : $("#propietario").val(),
                'estado' : $("#estado").val(),
                'responsable' : $("#responsable").val(),
                'tipo_comercio' : $("#tipo_comercio").val(),
                'ciudad' : $("#ciudad").val(),
                'colonia' : $("#colonia").val(),
                'afiliacion' : $("#afiliacion").val(),
                'telefono' : $("#telefono").val(),
                'direccion' : $("#direccion").val(),
                'rfc' : $("#rfc").val(),
                'email' : $("#email").val(),
                'email_ejecutivo' : $("#email_ejecutivo").val(),
                'territorial_banco' : $("#territorial_banco").val(),
                'territorial_sinttecom' : $("#territorial_sinttecom").val(),
                'hora_general' : $("#hora_general").val(),
                'hora_comida' : $("#hora_comida").val(),
                'razon_social' : $("#razon_social").val(),
                'cp': $("#cp").val()
            }

            $.ajax({
                type: 'GET',
                url: 'modelos/comercios_db.php', // call your php file
                data: data,
                cache: false,
                success: function(data){
                    var info = JSON.parse(data)
                    mensaje = "Se ha creado con Exito el Comercio"
                    if(info.id == '0') {
                        mensaje = "Se Modifico con Exito el Comercio"
                    }

                    $.toaster({
                        message: mensaje,
                        title: 'Aviso',
                        priority : 'success'
                    }); 

                    $("#editComercio").modal("hide") 
                    $('#example').DataTable().ajax.reload();          
                },
                error: function(error){
                    var demo = error;
                }
            });
           
        })

        $(document).on("click",".editCom", function() {
            var id = $(this).attr('data');
            $("#comercioId").val(id);
            $("#editComercio").modal("show")
        })

        $('#editComercio').on('show.bs.modal', function (e) {
            cleartext()
            var comercioId = $("#comercioId").val();
            $.ajax({
                type: 'GET',
                url: 'modelos/comercios_db.php', // call your php file
                data: 'module=getstados',
                cache: false,
                success: function(data){
                   $("#estado").html(data);            
                },
                error: function(error){
                    var demo = error;
                }
            });

            if(comercioId == '0') {
                $(this).find(".modal-title").text("Nuevo Comercio");
            } else {
                $(this).find(".modal-title").text("Editar Comercio");
                $.ajax({
                    type: 'GET',
                    url: 'modelos/comercios_db.php', // call your php file
                    data: 'module=getcomercio&comercioid='+$("#comercioId").val(),
                    cache: false,
                    success: function(data){
                    
                    var info = JSON.parse(data);

                    $.each(info, function(index, element) {
                            $("#cve_banco").val(element.cve_banco)
                            $("#comercio").val(element.comercio)
                            $("#propietario").val(element.propietario)
                            $("#estado").val(element.estado);
                            $("#responsable").val(element.responsable)
                            $("#tipo_comercio").val(element.tipo_comercio);
                            $("#ciudad").val(element.ciudad)
                            $("#colonia").val(element.colonia)
                            $("#afiliacion").val(element.afiliacion)
                            $("#telefono").val(element.telefono)
                            $("#direccion").val(element.direccion);
                            $("#rfc").val(element.rfc)
                            $("#email").val(element.email)
                            $("#email_ejecutivo").val(element.email_ejecutivo)
                            $("#territorial_banco").val(element.territorial_banco)
                            $("#territorial_sinttecom").val(element.territorial_sinttecom)
                            $("#hora_general").val(element.hora_general)
                            $("#hora_comida").val(element.hora_comida)
                            $("#razon_social").val(element.razon_social)
                            $("#cp").val(element.cp)

                    })           
                    },
                    error: function(error){
                        var demo = error;
                        alert(error)
                    }
                });
            }
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

  

//# sourceURL=js/comercios.js
//# sourceMappingURL=js/comercios.js