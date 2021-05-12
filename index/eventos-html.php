<h3>Consulta de Eventos</h3>
<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
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
    <br />
    <table id="eventos"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>CVE</th>
                <th>Comercio</th>
                <th>Servicio</th>
                <th>Fecha de Alta</th>
                <th>Fecha Vencimiento</th>
                <th>Estatus</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>CVE</th>
                <th>Comercio</th>
                <th>Servicio</th>
                <th>Fecha de Alta</th>
                <th>Fecha Vencimiento</th>
                <th>Estatus</th>
                <th>Accion</th>
            </tr>
        </tfoot>
    </table>
    <div class="row">
        <div class="col" style="padding-left:30px;padding-top:30px;">  
            <button class="btn btn-primary" id="btnNuevoEvento">Nuevo Evento</button>
        </div>
    </div>   
</div>

<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
  <div class="modal-dialog modal-lg" role="document">
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
                <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
            </div>
            <div class="col">           
                <label for="tipo_servicio" class="col-form-label-sm">Tipo Servicio</label>
                <input type="text" class="form-control form-control-sm" id="tipo_servicio" aria-describedby="tipo_servicio" readonly>
            </div>
            <div class="col">           
                <label for="fecha_alta" class="col-form-label-sm">Fecha Alta</label>
                <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
            </div>
        
        </div>
        <div class="row">
            <div class="col">           
                <label for="fecha_cierre" class="col-form-label-sm">Fecha Vencimiento</label>
                <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="fecha_cierre" readonly>
            </div>
            <div class="col">           
                <label for="comercio" class="col-form-label-sm">Comercio</label>
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
                        <button class="btn btn-primary" id="btnDocumentos">Documentos</button>
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
                <input type="text" class="form-control form-control-sm" id="fecha_atencion" aria-describedby="fecha_atencion" readonly>
            </div>
            <div class="col">           
                <label for="hora_llegada" class="col-form-label-sm">Hora de LLegada</label>
                <input type="text" class="form-control form-control-sm" id="hora_llegada" aria-describedby="hora_llegada" readonly>
            </div>
            <div class="col">           
                <label for="hora_salida" class="col-form-label-sm">Hora de Salida</label>
                <input type="text" class="form-control form-control-sm" id="hora_salida" aria-describedby="hora_salida" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="tecnico" class="col-form-label-sm">Tecnico</label>
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
            <div class="col">           
                <label for="servicio_final" class="col-form-label-sm">Servicio Final</label>
                <input type="text" class="form-control form-control-sm" id="servicio_final" aria-describedby="servicio_final" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="comentarios_cierre" class="col-form-label-sm">Comentarios de Cierre</label>
                <textarea  class="form-control form-control-sm" rows="5" id="comentarios_cierre" aria-describedby="comentarios_cierre" readonly></textarea>
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
      </div>
      <div class="modal-footer">
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
        <h5 class="modal-title">Imagenes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-9 anyClass" id="imagenSel"></div>
                <div class="col-md-3 anyClass" id="carruselFotos"></div>
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

<script type="text/javascript" src="js/eventos.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDv9c8bFp7dT21O32pZYEhoeHoBamwxLwU&callback=initMap" async defer></script>
