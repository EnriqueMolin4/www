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
                <h3>SUPERVISORES</h3>
            </div>
            <div class="container-fluid p-2 panel-white">
            
            <div class="row">
                <div class="col-sm-4 p-4">           
                    <label for="territorial" class="col-form-label-sm">TERRITORIOS</label>
                    <select id="territorial" name="territorial" class="form-control form-control-sm">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 p-4">  
                <label for="supervisores" class="col-form-label-sm">SUPERVISORES</label>
                    <table id="supervisores"  class="table table-md table-bordered ">
                        <thead>
                            <tr>
                                <th>SUPERVISORES</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
                
            </div>
                <fieldset class="border p-2">
                    <legend>AGREGAR CODIGO POSTAL</legend>
                    <div class="row">
                        <div class="col-md-12 p-4">
 
                            <label for="newCP" class="col-form-label-sm">CODIGO POSTAL</label>
                            <input type="text" id="newCP" name="newCP">
                            <button class="btn btn-success btn-sm" id="btnAddCP">Agregar</button>
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
    var supervisores;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "territorioslink")
            getTerritorios();
          
            supervisores = $("#supervisores").DataTable({
                language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                        url: 'modelos/territorial_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTableSupervisores'
                        }
                },
                columns : [
                    { data: 'nombre' },
                    { data: 'id'}
                ],
                aoColumnDefs: [
                    {
                        "targets": [1],
                        "mRender": function ( data,type, row ) {
                            return '<a href="#" class="delSupervisor" data="'+row.id+'"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                        }
                    }
                ]
            });

            

            $("#territorial").on('change',function() {
                territorial.ajax.reload();
                plazas.ajax.reload();
            })

            $("#btnRegistrar").on('click', function() {
                alert("Grabar")
                $("#showEvento").modal("hide")
            })

            

            $("#btnAddCP").on('click', function() {
                if( $("#territorial").val() == "0" ) {
                    alert("Necesitas seleccionar un Territorio");
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/territorial_db.php', // call your php file
                        data: { module: 'addCP', cp: $("#newCP").val(), territorial: $("#territorial").val() },
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            $("#tecnicoId").val("");
                            $("#newTecnico").val("");
                            territorial.ajax.reload();
                                
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                        }
                    });
                }
            })

            $(document).on('click','.delPlaza', function() {
                var cpid = $(this).attr('data');

                var r = confirm("Se borrará la plaza ¿Continuar?");

                if(r == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'modelos/territorial_db.php', // call your php file
                        data: { module: 'plazaDelete',cpid: cpid },
                        cache: false,
                        success: function(data){
                            if(data == "1") {
                                $.toaster({
                                    message: 'Se borró con éxito  ',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                                plaza.ajax.reload();
                            }
                        }
                    });
                }
            })
         
            $("#btnCargarExcel").on("click",function() {
                var form_data = new FormData();
                var excelMasivo = $("#excelMasivo");
                var file_data = excelMasivo[0].files[0];
                form_data.append('file', file_data);
                form_data.append('module','TerritoriosMasivo');
                $.toaster({
                    message: 'Inicia la Carga Masiva de CP por Territorio',
                    title: 'Aviso',
                    priority : 'success'
                });  
                $.ajax({
                    type: 'POST',
                    url: 'modelos/territorial_db.php', // call your php file
                    data: form_data,
                    processData: false,
                contentType: false,
                    success: function(data, textStatus, jqXHR){
                        var info = JSON.parse(data);

                        if(info.plazaNoCargadas > 0 ) {
                            $.toaster({
                                message: 'No Se Cargaron '+info.plazaNoCargadas+' CP',
                                title: 'Aviso',
                                priority : 'danger'
                            });  
                        }

                        if(info.plazaCargados > 0 ) {
                            $.toaster({
                                message: 'Se Cargaron '+info.plazaCargados+' Cp',
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
                url: 'modelos/territorial_db.php', // call your php file
                data: { module: 'getTerritorios' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#territorial").html(data);
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
                }
            });
        } 

        function getSupervisores() {
            
            $.ajax({
                type: 'POST',
                url: 'modelos/territorial_db.php', // call your php file
                data: { module: 'getSupervisores' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#territorial").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(data)
                }
            });
        }

        function getPlazas() {
            
            $.ajax({
                type: 'POST',
                url: 'modelos/territorial_db.php', // call your php file
                data: { module: 'getPlazas' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#plazas").html(data);
                    
                    
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