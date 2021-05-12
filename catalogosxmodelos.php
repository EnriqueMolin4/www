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
            <div class="page-title">
                <h3>MODELOS TPV</h3>
            </div>
            <div class="container-fluid p-4">
            <div class="row p-2">
                <button class="btn btn-success" id="btnNewModel">Nuevo Modelo</button>
            </div><br>
			<div class="row panel-white p-4">
                <div class="table-responsive">
                    <table id="modelos"  class="table table-md table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="200px">ID</th>
                        <th width="200px">MODELO</th>
                        <th width="200px">PROVEEDOR</th>
                        <th width="200px">CONECTIVIDAD</th>
                        <th width="200px">NO. LARGO</th>
                        <th width="200px">CLAVE BANCO</th>
                        <th width="200px">ESTATUS</th>
                        <th width="200px">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th width="200px">ID</th>
                        <th width="200px">MODELO</th>
                        <th width="200px">PROVEEDOR</th>
                        <th width="200px">CONECTIVIDAD</th>
                        <th width="200px">NO. LARGO</th>
                        <th width="200px">CLAVE BANCO</th>
                        <th width="200px">ESTATUS</th>
                        <th width="200px">ACCION</th>
                    </tr>
                </tfoot>
            </table>
                </div>
            
            <input type="hidden" id="modelId" value="0">
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showModel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">NUEVO MODELO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!-- MODAL PARA AGREGAR/EDITAR UN NUEVO EVENTO -->
                        <form id="frm" name="frm">
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="modelo" class="col-form-label-sm">MODELO</label>
                                    <input type="text" class="form-control form-control-sm" id="modelo" name="modelo" aria-describedby="modelo">
                                </div>

                                <div class="col-sm-4">           
                                    <label for="proveedor" class="col-form-label-sm">PROVEEDOR</label>
                                    <select id="proveedor" name="proveedor" class="form-control form-control-sm" required>
                                        <option value="0">Seleccionar</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">           
                                    <label for="conectividad" class="col-form-label-sm">CONECTIVIDAD</label>
                                    <select name="conectividad" id="conectividad" class="form-control form-control-sm">
                                     
                                    </select>
                                </div>     

                            </div> 
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="no_largo" class="col-form-label-sm">NO LARGO</label>
                                    <input value="0" type="text" class="form-control form-control-sm" id="no_largo" name="no_largo">
                                </div>
                                <div class="col-sm-4">           
                                    <label for="clave_elavon" class="col-form-label-sm">CLAVE BANCO</label>
                                    <input value="0" type="text" class="form-control form-control-sm" id="clave_elavon" name="clave_elavon">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGrabarModel">Registrar</button>
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
    var modelos;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "catalogoxmodeloslink")
            getProveedor();
            getConectividad();       

                modelos = $('#modelos').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "ASC" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
                    order: [[ 0, "desc" ]],
                    ajax: {
                        url: 'modelos/catalogosxmodelos_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable'
                        }
                    },
                    columns : [
                        { data: 'Id'},
                        { data: 'modelo'},
                        { data: 'proveedor' },
                        { data: 'conectividad' }, 
                        { data: 'no_largo' },
                        { data: 'clave_elavon' },
                        { data: 'estatus'}
                        //{ data: 'id'}
                        
                    ],
                    aoColumnDefs: [
                        
                        {
                            "targets": [6],
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
                            "targets": [7],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(row.estatus == '1'){
                                    boton =  '<a title="Desactivar" href="#" class="EditModel" data="'+row.Id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="DelModel" data="'+row.Id+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
                                } else {
                                    boton = '<a title="Activar" href="#" class="EditModel" data="'+row.Id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="AddModel" data="'+row.Id+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                            }

                                return boton;
                            }
                        }
                    ]
                });

                var rules = {
                    modelo:{
                        required:true,
                    },
                    proveedor: {
                        required:true,

                    },
                    conectividad: {
                        required: true,
                    },
    
                }

                var messages = {
                   
                    modelo: {
                        required: "Favor de apturar el Modelo",
                    },
                     proveedor: {
                        required: "Favor de seleccionar proveedor",
                    },
                    conectividad: {
                        required: "Favor de seleccionar conectividad",
                    }
                    
                }


                

                $("#btnRegistrar").on('click', function() {
                    alert("Grabar")
                    $("#showModel").modal("hide")
                })

            

                $('#modelos tbody').on('click', 'tr a.EditModel', function () {
                    var index = $(this).parent().parent().index() ;
                    var data = modelos.row( index ).data();
                    var id = data.Id;
                    $(".modal-title").html("EDITAR MODELO")
                    $("#modelId").val(id);
                    $("#btnGrabarModel").html('Editar');
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/catalogosxmodelos_db.php', // call your php file
                        data: { module:'getModel', id: id},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                        
                            $("#modelo").val(info[0].modelo) 
                            $("#proveedor").val(info[0].proveedor)
                            $("#conectividad").val(info[0].conectividad)
                            $("#no_largo").val(info[0].no_largo)
                            $("#clave_elavon").val(info[0].clave_elavon)
                            $("#showModel").modal({show: true, backdrop: false, keyboard: false}) 
        
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                    }
                    });
                
                });

                $('#modelos tbody').on('click', 'tr a.DelModel', function () {
                    var index = $(this).parent().parent().index() ;
                    var data = modelos.row( index ).data()
                    var id = $(this).attr('data');
                    console.log(id);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/catalogosxmodelos_db.php', // call your php file
                        data: { module:'delModel', id: id},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                    message: 'Se deshabilitó el Modelo ',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                            modelos.ajax.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                    }
                    });
                
                });

                $('#modelos tbody').on('click', 'tr a.AddModel', function () {
                    var index = $(this).parent().parent().index() ;
                    var data = modelos.row( index ).data()
                    var id = $(this).attr('data');
                    console.log(id);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/catalogosxmodelos_db.php', // call your php file
                        data: { module:'addModel', id: id},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                    message: 'Se habilitó el Modelo  ',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                            modelos.ajax.reload();
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
               

                $("#btnGrabarModel").on('click', function() {

                    var modelo =  $("#modelo").val();
                    
                    
					if(  $("#modelo").val().length > 0) 
                    {
                        var existModelo = $.get('modelos/catalogosxmodelos_db.php',{
                            module: 'existemodel',
                            modelo:modelo},
                            function(data) {
                            var form_data = 
                            {
                                 module: 'nuevomodelo',
                                 modelo: $("#modelo").val(),
                                 proveedor: $("#proveedor").val(),
                                 conectividad: $("#conectividad").val(),
                                 no_largo:  $("#no_largo").val(),
                                 clave_elavon: $("#clave_elavon").val(),
                                 modelid: $("#modelId").val()
                            };

                            var info = JSON.parse(data) ;

                            console.log(info)	
                                if( $("#modelId").val() == '0'  || $("#modelId").val() == '' ) 
                                {

                                    if( $("#proveedor").val() != '0') 
                                    {

                                        if( $("#conectividad").val() != '0') 
                                        {
                                            $.ajax({
                                            type: 'POST',
                                            url: 'modelos/catalogosxmodelos_db.php', // call your php file
                                            data: form_data,
                                            cache: false,
                                            success: function(data, textStatus, jqXHR)
                                            {
                                                modelos.ajax.reload();
                                                $.toaster({
                                                    message: data,
                                                    title: 'Aviso',
                                                    priority : 'success'
                                                });  
                                                $("#modelId").val('')
                                                $("#showModel").modal('hide');
                                                cleartext();
                                                
                                            },
                                                error: function(jqXHR, textStatus, errorThrown) {
                                                    alert(data)
                                                }
                                            });

                                            $.each(info.modelo,function(index,element) {
                                                console.log(element);
                                                    $("#modelo").val(element.modelo);
                                                    $("#proveedor").val(element.proveedor);
                                                    $("#conectividad").val(element.conectividad);
                                                    $("#no_largo").val(element.supervisor);
                                                    $("#clave_elavon").val(element.clave_elavon)
                                            })
                                        }
                                        else
                                        {
                                            $.toaster({
                                            message: "Debes elegir Tipo de Conectividad",
                                            title: 'Aviso',
                                            priority : 'warning'
                                            });  
                                        }

                                        
                                    } else {
                                         
                                        $.toaster({
                                            message: "Debes elegir El Proveedor",
                                            title: 'Aviso',
                                            priority : 'warning'
                                        });  
                                    }
                                } else {

                                    $.ajax({
                                        type: 'POST',
                                        url: 'modelos/catalogosxmodelos_db.php', // call your php file
                                        data: form_data,
                                        cache: false,
                                        success: function(data, textStatus, jqXHR){
                                            modelos.ajax.reload();
                                            $.toaster({
                                                message: data,
                                                title: 'Aviso',
                                                priority : 'success'
                                            });  
                                            $("#modelId").val('')
                                            $("#showModel").modal('hide');
                                            
                                            
                                            
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert(data)
                                        }
                                    });

                                    $.each(info.modelo,function(index,element) {
                                        console.log(element);
                                            $("#modelo").val(element.modelo);
                                            $("#no_largo").val(element.no_largo);                                           
                                            $("#proveedor").val(element.proveedor);
                                            $("#clave_elavon").val(element.clave_elavon);
                                            $("#conectividad").val(element.conectividad);
                                    })
                                }

                                

                            
						}).fail(function(error) {
                            alert(error); // or whatever
                        });
                    } else {
                        $.toaster({
							message: 'Favor De Ingresar El Modelo',
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
							contrasena:  $("#contrasena").val(),correo: $("#correo").val() ,modelid: $("#modelId").val() };
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
                                        $("#modelId").val('')
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

                $(document).on("click","#btnNewModel", function() 
                {
                    cleartext();
                    $(".modal-title").html("NUEVO MODELO DE TPV");

                    $("#btnGrabarModel").html('Registrar');


                    $("#no_largo").val("0");
                    
                    $("#showModel").modal({show: true, backdrop: false, keyboard: false})
                })
            
                $('#showModel').on('show.bs.modal', function (e) {
                
                    

                });

                $("#btnCargarExcel").on("click",function() {
                    var form_data = new FormData();
                    var excelMasivo = $("#excelMasivo");
                    var file_data = excelMasivo[0].files[0];
                    form_data.append('file', file_data);
                    form_data.append('module','masivoUsers');
                    $.toaster({
                        message: 'Inicia la Carga Masiva de Modelos',
                        title: 'Aviso',
                        priority : 'success'
                    });  
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/catalogosxmodelos_db.php', // call your php file
                        data: form_data,
                        processData: false,
                    contentType: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                message: 'Se Cargaron '+info.cantidad+' Modelos',
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

        function getProveedor() { /* Obtención del proveedor para Modelos */

            $.ajax({
                type: 'POST',
                url: 'modelos/catalogosxmodelos_db.php', // call your php file
                data: { module: 'getProveedor' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#proveedor").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        } 

        function getConectividad() {/* Obtención del conectividad para Modelos */

            $.ajax({
                type: 'POST',
                url: 'modelos/catalogosxmodelos_db.php', // call your php file
                data: { module: 'getConectividad' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#conectividad").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function cleartext() { /* Función que limpia los campos del formulario */
            $("#modelo").val("");
            $("#no_largo").val("");
            $("#clave_elavon").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#conectividad").val("0");
            $("#correo").val("")
            $("#proveedor").val("0");

        }


    </script> 
  
</body>

</html>