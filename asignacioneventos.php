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
                    <h3>ASIGNACION DE EVENTOS</h3>
                </div>

                <div class="container-fluid p-1">
                
                  <div class="row">
                    <div class="col-sm-5"> 
                         
                                <label for="excelMasivo" class="col-form-label-sm">Asignacion Masiva Eventos</label> 
                                <input class="input-file" type="file" id="excelMasivoAsignacion" name="excelMasivoAsignacion">
                                <button class="btn btn-success btn-sm" id="btnCargarExcelAsignaciones">Cargar</button>     
                         
                    </div>
                  </div>

        <div id="container" class="col-md-12 panel-white">
            <br>
            
                <h5>BUSQUEDA</h5>
                <div class="row">
                    <div class="col-md-3">
                        <label for="fechaVen_inicio" class="col-form-label-sm">VENCIMIENTO DESDE</label>
                        <input type="text" class="form-control form-control-sm refreshDataTable" id="fechaVen_inicio" aria-describedby="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="fechaVen_fin" class="col-form-label-sm">VENCIMIENTO HASTA</label>
                        <input type="text" class="form-control form-control-sm refreshDataTable" id="fechaVen_fin" aria-describedby="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                   
                    <div class="col-md-3">
                        <label for="tipo_evento" class="col-form-label-sm">TIPO EVENTO</label>
                        <select id="tipo_evento" name="tipo_evento" class="form-control form-control-sm refreshDataTable">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>
                   
                </div> <br>
                <div class="row">
                    <div class="col-md-3">
                        <label for="estado_e" class="col-form-label-sm">ESTADO</label>
                        <select name="estado_e" id="estado_e" class="form-control form-control-sm">
                            <option value="0" Seleccionar></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ciudad_E" class="col-form-label-sm">CIUDAD</label>
                        <select name="ciudad_e" id="ciudad_e" class="form-control form-control-sm refreshDataTable">
                            <option value="0" selected></option>
                        </select>
                    </div>
                </div>
                
                <div class="row mt-3 mb-3">
                    <div class="col-md-3">
                        <label for="supervisores" class="col-form-label-sm">SUPERVISORES</label>
                        <select name="supervisores" id="supervisores" class="form-control form-control-sm refreshDataTable">
                            <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="tecnico_asig" class="col-form-label-sm">TECNICO</label>
                        <select name="tecnico_asig" id="tecnico_asig" class="form-control mr-1">
                            <option value="0" selected>Seleccionar Técnico</option>
                        </select>
                    </div>
                </div>
                    
                <div class="table-responsive">
                    
                
                    <table id="assignaciones"  class="table table-md table-bordered ">
                    <thead>
                        <tr>
                            <th>ODT</th>
                            <th>AFILIACION</th>
                            <th>CIUDAD</th>
                            <th>COMERCIO</th>
                            <th>ESTATUS</th>
                            <th>TIPO COMERCIO</th>
                            <th>FECHA VENCIMIENTO</th>
                            <th>CODIGO POSTAL</th>
                            <th>DETALLE</th>
                            <th>ASIGNAR</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ODT</th>
                            <th>AFILIACION</th>
                            <th>CIUDAD</th>
                            <th>COMERCIO</th>
                            <th>ESTATUS</th>
                            <th>TIPO COMERCIO</th>
                            <th>FECHA VENCIMIENTO</th>
                            <th>POSTAL</th>
                            <th>DETALLE</th>
                            <th>ASIGNAR</th>
                        </tr>
                    </tfoot>
                    </table>
                    <br />
                </div>
            </div>
        </div>
    </main>
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
        <!-- MODAL -->
        <div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">INFORMACION DEL EVENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">           
                            <label for="odt" class="col-form-label-sm">ODT</label>
                            <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt" readonly>
                        </div>
                        <div class="col">           
                            <label for="afiliacion" class="col-form-label-sm" id="labelAfiliacion">AFILIACION | FOLIO</label>
                            <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_servicio" class="col-form-label-sm">TIPO SERVICIO</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_servicio" aria-describedby="tipo_servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_subservicio" class="col-form-label-sm">TIPO SUBSERVICIO</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_subservicio" aria-describedby="tipo_subservicio" readonly>
                        </div>
                    
                    </div>
                    <div class="row">
                    <div class="col">           
                            <label for="fecha_alta" class="col-form-label-sm">FECHA ALTA</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_cierre" class="col-form-label-sm">FECHA VENCIMIENTO</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="fecha_cierre" readonly>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comercio" class="col-form-label-sm">COMERCIO | CLIENTE</label>
                            <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" readonly>
                        </div>
                        <div class="col">           
                            <label for="colonia" class="col-form-label-sm">COLONIA</label>
                            <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                        </div>
                        <div class="col">           
                            <label for="ciudad" class="col-form-label-sm">CIUDAD</label>
                            <input type="text" class="form-control form-control-sm" id="ciudad" aria-describedby="ciudad" readonly >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="estado" class="col-form-label-sm">ESTADO</label>
                            <input type="text" class="form-control form-control-sm" id="estado" aria-describedby="estado" readonly>
                        </div>
                        <div class="col">           
                            <label for="direccion" class="col-form-label-sm">DIRECCION</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                        </div>
                        <div class="col">           
                            <label for="telefono" class="col-form-label-sm">TELEFONO</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center">

                        <div class="col">           
                        <label for="descripcion" class="col-form-label-sm">DESCIPCION</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="descripcion" aria-describedby="descripcion" readonly></textarea>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_atencion" class="col-form-label-sm">HORA DE ATENCION</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_atencion" aria-describedby="hora_atencion" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_comida" class="col-form-label-sm">HORARIO DE COMIDSA</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" readonly>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col">           
                            <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                            <input type="text" class="form-control form-control-sm" id="estatus" aria-describedby="estatus" readonly>
                        </div>
                        <div class="col">           
                            <label for="rollos_instalar" class="col-form-label-sm">ROLLOS A ENTREGAR</label>
                            <input type="text" class="form-control form-control-sm" id="rollos_instalar" aria-describedby="rollos_instalar" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="servicio" class="col-form-label-sm">SERVICIO SOLICITADO</label>
                            <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
                        </div>              
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="eventoId">
                    <input type="hidden" value="0" id="latitud">
                    <input type="hidden" value="0" id="longitud">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
            </div>
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
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/assignacioneventos.js"></script>  
</body>

</html>