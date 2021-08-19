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
            <h3>Trapasos</h3>
            <div class="row">
			<?php if( searchMenuEdit($_SESSION['Modules'],'url','traspasos') == '1') { ?>
                <div class="col-sm-8">
                    <label for="excelMasivo" class="col-form-label-sm">Creacion Traspasos Masivos</label> 
                    <input class="input-file" type="file" id="excelMasivoTraspasos" name="excelMasivoAsignacion">
                    <button class="btn btn-success btn-sm" id="btnCargarExcelTraspasos">Cargar</button>
                </div>
				<div class="col-sm-4">
					<a href="layouts/LayoutCargaMasivaTraspasos.xlsx" class="btn btn-primary" download>Descargar Layout</a>
				</div>
			<?php } ?>
            </div>
            <h5>Busqueda</h5>
                <div class="row  mb-4"> 
                    <div class="col">
                        <label for="almacen" class="col-form-label-sm">Almacenes</label>
                        <select id="almacen" name="almacen" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
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
                        <select name="estatus" id="estatus" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                <option value="EN TRANSITO">EN TRANSITO</option>
                                <option value="ACEPTADO">ACEPTADO</option>
                        </select>
                    </div>   
                </div>
                <table id="traspasos"  class="table table-md table-bordered ">
                    <thead>
                        <tr>
                            <th>No Guia</th>
                            <th>C Rastreo</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody> 
                    
                    </tbody>
                </table>
                <br />
                <input type="hidden" id="no_guia" name="no_guia" value="0">
				<input type="hidden" id="userPerm" value="<?php echo isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : 0 ; ?>">
            </div>
        </main>
        <!-- page-content" -->
        
    </div>
    <div class="modal fade" id="showAvisosCargas" role="dialog">
        <div class="modal-dialog">
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
                    <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="showDetalle" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog mw-100 w-75" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Traspaso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-mb-6 p-2"><p class="text-uppercase">No Serie: <span class="font-weight-bold" id="noGuia_det"></span></p></div>
                            <div class="col-mb-4 p-2"><p class="text-uppercase">Codigo Rastreo: <span class="font-weight-bold" id="codigorastreo_det"></span></p></div>
                        </div>
                        <div class="row">
                            <div class="col-mb-6 p-2"><p class="text-uppercase ">Origen: <span class="font-weight-bold" id="origen_det"></span></p></div>
                            <div class="col-mb-4 p-2"><p class="text-uppercase">Destino: <span class="font-weight-bold" id="destino_det"></span></div>
                        </div>
                    </div>   
                    <table id="traspasositems"  class="table table-md table-bordered " style="width:100%">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>No Serie</th>
                                <th>Modelo</th>
                                <th>Cantidad</th>
                                <th>Notas</th>
                                <th>Aceptada</th>
                                <th>Fecha Actualizacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody> 
                        
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="noGuia" name="noGuia">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancel" name="brnCancel">Cerrar</button>
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
    <script type="text/javascript" src="js/traspasos.js"></script> 
</body>

</html>