var infoAjax = 0;
var tablePeticiones;
var fecha_hoy;
$(document).ready(function() {
    getSupervisores();
	getPlazas();
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "peticioneslink")
    
    fecha_hoy = moment().format('YYYY-MM-DD');

    tablePeticiones = $('#tplPeticiones').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        order: [[ 0, "desc" ]],	  
        buttons: [{
            extend: 'excel',
            filename: 'Peticiones_'+fecha_hoy,
            exportOptions: {
                orthogonal: 'sort',
                columns: [2,3,5,6]
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
            url: 'modelos/almacen_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getPeticiones',
                d.supervisor = $("#supervisores").val(),
				//d.plaza = $("#plazas").val(),
                d.active = $("#activa").val();
            }
        },
        columns : [
            { data: 'id'},
            { data: 'activa'},
            { data: 'creadopor'},
            { data: 'creadopor'},
            { data: 'tecnico'},
            { data: 'almacen'},
            { data: 'fecha_creacion'},
            { data: 'modificado_por'}
        ],
        aoColumnDefs: [
            {
                "targets": [1],
                "mRender": function ( data, type, row ){
                    var boton = "";

                    if ( data == '0') 
                    {
                        boton = 'ACTIVA';
                    }else if ( data == '1')
                    {
                        boton = 'SURTIDA';
                    }

                    return boton;

                }
            },
            {
                "targets": [7],
                "mRender": function ( data,type, row ) {
              
                    return '<a href="#" title="Detalle Petición" class="mostrarDetalle" data-id="'+row.id+' "><i class="fas fa-info-circle fa-2x" style="color:#3489eb"></i></a> <a href="#" title="Eliminar Petición" class="eliminarPeticion" data="'+row.id+'"><i class="fas fa-trash-alt fa-2x" style="color:#F5425D"></i><a/>';

                }
            }
        ]
    });

    $(document).on("click",".mostrarDetalle", function() {
        var id = $(this).data('id');

        window.location.href = "detallepeticion.php?peticionId="+id;
    })



    $(document).on("click", ".eliminarPeticion", function(e){
        e.preventDefault();
        var id = $(this).attr('data');

        var eliminar = confirm("Se borrará esta petición. ¿Deseas continuar?");

        if (eliminar == true) 
        {
            $.ajax({
                type: 'GET',
                url: 'modelos/almacen_db.php', //call your php file
                data: {module: 'borrarPeticion', id: id},
                cache: false,
                success: function (data){
                    //var info = JSON.parse(data);

                    $.toaster({
                        message: 'Se eliminó la petición',
                        title: 'Aviso',
                        priority: 'warning'
                    });

                    $("#tplPeticiones").DataTable().ajax.reload();

                },
                error: function(error)
                {
                    var demo = error;
                }
            });
        }

    });

    $(".searchPeticiones").on('change', function(){
        $('#tplPeticiones').DataTable().ajax.reload();
    })


	
});

function getSupervisores() {

    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getSupervisores',
        cache: false,
        success: function(data){
           
            $("#supervisores").html(data);   
                 
        },
        error: function(error){
            var demo = error;
        }
    });
}


function getPlazas() {
	
	$.ajax({
		type: 'GET',
		url: 'modelos/almacen_db.php', // call your php file here
		data: 'module=getPlazas',
		cache: false,
		success: function(data){
				
			$("#plazas").html(data);
		},
		error: function(error){
			var demo = error;
		}
	});
}
