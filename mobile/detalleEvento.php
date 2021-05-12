<?php  include('modelos/loginredirect.php');?>
<!DOCTYPE html>
<html>
        <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sinttecom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    </head>
    <body>
		<form id="formVO" name="formVO">
        <input type="hidden" value="<?php echo  $_GET['evento']; ?>" id="eventoId" name="eventoId">
        <input type="hidden" id="odt" name="odt">
		<input type="hidden" id="formularioId" name="formularioId" value="0">
        <div class="container-fluid"> 
            <nav class="navbar navbar-light bg-light" tyle="background-color: #343a40;">
                <a class="navbar-brand" href="#">
                <img src="../images/LOGOSAE.fw.png" width="80" height="30" class="d-inline-block align-top" alt=""></a>
                <span class="navbar-text">
                    <a href="../sesiones/logout.php">Salir</a>
                </span>
            </nav>
            
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <a href="#" class="btn btn-link" data-toggle="collapse" data-target="#generales" aria-expanded="true" aria-controls="collapseOne">
                        Datos Generales
                        </a>
                    </h5>
                    </div>

                    <div id="generales" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                    <div id="listDocs"></div>
                        <div class="row">
                            <div class="col">
                                <small class="form-text text-muted">Fecha: <?php echo date('Y-m-d'); ?> </small>
                                <span id="fechaVisita"></span>
                            </div>
                            <div class="col">
                            <small class="form-text text-muted">Hora: <?php echo date('h:i'); ?></small>
                                <p id="horaVisita"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <small class="form-text text-muted">Folio: </small>
                                <span id="folio"></span>
                            </div>
                            <div class="col">
                            <small class="form-text text-muted">Producto:</small>
                                <span id="tipoProducto"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Nombre</small>
                            <input type="text" class="form-control" id="nombre"  readonly >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Calle</small>
                            <input type="text" class="form-control" id="calle" readonly >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Colonia</small>
                            <input type="text" class="form-control" id="colonia" readonly >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Municipio</small>
                            <input type="text" class="form-control" id="municipio" readonly >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Estado</small>
                            <input type="text" class="form-control" id="estado" readonly >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Telefono Fijo</small>
                            <input type="text" class="form-control" id="telFijo"  name="telFijo">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Telefono del Empleo</small>
                            <input type="text" class="form-control" id="telEmpleo" name="telEmpleo" >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Numero de Medidor</small>
                            <input type="text" class="form-control" id="numMedidor"  name="numMedidor">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Nivel Socioeconómico</small>
                            <select class="form-control" id="nivelEconomico" name="nivelEconomico">
                            <option value="Seleccionar">Seleccionar</option>
                            <option value="Alto">Alto</option>
                            <option value="Medio">Medio</option>
                            <option value="Bajo">Bajo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#registro" aria-expanded="false" aria-controls="collapseTwo">
                        Registro de Visita
                        </a>
                    </h5>
                    </div>
                    <div id="registro" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group">
                                <small class="form-text text-muted">Tipo de zona en el que se encuentra ubicada en el domicilio</small>
                                <select class="form-control" id="tipozona" name="tipozona">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Habitacional/Residencial">Habitacional/Residencial</option>
                                <option value="Comercial">Comercial</option>
                                
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Domicilio</small>
                                <select class="form-control" id="tipodomicilio" name="tipodomicilio">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Propio">Propio</option>
                                <option value="Rentado">Rentado</option>
                                <option value="Prestado">Prestado</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Persona Contactada</small>
                                <select class="form-control" id="personacontactada" name="personacontactada">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Cliente">Cliente</option>
                                <option value="Coacreditado">Coacreditado</option>
                                <option value="Aval">Aval</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Nombre de la persona contactada</small>
                                <input type="text" class="form-control" id="personaContacto"  name="personaContacto">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Relacion con el cliente</small>
                                <input type="text" class="form-control" id="relacionCliente" name="relacionCliente" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Se identifica con:</small>
                                <input type="text" class="form-control" id="identificacion" name="identificacion" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">No. de Identificacion</small>
                                <input type="text" class="form-control" id="noIdentificacion"  name="noIdentificacion">
                            </div>
                        
                            <div class="form-group">
                                <small class="form-text text-muted">Sin Contacto</small>
                                <select class="form-control" id="sincontacto" name="sincontacto">
                                    <option value="Seleccionar">Seleccionar</option>
                                    <option value="Casa deshabitada">Casa deshabitada</option>
                                    <option value="Domicilio inexistente">Domicilio inexistente</option>
                                    <option value="Cliente no se encuentra">Cliente no se encuentra</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#referencias" aria-expanded="false" aria-controls="collapseThree">
                            Referencias (Vecinos)
                            </a>
                        </h5>
                    </div>
                    <div id="referencias" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <p>Referencia 1</p>
                            <div class="form-group">
                                <small class="form-text text-muted">Nombre de la persona que proporciona la informacion</small>
                                <input type="text" class="form-control" id="referencia1Nombre" name="referencia1Nombre" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Cuanto tiempo tiene de conocerlo</small>
                                <input type="text" class="form-control" id="referencia1Tiempo" name="referencia1Tiempo" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Cuanto tiempo tiene de vivir en el domicilio(Cliente)</small>
                                <input type="text" class="form-control" id="referencia1TiempoResidencia"  name="referencia1TiempoResidencia">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Estado civil del cliente</small>
                                <select class="form-control" id="referencia1EstadoCivil" name="referencia1EstadoCivil">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Empresa donde labora el cliente</small>
                                <input type="text" class="form-control" id="referencia1Empresa" name="referencia1Empresa" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Considera que sabe pagar sus creditos</small>
                                <select class="form-control" id="referencia1PagarCredito">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Lo recomendria como Cliente para un crédito</small>
                                <select class="form-control" id="referencia1Recomendacion">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                            </div>
                            <p>Referencia 2</p>
                            <div class="form-group">
                                <small class="form-text text-muted">Nombre de la persona que proporciona la informacion</small>
                                <input type="text" class="form-control" id="referencia2Nombre" name="referencia2Nombre" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Cuanto tiempo tiene de conocerlo</small>
                                <input type="text" class="form-control" id="referencia2Tiempo" name="referencia2Tiempo" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Cuanto tiempo tiene de vivir en el domicilio(Cliente)</small>
                                <input type="text" class="form-control" id="referencia2TiempoResidencia"  name="referencia2TiempoResidencia">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Estado civil del cliente</small>
                                <select class="form-control" id="referencia2EstadoCivil" name="referencia2EstadoCivil">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Empresa donde labora el cliente</small>
                                <input type="text" class="form-control" id="referencia2Empresa" name="referencia2Empresa" >
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Considera que sabe pagar sus creditos</small>
                                <select class="form-control" id="referencia2PagarCredito">
                                <option>Seleccionar</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Lo recomendria como Cliente para un crédito</small>
                                <select class="form-control" id="referencia2Recomendacion">
                                <option>Seleccionar</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#empleo" aria-expanded="false" aria-controls="collapseThree">
                        Datos de Empleo
                        </a>
                    </h5>
                    </div>
                    <div id="empleo" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <small class="form-text text-muted">Nombre de la persona que proporciona la informacion</small>
                            <input type="text" class="form-control" id="datosempleoNombre" name="datosempleoNombre" >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Puesto</small>
                            <input type="text" class="form-control" id="datosempleoPuesto" name="datosempleoPuesto"  >
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Tiempo de laborar el Cliente en el empleo</small>
                            <input type="text" class="form-control" id="datosempleoTiempoLaborar" name="datosempleoTiempoLaborar" >
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#comentarios" aria-expanded="false" aria-controls="collapseThree">
                        Comentarios Adicionales
                        </a>
                    </h5>
                    </div>
                    <div id="comentarios" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <small class="form-text text-muted">Comentarios</small>
                            <textarea class="form-control" aria-label="With textarea" id="comentario" name="comentario"></textarea>
                        </div>
                    
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <a href="#" class="btn btn-link" data-toggle="collapse" data-target="#evidencias" aria-expanded="true" aria-controls="collapseOne">
                        Evidencias (Fotos)
                        </a>
                    </h5>
                    </div>

                    <div id="evidencias" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <small class="form-text text-muted">Cargar Foto </small><br />
                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
                        </div>
                        <div class="row">
                            <div id="details"></div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="button" onclick="uploadFile()" value="Upload" />
                        </div>
                        <div class="row">
                            <div id="progress"></div>
                        </div>
                        <input type="hidden" id='saveImage' name='saveImage'>
                        <div id="listImages"></div>
                    </div>
                </div>
            </div> 
            <br />
            <div class="row"> 
            <input type="hidden" id="latitude" name="latitude"  value="">
            <input type="hidden" id="longitude" name="longitude" value="">
            <input type="hidden" id="module" name="module" value="saveVisitaTecnico">
            <a href="#" class="btn btn-primary btn-lg btn-block" id="btnFinEvento" name="btnFinEvento">Terminar Visita</a>  
            </div>
        </div> 
		</form>
    <div class="modal" id="loading" name="loading"></div>
    <script src="../js/jquery-3.3.1.js"></script>
	<script src="../js/jquery.validate.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.toaster.js"></script>
    <script src="../js/detalleEvento.js"></script>
    </body>
</html>