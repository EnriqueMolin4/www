<h3>Assignación de Ruta</h3>
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
    <table id="assignaciones"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>Comercio</th>
                <th>Estatus</th>
                <th>Tipo Comercio</th>
                <th>Fecha Vencimiento</th>
                <th>Tecnico</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>ODT</th>
                <th>Afiliacion</th>
                <th>Comercio</th>
                <th>Estatus</th>
                <th>Tipo Comercio</th>
                <th>Fecha Vencimiento</th>
                <th>Tecnico</th>
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
        <h5 class="modal-title">Assignación de Ruta</h5>
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
                <label for="contacto" class="col-form-label-sm">Contacto</label>
                <input type="text" class="form-control form-control-sm" id="contacto" aria-describedby="contacto" readonly>
            </div>
            <div class="col">           
                <label for="hora_general" class="col-form-label-sm">Horario General</label>
                <input type="text" class="form-control form-control-sm" id="hora_general" aria-describedby="hora_general" readonly>
            </div>
            <div class="col">           
                <label for="hora_comida" class="col-form-label-sm">Horario Comida</label>
                <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" readonly>
            </div>
        
        </div>
        <div class="row">
            <div class="col">           
                <label for="telefono" class="col-form-label-sm">Telefono</label>
                <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
            </div>
            <div class="col">           
                <label for="direccion" class="col-form-label-sm">Direccion</label>
                <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="fecha_alta" class="col-form-label-sm">Fecha de Alta</label>
                <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
            </div>
            <div class="col">           
                <label for="fecha_cierre" class="col-form-label-sm">Fecha Vencimiento</label>
                <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="direccion" readonly>
            </div>
            <div class="col">           
                <label for="servicio" class="col-form-label-sm">Servicio</label>
                <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
            </div>
            <div class="col">           
                <label for="tipo_falla" class="col-form-label-sm">Tipo de Falla</label>
                <input type="text" class="form-control form-control-sm" id="tipo_falla" aria-describedby="tipo_falla" readonly>
            </div>
            <div class="col">           
                <label for="terminal" class="col-form-label-sm">Terminal Instalada</label>
                <input type="text" class="form-control form-control-sm" id="terminal" aria-describedby="terminal" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col">           
            <label for="descripcion" class="col-form-label-sm">Descripción</label>
                <textarea  class="form-control form-control-sm" rows="3" id="descripcion" aria-describedby="descripcion" readonly></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col">           
            <label for="fecha_assignacion" class="col-form-label-sm">Fecha Asignacion</label>
            <input type="text" class="form-control form-control-sm" id="fecha_assignacion" aria-describedby="fecha_assignacion">
            </div>
            <div class="col">           
            <label for="tecnico" class="col-form-label-sm">Tecnico</label>
            <select class="form-control form-control-sm" name="tecnico" id="tecnico" aria-describedby="tecnico">
            </select>
            </div>
            <div class="col">           
            <label for="fecha_viatico" class="col-form-label-sm">Fecha Viatico</label>
            <input type="text" class="form-control form-control-sm" id="fecha_viatico" aria-describedby="fecha_viatico">
            </div>
            <div class="col">           
            <label for="importe_viatico" class="col-form-label-sm">Importe de Viatico</label>
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
            <label for="comentarios_asig" class="col-form-label-sm">Comentario</label>
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



<script type="text/javascript" src="js/assignacionruta.js"></script> 
