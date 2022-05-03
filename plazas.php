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
            <h3>PLAZAS -TERRITORIO</h3>
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
            <div class="row">
                <div class="col-sm-12 p-4">           
                    <label for="territorios" class="col-form-label-sm">Territorios</label>
                    <select id="territorios" name="territorios" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>
            </div>
            <table id="plazas"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th>PLAZA</th>
                        <th>TERRITORIO</th>
                        
                        <th>ACCION</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>PLAZA</th>
                        <th>TERRITORIO</th>
                        
                        <th>ACCION</th>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="col-sm-5">
                    <input type="hidden" id="plazaId" name="plazaId" value="0">
                    <a href="#" class="btn btn-success" id="btnNewPlaza">Agregar Nueva Plaza</a>
                </div>
            </div>
            </div>
   
        </main>
        <!-- Modal Editar Territorial de Plaza-->
        <div id="newTerritorio" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR TERRITORIAL DE LA PLAZA</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="plazas">PLAZAS:</label>
                            <div class="col-sm-10">
                            <input type="newPlazaName" class="form-control" name="newPlazaName" id="newPlazaName" placeholder="Agregar Plaza" readonly>
                            </div>
                        </div>                       
                        <div class= "col-sm-10">
                            <select class="custom-select" name="listTerritorio" id="listTerritorio" multiple>
                            </select>
                        </div>
                 
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-success" id="btnGrabarNuevo">Grabar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- page-content" -->
        <!-- Modal -->
        <div id="cpPlazas" class="modal fade" role="dialog" style="width:100%">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">AGREGAR CODIGO POSTAL</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="plazas">CP:</label>
                            <div class="col-sm-10">
                            <input type="newCP" class="form-control" name="newCP" id="newCP" placeholder="Agregar CP">
                            </div>
                        </div>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnAddCP">Grabar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
        <div id="newPlazaTerritorio" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">AGREGAR PLAZA - TERRITORIAL</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="plazas">PLAZAS:</label>
                            <div class="col-sm-10">
                              <select class="form-control form-control-sm" name="plazaN" id="plazaN"></select>
                            </div>
                        </div>                       
                        <div class= "col-sm-10">
                            <label for="territoriosL" class="control-label col-sm-2">TERRITORIAL</label>
                                <select class="form-control form-control-sm" name="territoriosL" id="territoriosL">
                            </select>
                        </div>
                 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="plazaId" name="plazaId">
                        <button type="button" class="btn btn-success" id="btnNuevoTP">Grabar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
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
            getTerritorios();
            getPlazas();
 
            plazas = $('#plazas').DataTable({
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
                            d.module = 'getTable',
                            d.plazas = $("#plazas").val(),
                            d.territorio = $("#territorios").val()
                        }
                    },
                    columns : [
                        { data: 'plaza' },
                        { data: 'territorio' },
                        //{ data: 'estatus' },
                        { data: 'id'}
                    ],
                    aoColumnDefs: [
                       
                        {
                            "targets": [2],
                            "mRender": function ( data,type, row ) {
                                return '<a href="#" class="editPlaza" data="'+row.id+'" data-name="'+row.plaza+'"><i class="fas fa-edit fa-2x"></i></a>';
                                /*<a href="#" class="editCPPlaza" data-id="'+row.id+'" data-name="'+row.nombre+'"></i><i class="fas fa-plus-square fa-2x" style="color:green"></i></a>';*/
                            }
                        }
                    ]
                });

                $(document).on('click','.editPlaza', function() {
                    var plazaid = $(this).attr('data');
                    var plazaName = $(this).attr('data-name');
                    $("#plazaId").val(plazaid);
                    $("#newPlazaName").val(plazaName);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'getTerritoriosSelected', plazaId: plazaid },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            
                            $("#listTerritorio").html(data);

                            $("#listTerritorio").multiselect('refresh');
                            $("#newTerritorio").modal('show');
                            
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });
                    
                })
            

                $(document).on('click','.editCPPlaza', function() {
                    var id = $(this).data("id");
                    var name = $(this).data("name");
                    window.location.href = "cpxplazas.php?plazaId="+id+"&nombre="+name;
                   
                })

               

                $("#territorios").on('change',function() {
                    plazas.ajax.reload();
                })

                $("#btnRegistrar").on('click', function() {
                    alert("Grabar");
                    $("#showEvento").modal("hide")
                })
