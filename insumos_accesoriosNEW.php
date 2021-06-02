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
                <h3>INSUMOS & ACCESORIOS </h3>
            </div>
            <div class="container-fluid p-1">
            <div id="container" class="col-md-12 panel-white">
                
           
			<?php  
			if( searchMenuEdit($_SESSION['Modules'],'url','registroalmacen') == '1') { ?>
            <div class="row">
                <div class="col-sm-6">
                    <label for="excelMasivo" class="col-form-label-sm">Alta en Almacén Masivos</label> 
                    <input class="input-file" type="file" id="excelMasivoInventarios" name="excelMasivoInventarios">
                    <button class="btn btn-success btn-sm" id="btnCargarExcelInventarios">Cargar</button>
                    
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-warning btn-sm" id="btnUpdateExcelInventarios">Actualizar Series</button>
                </div>   
            </div>  <br> 


		    <?php } ?>
            <h5>BUSQUEDA</h5>
                <div class="row  mb-4">
                    <div class="col-sm-3">
                        <label for="tipo_producto" class="col-form-label-sm">TIPO</label>
                        <select id="tipo_producto" name="tipo_producto" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                <option value="3">Insumos</option>
                                <option value="4">Accesorios</option>
                        </select>
                    </div>   
                    
                </div>
				    <div class="table-responsive">
                        
                        <table id="inventario"  class="table table-md table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th width="200px">TIPO</th>
                                    <th width="200px">PRODUCTO</th>
                                    <th width="200px">ESTATUS</th>
                                    <th width="200px">UBICACION</th>
                                    <th width="200px">FECHA ACTUALIZACION</th>
                                    <th width="200px">FECHA CREACION</th>
                                    <th>CANTIDAD</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody>
                    
                            </tbody>
            
                        </table>
                    </div>
                <br />
				<input type="hidden" id="userPerm" value="<?php echo isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : 0 ; ?>">
            </div>
        </div>
        </main>
        <!-- page-content" -->
        <div class="modal fade" tabindex="-1" id="showAvisosCargas" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" >
                        <div style="overflow-y: scroll; height:400px;" id="bodyCargas">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="showHistoria" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">HISTORIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
                
                    <div class="table-responsive">
                        <table id="historia"  class="display table table-md table-bordered table-responsive" width="100%">
                        <thead>
                            <tr>
                                <th>FECHA MOVIMIENTO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>ESTATUS UBICACION</th>
                                <th width="200px">UBICACION</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>FECHA MOVIMIENTO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>ESTATUS UBICACION</th>
                                <th width="200px">UBICACION</th>
                                <th>ID</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
            
					<div class="modal-footer">
						<input type="hidden" value="0" id="noSerie" name="noSerie">
                        <input type="hidden" value="0" id="ubicacionId" name="ubicacionId">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="showDetalle" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETALLE DE SERIE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">           
							<label for="noserie" class="col-form-label-sm">NO SERIE</label>
							<input type="text" class="form-control form-control-sm" id="det-noserie" aria-describedby="odt" readonly>
						</div>
                        <div class="col-md-4" id="divModelo">           
							<label for="det-modelo" class="col-form-label-sm">MODELO</label>
							 <select id="det-modelo" name="det-modelo" class="form-control form-control-sm"></select>
						</div>
						<div class="col-md-4" id="divCarrier">           
							<label for="det-modelo" class="col-form-label-sm">CARRIER</label>
							 <select id="det-carrier" name="det-carrier" class="form-control form-control-sm"></select>
						</div>
                        <div class="col-md-4">           
							<label for="det-conectividad" class="col-form-label-sm">CONECTIVIDAD</label>
							 <select id="det-conectividad" name="det-conectividad" class="form-control form-control-sm">
                             </select>
						</div>
                    </div><br>
                    <div class="row">
						<div class="col-md-3">           
							<label for="estatus" class="col-form-label-sm">ESTATUS</label>
							 <select id="det-estatus" name="det-estatus" class="form-control form-control-sm"></select>
						</div>
						<div class="col-md-3">           
							<label for="det-estatus_inventario" class="col-form-label-sm">ESTATUS INVENTARIO</label>
							 <select id="det-estatus-inventario" name="det-estatus-inventario" class="form-control form-control-sm"></select>
						</div>
						<div class="col-md-3">           
							<label for="det-ubicacion" class="col-form-label-sm">UBICACION</label>
							 <select id="det-ubicacion" name="det-ubicacion" class="form-control form-control-sm"></select>
						</div>
                        <div class="col-md-2">           
							<label for="det-qty" class="col-form-label-sm">CANTIDAD</label>
                             <input type="text" class="form-control form-control-sm" id="det-qty" aria-describedby="qty" readonly>
						</div>
					</div>
					<br>
            
					<div class="modal-footer">
						 
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-success" id="btnCambiarInv">Guardar Cambios</a>
					</div>
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
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/insumosNEW.js"></script> 
</body>

</html>