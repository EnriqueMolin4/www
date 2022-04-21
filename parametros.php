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
                <div class="col-sm-4">           
                    <label for="catalogo" class="col-form-label-sm">Catalogo</label>
                    <select id="catalogo" name="catalogo" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                        <option value="tipo_evidencias">Evidencias</option>
                        <option value="tipo_servicio">Servicios</option>
                        <option value="tipo_subservicios">Sub Servicios</option>
                        <option value="tipo_user">Tipo Usuario</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="fBanco" class="col-form-label-sm">Banco</label>
                    <select name="fBanco" id="fBanco" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>
            </div> <br>
            <div class="row" id="divEvidencia" class="divEvidencia" style="display:none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addEvidencia">Nueva Evidencia</button>
                </div>
            </div>
            <div class="row" id="divServicios" class="divServicios" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addServicio">Nuevo Servicio</button>
                </div>
            </div>
            <div class="row" id="divUser" class="divUser" id="divUser" style="display:none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addUser">Nuevo Tipo de Usuario</button>
                </div>
            </div>
            <br>
            <table id="parametros"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th class="idsDeclarados">Nombre</th>
                        <th>Estatus</th>
                        <th>Banco</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Banco</th>
                        <th>Accion</th>
                    </tr>
                </tfoot>
            </table>

            <!-- Modal Nuevo Subservicio -->
            <div class="modal" tabindex="-1" role="dialog" id="nuevoSubservicio" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">AGREGAR NUEVO SUBSERVICIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="servicioNombre" class="col-form-label-sm">Servicio</label>
                            <input type="text" id="servicioNombre" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="ssNombre" class="col-form-label-sm">Nombre Subservicio</label>
                            <input type="text" class="form-control form-control-sm" id="ssNombre" name="ssNombre">
                        </div>
                        <div class="col">
                            <label for="ssBanco" class="col-form-label-sm">Banco</label>
                            <select name="ssBanco" id="ssBanco" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="servicio_id" id="servicio_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarSubserv" name="guardarSubserv">Guardar</button>
                  </div>
                </div>
              </div>
            </div>


            <!-- Modal Nueva Evidencia -->
            <div class="modal" tabindex="-1" role="dialog" id="nuevaEvidencia" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">AGREGAR NUEVA EVIDENCIA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="eNombre" class="col-form-label-sm">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="eNombre" name="eNombre">
                        </div>
                        <div class="col">
                            <label for="eBanco" class="col-form-label-sm">Banco</label>
                            <select name="eBanco" id="eBanco" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary guardarEvidencia" id="guardarEvidencia" >Guardar</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Nuevo Servicio -->
            <div class="modal" tabindex="-1" role="dialog" id="nuevoServicio" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">AGREGAR NUEVO SERVICIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="sNombre" class="col-form-label-sm">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="sNombre" name="sNombre">
                        </div>
                        <div class="col">
                            <label for="sBanco" class="col-form-label-sm">Banco</label>
                            <select name="sBanco" id="sBanco" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary guardarServicio" id="guardarServicio" >Guardar</button>
                  </div>
                </div>
              </div>
            </div>


            <!-- Modal Nuevo User -->
            <div class="modal" tabindex="-1" role="dialog" id="nuevoUsuario" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">AGREGAR NUEVA TIPO DE USUARIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="uNombre" class="col-form-label-sm">uNombre</label>
                            <input type="text" class="form-control form-control-sm" id="uNombre" name="uNombre">
                        </div>
                        <div class="col">
                            <label for="uBanco" class="col-form-label-sm">uBanco</label>
                            <select name="uBanco" id="uBanco" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary guardarUsuario" id="guardarUsuario" >Guardar</button>
                  </div>
                </div>
              </div>
            </div>


                <!-- <fieldset class="border p-2">
                    <legend>Agregar Parámetro</legend>
                    <div class="row">
                        <div class="col-md-4">
                             
                            <label for="newParametro" class="col-form-label-sm">Parametro</label>
                                <input type="text" id="newParametro" name="newParametro" class="form-control form-control-sm" ><br>
                            <button class="btn btn-success btn-sm" id="btnAddParametro">Agregar</button>
                        </div>
                    </div>
                </fieldset> -->
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
    var parametros, OpCatalogo;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "parametroslink")

            getBancos();

            parametros = $('#parametros').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "asc" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
                    ajax: {
                        url: 'modelos/parametros_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable',
                            d.catalogo = $("#catalogo").val(),
                            d.f_banco = $("#fBanco").val()
                        }
                    },
                    columns : [
                        { data: 'nombre'},
                        { data: 'status' },
                        { data: 'banco'},
                        { data: 'id'}
                    ],
                    aoColumnDefs: [
                        {
                            "targets": [1],
                            "mRender": function ( data,type, row ) {
                                var data = 'No Activo';
                                if(row.status == '1') {
                                    data = 'Activo';
                                }

                                return data;
                            
                            }
                        },
                        {
                            "targets": [3],
                            "mRender": function ( data,type, row ) {
                                var btnall = '';
                                var subSer = '<a title="Agregar subservicio" href="#" class="addSubservicio" data-nombre="'+row.nombre+'" data-id="'+row.id+'"><i class="fas fa-plus-circle fa-2x"></i><a/>';
                                var button = '<a title="Desactivar" href="#" class="delParametro" data="'+row.id+'-'+row.status+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
                                var button2 = '<a title="Activar" href="#" class="delParametro" data="'+row.id+'-'+row.status+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                               

                                if ($("#catalogo").val() == 'tipo_servicio') 
                                {
                                    btnall = subSer + button; 
                                    
                                }
                                else
                                {
                                    btnall = button;
                                }
                                
                                if(row.status == '0') {
                                    
                                    btnall = button2;
                                }
                                
                                return btnall;
                            }
                        }
                    ]
                });

                $("#catalogo").on('change',function() {

                    
                    parametros.ajax.reload();

                });

                $("#fBanco").on('change',function() {
                    parametros.ajax.reload();
                });

                const cat_option = document.getElementById('catalogo');

                cat_option.addEventListener('change', function handleChange(event)
                {
                        //console.log(event.target.value);
                        if (event.target.value == 'tipo_evidencias') 
                        {
                            $("#divEvidencia").show();
                            $("#divServicios").hide();

                        }
                        else{
                            $("#divEvidencia").hide();
                        }

                        if (event.target.value == 'tipo_servicio') 
                        {
                            $("#divServicios").show();
                            $("#divEvidencia").hide();
                        }
                        else
                        {
                            $("#divServicios").hide();
                        }

                        if (event.target.value == 'tipo_user') 
                        {
                            $("#divUser").show();
                        }
                        else
                        {
                            $("#divUser").hide();
                        }
                });

                $(document).on("click",".addSubservicio", function() {

                    var index = $(this).parent().parent().index();
                    var data = parametros.row( index ).data();

                    console.log(data);

                    $("#servicioNombre").val(data.nombre);
                    $("#servicio_id").val(data.id);

                    $("#nuevoSubservicio").modal("show");
                });

                $(document).on("click",".addEvidencia", function(){
                    $("#nuevaEvidencia").modal("show");
                })

                $(document).on("click",".addServicio", function(){
                    $("#nuevoServicio").modal("show");
                })

                $("#btnAddParametro").on('click', function(){


                    var param = $("#newParam").val(); 

                    if( $("#catalogo").val() == "0" ) 
                    {
                        $.toaster({
                          message: 'Recuerda elegir un catálogo de la lista',
                          title: 'Aviso',
                          priority : 'danger'
                      });
                    } 


                    if( $("#newParametro").val().length > 0 )
                    {
                                $.ajax({
                                   type: 'POST',
                                   url: 'modelos/parametros_db.php', // call your php file
                                   data: { module: 'addParametro', parametro: $("#newParametro").val(),catalogo: $("#catalogo").val() },
                                   cache: false,
                                    success: function(data, textStatus, jqXHR){
                                    $("#newParametro").val("");
                                    parametros.ajax.reload();
                                    
                            },
                            error: function(jqXHR, textStatus, errorThrown) 
                            {
                                alert(data)
                            }
                        });
                     
                    }
                    else
                    {
                        $.toaster({
                          message: 'Favor de ingresar un parámetro',
                          title: 'Aviso',
                          priority : 'danger'
                      });
                    }

                       
                });


                $(document).on('click','.guardarEvidencia', function(){
                    var cat = $("#catalogo").val();
                    var nombreEvidencia = $("#eNombre").val();
                    var bancoEvidencia = $("#eBanco").val();
        
                    if ( $("#eBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message:'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        })
                    }
                    else
                    {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : cat, nombre : nombreEvidencia, cve : bancoEvidencia},
                            cache: false,
                            success: function(data){
                                //console.log(data);
                                var info = JSON.parse(data);
                                console.log(info.valido);
                                if (info.valido == '0') 
                                {
                                    $.toaster({
                                        message: 'Se agregó con éxito',
                                        title: 'Aviso',
                                        priority : 'success'
                                    });
                                }
                                else
                                {
                                    $.toaster({
                                        message: 'El registro ya existe',
                                        title: 'Aviso',
                                        priority : 'warning'
                                    });
                                }

                                parametros.ajax.reload();
                                $("#nuevaEvidencia").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }

                })

                $(document).on('click','.guardarServicio', function(){
                    var cat = $("#catalogo").val();
                    var nombreServicio = $("#sNombre").val();
                    var bancoServicio = $("#sBanco").val();

                    if ( $("#sBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        })
                    }
                    else
                    {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: {module: 'grabarCatalogo',catalogo: cat, nombre: nombreServicio, cve: bancoServicio},
                            cache: false,
                            success: function(data){
                                var info = JSON.parse(data);
                                if (info.valido == '0') 
                                {
                                    $.toaster({
                                        message: 'Se agregó con éxito',
                                        title: 'Aviso',
                                        priority : 'success'
                                    });
                                }
                                else
                                {
                                    $.toaster({
                                        message: 'El registro ya existe',
                                        title: 'Aviso',
                                        priority : 'warning'
                                    });
                                }

                                parametros.ajax.reload();
                                $("#nuevoServicio").modal("hide");
                                cleartext();
                            }
                        })
                    }

                })

                $(document).on('click','.guardarSubserv', function(){
                    /*var cat = $("#catalogo").val();
                    var subSer = $("#ssNombre").val();
                    var ssBanco = $("#ssBanco").val();
                    var id_servicio = $("#servicio_id").val();*/

                    alert("El botón funciona!!");

                    /*if ( $("#ssBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                    }
                    else
                    {
                        $.ajax({
                            type:'GET',
                            url: 'modelos/parametros_db.php',
                            data: {module: 'grabarCatalogo',catalogo : cat, sub_servicio : subSer, cve : ssBanco, id_s : id_servicio},
                            cache: false,
                            success: function(data){
                                var info = JSON.parse(data);

                                if (info.valido == '0') {
                                    $.toaster({
                                        message: 'Se agregó con éxito',
                                        title: 'Aviso',
                                        priority : 'success'
                                    });
                                }else
                                {
                                    $.toaster({
                                        message: 'El registro ya existe',
                                        title: 'Aviso',
                                        priority : 'warning'
                                    });
                                }
                            }
                        })
                    }*/
                });

               
                $(document).on('click','.delParametro', function() {
                    var parametroid = $(this).attr('data').split('-');
                    $.ajax({
                        type: 'GET',
                        url: 'modelos/parametros_db.php', // call your php file
                        data: { module: 'parametroUpdate',catalogo: $("#catalogo").val(),parametroid: parametroid[0],statusid: parametroid[1] },
                        cache: false,
                        success: function(data){
                            if(data == "1") {
                                $.toaster({
                                    message: 'Se desactivo/activo con éxito  ',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                                parametros.ajax.reload();
                            }
                        }
                    });
                })
              
            } );

            
        



        function getSupervisores() {

            $.ajax({
                type: 'POST',
                url: 'modelos/tecnicosxsupervisor_db.php', // call your php file
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

        function getBancos(){
            $.ajax({
                type: 'POST',
                url: 'modelos/eventos_db.php',
                data: 'module=getBancos',
                cache: false,
                success: function(data){
                    $("#sBanco").html(data);
                    $("#ssBanco").html(data);
                    $("#eBanco").html(data);
                    $("#uBanco").html(data);
                    $("#fBanco").html(data);
                },
                error: function(error){
                    var demo = error;
                }
            });
        }

        function cleartext() {
            $("#eNombre").val("");
            $("#eBanco").val("0");

            $("#sNombre").val("");
            $("#sBanco").val("0");

            $("#ssNombre").val("");
            $("#ssBanco").val("0");

        

        }


    </script> 
  
</body>

</html>