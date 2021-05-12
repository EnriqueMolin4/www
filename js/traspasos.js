var infoAjax = 0;
var tableTraspasos,tableTraspasosItems;
$(document).ready(function() {
    
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "traspasoslink")
    getTecnicos();
    getAlmacenes();

    $(".searchInventario").on('change',function() {
        tableTraspasos.ajax.reload();
    })

    tableTraspasos = $('#traspasos').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "ASC" ]],	
        dom: 'lfrtiBp',	  
        buttons: [
            'pdf',
            'excelHtml5',
            'csv'
        ],
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getTraspasos',
                d.tecnico = $("#tecnico").val() ,
                d.almacen = $("#almacen").val() 
            }
        },
        columns : [
            { data: 'no_guia'},
            { data: 'codigo_rastreo'},
            { data: 'origen'},
            { data: 'destino'},
            { data: 'estatus'},
            { data: 'fecha_creacion' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [6],
                "mRender": function ( data,type, row ) {

                
                    if (row.estatus === 'EN TRANSITO' ) 
                    {
                         return '<a href="#" title="Detalle de traspaso" class="mostrarTraspaso"  data-id="'+row.no_guia+' "><i class="fas fa-edit fa-2x " style="color:#187CD0"></i></a> <a href="#" class="deleteTraspaso" title="Eliminar" data="'+row.no_guia+'"><i class="fas fa-trash-alt fa-2x" style="color:#F5425D"></i></a> ';
                    }
              
                    return '<a href="#" title="Detalle de traspaso" class="mostrarTraspaso" data-id="'+row.no_guia+' "><i class="fas fa-edit fa-2x " style="color:#187CD0"></i> </a>';
                }
            }
        ]
    });


    tableTraspasosItems = $('#traspasositems').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "ASC" ]],	
        scrollY: 350,
        scroller: true,
        responsive: true,
        ajax: {
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getProductosNoGuia',
                d.no_guia =  $("#no_guia").val() 
            }
        },
        columns : [
            { data: 'tipo'},
            { data: 'no_serie'},
            { data: 'modelo'},
            { data: 'cantidad'},
            { data: 'notas'},
            { data: 'aceptada' },
            { data: 'ultima_act' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [7],
                "mRender": function ( data,type, row ) {
              
                    return '<a href="#" title="Aceptar Entrada" class="aceptarItem" data-id="'+row.id+' "><i class="fas fa-sign-in-alt fa-2x"></i></a><br><a href="#" title="Retornar" class="retornarItem" data-id="'+row.id+' "><i class="fas fa-undo fa-2x" style="color:#3489eb"></i></a><br><hr><a href="#" title="Ajuste" class="retornarItem" data-id="'+row.id+' "><i class="fas fa-sliders-h fa-2x" style="color:#C17137"></i></a>';
                }
            }
        ]
    });

   
    $(document).on("click",".aceptarItem", function() {
        
        var traspasoId = $(".aceptarItem").data('id');
        
        $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', // call your php file
            data: 'module=aceptarTraspaso&traspasoId='+traspasoId,
            cache: false,
            success: function(data){
               
            $("#tecnico").html(data);   
            $("#add-tecnico").html(data);         
            },
            error: function(error){
                var demo = error;
            }
        }); 

    })

    $(document).on("click",".mostrarTraspaso", function() {
            
       
        var index = $(this).parent().parent().index() ;
        var data = tableTraspasos.row( index ).data()

        $("#noGuia_det").html(data.no_guia);
        $("#codigorastreo_det").html(data.codigo_rastreo);
        $("#origen_det").html(data.origen);
        $("#destino_det").html(data.destino);
        $("#no_guia").val(data.no_guia);
        $("#showDetalle").modal("show");
		
		tableTraspasosItems.ajax.reload();
		
		 
       
    })

//Eliminar trasapaso
    $(document).on('click', '.deleteTraspaso', function(){
        var guiaTrasp = $(this).attr('data');


        if (confirm("¿Estás seguro de eliminar este envío?")) 
        {
            $.ajax({
            type: 'GET',
            url: 'modelos/almacen_db.php', //call your php file
            data:{ module: 'eliminarTraspaso', guiaTrasp: guiaTrasp},
            cache: false,
            success: function(data){
                if (data == "1") 
                {
                    $.toaster({
                        message: 'Se eliminó el traspaso con éxito',
                        title: 'Aviso',
                        priority : 'success'
                    });

                    $('#traspasos').DataTable().ajax.reload();
                }
                else
                {
                    $.toaster({
                        message: 'No se eliminó, revisar nuevamente.',
                        title: 'Aviso',
                        priority: 'danger'
                     });
                 }
                }

            });
        }


    });
     
/*
    $('#showDetalle').on('show.bs.modal', function () {
         
      
      tableTraspasosItems.columns.adjust();
       
    });
*/

    $("#btnCargarExcelTraspasos").on('click', function() {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivoTraspasos");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','TraspasosMasivo');
        $.toaster({
            message: 'Inicia la Carga de Traspasos Masivos',
            title: 'Aviso',
            priority : 'success'
        }); 
        
        $("#showAvisosCargas").modal("show");
        $("#bodyCargas").html('Cargando Informacion <br /> ')

        $.ajax({
            type: 'POST',
            url: 'modelos/almacen_db.php', // call your php file
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR){
                var info = JSON.parse(data);

                if(info.traspasos.length > 0) {
                    $("#bodyCargas").append(info.mensajeYaCargadas);
                var message ;
                    $.each(info.traspasos,function(index,value) {
                       
                    
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/almacen_db.php', // call your php file
                            data: 'module=grabarTraspaso&info='+JSON.stringify(value),
                            cache: false,
                            success: function(data){
                                message += data+"  <br />  ";

                                $("#bodyCargas").append(data+" <br />  ");
                            
                            },
                            error: function(error){
                                var demo = error;
                            }
                        });
                    })
                    tableTraspasos.ajax.reload();
                } else {
                    $("#bodyCargas").append(info.mensajeYaCargadas);
                }
               /* $message1 = "Se Cargaron "+info.registrosCargados+" de "+info.registrosArchivo+" Eventos \n";
                if(info.odtYaCargadas.length > 0 ) {
                    var tec = '';
                    var odtTecnicos = info.odtYaCargadas;
                    $.each(odtTecnicos, function(index,value) {
                        tec += value.ODT+ " Asignada a "+value.Tecnico+ " <br /> ";
                    })
                    $message1 += "Las siguientes ODT ya estan Asignadas: <br /> "+tec
                }*/

                //alert($message1);
               

                 
               
                
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus)
           }
        });
    })

});

//getTecnicoxAlmacen
function getTecnicos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getTecnicos',
        cache: false,
        success: function(data){
           
        $("#tecnico").html(data);   
        $("#add-tecnico").html(data);         
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getAlmacenes() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getAlmacen',
        cache: false,
        success: function(data){
           
         
        $("#almacen").html(data);   
		tableTraspasos.ajax.reload();
			if($("#userPerm").val() == 'admin' || $("#userPerm").val() == 'CA' || $("#userPerm").val() == 'AL' ) {
				$("#almacen").attr('disabled',false);
			} else {
				$("#almacen").attr('disabled',true);
			}
        },
        error: function(error){
            var demo = error;
        }
    });
}