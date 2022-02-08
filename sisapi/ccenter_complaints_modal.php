<?php  //include('general/loginredirect.php');
include('general/language_config.php'); 
    date_default_timezone_set("America/Monterrey");
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="TypesId" class="control-label col-lg-6">Tipo de queja</label>
                    <select required name="TypesId"
                        class="form-control m-bot15" id="TypesId">
                        <option value="0"><?php  echo($TEXT['Select']);?></option>
                        <option value="1"><?php  echo($TEXT['Products']);?></option>
                        <option value="2"><?php  echo($TEXT['Services']);?></option>
                        
                    </select>
                    
            </div>
        </div>
            
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="ReasonsId" class="control-label col-lg-6">Motivo de queja</label>
                    <select required name="ReasonsId"
                        class="form-control m-bot15" id="ReasonsId">
                        <option value="0"><?php  echo($TEXT['Select']);?></option>
                    </select>
                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Description" class="control-label col-lg-6">Descripcion</label>	
                <textarea class="form-control m-bot15" name="Description" id="Description" cols="40" rows="5" > </textarea>       
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-check">
                <label class="form-check-label">
                <input type="radio" class="form-check-input" name="optradio" value="0" checked> Pendiente
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                <input type="radio" class="form-check-input" name="optradio" value="1"> Solucionado
                </label>
            </div>
        </div>
    </div>
</div>