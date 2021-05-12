<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    <table id="modelos"  class="table table-md table-bordered ">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Proveedor</th>
                <th>Conectividad</th>
                <th>No largo</th>
                <th>Estatus</th>
                <th>Accion</th>
                <th>proveedorid</th>
                <th>estatusid</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>Modelo</th>
                <th>Proveedor</th>
                <th>Conectividad</th>
                <th>No largo</th>
                <th>Estatus</th>
                <th>Accion</th>
                <th>proveedorid</th>
                <th>estatusid</th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" id="userId" value="0">
    <button class="btn btn-success" id="btnNewModelo">Nuevo Modelo</button>
</div>
<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="showModelo">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modelo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-sm-4">           
                <label for="modelo" class="col-form-label-sm">Modelo</label>
                <input type="text" class="form-control form-control-sm" id="modelo" aria-describedby="modelo">
            </div>
            <div class="col-sm-4">           
                <label for="proveedor" class="col-form-label-sm">Proveedor</label>
                <select id="proveedor" name="proveedor" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">           
                <label for="conectividad" class="col-form-label-sm">Conectividad</label>
                <select id="conectividad" name="conectividad" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-sm-4">           
                <label for="nolargo" class="col-form-label-sm">No. Largo</label>
                <input type="text" class="form-control form-control-sm" id="nolargo" aria-describedby="nolargo">
            </div>
            <div class="col-sm-4">           
                <label for="estatus" class="col-form-label-sm">Estatus</label>
                <select id="estatus" name="estatus" class="form-control form-control-sm">
                    <option value="0" selected>Seleccionar</option>
                </select>
            </div>
        </div>
        
   
    </div>
    <div class="modal-footer">
        <input type="hidden" value="0" id="modeloId">
        <button type="button" class="btn btn-primary" id="btnRegistrar">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="js/modelos.js"></script> 