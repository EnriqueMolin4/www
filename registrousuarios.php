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
                <h3>Usuarios</h3>
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
            <div class="table-responsive">
                <table id="usuarios"  class="table table-responsive table-md table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">Id</th>
                            <th width="10%">Nombre</th>
                            <th width="10%">Sgs</th>
                            <th width="10%">Correo</th>
                            <th width="10%">Tipo</th>
                            <th width="10%">Plaza</th>
                            <th width="10%">Territorial</th>
                            <th width="10%">Fecha Alta</th>
                            <th width="10%">Estatus</th>
                            <th width="10%">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    
                </table>
            </div>
            
            <input type="hidden" id="userId" value="0">
            <button class="btn btn-success" id="btnNewUser">Nuevo Usuario</button>
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showUser" data-backdrop="static" data-keyboard="false">
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
                                <div class="col-sm-4">
                                    <label for="user" class="col-form-label-sm">Usuario SGS</label>
                                    <input type="text" class="form-control form-control-sm" id="user" name="user" aria-describedby="user">
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
                                <div class="col-sm-4">           
                                    <label for="tipo" class="col-form-label-sm">Tipo Usuario</label>
                                    <select id="tipo" name="tipo" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                                       
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-4" id="divTerritorial">           
                                    <label for="territorial" class="col-form-label-sm">Territorial</label><br>
                                    <select id="territorial" name="territorial" class="custom-select form-control form-control-sm" multiple>
                                        
                                    </select>
                                </div>
                                <div class="col-sm-4" id="divPlaza">           
                                    <label for="plaza" class="col-form-label-sm">Plaza</label><br>
                                    <select id="plaza" name="plaza" class="custom-select form-control form-control-sm" multiple>
                                        
                                    </select>
                                </div>
                                <div class="col-sm-4" id="divAlmacen">           
                                    <label for="almacen" class="col-form-label-sm">Almacen</label>
                                    <select id="almacen" name="almacen" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                            
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="negocio" class="col-form-label-sm">Cuenta</label><br>
                                    <select id="negocio" name="negocio" class="custom-select form-control form-control-sm" multiple>
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
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.rotate.1-1.js"></script>
    <style>
        .multiselect{
          background-color: initial;
          border: 1px solid #ced4da;
          width: 235px;
          height: auto;
      }

        .multiselect-container
        {
            height: 250px  ;  
            overflow-x: hidden;
            overflow-y: scroll; 
        }

    </style>
    <script>
    var usuarios,almacen;
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
                        { data: 'sgs'},
                        { data: 'correo' },
                        { data: 'TipoUser' }, 
                        { data: 'plazas' },
                        { data: 'territorios' },
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
                            "targets": [ 3 ],
                            "width": "25%",
                            
                        },
                        {
                            "targets": [8],
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
                            "targets": [9],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(row.estatus == '1'){
                                    boton =  '<a href="#" class="EditUser" data="'+row.Id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="DelUser" data="'+row.Id+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></i></a>';
                                } else {
                                    boton = '<a href="#" class="EditUser" data="'+row.Id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="AddUser" data="'+row.Id+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
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
                    }
                }

                var messages = {
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

                //
               

                //agregar llenado de comboBox de Almacen 
                $("#plaza").on('change', function() {
                    getAlmacen($(this).val());
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
                            console.log(info);
                            var territorios = info[0].territorios == null ? [] : info[0].territorios.split(',');
                            var plazas = info[0].plazas == null ? [] : info[0].plazas.split(',');
                            //var cve = info[0].cve == null ? [] : info[0].cve.split(',');
                            almacen = info[0].almacen;
                            $("#showUser").modal({show: true, backdrop: false, keyboard: false}) 
                            
                            $("#nombre").val(info[0].nombre)
                            $("#apellidos").val(info[0].apellidos)
                            $("#user").val(info[0].sgs)
                           // $("#negocio").val(info[0].cve)
                            $("#supervisor").val(info[0].supervisor)
                            $("#correo").val(info[0].correo)
                            $("#tipo").val(info[0].tipo_user);
                            $("#territorial").val(territorios);
                            $("#territorial").multiselect('rebuild');
                            $("#almacen").val(almacen)
                            getPlazaxTerritorial(JSON.stringify(territorios) )
                           // $("#plaza").val(plazas);
                           // $("#plaza").multiselect('rebuild');
                            //getAlmacen( plazas );

                            
        
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



                $("#btnGrabarUser").on('click', function() 
                {
                    var correo = $("#correo").val();
                    var isNew = 1;

                    if( $("#userId").val() == '0' ) 
                    {
                        $("form[name='frm']").validate({
                            rules: rules,
                            messages: messages
                        });

                        if ( $("#contrasena").val().length > 0 ) 
                        {
                            isNew = 1;
							
                        } 
						else 
						{
                            
							isNew = 0;
                        }
                    }
					
                    if( isNew == 1 && correo.length > 0 && isNew > 0 && $("#tipo").val() != '0' && $("#nombre").val().length > 0  && $("#negocio").val().length > 0 && $("#almacen").val()  != '0' ) 
                    {
                        var existUsuario = $.get('modelos/usuarios_db.php',{module: 'existeuser',correo:correo},function(data) 
                        {
                            var form_data = { module: 'nuevousuario',
											  nombre: $("#nombre").val(),
											  apellidos: $("#apellidos").val(),
											  territorial: JSON.stringify( $("#territorial").val() ),
											  tipo: $("#tipo").val(), 
											  negocio: JSON.stringify( $("#negocio").val() ),
											  contrasena:  $("#contrasena").val(),
											  correo: $("#correo").val() ,
											  userid: $("#userId").val(), 
											  plaza: JSON.stringify( $("#plaza").val() ),
											  almacen: $("#almacen").val(), 
											  user: $("#user").val()  };

                            var info = JSON.parse(data) ;
 

                                if( $("#userId").val() == '0'  || $("#userId").val() == '' ) 
                                {

                                    if( $("#contrasena").val().length > 0 ) 
                                    {

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
                                                $("#user").val(element.user);
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
                                            $("#user").val(element.user);
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
                    } 
					*/

                    
                })

                $(document).on("click","#btnNewUser", function() {
                    cleartext()
                    $(".modal-title").html("Nuevo Usuario")
                    $("#btnGrabarUser").html('Registrar');
                    $("#showUser").modal({show: true, backdrop: false, keyboard: false})
                })

                $("#territorial").on("change", function () {
                    getPlazaxTerritorial( JSON.stringify($(this).val()) );
                     
                })
            
                $('#showUser').on('show.bs.modal', function (e) {
                
                    if($("#userId").val() == '0' ) {

                        getPlazaxTerritorial(JSON.stringify($("#territorial").val()) );

                        $.ajax({
                            type: 'POST',
                            url: 'modelos/usuarios_db.php', // call your php file
                            data: { module: 'getBancosUser'}
                        }).done(function(data) {
                            var plazas = data;
                            $("#negocio").html(data);
                            $("#negocio").multiselect('refresh');
                            
                        });
                    }

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
                data: { module: 'getTerritorial' }
            }).done(function(data) {

                $("#territorial").html(data);
                $("#territorial").multiselect({
                    includeSelectAllOption: true,
                    selectAllText: 'Todos',
                    nonSelectedText: 'Ninguno Seleccionado',
                    maxHeight: 200 
                }); 
                    
            });
        }
        
        function getPlazaxTerritorial(ter) {
            tecnico = $("#userId").val();
           
            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTerritorioPlazas','territorio': ter,'usr' : tecnico   },
            }).done(function(data) {
                var plazas = JSON.parse(data);
                var combos = '';
                $val = '<option value="0">Seleccionar</option>';

                $.each(plazas, function(index,element) {

                    var selected = element.tecnico_id == '0' ? '' : 'selected';

                    combos +=  "<option value='"+element.plaza_id+"' "+selected+">"+element.nombre+"</option>";

                })
                
                $("#plaza").html(combos);
                $("#plaza").multiselect({  maxHeight: 200 });
                $("#plaza").multiselect('rebuild');

                $.ajax({
                    type: 'POST',
                    url: 'modelos/usuarios_db.php', // call your php file
                    data: { module: 'getBancosUser'}
                }).done(function(data) {
                    var plazas = data;
                    $("#negocio").html(data);
                    $("#negocio").multiselect('refresh');

                    $.ajax({
                        type: 'POST',
                        url: 'modelos/usuarios_db.php', // call your php file
                        data: { module: 'getAlmacen','plaza': JSON.stringify( $("#plaza").val() ) },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            
                            $("#almacen").html(data);
                            $("#almacen").val(almacen);

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus)
                        }
                    });
                });
            });

            

        }

        function getTerritorioPlazas(tecnico) {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTerritorioPlazas', 'tecnico': tecnico  },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    var info = JSON.parse(data);

                    $("#territorial").val(info);
                    $("#territorial").multiselect('refresh');

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

        

        function getPlazas() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getPlazas' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#plaza").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function getAlmacen(plaza) {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getAlmacen','plaza': JSON.stringify(plaza) },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#almacen").html(data);

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
                data: { module: 'getBancosUser'},
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#negocio").html(data);
                    $("#negocio").multiselect({ 
                        includeSelectAllOption: true,
                        selectAllText: 'Todos',
                        maxHeight: 100 
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        

        function cleartext() {
            $("#nombre").val("");
            $("#apellidos").val("");
			$("#user").val("");
            $("#contrasena").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#negocio").val("0");
			$("#negocio").multiselect('refresh');
            $("#correo").val("")
            $("#territorial").val("0");
            $("#territorial").multiselect('refresh');
            $("#plaza").val("0");
			$("#plaza").multiselect('refresh');

        }


    </script> 
  
</body>

</html>