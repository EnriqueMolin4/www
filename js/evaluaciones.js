 $(document).ready(function(){
     getTecnicos();
     getEvaluaciones();
     
     

     $('#evaluaciones').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            processing: true,
            serverSide: true,
            order: [[ 1, "asc" ]],
            dom: 'lfrtiBp',
            buttons: [
                'pdf',
                'excelHtml5',
                'csv'
            ],
            ajax: {
                url: 'modelos/evaluacion_db.php',
                type: 'POST',
                data: function( d ) {
                    d.module = 'getTable'
                }
            },
            columns : [
                { data: 'nombre'},
                { data: 'descripcion' },
                { data: 'fecha_creacion' },
                { data: 'archivo' },
                { data: 'fecha_modificacion'},
                { data: 'id'}   
            ],aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "10%",
                },
                {
                    "targets": [5],
                    "mRender": function ( data,type, row ) {
                        var boton = "";
                        boton += '<a title="Eliminar Información" href="#" class="delEval" data="'+data+'"><i class="fas fa-trash-alt fa-2x" style="color:#F5425D"></i></a>';
                      return boton;
                    }
                }
            ]
    })

     

     $("#btnGuardar").on("click", function() 
        { 
            var data = {
                'module' : 'subirEvaluacion',
                'nombre' : $("#nombre").val(),
                'descripcion': $("#descripcion").val()
            }
            if ( $("#nombre").val().length == 0 || $("#descripcion").val().length == 0) 
            {
                $.toaster({
                    message: 'No debes dejar campos vacíos',
                    title: 'Aviso',
                    priority: 'warning'
                });
            }
            else if (document.getElementById("excelMasivoE").files.length == 0) 
            {
                $.toaster({
                    message: 'Debes seleccionar un archivo',
                    title: 'Aviso',
                    priority: 'warning'
                });
            }
            else
                     
            {
                     $.ajax({
                    type: 'GET',
                    url: 'modelos/evaluacion_db.php',
                    data: data,
                    cache: false,
                    success: function(data){
                        var info = JSON.parse(data)
                        mensaje = "Se guardó la información, subiendo preguntas y respuestas."
                        //if (info.id) {}
                        var eid = info.id
                        if (eid >= 0) 
                        {
                            $.toaster({
                                message: mensaje,
                                title: 'Aviso',
                                priority: 'success'
                                 });
                            //$("#evaluaciones").DataTable().ajax.reload();
                            //SE EJECUTA FUNCION MASIVA
                                   
                                    $("#evaluaciones").DataTable().ajax.reload();
                                
                                    var form_data = new FormData();
                                    var excelMasivo = $("#excelMasivoE");
                                    var file_data = excelMasivo[0].files[0];
                                    form_data.append('file', file_data);
                                    form_data.append('eid', eid);
                                    form_data.append('module','evaluacionMasivo');

                                    $.ajax({
                                        type: 'POST',
                                        url: 'modelos/evaluacion_db.php', //call your php file
                                        data: form_data,
                                        processData: false,
                                        contentType: false,
                                        success: function(data, textStatus, jqXHR)
                                        {
                                            var info = JSON.parse(data);
                                                $.toaster({
                                                    message: 'Se cargaron '+info.contador+ 'preguntas',
                                                    title: 'Aviso',
                                                    priority: 'success'
                                                        })
                                        },
                                        error: function(jqXHR, textStatus, errorThrown)
                                        {
                                            alert(textStatus)
                                        }

                                    });
                        }
                            
                        else
                        {
                            $.toaster({
                                message: 'Esta evaluación ya fue registrada',
                                title: 'Aviso',
                                priority: 'danger'
                            });
                        }
                        
                    },
                    error: function(error)
                    {
                        var demo = error;
                    }
                    
                })
            }

                           /*  
                
                $.ajax({
                    type: 'POST',
                    url: 'modelos/evaluacion_db.php', //call your php file
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(data, textStatus, jqXHR){
                        var info = JSON.parse(data);
                        $.toaster({
                         message: 'Se cargaron '+info.contador+ 'preguntas',
                            title: 'Aviso',
                            priority: 'success'
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert(textStatus)
                    }

                });
                */

            
        })



    $(document).on("click", ".delEval", function(e){
            e.preventDefault();
            var id = $(this).attr('data');

            var eliminar = confirm("Se borrarán todos los registros relacionados con esta evaluación técnica, ¿Deseas continuar?");

            if (eliminar == true) 
            {
                
                $.ajax({
                    type:'GET',
                    url: 'modelos/evaluacion_db.php', // call your php file
                    data: {module:'delEvaluacion', id: id},
                    cache: false,
                    success: function(data){
                        var info = JSON.parse(data);
                        $.toaster({
                            message: 'Se eliminó la información de la evaluación',
                            title: 'Aviso',
                            priority: 'warning'
                        })
                        $("#evaluaciones").DataTable().ajax.reload();

                    },
                    error: function(error)
                    {
                        var demo = error;
                    }
                })
            }
        })  

    $(document).on("click", ".asignar", function(e){
        $("#modalAsignar").modal("show");
    })


    $("#btnAsignarEv").on('click', function(){
        var Tecnicos = JSON.stringify( $("#tecnicos").val() );
        var Evaluaciones = JSON.stringify( $("#evaluacionList").val() );

        if ( $("#tecnicos").val == "0" || $("#evaluacionList").val() == "0" ) 
        {
            $.toaster({
                message: 'Debes seleccionar en ambas listas',
                title: 'Aviso',
                priority: 'warning'
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: 'modelos/evaluacion_db.php',
                data: { module: 'guardar_asignaciones', tecnicos : Tecnicos, evaluaciones : Evaluaciones},
                cache: false,
                success: function(data, textStatus, jqXHR)
                {
                //alert("SE MANDARON LOS DATOS");
                    $("#modalAsignar").modal("hide");
                    cleartext()
                    $.toaster({
                        message: 'Se asignaron las evaluaciones',
                        title: 'Aviso',
                        priority: 'success'
                    });

               
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert(data)

                    $.toaster({
                        message: 'Error con la asignación',
                        title: 'Aviso',
                        priority: 'danger'
                    });
                }
            });


            $.ajax({
                type: 'POST',
                url: 'modelos/evaluacion_db.php',
                data: {module: 'inicio_evaluacion'},
                cache: false,
                success: function(data, textStatus, jqXHRj)
                {

                },
                error: function(jqXHR, textStatus, errorThrown)
                {

                }
            })

            $.ajax({
                type: 'POST',
                url: 'modelos/evaluacion_db.php',
                data: {module: 'fin_evaluacion'},
                cache: false,
                success: function(data, textStatus, jqXHRj)
                {

                },
                error: function(jqXHR, textStatus, errorThrown)
                {

                }
            })
        }
        
    })


    function getTecnicos()
    {
        $.ajax({
            type: 'GET',
            url: 'modelos/evaluacion_db.php',
            data: 'module=getTecnicos',
            cache: false,
            success: function(data){
                console.log(data);
                $("#tecnicos").html(data);
                //$('#tecnicos').multiselect('refresh');
                $('#tecnicos').multiselect({
                    enableFiltering: true,
                    includeSelectAllOption: true,
                    allSelectedText: 'Todos',
                    nonSelectedText: 'Seleccionar',
                    selectAllText: 'Seleccionar Todos'
                        });
            },
            error: function(){
                var demo = error;
            }
        })
    }

    function getEvaluaciones()
    {
        $.ajax({
            type: 'GET',
            url: 'modelos/evaluacion_db.php',
            data: 'module=getEvaluaciones',
            cache: false,
            success: function(data){
                console.log(data);
                $("#evaluacionList").html(data);
                /*$('#evaluacionList').multiselect({
                    nonSelectedText: 'Seleccionar'
                });*/

            },
            error: function()
            {
                var demo = error;
            }
        })
    }





})
