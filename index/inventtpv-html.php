<div class="row">
    <div class="col-md-5"><h3>Inventario TPV</h3></div>
</div>

    <table id="example"  class="table  table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No Serie</th>
                <th>Modelo</th>
                <th>Fabricante</th>
                <th>Conectividad</th>
                <th>Fecha de Alta</th>
                <th>Ubicacion Fisica</th>
                <th>Historia</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr>
                <th>No Serie</th>
                <th>Modelo</th>
                <th>Fabricante</th>
                <th>Conectividad</th>
                <th>Fecha de Alta</th>
                <th>Ubicacion Fisica</th>
                <th>Historia</th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" id="noSerie" name="noSerie" value="0">

<!-- MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="showHistoria" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Historia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
            <table id="historia-tpv"  class="display table table-md table-bordered " style="width=100%;">
                <thead>
                    <tr>
                        <th>Fecha Movimiento</th>
                        <th>Movimiento</th>
                        <th>Producto</th>
                        <th>No Serie</th>
                        <th>Ubicacion</th>
                        <th>Id_Ubicacion</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Fecha Movimiento</th>
                        <th>Movimiento</th>
                        <th>Producto</th>
                        <th>No Serie</th>
                        <th>Ubicacion</th>
                        <th>Id_Ubicacion</th>
                    </tr>
                </tfoot>
            </table>
       <br />
        <h5>Traspaso</h5>
        <div class="row">
            <div class="col">
                <label for="hist-producto" class="col-form-label-sm">Producto</label>
                <input type="text" class="form-control form-control-sm" id="hist-producto" aria-describedby="hist-producto" readonly>
            </div>
            <div class="col">
                <label for="hist-noserie" class="col-form-label-sm">No Serie</label>
                <input type="text" class="form-control form-control-sm" id="hist-noserie" aria-describedby="hist-noserie" readonly>
            </div>
            <div class="col">
                <label for="hist-desde" class="col-form-label-sm">Desde</label>
                <select id="hist-desde" name="hist-desde" class="form-control form-control-sm" readonly>         
                </select>
            </div>
            <div class="col">
                <div col="col">
                <label for="hist-hacia" class="col-form-label-sm">Hacia</label>
                <select id="hist-hacia" name="hist-hacia" class="form-control form-control-sm">            
                </select>
                </div>
            </div>
            <div class="col">   
                <label for="hist-tecnico" class="col-form-label-sm">Tecnico</label>
                <select id="hist-tecnico" name="hist-tecnico" class="form-control form-control-sm">
                   <option value="0" selected>Seleccionar</option>            
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <br />
                <button id="btnTraspasar" name="btnTraspasar" class="btn btn-success">Traspasar</button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" value="0" id="noSerie" name="noSerie">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/inventario_tpv.js"></script> 