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
                <h3>EXPEDIENTES</h3>
            </div>
            <div class="row">
                            <div class="col py-3 px-md-5 bordered col-example">
                                <button class="btn btn-success" id="btnNuevoExpediente" name="btnNuevoExpediente">Nuevo Expediente</button>
                            </div>
                        </div>
            <div class="container-fluid p-1 panel-white">
                
                <div class="table-responsive">
                    <table id="expedientes"  class="table table-md table-bordered ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>CORREO</th>
                                <th>PUESTO</th>
                                <th>FECHA ALTA</th>
                                <th>ESTATUS</th>
                                <th>ACCION</th>       
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>
                </div>   

                        <!-- MODAL Avisos -->
                        <div class="modal fade" tabindex="-1" role="dialog" id="showExpediente">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">CREACION EVENTO</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <div class="modal-body">
                                    <form id="formExpediente" name="formExpediente">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a  href="#principal" class="nav-link active" data-toggle="tab">PRINCIPAL</a></li>
                                            <li class="nav-item"><a href="#papeleria" class="nav-link" data-toggle="tab">PAPELERIA</a></li>
                                            <li class="nav-item"><a href="#bancarios" class="nav-link" data-toggle="tab">DATOS BANCARIOS</a></li>
                                            <li class="nav-item"><a href="#beneficiarios" class="nav-link" data-toggle="tab">BENEFICIARIOS</a></li>
                                            <li class="nav-item"><a href="#baja" class="nav-link" data-toggle="tab">BAJA</a></li>
                                            <li class="nav-item"><a href="#reingreso" class="nav-link" data-toggle="tab">REINGRESO</a></li>
                                        </ul>
                                        <div class="tab-content ">
                                            
                                                <div class="tab-pane active" id="principal">
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="exp_nombre" class="col-form-label-sm">NOMBRE</label>
                                                            <input id="exp_nombre" name="exp_nombre" class="form-control form-control-sm" >
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="ticket" class="col-form-label-sm">FECHA INGRESO</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_ingreso" name="doc_ingreso">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="ticket" class="col-form-label-sm">FECHA ALTA</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_alta" name="doc_alta">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="ticket" class="col-form-label-sm">CAPACITACION</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_capacitacion" name="doc_capacitacion">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="ticket" class="col-form-label-sm">FECHA ENTREGA UNIFORME</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_uniforme" name="doc_uniforme">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="ticket" class="col-form-label-sm">TALLA</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_talla" name="doc_talla">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="papeleria">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="card" style="margin:50px 0">
                                                                <!-- Default panel contents -->
                                                                <div class="card-header"></div>
                                                            
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item">
                                                                    CURRICULUM Y/O SOLICITUD
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_curriculum" name="doc_curriculum" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    COPIA ACTA DE NACIMIENTO
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="primary" id="doc_acta" name="doc_acta" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CURP
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_curp" name="doc_curp" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    COPIA IDENTIFICACION OFICIAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="info" id="doc_ident" name="doc_ident" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    COPIA COMPROBANTE DE DOMICILIO RECIENTE
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="warning" id="doc_domicilio" name="doc_domicilio" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    COPIA NUMERO DE SEGURO SOCIAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="danger" id="doc_nss" name="doc_nss" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    COPIA RFC
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_rfc" name="doc_rfc" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CARTA DE RECOMENDACIÓN LABORAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_laboral" name="doc_laboral" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CARTA DE RECOMENDACIÓN PERSONAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_personal" name="doc_personal" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    VERIFICACIÓN DE REFERENCIAS LABORALES
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_referencias" name="doc_referencias" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    AVISO DE RETENCION CREDITO INFONAVIT
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_infonavit" name="doc_infonavit" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CARTA DE SEGUNDO TRABAJO
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_segtrabajo" name="doc_segtrabajo" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                        <div class="card" style="margin:50px 0">
                                                                <!-- Default panel contents -->
                                                                <div class="card-header"></div>
                                                            
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item">
                                                                    ALTA DEL IMSS
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="default"  id="doc_imss" name="doc_imss" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CONTRATO NOMINA BANCARIA
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="primary" id="doc_nomina" name="doc_nomina" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CONTRATO LABORAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_contratolaboral" name="doc_contratolaboral" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CARTA DE CONVENIO DE CONFIDENCIALIDAD
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_confidencialidad" name="doc_confidencialidad" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    REGLAMENTO GENERAL
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_reglamento" name="doc_reglamento" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    RESULTADO DE EXAMEN PSICOMETRICO
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_psicometrico" name="doc_psicometrico" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    RESULTADO DE EVALUACION PARA EL PUESTO
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_evaluacion" name="doc_evaluacion" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    RESULTADO DE EXAMEN ANTIDOPING
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_antidoping" name="doc_antidoping" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    CONSULTA DE EXPEDIENTE CONCILIACION
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_conciliacion" name="doc_conciliacion" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    AUTORIZACION MENORES DE EDAD
                                                                        <label class="switch ">
                                                                            <input type="checkbox" class="success" id="doc_menores" name="doc_menores" value="true">
                                                                            <span class="slider"></span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            </div> 
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="bancarios">
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_banco" class="col-form-label-sm">BANCO</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_banco" name="doc_banco" aria-describedby="doc_ingreso">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="doc_cuenta" class="col-form-label-sm">CUENTA</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_cuenta" name="doc_cuenta" aria-describedby="doc_alta">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_clabe" class="col-form-label-sm">CLABE</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_clabe" name="doc_clabe" aria-describedby="doc_ingreso">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="doc_tarjeta" class="col-form-label-sm">TARJETA</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_tarjeta" name="doc_tarjeta" aria-describedby="doc_alta">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="beneficiarios">
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_nombrebeneficiario" class="col-form-label-sm">NOMBRE</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_nombrebeneficiario" name="doc_nombrebeneficiario" aria-describedby="doc_ingreso">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="doc_parentesco" class="col-form-label-sm">PARENTEZCO</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_parentesco" name="doc_parentesco" aria-describedby="doc_alta">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_rfcbeneficiario" class="col-form-label-sm">RFC</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_rfcbeneficiario" name="doc_rfcbeneficiario" aria-describedby="doc_ingreso">
                                                        </div>
                                                        <div class="col">           
                                                            <label for="doc_curpbeneficiario" class="col-form-label-sm">CURP</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_curpbeneficiario" name="doc_curpbeneficiario" aria-describedby="doc_alta">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="baja">
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_fechabaja" class="col-form-label-sm">FECHA BAJA</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_fechabaja" name="doc_fechabaja" aria-describedby="doc_ingreso">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_motivobaja" class="col-form-label-sm">MOTIVO</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_motivobaja" name="doc_motivobaja" aria-describedby="doc_ingreso">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="reingreso">
                                                    <div class="row">
                                                        <div class="col">           
                                                            <label for="doc_reingreso" class="col-form-label-sm">REINGRESO</label>
                                                            <input type="text" class="form-control form-control-sm" id="doc_reingreso" name="doc_reingreso" aria-describedby="doc_ingreso">
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                        </div>

                                     </form>    
                                   
                                </div>
                               
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-success" id="btnGrabar" name="btnGrabar">Grabar</button>
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
        <script type="text/javascript" src="js/peticiones.js"></script> 
</body>

</html>