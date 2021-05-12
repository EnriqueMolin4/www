<div class="row">
    <div class="col-md-5"><h3>Comercios</h3></div>
    <div class="col-md-7 text-right">
        <button class="btn btn-primary editCom" data="0" id="btnNuevoComercio" name="btnNuevoComercio">Nuevo Comercio</button></div>
</div>
<div class="row" style="border-style: solid; padding: 20px;box-shadow: 10px 10px;">
    <table id="example"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>Cve Bancaria</th>
                <th>Comercio</th>
                <th>Afiliacion</th>
                <th>Responsable</th>
                <th>Tipo Comercio</th>
                <th>Territorial Banco</th>
                <th>Territorial Sinttecom</th>
                <th>Telefono</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>Cve Bancaria</th>
                <th>Comercio</th>
                <th>Afiliacion</th>
                <th>Responsable</th>
                <th>Tipo Comercio</th>
                <th>Territorial Banco</th>
                <th>Territorial Sinttecom</th>
                <th>Telefono</th>
                <th>Accion</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="editComercio" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de Comercio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="frm" name="frm">
        <div class="row">
            <div class="col">           
                <label for="cve_banco" class="col-form-label-sm">Clave Bancaria</label>
                <select id="cve_banco" name="cve_banco" class="form-control form-control-sm">
                    <option value="0">Seleccionar</option>
                </select>
            </div>
            <div class="col">           
                <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" >
            </div>
            <div class="col">           
                <label for="comercio" class="col-form-label-sm">Comercio</label>
                <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" >
            </div>
        
        </div>
        <div class="row">
            <div class="col">           
                <label for="responsable" class="col-form-label-sm">Responsable</label>
                <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" >
            </div>
            <div class="col">           
                <label for="propietario" class="col-form-label-sm">Propietario</label>
                <input type="text" class="form-control form-control-sm" id="propietario" aria-describedby="propietario" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="cp" class="col-form-label-sm">Codigo Postal</label>
                <input type="text" class="form-control form-control-sm" id="cp" name="cp" aria-describedby="cp" >
            </div>
            <div class="col">           
                <label for="estado" class="col-form-label-sm">Estado</label>
                <select id="estado" name="estado" class="form-control form-control-sm">
                    <option value="0">Seleccionar</option>
                </select>
            </div>
            <div class="col">           
                <label for="direccion" class="col-form-label-sm">Direccion</label>
                <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" >
            </div>
        
        </div>
        <div class="row">
            <div class="col">           
                <label for="colonia" class="col-form-label-sm">Colonia</label>
                <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" >
            </div>
            <div class="col">           
                <label for="ciudad" class="col-form-label-sm">Ciudad</label>
                <select id="ciudad" name="ciudad" class="form-control form-control-sm">
                    <option value="0">Seleccionar</option>
                </select>
            </div>
            <div class="col">           
                <label for="territorial_banco" class="col-form-label-sm">Territorio Banco</label>
                <select id="territorial_banco" name="territorial_banco" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                    <option value="NORTE">NORTE</option>
                    <option value="SUR">SUR</option>
                    <option value="ESTE">ESTE</option>
                    <option value="OESTE">OESTE</option>
                    <option value="NOROESTE">NOROESTE</option>
                    <option value="SURESTE">SURESTE</option>
                </select>
            </div>
            <div class="col">           
                <label for="territorial_sinttecom" class="col-form-label-sm">Territorio Sinttecom</label>
                <input type="text" class="form-control form-control-sm" id="territorial_sinttecom" aria-describedby="territorial_sinttecom" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="rfc" class="col-form-label-sm">RFC</label>
                <input type="text" class="form-control form-control-sm" id="rfc" aria-describedby="rfc" >
            </div>
            <div class="col">           
                <label for="telefono" class="col-form-label-sm">Telefono</label>
                <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" aria-describedby="telefono" >
            </div>
            <div class="col">           
                <label for="tipo_comercio" class="col-form-label-sm">Tipo Comercio</label>
                <select id="tipo_comercio" name="tipo_comercio" class="form-control form-control-sm">
                    <option>Seleccionar</option>
                    <option value="1">NORMAL</option>
					<option value="2">VIP</option>
                </select>
            </div>
            <div class="col">           
                <label for="razon_social" class="col-form-label-sm">Razon Social</label>
                <input type="text" class="form-control form-control-sm" id="razon_social" aria-describedby="razon_social" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="email_comercio" class="col-form-label-sm">Email Comercio</label>
                <input type="email"  class="form-control form-control-sm" id="email_comercio" name="email_comercio" aria-describedby="email_comercio" >
            </div>
            <div class="col">           
                <label for="email_ejecutivo" class="col-form-label-sm">Email Ejecutivo</label>
                <input type="text" class="form-control form-control-sm" id="email_ejecutivo" aria-describedby="email_ejecutivo" >
            </div>
            <div class="col">           
                <label for="hora_comida" class="col-form-label-sm">Hora de Comida</label>
                <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" >
            </div>
            <div class="col">           
                <label for="hora_general" class="col-form-label-sm">Hora de General</label>
                <input type="text" class="form-control form-control-sm" id="hora_general" aria-describedby="hora_general" >
            </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <input type="hidden" value="0" id="comercioId">
        <button type="button" class="btn btn-primary" id="btnRegistrar">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
        getBancos();
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
                        var boton = "";
                        console.log(row.estatus)
                      if(row.activo == '1'){
                        boton = '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="delCom" data="'+data+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                      } else {
                        boton = '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="actCom" data="'+data+'"><i class="fas fa-check fa-2x" style="color:green"></i></a>';
                      }

                      return boton;
                    }
                }
            ]
        });

        var rules = {
            email_comercio:{
                required:true,
                email: true
            },
            email_ejecutivo: {
                required:true,
                email: true
            },
            telefono: {
                required:true,
                digits:true
            },
            cp: {
                required: true,
                minlength: 5,
                digits: true                
            }
        };
        var messages = {
            email_comercio:  {
                required: "Favor de poner el Email",
                email: "Favor de poner un Email Valido"
            },
            email_ejecutivo:  {
                required: "Favor de poner el Email",
                email: "Favor de poner un Email Valido"
            },
            telefono:  {
                required: "Favor de capturar un Telefono",
                digits: "Favor de poner solo numeros"
               
            },
            cp: {
                required: "Favor de poner el Codigo Postal",
                minlength: "Favor de poner un Codigo Postal valido",
                digits: "Favor de poner solo numeros"
               
            }
        };
        $("form[name='frm']").validate({
            rules: rules,
            messages: messages
        });
   

        $("#btnRegistrar").on('click', function() {
            
            if($("#frm").valid() ) {
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
                    'email_comercio' : $("#email_comercio").val(),
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
            }
        })

        $(document).on("click",".delCom", function(e) {
            e.preventDefault();
            var id = $(this).attr('data');
            
            $.ajax({
                type: 'GET',
                url: 'modelos/comercios_db.php', // call your php file
                data: { module:'delCom', id: id},
                cache: false,
                success: function(data){
                    var info = JSON.parse(data);
                    $.toaster({
                            message: 'Se deshabilito el Comercio ',
                            title: 'Aviso',
                            priority : 'warning'
                        });  
                        $('#example').DataTable().ajax.reload();            
                },
                error: function(error){
                    var demo = error;
                }
            });
            
        })

        $(document).on("click",".actCom", function(e) {
            e.preventDefault();
            var id = $(this).attr('data');
           
            $.ajax({
                type: 'GET',
                url: 'modelos/comercios_db.php', // call your php file
                data: { module:'actCom', id: id},
                cache: false,
                success: function(data){
                    var info = JSON.parse(data);
                    $.toaster({
                            message: 'Se habilito el Comercio ',
                            title: 'Aviso',
                            priority : 'success'
                        });  
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
                            getMunicipio(element.ciudad)
                            $("#responsable").val(element.responsable)
                            $("#tipo_comercio").val(element.tipo_comercio);
                            //$("#ciudad").val(element.ciudad)
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

        $("#estado").on('change', function() {
            getMunicipio('0');
        })
  });

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

function getMunicipio($estado) {
    var estado = $("#estado").val();
    $.ajax({
        type: 'GET',
        url: 'modelos/comercios_db.php', // call your php file
        data: 'module=getmunicipio&estado='+estado,
        cache: false,
        success: function(data){
            $("#ciudad").html(data); 
            $("#ciudad").val($estado);
            console.log($estado);
        },
        error: function(error){
            var demo = error;
        }
    });
}

</script> 