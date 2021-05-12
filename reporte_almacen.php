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
        <main class="page-content">
            <div id="overlay" class="overlay"></div>
            <div class="page-title">
                <h3>REPORTE ALMACEN</h3>
            </div>
            <div class="container-fluid p-4 panel-white">
            
			
            <h5>BUSQUEDA</h5>
            <div id="container" class="col">
                <form action="modelos/reportes_db.php">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="tipo_producto" class="col-form-label-sm">TIPO</label><br>
                            <select hidden id="tipo_producto" name="tipo_producto[]" class="custom-select form-control-sm searchInventario" multiple>
                                    <option value="1">TPV</option>
                                    <option value="2">SIM</option>
                                    <option value="3">Insumos</option>
                                    <option value="4">Accesorios</option>
                            </select>
                        </div>   
                        <div class="col-sm-3">
                            <label for="tipo_ubicacion" class="col-form-label-sm">UBICACION</label><br>
                                <select hidden id="tipo_ubicacion" name="tipo_ubicacion[]" class="custom-select form-control-sm searchInventario" multiple>
                                    
                                </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="tipo_estatusubicacion" class="col-form-label-sm">ESTATUS UBICACION</label><br>
                                <select hidden id="tipo_estatusubicacion" name="tipo_estatusubicacion[]" class="custom-select form-control-sm searchInventario" multiple>
                                        
                                </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="tipo_estatus" class="col-form-label-sm">ESTATUS</label><br>
                                <select hidden id="tipo_estatus" name="tipo_estatus[]" class="custom-select form-control-sm searchInventario" multiple>
                                        
                                </select>
                        </div>
                        
            
                    </div>
                    <br />
                    <div class="row">
                        <div class="col">
                            <input type="submit" class="btn btn-success">
                        </div>
                    </div>
                    <input type="hidden" id="module" name="module" value="reporte_almaceninv">
                </form>

               
            </div>
				<div class="d-flex justify-content-end">
				</div>
            </div>
        </main>


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
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="js/reportes.js"></script> 
    <style>
        .multiselect {
          background-color: initial;
          border: 1px solid #ced4da;
          width: 270px;
          height: auto;

        }

        .multiselect-container
        {
            height: 240px  ;  
            width: 290px;
            overflow-x: hidden;
            overflow-y: scroll; 
        }
    </style>
</body>


</html>