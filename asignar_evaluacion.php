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
                <h3>Asignar Evaluación</h3>
                    
                <div class="row mb-4">
                    <div class="col">
                        
                            <label class="col-form-label-sm" for="tecnicos">Tecnico (s)</label><br>
                            <select hidden name="tecnicos[]" id="tecnicos" class="custom-select form-control-sm" multiple></select>
                      
 
                    </div>

                    <div class="col">
                        
                        
                            <label class="col-form-label-sm" for="evaluacionList">Evaluación</label>
                                <select style="text-align: center;text-align-last: center;-moz-text-align-last: center;" name="evaluacionList" id="evaluacionList" class="form-control form-control-sm">
                                        <option value="0" selected>Seleccionar</option>
                                </select>
                        
                    </div>
                </div>
                    <hr>
                    <br>
                    
                    <div class="row">
                        <div class="col-4">
                            <button type="button" class="btn btn-success" id="btnAsignarEv">Asignar</button>
                        </div>
                    </div>
                     </br>
                     <!-- <button type="button" class="btn btn-primary asignar" value="0" name="btnAsignar" id="btnAsignar">Asignar Evaluaciones</button>
                    <hr> -->
                    <div class="table-responsive">
                        <table id="evaluacion_asig" class="table table-bordered table-responsive" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="300px">Nombre Técnico</th>
                                    <th width="300px">Evaluación</th>
                                    <th width="300px">Inicio</th>
                                    <th width="200px">Fin</th>
                                    <th width="200px">Accion</th>

                                </tr>
                            </thead>
                                <tbody>
                                    
                                </tbody>
                            
                            </table>
                    </div>
                    
                    </div>
            </div> 
        </main>
        
</div>
    <!-- using online scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
       crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
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
<script src="js/main.js"></script>
<script src="js/evaluaciones.js"></script> 
<script src="js/bootstrap-multiselect.min.js"></script>
<script type="text/javascript">
var tblevaluacionAsig;
$(document).ready(function() {
    fecha_hoy = moment().format('YYYY-MM-DD');
    tblevaluacionAsig = $('#evaluacion_asig').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            order: [[ 1, "asc" ]],
            dom: 'lfrtiBp',
            buttons: [{
                extend: 'excel',
                title: 'EvaluacionAsignada_' + fecha_hoy,
                exportOption: {
                    orthogonal: 'sort',
                    columns:[0,1,2,3]
                },
                customizeData: function(data){
                    for (var i = 0; i < data.body.length; i++){
                        for (var j = 0; j < data.body[i].length; j++){
                            data.body[i][j] = '\u200C' + data.body[i][j];
                        }
                    }
                }
            }],
            ajax: {
                url: 'modelos/evaluacion_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTableEvAs'
                }
            },
            columns : [
                { data: 'tecnico'},
                { data: 'nombre' },
                { data: 'inicio' },
                { data: 'fin' } 
            ]
            
    })



$("#btnAsignarEv").on('click', function() {
    var Tecnicos = JSON.stringify($("#tecnicos").val());
    var Evaluaciones = JSON.stringify($("#evaluacionList").val());

    if ($("#tecnicos").val == "0" || $("#evaluacionList").val() == "0") {
        $.toaster({
            message: 'Debes seleccionar en ambas listas',
            title: 'Aviso',
            priority: 'warning'
        });
    } else {
        $.ajax({
            type: 'POST',
            url: 'modelos/evaluacion_db.php',
            data: {
                module: 'guardar_asignaciones',
                tecnicos: Tecnicos,
                evaluaciones: Evaluaciones
            },
            cache: false,
            success: function(data, textStatus, jqXHR) {
                var info = JSON.parse(data);

                $.toaster({
                            message: info.message,
                            title: 'Aviso',
                            priority : 'success'
                        });    
                cleartext()

                tblevaluacionAsig.ajax.reload();
            
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)

                $.toaster({
                    message: 'Error con la asignación',
                    title: 'Aviso',
                    priority: 'danger'
                });
            }
        });


        $.ajax({
            type: 'POST',
            url: 'modelos/evaluacion_db.php',
            data: {
                module: 'inicio_evaluacion'
            },
            cache: false,
            success: function(data, textStatus, jqXHRj) {

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        })

        $.ajax({
            type: 'POST',
            url: 'modelos/evaluacion_db.php',
            data: {
                module: 'fin_evaluacion'
            },
            cache: false,
            success: function(data, textStatus, jqXHRj) {

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        })
    }

})



})

function cleartext() {
//$('#tecnicos').multiselect('refresh');
$('#tecnicos').val('').multiselect('refresh');
//$("#evaluaciones").val("");
}


    </script>
    <style>
        .multiselect {
          background-color: initial;
          border: 1px solid #ced4da;
          width: 765px;
          height: auto;

        }

        .multiselect-container
        {
            height: 200px;  
            width: 700px;
            overflow-x: hidden;
            overflow-y: scroll; 
        }

    </style>
</body>

</html>