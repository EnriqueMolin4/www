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
            <div class="page-title">
            	<h3>BUSCAR TPV O SIM</h3>
            </div>
            <div class="container-fluid p-3 panel-white">
                					 
                    <div class="row">
                        <div id="avisos" class="display:none;" style="background-color:red;"></div>
                    </div>
                
                    <div id="progress"></div>
                    <div class="row">
                        <div class="col-sm-4">           
                            <label for="InSerie" class="col-form-label-sm">INGRESA LA SERIE:</label>
                            <input type="text" class="form-control form-control-sm" id="InSerie" style="text-transform:uppercase" >
                        </div>
                        <div class="col" style="padding-left:30px;padding-top:30px;">  
                            <button class="btn btn-primary" id="btnSerie">Mostrar</button>
                        </div>
                    </div>
                    <br/>
                

           
            <!-- Tabla Eventos -->
			
			<div class="row">
				
				<table id="table_eventos" class="table table-md table-bordered" style="display:none">
					<thead>
						<tr>
							<th>ODT</th>
							<th>ULTIMA MODIFICACION</th>
							<th>AFILIACION</th>
							<th>TPV INSTALADO</th>
							<th>TPV RETIRADO</th>
							<th>SERVICIO</th>
							<th>TECNICO</th>
							<th>MODIFICADO POR</th>
						</tr>
					</thead>
					<tbody>
                        
                    </tbody>
					
				</table>
				
			</div>
					 
		 <br>
		 <!-- Tabla Inventario -->
		 
		 <div class="row">
				
				<table id="table_inventario" class="table table-md table-bordered" style="display:none">
					<thead>
						<tr>
							<th width="120px">SERIE</th>
							<th>MODELO</th>
							<th>CONECTIVIDAD</th>
							<th>ESTATUS</th>
							<th>ESTATUS INVENTARIO</th>
							<th>ANAQUEL</th>
							<th>CAJA</th>
							<th>TARIMA</th>
							<th>CANTIDAD</th>
							<th>UBICACION</th>
							<th>UBICACION NOMBRE</th>
							<th>QUIEN MODIFICA</th>
							<th>FECHA EDICION</th>
						</tr>
					</thead>
					<tbody>
                        
                    </tbody>
				</table>
				
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
    
    <script type="text/javascript" src="js/series.js"></script> 
</body>

</html>