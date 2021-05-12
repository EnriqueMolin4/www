<?php require("header.php"); ?>

<body>
    <div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <?php include("menu.php"); ?>
        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
            <div class="row">
			<?php if( searchMenuEdit($_SESSION['Modules'],'url','registrousuarios') == '1') { ?>
                <div class="col"> 
                <label for="excelMasivo" class="col-form-label-sm">Carga Masiva Usuarios</label> 
                <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                </div>
                <div class="col">
                    <a href="layouts/Template_Masivo_Usuarios.csv" download>Template pra Carga Masiva</a>
                </div>
			<?php  } ?>
            </div>
            <table id="usuarios"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Tipo</th>
                        <th>Clave</th>
                        <th>Teritorial</th>
                        <th>Fecha Alta</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Tipo</th>
                        <th>Clave</th>
                        <th>Supervisor</th>
                        <th>Fecha Alta</th>
                        <th>Estatus</th>
                        <th>Accion</th>
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
                        <form id="frm" name="frm">
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="nombre" class="col-form-label-sm">Nombres</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" aria-describedby="nombre">
                                </div>
                                <div class="col-sm-4">           
                                    <label for="apellidos" class="col-form-label-sm">Apellidos</label>
                                    <input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos" aria-describedby="apellidos">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="correo" class="col-form-label-sm">Correo</label>
                                    <input type="text" class="form-control form-control-sm" id="correo" name="correo" aria-describedby="correo">
                                </div>
                                <div class="col-sm-4">           
                                    <label for="contrasena" class="col-form-label-sm">Contraseña</label>
                                    <input type="password" class="form-control form-control-sm" id="contrasena" name="contrasena" aria-describedby="contrasena">
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-4">           
                                    <label for="territorial" class="col-form-label-sm">Territorial</label>
                                    <select id="territorial" name="territorial" class="form-control form-control-sm">
                                        
                                    </select>
                            </div>
                            <div class="col-sm-4">           
                                    <label for="negocio" class="col-form-label-sm">Cuenta</label>
                                    <select id="negocio" name="negocio" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                            
                                    </select>
                                </div>
                                <div class="col-sm-4">           
                                    <label for="tipo" class="col-form-label-sm">Tipo Usuario</label>
                                    <select id="tipo" name="tipo" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                                       
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGrabarUser">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <script src="js/jquery.rotate.1-1.js"></script>
    <script>
    var usuarios;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "registrousuarioslink")
           // getSupervisores();
            getTerritorial();
            getTipoUser();
            getBancos();
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
                    order: [[ 0, "ASC" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
                    order: [[ 0, "desc" ]],
                    ajax: {
                        url: 'modelos/usuarios_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable'
                        }
                    },
                    columns : [
                        { data: 'Id'},
                        { data: 'nombre'},
                        { data: 'correo' },
                        { data: 'TipoUser' }, 
                        { data: 'cve' },
                        { data: 'territorial' },
                        { data: 'fecha_alta'},
                        { data: 'estatus'},
                        { data: 'Id'}
                        
                    ],
                    aoColumnDefs: [
                        {
                            "targets": [ 0 ],
                            "width": "10%",
                            
                        },
                        {
                            "targets": [ 2 ],
                            "width": "25%",
                            
                        },
                        {
                            "targets": [7],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(data == '1'){
                                    boton =  'Activo'
                                } else {
                                    boton = 'No Activo';
                            }

                                return boton;
                            }
                        },
                        {
                            "targets": [8],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(row.estatus == '1'){
                                    boton =  '<a href="#" class="EditUser" data="'+row.Id+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="DelUser" data="'+row.Id+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                                } else {
                                    boton = '<a href="#" class="EditUser" data="'+row.Id+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="AddUser" data="'+row.Id+'"><i class="fas fa-check fa-2x" style="color:green"></i></a>';
                            }

                                return boton;
                            }
                        }
                    ]
                });

                var rules = {
                    nombre:{
                        required:true,
                    },
                    apellidos: {
                        required:true,

                    },
                    correo: {
                        required: true,
                    },
                    contrasena:{
                        required:true,
                        minlength: 7,
                    },
                }

                var messages = {
                    contrasena: {
                        required: "Favor de Capturar una Contraseña",
                        minlength: "La contraseña debe contener 8 caracteres minimo"
                    },
                    nombre: {
                        required: "Favor de Capturar el Nombre",
                    },
                    apellidos: {
                        required: "Favor de Capturar los Apellidos",
                    },
                    correo: {
                        required: "Favor de Capturar el Correo Electronico",
                    }
                }



                $("#btnRegistrar").on('click', function() {
                    alert("Grabar")
                    $("#showEvento").modal("hide")
                })

            

                $('#usuarios tbody').on('click', 'tr a.EditUser', function () {
                var index = $(this).parent().parent().index() ;
                var data = usuarios.row( index ).data()
                var id = data.Id;
                    $(".modal-title").html("Editar Usuario")
                    $("#userId").val(id);
                    $("#btnGrabarUser").html('Editar');
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/usuarios_db.php', // call your php file
                        data: { module:'getUser', id: id},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                        
                            $("#nombre").val(info[0].nombre)
                            $("#apellidos").val(info[0].apellidos)
                            $("#negocio").val(info[0].cve)
                            $("#supervisor").val(info[0].supervisor)
                            $("#correo").val(info[0].correo)
                            $("#tipo").val(info[0].tipo_user);
							$("#territorial").val(info[0].territorial);

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


                $("form[name='frm']").validate({
                    rules: rules,
                    messages: messages
                });

                $("#btnGrabarUser").on('click', function() {
                    var correo = $("#correo").val();

                    var correo =  $("#correo").val();
					if( correo.length > 0 || $("#contrasena").val().length > 0 || $("#tipo").val() != '0' || $("#nombre").val().length > 0 ) {
                        var existUsuario = $.get('modelos/usuarios_db.php',{module: 'existeuser',correo:correo},function(data) {
                            var form_data = { module: 'nuevousuario',nombre: $("#nombre").val(),apellidos: $("#apellidos").val(),
                            territorial: $("#territorial").val(),tipo: $("#tipo").val(), negocio: $("#negocio").val(),
                            contrasena:  $("#contrasena").val(),correo: $("#correo").val() ,userid: $("#userId").val() };
                            var info = JSON.parse(data) ;
                            console.log(info)	
                                if( $("#userId").val() == '0'  || $("#userId").val() == '' ) {

                                    if( $("#contrasena").val().length > 0 && $("#contrasena").val().length < 9 ) {

                                        $.ajax({
                                            type: 'POST',
                                            url: 'modelos/usuarios_db.php', // call your php file
                                            data: form_data,
                                            cache: false,
                                            success: function(data, textStatus, jqXHR){
                                                usuarios.ajax.reload();
                                                $.toaster({
                                                    message: data,
                                                    title: 'Aviso',
                                                    priority : 'success'
                                                });  
                                                $("#userId").val('')
                                                $("#showUser").modal('hide');
                                                cleartext();
                                                
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert(data)
                                            }
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
                                    } else {
                                         
                                        $.toaster({
                                            message: "La Contraseña debe ser de minimo 8 caracteres",
                                            title: 'Aviso',
                                            priority : 'success'
                                        });  
                                    }
                                } else {

                                    $.ajax({
                                        type: 'POST',
                                        url: 'modelos/usuarios_db.php', // call your php file
                                        data: form_data,
                                        cache: false,
                                        success: function(data, textStatus, jqXHR){
                                            usuarios.ajax.reload();
                                            $.toaster({
                                                message: data,
                                                title: 'Aviso',
                                                priority : 'success'
                                            });  
                                            $("#userId").val('')
                                            $("#showUser").modal('hide');
                                            
                                            
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert(data)
                                        }
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

                                

                            
						}).fail(function(error) {
                            alert(error); // or whatever
                        });
                    } else {
                        $.toaster({
							message: 'Favor de Capturar los campos obligatorios *',
							title: 'Aviso',
							priority : 'warning'
						});  
                    }
                    
                    
                   /* e.preventDefault();

                    var correo =  $("#correo").val();
                    var contr = $("#contrasena").val().length;
					if( correo.length > 0 || ( $("#contrasena").val().length > 0 && $("#contrasena").val().length < 9 ) || $("#tipo").val() != '0' || $("#nombre").val().length > 0 ) {
						var existUsuario = $.get('modelos/usuarios_db.php',{module: 'existeuser',correo:correo},function(data) {
							var form_data = { module: 'nuevousuario',nombre: $("#nombre").val(),apellidos: $("#apellidos").val(),
							supervisor: $("#supervisor").val(),tipo: $("#tipo").val(), negocio: $("#negocio").val(),
							contrasena:  $("#contrasena").val(),correo: $("#correo").val() ,userid: $("#userId").val() };
							var info = JSON.parse(data) ;
							console.log(info)
						//	
						  //  if(info.existe == '0' ) {
								$.ajax({
									type: 'POST',
									url: 'modelos/usuarios_db.php', // call your php file
									data: form_data,
									cache: false,
									success: function(data, textStatus, jqXHR){
										usuarios.ajax.reload();
										$.toaster({
											message: data,
											title: 'Aviso',
											priority : 'success'
										});  
                                        $("#userId").val('')
										$("#showUser").modal('hide');
										
										
									},
									error: function(jqXHR, textStatus, errorThrown) {
										alert(data)
									}
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
						   // }


						});
					} else {
						$.toaster({
							message: 'Favor de Capturar los campos obligatorios *',
							title: 'Aviso',
							priority : 'warning'
						});  
					} */

                    
                })

                $(document).on("click","#btnNewUser", function() {
                    cleartext()
                    $(".modal-title").html("Nuevo Usuario")
                    $("#btnGrabarUser").html('Registrar');
                    $("#showUser").modal({show: true, backdrop: false, keyboard: false})
                })
            
                $('#showUser').on('show.bs.modal', function (e) {
                
                    

                });

                $('#showUbicacion').on('hide.bs.modal', function (e) {
                
                });

                $("#btnCargarExcel").on("click",function() {
                    var form_data = new FormData();
                    var excelMasivo = $("#excelMasivo");
                    var file_data = excelMasivo[0].files[0];
                    form_data.append('file', file_data);
                    form_data.append('module','masivoUsers');
                    $.toaster({
                        message: 'Inicia la Carga Masiva de Usuarios',
                        title: 'Aviso',
                        priority : 'success'
                    });  
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/usuarios_db.php', // call your php file
                        data: form_data,
                        processData: false,
                    contentType: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                message: 'Se Cargaron '+info.cantidad+' Usuarios',
                                title: 'Aviso',
                                priority : 'success'
                            });  
                            
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus)
                    }
                    });
                })
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
                    alert(textStatus)
                }
            });
        } 


        function getTerritorial() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTerritorial' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#territorial").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        } 

        function getTipoUser() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTipoUser' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#tipo").html(data);
 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function getBancos() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getBancos' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#negocio").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function cleartext() {
            $("#nombre").val("");
            $("#apellidos").val("");
            $("#contrasena").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#negocio").val("0");
            $("#correo").val("")
            $("#territorial").val("0");

        }


    </script> 
  
</body>

</html>