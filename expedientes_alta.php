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
                <label for="cve_banco" class="col-form-label-sm">CVE BANCARIA</label>
                <select id="cve_banco" name="cve_banco" class="form-control form-control-sm" ></select>
            </div>
            <div class="col">           
                <label for="afiliacion" class="col-form-label-sm">FOLIO</label>
                <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" >
            </div>
            <div class="col">           
                <label for="tipo_credito" class="col-form-label-sm">TIPO CREDITO</label>
                <select id="tipo_credito" name="tipo_credito" class="form-control form-control-sm" ></select>
            </div>    
        </div>
        <div class="row">
            <div class="col">           
                <label for="comercio" class="col-form-label-sm">CLIENTE</label>
                <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="direccion" class="col-form-label-sm">DIRECCION</label>
                <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" >
            </div>
            <div class="col">           
                <label for="colonia" class="col-form-label-sm">COLONIA</label>
                <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="estado" class="col-form-label-sm">ESTADO</label>
                <select id="estado" name="estado" class="form-control form-control-sm" ></select>
            </div>
            <div class="col">           
                <label for="municipio" class="col-form-label-sm">MUNICIPIO</label>
                <select id="municipio" name="municipio" class="form-control form-control-sm" ></select>
            </div>
            <div class="col">           
                <label for="tipo_servicio" class="col-form-label-sm">TIPO DE SERVICIO</label>
                <select id="tipo_servicio" name="tipo_servicio" class="form-control form-control-sm">
                    
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">           
                <label for="telefono" class="col-form-label-sm">TELEFONO</label>
                <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" >
            </div>
            <div class="col-md-3">           
                <label for="email" class="col-form-label-sm">EMAIL</label>
                <input type="text" class="form-control form-control-sm" id="email" aria-describedby="email" >
            </div>
            <div class="col">           
                <label for="responsable" class="col-form-label-sm">RESPONSABE</label>
                <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="ticket" class="col-form-label-sm">TICKET</label>
                <input type="text" class="form-control form-control-sm" id="ticket" aria-describedby="ticket" readonly>
            </div>
            <div class="col" style="display: none;">           
                <label for="hora_atencion" class="col-form-label-sm">HORA DE ATENCION</label>
                <input type="text" class="form-control form-control-sm" id="hora_atencion-in" name="hora_atencion-in" aria-describedby="hora_atencion" >
                <span>A</span>
                <input type="text" class="form-control form-control-sm" id="hora_atencion-fin" name="hora_atencion-fin" aria-describedby="hora_atencion" >
            </div>
            <div class="col" style="display: none;">           
                <label for="hora_comida" class="col-form-label-sm">HORA DE COMIDA</label>
                <input type="text" class="form-control form-control-sm" id="hora_comida" name="hora_comida" aria-describedby="hora_comida" >
                <span>A</span>
                <input type="text" class="form-control form-control-sm" id="hora_comida_fin" name="hora_comida_fin" aria-describedby="hora_comida_fin" >
            </div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="comentarios" class="col-form-label-sm">COMENTARIOS</label>
                <textarea  class="form-control form-control-sm" rows="5" id="comentarios" aria-describedby="comentarios"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col"> 
            <label for="documentos" class="col-form-label-sm">DOCUMENTACION: </label>
            <input type="file" name="documentos" id="documentos" multiple><br /><small>(para seleccionar multiples archivos usar la tecla ctrl)</small>
            </div>
        </div>

    </div>
</div>
