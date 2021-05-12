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
                 <h3>IMAGENES</h3>
            </div>
            <div class="container-fluid p-5 panel-white">
               
					 
                    <div class="row">
                        <div id="avisos" class="display:none;" style="background-color:red;"></div>
                    </div>
                
                    <div id="progress"></div>
                    <div class="row">
                        <div class="col-sm-4">           
                            <label for="odt" class="col-form-label-sm">ESCRIBE LA ODT</label>
                            <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt"  style="text-transform:uppercase" >
                        </div>
                        <div class="col" style="padding-left:30px;padding-top:30px;">  
                            <button class="btn btn-primary" id="btnImagenes">Mostrar</button>
                        </div>
                    </div>
                    <br/><hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="file" class="form-control-file" id="fileToUpload" accept="image/*"  multiple>
                        </div>
                        <div class="col-sm-4" >  
                            <button class="btn btn-primary" id="btnSaveImagenes">AGREGAR IMAGEN</button>
                        </div>
                    </div>
                
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="showImagenes">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IMAGENES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9 anyClass" id="imagenSel"></div>
                            <div class="col-md-3 anyClass" id="carruselFotos"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    
    <script type="text/javascript" src="js/imagenes.js"></script> 
</body>

</html>