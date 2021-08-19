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
            <div class="container-fluid p-5">
                <h3>Nueva Visita Ocular</h3>
            
                    <div id="container" class="container">

                            <br>
                            <div class="row">
                                    <div class="col"> 
                                    <label for="excelMasivo" class="col-form-label-sm">Carga Masiva Eventos</label> 
                                    <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
                                    <button class="btn btn-success btn-sm" id="btnCargarExcel">Cargar</button>
                                    </div>
                                    <div class="col">
                                        
                                    </div>
                                </div>
                            <div style="border-style: solid; padding: 10px;">
                                
                                <div class="row">
                                    <div id="avisos" class="display:none;" style="background-color:red;"></div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="cve_banco" class="col-form-label-sm">Cve Bancaria</label>
                                        <select id="cve_banco" name="cve_banco" class="form-control form-control-sm" ></select>
                                    </div>
                                    <div class="col">           
                                        <label for="afiliacion" class="col-form-label-sm">Folio</label>
                                        <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" >
                                    </div>
                                    <div class="col">           
                                        <label for="tipo_credito" class="col-form-label-sm">Tipo Credito</label>
                                        <select id="tipo_credito" name="tipo_credito" class="form-control form-control-sm" ></select>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="comercio" class="col-form-label-sm">Cliente</label>
                                        <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="direccion" class="col-form-label-sm">Dirección</label>
                                        <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" >
                                    </div>
                                    <div class="col">           
                                        <label for="colonia" class="col-form-label-sm">Colonia</label>
                                        <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="estado" class="col-form-label-sm">Estado</label>
                                        <select id="estado" name="estado" class="form-control form-control-sm" ></select>
                                    </div>
                                    <div class="col">           
                                        <label for="municipio" class="col-form-label-sm">Municipio</label>
                                        <select id="municipio" name="municipio" class="form-control form-control-sm" ></select>
                                    </div>
                                    <div class="col">           
                                        <label for="tipo_servicio" class="col-form-label-sm">Tipo de Servicio</label>
                                        <select id="tipo_servicio" name="tipo_servicio" class="form-control form-control-sm">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">           
                                        <label for="telefono" class="col-form-label-sm">Telefono</label>
                                        <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" >
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="ticket" class="col-form-label-sm">Ticket</label>
                                        <input type="text" class="form-control form-control-sm" id="ticket" aria-describedby="ticket" readonly>
                                    </div>
                                    <div class="col" style="display: none;">           
                                        <label for="hora_atencion" class="col-form-label-sm">Hora de Atención</label>
                                        <input type="text" class="form-control form-control-sm" id="hora_atencion-in" name="hora_atencion-in" aria-describedby="hora_atencion" >
                                        <span>A</span>
                                        <input type="text" class="form-control form-control-sm" id="hora_atencion-fin" name="hora_atencion-fin" aria-describedby="hora_atencion" >
                                    </div>
                                    <div class="col" style="display: none;">           
                                        <label for="hora_comida" class="col-form-label-sm">Hora de Comida</label>
                                        <input type="text" class="form-control form-control-sm" id="hora_comida" name="hora_comida" aria-describedby="hora_comida" >
                                        <span>A</span>
                                        <input type="text" class="form-control form-control-sm" id="hora_comida_fin" name="hora_comida_fin" aria-describedby="hora_comida_fin" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">           
                                        <label for="comentarios" class="col-form-label-sm">Comentarios</label>
                                        <textarea  class="form-control form-control-sm" rows="5" id="comentarios" aria-describedby="comentarios"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"> 
                                    <label for="documentos" class="col-form-label-sm">Documentacion: </label>
                                    <input type="file" name="documentos" id="documentos" multiple><br /><small>(para seleccionar multiples archivos usar la tecla ctrl)</small>
                                    </div>
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
                                        <div class="col-md-12" id="numFolio"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
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
    <script type="text/javascript" src="js/nuevavo.js"></script> 
</body>

</html>