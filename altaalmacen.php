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
             <div class="row p-2">
                    <div class="col-md-8">
                        <label for="excelMasivo" class="col-form-label-sm">Carga Masiva Inventario</label> 
                        <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                        <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                    </div>
                </div>
            <div class="container-fluid p-5 panel-white">
            
               
                <div class="row">
                    <div id="avisos" class="display:none;" style="background-color:red;"></div>
                </div>
                <div class="row">
                    <div class="col">           
                        <label for="cve_banco" class="col-form-label-sm">CVE BANCO</label>
                        <select id="cve_banco" name="cve_banco" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col">           
                        <label for="almacen_producto" class="col-form-label-sm">PRODUCTO</label>
                        <select id="almacen_producto" name="almacen_producto" class="form-control form-control-sm">
                            <option value="0">Seleccionar</option>
                            <option value="1">TPV</option>
                            <option value="2">SIM</option>
                            <option value="3">Insumo</option>
                        </select>
                    </div>
                    
                </div>
      
            <br/>
            <div style=" padding: 10px; display:none;" id="altatpv">
                <div class="row">
                    <div class="col" id="tpvbk">           
                        <label for="select-modelo_tpv" class="col-form-label-sm">MODELOS TPV </label>
                        <select class="form-control form-control-sm" id= "select-modelo_tpv" name="select-modelo_tpv"></select>
                    </div>
                    <div class="col" id="carrierbk">           
                        <label for="select-carrier" class="col-form-label-sm">CARRIER </label>
                        <select class="form-control form-control-sm" id= "select-carrier" name="select-carrier"></select>
                    </div>
                    <div class="col" id="insumobk">           
                        <label for="select-insumo" class="col-form-label-sm">INSUMO </label>
                        <select class="form-control form-control-sm" id= "select-insumo" name="select-insumo"></select>
                    </div>
                    <div class="col" id="noseriebk">           
                        <label for="almacen-no_serie" class="col-form-label-sm">NO. DE SERIE*</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-no_serie" aria-describedby="almacen-no_serie">
                    </div>
                    <div class="col" id="cantidadbk">           
                        <label for="almacen-cantidad" class="col-form-label-sm">CANTIDAD</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-cantidad" aria-describedby="almacen-cantidad">
                    </div>
                    <div class="col" id="fabricantebk">           
                        <label for="almacen-fabricante" class="col-form-label-sm">FABRICANTE</label>
                        <select class="form-control form-control-sm" id="almacen-fabricante" name="almacen-fabricante" readonly>
                        <option value="0">Seleccionar</option>
                        </select>
                    </div>
                    <div class="col" id="connectbk">           
                        <label for="almacen-connect" class="col-form-label-sm">CONECTIVIDAD</label>
                        <select class="form-control form-control-sm" id="almacen-connect" name="almacen-connect" readonly>
                        <option value="0">Seleccionar</option>
                        </select>
                    </div>
                    <div class="col" id="ptidbk">           
                        <label for="almacen-ptid" class="col-form-label-sm">PTID*</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-ptid" aria-describedby="almacen-ptid">
                    </div>
                </div>
            </div>
            <div style=" padding: 10px; display:none;" id="altaalmacen">
                <div class="row">
                    <div class="col">           
                        <label for="select-estatus" class="col-form-label-sm">ESTATUS* </label>
                        <select class="form-control form-control-sm" id= "select-estatus" name="select-estatus">
                           

                        </select>
                    </div>
                    <div class="col" id="tarimabk">           
                        <label for="almacen-tarima" class="col-form-label-sm">TARIMA</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-tarima" aria-describedby="almacen-tarima">
                    </div>
                    <div class="col" id="anaquelbk">           
                        <label for="almacen-anaquel" class="col-form-label-sm">ANAQUEL</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-anaquel" aria-describedby="almacen-anaquel">
                    </div>
                    <div class="col" id="cajonbk">           
                        <label for="almacen-cajon" class="col-form-label-sm">CAJON</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-cajon" aria-describedby="almacen-cajon">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" style="padding-left:30px;padding-top:10px;">  
                    <button class="btn btn-dark" id="btnAsignar">Grabar</button>
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
    <script type="text/javascript" src="js/almacen.js"></script> 
</body>

</html>