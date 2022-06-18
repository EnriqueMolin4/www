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
            <div class="row"><h3>Incidencias ODT</h3>
			
            </div>
            <br>
                
                <div class="table-responsive">
                        <table id="tblIncidencias"  class="table table-responsive table-md table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="20%">ODT</th>
                                <th>Tipo</th>
                                <th width="20%">Comentario Call Center</th>
                                <th width="20%">Comentario Solución</th>
                                <th width="10%">Fecha Alta</th>
                                <th width="10%">Fecha Solución</th>
                                <th width="10%">Estatus</th>
                                <th width="10%">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            
            
            <input type="hidden" id="bancoId" value="0">
            <!-- <button class="btn btn-success" id="btnNewBanco">Nuevo Banco</button>-->
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showIncidencias" role="document" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document" style="max-width: 950px!important;" >
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Incidencias de ODT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="estatus1" style="display: none;">
                            <div class="col-md-4 offset-md-4">
                                <label for="solucionVobo">Guardar solución con VoBo</label>
                                <a href="#" id="solucionVobo" class="solucionVobo"><i class="fas fa-toggle-off fa-2x" style="color:#3C95D4"></i></a>
                            </div>
                        </div>
                        <div class="row" id="estatus0" style="display: none;">
                            <div class="col-md-4 offset-md-4">
                                <label for="solucionVobo0">Quitar solucion con VoBo</label>
                                <a href="#" id="solucionVobo0" class="solucionVobo0"><i class="fas fa-toggle-on fa-2x" style="color:#3C95D4"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                             
                                    <table id="detalleIncidencia" class="table nowrap table-striped" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Incidencia</th>
                                                <th>Estatus</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                
                                <br>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col">
                                    <label class="form-check-label" for="textoSolucion">Comentarios</label>
                                    <textarea class="form-control" name="textoSolucion" id="textoSolucion" rows="5"></textarea>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="estatusVobo" class="estatusVobo" value="0">
                        <input type="hidden" id="incidenciaId" name="incidenciaId" value="0">
                        <button type="button" class="btn btn-primary" id="btnGuardarSolucion">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
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
    <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> -->
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.rotate.1-1.js"></script>
    <script>
    var tblIncidencias, tblDetail;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "bancoslink")    

            cambiarBtn();

            tblIncidencias = $('#tblIncidencias').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "ASC" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
                    order: [[ 0, "desc" ]],
                    ajax: {
                        url: 'modelos/eventos_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getIncidenciasEventos'
                        }
                    },
                    columns : [
                        { data: 'odt'},
                        { data: 'tipo'},
                        { data: 'comentario_cc'},
                        { data: 'comentario_solucion'},
                        { data: 'fecha_alta' },
                        { data: 'fecha_solucion' },
                        { data: 'estatus'},
                        { data: 'id'}
                        
                    ],
                    aoColumnDefs: [
                        
                        {
                            "targets": [1],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(data == 'e'){
                                    boton =  'Evidencia'
                                } else {
                                    boton = 'Inventario';
                            }

                                return boton;
                            }
                        },
                        {
                            "targets": [6],
                             "mRender": function (data, type, row){
                                var status = "";

                                if (row.estatus == '1') 
                                {
                                    status = 'Activa';
                                } else {
                                    status = 'Solucionado';
                                }
                                return status;
                             }
                        },
                        {
                            "targets": [7],
                             "mRender": function (data, type, row){
                                return '<a href="#" class="btn btn-primary verDetalleIncidencia" data="'+data+'">Detalle</a>';
                             }
                        }    
                    
                    ],
                    fixedColumns: true,
                    rowCallback: function(row,data,index,full){
                        var col = this.api().column(6).index('visible');
                        if (data.estatus == '1') 
                        {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('font-weight', 'bold');
                            $('td', row).eq(col).css('background-color', '#eb6060');
                            
                        }
                        if(data.estatus == '0')
                        {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('font-weight', 'bold');
                            $('td', row).eq(col).css('background-color', '#7cd992');
                        }

                    }
                });

            

            //

            
                $(document).on("click",".verDetalleIncidencia", function() {
                    var index = $(this).parent().parent().index() ;
                    var data = tblIncidencias.row( index ).data()
                    $("#incidenciaId").val(data.id);
                    $("#estatusVobo").val(data.vobo);
                    //$("#cve").val(data.cve);
                    //$("#bancoId").val( $(this).data('id') );
                    $("#showIncidencias").modal("show");
                    //tblDetail.destroy();
                    tblDetail.ajax.reload();
                    tblDetail.columns.adjust();
                    var voboStat = document.getElementById("estatusVobo").value;
                    if ( voboStat == "0" ) 
                    {
                        $("#estatus1").show();
                        $("#estatus0").hide();
                    }else
                    {
                        $("#estatus0").show();
                        $("#estatus1").hide();
                    }
                })


                $('#showIncidencias').on('show.bs.modal', function(){   

                    $(this).find('.modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });

                    tblDetail = $('#detalleIncidencia').DataTable({
        
                        language: {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        processing: true,
                        serverSide: true,
                        searching: false,
                        order: [
                            [0, "ASC"]
                        ],
                        dom: 'lfrtiBp',
                        buttons: [
                            'pdf',
                            'excelHtml5'
                        ],

                        ajax: {
                            url: 'modelos/eventos_db.php',
                            type: 'POST',
                            data: function(d) {
                                d.module = 'getDetalleIncidencia',
                                d.inId = $("#incidenciaId").val()
                            }
                        },
                        columns: [{
                                data: 'subtipo_incidencia'
                            },
                            {
                                data: 'estatus'
                            },
                            {
                                data: 'id'
                            }
                            
                        ],
                        aoColumnDefs: [
                        {
                            "targets":[2],
                            "mRender": function(data, type, row){

                                if(row.estatus == '1'){
                                    boton =  '<a href="#" class="delIncidencia" data="'+row.id+'"><i class="fas fa-toggle-off fa-2x" style="color:#eb6060"></i></a>';
                                } else {
                                    boton = '<a href="#" class="addIncidencia" data="'+row.id+'"><i class="fas fa-toggle-on fa-2x" style="color:#7cd992"></i></a>';
                            }

                                return boton;
                            }
                        },
                        {
                            "targets":[1],
                            "mRender": function(data, type, row){

                                if (row.estatus == '1') 
                                {
                                    aviso = 'Activa';
                                }else 
                                {
                                    aviso = 'Ya se atendió';
                                }
                                return aviso;
                            }
                        }
                        ]

                    });


                });


                $('#showIncidencias').on('hidden.bs.modal', function (e) {
                  $("#detalleIncidencia").dataTable().fnDestroy();
                })

               

                $('#detalleIncidencia tbody').on('click', 'tr a.addIncidencia', function () {
                    var index = $(this).parent().parent().index() ;
                    var data = tblDetail.row( index ).data()
                    var id = $(this).attr('data');
                    var id_inc = $("#incidenciaId").val();
                    //console.log(id);
                     console.log(id_inc);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/eventos_db.php', // call your php file
                        data: { module:'addIncidencia', id: id},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                    message: 'La incidencia vuelve a estar activa',
                                    title: 'Aviso',
                                    priority : 'warning'
                                }); 
                            tblDetail.ajax.reload();
                            $('#tblIncidencias').DataTable().ajax.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                    }
                    });
                
                });

                $('#detalleIncidencia tbody').on('click', 'tr a.delIncidencia', function () {
                    var index = $(this).parent().parent().index() ;
                    var data = tblDetail.row( index ).data()
                    var id = $(this).attr('data');
                    var id_inc = $("#incidenciaId").val();
                    //console.log(id);
                    console.log(id_inc);
                    $.ajax({
                        type: 'POST',
                        url: 'modelos/eventos_db.php', // call your php file
                        data: { module:'delIncidencia', id: id, inc_id : id_inc},
                        cache: false,
                        success: function(data, textStatus, jqXHR){
                            var info = JSON.parse(data);
                            $.toaster({
                                    message: 'Incidencia atendida',
                                    title: 'Aviso',
                                    priority : 'success'
                                });  
                            tblDetail.ajax.reload();
                            $('#tblIncidencias').DataTable().ajax.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(data)
                    }
                    });
                
                });


                $("#btnGuardarSolucion").on("click", function()
                {
                    var id_inc = $("#incidenciaId").val();
                    var comentSolucion = $("#textoSolucion").val();
                    if ( $("#textoSolucion").val().length > 0 ) 
                    {
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/eventos_db.php',
                            data: {module:'solucionIncidencia',comentario: comentSolucion, id: id_inc},
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                console.log(data);

                                $.toaster({
                                    message: 'Se guardó la información con éxito',
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                                $("#showIncidencias").modal("hide")
                                $('#tblIncidencias').DataTable().ajax.reload();
                            }
                        })
                    }
                    else 
                    {
                        $.toaster({
                            message : 'Ingresa el comentario de solución de incidencia',
                            title: 'Aviso',
                            priority: 'warning'
                        })
                    }
                });

                $("#solucionVobo").on("click", function()
                {
                    //Hacer que se pongan como solucionados todos las incidencias 
                    var idIn = $("#incidenciaId").val();
                    var comentSolucion = $("#textoSolucion").val();
                    $.ajax({
                            type: 'POST',
                            url: 'modelos/eventos_db.php',
                            data: {module:'voboIncidencia', idIn: idIn, comentario:comentSolucion},
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                console.log(data);
                                //changeIcon();
                                $.toaster({
                                    message: 'Cambio de estatus de incidencia por VoBo',
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                                $("#detalleIncidencia").DataTable().ajax.reload();
                                $('#tblIncidencias').DataTable().ajax.reload();
                                
                            }
                        })
                    
                })

                $("#solucionVobo0").on("click", function()
                {
                    //Hacer que se pongan como solucionados todos las incidencias 
                    var idIn = $("#incidenciaId").val();
                    var comentSolucion = $("#textoSolucion").val();
                    $.ajax({
                            type: 'POST',
                            url: 'modelos/eventos_db.php',
                            data: {module:'voboIncidenciaBack', idIn: idIn, comentario:comentSolucion},
                            cache: false,
                            success: function(data, textStatus, jqXHR){
                                console.log(data);
                                //changeIcon2();
                                $.toaster({
                                    message: 'Las incidencias vuelven a estar activas',
                                    title: 'Aviso',
                                    priority: 'success'
                                });
                                $("#detalleIncidencia").DataTable().ajax.reload();
                                $('#tblIncidencias').DataTable().ajax.reload();
                                
                            }
                        })
                    
                })

 
        } );

        function getProveedor() {

            $.ajax({
                type: 'POST',
                url: 'modelos/catalogosxmodelos_db.php', // call your php file
                data: { module: 'getProveedor' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#proveedor").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        } 

        function getConectividad() {

            $.ajax({
                type: 'POST',
                url: 'modelos/catalogosxmodelos_db.php', // call your php file
                data: { module: 'getConectividad' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#conectividad").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function cleartext() {  
            $("#modelo").val("");
            $("#no_largo").val("");
            $("#clave_elavon").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#conectividad").val("0");
            $("#correo").val("")
            $("#proveedor").val("0");

        }

        function cambiarBtn()
        {
            const estatusVobo1 = document.getElementById('solucionVobo');
            const estatusVobo0 = document.getElementById('solucionVobo0');

            estatusVobo1.addEventListener('click', function(){
                $("#estatus1").hide();
                $("#estatus0").show();
            });

            estatusVobo0.addEventListener('click', function(){
                $("#estatus1").show();
                $("#estatus0").hide();
            });


        }

    </script> 
  
</body>

</html>