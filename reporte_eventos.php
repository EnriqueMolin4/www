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
                <h3>REPORTE VISITAS</h3>
            
                    <div id="container" class="container">
                        <form action="modelos/reportes_db.php">
                            <div class="row">
                                <div class="col">
                                    <label for="fechaVen_inicio" class="col-form-label-sm">DESDE</label>
                                    <input type="text" class="form-control form-control-sm " id="fechaVen_inicio" name="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                                </div>
                                <div class="col">
                                    <label for="fechaVen_fin" class="col-form-label-sm">HASTA</label>
                                    <input type="text" class="form-control form-control-sm" id="fechaVen_fin" name="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                                </div>
                                <div class="col">
                                    <label for="tipo_evento" class="col-form-label-sm">TIPO EVENTO</label>
                                    <select id="tipo_evento" name="tipo_evento" class="form-control form-control-sm searchEvento">
                                            <option value="0" selected>Seleccionar</option>
                                        </select>
                                </div>
                                <div class="col">
                                    <label for="estatus_busqueda" class="col-form-label-sm">ESTATUS</label>
                                    <select id="estatus_busqueda" name="estatus_busqueda" class="form-control form-control-sm searchEvento">
                                            <option value="0" selected>Seleccionar</option>
                                            <option value="1">Abierto</option>
                                            <option value="2">En Ruta</option>
                                            <option value="3">Cerrado</option>
                                        </select>
                                </div>
                                
        
                            </div>
                            <br />
                            <div class="row">
                                <div class="col">
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </div>
                            <input type="hidden" id="module" name="module" value="reporte_eventos">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/reportes.js"></script> 
</body>

</html>