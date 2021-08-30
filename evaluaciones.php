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
                <div class="row">
                    <div class="col-md-5"><h3>Evaluaciones</h3></div>
                </div>

                    <table id="evaluaciones"  class="table  table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Nombre Evaluacion</th>
                            <th>Descripción</th>
                            <th>Fecha de Creación</th>
                            <th>Nombre Archivo</th>
                            <th>Modificado por</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre Evaluacion</th>
                                <th>Descripción</th>
                                <th>Fecha de Creación</th>
                                <th>Nombre Archivo</th>
                                <th>Modificado por</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                    </table>
                    

                <!-- MODAL PREGUNTAS -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showInfo" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle Evaluación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                             
                            <table id="tblPreg"  class="table table-md table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "400px">Preguntas</th>
                                        <th width = "100px">Acción</th>
                                                                     
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" id="evaluacionId" name="evaluacionId" value="0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- MODAL OPCIONES DE LAS PREGUNTAS-->
            <div class="modal fade" tabindex="-1" role="dialog" id="showOptions" data-backdrop="static" data-keyboard="false" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Opciones</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" value="0" id="pregunta" name="pregunta" readonly>
                        </div>

                        <div class="modal-body">
                            <table id="tblOpciones" class="table table-md" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Correcta</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="text" id="preguntaId" name="preguntaId" value="0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
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
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript">
    var tblEvaluaciones, tblPreguntas, tblOpciones;
$(document).ready(function() {

    tblEvaluaciones = $('#evaluaciones').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        lengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "Todos"]
        ],
        order: [
            [0, "ASC"]
        ],
        dom: 'lfrtip',
        ajax: {
            url: 'modelos/evaluacion_db.php',
            type: 'POST',
            data: function(d) {
                d.module = "getEvaluacionesList"
            }
        },
        columns: [{
                data: 'nombre'
            },
            {
                data: 'descripcion'
            },
            {
                data: 'fecha_creacion'
            },
            {
                data: 'archivo'
            },
            {
                data: 'usuario'
            },
            {
                data: 'id'
            }
        ],
        aoColumnDefs: [{
            "targets": [5],
            "mRender": function(data, type, row) {
                var boton = '<a href="#" title="Ver Preguntas" class="verPreguntas" data="' + data + '"><i class="fas fa-info-circle fa-2x " style="color:#187CD0"></i>';

                return boton;
            }
        }]
    });


    tblPreguntas = $('#tblPreg').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        searching: false,
        paging: true,
        order: [
            [0, "ASC"]
        ],
        lengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "Todos"]
        ],

        ajax: {
            url: 'modelos/evaluacion_db.php',
            type: 'POST',
            data: function(d) {
                d.module = 'getPreguntasInfo'
                d.id = $("#evaluacionId").val()
            }
        },
        columns: [{
                data: 'pregunta'
            },
            {
                data: 'id'
            }
        ],
        aoColumnDefs: [{
            "targets": [1],
            "mRender": function(data, type, row) {
                var boton = '<a href="#" title="Ver Opciones de Respuesta" class="verOpciones" data="' + data + '"><i class="fas fa-info-circle fa-2x" style="color:#212121"></i>';

                return boton;
            }
        }]
    });

    tblOpciones = $('#tblOpciones').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        searching: false,
        paging: true,
        order: [
            [0, "ASC"]
        ],
        lengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "Todos"]
        ],

        ajax: {
            url: 'modelos/evaluacion_db.php',
            type: 'POST',
            data: function(d) {
                d.module = 'getOpciones',
                d.idp = $("#preguntaId").val()
            }
        },
        columns: [{
                data: 'respuesta'
            },
            {
                data: 'correcta'
            },
            {
                data: 'estatus'
            }

        ]

    });

    $(document).on("click", ".verPreguntas", function() 
    {
        var index = $(this).parent().parent().index();
        var data = tblEvaluaciones.row(index).data();

        console.log(index)
        console.log(data)

        $("#evaluacionId").val(data.id);
        var eid = $("#evaluacionId").val();
        if (eid > 0) {
            $("#showInfo").modal("show");

            tblPreguntas.ajax.reload();
        }



    });

    $(document).on("click", ".verOpciones", function() 
    {
        var index = $(this).parent().parent().index();
        var data = tblPreguntas.row(index).data();

        console.log(index);
        console.log(data);

        $("#preguntaId").val(data.id);
        $("#pregunta").val(data.pregunta);

        
        $("#showOptions").modal("show");
       

        

    tblOpciones.ajax.reload();


    })

});


    </script>
</body>

</html>