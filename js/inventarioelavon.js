var infoAjax = 0;
var tableInventario;
var usrPerm;
var fecha_hoy;
$(document).ready(function() {
    usrPerm = $("#userPerm").val();
    getBancosf();
    getFabricantes();
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "almacenlink")
    $("#colFabricante").hide();
    $("#colCarrier").hide();

    $("#fechaVen_inicio").datetimepicker({
        format:'Y-m-d'
    });

    $("#fechaVen_fin").datetimepicker({
        format:'Y-m-d'
    });

    $(".searchInventario").on('change',function() {
        tableInventario.ajax.reload();
    })

    fecha_hoy = moment().format('YYYY-MM-DD');

   //Inhabilitar entrada

    $("#tipo").on("change", function() {
        
        if( $(this).val() == '1' ) {
            $("#colFabricante").show();
            $("#colCarrier").hide();
        } else if( $(this).val() == '2' ) {
            $("#colFabricante").hide();
            $("#colCarrier").show();
        } else {
            $("#colFabricante").hide();
            $("#colCarrier").hide();
        }
    })

    tableInventario = $('#inventario').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "ASC" ]],		  
        dom: 'lfrtiBp',
        buttons: [{
            extend: 'excel',
            filename: 'Inv_Elavon_'+fecha_hoy,
            exportOptions: {
                orthogonal: 'sort',
                columns: [0,1,2,3]
            },
            customizeData: function ( data ) {
                for (var i=0; i<data.body.length; i++){
                    for (var j=0; j<data.body[i].length; j++ )
                    {
                        data.body[i][j] = '\u200C' + data.body[i][j];
                    }
                }
            }               
        }],
        ajax: {
            url: 'modelos/inventarioelavon_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getTable',
                d.tipo_estatus = $("#tipo_estatus").val(),
                d.tipo_producto = $("#tipo_producto").val(),
                d.banco = $("#bancoF").val()
            }
        },
        columns : [
            { data: 'bnco'  },
            { data: 'tipo'},
            { data: 'serie'},
            { data: 'fabricante' },
            { data: 'estatus' },
            { data: 'id'}
        ],
        aoColumnDefs: [
            {
                "targets": [1],
                "mRender": function ( data,type, row ) {
                    var id;
					var tipo = '';
			
					switch(row.tipo) {
                        case '1':
                        tipo = 'TPV'
                        break;
                        case '2':
                        tipo = 'SIM'
                        break;
                
                    }

					
                    return tipo;
                }
            },
            {
                "targets": [5],
                "mRender": function ( data,type, row ) {
                    var id;
					var buttons = '';
			
					if(usrPerm == 'admin' || usrPerm == 'CA' || usrPerm == 'AN' ) {
						 buttons += ' <a href="#" class="mostrarDetalle" title="Editar Información" data="'+id+' "><i class="fas fa-edit fa-2x " style="color:#187CD0"></i></a>';
					} 

					
                    return buttons;
                }
            }
        ]
    });

    $(document).on("click",".mostrarDetalle", function() {
        clear();
        var id = $(this).attr('data');
        var index = $(this).parent().parent().index() ;
        var data = tableInventario.row( index ).data()
        
        $("#tipo").val(data.tipo);

        if(data.tipo == '1') {
            $("#fabricante").val(data.fabricante);
            $("#colFabricante").show();
            $("#colCarrier").hide();
        } else {
            $("#carrier").val(data.fabricante);
            $("#colFabricante").hide();
            $("#colCarrier").show();
        }
        
        $("#serie").val(data.serie);
        $("#estatus").val(data.estatus);
       
        $("#showAlta").modal({show: true, backdrop: false, keyboard: false})
    })

    $("#btnNuevoEvento").on("click", function() {
        clear();
        $("#showAlta").modal("show");
    })
	
	$("#btnCargarExcelInventarios").on('click', function() {
        var form_data = new FormData();
        var excelMasivo = $("#excelMasivoInventarios");
        var file_data = excelMasivo[0].files[0];
        form_data.append('file', file_data);
        form_data.append('module','InventarioElavon');
        $.toaster({
            message: 'Inicia alta Inventarios Masivos',
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
				 

                 $("#bodyCargas").append(info.mensajeYaCargadas);

                /*if(info.inventarios.length > 0) {
                    $("#bodyCargas").append(info.mensajeYaCargadas+" <br />  ");
                    var message ;
                     $.each(info.inventarios,function(index,value) {
                       
                    
                        $.ajax({
                            type: 'POST',
                            url: 'modelos/almacen_db.php', // call your php file
                            data: 'module=grabarInventarioElavon&info='+JSON.stringify(value),
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

                    tableInventario.ajax.reload(); 

                } else {
                    $("#bodyCargas").append(info.mensajeYaCargadas);
                } */
             

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus)
           }
        });
    })
	
	$("#btnCargar").on("click",function() {
		
		var tipo = $("#tipo").val();
        var fabricante = tipo == '1' ? $("#fabricante").val() : $("#carrier").val();
        var carrier = $("#carrier").val();
        var serie = $("#serie").val();
        var estatus = $("#estatus").val();
        var banco = $("#banco").val();
        
        if(serie === "" ) {

            $.toaster({
                message: 'Favor de Poner un numero de serie',
                title: 'Aviso',
                priority : 'danger'
            }); 

        } else { 

            $.ajax({
                type: 'GET',
                url: 'modelos/inventarioelavon_db.php', // call your php file
                data: 'module=agregarSerie&serie='+serie+'&estatus='+estatus+'&fabricante='+fabricante+"&carrier="+carrier+"&tipo="+tipo+'&banco='+banco,
                cache: false,
                success: function(data){

                    if(data == '0') {

                        $.toaster({
                            message: 'Se Actualizo la TPV o SIM',
                            title: 'Aviso',
                            priority : 'warning'
                        }); 


                    } else {
                       

                        $.toaster({
                            message: 'Se agrego con Exito  TPV o SIM',
                            title: 'Aviso',
                            priority : 'success'
                        }); 
                    }

                    tableInventario.ajax.reload();
                    $("#showAlta").modal("hide");
                    clear();
                     
                },
                error: function(error){
                    var demo = error;
                }
            });
		
        }
	})

     



});

function fnShowHide( colId,status )
{
    var table = $('#inventario').DataTable();
    table.column( colId ).visible( status ); 
}

function getBancosf() {

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getBancos',
        cache: true,
        success: function(data) {
            console.log(data);

            $("#banco").html(data);
            $("#bancoF").html(data);


        },
        error: function(error) {
            var demo = error;
        }
    });
}

function getFabricantes()
{
    $.ajax({
        type: 'GET',
        url: 'modelos/inventarioelavon_db.php',
        data: 'module=getFabricantesAlta',
        cache: true,
        success: function(data){
            $("#fabricante").html(data);
        },
        error: function(error){
            var demo = error;
        }
    })
}

function clear() {

    $("#colFabricante").hide();
    $("#colCarrier").hide();

    $("#tipo").val('0');
    $("#serie").val('');
    $("#estatus").val('');
    $("#fabricante").val('0');
    $("#carrier").val('0');
    $("#banco").val('0');

}
