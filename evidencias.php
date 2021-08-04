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
            <h3>Evidencias</h3>
            
                <h5>ODT</h5>
                <div class="row">
                    <div class="col">
                        <label for="evidencia_odt" class="col-form-label-sm">Vencimiento Desde</label>
                        <input type="text" class="form-control form-control-sm searchODT" id="evidencia_odt" aria-describedby="evidencia_odt">
                        <a href="#" id="btnBuscar" name="btnBuscar" class="btn btn-success">Buscar</a>
                    </div>
                    
                </div>
                <br />
                <div class="row">
                    <div class="col"><button class="btn btn-sucess" id="btnDescargar" name="btnDescargar">Descargar</button></div>
                </div>
                <div class="row">
                    <div id="checkboxes">
                        <div id="carruselFotos" name="carruselFotos">
                        </div>
                    </div>
                </div>

      
        </main>
        <!-- page-content" -->
    </div>
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/evidencias.js"></script> 
   
</body>

</html>