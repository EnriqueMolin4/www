 $(document).ready(function(){


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
                { data: 'fecha_modificacion'}
                //{ data: 'id'}   
            ]/*,aoColumnDefs: [
                {
                    "targets": [ 0 ],
                    "width": "10%",
                },
                {
                    "targets": [5],
                    "mRender": function ( data,type, row ) {
                        var boton = "";
                        console.log(row.estatus)
                    
                      if(row.activo == '1'){
                        boton += '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:#187CD0"></i>';
                        if($("#permusr").val() == '1') {
                        boton += '</a><a href="#" class="delCom" data="'+data+'"><i class="fas fa-times fa-2x" style="color:#E04242"></i></a>';
                        }
                      } else {
                        boton = '<a href="#" class="editCom" data="'+data+'"><i class="fas fa-edit fa-2x " style="color:blue"></i></a><a href="#" class="actCom" data="'+data+'"><i class="fas fa-check fa-2x" style="color:green"></i></a>';
                      }
                      return boton;
                    }
                }
            ]*/
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
                    message: 'Ingresa el nombre de la evaluación',
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
                        mensaje = "Se guardó la información."
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
                            
                            if (document.getElementById("excelMasivoE").files.length == 0) 
                                {
                                    $.toaster({
                                        message: 'No hay un archivo seleccionado.',
                                        title: 'Aviso',
                                        priority: 'danger'
                                    });
                                }else
                                {
                                    $.toaster({
                                        message: 'Inicia carga de preguntas y respuestas...',
                                        title: 'Aviso',
                                        priority: 'warning'
                                    });
                                    $("#evaluaciones").DataTable().ajax.reload();
                                    cleartext();
                                

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

 function cleartext()
 {
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#excelMasivoE").val("");
 }


})
