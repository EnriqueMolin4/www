<?php require("header.php"); ?>
<body>
    <div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">

                <?php include("menu.php") ?>

        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div class="page-title">
                <h3>Detalle de las Evaluaciones</h3>
            </div>
            <div id="overlay" class="overlay"></div>
                
            
                <div class="container-fluid p-3 panel-white">
				  

                    <div class="container-fluid p-5"><h3>Total Evaluados:</h3>
                        <input type="text" class="form-control" id="totalEvaluados" name="totalEvaluados" value="" readonly style="width: 200px">                        
                    </div>
            
                    <hr>
					
					<div class="table-responsive">
                        <table id="detEv" class="table table-md table-bordered table-responsive" >
                        <thead>
                            <tr>
                                <th width="400px">Técnico</th>
                                <th width="250px">Evaluación</th>
                                <th width="250px">Fecha de Inicio</th>
                                <th width="250px">Fecha de Fin</th>
                                <th width="200px">Accion</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <th width="400px">Técnico</th>
                                <th width="250px">Evaluación</th>
                                <th width="250px">Fecha De Inicio</th>
                                <th width="250px">Fecha De Fin</th>
                                <th width="200px">Accion</th>
                            </tr>
                        </tfoot>
                        
                    </table>
                    </div>
					<input type="hidden" id="modelId" value="0">
					
				   
                </div>
            
        </main>
        <!-- page-content" -->
    </div>

    <!-- MODAL DETALLE -->
    	<div class="modal fade" tabindex="-1" role="dialog" id="showDetalleEv">
    		<div class="modal-dialog modal-lg" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title">Detalle</h5>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				</div>

    				<div class="mb-3">
    					<input type="text" class="form-control" value="0" id="nombreTecnico" name="nombreTecnico" readonly> 
                    </div>

    				<div class="modal-body">
                        <center>
                            <div>
                                <label for="totalB" class="col-form-label-sm">Aciertos</label><input type="text" class="form-control totalInput" value="" id="totalB" name="totalB" readonly >
                                <label for="totalE" class="col-form-label-sm">Errores</label><input type="text" class="form-control totalInput" value="" id="totalE" name="totalE" readonly >
                            </div>
                        </center>
                        

                        <br><hr>
    					<div class="table-responsive">
                            <table width="100%" id="verDetalle" class="table table-md table-bordered table-responsive" >
                            
                            <thead>
                                <tr>
                                    <th width="55%">Pregunta</th>
                                    <th width="30%">Respuesta</th>
                                    <th width="15%">Resultado</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th width="55%">Pregunta</th>
                                    <th width="30%">Respuesta</th>
                                    <th width="15%">Resultado</th>
                                </tr>
                            </tfoot>

                        </table>
                        </div>
    					<div class="modal-footer">
    						<input type="hidden" value="0" id="tecnicoId" name="tecnicoId">
    					</div>
    				</div>
    				
    			</div>
    		</div>
    	</div>
    <!-- -->

    <!-- MODAL INFORMACION -->
        <div class="modal fade" tabindex="-1" role="dialog" id="showInfoEv">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Información de Resultados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control " value="0" id="nombreTecnico2" name="nombreTecnico2" readonly>
                    </div>

                    <div class="modal-body">
                        <center>
                        <div class="container">
                            <div class="row">
                                <div><h6>Calificación:</h6>
                                    <input type="text" class="form-control totalInput" value="" id="totalC" name="totalC" readonly>
                                </div>
                               
                            </div> 
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4">
                                    <canvas id="chartResult" width="200" height="200"></canvas>
                                </div>
                            </div> 
                        </div>
                        </center>
                    </div>

                </div>
            </div>
        </div>
    <!-- -->



</body>
<style>
    .totalInput
    {
        width: 27%;
    }

    #totalB, #totalC
    {
        background-color: #FFFFFF;
        border: 2px solid #2c9c4a;
        font-weight: bold;
        font-style: medium;
        text-align: center;
    }

    #totalE
    {
        background-color: #FFFFFF;
        border: 1px solid #db2c2c;
        font-weight: bold;
        font-style: medium;
        text-align: center;
    }

    #nombreTecnico2, #nombreTecnico
    {
        font-weight: bold;
        font-style: medium;
        
    }


