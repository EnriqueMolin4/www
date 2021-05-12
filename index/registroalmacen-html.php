<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    
    <h3>Registro para Almacen</h3>
    <div style="border-style: solid; padding: 10px;">
        <div class="row">
            <div id="avisos" class="display:none;" style="background-color:red;"></div>
        </div>
        <div class="row">
            <div class="col">           
                <label for="cve_banco" class="col-form-label-sm">Cve Banco</label>
                <select id="cve_banco" name="cve_banco" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col">           
                <label for="almacen_producto" class="col-form-label-sm">Producto</label>
                <select id="almacen_producto" name="almacen_producto" class="form-control form-control-sm">
                    <option value="0">Seleccionar</option>
                    <option value="1">TPV</option>
                    <option value="2">SIM</option>
                    <option value="3">Insumo</option>
                </select>
            </div>
            
        </div>
 
    </div>
    <br/>
    <div style="border-style: solid; padding: 10px; display:none;" id="altatpv">
        <div class="row">
            <div class="col" id="tpvbk">           
                <label for="select-modelo_tpv" class="col-form-label-sm">Modelos TPV </label>
                <select class="form-control form-control-sm" id= "select-modelo_tpv" name="select-modelo_tpv"></select>
            </div>
            <div class="col" id="carrierbk">           
                <label for="select-carrier" class="col-form-label-sm">Carrier </label>
                <select class="form-control form-control-sm" id= "select-carrier" name="select-carrier"></select>
            </div>
            <div class="col" id="insumobk">           
                <label for="select-insumo" class="col-form-label-sm">Insumo </label>
                <select class="form-control form-control-sm" id= "select-insumo" name="select-insumo"></select>
            </div>
            <div class="col" id="noseriebk">           
                <label for="almacen-no_serie" class="col-form-label-sm">No. de Serie</label>
                <input type="text" class="form-control form-control-sm" id="almacen-no_serie" aria-describedby="almacen-no_serie">
            </div>
            <div class="col" id="cantidadbk">           
                <label for="almacen-cantidad" class="col-form-label-sm">Cantidad</label>
                <input type="text" class="form-control form-control-sm" id="almacen-cantidad" aria-describedby="almacen-cantidad">
            </div>
            <div class="col">           
                <label for="almacen-fabricante" class="col-form-label-sm">Fabricante</label>
                <select class="form-control form-control-sm" id="almacen-fabricante" name="almacen-fabricante" readonly>
                </select>
            </div>
            <div class="col">           
                <label for="almacen-connect" class="col-form-label-sm">Conectividad</label>
                <select class="form-control form-control-sm" id="almacen-connect" name="almacen-connect" readonly>
                </select>
            </div>
            <div class="col">           
                <label for="almacen-ptid" class="col-form-label-sm">PTID</label>
                <input type="text" class="form-control form-control-sm" id="almacen-ptid" aria-describedby="almacen-ptid">
            </div>
        </div>
    </div>
    <div style="border-style: solid; padding: 10px; display:none;" id="altaalmacen">
        <div class="row">
            <div class="col">           
                <label for="select-estatus" class="col-form-label-sm">Estatus </label>
                <select class="form-control form-control-sm" id= "select-estatus" name="select-estatus">
                    <option value="0">Seleccionar</option>
                    <option value="1">Nuevo</option>
                    <option value="2">Dañado</option>
                    <option value="2">Activo</option>

                </select>
            </div>
            <div class="col">           
                <label for="almacen-tarima" class="col-form-label-sm">Tarima</label>
                <input type="text" class="form-control form-control-sm" id="almacen-tarima" aria-describedby="almacen-tarima">
            </div>
            <div class="col">           
                <label for="almacen-anaquel" class="col-form-label-sm">Anaquel</label>
                <input type="text" class="form-control form-control-sm" id="almacen-anaquel" aria-describedby="almacen-anaquel">
            </div>
            <div class="col">           
                <label for="almacen-cajon" class="col-form-label-sm">Cajon</label>
                <input type="text" class="form-control form-control-sm" id="almacen-cajon" aria-describedby="almacen-cajon">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" style="padding-left:30px;padding-top:10px;">  
            <button class="btn btn-primary" id="btnAsignar">Grabar</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/almacen.js"></script> 

