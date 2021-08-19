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
                <div class="col-sm-12 p-4">           
                    <label for="catalogo" class="col-form-label-sm">Catalogo</label>
                    <select id="catalogo" name="catalogo" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                        <option value="tipo_evidencias">Evidencias</option>
                        <option value="tipo_servicio">Servicios</option>
                        <option value="tipo_subservicios">Sub Servicios</option>
                        <option value="tipo_user">Tipo Usuario</option>
                    </select>
                </div>
            </div>
            <table id="parametros"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th class="idsDeclarados">Nombre</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                </tfoot>
            </table>
                <fieldset class="border p-2">
                    <legend>Agregar Parámetro</legend>
                    <div class="row">
                        <div class="col-md-4">
                             
                            <label for="newParametro" class="col-form-label-sm">Parametro</label>
                                <input type="text" id="newParametro" name="newParametro" class="form-control form-control-sm" ><br>
                            <button class="btn btn-success btn-sm" id="btnAddParametro">Agregar</button>
                        </div>
                    </div>
                </fieldset>
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
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "parametroslink")
            


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
                            d.catalogo = $("#catalogo").val()
                        }
                    },
                    columns : [
                        { data: 'nombre'},
                        { data: 'status' },
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
                            "targets": [2],
                            "mRender": function ( data,type, row ) {
                                var button = '<a title="Desactivar" href="#" class="delParametro" data="'+row.id+'-'+row.status+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
                                
                                if(row.status == '0') {
                                    button = '<a title="Activar" href="#" class="delParametro" data="'+row.id+'-'+row.status+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                                }
                                
                                return button;
                            }
                        }
                    ]
                });

                $("#catalogo").on('change',function() {
                    parametros.ajax.reload();
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


        function cleartext() {
            $("#nombre").val("");
            $("#apellidos").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#negocio").val("0");
            $("#correo").val("")

        }


    </script> 
  
</body>

</html>