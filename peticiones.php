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
         <div class="container-fluid p-5">
            <h3>Peticiones</h3>
            <div class="row">
               <div class="col-4 p-3">
                  <a href="nuevapeticion.php" class="btn btn-success" id="btnNuevo">Nueva Peticion</a>
               </div>
            </div>
            <div class="row">
               
            </div>
            <hr>
            <div class="row">
               <div class="col-4 p-3">
                  <label for="activa" class="col-form-label-sm">Filtrar Por:</label>
                  <select name="activa" id="activa" class="form-control form-control-sm searchPeticiones">
                     <option value=" " selected>Seleccionar</option>
                     <option value="0">ACTIVA</option>
                     <option value="1">SURTIDA</option>
                  </select>
               </div>
               <div class="col-4 p-3">
                  <label for="supervisores" class="col-form-label-sm">Seleccionar Supervisor</label>
                  <select id="supervisores" name="supervisores" class="form-control form-control-sm searchPeticiones">
                     <option value="0" selected>Seleccionar</option>
                  </select>
               </div><br>
               <!-- <div class="col-4 p-3">
                  <label for="plazas" class="col-form-label-sm">Plazas</label>
                  <select id="plazas" name="plazas" class="form-control form-control-sm searchPeticiones">
                      <option value="0" selected>Seleccionar</option>
                  </select>
                  </div> -->
            </div>
            <div class="table-responsive">
               <table class="table display table-responsive nowrap" id="tplPeticiones" style="width:100%">
                  <thead>
                     <tr>
                        <th width="10%">ID</th>
                        <th width="15%">ESTATUS</th>
                        <th width="15%">SUPERVISOR</th>
                        <th width="15%">CREADO POR</th>
                        <th width="15%">TECNICO</th>
                        <th width="10%">ALMACEN</th>
                        <th width="10%">FECHA</th>
                        <th width="10%">ACCION</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </main><br><br>
      <!-- page-content" -->
   </div>
   <!-- using online scripts -->
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <scrip src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js">
   </script>
   <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
      crossorigin="anonymous"></script>
   <!--
      <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
      -->
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
      crossorigin="anonymous"></script>
   <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
   <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
   <script src="js/jquery-ui.min.js"></script>
   <script src="js/moment-with-locales.js"></script>
   <script src="js/Chart.bundle.min.js"></script>
   <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
   <script type="text/javascript" src="js/jquery.toaster.js"></script>
   <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
   <script src="js/main.js"></script>
   <script type="text/javascript" src="js/peticiones.js"></script> 
   <style>
      .dataTables_filter {
      text-align: left !important;
      }
   </style>
</body>
</html>