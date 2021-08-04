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
                <a href="registroalmacen.php" class="btn btn-success">REGRESAR</a>
                <h3>Procesos de Carga Actualizacion de Inventario </h3>
                
                <table id="procesos"  class="table table-md table-bordered ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ARCHIVO</th>
                            <th>TOTAL</th>
                            <th>PROCESADOS</th>
                            <th>NO PROCESADOS</th>
                            <th>CREADO</th>
                            <th>ULTIMA MODIFICACION</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    
                </table>
            </div>
            <!-- MODAL Mostrar ODT No Cargadas -->
            <div class="modal fade" tabindex="-3" role="dialog" id="showODTNoCargadas">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SERIES YA EXISTEN EN LA BD (Validar en el archivo)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col p-3">
                            Archivo: <span id="nArchivo"></span>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                                    
                           <div id="odts" style="overflow: scroll; width: 400px; height: 400px;">
                           </div>
                        </div>
                        
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSubmitReasignar">ReAsignar</button>
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
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script src="js/jquery.rotate.1-1.js"></script>
    <script>
    var procesos;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "territorioslink")
            

            procesos = $("#procesos").DataTable({
                language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                        url: 'modelos/procesos_in.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getProcesos',
                            d.tipo = 'I'
                        }
                },
                columns : [
                    { data: 'id' },
                    { data: 'archivo'},
                    { data: 'registros_total'},
                    { data: 'registros_procesados'},
                    { data: 'registros_sinprocesar'},
                    { data: 'nombre'},
                    { data: 'fecha_modificacion' }
                ],
                aoColumnDefs: [
                    {
                        "targets": [1],
                         "width": '30%'
                    },
                    {
                        "targets": [4],
                        "mRender": function ( data,type, row ) {
              
                            return '<a href="#" class="mostrarDetalle" data-id="'+row.id+' " data-archivo="'+row.archivo+'">'+data+'</a>';
                        }  
                    }
                ] 
            });

            $(document).on("click", ".mostrarDetalle", function() {

                var id = $(this).data('id');
                var archivo = $(this).data('archivo');
                $("#nArchivo").html(archivo);
                $("#odts").html('');
                $.ajax({
                    type: 'GET',
                    url: 'modelos/procesos_in.php', // call your php file
                    data: 'module=getODTNoProcesados&id='+id,
                    cache: false,
                    success: function(data){
                        var info = JSON.parse(data);
                        var list = '';
                        $.each(info, function(index,valor) {
                            list += "<p>"+valor.NoSerie+"</p>";
                        })

                        $("#odts").html(list);
                        $("#showODTNoCargadas").modal("show");
                    },
                    error: function(error){
                        var demo = error;
                    }
                });
            })

            

              
        } );

            
       

    </script> 
  
</body>

</html>