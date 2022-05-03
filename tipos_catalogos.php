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
            <div class="row"><h3>Catálogo Versión, Aplicativo & Conectividad</h3>
                
            </div>

            <div class="row">
                <div class="col-sm-4">           
                    <label for="catalogo" class="col-form-label-sm">Catálogo</label>
                    <select id="catalogo" name="catalogo" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                        <option value="tipo_version">Tipo Versión</option>
                        <option value="tipo_aplicativo">Tipo Aplicativo</option>
                        <option value="tipo_conectividad">Tipo Conectividad</option>
                        <option value="tipo_causas_cambio">Causas Cambio</option>
                        <option value="tipo_cancelacion">Causas Cancelacion</option>
                       
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="fBanco" class="col-form-label-sm">Banco</label>
                    <select name="fBanco" id="fBanco" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>
            </div>
            <br>

            <div class="row" id="divVersion" class="divVersion" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addVersion">Nueva Versión</button>
                </div>
            </div>
            <div class="row" id="divAplicativo" class="divAplicativo" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addAplicativo">Nuevo Aplicativo</button>
                </div>
            </div>
            <div class="row" id="divConnec" class="divConnec" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addConectividad">Nueva Conectividad</button>
                </div>
            </div>
            <div class="row" id="divCausa" class="divCausa" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addCCambio">Nueva Causa de Cambio</button>
                </div>
            </div>
            <div class="row" id="divCancel" class="divCancel" style="display: none;">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary addCCancelacion">Nueva Causa de Cancelación</button>
                </div>
            </div>
            <br>
            <table id="parametros"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th>Nombre</th>
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
                <!-- <fieldset class="border p-2">
                    <legend>Agregar Parámetro</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="newParametro" class="col-form-label-sm">Parametro</label>
                                <input type="text" id="newParametro" name="newParametro" class="form-control form-control-sm"><br>
                            <button class="btn btn-success btn-sm" id="btnAddParametro">Agregar</button>
                        </div>
                    </div>
                </fieldset> -->

                <!-- Modal Nueva Version -->
                <div class="modal" tabindex="-1" role="dialog" id="nuevaVersion" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">AGREGAR NUEVA VERSION</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <label for="vNombre" class="col-form-label-sm">Nombre Versión</label>
                                <input type="text" class="form-control form-control-sm" id="vNombre" name="vNombre">
                            </div>
                            <div class="col">
                                <label for="vBanco" class="col-form-label-sm">Banco</label>
                                <select name="vBanco" id="vBanco" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarVersion" id="guardarVersion" name="guardarVersion">Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Nuevo Aplicativo -->
                <div class="modal" tabindex="-1" role="dialog" id="nuevoAplicativo" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">AGREGAR NUEVA APLICATIVO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <label for="aNombre" class="col-form-label-sm">Nombre Aplicativo</label>
                                <input type="text" class="form-control form-control-sm" id="aNombre" name="aNombre">
                            </div>
                            <div class="col">
                                <label for="aClave" class="col-form-label-sm">Clave Elavon</label>
                                <input type="text" class="form-control form-control-sm" id="aClave" name="aClave">
                            </div>
                            <div class="col">
                                <label for="aBanco" class="col-form-label-sm">Banco</label>
                                <select name="aBanco" id="aBanco" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarAplicativo" id="guardarAplicativo" name="guardarAplicativo">Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Nueva Conectividad -->
                <div class="modal" tabindex="-1" role="dialog" id="nuevaConnect" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">AGREGAR NUEVA CONECTIVIDAD</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <label for="cNombre" class="col-form-label-sm">Nombre Conectividad</label>
                                <input type="text" class="form-control form-control-sm" id="cNombre" name="cNombre">
                            </div>
                            <div class="col">
                                <label for="cClave" class="col-form-label-sm">Clave Elavon</label>
                                <input type="text" class="form-control form-control-sm" id="cClave" name="cClave">
                            </div>
                            <div class="col">
                                <label for="cBanco" class="col-form-label-sm">Banco</label>
                                <select name="cBanco" id="cBanco" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarConnect" id="guardarConnect" name="guardarConnect">Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Nueva Causas Cambio -->
                <div class="modal" tabindex="-1" role="dialog" id="nuevaCausa" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">AGREGAR NUEVA CAUSA DE CAMBIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <label for="ccNombre" class="col-form-label-sm">Nombre Causa Cambio</label>
                                <input type="text" class="form-control form-control-sm" id="ccNombre" name="ccNombre">
                            </div>
                            <div class="col">
                                <label for="ccClave" class="col-form-label-sm">Clave Elavon</label>
                                <input type="text" class="form-control form-control-sm" id="ccClave" name="ccClave">
                            </div>
                            <div class="col">
                                <label for="ccBanco" class="col-form-label-sm">Banco</label>
                                <select name="ccBanco" id="ccBanco" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarCausa" id="guardarCausa" name="guardarCausa">Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Nueva Cancelacion -->
                <div class="modal" tabindex="-1" role="dialog" id="nuevaCancelacion" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">AGREGAR NUEVA CANCELACION</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <label for="caNombre" class="col-form-label-sm">Nombre Cancelación</label>
                                <input type="text" class="form-control form-control-sm" id="caNombre" name="caNombre">
                            </div>
                            <div class="col">
                                <label for="cAClave" class="col-form-label-sm">Clave Elavon</label>
                                <input type="text" class="form-control form-control-sm" id="caClave" name="caClave">
                            </div>
                            <div class="col">
                                <label for="caBanco" class="col-form-label-sm">Banco</label>
                                <select name="caBanco" id="caBanco" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarCancelacion" id="guardarCancelacion" name="guardarCancelacion">Guardar</button>
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
    <script src="js/jquery.rotate.1-1.js"></script>
    <script>
    var parametros;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "parametroslink", "tiposxcatalogoslink")
            
            getBancos();

            parametros = $('#parametros').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "asc" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
                    ajax: {
                        url: 'modelos/tipos_catalogos_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable',
                            d.catalogo = $("#catalogo").val(),
                            d.banco = $("#fBanco").val()
                        }
                    },
                    columns : [
                        { data: 'nombre'},
                        { data: 'estatus' },
                        { data: 'banco'},
                        { data: 'id'}
                    ],
                    aoColumnDefs: [
                        {
                            "targets": [1],
                            "mRender": function ( data,type, row ) 
                            {
                                var data = 'No Activo';

                                if(row.estatus == '1') 
                                {
                                    data = 'Activo';
                                }

                                return data;
                            
                            }
                        },
                        {
                            "targets": [3],
                            "mRender": function ( data,type, row ) {
                                var button = '<a title="Desactivar" href="#" class="delParametro" data="'+row.id+'-'+row.estatus+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
                                
                                if(row.estatus == '0') {
                                    button = '<a title="Activar" href="#" class="delParametro" data="'+row.id+'-'+row.estatus+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                                }
                                
                                return button;
                            }
                        }
                    ]
                });

                $("#catalogo").on('change',function() {
                    parametros.ajax.reload();
                })
                 $("#fBanco").on('change',function() {
                    parametros.ajax.reload();
                });

                function validarnewParam() 
                    {
                        if ($('#newParametro').val().length == "0") 
                        {
                            alert('Ingrese rut');
                            return false;
                        }
                    }
        
                const cat_option = document.getElementById('catalogo');

                cat_option.addEventListener('change', function handleChange(event){
                    if (event.target.value == 'tipo_version') 
                    {
                        $("#divVersion").show();
                    }else
                    {
                        $("#divVersion").hide();
                    }
                    if(event.target.value == 'tipo_aplicativo')
                    {
                        $("#divAplicativo").show();
                    }
                    else
                    {
                        $("#divAplicativo").hide();
                    }
                    if(event.target.value == 'tipo_conectividad')
                    {
                        $("#divConnec").show();
                    }
                    else
                    {
                        $("#divConnec").hide();
                    }
                    if(event.target.value == 'tipo_causas_cambio')
                    {
                        $("#divCausa").show();
                    }
                    else
                    {
                        $("#divCausa").hide();
                    }
                    if(event.target.value == 'tipo_cancelacion')
                    {
                        $("#divCancel").show();
                    }
                    else
                    {
                        $("#divCancel").hide();
                    }
                })


                $("#btnAddParametro").on('click', function() 
                {
                    
                    if ( $("#catalogo").val() == "0" ) 
                    {
                        $.toaster({
                          message: 'Recuerda elegir un catálogo de la lista',
                          title: 'Aviso',
                          priority : 'danger'
                      });
                    } 
                    if( $("#newParametro").val().length > 0 ) {
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/tipos_catalogos_db.php', // call your php file
                            data: { module: 'addParametro', parametro: $("#newParametro").val(),catalogo: $("#catalogo").val() },
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                $("#newParametro").val("");
                                parametros.ajax.reload();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert(data)
                            }
                        });
                    }
                    else{
                        $.toaster({
                          message: 'Favor de ingresar un parámetro',
                          title: 'Aviso',
                          priority : 'danger'
                      });
                    }
                })

                 $(document).on("click",".addVersion", function(){
                    $("#nuevaVersion").modal("show");
                })

                 $(document).on("click",".addAplicativo", function(){
                    $("#nuevoAplicativo").modal("show");
                })
                 $(document).on("click",".addConectividad", function(){
                    $("#nuevaConnect").modal("show");
                })
                 $(document).on("click",".addCCambio", function(){
                    $("#nuevaCausa").modal("show");
                })
                 $(document).on("click",".addCCancelacion", function(){
                    $("#nuevaCancelacion").modal("show");
                })
               
                $(document).on('click','.delParametro', function() {
                    var parametroid = $(this).attr('data').split('-');
                    $.ajax({
                        type: 'GET',
                        url: 'modelos/tipos_catalogos_db.php', // call your php file
                        data: { module: 'parametroUpdate',catalogo: $("#catalogo").val(),parametroid: parametroid[0],estatusid: parametroid[1] },
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



                $(document).on('click','.guardarVersion' ,function(){
                    var catalogo = $("#catalogo").val();
                    var nombreVersion = $("#vNombre").val();
                    var bancoVersion = $("#vBanco").val();

                    var valido = 0;

                     if ( $("#vBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }

                    if ( $("#vNombre").val().length > 0 ) 
                    {

                    }
                    else 
                    {
                        $.toaster({
                            message: 'Favor de ingresar la nueva versión',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }
                
                    
                    if (valido==0) {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : catalogo, nombre : nombreVersion, cve : bancoVersion},
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
                                $("#nuevaVersion").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }

                })


                $(document).on('click','.guardarAplicativo' ,function(){
                    var catalogo = $("#catalogo").val();
                    var nombreAplicativo = $("#aNombre").val();
                    var clave = $("#aClave").val();
                    var bancoAplicativo = $("#aBanco").val();

                    var valido = 0;

                     if ( $("#aBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }

                    if ( $("#aNombre").val().length > 0 || $("#aClave").val().length > 0 ) 
                    {

                    }
                    else 
                    {
                        $.toaster({
                            message: 'Favor de ingresar nombre y clave elavon',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }
                    
                    if (valido == 0) {
                         $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : catalogo, nombre : nombreAplicativo, clave : clave, cve : bancoAplicativo},
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
                                $("#nuevoAplicativo").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }
                    

                })


                $(document).on('click','.guardarConnect' ,function(){
                    var catalogo = $("#catalogo").val();
                    var nombreConect = $("#cNombre").val();
                    var claveConect = $("#cClave").val();
                    var bancoConect = $("#cBanco").val();

                    var valido = 0;

                     if ( $("#cBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }

                    if ( $("#cNombre").val().length > 0 || $("#cClave").val().length > 0 ) 
                    {

                    }
                    else 
                    {
                        $.toaster({
                            message: 'Favor de ingresar nombre y clave elavon',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }
                    
                    if (valido==0) {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : catalogo, nombre : nombreConect, clave : claveConect, cve : bancoConect},
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
                                $("#nuevaConnect").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }
                    

                })
                $(document).on('click','.guardarCausa' ,function(){
                    var catalogo = $("#catalogo").val();
                    var nombreConect = $("#ccNombre").val();
                    var claveConect = $("#ccClave").val();
                    var bancoConect = $("#ccBanco").val();

                    var valido = 0;

                     if ( $("#ccBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }

                    if ( $("#ccNombre").val().length > 0 || $("#ccClave").val().length > 0 ) 
                    {

                    }
                    else 
                    {
                        $.toaster({
                            message: 'Favor de ingresar nombre y clave elavon',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }
                    
                    if (valido==0) {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : catalogo, nombre : nombreConect, clave : claveConect, cve : bancoConect},
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
                                $("#nuevaCausa").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }
                    

                });

                 $(document).on('click','.guardarCancelacion' ,function(){
                    var catalogo = $("#catalogo").val();
                    var nombreConect = $("#caNombre").val();
                    var claveConect = $("#caClave").val();
                    var bancoConect = $("#caBanco").val();

                    var valido = 0;

                     if ( $("#caBanco").val() == '0' ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar el banco',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }

                    if ( $("#caNombre").val().length > 0 || $("#caClave").val().length > 0 ) 
                    {

                    }
                    else 
                    {
                        $.toaster({
                            message: 'Favor de ingresar nombre y clave elavon',
                            title: 'Aviso',
                            priority: 'danger'
                        });
                        valido++;
                    }
                    
                    if (valido==0) {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/parametros_db.php',
                            data: { module: 'grabarCatalogo',catalogo : catalogo, nombre : nombreConect, clave : claveConect, cve : bancoConect},
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
                                $("#nuevaCancelacion").modal("hide");
                                cleartext();

                                
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    }

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

                    $("#vBanco").html(data);
                    $("#aBanco").html(data);
                    $("#cBanco").html(data);
                    $("#caBanco").html(data);
                    $("#ccBanco").html(data);
                    $("#fBanco").html(data);
                },
                error: function(error){
                    var demo = error;
                }
            });
        }


        function cleartext() {
            $("#vNombre").val("");
            $("#vBanco").val("0");
            $("#aNombre").val("");
            $("#aBanco").val("0");
            $("#cNombre").val("");
            $("#cBanco").val("0");
            $("#ccNombre").val("");
            $("#ccBanco").val("0");
            $("#caNombre").val(" ");
            $("#caBanco").val("0");

        }


    </script> 
  
</body>

</html>