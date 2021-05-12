<h3>Validaciones</h3>
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
    </div>
    <br />
    <table id="validaciones"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>Ticket</th>
                <th>Tipo de Servicio</th>
                <th>Fecha Vencimiento</th>
                <th>Terminal</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>Ticket</th>
                <th>Tipo de Servicio</th>
                <th>Fecha Vencimiento</th>
                <th>Terminal</th>
                <th>Accion</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Validacion Evento</h5>
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
            </div>
            <div class="col">           
            <label for="descripcion" class="col-form-label-sm">Descripción</label>
                <textarea  class="form-control form-control-sm" rows="3" id="descripcion" aria-describedby="descripcion" readonly></textarea>
            </div>
            <div class="col">         
                <label for="toque" class="col-form-label-sm">Intentos de llamada </label>
                <input type="text" class="form-control form-control-sm col-sm-4" id="toque" aria-describedby="toque" readonly>
            </div>
            
        </div>
		<br />
        <div class="row">
            <div class="col">           
                <label for="estatus" class="col-form-label-sm">Estatus </label>
                <select id="cmbestatus" name="cmbestatus" class="form-control form-control-sm">
                    
                </select>
            </div>
            <div class="col">           
                <label for="fecha_llamada" class="col-form-label-sm">Fecha de Llamada </label>
                <input type="text" class="form-control form-control-sm" id="txtfecha_llamada" aria-describedby="txtfecha_llamada">
            </div>
            <div class="col">           
                <label for="hora_llamada" class="col-form-label-sm">Hora de Llamada </label>
                <input type="text" class="form-control form-control-sm" id="txthora_llamada" aria-describedby="txthora_llamada">
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="comentarios_validacion" class="col-form-label-sm">Comentarios de Validación</label>
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
            <div class="row">
                <div class="col-md-5">
                    <button class="btn btn-success" id="btnRotarImagen">Rotar 90</button>
                    <button class="btn btn-success" id="btnValidarImagen" data-id="0">Validar Imagenes</button>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div> 
    </div>
  </div>
</div>
<script src="js/jquery.rotate.1-1.js"></script>
<script src="js/validaciones.js"></script>
