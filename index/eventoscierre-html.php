<h3>Cierre de Evento</h3>
<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    <div style="border-style: solid; padding: 10px;">
        <div class="row">
            <div id="avisos" class="display:none;" style="background-color:red;"></div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="odt" class="col-form-label-sm">Ordenes de Trabajo</label>
                <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt">
            </div>
            <div class="col">           
                <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
            </div>
            <div class="col">           
                <label for="tecnico" class="col-form-label-sm">Nombre de Tecnico</label>
                <input type="text" class="form-control form-control-sm" id="tecnico" aria-describedby="tecnico" readonly>
            </div>
            
        </div>
        <div class="row">
            <div class="col">           
                <label for="fecha_atencion" class="col-form-label-sm">Fecha Atencion</label>
                <input type="text" class="form-control form-control-sm" id="fecha_atencion" aria-describedby="fecha_atencion">
            </div>
            <div class="col">           
                <label for="hora_llegada" class="col-form-label-sm">Hora de Llegada</label>
                <input type="text" class="form-control form-control-sm" id="hora_llegada" aria-describedby="hora_llegada">
            </div>
            <div class="col">           
                <label for="hora_salida" class="col-form-label-sm">Hora de Salida</label>
                <input type="text" class="form-control form-control-sm" id="hora_salida" aria-describedby="hora_salida">
            </div>
            <div class="col">           
                <label for="estatus" class="col-form-label-sm">Estatus</label>
                <select id="estatus" name="estatus" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                    <option value="1">Exito</option>
                    <option value="2">Cancelado</option>
                    <option value="3">Rechazo</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col" style="padding-left:30px;padding-top:30px;">  
                <button class="btn btn-primary" id="btnConsultar">Consultar</button>
            </div>
        </div>

    </div>
<br/>
<div style="border-style: solid; padding: 10px; display: none;" id="divFueraTiempo">
        <div class="row">
            <div class="col form-inline">           
                <label for="cierre_evento-causa_fuera_tiempo" class="col-form-label-sm">Causa Fuera de Tiempo:</label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-causa_fuera_tiempo" aria-describedby="cierre_evento-causa_fuera_tiempo">
            </div>
        </div>
    </div>
    <br/>
    <div style="border-style: solid; padding: 10px; display:none;" id="serviciorealizado">
        <div class="form-group row">
            <div class="col-sm-6 form-inline">           
                <label for="select-servicio-realizado" class="col-sm-2 col-form-label">Servicio Realizado </label>
                <select class="form-control form-control-sm" id= "select-servicio-realizado" name="select-servicio-realizado"></select>
            </div>
            <div class="col-sm-6 form-inline">           
                <label for="servicio" class="col-sm-2 col-form-label">Servicio Solicitado </label>
                <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 form-inline">           
                <label for="servicio-sn" class="col-sm-2 col-form-label">S/N </label>
                <select class="form-control form-control-sm" id="servicio-sn" name="servicio-sn">
                </select>
            </div>
            <div class="col-sm-6 form-inline">           
                <label for="servicio-modelo" class="col-sm-2 col-form-label">Modelo </label>
                <select class="form-control form-control-sm" id="servicio-modelo" name="servicio-modelo">
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 form-inline">           
                <label for="servicio-ptid" class="col-sm-2 col-form-label">PTID </label>
                <input type="text" class="form-control form-control-sm" id="servicio-ptid" aria-describedby="servicio-ptid">
            </div>
            <div class="col-sm-6 form-inline">           
                <label for="servicio-producto" class="col-sm-2 col-form-label">Producto </label>
                <input type="text" class="form-control form-control-sm" id="servicio-producto" aria-describedby="servicio-producto">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 form-inline">   
                <label for="servicio-aplicativo" class="col-sm-2 col-form-label">Aplicativo </label>         
                <input type="text" class="form-control form-control-sm" id="servicio-aplicativo" aria-describedby="servicio-aplicativo">
            </div>
            <div class="col-sm-6 form-inline">           
                <label for="servicio-version" class="col-sm-2 col-form-label">Version </label>
                <input type="text" class="form-control form-control-sm" id="servicio-version" aria-describedby="servicio-version">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 form-inline">           
                <label for="servicio-sim" class="col-sm-2 col-form-label">SIM </label>
                <input type="text" class="form-control form-control-sm" id="servicio-sim" aria-describedby="servicio-sim">
            </div>
        </div>
    </div>
    
    <div style="border-style: solid; padding: 10px; display:none;" id="serviciocancelado">
        <div class="row">
            <div class="col">           
                <label for="cierre_evento-motivo_cancelacion" class="col-form-label-sm">Motivo Cancelación </label>
                <select class="form-control form-control-sm" id= "cierre_evento-motivo_cancelacion" name="cierre_evento-motivo_cancelacion">
                   
                </select>
            </div>
            <div class="col">           
                <label for="cierre_evento-cve_autorizacion" class="col-form-label-sm">Clave Autorización</label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-cve_autorizacion" aria-describedby="cierre_evento-cve_autorizacion">
            </div>
            <div class="col">           
                <label for="cierre_evento-autorizo" class="col-form-label-sm">Quien Autorizo</label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-autorizo" aria-describedby="cierre_evento-autorizo">
            </div>
        </div>
    </div>
    <div style="border-style: solid; padding: 10px;display:none; " id="serviciorechazado">
        <div class="row">
            <div class="col-md-6">           
                <label for="cierre_evento-motivo_rechazo" class="col-form-label-sm">Rechazo Inputable por </label>
                <select class="form-control form-control-sm" id= "cierre_evento-motivo_rechazo" name="cierre_evento-motivo_rechazo"> 
                </select>
            </div>
            <div class="col-md-6">  
                <label for="cierre_evento-motivo_subrechazo" class="col-form-label-sm">Motivo de SubRechazo </label>
                <select class="form-control form-control-sm" id= "cierre_evento-motivo_subrechazo" name="cierre_evento-motivo_subrechazo">
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col">           
                <label for="cierre_evento-cve_autorizacion" class="col-form-label-sm">Clave Autorización</label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-cve_autorizacion" aria-describedby="cierre_evento-cve_autorizacion">
            </div>
            <div class="col">           
                <label for="cierre_evento-autorizo" class="col-form-label-sm">Quien Autorizo</label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-autorizo" aria-describedby="cierre_evento-autorizo">
            </div>
        </div>
    </div>
    <br/>
    
    <div style="border-style: solid; padding: 10px;">
        <div class="row">
            <div class="col form-inline">           
                <label for="cierre_evento-persona_servico" class="col-form-label-sm">Persona que recibe el Servicio </label>
                <input type="text" class="form-control form-control-sm" id="cierre_evento-persona_servico" aria-describedby="cierre_evento-persona_servico">
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="cierre_evento-comentarios" class="col-form-label-sm">Comentarios Adicionales</label>
                <textarea  class="form-control form-control-sm" rows="3" id="cierre_evento-comentarios" aria-describedby="cierre_evento-comentarios"></textarea>
            </div>
        </div>
        <div class="col" style="padding-left:10px;padding-top:10px;">  
            <input type="hidden" id="odtId" value="0">
            <button class="btn btn-primary" id="btnRegistrar">Registrar</button>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/eventoscierre.js"></script> 