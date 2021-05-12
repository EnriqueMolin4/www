<?php require("header.php"); ?>

<body>
<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <?php include("menu.php"); ?>
        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay">
           
            </div>
            <div class="page-title">
                <h3>NUEVA PETICION</h3>
            </div>
            <br>
            <div class="row p-2">
            <?php if( searchMenuEdit($_SESSION['Modules'],'url','peticionesenvio') == '1') { ?>
                <div class="col-sm-6">
                    <label for="excelMasivoPeticion" class="col-form-label-sm">Creacion Petición Masivos</label> 
                    <input class="input-file" type="file" id="excelMasivoPeticion" name="excelMasivoPeticion">
                    <button class="btn btn-success btn-sm" id="btnCargarExcelPeticion">Cargar</button>
                </div>
            <?php } ?>
            </div>

            <div class="container-fluid panel-white">
            
            <hr> <div class="row p-3"> 
                    <div class="col-4">
                        <label for="plaza" class="col-form-label-sm">PLAZA</label>
                        <select id="plaza" name="plaza" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div>   
                    <div class="col-4">
                        <label for="tecnico" class="col-form-label-sm">TECNICO</label>
                        <select id="tecnico" name="tecnico" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                        </select>
                    </div> 
                    <div class="col-4">
                        <label for="tipo" class="col-form-label-sm">TIPO</label>
                        <select id="tipo" name="tipo" class="form-control form-control-sm searchInventario" onchange="campos_tipo()">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1" >TPV</option>
                                <option value="2" >SIM</option>
                                <option value="3" >INSUMOS</option>
                                
                        </select>
                    </div>   
                </div>
                
                
                <div class="row p-3">
                    
                    <div class="col-4"> 
                        <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                        <select id="estatus" name="estatus" class="form-control form-control-sm searchInventario">
                            <option value="0" selected>Seleccionar</option>
                            <option value="3">DISPONIBLE-USADO</option>
                            <option value="5">DISPONIBLE-NUEVO</option>
                            
                        </select>
                    </div>
                
                </div>
                <div class="row p-3" style="display:none" id="divTpv">
                        <div class="col-4"> 
                            <label for="conectividad" class="col-form-label-sm">CONECTIVIDAD</label>
                            <select id="conectividad" name="conectividad" class="form-control form-control-sm searchInventario" >
                                <option value="0" selected>Seleccionar</option>
                                
                            </select>
                        </div>
                        
                        <div class="col-4"> 
                            <label for="producto" class="col-form-label-sm">PRODUCTO</label><br>
                            <select id="producto" name="producto" class="form-control form-control-sm searchInventario">
                                <option value="0" selected>Seleccionar</option>
                                
                            </select>
                        </div>          
                </div>
                <div class="row p-3" style="display:none" id="divIns">  
                
                        <div class="col-4"> 
                            <label for="insumo" class="col-form-label-sm">TIPO INSUMO</label><br>
                            <select id="insumo" name="insumo" class="form-control form-control-sm searchInventario" >
                                <option value="0" selected>Seleccionar</option>
                                
                            </select>
                        </div>                  
                </div>
                <div class="row p-3">   
                        <div class="col-md-4" style="display:none" id="divCan">           
                            <label for="cantidad" class="col-form-label-sm">CANTIDAD</label>
                            <input type="text" name="cantidad" class="form-control form-control-sm" id="cantidad">
                        </div>
                    
                </div>
                <div class="row p-3">
                    <div class="col mb-3 row">
                        <button type="button" class="btn btn-success mb-3" id="btnAdd" style="width: 50vh;">Agregar</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-md table-bordered table-responsive" id="tplDetalle" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">TIPO</th>
                            <th width="15%">TECNICO</th>
                            <th width="15%">ESTATUS</th>
                            <th width="20%">INSUMO</th>
                            <th width="20%">CONECTIVIDAD</th>
                            <th width="10%">VERSION</th>
                            <th width="10%">CANTIDAD</th> 
                            <th>tipoId</th>  
                            <th>tecnicoId</th> 
                            <th>estatusId</th>  
                            <th>insumoId</th>   
                            <th>conectividadId</th>   
                            <th>versionId</th>    
                            <th>ACCION</th>                         
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>                    
                </table> 
                </div>   
                <div class="row p-3">
                    <div class="col-5 mb-2 row">
                        <button type="button" class="btn btn-warning mb-3 " id="btnRegresar" style="margin-right: 10px;">Regresar</button> 

                        <button type="button" class="btn btn-success mb-3 " id="btnPeticion">Realizar Petición</button>
                    </div>
                </div>
                

                <br />
                <input type="hidden" id="no_guia" name="no_guia" value="0">
                <input type="hidden" id="userId" name="userId" value="<?php echo ($_SESSION['territorial']); ?>">
                <input type="hidden" id="userPerm" value="<?php echo isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : 0 ; ?>">
            </div>
        </main>
        <!-- page-content" -->
        
    </div>
    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script src="js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="js/nuevapeticion.js"></script> 
    <style>
        .multiselect {
          background-color: initial;
          border: 1px solid #ced4da;
          width: 270px;
          height: auto;

        }

        .multiselect-container
        {
            height: 200px  ;  
            overflow-x: hidden;
            overflow-y: scroll; 
        }
    </style>
</body>

</html>