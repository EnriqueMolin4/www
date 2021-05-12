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
                <h3>CIERRE DE EVENTO</h3>
               
                    <div style="border-style: solid; padding: 10px;">
                        <div class="row">
                            <div id="avisos" class="display:none;" style="background-color:red;"></div>
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="odt" class="col-form-label-sm">ORDENES DE TRABAJO</label>
                                <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt">
                            </div>
                            <div class="col">           
                                <label for="afiliacion" class="col-form-label-sm">AFILIACION</label>
                                <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion">
                            </div>
                            <div class="col">           
                                <label for="tecnico" class="col-form-label-sm">NOMBRE DE TECNICO</label>
                                <input type="text" class="form-control form-control-sm" id="tecnico" aria-describedby="tecnico" readonly>
                                <input type="hidden" class="form-control form-control-sm"  name="tecnicoid" id="tecnicoid">
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="servicio" class="col-form-label-sm">SERVICIO</label>
                                <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
                            </div>
                            <div class="col">           
                                <label for="subservicio" class="col-form-label-sm">SUBSERVICIO</label>
                                <input type="text" class="form-control form-control-sm" id="subservicio" aria-describedby="subservicio" readonly>
                            </div>
                                                        
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="estatus_validacion" class="col-form-label-sm">ESTATUS VALIDACION</label>
                                <input type="text" class="form-control form-control-sm" id="estatus_validacion" aria-describedby="estatus_validacion" readonly>
                            </div>
                            <div class="col">           
                                <label for="servicio_descripcion" class="col-form-label-sm">DESCRIPCION</label>
                                <textarea  class="form-control form-control-sm" rows="2" id="servicio_descripcion" aria-describedby="servicio_descripcion" reandonly></textarea>
                            </div>
                                                        
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="fecha_atencion" class="col-form-label-sm">FECHA ATENCION</label>
                                <input type="text" class="form-control form-control-sm" id="fecha_atencion" aria-describedby="fecha_atencion">
                            </div>
                            <div class="col">           
                                <label for="hora_llegada" class="col-form-label-sm">HORA DE LLEGADA</label>
                                <input type="text" class="form-control form-control-sm" id="hora_llegada" aria-describedby="hora_llegada">
                            </div>
                            <div class="col">           
                                <label for="hora_salida" class="col-form-label-sm">HORA DE SALIDA</label>
                                <input type="text" class="form-control form-control-sm" id="hora_salida" aria-describedby="hora_salida">
                            </div>
                            <div class="col">           
                                <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                                <select id="estatus" name="estatus" class="form-control form-control-sm">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="padding-left:30px;padding-top:30px;">  
                                <input type="hidden"  id="servicioTipo" value='0'>
                                <button class="btn btn-primary" id="btnConsultar">Validar Cierre Evento</button>
                            </div>
                        </div>
                
                    </div>
                <br/>
                <div style="border-style: solid; padding: 10px; display: none;" id="divFueraTiempo">
                        <div class="row">
                            <div class="col form-inline">           
                                <label for="cierre_evento-causa_fuera_tiempo" class="col-form-label-sm">CAUSA FUERA DE TIEMPO:</label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-causa_fuera_tiempo" aria-describedby="cierre_evento-causa_fuera_tiempo">
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div style="border-style: solid; padding: 10px; display:none;" id="serviciorealizado">
						
							<div class="form-group row">
								<div class="col-sm-6 form-inline"> 
									<input type="hidden" id="select-servicio-comercio" name="select-servicio-comercio">          
									<label for="select-servicio-realizado" class="col-sm-2 col-form-label"> SERVICIO REALIZADO </label>
									<select class="form-control form-control-sm" id= "select-servicio-realizado" name="select-servicio-realizado"></select>
								</div>
							</div>
							<div class="form-group row" id="tvpMant">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 " id="tvpSim">
                                            <div class="form-group row">
                                                <div class="col-sm-3 ">   
                                                    <label for="servicio-sim-anterior" class="col-sm-12 col-form-label">SIM ANTERIOR </label>         
                                                    <select class="form-control form-control-sm" id="servicio-sim-anterior" name="servicio-sim-anterior">
                                                    </select>
                                                </div>
                                                <div class="col-sm-3" id="sim-anteriorbk">           
                                                    <label for="servicio-sim-anterior-manual" class="col-sm-12 col-form-label">SIM MANUAL:</label>
                                                    <input type="text" class="form-control form-control-sm" id="servicio-sim-anterior-manual" aria-describedby="servicio-sim-anterior-manual">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="tvpSN">
                                            <div class="row">
                                                <div class="col-sm-6 ">           
                                                    <label for="servicio-sn-anterior" class="col-sm-12 col-form-label">S/N ANTERIOR </label>
                                                    <select class="form-control form-control-sm" id="servicio-sn-anterior" name="servicio-sn-anterior">
                                                    </select>
                                                </div>
                                                <div class="col-sm-6" id="sn-anteriorbk">           
                                                    <label for="servicio-sn-anterior-manual" class="col-sm-12 col-form-label">S/N MANUAL:</label>
                                                    <input type="text" class="form-control form-control-sm" id="servicio-sn-anterior-manual" aria-describedby="servicio-sn-anterior-manual">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row" id="tvpMod">
										<div class="col-sm-3 ">   
											<label for="servicio-modelo-anterior" class="col-sm-12 col-form-label">MODELO ANTERIOR </label>         
											<select class="form-control form-control-sm" id="servicio-modelo-anterior" name="servicio-modelo-anterior" readonly>
											</select>
										</div>
										<div class="col-sm-3 ">   
											<label for="servicio-ptid-anterior" class="col-sm-12 col-form-label">PTID  ANTERIOR </label>         
											<input type="text" class="form-control form-control-sm" id="servicio-ptid-anterior" aria-describedby="servicio-ptid-anterior" readonly>
										</div>
										<div class="col-sm-3 ">   
											<label for="servicio-connect-anterior" class="col-sm-12 col-form-label">CONECTIVIDAD ANTERIOR </label>         
											<select class="form-control form-control-sm" id="servicio-connect-anterior" name="servicio-connect-anterior" readonly>
											</select>
										</div>
									   
									</div>
                                </div>
							</div>
							<div class="form-group row" id="tvpCambios">
								<div class="col-sm-12 ">
									<div class="form-group row">
										<div class="col-sm-6 form-inline">   
											<label for="servicio-sim" class="col-sm-2 col-form-label">SIM </label>         
											<select class="form-control form-control-sm" id="servicio-sim" name="servicio-sim">
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6 form-inline">           
											<label for="servicio-sn" class="col-sm-2 col-form-label">S/N </label>
											<select class="form-control form-control-sm" id="servicio-sn" name="servicio-sn">
											</select>
										</div>
										<div class="col-sm-6 form-inline">           
											<label for="servicio-modelo" class="col-sm-2 col-form-label">MODELO </label>
											<select class="form-control form-control-sm" id="servicio-modelo" name="servicio-modelo" readonly>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6 form-inline">           
											<label for="servicio-ptid" class="col-sm-2 col-form-label">PTID </label>
											<input type="text" class="form-control form-control-sm" id="servicio-ptid" aria-describedby="servicio-ptid">
										</div>
										<div class="col-sm-6 form-inline">           
											<label for="servicio-connect" class="col-sm-2 col-form-label">CONECTIVIDAD</label>
											<select class="form-control form-control-sm" id="servicio-connect" name="servicio-connect">
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6 form-inline">           
											<label for="servicio-producto" class="col-sm-2 col-form-label">PRODUCTO </label>
											<input type="text" class="form-control form-control-sm" id="servicio-producto" aria-describedby="servicio-producto">
										</div>
										<div class="col-sm-6 form-inline">   
											<label for="servicio-aplicativo" class="col-sm-2 col-form-label">APLICATIVO</label>         
											<input type="text" class="form-control form-control-sm" id="servicio-aplicativo" aria-describedby="servicio-aplicativo">
										</div>
									   
									</div>
									<div class="form-group row">
										<div class="col-sm-6 form-inline">           
											<label for="servicio-version" class="col-sm-2 col-form-label">VERSION </label>
											<input type="text" class="form-control form-control-sm" id="servicio-version" aria-describedby="servicio-version">
										</div>
										<div class="col-sm-6 form-inline">           
											<label for="afiliacion_amex" class="col-sm-2 col-form-label">AFILIACION AMEX</label>
											<input type="text" class="form-control form-control-sm" id="afiliacion_amex" aria-describedby="afiliacion_amex" >
										</div>
									   
									</div>						
									<div class="form-group row">
										<div class="col-sm-6 form-inline">           
											<label for="idcaja" class="col-sm-2 col-form-label">ID CAJA</label>
											<input type="text" class="form-control form-control-sm" id="idcaja" aria-describedby="idcaja" >
										</div>
										<div class="col-sm-6 form-inline">           
											<label for="idamex" class="col-sm-2 col-form-label">ID AMEX</label>
											<input type="text" class="form-control form-control-sm" id="idamex" aria-describedby="idamex" >
										</div>
									</div>
								</div>
							</div>
    
							<div class="form-group row">
								<div class="col-sm-6 form-inline">           
									<label for="servicio-rollosinstalar" class="col-sm-2 col-form-label">ROLLOS</label>
									<input type="text" class="form-control form-control-sm" id="servicio-rollosinstalar" aria-describedby="servicio-rollosinstalar" readonly>
								</div>
								<div class="col-sm-6 form-inline">           
									<label for="servicio-rollosentregados" class="col-sm-2 col-form-label">ROLLOS ENTREGADOS</label>
									<input type="text" class="form-control form-control-sm" id="servicio-rollosentregados" aria-describedby="servicio-rollosentregados" value="0">
								</div>
							</div>
						</div>
                        
                    </div>
                    
                    <div style="border-style: solid; padding: 10px; display:none;" id="serviciocancelado">
                        <div class="row">
                            <div class="col">           
                                <label for="cierre_evento-motivo_cancelacion" class="col-form-label-sm">MOTIVO CANCELACION</label>
                                <select class="form-control form-control-sm" id= "cierre_evento-motivo_cancelacion" name="cierre_evento-motivo_cancelacion">
                                
                                </select>
                            </div>
                            <div class="col">           
                                <label for="cierre_evento-cve_autorizacion" class="col-form-label-sm">CLAVE AUTORIZACION</label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-cve_autorizacion" aria-describedby="cierre_evento-cve_autorizacion">
                            </div>
                            <div class="col">           
                                <label for="cierre_evento-autorizo" class="col-form-label-sm">QUIEN AUTORIZO</label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-autorizo" aria-describedby="cierre_evento-autorizo">
                            </div>
                        </div>
                    </div>
                    <div style="border-style: solid; padding: 10px;display:none; " id="serviciorechazado">
                        <div class="row">
                            <div class="col-md-6">           
                                <label for="cierre_evento-motivo_rechazo" class="col-form-label-sm">RECHAZO IMPUTABLE POR </label>
                                <select class="form-control form-control-sm" id= "cierre_evento-motivo_rechazo" name="cierre_evento-motivo_rechazo"> 
                                </select>
                            </div>
                            <div class="col-md-6">  
                                <label for="cierre_evento-motivo_subrechazo" class="col-form-label-sm">MOTIVO DE SUBRECHAZO </label>
                                <select class="form-control form-control-sm" id= "cierre_evento-motivo_subrechazo" name="cierre_evento-motivo_subrechazo">
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="cierre_evento-cve_autorizacion" class="col-form-label-sm">CLAVE AUTORIZACION</label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-cve_autorizacion" aria-describedby="cierre_evento-cve_autorizacion">
                            </div>
                            <div class="col">           
                                <label for="cierre_evento-autorizo" class="col-form-label-sm">QUIEN AUTORIZO</label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-autorizo" aria-describedby="cierre_evento-autorizo">
                            </div>
                        </div>
                    </div>
                    <br/>
                    
                    <div style="border-style: solid; padding: 10px;">
                        <div class="row">
                            <div class="col form-inline">           
                                <label for="cierre_evento-persona_servico" class="col-form-label-sm">PERSONA QUE RECIBE EL SERVICIO </label>
                                <input type="text" class="form-control form-control-sm" id="cierre_evento-persona_servico" aria-describedby="cierre_evento-persona_servico">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">           
                                <label for="cierre_evento-comentarios" class="col-form-label-sm">COMENTARIOS ADICIONALES</label>
                                <textarea  class="form-control form-control-sm" rows="3" id="cierre_evento-comentarios" aria-describedby="cierre_evento-comentarios"></textarea>
                            </div>
                        </div>
                        <div class="col" style="padding-left:10px;padding-top:10px;">  
                            <input type="hidden" id="odtId" value="0">
                            <button class="btn btn-primary" id="btnRegistrar">Cerrar Evento</button>
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
    <script type="text/javascript" src="js/eventoscierre.js"></script> 
</body>

</html>