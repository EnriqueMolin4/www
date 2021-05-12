<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    <table id="usuarios"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo</th>
                <th>Clave</th>
                <th>Supervisor</th>
                <th>Fecha Alta</th>
                <th>Accion</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo</th>
                <th>Clave</th>
                <th>Supervisor</th>
                <th>Fecha Alta</th>
                <th>Accion</th>
                <th>Estatus</th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" id="userId" value="0">
    <button class="btn btn-success" id="btnNewUser">Nuevo Usuario</button>
</div>
<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="showUser">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-sm-4">           
                <label for="nombre" class="col-form-label-sm">Nombres</label>
                <input type="text" class="form-control form-control-sm" id="nombre" aria-describedby="nombre">
            </div>
            <div class="col-sm-4">           
                <label for="apellidos" class="col-form-label-sm">Apellidos</label>
                <input type="text" class="form-control form-control-sm" id="apellidos" aria-describedby="apellidos">
            </div>
            <div class="col-sm-4">           
                <label for="correo" class="col-form-label-sm">Correo</label>
                <input type="text" class="form-control form-control-sm" id="correo" aria-describedby="correo">
            </div>
            <div class="col-sm-4">           
                <label for="usuario" class="col-form-label-sm">Usuario</label>
                <input type="text" class="form-control form-control-sm" id="usuario" aria-describedby="usuario">
            </div>
            <div class="col-sm-4">           
                <label for="contrasena" class="col-form-label-sm">Contraseña</label>
                <input type="password" class="form-control form-control-sm" id="contrasena" aria-describedby="contrasena">
            </div>
        </div>
        <div class="row">
        <div class="col-sm-4">           
                <label for="supervisor" class="col-form-label-sm">Supervisor</label>
                <select id="supervisor" name="supervisor" class="form-control form-control-sm">
                    
                </select>
            </div>
        <div class="col-sm-4">           
                <label for="negocio" class="col-form-label-sm">Negocio</label>
                <select id="negocio" name="negocio" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                    <option value="001">Demo</option>
                    <option value="037">Santander</option>
                    <option value="099">EPayments</option>
                </select>
            </div>
            <div class="col-sm-4">           
                <label for="tipo" class="col-form-label-sm">Tipo Usuario</label>
                <select id="tipo" name="tipo" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                    <option value="1">supervisor</option>
                    <option value="2">almacen</option>
                    <option value="3">tecnico</option>
                    <option value="4">callcenter</option>
                    <option value="5">pdf</option>
                    <option value="6">Epayments</option>
                    <option value="7">admin</option>
                    <option value="8">user</option>
                </select>
            </div>
        </div>
   
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnGrabarUser">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var usuarios;
$(document).ready(function() {
    getSupervisores();
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
                { data: 'TipoUser' }, 
                { data: 'cve' },
                { data: 'supervisor' },
                { data: 'fecha_alta'},
                { data: 'Id'},
                { data: 'estatus'}
            ],
            aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "10%",
                    
                },
                {
                    "targets": [6],
                    "mRender": function ( data,type, row ) {
                        var boton = "";
                        console.log(row.estatus)
                      if(row.estatus == '1'){
                            boton =  '<a href="#" class="EditUser" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="DelUser" data="'+data+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                        } else {
                            boton = '<a href="#" class="EditUser" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="AddUser" data="'+data+'"><i class="fas fa-check fa-2x" style="color:green"></i></a>';
                       }

                        return boton;
                    }
                },
                {
                    "targets": [ 7 ],
                    "visible": false,
                    
                }
            ]
        });

        $("#btnRegistrar").on('click', function() {
            alert("Grabar")
            $("#showEvento").modal("hide")
        })

    

        $('#usuarios tbody').on('click', 'tr a.EditUser', function () {
           var index = $(this).parent().parent().index() ;
           var data = usuarios.row( index ).data()
           var id = $(this).attr('data');
            $(".modal-title").html("Editar Usuario")
            $("#userId").val(id);
             
            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module:'getUser', id: id},
                cache: false,
                success: function(data, textStatus, jqXHR){
                    var info = JSON.parse(data);
                   
                    $("#nombre").val(info[0].nombre)
                    $("#apellidos").val(info[0].apellidos)
                    $("#usuario").val(info[0].user)
                    $("#negocio").val(info[0].cve)
                    $("#supervisor").val(info[0].supervisor)
                    $("#correo").val(info[0].correo)
                    $("#tipo").val(info[0].tipo_user);

                    $("#showUser").modal({show: true, backdrop: false, keyboard: false}) 
  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
               }
             });
          
        });

        $('#usuarios tbody').on('click', 'tr a.DelUser', function () {
           var index = $(this).parent().parent().index() ;
           var data = usuarios.row( index ).data()
           var id = $(this).attr('data');
             console.log(id);
            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module:'delUser', id: id},
                cache: false,
                success: function(data, textStatus, jqXHR){
                    var info = JSON.parse(data);
                    $.toaster({
                            message: 'Se deshabilito el Usuario ',
                            title: 'Aviso',
                            priority : 'success'
                        });  
                    usuarios.ajax.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
               }
             });
          
        });

        $('#usuarios tbody').on('click', 'tr a.AddUser', function () {
           var index = $(this).parent().parent().index() ;
           var data = usuarios.row( index ).data()
           var id = $(this).attr('data');
             console.log(id);
            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module:'addUser', id: id},
                cache: false,
                success: function(data, textStatus, jqXHR){
                    var info = JSON.parse(data);
                    $.toaster({
                            message: 'Se habilito el Usuario  ',
                            title: 'Aviso',
                            priority : 'danger'
                        });  
                    usuarios.ajax.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
               }
             });
          
        });

        $("#btnGrabarUser").on('click', function(e) {
            e.preventDefault();

            var usuario =  $("#usuario").val();
            var existUsuario = $.get('modelos/usuarios_db.php',{module: 'existeuser',usuario:usuario},function(data) {
            var form_data = { module: 'nuevousuario',nombre: $("#nombre").val(),apellidos: $("#apellidos").val(),usuario:  $("#usuario").val(),
            supervisor: $("#supervisor").val(),tipo: $("#tipo").val(), negocio: $("#negocio").val(),
            contrasena:  $("#contrasena").val(),correo: $("#correo").val()  };
            var info = JSON.parse(data) ;
             console.log(info)
          
            if(info.existe == '0' ) {
                $.ajax({
                    type: 'POST',
                    url: 'modelos/usuarios_db.php', // call your php file
                    data: form_data,
                    cache: false,
                    success: function(data, textStatus, jqXHR){
                        usuarios.ajax.reload();
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
            } else {
                $.toaster({
                            message: 'El Usuario ya Existe ',
                            title: 'Aviso',
                            priority : 'warning'
                });
               $.each(info.usuario,function(index,element) {
                   console.log(element);
                    $("#nombre").val(element.nombre);
                    $("#apellidos").val(element.apellidos);
                    $("#usuario").val(element.user);
                    $("#supervisor").val(element.supervisor);
                    $("#tipo").val(element.tipo_user);
                    $("#negocio").val(element.cve);
                    $("#correo").val(element.correo)
               })
            }


            });

            
        })

        $(document).on("click","#btnNewUser", function() {
            $(".modal-title").html("Nuevo Usuario")
            $("#showUser").modal({show: true, backdrop: false, keyboard: false})
        })
      
        $('#showUser').on('show.bs.modal', function (e) {
          
            

        });

        $('#showUbicacion').on('hide.bs.modal', function (e) {
           
        });

        
    } );

    
function getSupervisores() {

    $.ajax({
        type: 'POST',
        url: 'modelos/usuarios_db.php', // call your php file
        data: { module: 'getSupervisores' },
        cache: false,
        success: function(data, textStatus, jqXHR){
            
            $("#supervisor").html(data);
            
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(data)
        }
    });
} 


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


</script> 