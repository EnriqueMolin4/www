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
                <h3>TERRITORIOS</h3>
            </div>
            <div class="container-fluid p-4 panel-white">
            
            <div class="row">
                <div class="col p-4">  
                    <div class="table-responsive">
                        <table id="territorios"  class="table table-md table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th width="400px">TERRITORIO</th>
                                <th width="400px">ESTATUS</th>
                                <th width="400px">ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        
                    </table>
                    </div>
                </div>
                
            </div>
            
                
            </div>
            <div class="panel-footer p-4">
                <fieldset class="border p-2">
                    <legend><h4>AGREGAR TERRITORIO</h4></legend>
                    <div class="row">
                        <div class="col-md-4">
                             <label for="territorio" class="col-form-label-sm">TERRITORIO</label>
                                <input type="text" id="territorio" name="territorio"  class="form-control form-control-sm"><br>
                            <button class="btn btn-success btn-sm" id="btnAddCP">AGREGAR</button>
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
    var territorial,plazas,territorios;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "territorioslink")


            territorios = $("#territorios").DataTable({
                language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                serverSide: true,
                ajax: {
                        url: 'modelos/territorial_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTableTerritorios'
                        }
                },
                columns : [
                    { data: 'nombre' },
                    { data: 'status'},
                    { data: 'id'}
                ],
                aoColumnDefs: [
                    {
                        "targets": [1],
                        "mRender": function ( data,type, row ) {
                            var status= data == '1' ? 'Activo' : 'Desactivado';
                            return status;
                        }
                    },
                    {
                        "targets": [2],
                        "mRender": function ( data,type, row ) {
                            var boton = '<a title="Desactivar" href="#" class="editRelacion" data="'+row.id+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';

                            if (row.status == '0') {
                               boton = '<a title="Activar" href="#" class="editRelacion" data="'+row.id+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                            }
                            return boton;
                            //return '<a href="#" class="editRelacion" data="'+row.id+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                        }
                    }
                ]
            });


            $("#btnAddCP").on('click', function() {
                if( $("#territorial").val() == "0" ) {
                    alert("Necesitas seleccionar un Territorio");
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/territorial_db.php', // call your php file
                        data: { module: 'addTerritorio', territorial: $("#territorio").val() },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                             
                            $("#territorio").val("");
                            territorial.ajax.reload();
                                
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });
                }
            })

            $(document).on('click','.delTerritorio', function() {
                var tid = $(this).attr('data');

                var r = confirm("Se va a borrar el Territorio esta seguro ? ");

                if(r == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'modelos/territorial_db.php', // call your php file
                        data: { module: 'delTerritorio',tid: tid },
                        cache: false,
                        success: function(data){
                            if(data == "1") {
                                $.toaster({
                                    message: 'Se borro con exito  ',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                                territorios.ajax.reload();
                            }
                        }
                    });
                }
            })
               
              
        } );


        function cleartext() {
            $("#territorio").val("");
          

        }


    </script> 
  
</body>

</html>