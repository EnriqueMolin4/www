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
            <div class="row"><h3>Causas de Rechazo y Cancelación</h3>
			
            </div>
			
			<div class="row">
				<div class="col">
					<label for="catalogo" class="col-form-label-sm">Catálogo</label>
					<select name="catalogo" id="catalogo" class="form-control form-control-sm">
						<option value="tipo_rechazos" selected>Rechazos y Subrechazos</option>
						<option value="tipo_cancelacion">Cancelación</option>
					</select>
				</div>
				<!-- <div class="col" id="divTipo" name="divTipo" style="display: none;">
					<label for="tipo" class="col-form-label-sm">Tipo</label>
					<select id="tipo" name="tipo" class="form-control from-control-sm">
						<option value="0">Seleccionar</option>
						
					</select>
				</div> -->
			</div><br>
            <table id="rechazos"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Clave Elavon</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
            <input type="hidden" id="bancoId" value="0">
            <button class="btn btn-success" id="btnNewRechazo">Nuevo Registro</button>
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showRechazo">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar/Actualizar Registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!-- MODAL PARA AGREGAR/EDITAR UN NUEVO REGISTRO -->
                        <form id="frm" name="frm">
                            
                                <div class="col">           
                                    <label for="rechazo" class="col-form-label-sm">Nombre</label>
                                    <input type="text" class="form-control" id="rechazo" name="rechazo" aria-describedby="rechazo">
                                </div>

                                <div class="col">           
                                    <label for="descripcion" class="col-form-label-sm">Descripción</label>
                                    <textarea class="form-control form-control" id="descripcion" name="descripcion" aria-describedby="descripcion"> </textarea>
                                </div>    

                            
							<div class="row p-3">
								<div class="col-sm-5">
									<label for="clave_elavon" class="col-form-label-sm">Clave Elavon</label>
									<input type="text" class="form-control" id="clave_elavon" name="clave_elavon" aria-describedby="clave_elavon">
								</div>
								<div class="col-sm-5">
									<label for="nTipo" class="col-form-label-sm">Tipo</label>
									<select id="nTipo" name="nTipo" class="form-control">
										<option value="0">Seleccionar</option>
										<option value="r">Rechazo</option>
										<option value="s">Subrechazo</option>
									</select>
								</div>
							</div>	

                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="rechazoId" name="rechazoId" value="0">
                        <button type="button" class="btn btn-primary" id="btnGrabarRechazo">Guardar</button>
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
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.rotate.1-1.js"></script>
	<script>
		var rechazos;
		$(document).ready(function(){
			getTipoRechazos();
			ResetLeftMenuClass("submenucatalogos","ulsubmenucatalogos","rechazoslink");
			
			rechazos = $("#rechazos").DataTable({
				language: {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				processing: true,
				serverSide: true,
				searching: true,
				order: [[0 , "ASC" ]],
				lengthMenu:[[5,10,25,-1],[5,10,25,"Todos"]],
				order: [[5, "asc"]],
				ajax: {
					url: 'modelos/tipos_catalogos_db.php',
					type: 'POST',
					data: function( d ){
						d.module = 'getRechazosTable',
						d.catalogo = $("#catalogo").val()
						//d.tipo = $("#tipo").val()
					}
				},
				columns : [
					{ data: 'nombre'},
					{ data: 'descripcion'},
					{ data: 'clave_elavon'},
					{ data: 'tipo'},
					{ data: 'estatus'},
					{ data: 'id'}
				],
				aoColumnDefs: [
					{
						"targets":[3],
						"mRender": function (data,type,row){
							var mostrar = "";
							if(data == 's')
							{
								mostrar = 'Subrechazo';
							}else if(data == 'r')
							{
								mostrar = 'Rechazo';
							}else{
								mostrar = 'Cancelación'
							}

							return mostrar;
						}
					},
					{
						"targets":[4],
						"mRender": function ( data,type,row ){
							var boton = "";
							
							if(data == '1'){
								boton = 'Activo';
							} else {
								boton = 'No Activo';
							}
							return boton;
							
						}
					},
					{
						"targets":[5],
						"mRender": function( data, type, row ){
							var boton = "";

							if (row.estatus == 1 ) 
							{	
								//<a href="#" class="editRechazo" title="Editar" data="'+data+'"><i class="fas fa-edit fa-2x"></i></a>
								boton = '<a href="#" title="Desactivar" class="desactivarE" data="'+data+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
							} else {
								//<a href="#" class="editRechazo" title="Editar" data="'+data+'"><i class="fas fa-edit fa-2x"></i></a>
								boton = '<a href="#" title="Activar" class="activarE" data="'+data+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
							}
							
							
							
							return boton;
						}
					}
				]
			});


			$("#catalogo").on('change',function() {
                    rechazos.ajax.reload();
                })

			/*$("#tipo").on('change', function(){
				rechazos.ajax.reload();
			})*/
			
			$("#btnNewRechazo").on("click", function(){
				$("#showRechazo").modal("show");
			})
			
			$('#showRechazo').on('hide.bs.modal', function(e){
				$("#rechazoId").val(0);
			})
			
			$(document).on("click",".editRechazo",function(){
				var index = $(this).parent().parent().index();
				var data = rechazos.row( index ).data()
				
				console.log(data)
				$("#rechazoId").val(data.id);
				$("#rechazo").val(data.nombre);
				$("#descripcion").val(data.descripcion);
				$("#clave_elavon").val(data.clave_elavon);
				$("#nTipo").val(data.tipo);
				
				
				$("#showRechazo").modal("show");
				
			});

			$('#showRechazo').on('hide.bs.modal', function () {
				cleartext();
			})


			$('#rechazos').on("click",'tr .desactivarE', function(){
				var index = $(this).parent().parent().index();
				var data = rechazos.row( index ).data();
				var id = $(this).attr('data');
				var catalogo = $("#catalogo").val();

				$.ajax({
					type: 'POST',
					url: 'modelos/tipos_catalogos_db.php',
					data: { module: 'desEstatusr', catalogo:catalogo, id: id},
					cache: false,
					success: function(data, textStatus, errorThrown){
						var info = JSON.parse(data);
						$.toaster({
							message: 'Se deshabilitó el registro',
							title: 'Aviso',
							priority : 'success'
						});
						rechazos.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown){
						alert(data)
					}
				})

			});

			$('#rechazos').on("click",'tr .activarE', function(){
				var index = $(this).parent().parent().index();
				var data = rechazos.row( index ).data();
				var id = $(this).attr('data');
				var catalogo = $("#catalogo").val();

				$.ajax({
					type: 'POST',
					url: 'modelos/tipos_catalogos_db.php',
					data: { module: 'actEstatusr', catalogo:catalogo, id: id},
					cache: false,
					success: function(data, textStatus, errorThrown){
						var info = JSON.parse(data);
						$.toaster({
							message: 'Se habilitó el registro',
							title: 'Aviso',
							priority : 'success'
						});
						rechazos.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown){
						alert(data)
					}
				})
				
			})

			$("#btnGrabarRechazo").on('click', function(){
				var catalogo = $("#catalogo").val();
				var rechazo = $("#rechazo").val();
				var descripcion = $("#descripcion").val();
				var clave_elavon = $("#clave_elavon").val();
				var tipo = $("#nTipo").val();
				var rId = $("#rechazoId").val();
				var error = 0;

				if(document.getElementById("rechazo").value.length == 0)
				{
				    $.toaster({
				    	message: 'Favor de ingresar nombre',
				    	title: 'Aviso',
				    	priority: 'warning'
				    });
				    error++;
				}
				if(descripcion.length <= 1)
				{
				    $.toaster({
				    	message: 'Favor de ingresar descripción',
				    	title: 'Aviso',
				    	priority: 'warning'
				    });
				    error++;
				}

				if (document.getElementById("clave_elavon").value.length == 0) 
				{
					$.toaster({
						message: 'Favor de ingresar Clave Elavon',
						title: 'Aviso',
						priority: 'warning'
					});
					error++;
				}
				if (tipo == 0) 
				{
					$.toaster({
						message: 'Favor de seleccionar el tipo',
						title: 'Aviso',
						priority: 'warning'
					})
				}

				if (error == 0) 
				{
					$.ajax({
						type:'POST',
						url: 'modelos/tipos_catalogos_db.php',
						data:{ module: 'grabarRechazo', catalogo:catalogo, rId:rId, rechazo: rechazo, descripcion: descripcion, clave_elavon:clave_elavon, tipo:tipo},
						cache: false,
						success: function(data)
						{
							console.log(data);
							var info = JSON.parse(data)

							if (info.id > 0) 
							{
								Swal.fire({
									icon:'success',
									title: 'Exito',
									text: info.msg
								})

								$("#showRechazo").modal("hide");
								rechazos.ajax.reload();
							}
							else
							{
								Swal.fire({
									icon: 'info',
									title: 'Actualizado',
									text: info.msg
								});
								$("#showRechazo").modal("hide");
								rechazos.ajax.reload();
							}
						},
						error: function(error)
						{
							var demo = error;
						}
					});
				}
				else
				{
					$.toaster({
						message: 'Revisar campos',
						title: 'Aviso',
						priority: 'warning'
					})
				}
			})
			
		});

	
		
	function getTipoRechazos() {
		$.ajax({
			type: 'GET',
			url: 'modelos/tipos_catalogos_db.php', // call your php file
			data: 'module=getTipoRechazos',
			cache: false,
			success: function(data){
				
			$("#tipo").html(data);
			//$("#nTipo").html(data);
		},
		error: function(error){
			var demo = error;
		}
		
		})
	}


	function cleartext(){
		$("#nTipo").val("0");			
		$("#descripcion").val("");
		$("#clave_elavon").val("0");
		$("#rechazo").val("");

	}
			
		
		
		
		
		
	</script>
</body>

</html>