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
            <div class="row"><h3>Bancos</h3>
			
            </div>
            <table id="bancos"  class="table table-md table-bordered ">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Banco</th>
                        <th>CVE</th>
                        <th>STATUS</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
            <input type="hidden" id="bancoId" value="0">
            <button class="btn btn-success" id="btnNewBanco">Nuevo Banco</button>
            </div>

            <!-- MODAL -->
            <div class="modal fade" tabindex="-1" role="dialog" id="showBanco">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Banco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!-- MODAL PARA AGREGAR/EDITAR UN NUEVO EVENTO -->
                        <form id="frm" name="frm">
                            <div class="row">
                                <div class="col-sm-4">           
                                    <label for="banco" class="col-form-label-sm">Banco</label>
                                    <input type="text" class="form-control form-control-sm" id="banco" name="banco" aria-describedby="banco">
                                </div>

                                <div class="col-sm-4">           
                                    <label for="cve" class="col-form-label-sm">CVE</label>
                                    <input type="text" class="form-control form-control-sm" id="cve" name="cve" aria-describedby="cve">
                                </div>    

                            </div> 

                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="bancoId" name="bancoId" value="0">
                        <button type="button" class="btn btn-primary" id="btnGrabarBanco">Registrar</button>
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
    var bancos;
        $(document).ready(function() {
            ResetLeftMenuClass("submenucatalogos", "ulsubmenucatalogos", "bancoslink")    

            bancos = $('#bancos').DataTable({
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
                        url: 'modelos/bancos_db.php',
                        type: 'POST',
                        data: function( d ) {
                            d.module = 'getTable'
                        }
                    },
                    columns : [
                        { data: 'id'},
                        { data: 'banco'},
                        { data: 'cve' },
                        { data: 'status'},
                        { data: 'tipo'},
                        //{ data: 'id'}
                        
                    ],
                    aoColumnDefs: [
                        
                        {
                            "targets": [3],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                            if(data == '1'){
                                    boton =  'Activo'
                                } else {
                                    boton = 'No Activo';
                            }

                                return boton;
                            }
                        },
                        {
                            "targets": [4],
                            "mRender": function ( data,type, row ) {
                                var boton = "";
                                
                                if(row.status == '1'){
                                    boton =  '<a href="#" title="Editar" class="EditBanco" data-id="'+row.id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="DelBanco" data="'+row.Id+'"><i class="fas fa-toggle-on fa-2x" style="color:#24b53c"></i></a>';
                                } else {
                                    boton = '<a href="#" title="Editar" class="EditBanco" data-id="'+row.id+'"><i class="fas fa-edit fa-2x "></i></a><a href="#" class="DelBanco" data="'+row.Id+'"><i class="fas fa-toggle-off fa-2x" style="color:#b52424"></i></a>';
                            }

                                return boton;
                            }
                        }
                    ]
                });

                $("#btnNewBanco").on("click", function() {

                    $("#showBanco").modal("show");

                })

                $('#showBanco').on('hide.bs.modal', function (e) {
                    $("#bancoId").val(0);
                })

                $(document).on("click",".EditBanco", function() {
                    var index = $(this).parent().parent().index() ;
                    var data = bancos.row( index ).data()
                    $("#banco").val(data.banco);
                    $("#cve").val(data.cve);
                    $("#bancoId").val( $(this).data('id') );
                    $("#showBanco").modal("show");

                })

                $("#btnGrabarBanco").on('click', function() {

                    var banco =  $("#banco").val();
                    var cve = $("#cve").val();
                    var bancoId = $("#bancoId").val();
					
					console.log(banco);
					console.log(cve);
					console.log(bancoId);
                    
					if(  banco.length > 0 && cve.length > 0 ) 
                    {
                        
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/bancos_db.php', // call your php file
                            data: { module : 'grabarBanco', bancoId: bancoId, banco: banco, cve: cve },
                            cache: false,
                            success: function(data){
                                console.log(data);
                                var info = JSON.parse(data)

                                if(info.id > 0 ) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Exito',
                                        text: info.msg
                                    }) 

                                    $("#showBanco").modal("hide");

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: info.msg
                                    }) 
                                }
                                
                                      
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });

                    } else {
                        $.toaster({
							message: 'Favor De Ingresar El Modelo',
							title: 'Aviso',
							priority : 'warning'
						});  
                    }
                    
                    
                  

                    
                })
 
        } );

        function getProveedor() { /* Obtención del proveedor para Modelos */

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

        function getConectividad() {/* Obtención del conectividad para Modelos */

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

        function cleartext() { /* Función que limpia los campos del formulario */
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


    </script> 
  
</body>

</html>