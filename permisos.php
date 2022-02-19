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
                    <h3>Permisos de Rol de Usuario</h3>
                    <div class="col-sm-12 p-4">
                        <label for="catalogo" class="col-form-label-sm"></label>
                        <select id="catalogo" name="catalogo" class="form-control form-control-sm">
                            <option value="0">Seleccionar</option>

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                      <table id="permisos" class="display table-responsive table table-bordered nowrap" style="width:100%">
                          <thead>
                              <tr>
                                  <th width="10%">Id</th>
                                  <th width="20%">Usuario</th>
                                  <th width="30%">Módulo</th>
                                  <th width="20%">Estatus</th>
                                  <th width="20%">Acción</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>
                </div>

                <button class="btn btn-success" id="btnNewPermiso">Nuevo Permiso</button>

            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showModel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Modelo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!-- MODAL PARA AGREGAR/EDITAR UN NUEVO EVENTO -->
                        <form id="frm" name="frm">
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="menu" class="col-form-label-sm">Menú</label>
                                    <select name="menu" id="menu" class="form-control form-control-sm">
                                        
                                    </select>
                                </div>

                                <div class="col-sm-4">          
                                <label for="user" class="col-form-label-sm">Tipo de Usuario</label> 
                                <select id="user" name="user" class="form-control form-control-sm">
                                    <option value="0">Seleccionar</option>
                             
                                    </select>
                                </div>
                            </div> 
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGrabarPermiso">Guardar</button>
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
    var permisos;
    $(document).ready(function() {
        ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "parametroslink", "tiposxcatalogoslink")

        getTiposUsuarios();
        getUsuariosTipos();
        getMenu();


        permisos = $('#permisos').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            searching: true,
            order: [
                [0, "asc"]
            ],
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "Todos"]
            ],
            ajax: {
                url: 'modelos/permisos_db.php',
                type: 'POST',
                data: function(d) {
                    d.module = 'getTable',
                        d.catalogo = $("#catalogo").val()
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'Usuario'
                },
                {
                    data: 'Modulo'
                },
                {
                    data: 'estatus'
                },
                /*{ data: 'id'}*/
            ],
            aoColumnDefs: [{
                    "targets": [0],
                    "width": "10%",

                },
                {
                    "targets": [1],
                    "width": "20%",

                },
                {
                    "targets": [2],
                    "width": "30%",

                },
                {
                    "targets": [3],
                    "width": "20%",

                },
                {
                    "targets": [4],
                    "width": "10%",

                },
                {
                    "targets": [3],
                    "mRender": function(data, type, row) {
                        var data = 'No Activo';

                        if (row.estatus == '1') {
                            data = 'Activo';
                        }

                        return data;

                    }
                },
                {
                    "targets": [4],
                    "mRender": function(data, type, row) {
                        var button = '<a title="Deshabilitar" href="#" class="delParametro" data="' + row.id + '-' + row.estatus + '"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></i></a>';

                        if (row.estatus == '0') {
                            button = '<a title="Habilitar" href="#" class="delParametro" data="' + row.id + '-' + row.estatus + '"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                        }

                        return button;
                    }
                }
            ]
        });

        $("#catalogo").on('change', function() {
            permisos.ajax.reload();
        })

        /*
                    function validarnewParam() 
                        {
                            if ($('#newParametro').val().length == "0") 
                            {
                                alert('Ingrese rut');
                                return false;
                            }
                        }
          */

        $("#btnAddParametro").on('click', function() {

            if ($("#catalogo").val() == "0") {
                $.toaster({
                    message: 'Recuerda elegir un catálogo de la lista',
                    title: 'Aviso',
                    priority: 'danger'
                });
            }
            if ($("#newParametro").val().length > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'modelos/permisos_db.php', // call your php file
                    data: {
                        module: 'addParametro',
                        parametro: $("#newParametro").val(),
                        catalogo: $("#catalogo").val()
                    },
                    cache: false,
                    success: function(data, textStatus, jqXHR) {
                        $("#newParametro").val("");
                        permisos.ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(data)
                    }
                });
            } else {
                $.toaster({
                    message: 'Favor de ingresar un parámetro',
                    title: 'Aviso',
                    priority: 'danger'
                });
            }
        })


        $(document).on('click', '.delParametro', function() {
            var parametroid = $(this).attr('data').split('-');
            $.ajax({
                type: 'GET',
                url: 'modelos/permisos_db.php', // call your php file
                data: {
                    module: 'parametroUpdate',
                    catalogo: $("#catalogo").val(),
                    parametroid: parametroid[0],
                    estatusid: parametroid[1]
                },
                cache: false,
                success: function(data) {
                    if (data == "1") {
                        $.toaster({
                            message: 'Se desactivo/activo con éxito  ',
                            title: 'Aviso',
                            priority: 'success'
                        });

                    }
                    permisos.ajax.reload();
                }
            });
        })

    });

    $(document).on("click", "#btnNewPermiso", function() {

        $(".modal-title").html("Asignar Permiso");

        //$("#btnGrabarModel").html('Registrar');


        //$("#no_largo").val("0");

        $("#showModel").modal({
            show: true,
            backdrop: false,
            keyboard: false
        })
    })


    //////////////////////

    $("#btnGrabarPermiso").on('click', function() {

        var menu = $("#menu").val();
        var usuario = $("#user").val();

        if ($("#menu").val() != '0') {

            if ($("#user").val() != '0') {

                var existePermiso = $.get('modelos/permisos_db.php', {
                        module: 'existepermiso',
                        menu: menu,
                        user: usuario
                    },

                    function(data) {
                        var form_data = {
                            module: 'nuevopermiso',
                            menu: $("#menu").val(),
                            user: $("#user").val()
                        };
                        var info = JSON.parse(data);

                        console.log(info);

                        $.ajax({
                            type: 'POST',
                            url: 'modelos/permisos_db.php',
                            data: form_data,
                            cache: false,
                            success: function(data, textStatus, jqXHR) {
                                permisos.ajax.reload();
                                $.toaster({
                                    message: data,
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                                cleartext();
                                $("#showModel").modal('hide');
                            }

                        });

                        $.each(info.menu, function(index, element) {
                            console.log(element);
                            $("#menu").val(element.menu);
                            $("#user").val(element.user);
                        });

                    }).fail(function(error) {
                    alert(error);
                });



            } else {
                $.toaster({
                    message: 'Selecciona el Usuario',
                    title: 'Aviso',
                    priority: 'warning'
                });
            }

        } else {
            $.toaster({
                message: 'Selecciona el menú que deseas asignar',
                title: 'Aviso',
                priority: 'warning'
            });
        }

    });

    /////////////////////

    function getUsuariosTipos() {

        $.ajax({
            type: 'POST',
            url: 'modelos/permisos_db.php', // call your php file
            data: {
                module: 'getUsuariosTipos'
            },
            cache: false,
            success: function(data, textStatus, jqXHR) {


                $("#user").html(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
            }
        });
    }

    function getTiposUsuarios() {

        $.ajax({
            type: 'POST',
            url: 'modelos/permisos_db.php', // call your php file
            data: {
                module: 'getTipoUsuarios'
            },
            cache: false,
            success: function(data, textStatus, jqXHR) {

                $("#catalogo").html(data);
                $("#user").html(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
            }
        });
    }

    function getMenu() {

        $.ajax({
            type: 'POST',
            url: 'modelos/permisos_db.php', // call your php file
            data: {
                module: 'getMenu'
            },
            cache: false,
            success: function(data, textStatus, jqXHR) {

                $("#menu").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
            }
        });
    }


    function cleartext() {
        $("#menu").val("0");
        $("#user").val("0");
        $("#usuario").val("");

    }


    </script> 
  
</body>

</html>