<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SINTTECOM</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.css"/>
    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
   </head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="view/img/logo.png" width="200" height="80">
            </div>

             <?php include("menu.php"); ?>

           
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="sesiones/logout.php"><i class="far fa-user"></i> Salir</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="container" class="container">
            <div style="border-style: solid; padding: 10px;box-shadow: 10px 10px;">
    
                <h3>Nuevo Evento</h3>
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
                            <input type="text" class="form-control form-control-sm" id="cve_banco" aria-describedby="cve_banco">
                        </div>
                        <div class="col">           
                            <label for="afiliacion" class="col-form-label-sm">Afilacion</label>
                            <input type="text" class="form-control form-control-sm" id="afiliacion" aria-describedby="afiliacion">
                        </div>
                        <div class="col">           
                            <label for="comercio" class="col-form-label-sm">Comercio</label>
                            <input type="text" class="form-control form-control-sm" id="comercio" aria-describedby="comercio">
                        </div>
                        <div class="col">           
                            <label for="direccion" class="col-form-label-sm">Dirección</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" aria-describedby="direccion">
                        </div>
                        <div class="col">           
                            <label for="estado" class="col-form-label-sm">Estado</label>
                            <select class="form-control form-control-sm" id="estado" name="estado"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="colonia" class="col-form-label-sm">Colonia</label>
                            <input type="text" class="form-control form-control-sm" id="colonia" aria-describedby="colonia" >
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
                            <select  class="form-control form-control-sm" id="municipio" name="municipio"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">           
                            <label for="telefono" class="col-form-label-sm">Telefono</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" aria-describedby="telefono" >
                        </div>
                        <div class="col">           
                            <label for="email" class="col-form-label-sm">Email</label>
                            <input type="text" class="form-control form-control-sm" id="email" aria-describedby="email" >
                        </div>
                        <div class="col">           
                            <label for="responsable" class="col-form-label-sm">Responsable</label>
                            <input type="text" class="form-control form-control-sm" id="responsable" aria-describedby="responsable" >
                        </div>
                        <div class="col">           
                            <label for="ticket" class="col-form-label-sm">Ticket</label>
                            <input type="text" class="form-control form-control-sm" id="ticket" aria-describedby="ticket" >
                        </div>
                        <div class="col">           
                            <label for="hora_atencion" class="col-form-label-sm">Hora de Atención</label>
                            <input type="text" class="form-control form-control-sm" id="hora_atencion" aria-describedby="hora_atencion" >
                        </div>
                        <div class="col">           
                            <label for="hora_comida" class="col-form-label-sm">Hora de Comida</label>
                            <input type="text" class="form-control form-control-sm" id="hora_comida" aria-describedby="hora_comida" >
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
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="js/jquery-3.3.1.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript">
        var infoAjax = 0;
$(document).ready(function() {
        
    getTipoServicio();
    getEstados();
    getTipoFallas()


    $("btnNuevoEvento").on("click", function() {
        $("#newEvento").modal("show");
    })

    $("#estado").on("change", function() {
        getMunicipios();
    })

    $("#btnAsignar").on('click', function() {

        if( $("#tipo_servicio").val().length > 0 || $("#telefono").val().length > 0 || $("#hora_atencion").val().length > 0 ||  $("#hora_comida").val().length > 0  )
        {
            
            var dn= { cve_banco: $("#cve_banco").val(), afiliacion: $("#afiliacion").val(), comercio: $("#comercio").val() , 
        direccion: $("#direccion").val() , estado: $("#estado").val() , colonia: $("#colonia").val() , tipo_servicio: $("#tipo_servicio").val(), 
        tipo_falla: $("#tipo_falla").val() , equipo_instalado: $("#equipo_instalado").val() , municipio: $("#municipio").val() ,
        telefono: $("#telefono").val() , email: $("#email").val(), responsable: $("#responsable").val() , ticket: $("#ticket").val(), 
        hora_atencion: $("#hora_atencion").val(), hora_comida: $("#hora_comida").val() , comentarios: $("#comentarios").val() };
            
            $.ajax({
                type: 'GET',
                url: 'modelos/eventos_db.php', // call your php file
                data: 'module=nuevoEvento',
                cache: false,
                success: function(data){
                    var info = JSON.parse(data);

                    $("#numODT").html('<label>SU SERVICIO HA QUEDADO REGISTRADO CON EL NO. DE ODT: </label> '+data.nuevaOdt);
                    $("#odtFechaLimite").html('<label>SU FECHA Y HORA LIMITE PARA LA ATENCION ES: </label>'+data.fecha_cierre+'<br><br><label style="color:#ff0000;">FAVOR DE PROPORCIONAR AL CLIENTE ESTOS DATOS PARA SU SEGUIMIENTO</label>');            
                    $("#showAvisos").modal("show");
                },
                error: function(error){
                    var demo = error;
                }
            });
            
        } else {
            alert("HACEN FALTA CAMPOS POR LLENAR");
        }
    })

    $( "#buscarComercio" ).autocomplete({
        source: function( request, response ) {
          $.ajax( {
            url: "modelos/eventos_db.php",
            dataType: "jsonp",
            data: {
              term: request.term,
              module: 'buscarComercio'
            },
            success: function( data ) {
                response( $.map( data, function( item ) {
                         alert(item);           
                    return {
                        label: item.Comercio,
                        value: item.id,
                        data : item
                    }
                }));
            }
          } );
        },
        messages: {
            noResults: '',
            results: function() {}
        },
        autoFocus: true,
        minLength: 2,
        select: function( event, ui ) {
            var info = ui.item.data;
            mostrarComercio(info)
        }
      } );
    

        
} );

    
      function initMap() {
         
      }

function getTipoServicio() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoServicios',
        cache: false,
        success: function(data){
        $("#tipo_servicio").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTipoFallas() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getTipoFallas',
        cache: false,
        success: function(data){
        $("#tipo_falla").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}


function getEstados() {
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getEstados',
        cache: false,
        success: function(data){
        $("#estado").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getMunicipios() {
    var estado = $("#estado").val();

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getMunicipios&estado='+estado ,
        cache: false,
        success: function(data){
        $("#municipio").html(data);            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function cleartext() {
    $("#cvebancaria").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_comercio").val("");
    $("#ciudad").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#rfc").val("")
    $("#email").val("")
    $("#email_ejecutivo").val("")
    $("#territorial_banco").val("")
    $("#territorial_sinttecom").val("")
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#razon_social").val("")
    $("#cp").val("")

}

function mostrarComercio(data) {
    $("#cvebancaria").val(data.cve_banco)
    $("#comercio").val(data.comercio)
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_comercio").val("");
    $("#ciudad").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#rfc").val("")
    $("#email").val("")
    $("#email_ejecutivo").val("")
    $("#territorial_banco").val("")
    $("#territorial_sinttecom").val("")
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#razon_social").val("")
    $("#cp").val("")
}


    </script>
    
</body>

</html>