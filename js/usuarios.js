var usuarios;
$(document).ready(function() {
       
        $("#txtfecha_llamada").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });

        $("#txthora_llamada").datetimepicker({
            datepicker:false,
            format:'H:i'
        });

        usuarios = $('#usuarios').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            ajax: {
                url: 'modelos/usuarios_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable'
                }
            },
            columns : [
                { data: 'nombre'},
                { data: 'correo' },
                { data: 'tipo_user' },
                { data: 'cve' },
                { data: 'supervisor' },
                { data: 'fecha_alta'},
                { data: 'id'}
            ],
            aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "10%",
                    
                },
                {
                    "targets": [6],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="EditUser" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="delCom"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                    }
                }
            ]
        });

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

        $(document).on("click",".EditUser", function() {
            
        })

        $('#usuarios tbody').on('click', 'tr a.EditUser', function () {
           var index = $(this).parent().parent().index() ;
           var data = usuarios.row( index ).data()
           var id = $(this).attr('data');
            $(".modal-title").html("Editar Usuario")
            $("#userId").val(id);
              
            $("#nombre").val(data.nombre)
            $("#usuario").val(data.user)
            $("#supervisor").val(data.supervisor)
            $("#tipo").find("option[text=" + data.tipo_user + "]").attr("selected", true);

            $("#showUser").modal({show: true, backdrop: false, keyboard: false})
          
        });

        $(document).on("click","#btnNewUser", function() {
            $(".modal-title").html("Nuevo Usuario")
            $("#showUser").modal({show: true, backdrop: false, keyboard: false})
        })
      
        $('#showUser').on('show.bs.modal', function (e) {
          
            $("#btnGrabarUser").on('click', function() {
                var usuario =  $("#usuario").val();
                var existUsuario = $.get('modelos/usuarios_db.php',{module: 'existeuser',usuario:usuario});
                
               var form_data = { module: 'nuevousuario',nombre: $("#nombre").val(),usuario:  $("#usuario").val(),
               supervisor: $("#supervisor").val(),tipo: $("#tipo").val(), negocio: $("#negocio").val(),
               contrasena:  $("#contrasena").val(),correo: $("#correo").val()  };

                $.ajax({
                    type: 'POST',
                    url: 'modelos/usuarios_db.php', // call your php file
                    data: form_data,
                    cache: false,
                    success: function(data, textStatus, jqXHR){
                        $.toaster({
                            message: 'Se creo Nuevo Usuario ',
                            title: 'Aviso',
                            priority : 'success'
                        });  

                        $("#showUser").modal('hide');
                        
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(data)
                   }
                 });
            })

        });

        $('#showUbicacion').on('hide.bs.modal', function (e) {
           
        });

        
    } );

    
  


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
    $("#cp").val("");
	$("#contrasena").val("");

}

