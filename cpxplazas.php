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
            <h3>CP x Plazas (<?php echo $_GET['nombre']; ?> )</h3>
            <!--
                <div class="row">
                        <div class="col-sm-5"> 
                            <label for="excelMasivo" class="col-form-label-sm">Carga Masiva</label> 
                            <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                            <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="layouts/LayoutCargaMasivaCPPlazas.csv" download>Template Carga Masiva</a>
                        </div>
                </div>
                -->
                <a href="plazas.php" class="btn btn-primary">Regresar</a>
                <fieldset>
                    <legend>Agregar CP</legend>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="plazas">CP:</label>
                                <div class="col-sm-10">
                                <input type="newCP" class="form-control" name="newCP" id="newCP" placeholder="Agregar CP">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 p-4">
                            <div class="form-group">
                                <a href="#" class="btn btn-success" id="btnGrabarNuevo" name="btnGrabarNuevo">Agregar</a>
                                
                            </div>
                            <div class="form-group">
                                
                            </div>
                        </div>
    
                    </div>
                </fieldset>
                <div class="table-responsive">  
                    <table id="tblCP" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>CP</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div> 
                <input type="hidden" id="plazaId" name="plazaId" value="<?php echo $_GET['plazaId']; ?>">
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
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script>
    var plazas,tblCP;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "plazaslink")

            tblCP = $('#tblCP').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    
                    order: [[ 0, "asc" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
                    ajax: {
                        url: 'modelos/plazas_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTableCP',
                            d.plazas = $("#plazaId").val()
                        }
                    },
                    columns : [
                        { data: 'cp' },
                        { data: 'id'}
                    ],
                    aoColumnDefs: [
                        { "width": "50%", "targets": 0 },
                        {
                            "width": "50%",
                            "targets": [1],
                            "mRender": function ( data,type, row ) {
                                return '<a href="#" class="deleteCP" data-id="'+row.id+'"></i><i class="fas fa-trash-alt fa-2x" style="color:#F5425D"></i></a>';
                            }
                        }
                    ]
                });

                $(document).on('click','.deleteCP', function(e) {
                    e.preventDefault();

                    var id = $(this).data("id");
                    var eliminar = confirm("Se borrará este registro. ¿Deseas continuar?");
                    $("#plazaId").val(id);

                    if (eliminar == true) 
                    {
                        $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'delCPPlaza', cpid : id },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            tblCP.ajax.reload();
                            $.toaster({
                                message: 'Se borro el  CP ' ,
                                title: 'Aviso',
                                priority : 'success'
                            });  
                        
                            
                        },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $.toaster({
                                    message: 'No se pudo borrar el cp' ,
                                    title: 'Aviso',
                                    priority : 'danger'
                                });  
                            }
                        }); 
                        tblCP.ajax.reload();
                        tblCP.columns.adjust().draw();
                    }
                    
                    
                    
                   
                })

                $("#btnGrabarNuevo").on("click",function() {

                    
                    var plazaId = $("#plazaId").val();
                    var cp = $("#newCP").val();

                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'saveNewCPPlaza', plazaid : plazaId,cp: cp },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            tblCP.ajax.reload();
                            $.toaster({
                                message: 'Se agrego el CP '+cp ,
                                title: 'Aviso',
                                priority : 'success'
                            });  
                        
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $.toaster({
                                message: 'Hay un error al grabar el cp  '+cp ,
                                title: 'Aviso',
                                priority : 'danger'
                            });  
                        }
                    });

                })
               

         
                $("#btnCargarExcel").on("click",function() {
                    var form_data = new FormData();
                    var excelMasivo = $("#excelMasivo");
                    var file_data = excelMasivo[0].files[0];
                    form_data.append('file', file_data);
                    form_data.append('module','plazasMasivo');
                    $.toaster({
                        message: 'Inicia la Carga Masiva de Plazas',
                        title: 'Aviso',
                        priority : 'success'
                    });  
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: form_data,
                        processData: false,
                    contentType: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);

                            if(info.plazaNoCargadas > 0 ) {
                                $.toaster({
                                    message: 'No Se Cargaron '+info.plazaNoCargadas+' Plazas',
                                    title: 'Aviso',
                                    priority : 'danger'
                                });  
                            }

                            if(info.plazaCargados > 0 ) {
                                $.toaster({
                                    message: 'Se Cargaron '+info.plazaCargados+' Plazas',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                            }
                           
                            plazas.ajax.reload();
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus)
                    }
                    });
                })
              
        } );

       
        function cleartext() {
            $("#newCP").val("");
          

        }


    </script> 
  
</body>

</html>