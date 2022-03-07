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
        <main class="page-content pt-4">
            <div id="overlay" class="overlay"></div>
            <div class="container" style="max-width: 1402px!important;">
               <h3>Nueva Petición</h3>
               <div class="row">
                  <div class="col-sm">
                     <label for="tipo_envio" class="col-form-label-sm">Tipo de Envío</label>
                     <select name="tipo_envio" id="tipo_envio" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                        <option value="DIA SIGUIENTE">DIA SIGUIENTE</option>
                        <option value="TERRESTRE">TERRESTRE</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="direccion_envio" class="col-form-label-sm">Dirección de Envío</label>
                     <select name="direccion_envio" id="direccion_envio" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                        <option value="DOMICILIO">DOMICILIO</option>
                        <option value="OCURRE">OCURRE</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="tipo_peticion" class="col-form-label-sm">Tipo Petición</label>
                     <select name="tipo_peticion" id="tipo_peticion" class="form-control form-control-sm searchInventario" onchange="campos_tipo()">
                        <option value="0">Seleccionar</option>
                        <option value="1">Petición Técnico</option>
                        <option value="2">Peticion entre Almacenes</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm" style="display:none" id="almD">
                     <label for="almacen_destino" class="col-form-label-sm">Almacén Destino</label>
                     <select name="almacen_destino" id="almacen_destino" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col-sm" style="display:none" id="almO">
                     <label for="almacen_origen" class="col-form-label-sm">Almacen Origen</label>
                     <select name="almacen_origen" id="almacen_origen" class="form-control form-control-sm searchInventario">
                     </select>
                  </div>
                  <div class="col-sm" style="display:none" id="divPlaza">
                     <label for="plaza" class="col-form-label-sm">Plaza</label>
                     <select id="plaza" name="plaza" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col-sm" style="display:none" id="divTecnico">
                     <label for="tecnico" class="col-form-label-sm">Técnico</label>
                     <select id="tecnico" name="tecnico" class="form-control form-control-sm searchInventario" required>
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                     <label for="tipo" class="col-form-label-sm">Tipo</label>
                     <select id="tipo" name="tipo" class="form-control form-control-sm searchInventario" onchange="campos_tipo()">
                        <option value="0" selected>Seleccionar</option>
                        <option value="1" >TPV</option>
                        <option value="2" >SIM</option>
                        <option value="3" >INSUMOS</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="estatus" class="col-form-label-sm">Estatus</label>
                     <select id="estatus" name="estatus" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                        <option value="3">DISPONIBLE-USADO</option>
                        <option value="5">DISPONIBLE-NUEVO</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="banco" class="col-form-label-sm">Banco</label>
                     <select name="banco" id="banco" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col" style="display:none" id="divCarrier"> 
                     <label for="carrier" class="col-form-label-sm">Carrier</label>
                     <select id="carrier" name="carrier" class="form-control form-control-sm searchInventario">
                     </select>
                  </div>
               </div>
               <div class="row" style="display:none" id="divTpv">
                  <div class="col-sm">
                     <label for="conectividad" class="col-form-label-sm">Conectividad</label>
                     <select id="conectividad" name="conectividad" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="producto" class="col-form-label-sm">Producto</label>
                     <select id="producto" name="producto" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
               </div>
               <div class="row " style="display:none" id="divIns">
                  <div class="col-sm" >
                     <label for="insumo" class="col-form-label-sm">Tipo Insumo</label>
                     <select id="insumo" name="insumo" class="form-control form-control-sm searchInventario">
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm" style="display:none" id="divCan">           
                     <label for="cantidad" class="col-form-label-sm">Cantidad</label>
                     <input type="text" name="cantidad" class="form-control form-control-sm" id="cantidad">
                  </div>
                  <div class="col-sm">
                        <label for="comentario_supervisor" class="col-form-label-sm">Comentarios</label>
                        <textarea class="form-control form-control-sm" name="comentario_supervisor" id="comentario_supervisor" cols="10" rows="5"></textarea>
                    </div>
               </div>
            <br>
               <div class="row">
                  <div class="col-sm">
                     <button type="button" class="btn btn-success" id="btnAdd">Agregar</button>
                  </div>
               </div>
               <div class="table-responsive">
                  <table class="table table-md table-responsive table-bordered " id="tplDetalle" style="width:100%">
                     <thead>
                        <tr>
                           <th width="5%">BANCO</th>
                           <th width="10%">TIPO</th>
                           <th width="10%">ALMACEN DESTINO</th>
                           <th width="10%">ALMACEN ORIGEN</th>
                           <th width="10%">TECNICO</th>
                           <th width="10%">ESTATUS</th>
                           <th width="10%">INSUMO</th>
                           <th width="10%">CARRIER</th>
                           <th width="10%">CONECTIVIDAD</th>
                           <th width="10%">VERSION</th>
                           <th width="5%">CANTIDAD</th>
                           <th>banco</th>
                           <th>almacen_origen</th>
                           <th>almacen_destino</th>
                           <th>comentario_supervisor</th>
                           <th>tipo_envio</th>
                           <th>direccion_envio</th>
                           <th>tipoId</th>
                           <th>tecnicoId</th>
                           <th>estatusId</th>
                           <th>insumoId</th>
                           <th>carrierId</th>
                           <th>conectividadId</th>
                           <th>versionId</th>
                           <th>ACCION</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
               <div class="row p-3">
                  <div class="col-5 mb-2 row">
                     <button type="button" class="btn btn-warning mb-3 " id="btnRegresar">Regresar</button> 
                     <button type="button" class="btn btn-success mb-3 " id="btnPeticion">Realizar Petición</button>
                  </div>
               </div>
               <br />
               <input type="hidden" id="no_guia" name="no_guia" value="0">
               <input type="hidden" id="userId" name="userId" value="<?php echo ($_SESSION['territorial']); ?>">
               <input type="hidden" id="userPerm" value="<?php echo isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : 0 ; ?>">
            </div>
        </main>
        <!-- page-content" -->
        
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
    <script type="text/javascript" src="js/nuevapeticion.js"></script> 
</body>

</html>