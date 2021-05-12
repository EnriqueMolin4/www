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
                <h3>ASIGNACION DE RUTA</h3>
            </div>
                <div class="container-fluid p-5 panel-white">
                

                <h5>BÚSQUEDA</h5>
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
                    <div class="col">
                        <label for="estatus_busqueda" class="col-form-label-sm">ESTATUS</label>
                        <select id="estatus_busqueda" name="estatus_busqueda" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">Abierto</option>
                                <option value="2">En Ruta</option>
                                <option value="3">Cerrado</option>
                            </select>
                    </div>
                </div>
                <br />
                <div class="table-responsive">
                    <table id="assignaciones"  class="table table-md table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th width="230px">ODT</th>
                                <th width="230px">AFILIACION</th>
                                <th width="230px">COMERCIO</th>
                                <th width="230px">ESTATUS</th>
                                <th width="230px">TIPO COMERCIO</th>
                                <th width="230px">FECHA VENCIMIENTO</th>
                                <th width="230px">ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th width="230px">ODT</th>
                                <th width="230px">AFILIACION</th>
                                <th width="230px">COMERCIO</th>
                                <th width="230px">ESTATUS</th>
                                <th width="230px">TIPO COMERCIO</th>
                                <th width="230px">FECHA VENCIMIENTO</th>
                                <th width="230px">ACCION</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                


                <!-- MODAL -->
                <div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ASIGNACION DE RUTA</h5>
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
                            <label for="contacto" class="col-form-label-sm" id="contactolabel">CONTACTO</label>
                            <input type="text" class="form-control form-control-sm" id="contacto" aria-describedby="contacto" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_general" class="col-form-label-sm">HORARIO GENERAL</label>
                            <input type="text" class="form-control form-control-sm" id="hora_general" aria-describedby="hora_general" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_comida" class="col-form-label-sm">HORARIO COMIDA</label>
                            <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" readonly>
                        </div>
                    
                    </div>
					<div class="row">
						<div class="col">           
                            <label for="direccion" class="col-form-label-sm">DIRECCION</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                        </div>
                        <div class="col">           
                            <label for="colonia" class="col-form-label-sm">COLONIA</label>
                            <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                        </div>	
					</div>
                    <div class="row">
                        
                        <div class="col">           
                            <label for="ciudad" class="col-form-label-sm">CIUDAD</label>
                            <input type="text" class="form-control form-control-sm" id="ciudad" aria-describedby="ciudad" readonly >
                        </div>
                        <div class="col">           
                            <label for="estado" class="col-form-label-sm">ESTADO</label>
                            <input type="text" class="form-control form-control-sm" id="estado" aria-describedby="estado" readonly>
                        </div>
                        <div class="col">           
                            <label for="telefono" class="col-form-label-sm">TELEFONO</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="col">           
                            <label for="fecha_alta" class="col-form-label-sm">FECHA ALTA</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_cierre" class="col-form-label-sm">FECHA VENCIMIENTO</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="direccion" readonly>
                        </div>
                        <div class="col">           
                            <label for="servicio" class="col-form-label-sm">Servicio</label>
                            <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="subservicio" class="col-form-label-sm">SUBSERVICI</label>
                            <input type="text" class="form-control form-control-sm" id="subservicio" aria-describedby="subservicio" readonly>
                        </div>
                    </div>
                    <?php if($_SESSION['tipo_user'] == 'VO' || $_SESSION['tipo_user'] == 'supVO' ) { } else { ?>
                    <div class="row">
                        <div class="col">           
                            <label for="tipo_falla" class="col-form-label-sm">TIPO DE FALLA</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_falla" aria-describedby="tipo_falla" readonly>
                        </div>
                        <div class="col">           
                            <label for="terminal" class="col-form-label-sm">TERMINAL INSTALADA</label>
                            <input type="text" class="form-control form-control-sm" id="terminal" aria-describedby="terminal" readonly>
                        </div>
                    </div>
                    <?php } ?>
                   
                    <div class="row">
                        <div class="col">           
                        <label for="descripcion" class="col-form-label-sm">DESCRIPCION</label>
                            <textarea  class="form-control form-control-sm" rows="3" id="descripcion" aria-describedby="descripcion" readonly></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                        <label for="fecha_assignacion" class="col-form-label-sm">FECHA ASIGNACION</label>
                        <input type="text" class="form-control form-control-sm" id="fecha_assignacion" aria-describedby="fecha_assignacion">
                        </div>
                        <div class="col">           
                        <label for="tecnico" class="col-form-label-sm">TECNICO</label>
                        <select class="form-control form-control-sm" name="tecnico" id="tecnico" aria-describedby="tecnico">
                        </select>
                        </div>
                        <div class="col">           
                        <label for="fecha_viatico" class="col-form-label-sm">FECHA VIATICO</label>
                        <input type="text" class="form-control form-control-sm" id="fecha_viatico" aria-describedby="fecha_viatico">
                        </div>
                        <div class="col">           
                        <label for="importe_viatico" class="col-form-label-sm">IMPORTE DE VIATICO</label>
                        <input type="text" class="form-control form-control-sm" id="importe_viatico" aria-describedby="importe_viatico">
                        </div>
                    
                    </div>
                    <div class="row">
                        <!--<div class="col">           
                        <label for="fecha_destajo" class="col-form-label-sm">Fecha de Pago a Destajo</label>
                        <input type="text" class="form-control form-control-sm" id="fecha_destajo" aria-describedby="fecha_destajo">
                        </div>
                        <div class="col">           
                        <label for="importe_destajo" class="col-form-label-sm">Importe de Destajo</label>
                        <input type="text" class="form-control form-control-sm" id="importe_destajo" aria-describedby="importe_destajo">
                        </div>-->
                        <div class="col">           
                        <label for="comentarios_asig" class="col-form-label-sm">COMENTARIO</label>
                            <textarea  class="form-control form-control-sm" rows="3" id="comentarios_asig" aria-describedby="comentarios_asig"></textarea>
                        </div>
                    </div>
                <div>
                <br />
                
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="eventoId">
                    <input type="hidden" value="0" id="odtId">
                    <button class="btn btn-primary" id="btnAsignar">Asignar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
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
    <script type="text/javascript" src="js/assignacionruta.js"></script>  
</body>

</html>