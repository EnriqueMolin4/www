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
            <div class="col-md-3">           
                <label for="email" class="col-form-label-sm">Email</label>
                <input type="text" class="form-control form-control-sm" id="email" aria-describedby="email" >
            </div>
            <div class="col">           
                <label for="responsable" class="col-form-label-sm">Responsable</label>
                <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" >
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
</div>
