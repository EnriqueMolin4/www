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
            <h3>Inventario Tecnico</h3>
           
            <h5>Busqueda</h5>
                <div class="row  mb-4">
                    <div class="col">
                        <label for="tipo_producto" class="col-form-label-sm">Tipo</label>
                        <select id="tipo_producto" name="tipo_producto" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">TPV</option>
                                <option value="2">SIM</option>
                                <option value="3">Insumos</option>
                                <option value="4">Accesorios</option>
                        </select>
                    </div>  
                    <div class="col">
                        <label for="tecnico" class="col-form-label-sm">Tecnico</label>
                        <select id="tecnico" name="tecnico" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>  
                    <div class="col">
                        <label for="estatus" class="col-form-label-sm">Estatus</label>
                        <select id="estatus" name="estatus" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>    
                </div>
                <div class="row">
				<?php if( searchMenuEdit($_SESSION['Modules'],'url','inventariotecnico') == '1') { ?>
                    <div class="col">
                        <a href="#" class="btn btn-success" id="btnCrearTraspasoDañado">Crear Envio hacia Almacen</a>
                    </div>
				<?php } ?>
                </div>
                <table id="inventario"  class="table table-md table-bordered ">
                    <thead>
                        <tr>
                            <th>Tecnico</th>
                            <th>Producto</th>
                            <th>No Serie</th>
							<th>Modelo</th>
                            <th>Conectividad</th>
                            <th>Aplicativo</th>
                            <th>Cantidad</th>
                            <th>Estatus</th>
                            <th>Fecha Actualizacion</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
                <br />
				<input type="hidden" id="almacenId" name="almacenId" value="<?php echo $_SESSION['almacen']; ?>">
                <input type="hidden" id="tecnicoId" name="tecnicoId" value="0">
                
            </div>
        </main>
        <!-- page-content" -->
        
    </div>
    <div class="modal fade" tabindex="-2" role="dialog" id="showTraspaso" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Envio</h5>
    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">Origen Tecnico: <span id="desdeEnvio"></span></div>
                        <div class="col">Destino Almacen : Almacen MTY</div>
                    </div>
                    <br \>
                    <div class="form-group">
                        <label for="noGuia">No Guia:</label>
                        <input type="text" class="form-control" id="noGuia">
                    </div>
                    <div class="form-group">
                        <label for="codigoRastreo">Codigo Rastreo:</label>
                        <input type="text" class="form-control" id="codigoRastreo">
                    </div>                
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelar">Cancelar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnGrabar">Grabar</button>
                </div>
            </div> 
        </div>
    </div>
	<div class="modal fade" tabindex="-1" role="dialog" id="showHistoria" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <table id="historia"  class="display table table-md table-bordered " width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha Movimiento</th>
                                    <th>Movimiento</th>
                                    <th>Cantidad</th>
                                    <th>Estatus Ubicacion</th>
                                    <th>Ubicacion</th>
                                    <th>Id</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Fecha Movimiento</th>
                                    <th>Movimiento</th>
                                    <th>Cantidad</th>
                                    <th>Estatus Ubicacion</th>
                                    <th>Ubicacion</th>
                                    <th>Id</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="noSerie" name="noSerie">
                    <!-- <input type="hidden" value="0" id="Tec" name="Tec"> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
           </div>
        </div>
    </div>
   
    
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
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
    <script type="text/javascript" src="js/inventariotecnico.js"></script> 
</body>

</html>