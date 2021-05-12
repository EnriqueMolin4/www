$(document).ready(function() {
	
	$("#doc_ingreso").datetimepicker({
        timepicker:false,
        format:'Y-m-d' 
    });

    $("#doc_alta").datetimepicker({
        timepicker:false,
        format:'Y-m-d' 
    });

    $("#doc_uniforme").datetimepicker({
        timepicker:false,
        format:'Y-m-d' 
    });

    $("#doc_fechabaja").datetimepicker({
        timepicker:false,
        format:'Y-m-d' 
    });

    $("#doc_reingreso").datetimepicker({
        timepicker:false,
        format:'Y-m-d' 
    });

    

    
    ResetLeftMenuClass("submenurecursos", "ulsubmenurecursos", "expedienteslink")
    $('#expedientes').DataTable({
        order: [[ 0, "desc" ]],
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [[5,10, 25, -1], [5, 10, 25, "All"]],
        dom: 'lfrtiBp',
        buttons: [
            'pdf',
            'excelHtml5',
            'csv'
        ],
        ajax: {
            url: 'modelos/expedientes_db.php',
            type: 'POST',
            data: function( d ) {
                d.module = 'getTable'
            }
        },
        columns : [
            { data: 'id'},
            { data: 'nombre' },
            { data: 'correo' },
            { data: 'puesto' },
            { data: 'fecha_alta'},
            { data: 'estatus'},
            { data: 'fecha_ingreso'}
              
        ],
        aoColumnDefs: [
            {
                "targets": [6],
                "mRender": function ( data,type, row ) {
                    return '<a href="#" class="editCom" data="'+row.id+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a>';
                }
            }
        ]
    });

    $("#btnNuevoExpediente").on("click", function() {
        $("#showExpediente").modal("show");
    })
	
	$("#btnGrabar").on('click',function() {
        var formData = $("#formExpediente").serializeArray();

       // alert( formData )

        $.ajax({
            type: 'GET',
            url: 'modelos/expedientes_db.php', // call your php file
            data: { module : 'saveExpediente', formData: formData },
            cache: false,
            success: function(data){
                var info = JSON.parse(data);
                alert(info);           
            },
            error: function(error){
                var demo = error;
            }
        });

    })
	
});