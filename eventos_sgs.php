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
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
            <h3>REPORTE EVENTOS SGS</h3>
            
            <div id="container" class="container">
                 
                   
                     <div class="row pb-3">
                        <div class="col-sm-3">
                            <label for="fechaIni" class="col-form-label-sm">FECHA INICIO</label>
                            <input type="text" class="form-control form-control-sm" id="fechaIni" name="fechaIni" value="<?php echo date("d/m/Y", strtotime("-1 days", strtotime(date("Y-m-d")) )); ?>" autocomplete="off">
                        </div>
                        <div class="col-sm-3">
                            <label for="fechaFin" class="col-form-label-sm">FECHA FIN</label>
                            <input type="text" class="form-control form-control-sm" id="fechaFin" name="fechaFin" value="<?php echo date("d/m/Y", strtotime("-0 days", strtotime(date("Y-m-d")) )); ?>" autocomplete="off">
                        </div>
                        <div class="col-sm-3">
                            <label for="estatus" class="col-form-label-sm">FECHA FIN</label>
                            <select id="estatus" name="estatus" class="form-control form-control-sm" >
                                <option value="0" selected>Seleccionar</option>
                                <option value="3">Abierto</option>
                                <option value="6">Exito</option>
                                <option value="7">Rechazada</option>
                                <option value="8">Cancelado</option>
                                <option value="31">Programado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">
                            <a href="#"  class="btn btn-success" id="btnEnviar">Generar</a>
                        </div>
                    </div>
                    <div id="resultado">
                    </div>
					<div id="paginacion">
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script>
<script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="js/jquery.toaster.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap-multiselect.min.js"></script>
<script>
$(document).ready(function() {

    ResetLeftMenuClass("submenureportes", "ulsubmenureportes","repeventosgslink")

    $("#fechaIni").datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $("#fechaFin").datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $("#btnEnviar").on("click", function() {

        $.ajax({
            type: 'POST',
            url: 'conector/getODTbyStatus.php', // call your php file
            data: { fechaIni: $("#fechaIni").val(), fechaFin: $("#fechaFin").val(), estatus: $("#estatus").val()  },
            cache: false,
            success: function(data){    
                var info = JSON.parse(data);
                $("#resultado").html('');
                var tabla ="";
                $.each(info.datos, function(index,result) {
                   /* tabla += "<div class='row'>";
                    tabla += "<div class='col'>"+result.ODT+"</div>";
                    tabla += "<div class='col'>"+result.AFILIACION+"</div>";
                    tabla += "<div class='col'>"+result.FECHA_ALTA+"</div>";
                    tabla += "<div class='col'>"+result.TIPO_SERVICIO+"</div>";
                    tabla += "<div class='col'>"+result.SUB_TIPO_SERVICIO+"</div>";
                    tabla += "<div class='col'>"+result.ESTATUS_SERVICIO+"</div>";
                    tabla += "</div>"; */

                    tabla += "<div class='card pb-3'>"
                    tabla += "<div class='card-body'>"
                    tabla += "<h5 class='card-title'>"+result.objeto.ODT+"</h5>"
                    tabla += "<h6 class='card-subtitle mb-2 text-muted'>AFILIACION: "+result.objeto.AFILIACION+"</h6>"
                    tabla += "<h6>SGS </h6>"
                    tabla +="<div class='row'> "
                    tabla += "<div class='col'><b>FECHA_ALTA:</b> "+result.objeto.FECHA_ALTA+"</div>";
                    tabla += "<div class='col'><b>TIPO_SERVICIO:</b> "+result.objeto.TIPO_SERVICIO+"</div>";
                    tabla += "<div class='col'><b>SUB_TIPO_SERVICIO:</b> "+result.objeto.SUB_TIPO_SERVICIO+"</div>";
                    tabla += "<div class='col'><b>ESTATUS_SERVICIO:</b> "+result.objeto.ESTATUS_SERVICIO+"</div>";
                    
                    tabla +="</div><div class='row'> "
                    
                    tabla += "<div class='col'><b>COMERCIO:</b> "+result.objeto.COMERCIO+"</div>";
                    tabla += "<div class='col'><b>CONTACTO1:</b> "+result.objeto.CONTACTO1+"</div>";
                    tabla += "<div class='col'><b>ZONA:</b> "+result.objeto.ZONA+"</div>";
                    tabla += "<div class='col'><b>ESTADO:</b> "+result.objeto.ESTADO+"</div>";
                    tabla +="</div><div class='row'> "
                    tabla += "<div class='col'><b>DESCRIPCION:</b> "+result.objeto.DESCRIPCION+"</div>";
                    tabla +="</div><div class='row'> "
                    tabla += "<div class='col'><b>OBSERVACIONES:</b> "+result.objeto.OBSERVACIONES+"</div>";
                    tabla +="</div><div class='row'> "
                    tabla += "<div class='col'><b>CONECTIVIDAD:</b> "+result.objeto.CONECTIVIDAD+"</div>";
                    tabla += "<div class='col'><b>MODELO:</b> "+result.objeto.MODELO+"</div>";
                    tabla += "<div class='col'><b>ROLLOS_A_INSTALAR:</b> "+result.objeto.ROLLOS_A_INSTALAR+"</div>";
                    tabla += "<div class='col'><b>PRODUCTO:</b> "+result.objeto.PRODUCTO+"</div>";
                    tabla +="</div>"
                   
                    tabla += "<h6>SAES </h6>"
                    tabla +="<div class='row'> "
                    tabla += "<div class='col'><b>ESTATUS:</b> "+result.sinttecom.estatus_servicio+"</div>";
                    tabla += "<div class='col'><b>CONECTIVIDAD:</b> "+result.sinttecom.conectividadRet+"</div>";
                    tabla += "<div class='col'><b>MODELO:</b> "+result.sinttecom.modeloRet+"</div>";
                    tabla += "<div class='col'><b>ROLLOS_A_INSTALAR:</b> "+result.objeto.ROLLOS_A_INSTALAR+"</div>";
                    tabla += "<div class='col'><b>PRODUCTO:</b> "+result.objeto.PRODUCTO+"</div>";
                    tabla +="</div><div class='row'> "
                    tabla += "</div>";
                    tabla +="</div> "
                    tabla += "</div>"
                    tabla += "</div>"

                    tabla += "</div>";
                    tabla +="</div> "
                    tabla += "</div>"
                    tabla += "</div>"
                    
                })
                $("#resultado").html(tabla);
				
				var paginacion = "<div class='row'> "
                paginacion += "<div class='col'><b>Pagina </b> "+info.meta.currentPage+" de "+info.meta.totalPages+"</div>";
				paginacion += "<div class='col'><b>Total de Registros </b> "+info.meta.totalCount+"</div>";
				paginacion += "<div class='col'><b>Siguiente </b> "+info.meta.PageNumber+"</div>";
				$("#paginacion").html(paginacion);
                    
            },
            error: function(error){
                var demo = error;
            }
        });
    })
})
</script>
</body>

</html>