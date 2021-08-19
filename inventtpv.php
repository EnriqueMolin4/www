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
                    <div class="col-md-5"><h3>Inventario TPV</h3></div>
                </div>
                    <div class="row">
                        <div class="col-sm-5"> 
                            <label for="excelMasivo" class="col-form-label-sm">Carga Masiva Inventario</label> 
                            <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                            <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                        </div>                        
                    </div>
                    <table id="example"  class="table  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Serie</th>
                                <th>Modelo</th>
                                <th>Fabricante</th>
                                <th>Conectividad</th>
                                <th>Fecha de Alta</th>
                                <th>Ubicacion Fisica</th>
                                <th>Historia</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No Serie</th>
                                <th>Modelo</th>
                                <th>Fabricante</th>
                                <th>Conectividad</th>
                                <th>Fecha de Alta</th>
                                <th>Ubicacion Fisica</th>
                                <th>Historia</th>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" id="noSerie" name="noSerie" value="0">

                <!-- MODAL -->
                <div class="modal fade" tabindex="-1" role="dialog" id="showHistoria" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Historia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <table id="historia-tpv"  class="display table table-md table-bordered " style="width=100%;">
                                <thead>
                                    <tr>
                                        <th>Fecha Movimiento</th>
                                        <th>Movimiento</th>
                                        <th>Producto</th>
                                        <th>No Serie</th>
                                        <th>Ubicacion</th>
                                        <th>Id_Ubicacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Fecha Movimiento</th>
                                        <th>Movimiento</th>
                                        <th>Producto</th>
                                        <th>No Serie</th>
                                        <th>Ubicacion</th>
                                        <th>Id_Ubicacion</th>
                                    </tr>
                                </tfoot>
                            </table>
                    <br />
                        <h5>Traspaso</h5>
                        <div class="row">
                            <div class="col">
                                <label for="hist-producto" class="col-form-label-sm">Producto</label>
                                <input type="text" class="form-control form-control-sm" id="hist-producto" aria-describedby="hist-producto" readonly>
                            </div>
                            <div class="col">
                                <label for="hist-noserie" class="col-form-label-sm">No Serie</label>
                                <input type="text" class="form-control form-control-sm" id="hist-noserie" aria-describedby="hist-noserie" readonly>
                            </div>
                            <div class="col">
                                <label for="hist-desde" class="col-form-label-sm">Desde</label>
                                <select id="hist-desde" name="hist-desde" class="form-control form-control-sm" readonly>         
                                </select>
                            </div>
                            <div class="col">
                                <div col="col">
                                <label for="hist-hacia" class="col-form-label-sm">Hacia</label>
                                <select id="hist-hacia" name="hist-hacia" class="form-control form-control-sm">            
                                </select>
                                </div>
                            </div>
                            <div class="col">   
                                <label for="hist-tecnico" class="col-form-label-sm">Tecnico</label>
                                <select id="hist-tecnico" name="hist-tecnico" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>            
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <br />
                                <button id="btnTraspasar" name="btnTraspasar" class="btn btn-success">Traspasar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="0" id="noSerie" name="noSerie">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>

                <div class="modal fade" id="showAvisosCargas" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                
                                </div>
                                <div class="modal-body" >
                                    <div style="overflow-y: scroll; height:400px;" id="bodyCargas">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                                
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
    <script type="text/javascript" src="js/inventario_tpv.js"></script> 
</body>

</html>