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
                <h3>VALIDACIONES</h3>
            </div>
            <div class="container-fluid p-3 panel-white">
            
                <h5>BUSQUEDA</h5>
                <div class="row">
                    <div class="col">
                        <label for="fechaVen_inicio" class="col-form-label-sm">VENCIMIENTO DESDE</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_inicio" aria-describedby="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <label for="fechaVen_fin" class="col-form-label-sm">VENCIMIENTO HASTA</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_fin" aria-describedby="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <label for="tipo_evento" class="col-form-label-sm">TIPO EVENTO</label>
                        <select id="tipo_evento" name="tipo_evento" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>
                </div>
                <br />
                <div class="table-responsive">
                    <table id="validaciones"  class="table table-md table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>ODT</th>
                            <th>AFILIACION</th>
                            <th>TICKET</th>
                            <th>TIPO DE SERVICIO</th>
                            <th>FECHA VENCIMIENTO</th>
                            <th>TECNICO</th>
                            <th>ESTATUS LLAMADAS</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ODT</th>
                            <th>AFILIACION</th>
                            <th>TICKET</th>
                            <th>TIPO DE SERVICIO</th>
                            <th>FECHA VENCIMIENTO</th>
                            <th>TECNICO</th>
                            <th>ESTATUS LLAMADAS</th>
                            <th>ACCION</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">VALIDACION EVENTO</h5>
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
                            <label for="afiliacion" class="col-form-label-sm">AFILIACION</label>
                            <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                        </div>
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
                            <label for="comercio" class="col-form-label-sm">COMERCIO</label>
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
                        <div class="col" style="padding:30px;">   
                            <div class="row justify-content-center" >
                                <div class="col-sm-4" style="padding:5px">
                                    <button class="btn btn-primary" id="btnImagenes">IMAGENES</button> 
                                </div>
                            </div>    
                        </div>
                        <div class="col">           
                        <label for="descripcion" class="col-form-label-sm">DESCRIPCION</label>
                            <textarea  class="form-control form-control-sm" rows="3" id="descripcion" aria-describedby="descripcion" readonly></textarea>
                        </div>
                        <div class="col">         
                            <label for="toque" class="col-form-label-sm">INTENTOS DE LLAMADA </label>
                            <input type="text" class="form-control form-control-sm col-sm-4" id="toque" aria-describedby="toque" readonly>
                        </div>
                        
                    </div>
                    <br />
                    <div class="row">
                        <div class="col">           
                            <label for="estatus" class="col-form-label-sm">ESTATUS </label>
                            <select id="cmbestatus" name="cmbestatus" class="form-control form-control-sm">
                                
                            </select>
                        </div>
                        <div class="col">           
                            <label for="fecha_llamada" class="col-form-label-sm">FECHA DE LLAMADA</label>
                            <input type="text" class="form-control form-control-sm" id="txtfecha_llamada" aria-describedby="txtfecha_llamada">
                        </div>
                        <div class="col">           
                            <label for="hora_llamada" class="col-form-label-sm">HORA DE LLAMADA </label>
                            <input type="text" class="form-control form-control-sm" id="txthora_llamada" aria-describedby="txthora_llamada">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comentarios_validacion" class="col-form-label-sm">COMENTARIOS DE VALIDACIÓN</label>
                            <textarea  class="form-control form-control-sm" rows="3" id="comentarios_validacion" name="comentarios_validacion" aria-describedby="comentarios_validacion" ></textarea>
                        </div>
                        
                    </div>
                    <div id="hist-validacion"></div>
                </div>
                <div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="eventoId">
                    <button class="btn btn-primary" id="btnValidar">Validar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
            </div>

            <!-- MODAL IMAGENES Ubicacion -->
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
                        <div class="row">
                            <div class="col-md-5">
                                <button class="btn btn-success" id="btnRotarImagen">Rotar 90</button>
                                <button class="btn btn-success" id="btnValidarImagen" data="0">Validar Imagenes</button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div> 
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
    <script src="js/jquery.rotate.1-1.js"></script>
    <script src="js/validaciones.js"></script>
</body>

</html>