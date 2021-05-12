<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    <div style="border-style: solid; padding: 10px;">
        <div class="row">
            <div id="avisos" class="display:none;" style="background-color:red;"></div>
        </div>
       
        <div id="progress"></div>
        <div class="row">
            <div class="col-sm-4">           
                <label for="odt" class="col-form-label-sm">Escribe la ODT</label>
                <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt">
            </div>
            <div class="col" style="padding-left:30px;padding-top:30px;">  
                <button class="btn btn-primary" id="btnImagenes">Mostrar</button>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-4">
                <input type="file" class="form-control-file" id="fileToUpload">
            </div>
            <div class="col-sm-4" >  
                <button class="btn btn-primary" id="btnSaveImagenes">Agregar Imagen</button>
            </div>
        </div>
      
    </div>
</div>
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

<script type="text/javascript" src="js/imagenes.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDv9c8bFp7dT21O32pZYEhoeHoBamwxLwU&callback=initMap" async defer></script>
