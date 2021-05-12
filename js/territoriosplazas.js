var infoAjax = 0;
var plazaTerritorio;
$(document).ready(function() {
        
  
    getPlazas();
    getAlmacenes();

    plazaTerritorio = $('#plaza_territorio').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        order: [[ 0, "asc" ]],
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "Todos"]],
        ajax: {
            url: 'modelos/territoriosplazas_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getplazaAlmacen',
                d.almacen = $("#almacenes").val(),
                d.plaza = $("#plazas").val()
            }
        },
        columns : [
            { data: 'Almacen'},
            { data: 'Plaza' },
            { data: 'id' },
            { data: 'almacen_id'},
            { data: 'plaza_id'}
        ],
        aoColumnDefs: [
            {
                "targets": [2],
                "mRender": function ( data,type, row ) 
                {
             
                    var button = '<a href="#" class="delPlaza" data="'+row.plaza_id+'-'+row.almacen_id+'"><i class="fas fa-times-circle fa-2x" style="color:red"></i></a>';

                    return button;
                
                }

            },
            {
                "targets": [3],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [4],
                "visible": false,
                "searchable": false
            }
        ]
    });

    $("#almacenes").on("change", function() {
        plazaTerritorio.ajax.reload();
    })
        
        
} );

    




function cleartext() {
    $("#cvebancaria").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_comercio").val("");
    $("#ciudad").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#rfc").val("")
    $("#email").val("")
    $("#email_ejecutivo").val("")
    $("#territorial_banco").val("")
    $("#territorial_sinttecom").val("")
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#razon_social").val("")
    $("#cp").val("")

}

function getTerritorios() {
    $.ajax({
        type: 'GET',
        url: 'modelos/territoriosplazas_db.php', // call your php file
        data: 'module=getTerritorios',
        cache: false,
        success: function(data){
             $("#territorios").html(data);       
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getPlazas() {
    $.ajax({
        type: 'GET',
        url: 'modelos/territoriosplazas_db.php', // call your php file
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

function getAlmacenes() {
    $.ajax({
        type: 'GET',
        url: 'modelos/territoriosplazas_db.php', // call your php file
        data: 'module=getAlmacenes',
        cache: false,
        success: function(data){
             $("#almacenes").html(data);       
        },
        error: function(error){
            var demo = error;
        }
    });
}

 