</style>
    <!-- page-wrapper -->
    <link href="css/style_timer.css" rel="stylesheet" />

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
		var detalle;
		var verDetalleEv;
		$(document).ready(function(){
            var aciertosErrores = $("#chartResult");
            getTotalEvaluados();
			ResetLeftMenuClass("submenuresultados", "ulsubmenuresultados", "resultadoslink")
			
			detalle = $('#detEv').DataTable({
				language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
				processing: true,
				serverSide: true,
				searching: true,
				//order: [[0, "ASC" ]],
				lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
				//order: [[ 0, "desc" ]],
				ajax: {
					url: 'modelos/evaluacion_db.php',
					type: 'POST',
					data: function( d )
					{
						d.module= 'getTableDetalle'
					}
				},
				columns : [
					{ data: 'nombreTecnico'},
					{ data: 'nombre'},
					{ data: 'inicio'},
					{ data: 'fin'},
					{ data: 'tecnico_id'}

				],
				aoColumnDefs: [
					{
						"targets": [4],
						"mRender" : function ( data, type, row ) 
						{
							var boton = "";
							if(row.fin === null)
							{
								boton += '<p style="font-style:italic;color:#c44545;">Sin Contestar<p>';

							}
							else
							{
								boton += '<a title="Ver detalle" href="#" class="verDet" data="'+row.tecnico_id+'" ><i class="fas fa-table fa-2x" style="color:#1455cc"></i></a>     ';
								boton += '<a title="Ver resultado" href="#" class="verInfo" data="'+row.tecnico_id+'" ><i class="fas fa-info-circle fa-2x" style="color: #167dcc;"></i></a>';
							}
							
							return boton;
						}
					}
				]
				
			});		
			

			verDetalleEv = $('#verDetalle').DataTable({
				language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                processing: true,
                serverSide: true,
                searching: true,
                order: [[ 0, "ASC" ]],
                lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
                order: [[ 0, "desc" ]],
                dom: 'Bfrtip',
                buttons: [
                            {
                                extend: 'csvHtml5',
                                charset: 'UTF-8',
                                bom: true,
                                filename: 'CsvTest',
                                title: 'CSV'
                            }
                        ],
                ajax: {
                	url: 'modelos/evaluacion_db.php',
                	type: 'POST',
                	data: function( d )
                	{
                		d.module = 'getDetalleEvaluacion'
                		d.id = $("#tecnicoId").val()
                	}
                },
                columns:[
                	{ data: 'pregunta' },
                	{ data: 'respuesta' },
                	{ data: 'correcta' }
                ],
                aoColumnDefs: [
                	{

                		"targets": [2],
                		"mRender": function (data, type, row)
                		{
                			var boton = "";
                			if (row.correcta == '1') 
                			{
                				//boton = '<a href="#" title="Correcta"><i class="fas fa-check-square fa-2x" style="color:#329c1a"></i></a>';
                                boton = 'Correcta';              			}
                			else
                			{
                				//boton = '<a href="#" title="Errónea"></a><i class="fas fa-times-circle fa-2x" style="color:#b51f1f"></i>';
                                boton = 'Incorrecta';
                			}
                			return boton;
                		}
                	}
                ]

			})


			$(document).on("click",".verDet", function(){
				var index = $(this).parent().parent().index();
				var data = detalle.row( index ).data();
				console.log(index)
				console.log(data)

				$("#tecnicoId").val(data.tecnico_id);
				$("#nombreTecnico").val(data.nombreTecnico);
				$("#showDetalleEv").modal("show");

                $("#showInfoEv").modal("hide");

                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php',
                    data: {module: 'getErroneasNum', id_tecnico: $("#tecnicoId").val() },
                    cache: false,
                    success: function(data, textStatus, jqXHR){

                        $("#totalE").val(data);
                    }
                })

                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php',
                    data: {module: 'getCorrectasNum', id_tecnico: $("#tecnicoId").val() },
                    cache: false,
                    success: function(data, textStatus, jqXHR){

                        $("#totalB").val(data);
                    }
                });

			});


			$('#showDetalleEv').on('show.bs.modal', function(){
				$(this).find('.modal-body').css({
					width:'auto',
					height: 'auto',
					'max-height':'100%'
				});

				$('#verDetalle').DataTable().ajax.reload();
			});

            $(document).on("click", ".verInfo", function(){
                var index = $(this).parent().parent().index();
                var dataDet = detalle.row( index ).data();
                console.log(index)
                console.log(dataDet)


                $("#tecnicoId").val(dataDet.tecnico_id);
                $("#nombreTecnico2").val(dataDet.nombreTecnico);
                $("#showInfoEv").modal("show");
                $("#showDetalleEv").modal("hide");

                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php',
                    data: {module: 'getCorrectasNum', id_tecnico: $("#tecnicoId").val() },
                    cache: false,
                    success: function(data, textStatus, jqXHR){

                       var calif = data;

                       var total = (data*2)

                       $("#totalC").val(total+"%");
                       //console.log(data);
                    }
                });

                

                $.ajax({
                    type: 'GET',
                    url: 'modelos/evaluacion_db.php',
                    data: {module : 'aciertosErrores', id_tecnico: $("#tecnicoId").val() },
                    success: function(data){
                        var info = JSON.parse(data);
                        console.log(info);

                        var result = [];

                        for ( var i = 0; i < info.aciertosErrores.length; i++){

                            result.push(info.aciertosErrores[i].total)

                            console.log(result);
                        }

                        var dataR = {
                            labels : ["Correctas", "Incorrectas"],
                            datasets : [
                                {
                                    label: "Total",
                                    data: result,
                                    backgroundColor: ["#01ff00","#ff0000"],
                                }
                            ]
                        };

                        var chartResult = new Chart(aciertosErrores,{
                            type: 'bar',
                            data: dataR,
                            options: {
                                legend: { display: false},
                                title: {
                                    display: true,
                                    text: 'Total aciertos y errores'
                                }
                            }
                        });



                    },
                    error: function(error)
                    {
                        var demo= error;
                    }
                })



            });

            $('#showInfoEv').on('show.bs.modal', function(){
                $(this).find('.modal-body').css({
                    width:'auto',
                    height: 'auto',
                    'max-height':'100%'
                })
            })


            function getTotalEvaluados()
            {
                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php',
                    data: {module: 'getTotalEvaluaciones'},
                    cache: false,
                    success: function(data, textStatus, jqXHR){
                        $("#totalEvaluados").val(data);
                    },
                    error: function(error)
                    {
                        var demo = error;
                    }
                })
            }

           /* function getCorrectasNum()
            {
                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php',
                    data: {module: 'getCorrectasNum&id_tecnico'+$("")},
                    cache: false,
                    success: function(data, textStatus, jqXHR){

                    }
                })
            }*/


			
		})
	</script>








</html>