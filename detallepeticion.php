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
            <div class="container" class="container">
            <h3>Detalle Peticion</h3>
 
                <div class="row p-3"> 
                    <div class="col-4">
                        <p><h5>Supervisor:</h5>   
                            <span id="txtSupervisor" style="font-size: 14px; font-weight: bold;"></span>
                        </p>
                    </div>   
                    <div class="col-4">
                       <p><h5>Creado Por: </h5>   
                            <span id="txtCreadopor" style="font-size: 14px; font-weight: bold;"></span>
                        </p>
                    </div> 
                    <div class="col-4">
                       <p><h5>Fecha: </h5>   
                            <span id="txtFecha" style="font-size: 14px; font-weight: bold;"></span>
                        </p>
                    </div>
                </div>
               
                <table class="table table-md table-bordered " id="tplDetalle" style="width:100%">
                    <thead>
                        <tr>
                            <th>TECNICO</th>
                            <th>TIPO</th>
                            <th>ESTATUS</th>
                            <th>INSUMO</th>
                            <th>CARRIER</th>
                            <th>CONECTIVIDAD</th>
                            <th>VERSION</th>
                            <th>CANTIDAD</th>   
                            <th>ACCION</th>                         
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>                    
                </table>
                <div class="row p-2">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="no_guia">No Guia:</label>
                            <input class="form-control"  id="no_guia">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="codigo_rastreo">Codigo Rastreo:</label>
                            <input class="form-control"  id="codigo_rastreo">
                        </div>
                    </div>
                </div>	
                <div class="row p-2">
                    
                    <div class="form-group ">
                        <label for="comment">Comentarios:</label>
                        <textarea class="form-control" rows="3" cols="100" id="comentario"></textarea>
                    </div>
                    <!-- <div class="form-group">
                        
                        <input type="text" name="qtyi" id="qtyi">
                    </div>
                    <div class="form-group">
                        
                        <input type="text" name="qtpi" id="qtyp">
                    </div> -->
                    
               
                </div>
                <div class="row p-3">
                    <div class="col-5 mb-2 row">
                        <button type="button" class="btn btn-warning mb-3 " id="btnRegresar">Regresar</button> 
						<button type="button" class="btn btn-success mb-3 " id="btnEnvio">Generar Envio</button>
					</div>
                </div>
				

                <br />
                <input type="hidden" id="peticionId" name="peticionId" value="0">
            </div>
        </main>
        <!-- Modal -->
        <div id="agregarSeries" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">AGREGAR SERIES</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row p-3">
                            <div class="col-3">
                                Total : <span id="sPend" style="font-weight: bold;"></span>
                            </div>
                            <div class="col-3">
                                Cargadas : <span id="sLoad" style="font-weight: bold;">0</span>
                            </div>
                        </div>
                        <div class="row">                                
                                <div class="col-4">
                                <label class="control-label col-sm-2" for="iSerie">PRODUCTO:</label>
                                    <input class="form-control" name="iProducto" id="iProducto" readonly>
                                   
                                </div>  
                                <div class="col-6">
                                <label class="control-label col-sm-2" for="iSerie">SERIE:</label>
                                <input type="text" class="form-control" name="iSerie" id="iSerie" placeholder="Agregar Serie">
                                </div>
                                <div class="col-2 p-4">
                                    <a href="#" class="btn btn-success" id="btnAddSerie" name="btnAddSerie"><i class="fas fa-plus"></i></a>
                                </div> 
                            <table class="table"   id="tplSeries" style="width:100%">
                            <thead>
                                    <tr>
                                        <th>NoSerie</th>
                                        <th>Modelo</th>
                                        <th>Producto</th>
                                        <th>Accion</th>                   
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>   
                            </table>   
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="peticionDetalleId" name="peticionDetalleId" value='0'>
                        <input type="hidden" id="tipoId" name="tipoId">
                        <input type="hidden" id="estatusId" name="estatusId">
                        <button type="button" class="btn btn-success" id="btnGrabarNuevo">CARGAR CAJA</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/main.js"></script>
    <script>
    var tplDetalle,tplSeries;
    $(document).ready(function() {
        
        //GET info from URL
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const peticion = urlParams.get('peticionId');

        var idp = urlParams.get('peticionId');
        //console.log(idp);
        //rollosAlm();
        //cantPeticion(idp);

        loadInfo(peticion);
        loadProducto();

        tplDetalle = $('#tplDetalle').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            order: [[ 0, "ASC" ]],	
            dom: 'lfrtip',	  
            ajax: {
                url: 'modelos/almacen_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getdetallePeticiones',
                    d.peticion = peticion
                }
            },
            columns : [
                { data: 'tecnico'},
                { data: 'tipo'},
                { data: 'estatus'},
                { data: 'insumo'},
                { data: 'carrier'},
                { data: 'conectividad'},
                { data: 'producto'},
                { data: 'cantidad'},
                { data: 'id'}
            ],
            aoColumnDefs: [
                {
                    "targets": [2],
                    "mRender": function (data, type, row){
                        var mostrar;

                        if(data == '3'){
                            mostrar = 'DISPONIBLE-USADO';
                        }else {
                            mostrar = 'DISPONIBLE-NUEVO';
                        }

                        return mostrar;
                    }

                },
                {
                    "targets": [8],
                    "mRender": function ( data,type, row ) 
                    {
                        var btn;

                        if(row.tipoid == '3') 
                        {
                            
                                if(row.cantidad > row.qty)
                                {
                                
                                    btn = "<h6>Cantidad Actual: <a title ='Cantidad' href='#' style='color:#b52424'>"+row.qty+"</a></h6>";
                                }
                                else
                                {
                                    btn = "<h6>Cantidad Actual: <a title ='Cantidad' href='#' style='color:#24b53c'>"+row.qty+"</i></h6>";
                                }  

                        } else {
                            btn = "<a href='#' class='btn btn-success addSeries' data-producto='"+row.producto+"' data-tipo='"+row.tipoid+"' data-id='"+data+"' data-qty='"+row.cantidad+"' >CARGAR</a> ";
                        }

                        return btn;
                    }
                }
            ]
        });

     /*    
        $.ajax({
            type: 'GET',
            url : 'modelos/almacen_db.php',
            data: 'module=getCantPeticion&peticionID='+idp,
            cache: false,
            success: function(data, textStatus, errorThrown)
            {
               
                var info = JSON.parse(data);
                
                $("#qtyi").val(info[0].qty);

                $("#qtyp").val(info[0].cantidad);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                var demo = error();
            }
            }) 
        */

             


        tplSeries = $("#tplSeries").DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            responsive: true,
            searching: false,
            paging: false,
            info: false,
            aoColumnDefs: [
                {
                    "targets": [3],
                    "mRender": function ( data,type, row ) {
                        var btn;

                        btn = "<a href='#' data-id='"+row.nom_serie+"'><span style='color: red;'><i class='fas fa-minus-circle'></i></span></a> ";
                        

                        return btn;
                    }
                }
            ]
        })

        $('#tplSeries tbody').on( 'click', '.fa-minus-circle', function () {
            tplSeries
                .row( $(this).parents('tr') )
                .remove()
                .draw();
            
                var info = tplSeries.page.info();
            $("#sLoad").html( info.recordsTotal );
        } );

        $("#btnRegresar").on('click',function() {
            window.location.href = "peticiones.php";
        })

        $(document).on("click",".addSeries", function() {
            tplSeries.clear()
                .draw();
            var totalSeries = $(this).data('qty');
            var tipo = $(this).data('tipo');
            var estatus = $(this).data('estatus');
            var id = $(this).data('id');
            var producto = $(this).data('producto');
            $("#tipoId").val(tipo);
            $("#estatusId").val(estatus);
            $("#iProducto").val(producto);
            $("#sPend").html(totalSeries);
            $("#peticionDetalleId").val(id);
            getSeriesPeticion(tplSeries,id);
            $("#agregarSeries").modal({show: true, backdrop: false, keyboard: false});

        })


        $("#no_guia").on("change",function(){
	    var guia = $(this).val();
	     if(guia.length > 0){
	         result = existeGuia(guia)
	      }
	    })

        $("#codigo_rastreo").on("change",function(){
	    var codigor = $(this).val();
	     if(codigor.length > 0){
	         result = existeRastreo(codigor)
	      }
	    })

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                validarSerie( $("#iSerie").val(),tplSeries )
            }
        });

        $("#btnAddSerie").on('click', function() {
            validarSerie( $("#iSerie").val(),tplSeries );
        })

       

        $("#btnEnvio").on("click", function() 
        {
            
            if( $("#no_guia").val().length > 0 && $("#codigo_rastreo").val().length > 0 ) 
            {            
                                        $.ajax({ 
                            type: 'POST',
                            url : 'modelos/almacen_db.php',
                            data: 'module=generarEnvio&peticionId='+ peticion +"&no_guia="+ $("#no_guia").val() + "&codigo_rastreo="+ $("#codigo_rastreo").val(),
                            cache: false,
                            success: function(data)
                            {
                                $("#btnEnvio").attr("disabled",true);
                                var info = JSON.parse(data);
                                console.log(info);
                                if(info.enviado == '0' || info.enviado == '9')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: info.mensaje
                                        
                                    })
                                    
                                }
                                else if(info.enviado == '2')
                                {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando...',
                                        text: 'Generando envío'
                                        
                                    })
                                    
                                }
                                else
                                {
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Exito',
                                    text: 'Se generó el Envío' 
                                    }) .then((result) => {

                                    if (result.isConfirmed) {
                                    //window.location.href = "peticiones.php";
                                    }
                                    })  
                                }


                            },
                                error: function(error){
                                var demo = error;
                                }
                            })     
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Es necesario ingresar la Guía y Código de Rastreo',
                    footer: 'Volver a intentar'
                })
            }
                        
        })

        $("#btnGrabarNuevo").on("click", function() {
            var stat = 1;
            
            if( $("#sPend").html() != $("#sLoad").html()  ) {

                Swal.fire({
                    title: 'La peticion no esta completa deseas:',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Grabar`,
                    denyButtonText: `Ajustar`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        
                        stat= 1;

                    } else if (result.isDenied) {
                        stat= 0;
                    } 
                })

            } 
            
            if( stat == 1) {

                var data = tplSeries.rows().data();
                var datos=[];

                $.each(data, function(index,value) {
                    
                    var valueToPush = new Object();
                    valueToPush["NoSerie"] = value[0];
                    valueToPush["Modelo"] = value[1];
                    valueToPush["Producto"] = value[2];
                    datos.push(valueToPush);
                })

                console.log( JSON.stringify(datos) );

                //id detalle 
                var detalleId = $("#peticionDetalleId").val();
                var detalleSeries = JSON.stringify(datos);

                $.ajax({ 
                    type: 'POST',
                    url : 'modelos/almacen_db.php',
                    data: 'module=grabardetallePeticion&id='+ detalleId +'&noseries='+ detalleSeries,
                    cache: false,
                    success: function(data){
                    
                        $("#agregarSeries").modal("hide");
                        $("#peticionDetalleId").val('');
                    },
                    error: function(error){
                        var demo = error;
                    }
                })

            }

            

        })


    })

    function existeRastreo(codigo)
    {
        $.ajax({
            type: 'POST',
            url: 'modelos/almacen_db.php',
            data: 'module=existeRastreo&codigo='+codigo,
            cache: false,
            success: function(data)
            {
                var exist = JSON.parse(data).length;

                if(exist == 0)
                {
                    
                }
                else{
                    $.toaster({
                    message: 'YA EXISTE EL CODIGO DE RASTREO',
                    title: 'Aviso',
                    priority: 'danger'
                })
                }
               
            },
            error: function(error){
                var demo = error;
            }
        })
    }

    function existeGuia(guia)
    {
        result = 
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php',
            data: 'module=existeGuia&guia='+guia,
            cache: false,
            success: function(data)
            {
                var exist = JSON.parse(data).length;
               
                if(exist == 0)
                {
                    
                } else
                {
                    $.toaster({
                        message: 'YA EXISTE LA GUIA INGRESADA',
                        title: 'Aviso',
                        priority : 'danger'
                    });
                }
    
                
                
            },
            error: function(error){
                var demo = error;
            }
        })
    }

    function updateTotal(tbl) {
        var cargadas = tbl.page.info();
        var total = parseInt( $("#sPend").val() );

        return total;

    }   

    function totalDt(tbl) {
        var cargadas = tbl.page.info();

        return cargadas.recordsTotal;
    }

    function getSeriesPeticion(tbl,id) {

        
        $.ajax({ 
            type: 'POST',
            url : 'modelos/almacen_db.php',
            data: 'module=getNoSeriePeticion&id='+id ,
            cache: false,
            success: function(data){
                if(data.length > 0) {
                    var info= JSON.parse(data);
                

                    $.each(info, function(index,detalle) {
                        tbl.row.add( [ detalle.NoSerie,detalle.Modelo,detalle.Producto, 1 ] );
                    })

                    tbl.draw();  
                    $("#sLoad").html( totalDt(tbl) );
                }
            },
            error: function(error){
                var demo = error;
            }
        })		
    }

    function loadInfo(peticionId) {

        $.ajax({ 
                type: 'POST',
                url : 'modelos/almacen_db.php',
                data: 'module=detallePeticion&peticionId='+peticionId ,
                cache: false,
                success: function(data){
                    var info= JSON.parse(data);

                    $("#txtSupervisor").html(info.supervisor);
                    $("#txtCreadopor").html(info.creadopor);
                    $("#txtFecha").html(info.fecha_creacion);
                    if(info.IsActive == '1') {
                        $("#btnEnvio").attr("disabled",true);
                    }
                
                },
                error: function(error){
                    var demo = error;
                }
        })		
    }

    
    function loadProducto() {

        $.ajax({ 
                type: 'POST',
                url : 'modelos/almacen_db.php',
                data: 'module=getProducto' ,
                cache: false,
                success: function(data){
                    
                    $("#iProducto").html(data);

                },
                error: function(error){
                    var demo = error;
                }
        })		
    }

    function validarSerie(serie,tbl) {
        var producto = $("#iProducto").val();

        if( producto != '0') {
        
            $.ajax({ 
                type: 'POST',
                url : 'modelos/almacen_db.php',
                data: 'module=validarSerie&serie='+serie+'&tipo='+$("#tipoId").val()+'&estatus='+$("estatusId").val(),
                cache: false,
                success: function(data){
                    var info= JSON.parse(data);
                    console.log(info);
                    var loaded = parseInt($("#sLoad").html());
                    var pend = parseInt($("#sPend").html());

                    if(info.total == "1") {
                        pend = pend - 1 ; //loaded
                        loaded = loaded + 1 ;
                        
                        tbl.row.add( [ serie,info.modelo,producto, 1 ] ).draw();
                        var total = tbl.page.info();
              
                        $("#sLoad").html( total.recordsTotal );
                        $("#iSerie").val('');
                         

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Esta serie ya no esta en el almacen o no es del Tipo Seleccionado',
                            footer: 'Favor de contactar con almacenista'
                        })
                    }

                    console.log(info);
                
                },
                error: function(error){
                    var demo = error;
                }
            })

        } else {

            Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Es necesario poner el Producto',
                    footer: 'Volver a intentar'
                })
        }	
    }

    function rollosAlm()
    {
            var rollos;
            $.ajax({
                type: 'GET',
                url : 'modelos/almacen_db.php',
                data: 'module=getCantidadRollos',
                cache: false,
                success: function(data, textStatus, errorThrown)
                {
                    var info = JSON.parse(data);

                    var rollos = info[0].cantidad;
                    

                    //console.log(rollos);
                    
                },
                error: function()
                {

                }
            });
            return rollos;
    }  
    
    function cantPeticion(idp)
    {
        var cantidad;
        $.ajax({
            type: 'GET',
            url : 'modelos/almacen_db.php',
            data: 'module=getCantPeticion&peticionID='+idp,
            cache: false,
            success: function(data, textStatus, errorThrown)
            {
               
                var info = JSON.parse(data);

                var cantidad = info[0].cantidad;

                //console.log(cantidad);
                
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                var demo = error();
            }
            });
            return cantidad; 
    }

    </script> 
</body>

</html>