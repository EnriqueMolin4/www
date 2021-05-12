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
                <h3>EVALUACIONES</h3>
            </div>
            <div class="container-fluid p-3 panel-white">
                
                    <h5>NUEVA EVALUACION</h5>
                    <div class="row">
                        <div class="col-4">
                            <label for="nombre" class="col-form-label-sm">NOMBRE DE LA EVALUACION</label>
                            <input type="text" name="nombre" class="form-control form-control-sm" id="nombre" onkeyup="enableBtn();">
                        </div>

                        <div class="col-4">
                            <label for="descripcion" class="col-form-label-sm">DESCRIPCION</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" onkeyup="enableBtn();"></textarea>
                        </div>  
                    </div>
                    <hr>
                    <br>
                    <div id="evFile" style="display: none;">
                     <h5>CARGAR PREGUNTAS Y RESPUESTAS</h5>
                    <div class="row p-3">

                        <div class="col-sm-5"> 
                            <!--<label for="excelMasivo" class="col-form-label-sm">CARGAR EVALUACION</label>-->
                            <input class="input-file" type="file" id="excelMasivoE" name="excelMasivoE">
                            <button class="btn btn-success btn-sm" id="btnFileTest" hidden>Cargar</button>
                        </div>
                    </div> <hr>                  
                    </br>   
                    </div> 
                    
                   
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-success" id="btnGuardar" name="btnGuardar">Guardar Evaluación</button>
                        </div>
                    </div>
                     </br>
                     <button type="button" class="btn btn-primary asignar" value="0" name="btnAsignar" id="btnAsignar">Asignar Evaluaciones</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="evaluaciones" class="table table-bordered table-responsive" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="300px">NOMBRE</th>
                                    <th width="300px">DESCRIPCIÓN</th>
                                    <th width="300px">FECHA CREACION</th>
                                    <th width="200px">ARCHIVO</th>
                                    <th width="200px">FECHA MODIFICACION</th>
                                    <th width="200px">ACCION</th>

                                </tr>
                            </thead>
                                <tbody>
                                    
                                </tbody>
                            
                            </table>
                    </div>
                    
                    </div>
            </div> 
        </main>
        <!-- page-content" -->
        <!-- MODAL ASIGNAR -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modalAsignar" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>ASIGNAR EVALUACIONES</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm" name="frm">
                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label-sm" for="tecnicos">TECNICOS</label><br>
                                    <select hidden name="tecnicos[]" id="tecnicos" class="custom-select form-control-sm" multiple></select>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label-sm" for="evaluacionList">EVALUACIONES</label>
                                    <select style="text-align: center;text-align-last: center;-moz-text-align-last: center;" name="evaluacionList" id="evaluacionList" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                                    </select>
                                    
                                </div>
                            </div>
                            
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnAsignarEv">Asignar</button>
                    </div>
                </div>
                
            </div>
        </div>
        
</div>
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
    <script src="js/evaluaciones.js"></script> 
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript">

         function enableBtn()
         {
            var n = document.getElementById("nombre");
            var d = document.getElementById("descripcion");

            if (n.value.length > 0 && d.value.length > 0) 
            {
                document.getElementById("evFile").style.display = '';
            }

        }

        function cleartext()
        {
            //$('#tecnicos').multiselect('refresh');
            $('#tecnicos').val('').multiselect('refresh');
            //$("#evaluaciones").val("");
        }


        $('#modalAsignar').on('hide.bs.modal',function (e){
            cleartext()
        })

    </script>
    <style>
        .multiselect {
          background-color: initial;
          border: 1px solid #ced4da;
          width: 765px;
          height: auto;

        }

        .multiselect-container
        {
            height: 200px;  
            width: 700px;
            overflow-x: hidden;
            overflow-y: scroll; 
        }

    </style>
</body>

</html>