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
        
        <main class="page-content">
            <div id="overlay" class="overlay"></div>
            <div class="page-title">
                <h3>CONSULTA DE EVENTOS</h3>
            </div><br>
            <div class="row">
                <div class="col">  
                    <a href="nuevoevento.php" class="btn btn-success" id="btnNuevoEvento">Nuevo Evento</a>
                </div>
            </div>  <br>
            <div class="container-fluid p-2 panel-white">
                        
                <h5>BUSQUEDA</h5>
                <div class="row">
                    <div class="col">
                        <label for="fechaVen_inicio" class="col-form-label-sm">VENCIMIENTO DESDE</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_inicio" aria-describedby="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <label for="fechaVen_fin" class="col-form-label-sm">VENCIMIENTO HASTA</label>
                        <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_fin" aria-describedby="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                    </div>
                    <div class="col">
                        <!--<input type="text" value="0" id="dt_vencimiento" class="dt_vencimiento">-->
                        <label for="diasVencidos" class="col-form-label-sm">DIAS DE VENCIMIENTO</label>
                        <select name="diasVencidos" id="diasVencidos" class="form-control form-control-sm searchEvento">
                            <option value="0" selected>Seleccionar</option>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                            <option value="4"> 4 </option>
                            <option value="5"> 5 </option>
                            <option value="6"> 6 </option>
                            <option value="7"> 7 </option>
                            <option value="8"> 8 </option>
                            <option value="9"> 9 </option>
                            <option value="10"> 10 </option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="tipo_evento" class="col-form-label-sm">TIPO EVENTOS</label>
                        <select id="tipo_evento" name="tipo_evento" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                            </select>
                    </div>
                    <div class="col">
                        <label for="estatus_busqueda" class="col-form-label-sm">ESTATUS</label>
                        <select id="estatus_busqueda" name="estatus_busqueda" class="form-control form-control-sm searchEvento">
                                <option value="0" selected>Seleccionar</option>
                                <option value="1">Abierto</option>
                                <option value="2">En Ruta</option>
                                <option value="3">Cerrado</option>
                            </select>
                    </div>          
                </div>
                <div class="row pt-3 pl-4">
                    <div class="col">
                        <input type="checkbox" class="form-check-input searchEvento" id="evidencias">
                        <label class="form-check-label" for="evidencias">CON EVIDENCIAS</label>
                    </div>
                </div>
                <br />
                <div class="table-responsive">
                   <table id="eventos"  class="display table table-md table-bordered table-responsive"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ODT</th>
                            <th>AFILIACION | FOLIO</th>
                            <th>CVE</th>
                            <th>COMERCIO | CLIENTE</th>
                            <th>SERVICIO</th>
                            <th>FECHA DE ALTA</th>
                            <th>FECHA VENCIMIENTO</th>
                            <th>FECHA CIERRE</th>
                            <th>IMAGENES CARGADAS</th>
                            <th>TECNICO</th>
                            <th>ESTATUS</th>
                            <th>Estatus SERVICIO</th>
                            <th>ACCION</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                       
                    </tfoot>
                </table> 
                </div>
                
                 
           <input type="hidden" id="tipo_user" name="tipo_user" value="<?php echo $_SESSION['tipo_user']; ?>">

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showEvento">
            <div class="modal-dialog modal-lg" style="max-width: 1350px!important;" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">INFORMACION DEL EVENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">           
                            <label for="odt" class="col-form-label-sm">ODT</label>
                            <input type="text" class="form-control form-control-sm" id="odt" aria-describedby="odt" readonly>
                        </div>
                        <div class="col">           
                            <label for="afiliacion" class="col-form-label-sm" id="labelAfiliacion">AFILIACION | FOLIO</label>
                            <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_servicio" class="col-form-label-sm">TIPO SERVICIO</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_servicio" aria-describedby="tipo_servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="tipo_subservicio" class="col-form-label-sm">TIPO SUBSERVICIO</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_subservicio" aria-describedby="tipo_subservicio" readonly>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtGetNet">Vestiduras GetNet</label>
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtNotificado">Notificado</label>
                            <label class="checkbox-inline"><input type="checkbox" value="" id="odtDescarga">Descarga mi comercio</label>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col">           
                            <label for="fecha_alta" class="col-form-label-sm">FECHA ALTA</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_alta" aria-describedby="fecha_alta" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_vencimiento" class="col-form-label-sm">FECHA VENCIMIENTO</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_vencimiento" aria-describedby="fecha_vencimiento" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_cierre" class="col-form-label-sm">FECHA CIERRE</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_cierre" aria-describedby="fecha_cierre" readonly>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comercio" class="col-form-label-sm">COMERCIO | CLIENTE</label>
                            <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio" readonly>
                        </div>
                        <div class="col">           
                            <label for="colonia" class="col-form-label-sm">COLONIA</label>
                            <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" readonly>
                        </div>
                        <div class="col">           
                            <label for="ciudad" class="col-form-label-sm">CIUDAD</label>
                            <input type="text" class="form-control form-control-sm" id="ciudad" aria-describedby="ciudad" readonly >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="estado" class="col-form-label-sm">ESTADO</label>
                            <input type="text" class="form-control form-control-sm" id="estado" aria-describedby="estado" readonly>
                        </div>
                        <div class="col">           
                            <label for="direccion" class="col-form-label-sm">DIRECCION</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion" readonly>
                        </div>
                        <div class="col">           
                            <label for="telefono" class="col-form-label-sm">TELEFONO</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col" style="padding:30px;">   
                            <div class="row justify-content-center" >
                                <div class="col-sm-4" style="padding:5px">
                                    <button class="btn btn-primary" id="btnImagenes">Imágenes</button> 
                                </div>
                            </div>       
                            <div class="row justify-content-center" >
                                <div class="col-sm-4" style="padding:5px">
                                    <button class="btn btn-primary" id="btnUbicacion">Ubicacion</button>
                                </div>
                            </div> 
                        </div>
                        <div class="col">           
                        <label for="descripcion" class="col-form-label-sm">DESCRIPCION</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="descripcion" aria-describedby="descripcion" readonly></textarea>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_atencion" class="col-form-label-sm">HORARIO DE ATENCION</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_atencion" aria-describedby="hora_atencion" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">           
                                    <label for="hora_comida" class="col-form-label-sm">HORARIO DE COMIDA</label>
                                    <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">           
                                    <label for="fecha_asignacion" class="col-form-label-sm">FECHA DE ASIGNACION</label>
                                    <input type="text" class="form-control form-control-sm" id="fecha_asignacion" aria-describedby="fecha_asignacion" readonly>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col">           
                            <label for="receptor_servicio" class="col-form-label-sm">QUIEN ATENDIO</label>
                            <input type="text" class="form-control form-control-sm" id="receptor_servicio" aria-describedby="receptor_servicio" readonly>
                        </div>
                        <div class="col">           
                            <label for="fecha_atencion" class="col-form-label-sm">FECHA DE ATENCION</label>
                            <input type="text" class="form-control form-control-sm" id="fecha_atencion" aria-describedby="fecha_atencion" autocomplete="off" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_llegada" class="col-form-label-sm">HORA DE LLEGADA</label>
                            <input type="time" class="form-control form-control-sm" id="hora_llegada" aria-describedby="hora_llegada" readonly>
                        </div>
                        <div class="col">           
                            <label for="hora_salida" class="col-form-label-sm">HORA DE SALIDA</label>
                            <input type="time" class="form-control form-control-sm" id="hora_salida" aria-describedby="hora_salida" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="tecnico" class="col-form-label-sm">TECNICO</label><?php if ($_SESSION['tipo_user'] == 'supOP' || $_SESSION['tipo_user'] == 'supervisor' || $_SESSION['tipo_user'] == 'admin' ) {  ?><a href="#" id="btnReasignarTecnico"><i class="fas fa-arrows-alt-h"></i>Reasignar</a> <?php } ?>  
                            <input type="text" class="form-control form-control-sm" id="tecnico" aria-describedby="tecnico" readonly>
                        </div>
                        <div class="col">           
                            <label for="estatus" class="col-form-label-sm">ESTATUS</label>
                            <input type="text" class="form-control form-control-sm" id="estatus" aria-describedby="estatus" readonly>
                        </div>
                        <div class="col">           
                            <label for="servicio" class="col-form-label-sm">SERVICIO SOLICITADO</label>
                            <input type="text" class="form-control form-control-sm" id="servicio" aria-describedby="servicio" readonly>
                        </div>
                        <div class="col" id="col_tipocredito">           
                            <label for="tipo_credito" class="col-form-label-sm">TIPO CREDITO</label>
                            <input type="text" class="form-control form-control-sm" id="tipo_credito" aria-describedby="tipo_credito" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                                <label for="tpv" class="col-form-label-sm">TERMINAL INSTALADA</label>
                                <input type="text" class="form-control form-control-sm" id="tpv" aria-describedby="tpv" readonly>
                                <select  class="form-control form-control-sm" id="tpvInDataModelo" aria-describedby="tpvInDataModelo">
                                    <option value="0" selected>Seleccionar Modelo</option>
                                </select>
                                <select  class="form-control form-control-sm" id="tpvInDataConnect" aria-describedby="tpvInDataConnect">
                                    <option value="0" selected>Seleccionar Conectividad</option>
                                </select>
                        </div>
                        <div class="col">           
                                <label for="tpv_retirado" class="col-form-label-sm">Terminal Retirada</label>
                                <input type="text" class="form-control form-control-sm" id="tpv_retirado" aria-describedby="tpv" readonly>
                                <select  class="form-control form-control-sm" id="tpvReDataModelo" aria-describedby="tpvReDataModelo">
                                    <option value="0" selected>Seleccionar Modelo</option>
                                </select>
                                <select  class="form-control form-control-sm" id="tpvReDataConnect" aria-describedby="tpvReDataConnect">
                                    <option value="0" selected>Seleccionar Conectividad</option>
                                </select>
                                <div class="row" id="tvpRetiradaCHK">
                                    <div class="col">
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetBateria">Batería</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetEliminador">Eliminador</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetTapa">Tapa Ret</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetCable">Cable AC</label>
                                        <label class="checkbox-inline"><input type="checkbox" value="" id="tvpRetBase">Base</label>
                                    </div>
                                </div>
                        </div>
                        <div class="col">           
                                <label for="idcaja" class="col-form-label-sm">ID CAJA</label>
                                <input type="text" class="form-control form-control-sm" id="idcaja" aria-describedby="idcaja" readonly>
                        </div>
                        <div class="col">           
                            <label for="afiliacion_amex" class="col-form-label-sm">AFILIACION AMEX</label>
                            <input type="hidden" id="tieneamex" name="tieneamex">
                            <input type="text" class="form-control form-control-sm" id="afiliacion_amex" aria-describedby="afiliacion_amex" readonly>
                        </div>
                        <div class="col">           
                            <label for="idamex" class="col-form-label-sm">ID AMEX</label>
                            <input type="text" class="form-control form-control-sm" id="idamex" aria-describedby="idamex" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                                <label for="version" class="col-form-label-sm">VERSION</label>
                                <select  class="form-control form-control-sm" id="version" aria-describedby="version" readonly>
                                    <option value="0">Seleccionar</option>
                                </select>
                        </div>
                        <div class="col">           
                                <label for="aplicativo" class="col-form-label-sm">APLICATIVO</label>
                                <select  class="form-control form-control-sm" id="aplicativo" aria-describedby="aplicativo" readonly>
                                    <option value="0">Seleccionar</option>
                                </select>
                        </div>
                        <div class="col">           
                            <label for="producto" class="col-form-label-sm">PRODUCTO</label>
                            <select  class="form-control form-control-sm" id="producto" aria-describedby="producto" disabled>
                                <option value="0">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col">           
                            <label for="rollos_instalar" class="col-form-label-sm">ROLLOS A ENTREGAR</label>
                            <input type="text" class="form-control form-control-sm" id="rollos_instalar" aria-describedby="rollos_instalar" readonly>
                        </div>
                        <div class="col">           
                            <label for="rollos_entregados" class="col-form-label-sm">ROLLOS ENTREGADOS</label>
                            <input type="text" class="form-control form-control-sm" id="rollos_entregados" aria-describedby="rollos_entregados" readonly>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="simInData" class="col-form-label-sm">SIM INSTALADA</label>
                            <input type="text" class="form-control form-control-sm" id="sim_instalado" aria-describedby="sim_instalado">
                            <select  class="form-control form-control-sm" id="simInData" aria-describedby="simInData">
                                <option value="0" selected>Seleccionar Carrier</option>
                            </select>
                        </div>
                        <div class="col">           
                            <label for="simReData" class="col-form-label-sm">SIM RETIRADA</label>
                            <input type="text" class="form-control form-control-sm" id="sim_retirado" aria-describedby="sim_retirado">
                            <select  class="form-control form-control-sm" id="simReData" aria-describedby="simReData">
                                <option value="0" selected>Seleccionar Carrier</option>
                            </select>
                        </div>
                        <div class="col-sm-3">           
                            <label for="folio_telecarga" class="col-form-label-sm">FOLIO TELECARGA</label>
                            <input type="text" class="form-control form-control-sm" id="folio_telecarga" aria-describedby="folio_telecarga" readonly>
                        </div>
                        <div class="col-sm-3">           
                            <label for="estatus_servicio" class="col-form-label-sm">ESTATUS SERVICIO</label>
                            <select  class="form-control form-control-sm" id="estatus_servicio" aria-describedby="estatus_servicio" disabled>
                                <option value="0">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" id="rowRechazos" style="display: none;">           
                            <label for="rechazo" class="col-form-label-sm">RECHAZO</label>
                            <select  class="form-control form-control-sm" id="rechazo" aria-describedby="rechazo" >
                                <option value="0">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-sm-4" id="rowSubRechazos" style="display: none;">           
                            <label for="subrechazo" class="col-form-label-sm">SUB RECHAZO</label>
                            <select  class="form-control form-control-sm" id="subrechazo" aria-describedby="subrechazo" >
                                <option value="0">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-sm-4" id="rowCancelado" style="display: none;">           
                            <label for="cancelado" class="col-form-label-sm">CANCELADO</label>
                            <select  class="form-control form-control-sm" id="cancelado" aria-describedby="cancelado" >
                                <option value="0">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comentarios_tecnico" class="col-form-label-sm">COMENTARIOS DE TECNICO</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_tecnico" aria-describedby="comentarios_tecnico" readonly></textarea>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="comentarios_cierre" class="col-form-label-sm">COMENTARIOS DE CIERRE</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_cierre" aria-describedby="comentarios_cierre" readonly></textarea>
                        </div>
                        
                    </div>
                    <div class="row" style="display:none" id="comentarios_valid" >
                        <div class="col">           
                            <label for="comentarios_validacion" id="comentarios_valid"  class="col-form-label-sm">COMENTARIOS DE VALIDACION</label>
                            <textarea  class="form-control form-control-sm" rows="5" id="comentarios_validacion" aria-describedby="comentarios_validacion"></textarea>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="0" id="eventoId">
                    <input type="hidden" value="0" id="servicioId">
                    <input type="hidden" value="0" id="tecnicoid"> 
                    <input type="hidden" value="0" id="odt">
                    <input type="hidden" value="0" id="latitud">
                    <input type="hidden" value="0" id="longitud">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                <div class="modal-footer" id="divBtnCV" style="display:none" >
                    <button type="button" class="btn btn-primary" name="btnComentValid" id="btnComentValid" >Guardar Comentario de Validación</button>
                </div>
                </div>
            </div>
            </div>
            <!-- MODAL Reasignar -->
            <div class="modal fade" tabindex="-3" role="dialog" id="showReasignar">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reasignar Tecnico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">           
                            <label for="reasignartecnico" class="col-form-label-sm">TECNICO</label>
                            <select class="form-control form-control-sm" name="reasignartecnico" id="reasignartecnico" aria-describedby="reasignartecnico">
                            </select>
                        </div>
                        
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSubmitReasignar">ReAsignar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>  
                </div>
            </div>
            </div>
            <!-- MODAL MAPS Ubicacion -->
            <div class="modal fade" tabindex="-3" role="dialog" id="showUbicacion">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubicacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div id="mapa" style="width: 700px; height: 500px;"></div>
                        <div class="row">
                            <div class="col"><span id="ubicacionData"></span></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>  
                </div>
            </div>
            </div>
            <!-- MODAL IMAGENES Ubicacion -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showImagenes">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IMAGENES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 anyClass" id="carruselFotos"></div>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div> 
                </div>
            </div>
            </div>
            <!-- MODAL Documentos Ubicacion -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showDocumentos">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DOCUMENTOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                
                                <div class="col-md-10" id="carruselDocs"></div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div> 
                    </div>
                </div>
            </div>
            <!-- MODAL Cambiar ODT -->
            <div class="modal fade" tabindex="-3" role="dialog" id="chgODT">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CAMBIAR ODT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-5">           
                                <label for="old_odt" class="col-form-label-sm">ODT ACTUAL</label>
                                <input type="text" class="form-control form-control-sm" id="old_odt" aria-describedby="old_odt" readonly>
                                 
                            </div>
                            <div class="col-sm-5">           
                                <label for="new_odt" class="col-form-label-sm">NUEVA ODT</label>
                                <input type="text" class="form-control form-control-sm" id="new_odt" aria-describedby="new_odt">
                                 
                            </div>  
                        </div>        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnChgODT">Cambiar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>  
                    </div>
                </div>
            </div>
            <!-- Modal Historia Evento ODT -->
            <div class="modal fade" tabindex="-1" id="showHistoria" role="dialog" data-backdrop="static" data-keyboar="false">
                <div class="modal-dialog  modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> HISTORIAL ODT  </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            
                        </div>
                        <div class="mb-3">
                            <center> <input type="text" class="form-control" value="0" id="historiaOdt" name="historiaOdt" readonly> </center>
                        </div>
                        
                        <div class="modal-body">

                            <h3>BITÁCORA ODT</h3>
                            <div class="row">
                                <div class="table-responsive">
                                  <table id="historia" class="table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> ID </th>
                                                <th> ODT </th>
                                                <th> ESTATUS </th>
                                                <th> MODIFICADO POR </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                  </table>
                                </div>
                                
                            </div>
                            
                            <hr>

                            <h3>MOVIMIENTOS DE INV ODT</h3>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="historiaevento" class="table table-responsive" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th> SERIE DE ENTRADA</th>
                                                <th> APLICATIVO </th>
                                                <th> CONECTIVIDAD </th>
                                                <th> SERIE DE SALIDA </th>
                                                <th> SIM DE ENTRADA</th>
                                                <th> SIM DE SALIDA</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            
                                        </tbody>   
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                
            </div>
            
            <!-- End Modal Historia Evento ODT -->
            </div>
            </div>
        </main>
        <!-- page-content" -->
    </div>
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-html5-1.6.5/fc-3.3.2/fh-3.1.8/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
    <script src="js/zoomifyc.min.js" ></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/eventos.js"></script> 
    <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7&key=AIzaSyAQCiiA5ZZ1RoIxJquirYDaLOwRbZAQDzA&callback=initMap" async defer></script>

</body>

</html>