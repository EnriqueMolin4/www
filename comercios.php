<?php require("header.php"); ?>
<body>
    <div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">

                <?php include("menu.php") ?>

        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                <h2>Comercios</h2>
                <hr>
				<?php  
				if( searchMenuEdit($_SESSION['Modules'],'url','comercios') == '1') { ?>
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary editCom" data="0" id="btnNuevoComercio" name="btnNuevoComercio">Nuevo Comercio</button></div>
                </div>
				 <?php } ?>
                <br />
                <div class="row">
				
                    <table id="example"  class="table table-md table-bordered ">
                        <thead>
                            <tr>
                                <th>Banco</th>
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
                                <th>Banco</th>
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
				<input type="hidden" value="<?php echo searchMenuEdit($_SESSION['Modules'],'url','comercios'); ?>"  id="permusr">
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
                                <input type="text" class="form-control form-control-sm" id="afiliacion" name="afiliacion" aria-describedby="afiliacion" >
                            </div>
                            <div class="col">           
                                <label for="comercio" class="col-form-label-sm ">Nombre Comercio</label>
                                <input type="text" class="form-control form-control-sm cambioMay" id="comercio" aria-describedby="comercio" >
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="responsable" class="col-form-label-sm">Responsable</label>
                                <input type="text" class="form-control form-control-sm cambioMay" id="responsable" aria-describedby="responsable" >
                            </div>
                            <div class="col">           
                                <label for="propietario" class="col-form-label-sm">Propietario</label>
                                <input type="text" class="form-control form-control-sm cambioMay" id="propietario" aria-describedby="propietario" >
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
                                <label for="ciudad" class="col-form-label-sm">Ciudad</label>
                                <select id="ciudad" name="ciudad" class="form-control form-control-sm">
                                    <option value="0">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="direccion" class="col-form-label-sm">Direccion</label>
                                <input type="text" class="form-control form-control-sm cambioMay" id="direccion" name="direccion" aria-describedby="direccion" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="colonia" class="col-form-label-sm">Colonia</label>
                                <input type="text" class="form-control form-control-sm cambioMay" id="colonia" name="colonia" aria-describedby="colonia" >
                            </div>

                            <div class="col">           
                                <label for="territorial_banco" class="col-form-label-sm">Territorio Banco</label>
                                <input type="text" class="form-control form-control-sm" id="territorial_banco" name="territorial_banco" aria-describedby="territorial_banco" >

                            </div>
                            <div class="col">           
                                <label for="territorial_sinttecom" class="col-form-label-sm">Territorio Sinttecom</label>
                                <input type="text" class="form-control form-control-sm" id="territorial_sinttecom" name="territorial_sinttecom" aria-describedby="territorial_sinttecom" >
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
                                <input type="email" class="form-control form-control-sm" id="email_ejecutivo" name="email_ejecutivo" aria-describedby="email_ejecutivo" >
                            </div>
 
                        </div>
                        <div class="row">
                            <div class="col-sm-3">           
                                <label for="hora_general" class="col-form-label-sm">Horario General Inicio</label>
                                <input type="time" class="form-control form-control-sm" id="hora_general_inicio" name="hora_general_inicio" aria-describedby="hora_general" >
                            </div>
                            <div class="col-sm-3">           
                                <label for="hora_general" class="col-form-label-sm">Horario General Fin</label>
                                <input type="time" class="form-control form-control-sm" id="hora_general_fin" name="hora_general_fin" aria-describedby="hora_general" >
                            </div>
                            <div class="col-sm-3">           
                                <label for="hora_comida_inicio" class="col-form-label-sm">Hora de Comida Inicio</label>
                                <input type="time" class="form-control form-control-sm" id="hora_comida_inicio" name="hora_comida_inicio" aria-describedby="hora_comida" >
                                
                            </div>
                            <div class="col-sm-3">
                            <label for="hora_comida_fin" class="col-form-label-sm">Hora de Comida Fin</label>
                                <input type="time" class="form-control form-control-sm" id="hora_comida_fin" name="hora_comida_fin" aria-describedby="hora_comida" >
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
            </div>
        </main>
        <!-- page-content" -->
    </div>
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript">

    jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

  $(document).ready(function () {
        getBancos();
		permission();
		
		$(".cambioMay").on('change',function() {
			$(this).val($(this).val().toUpperCase());
		});
		
		
        $('#example').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            order: [[ 1, "asc" ]],
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
                { data: 'nombreBanco'},
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
                        boton += '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i>';
						if($("#permusr").val() == '1') {
						boton += '</a><a href="#" class="delCom" data="'+data+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
						}
                      } else {
                        boton = '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="actCom" data="'+data+'"><i class="fas fa-check fa-2x" style="color:green"></i></a>';
                      }
					  
					 

                      return boton;
                    }
                }
            ]
        });

        var rules = {
            cve_banco:{
                notEqual : '0'
            },
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
            },
            afiliacion: {
                required: true,
                minlength: 7,
                digits: true
            },
            direccion: {
                required:true
            },
            colonia: {
                required:true
            }
        };
        var messages = {
            cve_banco: {
                notEqual: "Favor de selecionar un Banco"
            },
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
               
            },
            afiliacion: {
                required: "Favor de llenar el campo de afiliacion",
                minlength: "Favor de poner una Afiliación valida",
                digits: "Favor de poner solo numeros"
               
            },
            direccion: {
                required: "Favor de llenar el campo de direccion"
            },
            colonia: {
                required: "Favor de llenar el campo de colonia"
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
                    'hora_general' : $("#hora_general_inicio").val() + '|' + $("#hora_general_fin").val() ,
                    'hora_comida' : $("#hora_comida_inicio").val() + '|' + $("#hora_comida_fin").val(),
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

        $("#cp").on('input', function() {

            var cp = $(this).val();
            if (cp.length > 4 && cp.length < 6) {
                getEstado(cp);
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

function getEstado(cp) {
    $.ajax({
        type: 'GET',
        url: 'modelos/comercios_db.php', // call your php file
        data: 'module=getestado&cp='+cp,
        cache: false,
        success: function(data){
            if(data.length > 0) {
                $("#estado").html(data);
                var estado = $("#estado").val();
                getMunicipio() 
            } else {
                alert('No Existe el Codigo Postal en el Sistema')
                $("#cp").val('');
            }
           
            console.log(estado);
        },
        error: function(error){
            var demo = error;
        }
    });
} 

function getMunicipio() {
    var cp = $("#cp").val();
    $.ajax({
        type: 'GET',
        url: 'modelos/comercios_db.php', // call your php file
        data: 'module=getmunicipio&cp='+cp,
        cache: false,
        success: function(data){
            var info = JSON.parse(data)
            $.each(info, function(index,value) {
                $("#ciudad").html('<option value="'+value.Id+'" selected>'+value.nombre+'</option>'); 
                $("#territorial_banco").val(value.territorial_banco); 
                $("#territorial_sinttecom").val(value.territorial_sinttecom); 
            })
           // 
            
            console.log(estado);
        },
        error: function(error){
            var demo = error;
        }
    });
}

function permission() {
	
	var perm = $("#permusr").val();
	
	if(perm == '0') {
		$("#btnRegistrar").attr('disabled',true);
		$("#cve_banco").attr('disabled',true);
		$("#cvebancaria").attr('disabled',true);
		$("#comercio").attr('disabled',true);
		$("#propietario").attr('disabled',true);
		$("#estado").attr('disabled',true);
		$("#responsable").attr('disabled',true);
		$("#tipo_comercio").attr('disabled',true);;
		$("#ciudad").attr('disabled',true);
		$("#colonia").attr('disabled',true);
		$("#afiliacion").attr('disabled',true);
		$("#telefono").attr('disabled',true);
		$("#direccion").attr('disabled',true);
		$("#rfc").attr('disabled',true);
		$("#email").attr('disabled',true);
		$("#email_ejecutivo").attr('disabled',true);
		$("#territorial_banco").attr('disabled',true);
		$("#territorial_sinttecom").attr('disabled',true);
		$("#hora_general").attr('disabled',true);
		$("#hora_comida").attr('disabled',true);
		$("#razon_social").attr('disabled',true);
		$("#cp").attr('disabled',true);
	}

}

</script> 
</body>

</html>