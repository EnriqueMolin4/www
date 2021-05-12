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
        <main class="page-content">
            <div id="overlay" class="overlay"></div>
            <div class="page-title">
                <h3>BITACORA ODT</h3>
            </div>
            <div class="container-fluid p-4 panel-white">
            
            
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        
                    
                    <table id="bitacora"  class="table table-md table-bordered table-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>ODT</th>
                                <th>COMERCIO</th>
                                <th>ALTA</th>
                                <th>ESTATUS</th>
                                <th>NIVEL</th>
                                <th>ULTIMA ACT</th>
                                <th>MODIFICADO POR</th>
                                <th>HISTORIA SERIE</th>
                            
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ODT</th>
                                <th>COMERCIO</th>
                                <th>ALTA</th>
                                <th>ESTATUS</th>
                                <th>NIVEL</th>
                                <th>ULTIMA ACT</th>
                                <th>MODIFICADO POR</th>
                                <th>HISTORIA SERIE</th>
                                
                                
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                <!--<input type="hidden" id="userId" value="0">
                <button class="btn btn-success" id="btnNewUser">Nuevo Usuario</button>-->
                </div>
            </div>
        </div>
            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showHistoria" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h3>HISTORIA</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
                <div class="table-responsive">
                    
                
                    <table id="historia"  class="display table table-md table-bordered table-responsive" width="100%">
                        <thead>
                            <tr>
                                <th>NO SERIE</th>
                                <th>FECHA MOVIMIENTO</th>
                                <th>MOVIMIENTO</th>
                                <th>PRODUCTO</th>
                                <th>UBICACION</th>
                                <th>MODIFICADO POR</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NO SERIE</th>
                                <th>FECHA MOVIMIENTO</th>
                                <th>MOVIMIENTO</th>
                                <th>PRODUCTO</th>
                                <th>UBICACION</th>
                                <th>MODIFICADO POR</th>
                               
                            </tr>
                        </tfoot>
                    </table>
                    </div>
            
					<div class="modal-footer">
						<input type="hidden" value="0" id="tpv_instalado" name="tpv_instalado">
                        
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
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
    <script src="js/jquery.rotate.1-1.js"></script>
    <script>
    var bitacora;
        $(document).ready(function() {
            ResetLeftMenuClass("submenureportes","ulsubmenureportes","bitacoraodtlink");
           
               

                bitacora = $('#bitacora').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    order: [[ 0, "ASC" ]],
                    lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
                    order: [[ 0, "desc" ]],
                    ajax: {
                        url: 'modelos/bitacoraODT_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable'
                        }
                    },
                    columns : [
                        { data: 'odt'},
                        { data: 'comercio'},
                        { data: 'fecha_alta' },
                        { data: 'estatus' }, 
                        { data: 'nivel' },
                        { data: 'ultima_act'},
                        { data: 'modificado_por'},
                        { data: 'tpv_instalado'},
                                              
                    ],
                    aoColumnDefs: [
                        {
                            "targets": [ 0 ],
                            "width": "15%",
                            
                        },
                        {
                            "targets": [ 3 ],
                            "width": "10%",
                            
                        },
                        {
                            "targets": [ 5 ],
                            "width": "10%",
                            
                        },
                        {
                            "targets": [ 7 ],
                            "mRender": function ( data, type, row)
                            {
                                var tpv;
                                var buttons='';

                                
                                tpv = row.tpv_instalado;
                                
                                if(tpv  != null ) {
                                
                                buttons += '<a href="#" class="btn btn-warning mostrarHistoria" data-id="'+tpv+' ">Historial</a>';
                                
                                }

                                return buttons;
                            }
                        }
                    ]
                });


                

                $(document).on("click", ".mostrarHistoria", function() 
                {
                    var index = $(this).parent().parent().index();

                    var data = bitacora.row(index).data();

                    console.log(index);
                    console.log(data);

                    console.log( $(this).data('id') );

                    $("#tpv_instalado").val($(this).data('id'));
                   
                    //Details
                    
                    $("#showHistoria").modal("show");
                    $('#historia').DataTable().ajax.reload();

                });

                
                $('#historia').DataTable(
                    {
                        language: 
                        {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },

                        processing: true,
                        serverSide: true,
                        //lengthMenu: [[5], [5]],
                        order: [[ 0, "ASC" ]],		
                        dom: 'lfrtiBp',
                        
                        buttons: 
                        [
                            'pdf',
                            'excelHtml5',
                            'csv'
                        ],
                
                        ajax: 
                        {
                            url: 'modelos/bitacoraODT_db.php',
                            type: 'POST',
                            data: function( d ) 
                            {
                                d.module = 'getHistoria',
                                d.tpv_instalado = $("#tpv_instalado").val()
                            }   
                        },
                        
                        columns : 
                        [
                            { data: 'no_serie'},
                            { data: 'fecha_movimiento' },
                            { data: 'tipo_movimiento' },
                            { data: 'producto'},
                            { data: 'ubicacionNombre'},
                            { data: 'correo'}
            
                        ], 

                        columnDefs: [
                            {
                                "targets": [-1, 1],
                                "visible": true,
                                "searchable":false
                            }
                        ]
                    }); 
                

                
        

               
            });

            
        function getSupervisores() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getSupervisores' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#supervisor").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        } 


        function getTerritorial() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTerritorial' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#territorial").html(data);
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        } 

        function getTipoUser() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getTipoUser' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#tipo").html(data);
 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function getBancos() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getBancos' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#negocio").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function getPlazas() {

            $.ajax({
                type: 'POST',
                url: 'modelos/usuarios_db.php', // call your php file
                data: { module: 'getPlazas' },
                cache: false,
                success: function(data, textStatus, jqXHR){
                    
                    $("#plaza").html(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus)
                }
            });
        }

        function cleartext() {
            $("#nombre").val("");
            $("#apellidos").val("");
            $("#contrasena").val("");
            $("#usuario").val("");
            $("#supervisor").val("0");
            $("#tipo").val("0");
            $("#negocio").val("0");
            $("#correo").val("")
            $("#territorial").val("0");
            $("#plaza").val("0");

        }


    </script> 
  
</body>

</html>