/*
                $("#territorios").on("change", function() {
                    territorios.ajax.reload();
                })*/

                $("#btnNewPlaza").on('click', function() {

                    $("#newPlazaTerritorio").modal('show');

                    /*$('option', $('#listTerritorio')).each(function(element) {
                        $(this).removeAttr('selected').prop('selected', false);
                    });

                    $("#listTerritorio").multiselect('refresh');
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'getTerritoriosSelected', plazaId: 0 },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            
                            $("#listTerritorio").html(data);
                            $("#listTerritorio").multiselect('refresh');
                            $("#newTerritorio").modal('show');
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });*/

                })

               /*
                $(document).on('click','.cpPlazas', function() {
                    var plazaid = $(this).attr('data');
                    var plazaName = $(this).attr('data-name');
                    $("#plazaId").val(plazaid);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'getCPbyPlaza', plazaId: plazaid },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            
                            $("#listTerritorio").html(data);

                            $("#listTerritorio").multiselect('refresh');
                            $("#newTerritorio").modal('show');
                            
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });
                    
                })
                */
                $("#btnGrabarNuevo").on("click",function() {

                    var territoriosSel = JSON.stringify( $("#listTerritorio").val() );
                    var plazaId = $("#plazaId").val();

                    $.ajax({
                        type: 'POST',
                        url: 'modelos/plazas_db.php', // call your php file
                        data: { module: 'saveNewPlaza', plazaid : plazaId, territorios : territoriosSel },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            if (data > 0) 
                            {
                                $.toaster({
                                    message: 'Se actualizó el territorio ligado a la plaza',
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                                ("#newTerritorio").modal('hide');
                                plazas.ajax.reload();

                            }
                            else
                            {
                                $.toaster({
                                    message: 'No se actualizó',
                                    title: 'Aviso',
                                    priority: 'danger'
                                });
                            }
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });

                });

                $("#btnNuevoTP").on("click",function(){
                    var nuevaPlaza = $("#plazaN").val();
                    var nuevoTerr = $("#territoriosL").val();

                    if ( $("#plazaN").val() == "0" || $("#territoriosL").val() == "0" ) 
                    {
                        $.toaster({
                            message: 'Favor de seleccionar plaza y territorial',
                            title: 'Aviso',
                            priority:'warning'
                        });

                    }
                    else
                    {
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/plazas_db.php',
                            data: { module:'guardarPlazaTerritorio', plaza: nuevaPlaza, territorio : nuevoTerr },
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                if (data > 0) 
                                {
                                    $.toaster({
                                        message: 'Se guardó con éxito',
                                        title: 'Aviso',
                                        priority:'success'
                                    });
                                    $("#newPlazaTerritorio").modal('hide');
                                    plazas.ajax.reload();

                                }
                                else
                                {
                                    $.toaster({
                                        message: 'Hubo un error',
                                        title: 'Aviso',
                                        priority: 'warning'
                                    })
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                alert(data);
                            }
                        })
                    }

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

            
        function getTerritorios() {

            $.ajax({
                type: 'POST',
                url: 'modelos/plazas_db.php', // call your php file
                data: { module: 'getTerritorios' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#territorios").html(data);
                    $("#territoriosL").html(data);
                     
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
                }
            });
        } 

        function getPlazas() {

            $.ajax({
                type: 'POST',
                url: 'modelos/plazas_db.php', // call your php file
                data: { module: 'getPlazas' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#plazaN").html(data);        
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
                }
            });
        } 

         


        function cleartext() {
            $("#newCP").val("");
          

        }


    </script> 
  
</body>

</html>