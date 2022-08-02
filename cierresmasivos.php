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
            
            <div class="container-fluid p-2">
                    <h3>Cierre Masivos de Eventos</h3>
            
                    <h5>Busqueda</h5>
                    <div class="row">
                        <div class="col">
                            <label for="fechaVen_inicio" class="col-form-label-sm">Vencimiento Desde</label>
                            <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_inicio" aria-describedby="fechaVen_inicio" value="<?php echo date("Y-m-d", strtotime("-5 days", strtotime(date("Y-m-d")) )); ?>">
                        </div>
                        <div class="col">
                            <label for="fechaVen_fin" class="col-form-label-sm">Vencimiento Hasta</label>
                            <input type="text" class="form-control form-control-sm searchEvento" id="fechaVen_fin" aria-describedby="fechaVen_fin" value="<?php echo date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d")) )); ?>">
                        </div>
                        <div class="col p-4">
                            <a href="#" class="btn btn-success" id="btnCerrar">Cierre Masivo</a>
                        </div>
                                
                    </div>  
                    <br />
                    <div class="table-responsive">
                        <table id="eventos"  class="display table-responsive table table-md table-bordered"  cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>ODT</th>
                                    <th>Afiliación | Folio</th>
                                    <th>CVE</th>
                                    <th>Comercio | Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha de Alta</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Días Vencidos</th>
                                    <th>Fecha Cierre</th>
                                    <th>Imagenes Cargadas</th>
                                    <th>Técnico</th>
                                    <th>Estatus</th>
                                    <th>Estatus Servicio</th>
                                    <th>Accion</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                        
                            </tbody>
                            <tfoot>
                        
                            </tfoot>
                        </table>
                    </div>
                
                 
                    <input type="hidden" id="tipo_user" name="tipo_user" value="<?php echo $_SESSION['tipo_user']; ?>">

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

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
	<script src="js/zoomifyc.min.js" ></script> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/main.js"></script>
    <script>
    var tableEventos;
    $(document).ready(function() {
        ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "cierresmasivoslink")

        $("#fechaVen_inicio").datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });

        $("#fechaVen_fin").datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });

        
 
        fecha_hoy = moment().format('YYYY-MM-DD');

        tableEventos = $('#eventos').DataTable({
            "responsive": true,
            order: [
                [8, "desc"]
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            order: [
                [6, "ASC"]
            ],
            dom: 'lfrtiBp',
            buttons: [
                {
                charset: 'utf-8',
                extension: '.csv',
                bom: true,
                extend: 'csv',
                title: 'Eventos_' + fecha_hoy,
                exportOptions: {
                    orthogonal: 'sort',
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                customizeData: function(data) {
                    for (var i = 0; i < data.body.length; i++) {
                        for (var j = 0; j < data.body[i].length; j++) {
                            data.body[i][j] = '\u200C' + data.body[i][j];
                        }
                    }
                }
            }],
            ajax: {
                url: 'modelos/eventos_db.php',
                type: 'POST',
                data: function(d) {
                    d.module = 'getEventosCerrar',
                        d.fechaVen_inicio = $("#fechaVen_inicio").val(),
                        d.fechaVen_fin = $("#fechaVen_fin").val()
                }
            },
            columns: [{
                    data: 'odt'
                },
                {
                    data: 'afiliacion'
                },
                {
                    data: 'cveBancoNombre'
                },
                {
                    data: 'comercio'
                },
                {
                    data: 'servicio'
                },
                {
                    data: 'fecha_alta'
                },
                {
                    data: 'fecha_vencimiento'
                },
                {
                    data: 'dias',
                },
                {
                    data: 'fecha_cierre'
                },
                {
                    data: 'totalImg'
                },
                {
                    data: 'tecnico'
                },
                {
                    data: 'nombreEstatus'
                },
                {
                    data: 'nombreEstatusServicio'
                },
                {
                    data: 'id'
                }

            ],
            aoColumnDefs: [{
                    "targets": [0],
                    "width": "15%",

                },
                {
                    "targets": [1],
                    "visible": $("#tipo_user").val() == 'callcenter' ? false : true

                },
                {
                    "targets": [13],
                    "mRender": function(data, type, row) {
                        var btnALL = '';
                        var btnCerrar = '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+row.odt+'"></div>';
                        
                        return btnCerrar;
                    }
                }
            ],
            fixedColumns: true,
            rowCallback: function(row, data, index, full) {
                if ($("#tipo_user").val() != 'VO') {
                    fnShowHide(5, true)
                    var fechacompromiso = moment(data.fecha_vencimiento)
                    var now = moment();
                    var diff = moment.duration(fechacompromiso.diff(now));
                    var col = this.api().column(5).index('visible');
                    /*console.log('Evento '+fechacompromiso.format('YYYY-MM-DD'));
                    console.log('HOY '+now.format('YYYY-MM-DD'));
                    console.log('Diferencia Dias '+ fechacompromiso.diff(now,'days'))
                    console.log('Diferencia Horas '+ fechacompromiso.diff(now,'hours'))
                    console.log('dias '+diff.days())
                    console.log('horas '+diff.hours())
                    console.log(fechacompromiso.isBefore(now) );*/
                    if (fechacompromiso.isAfter(now)) {
                        if (fechacompromiso.diff(now, 'hours') > 24 && data.nombreEstatus != 'Exito') {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#00cc66');
                        } else if (fechacompromiso.diff(now, 'hours') == 24 && data.nombreEstatus != 'Exito') {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ff6600');
                        } else if (fechacompromiso.diff(now, 'hours') <= 24) {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ffff00');
                        } else if (fechacompromiso.diff(now, 'hours') <= 5) {
                            $('td', row).eq(col).css('color', '#000');
                            $('td', row).eq(col).css('background-color', '#ae2b2b');
                        }
                    }

                    if (fechacompromiso.isBefore(now) && data.nombreEstatus != 'Exito') {

                        $('td', row).eq(col).css('color', '#000');
                        $('td', row).eq(col).css('background-color', '#ae2b2b');

                    }
                    //Semáforo no aplica para eventos cerrados
                    if (data.nombreEstatus == 'Cerrado') {
                        $('td', row).eq(col).css('color', '#3F4044');
                        $('td', row).eq(col).css('background-color', '#fff');
                    }

                } else {
                    fnShowHide(5, false)
                }
            }
        });

        $("#fechaVen_inicio").on("change",function() {
            tableEventos.ajax.reload()
        })

        $("#fechaVen_fin").on("change",function() {
            tableEventos.ajax.reload()
        })

        $("#btnCerrar").on("click",function() {
            var dtAsig = tableEventos;
            var data = dtAsig.rows().data();
            var counter = 0;

            $.each(data, function(index,value) {
                if( dtAsig.cell(index,13).nodes().to$().find('input').is(":checked") ) {
                    counter++;

                    //sendInfoBanco(value.odt);
           

                    $.toaster({
                        message: counter,
                        title: 'Aviso',
                        priority : 'success'
                    }); 
                }
            })

            tableEventos.ajax.reload();
        })
    })

    function fnShowHide(colId, status) {
        var table = $('#eventos').DataTable();
        table.column(colId).visible(status);
    }

    function sendInfoBanco(odt) {

        $.ajax({
            type: 'POST',
            url: 'conector/postODT.php', // call your php file
            data: 'odt='+odt,
            cache: false,
            dataType: "json",
            success: function(data) {
                var msg = 'Se envio la odt '+odt+' con Exito';

        
            
                if(data.evento.result.status == '400') 
                {
                    msg = " LA ODT "+odt+" presenta algunos campos erroneos \n"
                    $.each(data.evento.result.messages, function(index,message) {
                            msg += message;
                    })

            
                    $.toaster({
                        message: msg,
                        title: 'Opps..',
                        priority : 'danger'
                    }); 

                    
                } else if(data.evento.result == '201') {
                    
                    $.toaster({
                        message: msg,
                        title: 'Opps..',
                        priority : 'success'
                    }); 

                } else if (data.evento.result.status == 410 ) {
                    
                    msg = " LA ODT presenta algunos campos erroneos \n"
                    $.each(data.evento.result.messages, function(index,message) {
                        msg += message+" \n ";
                    })

                    $.toaster({
                        message: msg,
                        title: 'Opps..',
                        priority : 'danger'
                    }); 

                } else if (data.evento.result.status == 404 ) {
                    
                    msg = " LA ODT presenta algunos campos erroneos \n"
                    $.each(data.evento.result.messages, function(index,message) {
                        msg += message+" \n ";
                    })

                    $.toaster({
                        message: msg,
                        title: 'Opps..',
                        priority : 'danger'
                    }); 

                } else {
                    
           
                    $.toaster({
                        message: msg,
                        title: 'Opps..',
                        priority : 'warning'
                    }); 
                } 

               

            },
            error: function(error){
                 
                $.toaster({
                    message: error.responseText,
                    title: 'Opps..',
                    priority : 'warning'
                }); 
            }
        })
    }
    </script>

</body>

</html>