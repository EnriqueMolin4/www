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
                <h3>REGISTRO PARA ALMACEN</h3>
            </div>
            <div class="row p-3">
                <button class="btn btn-success" id="btnNewModelo">Nuevo Modelo</button>
            </div>
            <div class="container-fluid p-3 panel-white">
            
                <table id="modelos"  class="table table-md table-bordered ">
                    <thead>
                        <tr>
                            <th>MODELO</th>
                            <th>PROVEEDOR</th>
                            <th>CONECTIVIDAD</th>
                            <th>NO LARGO</th>
                            <th>ESTATUS</th>
                            <th>ACCION</th>
                            <th>proveedorid</th>
                            <th>estatusid</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>MODELO</th>
                            <th>PROVEEDOR</th>
                            <th>CONECTIVIDAD</th>
                            <th>NO LARGO</th>
                            <th>ESTATUS</th>
                            <th>ACCION</th>
                            <th>proveedorid</th>
                            <th>estatusid</th>
                        </tr>
                    </tfoot>
                </table>
                <input type="hidden" id="userId" value="0">
                
    
            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showModelo">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">MODELO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-4">           
                            <label for="modelo" class="col-form-label-sm">MODELO</label>
                            <input type="text" class="form-control form-control-sm" id="modelo" aria-describedby="modelo">
                        </div>
                        <div class="col-sm-4">           
                            <label for="proveedor" class="col-form-label-sm">PROVEEDOR</label>
                            <select id="proveedor" name="proveedor" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">           
                            <label for="conectividad" class="col-form-label-sm">CONECTIVIDAD</label>
                            <select id="conectividad" name="conectividad" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-sm-4">           
                            <label for="nolargo" class="col-form-label-sm">No. LARGO</label>
                            <input type="text" class="form-control form-control-sm" id="nolargo" aria-describedby="nolargo">
                        </div>
                        <div class="col-sm-4">           
                            <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                                <select id="estatus" name="estatus" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    
            
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="modeloId">
                    <button type="button" class="btn btn-primary" id="btnRegistrar">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    
    <script type="text/javascript" src="js/modelos.js"></script> 
</body>

</html>