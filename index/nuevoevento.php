<h3>Nuevo Evento</h3>
<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    
    <div id="container" class="container">
           <label>Carga Masiva Eventos 
         
                <input class="input-file" type="file" id="excelMasivo" name="excelMasivo">
            </label>
            <div class="row">
                <div class="col-md-10">           
                    <label for="buscarComercio" class="col-form-label-sm">Buscar Comercio</label>
                    <input type="text" class="form-control form-control-sm col-md-7" id="buscarComercio" placeholder="Buscar por Clave Banco, Afiliacion, Nombre Comercio" aria-describedby="buscarComercio">
                </div>
            </div>
            <br>
            <div style="border-style: solid; padding: 10px;">
                <div class="row">
                    <div id="avisos" class="display:none;" style="background-color:red;"></div>
                </div>
                <div class="row">
                    <div class="col">           
                        <label for="cve_banco" class="col-form-label-sm">Cve Bancaria</label>
                        <input type="text" class="form-control form-control-sm" id="cve_banco" aria-describedby="cve_banco" readonly>
                    </div>
                    <div class="col">           
                        <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                        <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                    </div>
                    <div class="col">           
                        <label for="comercio" class="col-form-label-sm">Comercio</label>
                        <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" readonly>
                    </div>
                    <div class="col">           
                        <label for="direccion" class="col-form-label-sm">Dirección</label>
                        <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                    </div>
                    <div class="col">           
                        <label for="estado" class="col-form-label-sm">Estado</label>
                        <select id="estado" name="estado" class="form-control form-control-sm" readonly></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">           
                        <label for="colonia" class="col-form-label-sm">Colonia</label>
                        <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                    </div>
                    <div class="col">           
                        <label for="tipo_servicio" class="col-form-label-sm">Tipo de Servicio</label>
                        <select id="tipo_servicio" name="tipo_servicio" class="form-control form-control-sm">
                            
                        </select>
                    </div>
                    <div class="col">           
                        <label for="tipo_falla" class="col-form-label-sm">Tipo de Falla</label>
                        <select id="tipo_falla" name="tipo_falla" class="form-control form-control-sm">
                            
                        </select>
                    </div>
                    <div class="col">           
                        <label for="equipo_instalado" class="col-form-label-sm">Equipo Instalado</label>
                        <select id="equipo_instalado" name="equipo_instalado" class="form-control form-control-sm">
                            
                        </select>
                    </div>
                    <div class="col">           
                        <label for="municipio" class="col-form-label-sm">Municipio</label>
                        <select id="municipio" name="municipio" class="form-control form-control-sm" readonly></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">           
                        <label for="telefono" class="col-form-label-sm">Telefono</label>
                        <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                    </div>
                    <div class="col-md-3">           
                        <label for="email" class="col-form-label-sm">Email</label>
                        <input type="text" class="form-control form-control-sm" id="email" aria-describedby="email" readonly>
                    </div>
                    <div class="col">           
                        <label for="responsable" class="col-form-label-sm">Responsable</label>
                        <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col">           
                        <label for="ticket" class="col-form-label-sm">Ticket</label>
                        <input type="text" class="form-control form-control-sm" id="ticket" aria-describedby="ticket" readonly>
                    </div>
                    <div class="col">           
                        <label for="hora_atencion" class="col-form-label-sm">Hora de Atención</label>
                        <input type="text" class="form-control form-control-sm" id="hora_atencion-in" name="hora_atencion-in" aria-describedby="hora_atencion" >
                        <span>A</span>
                        <input type="text" class="form-control form-control-sm" id="hora_atencion-fin" name="hora_atencion-fin" aria-describedby="hora_atencion" >
                    </div>
                    <div class="col">           
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

            </div>
            <div class="row">
                <div class="col" style="padding-left:30px;padding-top:10px;">  
                    <button class="btn btn-primary" id="btnAsignar">Grabar</button>
                </div>
            </div>
        </div>

        <!-- MODAL Avisos -->
        <div class="modal fade" tabindex="-1" role="dialog" id="showAvisos">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Creación Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="numODT"></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="odtFechaLimite">
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div> 
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/nuevoevento.js"></script> 

    
   