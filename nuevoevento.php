<?php require("header.php"); ?>
<body>
    <div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <?php require("menu.php"); ?> 
        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                <h3>Nuevo Evento</h3>

                    <div id="container" class="container">
                    <br>
                            <div class="row">
                                    <div class="col-sm-5"> 
                                        <label for="excelMasivo" class="col-form-label-sm">Carga Masiva Eventos</label> 
                                        <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                                        <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="layouts/LayoutCargaMasivaEventos.xlsx" download>Template Carga Masiva Eventos</a>
                                    </div>
                                    <div class="col-2">
                                        <select class="form-control form-control-sm searchInventario" name="cveBanco" id="cveBanco"></select>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-primary" id="btnProcesosActivos">
                                            Proceso Activo <span class="badge badge-light" id="processBadge"></span>
                                        </button>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">           
                                    <label for="buscarComercio" class="col-form-label-sm">Buscar Comercio</label>
                                    <input type="text" class="form-control form-control-sm col-md-7" id="buscarComercio" placeholder="Buscar por Clave Banco, Afiliacion, Nombre Comercio" aria-describedby="buscarComercio">
                                </div>
                            </div>
                            <br>
                            
                                <div class="row">
                                    <div id="avisos" class="display:none;" style="background-color:red;"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">           
                                        <label for="odt" class="col-form-label-sm">ODT</label>
                                        <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="cve_banco" class="col-form-label-sm">Cve Bancaria</label>
                                        <input type="text" class="form-control form-control-sm" id="cve_banco" aria-describedby="cve_banco" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                                        <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="comercio" class="col-form-label-sm">Comercio</label>
                                        <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="direccion" class="col-form-label-sm">Dirección</label>
                                        <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="estado" class="col-form-label-sm">Estado</label>
                                        <select id="estado" name="estado" class="form-control form-control-sm" readonly></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="colonia" class="col-form-label-sm">Colonia</label>
                                        <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="tipo_servicio" class="col-form-label-sm">Tipo de Servicio</label>
                                        <select id="tipo_servicio" name="tipo_servicio" class="form-control form-control-sm">
                                            
                                        </select>
                                    </div>
                                    <div class="col">           
                                    <label for="tipo_subservicio" class="col-form-label-sm">Tipo de Sub Servicio</label>
                                        <select id="tipo_subservicio" name="tipo_subservicio" class="form-control form-control-sm">
                                        </select>
                                    </div>
                                     
                                    <div class="col">           
                                        <label for="cantidad" class="col-form-label-sm">Cantidad</label>
                                        <input type="text" class="form-control form-control-sm" id="cantidad" aria-describedby="cantidad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="equipo_instalado" class="col-form-label-sm">Equipo Instalado</label>
                                        <select id="equipo_instalado" name="equipo_instalado" class="form-control form-control-sm">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-3">           
                                        <label for="municipio" class="col-form-label-sm">Municipio</label>
                                        <select id="municipio" name="municipio" class="form-control form-control-sm" readonly></select>
                                    </div>
                                    <div class="col-md-3">           
                                        <label for="telefono" class="col-form-label-sm">Telefono</label>
                                        <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                                    </div>
                                    <div class="col-md-3">           
                                        <label for="email" class="col-form-label-sm">Email</label>
                                        <input type="text" class="form-control form-control-sm" id="email" aria-describedby="email" readonly>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="responsable" class="col-form-label-sm">Responsable</label>
                                        <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" readonly>
                                    </div>
                                    <div class="col">           
                                        <label for="ticket" class="col-form-label-sm">Ticket</label>
                                        <input type="text" class="form-control form-control-sm" id="ticket" aria-describedby="ticket">
                                    </div>
                                    <div class="col">           
                                        <label for="hora_atencion" class="col-form-label-sm">Hora de Atención</label>
                                        <input type="text" class="form-control form-control-sm" id="hora_atencion-in" name="hora_atencion-in" aria-describedby="hora_atencion" autocomplete="off">
                                        <span>A</span>
                                        <input type="text" class="form-control form-control-sm" id="hora_atencion-fin" name="hora_atencion-fin" aria-describedby="hora_atencion" autocomplete="off">
                                    </div>
                                    <div class="col">           
                                        <label for="hora_comida" class="col-form-label-sm">Hora de Comida</label>
                                        <input type="text" class="form-control form-control-sm" id="hora_comida" name="hora_comida" aria-describedby="hora_comida" autocomplete="off">
                                        <span>A</span>
                                        <input type="text" class="form-control form-control-sm" id="hora_comida_fin" name="hora_comida_fin" aria-describedby="hora_comida_fin" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="comentarios" class="col-form-label-sm">Comentarios</label>
                                        <textarea  class="form-control form-control-sm" rows="5" id="comentarios" aria-describedby="comentarios"></textarea>
                                    </div>
                                </div>

                 
                            <div class="row">
                                <div class="col" style="padding-left:30px;padding-top:10px;">  
                                    <button class="btn btn-primary" id="btnAsignar">Grabar</button>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Avisos -->
                        <div class="modal fade" tabindex="-1" role="dialog" id="showAvisos">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Creación Evento</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12" id="numODT"></div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" id="odtFechaLimite">
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div> 
                            </div>
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
    <script type="text/javascript" src="js/nuevoevento.js"></script>  
</body>

</html>