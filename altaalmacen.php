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
            <h3>Registro para Almacen</h3>
                
                <div class="row">
                    <div id="avisos" class="display:none;" style="background-color:red;"></div>
                </div>
                <div class="row">
                    <div class="col">           
                        <label for="cve_banco" class="col-form-label-sm">Cve Banco</label>
                        <select id="cve_banco" name="cve_banco" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col">           
                        <label for="almacen_producto" class="col-form-label-sm">Producto</label>
                        <select id="almacen_producto" name="almacen_producto" class="form-control form-control-sm">
                            <option value="0">Seleccionar</option>
                            <option value="1">TPV</option>
                            <option value="2">SIM</option>
                        </select>
                    </div>
                    
                </div>
      
            <br/>
            <div style=" padding: 10px; display:none;" id="altatpv">
                <div class="row">
                    <div class="col" id="tpvbk">           
                        <label for="select-modelo_tpv" class="col-form-label-sm">Modelos TPV </label>
                        <select class="form-control form-control-sm" id= "select-modelo_tpv" name="select-modelo_tpv"></select>
                    </div>
                    <div class="col" id="aplicativobk">
                        <label for="select-aplicativo" class="col-form-label-sm">Aplicativo</label>
                        <select class="form-control form-control-sm" name="select-aplicativo" id="select-aplicativo"></select>
                    </div>
                    <div class="col" id="carrierbk">           
                        <label for="select-carrier" class="col-form-label-sm">Carrier </label>
                        <select class="form-control form-control-sm" id= "select-carrier" name="select-carrier"></select>
                    </div>
                    <div class="col" id="insumobk">           
                        <label for="select-insumo" class="col-form-label-sm">Insumo </label>
                        <select class="form-control form-control-sm" id= "select-insumo" name="select-insumo"></select>
                    </div>
                    <div class="col" id="noseriebk">           
                        <label for="almacen-no_serie" class="col-form-label-sm">No. de Serie*</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-no_serie" aria-describedby="almacen-no_serie">
                    </div>
                    <div class="col" id="cantidadbk">           
                        <label for="almacen-cantidad" class="col-form-label-sm">Cantidad</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-cantidad" aria-describedby="almacen-cantidad">
                    </div>
                    
                    <div class="col" id="ptidbk">           
                        <label for="almacen-ptid" class="col-form-label-sm">PTID*</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-ptid" aria-describedby="almacen-ptid">
                    </div>
                </div>
                <div class="row">
            <div class="col" id="fabricantebk">           
                        <label for="almacen-fabricante" class="col-form-label-sm">Fabricante</label>
                        <select class="form-control form-control-sm" id="almacen-fabricante" name="almacen-fabricante">
                        <option value="0">Seleccionar</option>
                        </select>
                    </div>
                    <div class="col" id="connectbk">           
                        <label for="almacen-connect" class="col-form-label-sm">Conectividad</label>
                        <select class="form-control form-control-sm" id="almacen-connect" name="almacen-connect">
                        <option value="0">Seleccionar</option>
                        </select>
                    </div>
            </div>
            </div>
            
            <div style=" padding: 10px; display:none;" id="altaalmacen">
                <div class="row">
                    <div class="col">           
                        <label for="select-estatus" class="col-form-label-sm">Estatus* </label>
                        <select class="form-control form-control-sm" id= "select-estatus" name="select-estatus">
                        </select>
                    </div>
                    <div class="col">           
                        <label for="select-estatus_inventario" class="col-form-label-sm">Estatus Inventario</label>
                        <select class="form-control form-control-sm" id= "select-estatus_inventario" name="select-estatus_inventario">
                        </select>
                    </div>
                    <div class="col">           
                        <label for="almacen-idubicacion" class="col-form-label-sm">Ubicacion </label>
                        <input type="text" class="form-control form-control-sm" id="almacen-idubicacion" aria-describedby="almacen-idubicacion">
                        <input type="hidden" value="0" id="ubicacionId">
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col" id="tarimabk">           
                        <label for="almacen-tarima" class="col-form-label-sm">Tarima</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-tarima" aria-describedby="almacen-tarima">
                    </div>
                    <div class="col" id="anaquelbk">           
                        <label for="almacen-anaquel" class="col-form-label-sm">Anaquel</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-anaquel" aria-describedby="almacen-anaquel">
                    </div>
                    <div class="col" id="cajonbk">           
                        <label for="almacen-cajon" class="col-form-label-sm">Cajon</label>
                        <input type="text" class="form-control form-control-sm" id="almacen-cajon" aria-describedby="almacen-cajon">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" style="padding-left:30px;padding-top:10px;">  
                    <button class="btn btn-dark" id="btnAsignar">Grabar</button>
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
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script>
    var infoAjax = 0;
    $(document).ready(function() {
        
        $("#almacenlink").addClass("active");     
        getBancos();
        getModelosTPV();
        getAplicativo();
        getCarriers();
        getInsumos();
        getConectividad();
        getFabricantes();
        getStatus();
        getStatusInventario();
        getUbicacion();

        $("#almacen-idubicacion").autocomplete({
            delay: 1000,
            minLength: 4,
            source: function( request, response ) {
            $.ajax({
                url: "modelos/almacen_db.php",
                dataType: "json",
                data: {
                term: request.term,
                module: 'buscarUbicacion',
                tipoUbicacion: $("#select-estatus_inventario").val()
                },
                success: function( data ) {
                        $("#ubicacionId").val("0");
                    response( $.map( data, function( item ) {
                                    
                        return {
                            label: item.nombre,
                            value: item.nombre,
                            data : item
                        }
                    }));
                }
            });
            },
            messages: {
                noResults: '',
                results: function() {}
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ) {
                var info = ui.item.data;
                $("#ubicacionId").val(info.id);
                
            
            }
        } );

        $("#almacen_producto").on("change", function() {
            $("#altatpv").show();
            $("#altaalmacen").show();
            $("#almacen-fabricante").val('0');
            $("#almacen-connect").val('0');
            $("#select-modelo_tpv").val('0');
            $("#select-aplicativo").val('0');
            $("#select-carrier").val('0');
            $("#select-insumo").val('0');
            $("#almacen-ptid").val('');
            $("#fabricantebk").show();
            $("#connectbk").show();
            $("#ptidbk").show();

        
            switch ( $(this).val() ) {
                
                case '1':
                $("#carrierbk").hide();
                $("#tpvbk").show();
                $("#aplicativobk").show();
                $("#ptidbk").hide();
                $("#noseriebk").show();
                $("#cantidadbk").hide();
                $("#insumobk").hide();
                $("#tarimabk").show();
                $("#anaquelbk").show();
                $("#cajonbk").show();
                $("#almacen-ptid").attr('readonly',false);
                $("#almacen-ptid").attr('disabled',true);
                
                break;
                case '2':
                $("#fabricantebk").hide();
                $("#connectbk").hide();
                $("#carrierbk").show();
                $("#ptidbk").hide();
                $("#tarimabk").hide();
                $("#anaquelbk").hide();
                $("#cajonbk").hide();
                $("#tpvbk").hide();
                $("#aplicativobk").hide();
                $("#noseriebk").show();
                $("#cantidadbk").hide();
                $("#insumobk").hide();
                $("#almacen-ptid").attr('readonly',true);
                
                break;
                case '3':
                $("#carrierbk").hide();
                $("#tpvbk").hide();
                $("#aplicativobk").hide();
                $("#noseriebk").hide();
                $("#cantidadbk").show();
                $("#insumobk").show();
                $("#almacen-ptid").attr('readonly',true);
                $("#fabricantebk").hide();
                $("#connectbk").hide();
                $("#ptidbk").hide();
                $("#cajonbk").hide();
                break;
                default:
                $("#altatpv").hide();
                $("#altaalmacen").hide();
    
            }
        })
        
        /* $("#select-modelo_tpv").on('change', function() {
            var info = $(this).find(":selected").attr('data').split('_');
        console.log(info);
            $("#almacen-fabricante").val(info[1]);
            $("#almacen-connect").val(info[2]);
        }) */

        $("#btnAsignar").on('click', function() {

            if( $("#almacen-no_serie").val().length > 0 ) {

                if( $("#cve_banco").val() != '0'  ||  $("#almacen_producto").val() != '0' ||   $("#almacen-estatus").val() != 0 ||   $("#almacen-tarima").val() != 0 ||   $("#almacen-anaquel").val() != 0 ||   $("#almacen-cajon").val() != 0 ||   $("#select-insumo").val() != 0 )
                {
                    
                    var dn= { 
                        module: 'altaAlmacen', cve_banco: $("#cve_banco").val(), 
                        'tpv': $("#select-modelo_tpv").val(),  'aplicativo' : $("#select-aplicativo").val(),
                        'connect': $("#almacen-connect").val(),  'carrier': $("#select-carrier").val(), 
                        'insumo': $("#select-insumo").val() ,   'producto' : $("#almacen_producto").val(), 
                        'cantidad': $("#almacen-cantidad").val(), 'noserie': $("#almacen-no_serie").val(), 
                        'estatus': $("#select-estatus").val() ,  'tarima' : $("#almacen-tarima").val(), 
                        'anaquel': $("#almacen-anaquel").val(),  'cajon' : $("#almacen-cajon").val() ,
                        'estatusinv' : $("#select-estatus_inventario").val(), 'ubicacionid': $("#ubicacionId").val()
                    };
                    
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/almacen_db.php', // call your php file
                        data: dn,
                        cache: false,
                        success: function(data){
                            var info = JSON.parse(data);
                            mensaje = "Se agrego con Exito al Inventario"
                            if(info.id == '0') {
                                mensaje = info.msg
                            } else {
                                cleartext();
                            }

                            $.toaster({
                                message: mensaje,
                                title: 'Aviso',
                                priority : 'success'
                            }); 

                        
                        },
                        error: function(error){
                            var demo = error;
                        }
                    });
                    
                } else {
                    alert("HACEN FALTA CAMPOS POR LLENAR");
                }
            } else {
                alert("Necesitas llenar el num serie");
            }
        })


        

            
    } );

        

    function getBancos() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getBancos',
            cache: false,
            success: function(data){
            $("#cve_banco").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getModelosTPV() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getmodelostpv',
            cache: false,
            success: function(data){
            $("#select-modelo_tpv").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getCarriers() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getCarriers',
            cache: false,
            success: function(data){
            $("#select-carrier").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }


    function getInsumos() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getInsumos',
            cache: false,
            success: function(data){
            $("#select-insumo").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getFabricantes() {
        
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getFabricantes',
            cache: false,
            success: function(data){
            $("#almacen-fabricante").html(data);   
            $("#almacen-fabricante").val("0");           
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getConectividad() {
        $("#almacen-connect").html('');
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getConectividad',
            cache: false,
            success: function(data){
            $("#almacen-connect").html(data);
            $("#almacen-connect").val("0");                  
            },
            error: function(error){
                var demo = error;
            }
        });
    }


    function getAplicativo() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getAplicativo',
        cache: false,
        success: function(data){
             
            $("#select-aplicativo").html(data);
            //tableInventario.ajax.reload();
            
        },
        error: function(error){
            var demo = error;
        }
    });
}



    function cleartext() {
        $("#cve_banco").val("0")
        $("#almacen_producto").val("0")
        $("#select-modelo_tpv").val("0")
        $("#select-aplicativo").val("0")
        $("#almacen-no_serie").val("");
        $("#select-estatus").val("0")
        $("#select-estatus_inventario").val("0");
        $("#almacen-idubicacion").val("");
        $("#ubicacionId").val(0);
        $("#almacen-tarima").val("");
        $("#almacen-anaquel").val("");
        $("#almacen-cajon").val("")
        $("#select-carrier").val("0")
        $("#select-insumo").val("0")
        $("#almacen-cantidad").val("");
        $("#almacen-connect").val('0');
    }

    function mostrarComercio(data) {
        $("#cve_banco").val(data.cve_banco)
        $("#comercio").val(data.comercio)
        $("#propietario").val(data.propietario)
        $("#estado").val(data.estado);
        $("#responsable").val(data.responsable)
        $("#tipo_comercio").val(data.tipo_comercio);
        $("#municipio").val(data.ciudad)
        $("#colonia").val(data.colonia)
        $("#afiliacion").val(data.afiliacion)
        $("#telefono").val(data.telefono)
        $("#direccion").val(data.direccion);
        $("#email").val(data.email)
        $("#hora_general").val(data.hora_general)
        $("#hora_comida").val(data.hora_comida)
        getEquipos();
    }




    function getProveedores() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getProveedores',
            cache: false,
            success: function(data){
            $("#almacen-proveedor").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getStatus() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getStatus',
            cache: false,
            success: function(data){
            $("#select-estatus").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        }); 
    }

    function  getStatusInventario() {
        
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getStatusInventario',
            cache: false,
            success: function(data){
            $("#select-estatus_inventario").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        }); 
    }

    function getUbicacion() {
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=getubicacionAlta',
            cache: false,
            success: function(data){
            $("#select-ubicacion").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        }); 
    }
    </script> 
</body>

</html>