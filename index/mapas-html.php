<div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    <div style="border-style: solid; padding: 10px;">
        <div class="row">
            <div id="avisos" class="display:none;" style="background-color:red;"></div>
        </div>
       
        <div id="progress"></div>
        <div class="row">
            <div class="col-sm-4">           
                <label for="tecnico" class="col-form-label-sm">Buscar Tecnico</label>
                <input type="text" class="form-control form-control-sm" id="tecnico" aria-describedby="tecnico">
            </div>
            <div class="col" style="padding-left:30px;padding-top:30px;">  
                <button class="btn btn-primary" id="btnMostrarTecnico">Mostrar</button>
            </div>
        </div>
       
      
    </div>
</div>
<div id="mapa" style="width: 700px; height: 500px;"></div>

<script type="text/javascript" src="js/imagenes.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDv9c8bFp7dT21O32pZYEhoeHoBamwxLwU&callback=initMap" async defer></script>
