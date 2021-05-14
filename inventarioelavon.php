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
        <main class="page-content pt-1">
            <div id="overlay" class="overlay">
           
            </div>
            <div class="page-title">
                <h3>INVENTARIO UNIVERSO ELAVON</h3>
            </div><br>
            <div class="row">
                <div class="col">
                        <label for="excelMasivo" class="col-form-label-sm">CARGA MASIVA INVENTARIO</label> 
                        <input class="input-file" type="file" id="excelMasivoInventarios" name="excelMasivoInventarios">
                        <button class="btn btn-success btn-sm" id="btnCargarExcelInventarios">Cargar</button>
                    </div>
            </div> 
             <div class="row">
                   <div class="col">  
                    <a href="#" class="btn btn-success" id="btnNuevoEvento">Agregar Nuevo</a>
                    </div>
                </div><br>
            <div class="container-fluid p-5 panel-white">
            
            <h5>BUSQUEDA</h5>
                <div class="row  mb-4">
                    <div class="col">
                        <label for="tipo_producto" class="col-form-label-sm">TIPO</label>
                        <select id="tipo_producto" name="tipo_producto" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">TPV</option>
                                <option value="2">SIM</option>
                        </select>
                    </div>     
                    <div class="col">
                        <label for="tipo_estatus" class="col-form-label-sm">ESTATUS</label>
                        <select id="tipo_estatus" name="tipo_estatus" class="form-control form-control-sm searchInventario">
                            <option value="0" selected>Seleccionar</option>
                            <option value="PERTENECE A ELAVON">PERTENECE A ELAVON</option>
                            <option value="DESTRUIDA ¡NO INSTALAR!">DESTRUIDA ¡NO INSTALAR!</option>
                            <option value="QUEBRANTADA ¡NO INSTALAR!">QUEBRANTADA ¡NO INSTALAR!</option>
                            <option value="PENDIENTE POR QUEBRANTAR">PENDIENTE POR QUEBRANTAR</option>
                            <option value="CANCELADO">CANCELADO</option>
                            <option value="ACTIVA">ACTIVA</option>
                        </select>
                    </div>   
                    
                </div>
				<div class="d-flex justify-content-end">

				</div>
                <div class="table-responsive">
                    <table id="inventario"  class="table table-md table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th width="300px">TIPO</th>
                                <th width="300px">NO SERIE</th>
                                <th width="300px">FABRICANTE</th>
                                <th width="300px">ESTATUS</th>
                                <th width="300px">ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
            
                    </table>
                </div>
                <br />
				<input type="hidden" id="userPerm" value="<?php echo isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : 0 ; ?>">
            </div>
        </main>
        <!-- page-content" -->
        <div class="modal fade" tabindex="-1" id="showAlta" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">EDITAR REGISTRO</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">           
                                <label for="tipo" class="col-form-label-sm">TIPO</label>
                                <select id="tipo" name="tipo" class="form-control form-control-sm">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="1">TPV</option>
                                    <option value="2">SIM</option>
                                </select>
                            </div>
                            <div class="col" id="colFabricante">           
                                <label for="fabricante" class="col-form-label-sm">FABRICANTE</label>
                                <select id="fabricante" name="fabricante" class="form-control form-control-sm">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="INGENICO">INGENICO</option>
                                    <option value="VERIFONE">VERIFONE</option>
									<option value="HYPERCOM">HYPERCOM </option>
                                    <option value="InteliPOS">InteliPOS</option>
                                </select>
                            </div>
                            <div class="col" id="colCarrier">           
                                <label for="carrier" class="col-form-label-sm">CARRIER</label>
                                <select id="carrier" name="carrier" class="form-control form-control-sm">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="TELCEL">TELCEL</option>
                                    <option value="MOVISTAR">MOVISTAR</option>
                                    <option value="MOVISTAR">M2M</option>
                                    <option value="AT&T">AT&T</option>
                                    <option value="UNO">UNO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="serie" class="col-form-label-sm">NO SERIE</label>
                                <input id="serie" name="serie" class="form-control form-control-sm">
                                 
                            </div>
                            <div class="col">           
                                <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                                <select id="estatus" name="estatus" class="form-control form-control-sm">
                                    <option value="0" selected>Seleccionar</option>
                                    <option value="PERTENECE A ELAVON" data-id="3">PERTENECE A ELAVON</option>
                                    <option value="DESTRUIDA ¡NO INSTALAR!" data-id="17">DESTRUIDA ¡NO INSTALAR!</option>
                                    <option value="QUEBRANTADA ¡NO INSTALAR!" data-id="16">QUEBRANTADA ¡NO INSTALAR!</option>
                                    <option value="PENDIENTE POR QUEBRANTAR" data-id="3">PENDIENTE POR QUEBRANTAR</option>
                                    <option value="CANCELADO" data-id="7">CANCELADO</option>
                                    <option value="ACTIVA" data-id="3">ACTIVA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger  pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
                        <button class="btn btn-success" id="btnCargar"> Cargar</a>
                    </div>
                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="js/inventarioelavon.js"></script> 
</body>

</html>