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
                <h3>REPORTE DETALLE EVENTO</h3>
            
                    <div id="container" class="container">
                        <form method = "post" action="modelos/reportes_db.php">
                           
                           <div class="row">
                                <div class="col-sm-5">
                                    <label for="proveedor" class="col-form-label-sm">PROVEEDOR</label>
                                    <input type="text" class="form-control form-control-sm" id="proveedor" name="proveedor" value="Sinttecom" readonly>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-sm-3">
                                    <label for="fecha_alta" class="col-form-label-sm">FECHA ALTA SISTEMA</label>
                                    <input type="text" class="form-control form-control-sm" id="fecha_alta" name="fecha_alta" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                                </div>

                                <div class="col-sm-3">
                                    <label for="fecha_hasta" class="col-form-label-sm">HASTA</label>
                                    <input type="text" class="form-control form-control-sm" id="fecha_hasta" name="fecha_hasta" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                                </div>

                                <div class="col-sm-4">
                                    <label for="estado" class="col-form-label-sm">ESTADO</label><br>
                                    <select hidden name="estado[]" id="estado" class="custom-select form-control-sm" multiple>
                                        
                                    </select>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="tipo_servicio" class="col-form-label-sm">SERVICIO</label>
                                        <select name="tipo_servicio" id="tipo_servicio" class="form-control form-control-sm">
                                        </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="tipo_subservicio" class="col-form-label-sm">SUBSERVICIO</label>
                                        <select name="tipo_subservicio" id="tipo_subservicio" class="form-control form-control-sm">
                                            <option value="0">Seleccionar</option>
                                        </select>
                                </div>

                                <div class="col-sm-4">           
                                    <label for="estatus_servicio" class="col-form-label-sm">ESTATUS SERVICIO</label><br>
                                        <select hidden name="estatus_servicio[]" class="custom-select form-control form-control-sm" id="estatus_servicio" multiple>
                                            <option value="0">Seleccionar</option>
                                        </select>
                                </div>
                            </div>

                            </br>

                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="fecha_cierre">FECHA CIERRE</label>
                                    <input type="text" class="form-control form-control-sm" id="fecha_cierre" placeholder="Seleccionar Fecha" name="fecha_cierre" value="">
                                </div>
                            </div>

                            <br />
                            <div class="row">
                                <div class="col">
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </div>
                            <input type="hidden" id="module" name="module" value="reporte_detevento">
                        </form>

                       
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
    <script src="js/jquery.rotate.1-1.js"></script>
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script src="js/reporteDetEv.js"></script>
    <style>
        .multiselect {
          background-color: initial;
          border: 1px solid #ced4da;
          width: 270px;
          height: auto;

        }

        .multiselect-container
        {
            height: 200px  ;  
            overflow-x: hidden;
            overflow-y: scroll; 
        }
    </style>
</body>

</html>