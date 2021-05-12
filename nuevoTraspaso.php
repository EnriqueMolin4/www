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
            <div id="overlay" class="overlay">
           
            </div>
            <div class="page-title">
                <h3>NUEVO TRASPASO</h3>
            </div>

            <div class="container-fluid p-3 panel-white">
                
                <div class="row  mb-4">
                    <div class="col">
                        <label for="addtipo_traspaso" class="col-form-label-sm">TIPO TRASPASO</label>
                        <select id="addtipo_traspaso" name="addtipo_traspaso" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">TECNICO</option>
                                <option value="2">ALMACEN</option>
                        </select>
                    </div>    
                </div>
                <div class="row  mb-4">
                    <div class="col-5">
                        <label for="addtipo_producto" class="col-form-label-sm">TIPO</label>
                        <select id="addtipo_producto" name="addtipo_producto" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">TPV</option>
                                <option value="2">SIM</option>
                                <option value="3">Insumos</option>
                        </select>
                    </div>  
                    <div class="col showTecnico">
                        <label for="add-tecnico" class="col-form-label-sm">TECNICO</label>
                        <select id="add-tecnico" name="add-tecnico" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>   
                    <div class="col showAlmacen">
                        <label for="add-almacen" class="col-form-label-sm">ALMACEN</label>
                        <select id="add-almacen" name="add-almacen" class="form-control form-control-sm">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>   
                </div>
                <div class="row  mb-4">
                    <div class="col-6 showNoSerie">
                        <label for="add_no_serie" class="col-form-label-sm">NO. SERIE</label>
                        <input type="text" class="form-control form-control-sm" id="add_no_serie" name="add_no_serie">
                    </div> 
                    <div class="col-6 showNoGuia">
                        <label for="add_no_guia" class="col-form-label-sm">NO GUIA</label>
                        <input type="text" class="form-control form-control-sm" id="add_no_guia" name="add_no_guia">
                    </div>  
                </div>
                <div class="row  mb-4 showInsumo">
                    <div class="col">
                        <label for="add-insumo" class="col-form-label-sm">INSUMO</label>
                        <select id="add-insumo" name="add-insumo" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>  
                    <div class="col">
                        <label for="cant-insumo" class="col-form-label-sm">INV ACTUAL</label>
                        <input type="text" class="form-control form-control-sm" id="cant-insumo" name="cant-insumo" readonly> 
                    </div>  
                    <div class="col">
                        <label for="add-cantidad" class="col-form-label-sm">CANTIDAD</label>
                        <input type="text" class="form-control form-control-sm" id="add_cantidad" name="add_cantidad">
                    </div>  
                   
                </div> 
                <div class="col-form showProduct"> 
                    <div class="row">
                        <div class="col">
                        <label for="add-product" class="col-form-label-sm">Producto por Asignar</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <textarea style="resize:none;  overflow-y: scroll;height: 100px;" rows="10" cols="30" id="add-product" name="add-product" readonly></textarea>
                        </div>
                    </div>
                </div> 
                <div class="row">
                <div class="col" style="padding-top:10px;">  
                    <button class="btn btn-success" id="btnGrabar" name="btnGrabar">Grabar</button>
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
    <script type="text/javascript" src="js/nuevoTraspaso.js"></script> 
</body>

</html>