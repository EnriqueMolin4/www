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
                <h3>TECNICOS</h3>
            </div>
            <div class="container-fluid p-3 panel-white">
            <div class="row">
                <div class="col-sm-12 p-4">           
                    <label for="supervisor" class="col-form-label-sm">SUPERVISOR</label>
                    <select id="supervisor" name="supervisor" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="usuarios"  class="table table-md table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="350px">NOMBRE</th>
                        <th width="350px">APELLIDOS</th>
                        <th width="250px">EMAIL</th>
                        <th width="250px">TELEFONO</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th width="350px">NOMBRE</th>
                        <th width="350px">APELLIDOS</th>
                        <th width="250px">EMAIL</th>
                        <th width="250px">TELEFONO</th>
                        <th width="200px">ACCION</th>
                    </tr>
                </tfoot>
            </table>
            </div>
                            
            </div>
            <div class="panel-footer p-4">
                <fieldset class="border p-2">
                    <legend>AGREGAR TECNICO</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" value="0" id="tecnicoId" name="tecnicoId">
                            <label for="newTecnico" class="col-form-label-sm">Buscar Tecnico</label>
                                <input type="text" id="newTecnico" name="newTecnico" class="form-control form-control-sm"><br>
                            <button class="btn btn-success btn-sm" id="btnAddTecnico">Agregar</button>
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
    var usuarios;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "tecnicosxsupervisorlink")
            getSupervisores();


                usuarios = $('#usuarios').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "asc" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
                    ajax: {
                        url: 'modelos/tecnicosxsupervisor_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable',
                            d.supervisor = $("#supervisor").val()
                        }
                    },
                    columns : [
                        { data: 'nombre'},
                        { data: 'apellidos' },
                        { data: 'email' },
                        { data: 'telefono' },
                        { data: 'id'}
                    ],
                    aoColumnDefs: [
                        {
                            "targets": [4],
                            "mRender": function ( data,type, row ) {
                                return '<a href="#" title="Des-Asignar Técnico" class="delTecnico" data="'+row.id+'"><i class="fas fa-user-minus fa-2x" style="color:#F5425D"></i></a>';
                            }
                        }
                    ]
                });

                $("#supervisor").on('change',function() {
                    usuarios.ajax.reload();
                })

                $("#btnRegistrar").on('click', function() {
                    alert("Grabar")
                    $("#showEvento").modal("hide")
                })

                $( "#newTecnico" ).autocomplete({
                    delay: 1000,
                    minLength: 4,
                    source: function( request, response ) {
                    $.ajax({
                        url: "modelos/tecnicosxsupervisor_db.php",
                        dataType: "json",
                        data: {
                        term: request.term,
                        module: 'buscarTecnico'
                        },
                        success: function( data ) {
                              $("#tecnicoId").val("0");
                            response( $.map( data, function( item ) {
                                            
                                return {
                                    label: item.nombre,
                                    value: item.nombre,
                                    data : item
                                }
                            }));
                        }
                    });
                    },
                    messages: {
                        noResults: '',
                        results: function() {}
                    },
                    autoFocus: true,
                    minLength: 2,
                    select: function( event, ui ) {
                        var info = ui.item.data;
                       $("#tecnicoId").val(info.id);
                       
                    
                    }
                } );

                $("#btnAddTecnico").on('click', function() {
                    if( $("#supervisor").val() == "0" ) 
                    {
                        alert("SELECCIONA EL SUPERVISOR");

                    } else if ( $("#newTecnico").val().lenght != 0 ) {
                        $.toaster({
                          message: 'Favor de ingresar un técnico',
                          title: 'Aviso',
                          priority : 'danger'
                      });

                    }else {
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/tecnicosxsupervisor_db.php', // call your php file
                            data: { module: 'addTecnico', tecnicoid: $("#tecnicoId").val(), territorial: $("#supervisor").val() },
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                $("#tecnicoId").val("");
                                $("#newTecnico").val("");
                                 usuarios.ajax.reload();
                                    
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert(data)
                            }
                        });
                    }
                })

               
                $(document).on('click','.delTecnico', function() {
                    var tecnicoid = $(this).attr('data');

                    var r = confirm("Se Des-asignará el Técnico. ¿Desea Continuar?");

                    if(r == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'modelos/tecnicosxsupervisor_db.php', // call your php file
                            data: { module: 'tecnicoDelete',tecnicoid: tecnicoid },
                            cache: false,
                            success: function(data){
                                if(data == "1") {
                                    $.toaster({
                                        message: 'Se des-asignó con éxito. ',
                                        title: 'Aviso',
                                        priority : 'success'
                                    });  
                                    usuarios.ajax.reload();
                                }
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