var modelos;
$(document).ready(function() {
       
        getProveedores();
        getConectividad();
        getEstatus();

        modelos = $('#modelos').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
            ajax: {
                url: 'modelos/catalogos_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getModelos'
                }
            },
            columns : [
                { data: 'modelo'},
                { data: 'nombreProveedor' },
                { data: 'conectividad' },
                { data: 'no_largo' },
                { data: 'estatusNombre' },
                { data: 'id'},
                { data: 'proveedor'},
                { data: 'estatus'}
            ],
            aoColumnDefs: [
                {
                    "targets": [5],
                    "mRender": function ( data,type, row ) {
                        return '<a href="#" class="EditModelo" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="delCom"><i class="fas fa-times fa-2x" style="color:red"></i></a>';
                    }
                },
                {
                    "targets": [6],
                    "visible": false,
                    "searchable": false
                     
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                     
                }
            ]
        });

        $("#btnRegistrar").on('click', function() {
    
                var data = { 
                    'module' : 'grabarModelo',
                    'modeloid': $("#modeloId").val(),
                    'modelo': $("#modelo").val(),
                    'proveedor': $("#proveedor").val(),
                    'conectividad': $("#conectividad").val() ,
                    'estatus': $("#estatus").val() ,
                    'no_largo' : $("#nolargo").val()
                }
    
                $.ajax({
                    type: 'POST',
                    url: 'modelos/catalogos_db.php', // call your php file
                    data: data,
                    cache: false,
                    success: function(data){
                        console.log(data);
                        var info = JSON.parse(data)
                        
                        mensaje = "Se ha creado con Exito el Modelo"
                        if(info.id == '0') {
                            mensaje = "Se Modifico con Exito el Modelo"
                        }
    
                        $.toaster({
                            message: mensaje,
                            title: 'Aviso',
                            priority : 'success'
                        }); 
    
                        $("#showModelo").modal("hide")
                        $('#modelos').DataTable().ajax.reload();          
                    },
                    error: function(error){
                        var demo = error;
                    }
                });
               
            
            
        })

        $("#btnNewModelo").on('click', function() {
            
            $("#showModelo").modal("show")
        })

        // $(document).on("click",".EditModelo", function() {
           
        //     var id = $(this).attr('data');
        //     $("#modeloId").val(id);
        //     $("#showModelo").modal("show")
        // })

 
        $('#modelos tbody').on('click', 'tr a.EditModelo', function () {
            cleartext()
            var index = $(this).parent().parent().index() ;
            var data = modelos.row( index ).data()
            console.log(data)
            //var id = $(this).attr('data');
            $(".modal-title").html("Editar Modelo")
            $("#modeloId").val(data.id);
              
            $("#modelo").val(data.modelo)
            $("#proveedor").val(data.proveedor)
            $("#conectividad").val(data.conectividad)
            $("#nolargo").val(data.no_largo)
            $("#showModelo").modal({show: true, backdrop: false, keyboard: false})
          
        });

        $(document).on("click","#btnNewModelo", function() {
            cleartext()
            $(".modal-title").html("Nuevo Modelo")
            $("#showModelo").modal({show: true, backdrop: false, keyboard: false})
        })
      
        $('#showModelo').on('show.bs.modal', function (e) {
          

        });

       

        
    } );

    
 
    function getProveedores() {
        $.ajax({
            type: 'GET',
            url: 'modelos/catalogos_db.php', // call your php file
            data: 'module=getProveedores',
            cache: false,
            success: function(data){
            $("#proveedor").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }

    function getConectividad() {
        $.ajax({
            type: 'GET',
            url: 'modelos/catalogos_db.php', // call your php file
            data: 'module=getConectividad',
            cache: false,
            success: function(data){
            $("#conectividad").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }
    
    function getEstatus() {
        $.ajax({
            type: 'GET',
            url: 'modelos/catalogos_db.php', // call your php file
            data: 'module=getEstatusModelo',
            cache: false,
            success: function(data){
            $("#estatus").html(data);            
            },
            error: function(error){
                var demo = error;
            }
        });
    }
    


function cleartext() {
    $("#modeloId").val('0'),
    $("#modelo").val(''),
    $("#proveedor").val(''),
    $("#conectividad").val('0') ,
    $("#estatus").val('0') ,
    $("#nolargo").val('')

}

