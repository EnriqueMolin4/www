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
            <h3>Cierre de Evento</h3>
            <div style="border-style: solid; padding: 10px;">
               <div class="row">
                  <div id="avisos" class="display:none;" style="background-color:red;"></div>
               </div>
              <div class="row">
                  <div class="col-sm-4">
                     <label for="odt" class="col-form-label-sm">Ordenes de Trabajo  <b><span id="nombreBanco"></span></b> </label> 
                     <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt"  readonly>
                  </div>
                  <div class="col-sm-4">
                     <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                     <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion">
                  </div>
                  <div class="col-sm-4">           
                     <label for="tipoatencion" class="col-form-label-sm">Tipo Atencion</label>
                     <select  class="form-control form-control-sm" id="tipoatencion" aria-describedby="tipoatencion">
                        <option value="0" selected>Seleccionar....</option>
                        <option value="1">Presencial</option>
                        <option value="2">Telefonico</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-10" style="padding-left:30px;padding-top:30px;">  
                     <input type="hidden"  id="servicioTipo" value='0'>
                     <a href="eventos.php" class="btn btn-warning" id="btnRegresar">Regresar Eventos</a>
                     <button class="btn btn-primary" id="btnEvidencias">Ver Evidencias</button>
                     <button class="btn btn-success" id="btnConsultar">Validar Cierre Evento</button>
                  </div>
               </div>
            </div>
            <div id="divEvento" style="display:none ">
               <div class="row">
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
                     <label for="tecnico" class="col-form-label-sm">Tecnico </label>
                                <?php if ( $_SESSION['tipo_user'] == 'supOP' || $_SESSION['tipo_user'] == 'supervisor' || $_SESSION['tipo_user'] == 'admin' || $_SESSION['tipo_user'] == 'callcenter' || $_SESSION['tipo_user'] == 'callcenterADM' ) {  ?>
                                <a href="#" id="btnReasignarTecnico"><i class="fas fa-arrows-alt-h"></i>Reasignar</a>
                     <?php } ?>  
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
                     </select>
                  </div>
                  <div class="col">
                     <label for="version" class="col-form-label-sm">Version Instalada</label>
                     <select  class="form-control form-control-sm" id="version" aria-describedby="version" readonly>
                        <option value="0">Seleccionar</option>
                     </select>
                  </div>
                  <div class="col">
                     <label for="aplicativo" class="col-form-label-sm">Aplicativo Instalado</label>
                     <select  class="form-control form-control-sm" id="aplicativo" aria-describedby="aplicativo" readonly>
                        <option value="0">Seleccionar</option>
                     </select>
                  </div>
                  <div class="col">
                     <label for="producto" class="col-form-label-sm">Producto Instalado</label>
                     <select  class="form-control form-control-sm" id="producto" aria-describedby="producto" disabled>
                        <option value="0">Seleccionar</option>
                     </select>
                  </div>
               </div>
               <div class="row">
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
                     <label for="version_ret" class="col-form-label-sm">Version Retirada</label>
                     <select  class="form-control form-control-sm" id="version_ret" aria-describedby="version" readonly>
                        <option value="0">Seleccionar</option>
                     </select>
                  </div>
                  <div class="col">
                     <label for="aplicativo_ret" class="col-form-label-sm">Aplicativo Retirado</label>
                     <select  class="form-control form-control-sm" id="aplicativo_ret" aria-describedby="aplicativo" readonly>
                        <option value="0">Seleccionar</option>
                     </select>
                  </div>
                  <div class="col">
                     <label for="producto_ret" class="col-form-label-sm">Producto Retirado</label>
                     <select  class="form-control form-control-sm" id="producto_ret" aria-describedby="producto" readonly>
                        <option value="0">Seleccionar</option>
                     </select>
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
                  <div class="col">           
                     <label for="rollos_instalar" class="col-form-label-sm">Rollos a Entregar</label>
                     <input type="text" class="form-control form-control-sm" id="rollos_instalar" aria-describedby="rollos_instalar" readonly>
                  </div>
                  <div class="col">           
                     <label for="rollos_entregados" class="col-form-label-sm">Rollos Entregados</label>
                     <input type="text" class="form-control form-control-sm" id="rollos_entregados" aria-describedby="rollos_entregados" readonly>
                  </div>
               </div>
               <div class="row">
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
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col-sm-4" id="rowSubRechazos" style="display: none;">
                     <label for="subrechazo" class="col-form-label-sm">Sub Rechazo</label>
                     <select  class="form-control form-control-sm" id="subrechazo" aria-describedby="subrechazo" >
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
                  <div class="col-sm-4" id="rowCancelado" style="display: none;">
                     <label for="cancelado" class="col-form-label-sm">Cancelado</label>
                     <select  class="form-control form-control-sm" id="cancelado" aria-describedby="cancelado" >
                        <option value="0" selected>Seleccionar</option>
                     </select>
                  </div>
               </div>
               <div class="row" id="rowCierreTel" style="display: none;">
                  
                  <div class="col-sm-4">
                    <label for="fecha_rep" class="col-form-label-sm">Fecha Reprogramacion</label>
                    <input type="text" class="form-control form-control-sm" id="fecha_rep" aria-describedby="fecha_rep">
                  </div>
               </div>
               <div class="row">
                  <div class="col">           
                     <label for="comentarios_tecnico" class="col-form-label-sm">Comentarios de Tecnico</label>
                     <textarea  class="form-control form-control-sm" rows="5" id="comentarios_tecnico" aria-describedby="comentarios_tecnico" readonly></textarea>
                  </div>
               </div>
               <div class="row showcausacambio">
                  <div class="col-sm-3">
                     <label for="causas_cambio" class="col-form-label-sm">Causas de Cambio</label>
                     <select  class="form-control form-control-sm" id="causas_cambio" aria-describedby="causas_cambio">
                        <option value="0">Seleccionar</option>
                     </select>
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
               <div class="row">
                  <div class="col-sm-4">
                     <label for="cod_rech" class="col-form-label-sm">Código Rechazo</label>
                     <input type="text" class="form-control form-control-sm" id="cod_rech" aria-describedby="cod_rech">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aplicaExito" value="option1">
                        <label class="form-check-label" for="aplicaExito">Aplica Éxito</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label for="cod_rech2" class="col-form-label-sm">Código Rechazo 2</label>
                     <input type="text" class="form-control form-control-sm" id="cod_rech2" aria-describedby="cod_rech2">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aplicaRechazo" value="option1">
                        <label class="form-check-label" for="aplicaRechazo">Aplica Rechazo 2</label>
                     </div>
                  </div>
               </div>
               <br><br>
               <input type="hidden" value="0" id="eventoId">
               <input type="hidden" value="0" id="servicioId">
               <input type="hidden" value="0" id="tecnicoid">
               <input type="hidden" value="0" id="odt">
               <input type="hidden" value="0" id="latitud">
               <input type="hidden" value="0" id="longitud">
			   <input type="hidden" value="0" id="cve_banco">
               <input type="hidden" id="tipo_user" name="tipo_user" value="<?php echo $_SESSION['tipo_user']; ?>">
               <button type="button" class="btn btn-success" name="btnUpdateEvento" id="btnUpdateEvento">Cerrar Evento</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               <button type="button" class="btn btn-primary" name="btnComentValid" id="btnComentValid" >Guardar Comentario de Validación</button>
               <button type="button" class="btn btn-warning" name="btnAddIncidencia" id="btnAddIncidencia">Generar Incidencia</button>
            </div>
         </div>
      </main>
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
      <!-- MODAL INCIDENCIA -->
      <div class="modal fade" tabindex="-3" role="dialog" id="modalIncidencia">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">GENERAR INCIDENCIA</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
            
                  <div class="row">
                     <div class="col-md-5">
                        <label for="tipoIncidencia" class="col-form-label-sm">Tipo Incidencia</label><br>
                        <select class="form-control form-control-sm" name="tipoIncidencia" id="tipoIncidencia">
                           <option value="0" >Seleccionar</option>
                           <option value="e">Evidencia</option>
                           <option value="i">Inventario</option>
                        </select>
                     </div>
                  </div><hr>

                     <div class="row" id="divEvidencia1" style="display:none;" >
                        <div class="col">
                           <label for="incidenciasEvidencia" class="col-form-label-sm">EVIDENCIA</label><br>
                           <select name="incidenciasEvidencia[]" id="incidenciasEvidencia" class="form-control" multiple>
                              
                              <option value="OTROS">OTROS</option>
                              <option value="EVIDENCIA ILEGIBLE">EVIDENCIA ILEGIBLE</option>
                              <option value="NO COINCIDE">NO COINCIDE</option>
                              <option value="VOBO">VOBO</option>
                              <option value="FALTA INFORMACION">FALTA INFORMACION</option>
                              <option value="PAPELETA">PAPELETA</option>
                              <option value="PRUEBAS">PRUEBAS</option>
                              <option value="COMERCIO">COMERCIO</option>
                              <option value="UBICACION">UBICACION</option>
                              <option value="DAÑO">DAÑO</option>
                              <option value="ACCESORIOS">ACCESORIOS</option>
                           </select>
                        </div><br>
                     </div>

                     

                     <div class="row" id="divInventario1" style="display:none">
                        <div class="col">
                           <label for="incidenciasInventario" class="col-form-label-sm">INVENTARIO</label><br>
                           <select name="incidenciasInventario[]" id="incidenciasInventario" class="form-control" multiple>
                              
                              <option value="SERIE">SERIE</option>
                              <option value="SIM">SIM</option>
                              
                           </select>
                        </div><br>
                        
                     </div>

                     <br>
                     <div class="row" id="divComentE" style="display:none;"><br>
                        <div class="col">
                           <label class="form-check-label" for="descripcionE">Comentarios para Operaciones</label>
                           <textarea class="form-control" name="descripcionE" id="descripcionE" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="row" id="divComentI" style="display:none;"><br>
                        <div class="col">
                           <label class="form-check-label" for="descripcionI">Comentarios para Almacén</label>
                           <textarea class="form-control" name="descripcionI" id="descripcionI" rows="5"></textarea>
                        </div>
                     </div>
                                          
                     
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" name="btnGuardarIncidencia" id="btnGuardarIncidencia">Guardar</button>
               </div>
            </div>
         </div>
      </div>
      <!-- MODAL IMAGENES Ubicacion -->
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
   <script src="js/jquery-ui.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
   <script src="js/zoomifyc.min.js" ></script> 
   <script type="text/javascript" src="js/jquery.toaster.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/bootstrap-multiselect.min.js"></script>
   <script src="js/main.js"></script>
   <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7&key=AIzaSyAQCiiA5ZZ1RoIxJquirYDaLOwRbZAQDzA&callback=initMap" async defer></script>
   <style>
        .multiselect{background-color: initial;border: 1px solid #ced4da;height: auto;
        }

        .multiselect-container
        {height: auto  ;  overflow-x: hidden;overflow-y: scroll; width: 550px; }
        
    </style>
   <script>
      $(document).ready(function() {
         
        

          //GET info from URL
          const queryString = window.location.search;
          const urlParams = new URLSearchParams(queryString);
          const id = urlParams.get('id');

          $("#eventoId").val(id);

          $("#fechaVen_inicio").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
          });

          $("#fecha_rep").datetimepicker({
            timepicker:false,
            format:'Y-m-d'
         });
      
          $("#fechaVen_fin").datetimepicker({
              timepicker:false,
              format:'Y-m-d'
          });

          $("#fecha_atencion").datetimepicker({
              timepicker:false,
              format:'Y-m-d'
          });

          //Traer Info Basica ODT
          $.ajax({ 
              type: 'POST',
              url : 'modelos/eventos_db.php',
              data: 'module=getOdtById&id='+ id,
          }).done(function(result) {
			  result = JSON.parse(result);
               $("#odt").val(result.odt);
			      $("#cve_banco").val(result.cve_banco);
               $("#nombreBanco").html(result.banco);
			      getTipoEvento();
			      getEstatusEvento();
			      getEstatusServicio(result.cve_banco);
			      getRechazos(result.cve_banco);
			      getSubRechazos(result.cve_banco);
			      getCancelado();
			      getProductos(result.cve_banco);
			      getAplicativo(result.cve_banco);
			      getVersion(result.cve_banco);
			      getModelos(result.cve_banco);
			      getConectividad(result.cve_banco);
			      getCarrier();
			      getCausasCambios();
          });

          $("#btnEvidencias").on("click",function() {
              var windowname = $("#odt").val();
              window.open("galeria_img.php?odt="+$("#odt").val() , windowname, "resizable=no, toolbar=no, scrollbars=no, menubar=no, status=no, directories=no ");

          })

          $(document).on("click","#btnUbicacion", function() {
              $("#showUbicacion").modal({show: true, backdrop: false, keyboard: false})
          })

          $("#btnReasignarTecnico").on("click",function() {
              $("#showReasignar").modal("show");
              getTecnicos(0)
          })

          $("#btnSubmitReasignar").on("click", function() {
              $.ajax({
                  type: 'GET',
                  url: 'modelos/eventos_db.php', // call your php file
                  data: 'module=assignarTecnico&tecnico='+$("#reasignartecnico").val()+"&odtid="+$("#odt").val(),
                  cache: false,
                  success: function(data){    
                      $("#tecnicoid").val(data);
                          $.toaster({
                              message: 'Se Reasigno el Tecnico',
                              title: 'Aviso',
                              priority : 'success'
                          });   
                    
                      $("#tecnico").val( $("#reasignartecnico option:selected").text() );
                      $("#showReasignar").modal("hide");
                      $("#reasignartecnico").val('0');
                      //$('#showEvento').modal("hide");
                        
                  },
                  error: function(error){
                      var demo = error;
                  }
              });
          })


          $('#showUbicacion').on('show.bs.modal', function (e) {
              // initMap()
              var latitud = $("#latitud").val().length > 0 ? parseFloat($("#latitud").val()) : 0;
              var longitud = $("#longitud").val().length > 0 ? parseFloat($("#longitud").val()) : 0;
              var cliente = {lat: latitud, lng: longitud};

              var map = new google.maps.Map(document.getElementById('mapa'), {
                      center: cliente,
                      zoom: 15
                  });

                  var marker = new google.maps.Marker({position: cliente, map: map});
                  $("#ubicacionData").html("Ubicacion: "+latitud+" "+longitud+" Fecha Atencion: "+$("#fecha_atencion").val() );

    
          });

          $('#modalIncidencia').on('show.bs.modal', function (e){
            camposIncidencias();
          })

          $(document).on('click','.btnDelImage', function() {
              var idImg = $(this).attr('data');
              $.ajax({
                  type: 'GET',
                  url: 'modelos/eventos_db.php', // call your php file
                  data: { module: 'imgDelete',idImg: idImg },
                  cache: false,
                  success: function(data){
                      if(data == "1") {
                          $.toaster({
                              message: 'Se borro con exito la imagen ',
                              title: 'Aviso',
                              priority : 'success'
                          });  
                          mostrarImagenes($("#odt").val())
                      }
                  }
              });
          })

          $("#estatus_servicio").on("change",function() {    
              var servicio = $("#servicioId").val();
              var noserie = $("#tpv").val();
              var modelo = $("#tpvInDataModelo").val();
              var conectividad = $("#tpvInDataConnect").val();

    
                  if( $(this).val() == '1' || $(this).val() == '16' || $(this).val() == '0' ) {
                      $("#rowCancelado").hide();
                      $("#rowRechazos").hide();
                      $("#rowSubRechazos").hide();
                      $("#comentarios_cierre").val('');
                  } else {

                

                      if($(this).val() == '14' ) {
                          $("#btnUpdateEvento").attr('disabled',false);
                          //$("#btnUpdateEvento").attr('disabled',false);
                          //$("#divBtnCV").show();
                          $("#rowCancelado").show();
                          $("#rowRechazos").hide();
                          $("#rowSubRechazos").hide();
						  $("#rowCierreTel").hide()
                          $("#comentarios_cierre").val('');

                      } else if($(this).val() == '15') { 
                        $("#btnUpdateEvento").attr('disabled',false)


                            //$("#btnComentValid").attr('disabled',false);
                            //$("#divBtnCV").show();
                            $("#rowCierreTel").show();
                            $("#rowCancelado").hide();
                            $("#rowRechazos").show();
                            $("#rowSubRechazos").show();
                            $("#comentarios_cierre").val('');
                            $("#comentarios_cierre").val('Cierre Telefónico');
                        
                      } else if($(this).val() == '13') {
                          $("#btnUpdateEvento").attr('disabled',false);
                          $("#rowCancelado").hide();
                          $("#rowRechazos").hide();
                          $("#rowSubRechazos").hide();
						  $("#rowCierreTel").hide();
                          getScriptEvento(servicio,noserie,conectividad,modelo);
                        
                      } else {
                          $("#rowCancelado").hide();
                          $("#rowRechazos").hide();
                          $("#rowSubRechazos").hide();
                          $("#comentarios_cierre").val('');
						  $("#rowCierreTel").hide();
                          //$("#btnUpdateEvento").attr('disabled',true);
                      }
                  }
            
          })

         $("#btnComentValid").on('click', function() {
    
            var aplicaExito = $("#aplicaExito").is(":checked") ? 1 : 0 ;
            var aplicaRechazo = $("#aplicaRechazo").is(":checked") ? 1 : 0 ;
            var faltaSerie = $("#faltaSerie").prop('checked') ? 1 : 0 ;
            var faltaEvidencia = $("#faltaEvidencia").prop('checked') ? 1 : 0 ;
            var faltaInformacion = $("#faltaInformacion").prop('checked') ? 1 : 0 ;
            var faltaUbicacion = $("#faltaUbicacion").prop('checked') ? 1 : 0 ;
    
              if( $('#comentarios_validacion').val().length > 0  )
              {
                  var dn = { module : 'guardarComVal', comentario:$('#comentarios_validacion').val(), odt:$('#odt').val(), codigo_rechazo:$("#cod_rech").val(),codigo_rechazo_2: $("#cod_rech2").val(),aplica_exito:aplicaExito,aplica_rechazo: aplicaRechazo,
              faltaserie: faltaSerie,faltaubicacion:faltaUbicacion,faltainformacion:faltaInformacion,faltaevidencia:faltaEvidencia ,tecnico: $("#tecnicoid").val() };
              console.log(dn);
              $.ajax({ 
                      type: 'POST',
                      url : 'modelos/eventos_db.php',
                      data: dn,
                      cache: false,
                      success: function(data){
                        
                    
                      $.toaster({
                              message: data,
                              title: 'Aviso',
                              priority : 'success'
                          });
                          //cleartext();
                      },
                      error: function(error){
                          var demo = error;
                      }
                  });
                
              }else{
                  $.toaster({
                  message: 'Ingresa el comentario de validacion',
                  title: 'Aviso',
                  priority : 'danger'
                      });}
        
          })

          $("#btnAddIncidencia").on('click', function(){
               $("#modalIncidencia").modal("show");
          })

          $("#btnConsultar").on("click",function() {
            
              var searchAfiliacion = $("#afiliacion").val();
              var searchODT = $("#odt").val();
			   

              $.ajax({
                  type: 'POST',
                  url: 'modelos/eventos_db.php',
                  data: { module: 'validateOdt',odt: searchODT, afiliacion: searchAfiliacion }
              }).done( function(data) { 
                  var exist = JSON.parse(data).length;

                  if( exist == 0) {

        

                      Swal.fire({
                          title: 'Cierre de Eventos',
                          text: "EL Comercio no tiene Asignada la ODT",
                          footer: 'Comunicate con tu Supervisor',
                          icon: 'warning',
                      })

                  } else { 
                      $.ajax({
                          type: 'GET',
                          url: 'modelos/eventos_db.php', // call your php file
                          data: 'module=getstados',
                          cache: false,
                          success: function(data){
                          $("#estado").html(data);            
                          },
                          error: function(error){
                              var demo = error;
                          }
                      });

                      $.ajax({
                         type: 'GET',
                          url: 'modelos/eventos_db.php', // call your php file
                          data: 'module=getevento&eventoid='+id,
                          cache: false,
                          success: function(data){
                        
                              var info = JSON.parse(data);
                        
                              if(info == null ) {
                                  $("#showEvento").modal('hide');
                                  cleartext()
                                  alert("Hay Problemas con los Datos")

                              } else {

                                  $.each(info, function(index, element) {

                                      // trae validaciones de Campos obligatorios
                                          camposObligatorios(element.tipo_servicio)
                                              .then( (data) => {
                                                  PermisosEvento = data
                                              })
                                        
                                           //EXTRAS
                                          getInfoExtra(element.odt);

                                          $("#odt").val(element.odt)
                                          $("#afiliacion").val(element.afiliacion)
                                          $("#tipo_servicio").val(element.servicioNombre);
                                          $("#tipo_subservicio").val(element.subservicioNombre);
                                          $("#fecha_alta").val(element.fecha_alta);
                                          $("#fecha_vencimiento").val(element.fecha_vencimiento)
                                          $("#fecha_cierre").val(element.fecha_cierre);
                                          $("#servicioId").val(element.tipo_servicio);
                                        
                                          if(element.tipo_servicio == '15') {
                                          $("#comercio").val(element.cliente_vo)
                                          } else {
                                             $("#comercio").val(element.comercioNombre)
                                          }
                                          $("#receptor_servicio").val(element.receptor_servicio);
                                            var fechaAtencion = element.fecha_atencion == null ? '' : element.fecha_atencion.split(' ')[0] ;
                                          $("#fecha_atencion").val(fechaAtencion);
                                          $("#colonia").val(element.colonia)
                                          $("#ciudad").val(element.municipioNombre)
                                          $("#estado").val(element.estadoNombre)
                                          $("#direccion").val(element.direccion)
                                          $("#telefono").val(element.telefono)
                                          $("#descripcion").val(element.descripcion);
                                          $("#hora_atencion").val(element.hora_atencion+" | "+element.hora_atencion_fin)
                                          $("#hora_llegada").val(element.hora_llegada)
                                          $("#hora_salida").val(element.hora_salida)
                                          $("#tecnico").val(element.tecnicoNombre)
                                          $("#tecnicoid").val(element.tecnico)
                                          $("#estatus").val(element.estatusNombre)
                                          $("#servicio").val(element.servicioNombre)
                                          $("#comentarios_tecnico").val(element.comentarios)
                                          $("#comentarios_validacion").val(element.comentarios_validacion)
                                          $("#servicio_final").val(element.serviciofinalNombre)
                                          $("#comentarios_cierre").val(element.comentarios_cierre)
                                          $("#fecha_asignacion").val(element.fecha_asignacion);
                                          $("#hora_comida").val(element.hora_comida+" | "+element.hora_comida_fin);
                                          $("#latitud").val( element.latitud );
                                          $("#longitud").val( element.longitud );
                                    
                                          $("#tipo_credito").val(element.tipocreditoNombre);
                                          $("#tieneamex").val(element.tieneamex);
                                          $("#afiliacion_amex").val(element.afiliacionamex);
                                          $("#idamex").val(element.amex);
                                          $("#idcaja").val(element.id_caja);
                                          $("#tpv").val(element.tpv_instalado);
                                          $("#tpv_retirado").val(element.tpv_retirado);
                                          $("#version").val(element.version);
                                          $("#version_ret").val(element.version_ret);
                                          $("#aplicativo").val(element.aplicativo);
                                          $("#aplicativo_ret").val(element.aplicativo_ret);
                                          $("#producto").val(element.producto);
                                          $("#producto_ret").val(element.producto_ret);
                                          $("#rollos_instalar").val(element.rollos_instalar);
                                          $("#rollos_entregados").val(element.rollos_entregados);
                                          $("#sim_instalado").val(element.sim_instalado);
                                          $("#sim_retirado").val(element.sim_retirado);
                                          //$("#estatus_servicio").val(element.estatus_servicio);
										  $("#estatus_servicio option:contains("+element.nombreStatus+")").attr('selected', true);
										  $("#cve_banco").val(element.cve_banco);
											
                                           //Informacion Faltante
                                          $("#faltaSerie").prop('checked',parseInt(element.faltaserie));
                                          $("#faltaEvidencia").prop('checked',parseInt(element.faltaevidencia))  ;
                                          $("#faltaInformacion").prop('checked',parseInt(element.faltainformacion)) ;
                                          $("#faltaUbicacion").prop('checked',parseInt(element.faltaubicacion)) ;
                                        
                                          if (element.estatus_servicio == '13' )
                                          {
                                              if($("#tipo_user").val() == 'callcenterADM' ) {
                                                  $("#estatus_servicio").attr("disabled",false);
                                              } else {
                                                  $("#estatus_servicio").prop("disabled",true);
                                                  $("#btnUpdateEvento").attr("disabled",true);
                                              }

                                          }  else {
                                            
                                          }
                                    
                                          $("#folio_telecarga").val(element.folio_telecarga);
                                          $("#tpvInDataModelo").val(element.tvpInModelo);
                                          $("#tpvInDataConnect").val(element.tvpInConectividad);
                                          $("#tpvReDataModelo").val(element.tvpReModelo);
                                          $("#tpvReDataConnect").val(element.tvpReConectividad);
                                          $("#simInData").val(element.simInCarrier);
                                          $("#simReData").val(element.simReCarrier);

                                          if(element.servicio == '15') {
                                              $("#labelAfiliacion").html('Folio');
                                              $("#col_tipocredito").show();
                                              $("#col_serviciofinal").hide();
                                          } else {
                                              $("#labelAfiliacion").html('Afiliacion');
                                              $("#col_tipocredito").hide();
                                              $("#col_serviciofinal").show();
                                          }

                                          if(element.tecnico =='0') {
                                              $("#btnReasignarTecnico").hide();
                                          } else {
                                              $("#btnReasignarTecnico").show();
                                          }

                                          if(element.estatus == '3' || element.estatus == '1' ) {
                                              $("#btnReasignarTecnico").hide();
                                          } else {
                                              $("#btnReasignarTecnico").show();
                                          }
                                        
                                          $("#divBtnCV").show();
                                          $("#comentarios_valid").show();
                                          //getScriptEvento(element.servicio,element.tpv_instalado)
                                          //INTENTAR VALIDACIÓN AQUÍ
                                        
                                          if(element.estatus_servicio == '13')
                                          {
                                              $("#divBtnCV").show();
                                              $("#comentarios_valid").show();
                                            
                                          } else if (element.estatus_servicio == '14')
                                          {
                                            
                                          }else if (element.estatus_servicio == '15')
                                          {
                                              $("#divBtnCV").show();
                                              $("#comentarios_valid").show();
                                              $("#rowRechazos").show();
                                            
                                              $("#rowSubRechazos").show();
                                          }

                                          if( element.tipo_servicio == '2' || element.tipo_servicio == '8' || element.tipo_servicio == '13' || element.tipo_servicio == '14' ||  element.tipo_servicio == '26' || element.tipo_servicio == '30' || element.tipo_servicio == '33' || element.tipo_servicio == '45' || element.tipo_servicio == '47' || element.tipo_servicio == '48') {
                                              $(".showcausacambio").show();
                                          } else {
                                              $(".showcausacambio").hide();
                                          }

                                        
                                          $("#cancelado").val(element.cancelado);

                                          tipodeUsuario(element.estatus);
                                          if (element.estatus_servicio == '15' )
                                          {
                                              $("#rowRechazos").show();
                                              $("#rowSubRechazos").show();
                                              $("#rechazo").val(element.rechazo);
                                              $("#subrechazo").val(element.subrechazo);
                                          }
                                  })

                                  $("#divEvento").show();
                              }         
                          },
                          error: function(error){
                              var demo = error;
                              alert(error)
                          }
                      });
                  }
              })
        
              $("#divImagenes").hide();
              $("#divImagenes").html('');
            
          })

      $("#btnUpdateEvento").on("click",function() {
            var validar = 0;
            var msg = '';

			var eventoId = $("#eventoId").val();
			var odt = $("#odt").val();
			var comentario = $("#comentarios_cierre").val();
			var estatus = $("#estatus_servicio").val();
            var foliotelecarga = $("#folio_telecarga").val();
            var version = $("#version").val();
            var aplicativo = $("#aplicativo").val();
            var version_ret = $("#version_ret").val();
            var aplicativo_ret = $("#aplicativo_ret").val();
            var receptorservicio = $("#receptor_servicio").val();
            var tecnico = 	$("#tecnicoid").val();
			var servicioId = $("#servicioId").val();
            var fecha_atencion = $("#fecha_atencion").val();
            var hora_llegada = $("#hora_llegada").val();
            var hora_salida = $("#hora_salida").val();
            //Prueba fecha vencimiento dias
            var fecha_vencimiento = ("#fecha_vencimiento");
            //

			//ODT checkbox
			var odtGetNet = $("#odtGetNet").is(":checked") ? 1 : 0;
			var odtNotificado = $("#odtNotificado").is(":checked") ? 1 : 0;
			var odtDescarga = $("#odtDescarga").is(":checked") ? 1 : 0;
			
			//TPV Retirado
			var tvpRetBateria = $("#tvpRetBateria").is(":checked") ? 1 : 0;
			var tvpRetEliminador = $("#tvpRetEliminador").is(":checked") ? 1 : 0;
			var tvpRetTapa = $("#tvpRetTapa").is(":checked") ? 1 : 0;
			var tvpRetCable = $("#tvpRetCable").is(":checked") ? 1 : 0;
			var tvpRetBase = $("#tvpRetBase").is(":checked") ? 1 : 0;
			
			// Rechazo
			var rechazo = $("#rechazo").val();
			var subrechazo = $("#subrechazo").val();
			var cancelado = $("#cancelado").val();
			
            var tipoatencion = $("#tipoatencion").val();
			var fecha_reprogramacion = $("#fecha_rep").val();
			//DTOS ACtulizables
            var tpv = $("#tpv").val();
            var tvpInModelo = $("#tpvInDataModelo").val();
            var tpvInConnect = $("#tpvInDataConnect").val();
            var tpv_retirado = 	$("#tpv_retirado").val();
            var tvpReModelo = $("#tpvReDataModelo").val();
            var tpvReConnect = $("#tpvReDataConnect").val();
			var idcaja = 	$("#idcaja").val();
			var afiliacion_amex = 	$("#afiliacion_amex").val();
			var idamex = 	$("#idamex").val();
            var sim_instalado = 	$("#sim_instalado").val();
            var simInData = $("#simInData").val();
            var sim_retirado = 	$("#sim_retirado").val();
            var simReData = $("#simReData").val();
            var producto = 	$("#producto").val();
            var producto_ret = 	$("#producto_ret").val();

            //Rollos
            var rollosInstalar = $("#rollos_instalar").val();
            var rollosInstalados = $("#rollos_entregados").val();

            //Informacion Faltante
            var faltaSerie = $("#faltaSerie").prop('checked') ? 1 : 0 ;
            var faltaEvidencia = $("#faltaEvidencia").prop('checked') ? 1 : 0 ;
            var faltaInformacion = $("#faltaInformacion").prop('checked') ? 1 : 0 ;
            var faltaUbicacion = $("#faltaUbicacion").prop('checked') ? 1 : 0 ;

            var causacambio = $("#causas_cambio").val();

            //codigos rechazo
            var codigo_rechazo = $("#cod_rech").val();
            var codigo_rechazo_2 = $("#cod_rech2").val();
            var aplica_exito = $("#aplicaExito").prop('checked') ? 1 : 0 ;
            var aplica_rechazo = $("#aplicaRechazo").prop('checked') ? 1 : 0 ;
            
            //Validar si es obligatorio la TVP INStalada
            if( PermisosEvento.tvp_instalada == '1' &&  estatus == '13' ) {
                
                if(tpv.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una terminal instalada al Evento \n ";
                }

            }

            //Validar si es obligatorio la TVP Retirada
            if( PermisosEvento.tpv_salida == '1' &&  estatus == '13' ) {
                
                if(tpv_retirado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una terminal retirada al Evento \n ";
                }

            }

            //Validar si es obligatorio la SIM Retirada
            if( PermisosEvento.sim_retirado == '1' &&  estatus == '13' ) {
                
                if(sim_retirado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una sim retirada al Evento \n ";
                }

            }

            //Validar si es obligatorio la SIM Instalado
            if( PermisosEvento.sim_instalado == '1' &&  estatus == '13' ) {
                
                if(sim_instalado.length == 0) {
                    validar++;
                    msg += "Necesitas asignar una sim instalada al Evento \n ";
                }

            }

            //Validar Rollos 
            if( PermisosEvento.rollos == '1' &&  estatus == '13' ) {

                if( rollosInstalar != rollosInstalados ) {
                    validar++;
                    msg += "La cant de rollos no coincide \n ";
                }
            }
            if(tipoatencion == '0')
            {
                validar++;
                msg += "Necesitas seleccionar el tipo de atención \n ";
            }

            if(tecnico == 0) {
                validar++;
                msg += "Necesitas asignar un tecnico al Evento \n ";
            }

            if(!existeFecha(fecha_atencion) ) {
                validar++;
                msg += "Se necesita agregar la fecha de atencion \n ";
            }
            
            if(hora_llegada.length == 0 ) {
                validar++;
                msg += "Se necesita agregar la hora de llegada \n ";
            }

            if( hora_salida.length == 0 ) {
                validar++;
                msg += "Se necesita agregar la hora de salida \n ";
            }
            

            if(comentario.length <= 200 &&  estatus == '13' ) {
                validar++;
                msg += "Se necesita mas información en las observaciones (minimo 200 caracteres) \n ";
            }

            //Validar cuando sea Cambio que pongan la causa 
            if(estatus == '14' || estatus == '15') {
				//No Aplica
			} else {
            
				if( servicioId == '2' || servicioId == '8' || servicioId == '13' || servicioId == '14' ||  servicioId == '26' || servicioId == '30' || servicioId == '33' || servicioId == '45') {
					if(causacambio == '0' ) {
						validar++;
						msg += "Se necesita La causa de cambio  \n ";
					}
				}
			}

            if(estatus == '14') {

                if(cancelado == '0') {
                    validar++;
                    msg += "Se necesita la causa de cancelacion ";
                }

                /*if(tipoatencion == '2')
				{
					console.log("Telefonico");
				} else {
					validar++;
                    msg += "Se necesita seleccionar el tipo de Atención Telefonica \n  <br>";
				}*/
            } 

            if(estatus == '15') {
                

              if(rechazo == '0') {
                  validar++;
                  msg += "Se necesita la causa de rechazo ";

              } else if (subrechazo == '0') {
                  validar++;
                  msg += "Se necesita la causa de subrechazo ";
              } else {
                if ( $("#subrechazo").find(':selected').data('prog')  == '1' )
				  {
					  if( tipoatencion == '2') {
						  if( fecha_reprogramacion.length == 0 )
						  {
							validar++;
							msg += "Se necesita la fecha de reprogramacion ";
						  }
					  }
				  }
			  }
			}

           if(tpv.length > 0 && tpv_retirado.length > 0 )
           {
                //Validar que no se repita la serie tpv o sim inst y ret
            if(tpv == tpv_retirado)
            {
                validar++;
                msg *= " No se puede repetir la misma serie de tpv";
            }

            
            if(tpv == sim_retirado)
            {
                validar++;
                msg += "No se puede repetir la misma serie";
            }
            if(tpv == sim_instalado)
            {
                validar++;
                msg += "No se puede repetir la misma serie";
            }
           }

           if(sim_instalado.length > 0 && sim_retirado.length > 0)
           {
            if(sim_instalado == sim_retirado)
            {
                validar++;
                msg += "No se puede repetir el mismo sim";
            }
           }

            


			if(validar == 0 ) {
				var dnd = { module: 'cerrarEvento',eventoId : eventoId, odt : odt,comentario: comentario,estatus:estatus,foliotelecarga:foliotelecarga, odtGetNet : odtGetNet, odtNotificado : odtNotificado,
							odtDescarga: odtDescarga, tvpRetBateria: tvpRetBateria, tvpRetEliminador: tvpRetEliminador, tvpRetTapa: tvpRetTapa, tvpRetCable: tvpRetCable, tvpRetBase: tvpRetBase,
							rechazo: rechazo, subrechazo: subrechazo,cancelado: cancelado,tpv:tpv,tpvRetirado : tpv_retirado,idCaja: idcaja,afiliacionAmex:afiliacion_amex ,idamex:idamex,
                            simInstalado:sim_instalado, simRetirado: sim_retirado,producto: producto,version: version,aplicativo: aplicativo,producto_ret: producto_ret,version_ret: version_ret,aplicativo_ret:aplicativo_ret,receptorservicio:receptorservicio, 
                            tvpInModelo:tvpInModelo,tpvInConnect:tpvInConnect ,tvpReModelo, tvpReModelo, tpvReConnect: tpvReConnect, simInData:simInData, simReData:simReData,tecnico:tecnico, 
                            rollosInstalar:rollosInstalar, rollosInstalados:rollosInstalados,servicioId:servicioId,fechaatencion:fecha_atencion,horallegada:hora_llegada,horasalida: hora_salida, 
                            faltaSerie:faltaSerie,faltaEvidencia:faltaEvidencia,faltaInformacion:faltaInformacion,faltaUbicacion:faltaUbicacion,causacambio: causacambio, codigo_rechazo: codigo_rechazo, codigo_rechazo_2: codigo_rechazo_2, aplica_exito: aplica_exito, aplica_rechazo: aplica_rechazo,tipo_atencion: tipoatencion,fecha_reprogramacion : fecha_reprogramacion   };
				
				 $.ajax({
					type: 'POST',
					url: 'modelos/eventos_db.php', // call your php file
					data: dnd,
					cache: false,
					success: function(data){    
							if($("#cve_banco").val() == '037') {
								Swal.fire({
									title: 'Cierre de Eventos ',
									text: "¡Cerrado Exitosamente! ¿Deseas enviar el evento al banco?",
									showDenyButton: true,
									confirmButtonText: `Enviar`,
									denyButtonText: `No`,
									icon: 'success',
								}).then((result) => {
									if (result.isConfirmed) { 
										sendInfoBanco(odt)
									} else if (result.isDenied) {
										window.location.href = "eventos.php";
									}
								})   
							} else {
									 Swal.fire({
										  title: 'Cierre de Eventos ',
										  text: 'Cerrado Existosamente',
										  confirmButtonText: `OK`,
									  }).then((result) => {
										  if (result.isConfirmed) {    
											  window.location.href = "eventos.php";
										  }  
									  
									  });
							}
	 
					},
					error: function(error){
						var demo = error;
					}
				});
			} else {
				$.toaster({
					message: msg,
					title: 'Aviso',
					priority : 'danger'
				});   
			}
        });
    
      $("#tpv").on("change",function() {
          var tpv = $(this).val();
          if(tpv.length > 0) {
              result = validarTPV(tpv,1,'in',$("#afiliacion").val())
        
          }
      })

      $("#tpv_retirado").on("change",function() {
          var tpv = $(this).val();
          if(tpv.length > 0) {
              validarTPV(tpv,1,'out',$("#afiliacion").val())
            
          }
        
      })

      $("#sim_instalado").on("change",function() {
          var tpv = $(this).val();
          if(tpv.length > 0) {
              validarTPV(tpv,2,'in',$("#afiliacion").val())
            
          }
      })

      $("#sim_retirado").on("change", function() {
          var tpv = $(this).val();
          var result;
          if(tpv.length > 0) {
              validarTPV(tpv,2,'out',$("#afiliacion").val())
            
          }
      })
      


          //Update SERIE RETIRADA INSTALADA INFO
          $("#tpvInDataModelo").on('change', function() {
            
              updateSerieData($("#tpv").val(), 'modelo',$("#tpvInDataModelo").val() );

          })

          $("#tpvInDataConnect").on('change', function() {
            
              updateSerieData($("#tpv").val(), 'conectividad',$("#tpvInDataConnect").val() );

          })

          $("#tpvReDataModelo").on('change', function() {
            
              updateSerieData($("#tpv_retirado").val(), 'modelo',$("#tpvReDataModelo").val() );

          })

          $("#tpvReDataConnect").on('change', function() {
            
              updateSerieData($("#tpv_retirado").val(), 'conectividad',$("#tpvReDataConnect").val() );

          })

          $("#tipoIncidencia").on('change',function(){
               
          })

          $("#btnGuardarIncidencia").on("click", function(){

               var tipoIncidencia = $("#tipoIncidencia").val();
               
               var odt = $("#odt").val();
               
               var incEvidencia = JSON.stringify( $("#incidenciasEvidencia").val() ) ;
               var incInventario = JSON.stringify( $("#incidenciasInventario").val() );
                  
               var coment1 = $("#descripcionE").val();
               var coment2 = $("#descripcionI").val();
                  
                  var form_data = {
                     module: 'grabarIncidencia',
                     id: id,
                     odt : $("#odt").val(),
                     tipo : tipoIncidencia,
                     comentarioCallCenter1 : coment1,
                     comentarioCallCenter2 : coment2,
                     inc1 : incEvidencia,
                     inc2 : incInventario

                  }

                  if ( $("#incidenciasEvidencia").val().length > 0 || $("#incidenciasInventario").val().length > 0 ) 
                  {
                     
                       $.ajax({
                          type: 'GET',
                         url: 'modelos/eventos_db.php',
                          data: form_data,
                          cache: false,
                          success: function(data){
                             var info = JSON.parse(data);
                             //console.log(info);

                             if (info.id == '0') 
                             {
                                 mensaje = info.msg;
                                 Swal.fire({
                                   icon: 'warning',
                                   title: 'Ya existe',
                                   text: mensaje
                                   
                                 });
                             }
                             else
                             {
                                 

                                 Swal.fire({
                                   icon: 'success',
                                   title: 'Guardado',
                                   text: 'Se generó la incidencia'
                                   
                                 })

                                 $("#modalIncidencia").modal('hide');
                             }
                             
                             
                             
                          },
                          error: function(error){
                             var demo = error;
                          }
                       });
                    
                  }else {
                      $.toaster({
                        message: 'Debes seleccionar una opción',
                        title: 'Aviso',
                        priority: 'danger'
                     });
                  }
               
               
         
          });
            $("#incidenciasEvidencia").multiselect({nonSelectedText: 'SELECCIONA UNA O VARIAS INCIDENCIAS'});
            $("#incidenciasInventario").multiselect({nonSelectedText: 'SELECCIONA UNA O VARIAS INCIDENCIAS'});

      });
   
      function camposIncidencias()
      {
         const tipo_incidencia = document.getElementById('tipoIncidencia');

         tipo_incidencia.addEventListener('change', function handleChange(event){

            if (event.target.value == 'e') 
            {

               $("#divEvidencia1").show();
               
               $("#divComentE").show();
              
               $("#divInventario1").hide();
               
            }else
            {

               $("#divInventario1").show();
               
                $("#divComentI").show();

                $("#divEvidencia1").hide();
                $("#divComentE").hide();
               
            }
         })

      }

      function updateSerieData(tpv,tipo,dato) {

          if(tpv.length > 0 && dato > 0 ) {
              $.ajax({
                  type: 'POST',
                  url: 'modelos/eventos_db.php', // call your php file
                  data: { module: 'updSerie', tpv: tpv, tipo: tipo, dato: dato },
                  dataType: "json",
                  success: function(data) {
                    
                      $.toaster({
                          message: data,
                          title: 'Aviso',
                          priority : 'success'
                      });
                  },
                  error: function(error) {
                    
                      $.toaster({
                          message: error.responseText,
                          title: 'Aviso',
                          priority : 'success'
                      });
                  }
              })
          }
      }

      function sendInfoBanco(odt) {

          $.ajax({
              type: 'POST',
              url: 'conector/postODT.php', // call your php file
              data: 'odt='+odt,
              cache: false,
              dataType: "json",
              success: function(data) {
                  var msg = 'Se envio la odt '+odt+' con Exito';

            
                
                 if(data.evento.result.status == '400') 
                 {
                      msg = " LA ODT presenta algunos campos erroneos \n"
                     $.each(data.evento.result.messages, function(index,message) {
                          msg += message;
                     })

                     Swal.fire({
                      text: msg,
                      confirmButtonText: `OK`,
                      denyButtonText: `No`,
                      }).then((result) => {
                          if (result.isConfirmed) {
                              //window.location.href = "eventos.php";
                          }
                      });
                 } else if(data.evento.result == '201') {
                    
                      Swal.fire({
                      text: msg,
                      confirmButtonText: `OK`,
                      denyButtonText: `No`,
                      }).then((result) => {
                          if (result.isConfirmed) {
                              window.location.href = "eventos.php";
                          }  
                      });

                 } else if (data.evento.result.status == 410 ) {
                        msg = " LA ODT presenta algunos campos erroneos \n"
                      $.each(data.evento.result.messages, function(index,message) {
                          msg += message+" \n ";
                     })

                      Swal.fire({
                          text: msg,
                          confirmButtonText: `OK`,
                      }).then((result) => {
                          if (result.isConfirmed) {    
                              //window.location.href = "eventos.php";  
                          }  
                      });
                 } else if (data.evento.result.status == 404 ) {
                        msg = " LA ODT presenta algunos campos erroneos \n"
                      $.each(data.evento.result.messages, function(index,message) {
                          msg += message+" \n ";
                      })

                      Swal.fire({
                          text: msg,
                          confirmButtonText: `OK`,
                      }).then((result) => {
                          if (result.isConfirmed) {    
                              //window.location.href = "eventos.php";
                          }  
                      });
                  } else {

                      Swal.fire({
                          text: data.evento.result,
                          confirmButtonText: `OK`,
                      }).then((result) => {
                          if (result.isConfirmed) {
                              //window.location.href = "eventos.php";
                          }  
                      });
                  } 

              },
              error: function(error){
                  alert(error.responseText)
              }
          })
        }

      function existeFecha(fecha){
          var fechaf = fecha.split("-");
          var day = fechaf[2];
          var month = fechaf[1];
          var year = fechaf[0];
          var date = new Date(year,month,day);
          if(isNaN(date)){
              return false ;
          } else {
              return true
          }
        
      }

      function validateHhMm(inputField) {
          var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);

          /*if (isValid) {
           return true;
          } else {
              return false;
          }*/

          return isValid; 
      }

      function initMap() {
    
      }

      function getInfoExtra(odt) {
          $.ajax({
              type: 'POST',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getInfoExtra&odt='+odt,
              cache: false,
              dataType: "json",
              success: function(data) {
                  var info =  data;

                  var odtGetNet = info.getnet == '1' ? true : false;
                  var odtNotificado = info.notificado == '1' ? true : false;
                  var odtDescarga = info.descarga == '1' ? true : false;
                  var tvpRetBateria = info.ret_batalla == '1' ? true : false;
                  var tvpRetEliminador = info.ret_eliminador == '1' ? true : false;
                  var tvpRetTapa = info.ret_tapa == '1' ? true : false;
                  var tvpRetCable = info.ret_cable == '1' ? true : false;
                  var tvpRetBase = info.ret_base == '1' ? true : false;

                  $("#odtGetNet").prop( "checked", odtGetNet );
                  $("#odtNotificado").prop( "checked", odtNotificado );
                  $("#odtDescarga").prop( "checked", odtDescarga );

                  $("#tvpRetBateria").prop( "checked", tvpRetBateria );
                  $("#tvpRetEliminador").prop( "checked", tvpRetEliminador );
                  $("#tvpRetTapa").prop( "checked", tvpRetTapa );
                  $("#tvpRetCable").prop( "checked", tvpRetCable );
                  $("#tvpRetBase").prop( "checked", tvpRetBase );


              },
              error: function(error){
                  reject(error)
              }
          })
      }

      function camposObligatorios(servicio) {

          return new Promise((resolve, reject) => {
              $.ajax({
                  type: 'GET',
                  url: 'modelos/eventos_db.php', // call your php file
                  data: 'module=getCamposObligatorios&servicioid='+servicio,
                  cache: false,
                  dataType: "json",
                  success: function(data) {
                      resolve(data)
                  },
                  error: function(error){
                      reject(error)
                  }
              })

          })
      }

      function validarTPV(tpv,tipo,donde,comercio) {
          result = 0;
            var afiliacion = $("#afiliacion").val();
            var odt = $("#odt").val();

         var permiso = donde == 'in' ? PermisosEvento.tvp_instalada : PermisosEvento.tpv_salida;

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=validarTPV&noserie='+tpv+"&tipo="+tipo+"&comercio="+comercio+"&donde="+donde+"&permiso="+permiso+"&odt="+odt+"&cve_banco="+cve_banco,
              cache: false,
              success: function(data){
                  var info = JSON.parse(data);
                  if(info.status != false ) {
                      result = 1;    
                    
                      var modelo = info.modelo == null ? 0 : info.modelo;
                      var conectividad = info.conectividad == null ? 0 : info.conectividad;
                      if(tipo == 1) {
                          if(donde == 'in') {
                              $("#tpvInDataModelo").val(modelo);
                              $("#tpvInDataConnect").val(conectividad);
                          } else {
                              $("#tpvReDataModelo").val(modelo);
                              $("#tpvReDataConnect").val(conectividad);
                          }

                      } else if (tipo == 2) {
                          if(donde == 'in') {
                              $("#simInData").val(modelo)
                          } else {
                              $("#simReData").val(modelo)
                          }
                      }

                  } else {
                      $("#tpv").val('');  
                      $.toaster({
                          message: info.msg,
                          title: 'Aviso',
                          priority : 'danger'
                                });
                        
                  }
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });

          return result;

      }

      function mostrarImagenes(odt) {
          $("#carruselFotos").html('')
          $("#btnValidarImagen").data('id','0');
        
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getImagenesODT&odt='+odt ,
              cache: false,
              success: function(data){
                  var texto = '<div class="row">';
                  var info = JSON.parse(data);
                  var locacion = window.location;
                  if(info['estatus'] == '1') {
                      $.each(info['imagenes'], function(index, element) {
                        
                          texto = texto + '<div class="col-4"><img src="'+locacion.origin+'/'+element.path+'" width="90%" class="zoomImgs"><button class="btn btn-primary button1 btnDelImage" data= "'+element.id+'">Borrar</button></div>'

                      })

                      texto = texto + "</div>";
                      $("#carruselFotos").html(texto);
                      zoomifyc.init($('#carruselFotos img'));
                  } else {
                
                      $.toaster({
                          message: 'LA ODT NO TIENE IMAGENES REGISTRADAS',
                          title: 'Aviso',
                          priority : 'danger'
                      });      
                  }
                        
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function tipodeUsuario(tipo) {

          $("#rowCancelado").hide();
          $("#rowRechazos").hide();
          $("#rowSubRechazos").hide();
          $("#btnUpdateEvento").attr('disabled',true);

          if(  $("#tipo_user").val() == 'callcenter' || $("#tipo_user").val() == 'admin' || $("#tipo_user").val() == 'callcenterADM' || $("#tipo_user").val() == 'supOp'  ) {
              $("#rollos_entregados").attr('readonly',false);
              $("#rollos_instalar").attr('readonly',false);
              $("#comentarios_cierre").attr('readonly',false);
              //$("#btnUpdateEvento").attr('disabled',false);
              $("#estatus_servicio").attr('disabled',false)
              $("#folio_telecarga").attr('readonly',false)
              $("#producto").attr('disabled',false)
              $("#version").attr('readonly',false)
              $("#aplicativo").attr('readonly',false)
              $("#producto_ret").attr('readonly',false)
              $("#version_ret").attr('readonly',false)
              $("#aplicativo_ret").attr('readonly',false)
              $("#receptor_servicio").attr('readonly',false);
              //CIERRES CALLCENTER
              $("#tecnico").attr('readonly',false);
              $("#btnReasignarTecnico").show();

              $("#odtGetNet").attr('disabled',false)
              $("#odtNotificado").attr('disabled',false)
              $("#odtDescarga").attr('disabled',false)

              $("#tvpRetBateria").attr('disabled',false)
              $("#tvpRetEliminador").attr('disabled',false)
              $("#tvpRetTapa").attr('disabled',false)
              $("#tvpRetCable").attr('disabled',false)
              $("#tvpRetBase").attr('disabled',false)
            
              $("#tpv").attr('readonly',false)
              $("#tpv_retirado").attr('readonly',false)
              $("#idcaja").attr('readonly',false)
              $("#afiliacion_amex").attr('readonly',false)
              $("#idamex").attr('readonly',false)
              $("#sim_instalado").attr('readonly',false)
              $("#sim_retirado").attr('readonly',false)  
            
               //HORAS
              $("#fecha_atencion").attr('readonly',false);
              $("#hora_llegada").attr('readonly',false);
              $("#hora_salida").attr('readonly',false);
        
        
          } else {
              $("#rollos_entregados").attr('readonly',true);
              $("#comentarios_cierre").attr('readonly',true);
              $("#btnUpdateEvento").attr('disabled',true);
              $("#estatus_servicio").attr('disabled',true)
              $("#folio_telecarga").attr('readonly',true)
              $("#producto").attr('disabled',true)
              $("#version").attr('readonly',true)
              $("#aplicativo").attr('readonly',true)
              $("#producto_ret").attr('readonly',true);
              $("#version_ret").attr('readonly',true)
              $("#aplicativo_ret").attr('readonly',true)
              $("#receptor_servicio").attr('readonly',true);

              $("#odtGetNet").attr('disabled',true)
              $("#odtNotificado").attr('disabled',true)
              $("#odtDescarga").attr('disabled',true)

              $("#tvpRetBateria").attr('disabled',true)
              $("#tvpRetEliminador").attr('disabled',true)
              $("#tvpRetTapa").attr('disabled',true)
              $("#tvpRetCable").attr('disabled',true)
              $("#tvpRetBase").attr('disabled',true)
            
              $("#tpv").attr('readonly',true)
              $("#tpv_retirado").attr('readonly',true)
              $("#idcaja").attr('readonly',true)
              $("#afiliacion_amex").attr('readonly',true)
              $("#idamex").attr('readonly',true)
              $("#sim_instalado").attr('readonly',true)
              $("#sim_retirado").attr('readonly',true)
        
          }
      }

      function getScriptEvento(servicio,noserie,conectividad,modelo) {
          var result = '';
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=scriptEvento&servicio_id='+servicio+'&noserie='+noserie+'&conectividad='+conectividad+'&modelo='+modelo,
              cache: false,
              success: function(data){    
                  var info = JSON.parse(data);
                
                  var script = info.script;
                  script = script.replace("#MODELO#",$("#tpvInDataModelo option:selected" ).text() ) 
                  script = script.replace("#AFILIACION#",$("#afiliacion").val() )
                  script = script.replace("#MODELORETIRO#",$("#tpvReDataModelo option:selected" ).text() )
                  script = script.replace("#CONECTIVIDAD#",$("#tpvInDataConnect option:selected" ).text() ) 
                  script = script.replace("#CONECTIVIDADRETIRO#",$("#tpvReDataConnect option:selected" ).text() ) 
                  script = script.replace("#SERIE#",$("#tpv").val() ) 
                  script = script.replace("#SERIERETIRO#",$("#tpv_retirado").val() ) 
                  script = script.replace("#PTID#",$("#tpv").val() ) 
                  script = script.replace("#SIM#",$("#sim_instalado" ).val() )
                  script = script.replace("#SIMRETIRO#",$("#sim_retirado" ).val() )
                  script = script.replace("#CARRIER#",$("#simInData option:selected" ).text())
                  script = script.replace("#CARRIERRETIRO#",$("#simReData option:selected" ).text()) 
                  //data.replace("#CARRIER",$("#tpv").val() ) 
                  script = script.replace("#CAJA#",$("#idcaja").val() ) 
                  script = script.replace("#FT#",$("#folio_telecarga").val() ) 
                  script = script.replace("#AMEX#",$("#tieneamex").val() )
				  script = script.replace("#TECNICO#",$("#tecnico").val() )
				  script = script.replace("#COMERCIO#",$("#comercio").val() )
                  if($("#tieneamex").val() == 'SI') {
                      script = script.replace("#AFAMEX#",$("#afiliacion_amex").val() )
                      script = script.replace("#AMEXID#",$("#idamex").val() )
                  } else {
                      script = script.replace("#AFAMEX#",'' )
                      script = script.replace("#AMEXID#",'' )
                  }
                  script = script.replace("#ROLLOS#",$("#rollos_entregados").val() )
                
                  script = script.replace("#FECHAHORA",$("#fecha_atencion").val()+" DE "+$("#hora_llegada").val()+" A "+$("#hora_salida").val() )
                  script = script.replace("#APP#",$("#aplicativo option:selected" ).text() ) 
                  script = script.replace("#VERSION#",$("#version option:selected" ).text() ) 
                  script = script.replace("#RECEPTORSERVICIO#",$("#receptor_servicio").val() )
                  script = script.replace("#TELEFONO#", $("#telefono").val() )

                  $("#comentarios_cierre").val(script);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function cleartext() {
          $("#odt").val("")
          $("#afiliacion").val("")
          $("#tipo_servicio").val("");
          $("#tipo_subservicio").val("");
          $("#fecha_alta").val("");
          $("#fecha_vencimiento").val("")
          $("#fecha_cierre").val("");
          $("#comercio").val("")
          $("#receptor_servicio").val("");
          $("#fecha_atencion").val("");
          $("#colonia").val("")
          $("#ciudad").val("")
          $("#estado").val("")
          $("#direccion").val("")
          $("#telefono").val("")
          $("#descripcion").val("");
          $("#hora_atencion").val("")
          $("#hora_llegada").val("")
          $("#hora_salida").val("")
          $("#tecnico").val("")
          $("#estatus").val("")
          $("#servicio").val("")
          $("#comentarios_tecnico").val("")
          $("#servicio_final").val("")
          $("#comentarios_cierre").val("")
          $("#fecha_asignacion").val("");
          $("#hora_comida").val("");
          $("#latitud").val("" );
          $("#longitud").val("");

          $("#tipo_credito").val("");
          $("#afiliacion_amex").val("");
          $("#idamex").val("");
          $("#idcaja").val("");
          $("#tpv").val("");
          $("#tpv_retirado").val(""); 
          $("#version").val("");
          $("#aplicativo").val("");
          $("#producto").val("");
          $("#version_ret").val("");
          $("#aplicativo_ret").val("");
          $("#producto_ret").val("");
          $("#rollos_instalar").val("");
          $("#rollos_entregados").val("");
          $("#sim_instalado").val("");
          $("#sim_retirado").val("");
          $("#estatus_servicio").val("");
          $("#folio_telecarga").val("");

      }

      function getTecnicos(id) {
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getTecnicos',
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#reasignartecnico").html(data);
              $("#reasignartecnico").val(id);		
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getEstatusServicio(cve_banco) {
		
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getEstatusServicio&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#estatus_servicio").html(data);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getCancelado() {
        
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getEstatusCancelado',
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#cancelado").html(data);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
        
      }

      function getRechazos(cve_banco) {
        
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getEstatusRechazo&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#rechazo").html(data);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
        
      }

      function getSubRechazos(cve_banco) {
        
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getEstatusSubRechazo&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#subrechazo").html(data);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
        
      }

      function getProductos(cve_banco) {
        
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getProductos&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
                  $("#producto").html(data);
                  $("#producto_ret").html(data);
                
              },
              error: function(error){
                  var demo = error;
              }
          });
        
      }

      function subirFotos(odt,file) {
          //var odt = $("#odt").val();
          var file_data = file; //$("#fileToUpload")[0].files[0];
          var form_data = new FormData();
          form_data.append('file', file_data);
          form_data.append('name',odt);
          form_data.append('module','saveDoc');

          $.ajax({
              type: 'POST',
              url: 'modelos/eventos_db.php', // call your php file
              data: form_data,
              processData: false,
              contentType: false,
              success: function(data, textStatus, jqXHR){
                  //$("#avisos").html(data);
                  $.toaster({
                      message: data,
                      title: 'Aviso',
                      priority : 'warning'
                  });  
                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(data)
          }
          });
      }

      function getTipoServicio() {
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=gettiposervicio',
              cache: false,
              success: function(data){
              $("#tipo_servicio").html(data);            
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getTipoSubServicio() {
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=gettiposubservicio',
              cache: false,
              success: function(data){
              $("#tipo_subservicio").html(data);            
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getTipoEvento() {
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=gettipoevento',
              cache: false,
              success: function(data){
              $("#tipo_evento").html(data);            
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getEstatusEvento() {
          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getestatusevento',
              cache: false,
              success: function(data){
              $("#estatus_busqueda").html(data);            
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getVersion(cve_banco) {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getVersion&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
                  $("#version").html(data);
                  $("#version_ret").html(data);
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getAplicativo(cve_banco) {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getAplicativo&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
                  $("#aplicativo").html(data);
                  $("#aplicativo_ret").html(data);
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getModelos(cve_banco) {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getListaModelos&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#tpvInDataModelo").html(data);
              $("#tpvReDataModelo").html(data);
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getConectividad(cve_banco) {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getListaConectividad&cve_banco='+cve_banco,
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#tpvInDataConnect").html(data);
              $("#tpvReDataConnect").html(data);
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getCarrier() {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getListaCarrier',
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#simInData").html(data);
              $("#simReData").html(data);
            
                
              },
              error: function(error){
                  var demo = error;
              }
          });
      }

      function getCausasCambios() {

          $.ajax({
              type: 'GET',
              url: 'modelos/eventos_db.php', // call your php file
              data: 'module=getCausasCambio',
              cache: true,
              success: function(data){
                  console.log(data);
            
              $("#causas_cambio").html(data);

              },
              error: function(error){
                  var demo = error;
              }
          });

      }

      function existeIncidencia(odt,tipo)
        {   
            

            $.ajax({
               type: 'POST',
               url: 'modelos/eventos_db.php',
               data: 'module=existeIncidencia&odt='+odt+'&tipo='+tipo,
               cache: false,
               success: function(data)
               {
                  var existe = JSON.parse(data).length;

                  if (existe == 0) 
                  {
                     console.log(existe);
                  }
                  else
                  {
                                       
                  }
               },
               error: function(error)
               {
                  var demo = error;
               }
            })
            
        }
   </script>
</body>
</html>