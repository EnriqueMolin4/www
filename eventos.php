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
            
            <div class="container-fluid p-2">
            <h3>Consulta de Eventos</h3>
            
                <h5>Busqueda</h5>
                <div class="row">
                    <div class="col">
                        <label for="fechaVen_inicio" class="col-form-label-sm">Vencimiento Desde</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_inicio" aria-describedby="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <label for="fechaVen_fin" class="col-form-label-sm">Vencimiento Hasta</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_fin" aria-describedby="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <label for="tipo_evento" class="col-form-label-sm">Tipo Evento</label>
                        <select id="tipo_evento" name="tipo_evento" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                    </div>
                    <div class="col">
                        <label for="estatus_busqueda" class="col-form-label-sm">Estatus</label>
                        <select id="estatus_busqueda" name="estatus_busqueda" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">Abierto</option>
                                <option value="2">En Ruta</option>
                                <option value="3">Cerrado</option>
                            </select>
                    </div>          
                </div>
                <div class="row pt-3 pl-4">
                    <div class="col">
                        <input type="checkbox" class="form-check-input searchEvento" id="evidencias">
                        <label class="form-check-label" for="evidencias">Con evidencias</label>
                    </div>
                    <?php if ($_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'supervisor') { ?>
                    <div class="col">
                        <label for="territorialF" class="col-form-label-sm">TERRITORIAL</label>
                        <select id="territorialF" name="territorialF" class="form-control form-control-sm searchEvento">
                            <option value="0">Seleccionar</option>
                        </select>
                    </div>
                    <?php } ?>
                    <div class="col">
                        <label for="tecnicoF" class="col-form-label-sm">TECNICO</label>
                        <select name="tecnicoF" id="tecnicoF" class="form-control form-control-sm searchEvento">
                            <option value="0" selected>Seleccionar</option> 
                        </select>
                    </div>
                    <div class="col">
                        <label for="bancoF" class="col-form-label-sm">BANCO</label>
                        <select name="bancoF" id="bancoF" class="form-control form-control-sm searchEvento">
                            <option value="0" selected>Seleccionar</option> 
                        </select>
                    </div>
                </div>
                <br />
                <table id="eventos"  class="display table table-md table-bordered"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ODT</th>
                            <th>Afiliación | Folio</th>
                            <th>CVE</th>
                            <th>Comercio | Cliente</th>
                            <th>Dirección</th>
                            <th>Servicio</th>
                            <th>Fecha de Alta</th>
                            <th>Fecha Vencimiento</th>
                            <th></th>
							<th>Fecha Cierre</th>
                            <th>Imagenes Cargadas</th>
                            <th>Técnico</th>
                            <th>Estatus</th>
							<th>Estatus Servicio</th>
                            <th>Accion</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                       
                    </tfoot>
                </table>
                <div class="row">
                    <div class="col" style="padding-left:30px;padding-top:30px;">  
                        <a href="nuevoevento.php" class="btn btn-dark" id="btnNuevoEvento">Nuevo Evento</a>
                    </div>
                </div>   
           <input type="hidden" id="tipo_user" name="tipo_user" value="<?php echo $_SESSION['tipo_user']; ?>">

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
            <div class="modal-dialog" style="max-width: 1350px!important;" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información del Evento</h5>
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
                            <label for="afiliacion" class="col-form-label-sm" id="labelAfiliacion">Afilacion | Folio</label>
                            <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_servicio" class="col-form-label-sm">Tipo Servicio</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_servicio" aria-describedby="tipo_servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_subservicio" class="col-form-label-sm">Tipo SubServicio</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_subservicio" aria-describedby="tipo_subservicio" readonly>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtGetNet">Vestiduras GetNet</label>
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtNotificado">Notificado</label>
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtDescarga">Descarga mi comercio</label>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col">           
                            <label for="fecha_alta" class="col-form-label-sm">Fecha Alta</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_vencimiento" class="col-form-label-sm">Fecha Vencimiento</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_vencimiento" aria-describedby="fecha_vencimiento" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_cierre" class="col-form-label-sm">Fecha Cierre</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="fecha_cierre" readonly>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comercio" class="col-form-label-sm">Comercio | Cliente</label>
                            <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" readonly>
                        </div>
                        <div class="col">           
                            <label for="colonia" class="col-form-label-sm">Colonia</label>
                            <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                        </div>
                        <div class="col">           
                            <label for="ciudad" class="col-form-label-sm">Ciudad</label>
                            <input type="text" class="form-control form-control-sm" id="ciudad" aria-describedby="ciudad" readonly >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="estado" class="col-form-label-sm">Estado</label>
                            <input type="text" class="form-control form-control-sm" id="estado" aria-describedby="estado" readonly>
                        </div>
                        <div class="col">           
                            <label for="direccion" class="col-form-label-sm">Dirección</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                        </div>
                        <div class="col">           
                            <label for="telefono" class="col-form-label-sm">Telefono</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col" style="padding:30px;">   
                            <div class="row justify-content-center" >
                                <div class="col-sm-4" style="padding:5px">
                                    <button class="btn btn-primary" id="btnImagenes">Imagenes</button> 
                                </div>
                            </div>       
                            <div class="row justify-content-center" >
                                <div class="col-sm-4" style="padding:5px">
                                    <button class="btn btn-primary" id="btnUbicacion">Ubicacion</button>
                                </div>
                            </div> 
                        </div>
                        <div class="col">           
                        <label for="descripcion" class="col-form-label-sm">Descripción</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="descripcion" aria-describedby="descripcion" readonly></textarea>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_atencion" class="col-form-label-sm">Horario de Atencion</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_atencion" aria-describedby="hora_atencion" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_comida" class="col-form-label-sm">Horario de Comida</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">           
                                    <label for="fecha_asignacion" class="col-form-label-sm">Fecha de Asignación</label>
                                    <input type="text" class="form-control form-control-sm" id="fecha_asignacion" aria-describedby="fecha_asignacion" readonly>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col">           
                            <label for="receptor_servicio" class="col-form-label-sm">Quien Atendio</label>
                            <input type="text" class="form-control form-control-sm" id="receptor_servicio" aria-describedby="receptor_servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_atencion" class="col-form-label-sm">Fecha de Atención</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_atencion" aria-describedby="fecha_atencion" autocomplete="off" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_llegada" class="col-form-label-sm">Hora de LLegada</label>
                            <input type="time" class="form-control form-control-sm" id="hora_llegada" aria-describedby="hora_llegada" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_salida" class="col-form-label-sm">Hora de Salida</label>
                            <input type="time" class="form-control form-control-sm" id="hora_salida" aria-describedby="hora_salida" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
							<label for="tecnico" class="col-form-label-sm">Tecnico</label><?php if ($_SESSION['tipo_user'] == 'supOP' || $_SESSION['tipo_user'] == 'supervisor' || $_SESSION['tipo_user'] == 'admin' ) {  ?><a href="#" id="btnReasignarTecnico"><i class="fas fa-arrows-alt-h"></i>Reasignar</a> <?php } ?>  
                            <input type="text" class="form-control form-control-sm" id="tecnico" aria-describedby="tecnico" readonly>
                        </div>
                        <div class="col">           
                            <label for="estatus" class="col-form-label-sm">Estatus</label>
                            <input type="text" class="form-control form-control-sm" id="estatus" aria-describedby="estatus" readonly>
                        </div>
                        <div class="col">           
                            <label for="servicio" class="col-form-label-sm">Servicio Solicitado</label>
                            <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
                        </div>
                        <div class="col" id="col_tipocredito">           
                            <label for="tipo_credito" class="col-form-label-sm">Tipo Credito</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_credito" aria-describedby="tipo_credito" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                                <label for="tpv" class="col-form-label-sm">Terminal Instalada</label>
                                <input type="text" class="form-control form-control-sm" id="tpv" aria-describedby="tpv" readonly>
                                <select  class="form-control form-control-sm" id="tpvInDataModelo" aria-describedby="tpvInDataModelo">
                                    <option value="0" selected>Seleccionar Modelo</option>
                                </select>
                                <select  class="form-control form-control-sm" id="tpvInDataConnect" aria-describedby="tpvInDataConnect">
                                    <option value="0" selected>Seleccionar Conectividad</option>
                                </select><br>
                                <div class="row">
                                    <div class="col" id="cambiarInfoTpv">
                                        <button type="button" id="btnUpdateAlmacen" class="btn btn-info" style="height: 30px;">Actualizar en Almacén</button>
                                    </div>
                                    
                                </div>
                        </div>
						<div class="col">           
                                <label for="tpv_retirado" class="col-form-label-sm">Terminal Retirada</label>
                                <input type="text" class="form-control form-control-sm" id="tpv_retirado" aria-describedby="tpv" readonly>
                                <select  class="form-control form-control-sm" id="tpvReDataModelo" aria-describedby="tpvReDataModelo">
                                    <option value="0" selected>Seleccionar Modelo</option>
                                </select>
                                <select  class="form-control form-control-sm" id="tpvReDataConnect" aria-describedby="tpvReDataConnect">
                                    <option value="0" selected>Seleccionar Conectividad</option>
                                </select>
                                <div class="row" id="tvpRetiradaCHK">
                                    <div class="col">
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetBateria">Batería</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetEliminador">Eliminador</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetTapa">Tapa Ret</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetCable">Cable AC</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetBase">Base</label>
                                    </div>
                                </div>
                        </div>
                        <div class="col">           
                                <label for="idcaja" class="col-form-label-sm">Id Caja</label>
                                <input type="text" class="form-control form-control-sm" id="idcaja" aria-describedby="idcaja" readonly>
                        </div>
                        <div class="col">           
                            <label for="afiliacion_amex" class="col-form-label-sm">Afiliacion Amex</label>
                            <input type="hidden" id="tieneamex" name="tieneamex">
                            <input type="text" class="form-control form-control-sm" id="afiliacion_amex" aria-describedby="afiliacion_amex" readonly>
                        </div>
                        <div class="col">           
                            <label for="idamex" class="col-form-label-sm">Id Amex</label>
                            <input type="text" class="form-control form-control-sm" id="idamex" aria-describedby="idamex" readonly>
                        </div>
                    </div>
					<div class="row">
                        <div class="col">           
                                <label for="version" class="col-form-label-sm">Version</label>
                                <select  class="form-control form-control-sm" id="version" aria-describedby="version" readonly>
                                    <option value="0">Seleccionar</option>
                                </select>
                        </div>
                        <div class="col">           
                                <label for="aplicativo" class="col-form-label-sm">Aplicativo</label>
								<select  class="form-control form-control-sm" id="aplicativo" aria-describedby="aplicativo">
                                    <option value="0">Seleccionar</option>
                                </select>
                        </div>
                        <div class="col">           
                            <label for="producto" class="col-form-label-sm">Producto</label>
                            <select  class="form-control form-control-sm" id="producto" aria-describedby="producto" disabled>
								<option value="0">Seleccionar</option>
							</select>
                        </div>
                        <div class="col">           
                            <label for="rollos_instalar" class="col-form-label-sm">Rollos a Entregar</label>
                            <input type="text" class="form-control form-control-sm" id="rollos_instalar" aria-describedby="rollos_instalar" readonly>
                        </div>
			
						
                    </div>
                    <div class="row">
                            <div class="col">           
                                    <label for="version_ret" class="col-form-label-sm">Version Retirada</label>
                                    <select  class="form-control form-control-sm" id="version_ret" aria-describedby="version_ret" readonly>
                                        <option value="0">Seleccionar</option>
                                    </select>
                            </div>
                            <div class="col">           
                                    <label for="aplicativo_ret" class="col-form-label-sm">Aplicativo Retirado</label>
                                    <select  class="form-control form-control-sm" id="aplicativo_ret" aria-describedby="aplicativo_ret">
                                        <option value="0">Seleccionar</option>
                                    </select>
                            </div>
                            <div class="col">           
                                <label for="producto_ret" class="col-form-label-sm">Producto Retirado</label>
                                <select  class="form-control form-control-sm" id="producto_ret" aria-describedby="producto_ret" disabled>
                                    <option value="0">Seleccionar</option>
                                </select>
                            </div>
                            <div class="col">           
                                <label for="rollos_entregados" class="col-form-label-sm">Rollos Entregados</label>
                                <input type="text" class="form-control form-control-sm" id="rollos_entregados" aria-describedby="rollos_entregados" readonly>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col">           
                            <label for="simInData" class="col-form-label-sm">SIM Instalada</label>
                            <input type="text" class="form-control form-control-sm" id="sim_instalado" aria-describedby="sim_instalado">
                            <select  class="form-control form-control-sm" id="simInData" aria-describedby="simInData">
                                <option value="0" selected>Seleccionar Carrier</option>
                            </select>
                        </div>
						<div class="col">           
                            <label for="simReData" class="col-form-label-sm">SIM Retirada</label>
                            <input type="text" class="form-control form-control-sm" id="sim_retirado" aria-describedby="sim_retirado">
                            <select  class="form-control form-control-sm" id="simReData" aria-describedby="simReData">
                                <option value="0" selected>Seleccionar Carrier</option>
                            </select>
                        </div>
                        <div class="col-sm-3">           
                            <label for="folio_telecarga" class="col-form-label-sm">Folio Telecarga</label>
                            <input type="text" class="form-control form-control-sm" id="folio_telecarga" aria-describedby="folio_telecarga" readonly>
                        </div>
						<div class="col-sm-3">           
                            <label for="estatus_servicio" class="col-form-label-sm">Estatus Servicio</label>
                            <select  class="form-control form-control-sm" id="estatus_servicio" aria-describedby="estatus_servicio" disabled>
								<option value="0">Seleccionar</option>
							</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" id="rowRechazos" style="display: none;">           
                            <label for="rechazo" class="col-form-label-sm">Rechazo</label>
                            <select  class="form-control form-control-sm" id="rechazo" aria-describedby="rechazo" >
								<option value="0">Seleccionar</option>
							</select>
                        </div>
                        <div class="col-sm-4" id="rowSubRechazos" style="display: none;">           
                            <label for="subrechazo" class="col-form-label-sm">Sub Rechazo</label>
                            <select  class="form-control form-control-sm" id="subrechazo" aria-describedby="subrechazo" >
								<option value="0">Seleccionar</option>
							</select>
                        </div>
                        <div class="col-sm-4" id="rowCancelado" style="display: none;">           
                            <label for="cancelado" class="col-form-label-sm">Cancelado</label>
                            <select  class="form-control form-control-sm" id="cancelado" aria-describedby="cancelado" >
								<option value="0">Seleccionar</option>
							</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comentarios_tecnico" class="col-form-label-sm">Comentarios de Tecnico</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_tecnico" aria-describedby="comentarios_tecnico" readonly></textarea>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comentarios_cierre" class="col-form-label-sm">Comentarios de Cierre</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_cierre" aria-describedby="comentarios_cierre" readonly></textarea>
                        </div>
                        
                    </div>
					<div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="faltaSerie" value="option1">
                                <label class="form-check-label" for="faltaSerie">Falta serie</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="faltaEvidencia" value="option2">
                                <label class="form-check-label" for="faltaEvidencia">Falta Evidencia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="faltaInformacion" value="option2">
                                <label class="form-check-label" for="faltaInformacion">Falta Información</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="faltaUbicacion" value="option2">
                                <label class="form-check-label" for="faltaUbicacion">Falta ubicación</label>
                            </div>
                        </div>

                    </div>  
                    <div class="row" style="display:none" id="comentarios_valid" >
                        <div class="col">           
                            <label for="comentarios_validacion" id="comentarios_valid"  class="col-form-label-sm">Comentarios de Validación</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_validacion" aria-describedby="comentarios_validacion"></textarea>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="eventoId">
                    <input type="hidden" value="0" id="servicioId">
					<input type="hidden" value="0" id="tecnicoid"> 
                    <input type="hidden" value="0" id="odt">
                    <input type="hidden" value="0" id="latitud">
                    <input type="hidden" value="0" id="longitud">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                <div class="modal-footer" id="divBtnCV" style="display:none" >
                    <button type="button" class="btn btn-primary" name="btnComentValid" id="btnComentValid" >Guardar Comentario de Validación</button>
                </div>
                </div>
            </div>
            </div>
            <!-- MODAL Reasignar -->
            <div class="modal fade" tabindex="-3" role="dialog" id="showReasignar">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reasignar Tecnico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">           
                            <label for="reasignartecnico" class="col-form-label-sm">Tecnico</label>
                            <select class="form-control form-control-sm" name="reasignartecnico" id="reasignartecnico" aria-describedby="reasignartecnico">
                            </select>
                        </div>
                        
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSubmitReasignar">ReAsignar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>  
                </div>
            </div>
            </div>
            <!-- MODAL MAPS Ubicacion -->
            <div class="modal fade" tabindex="-3" role="dialog" id="showUbicacion">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubicacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div id="mapa" style="width: 700px; height: 500px;"></div>
                        <div class="row">
							<div class="col"><span id="ubicacionData"></span></div>
						</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>  
                </div>
            </div>
            </div>
            <!-- MODAL IMAGENES Ubicacion -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showImagenes">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Imagenes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 anyClass" id="carruselFotos"></div>
                        </div>
						
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div> 
                </div>
            </div>
            </div>
            <!-- MODAL Documentos Ubicacion -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showDocumentos">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Documentos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                
                                <div class="col-md-10" id="carruselDocs"></div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div> 
                    </div>
                </div>
            </div>
            <!-- MODAL Cambiar ODT -->
            <div class="modal fade" tabindex="-3" role="dialog" id="chgODT">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambiar ODT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">           
                                <label for="old_odt" class="col-form-label-sm">ODT Actual</label>
                                <input type="text" class="form-control form-control-sm" id="old_odt" aria-describedby="old_odt" readonly>
                                 
                            </div>
                            <div class="col-sm-3">           
                                <label for="new_odt" class="col-form-label-sm">Nueva ODT</label>
                                <input type="text" class="form-control form-control-sm" id="new_odt" aria-describedby="new_odt">
                                 
                            </div>  
                        </div>        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnChgODT">Cambiar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>  
                    </div>
                </div>
            </div>
            <!-- MODAL Cambiar FECHAS -->
            <div class="modal fade" tabindex="-3" role="dialog" id="fechaModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambiar Fechas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">           
                                <label for="odtF" class="col-form-label-sm">ODT</label>
                                <input type="text" class="form-control form-control-sm" id="odtF" aria-describedby="odtF" readonly>
                            </div>
                            <div class="col-sm-3">           
                                <label for="fechaAtencion" class="col-form-label-sm">Fecha Atencion</label>
                                <input type="text" class="form-control form-control-sm" id="fechaAtencion" aria-describedby="fechaAtencion">
                                 
                            </div>
                            <div class="col-sm-3">           
                                <label for="idOdt" class="col-form-label-sm"></label>
                                <input type="hidden" class="form-control form-control-sm" id="idOdt" aria-describedby="idOdt" readonly>
                                 
                            </div>
                             
                        </div>   
                        <div class="row">
                            <div class="col-sm-3">           
                                <label for="fechaAlta" class="col-form-label-sm">Fecha de Alta</label>
                                <input type="text" class="form-control form-control-sm" id="fechaAlta" aria-describedby="fechaAlta">
                                 
                            </div>
                             <div class="col-sm-3">           
                                <label for="fechaVen" class="col-form-label-sm">Fecha de Vencimiento</label>
                                <input type="text" class="form-control form-control-sm" id="fechaVen" aria-describedby="fechaVen">
                            </div> 
                        </div>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnChgFechas">Cambiar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>  
                    </div>
                </div>
            </div>

			<!-- Modal Historia Evento ODT -->
			<div class="modal fade" tabindex="-1" id="showHistoria" role="dialog" data-backdrop="static" data-keyboar="false">
				
				<div class="modal-dialog  modal-dialog-scrollable modal-xl" role="document">
					<div class="modal-content">
						
						<div class="modal-header">
							<h5 class="modal-title"> HISTORIAL ODT  </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							
						</div>
						<div class="mb-3">
							<center> <input type="text" class="form-control" value="0" id="historiaOdt" name="historiaOdt" readonly> </center>
						</div>
						
						<div class="modal-body">
                            <h5>Bitácora ODT:</h5>
							<table id="historia" class="display responsive nowrap" width="100%">
								<thead> 
									<tr>
										<th> Id </th>
										<th> ODT </th>
										<th> Estatus </th>
										<th> Modificado Por </th>
                                        <th> Correo </th>
									</tr>
								</thead>
								 <tbody>
                        
								</tbody>
								
							
							</table>
							<br><hr>
                            <h5>Movimientos de Inv Odt</h5>
							<table id="historiaevento" class="display responsive nowrap" width="100%">
  
								<thead>
									<tr>
										<th> Serie de Entrada</th>
										<th> Aplicativo </th>
										<th> Conectividad </th>
										<th> Serie de Salida </th>
										<th> SIM de Entrada</th>
										<th> SIM de Salida</th>
									</tr>
								</thead>
								 <tbody>
                        
								</tbody>
	
							
							</table>
							
							<div class="modal-footer">
								<input type="hidden" value="0" id="historiaOdt" name="historiaOdt">
							</div>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			<!-- End Modal Historia Evento ODT -->
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-html5-1.6.5/fc-3.3.2/fh-3.1.8/datatables.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
	<script src="js/zoomifyc.min.js" ></script> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/eventos.js"></script> 
    <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7&key=AIzaSyAQCiiA5ZZ1RoIxJquirYDaLOwRbZAQDzA&callback=initMap" async defer></script>

</body>

</html>