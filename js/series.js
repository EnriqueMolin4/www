

var infoAjax = 0;
$(document).ready(function() 
{
       ResetLeftMenuClass("submenureportes","ulsubmenureportes","buscarserielink");
	   
        $(document).on("click","#btnSerie", function() 
        {
			
            var serie = $("#InSerie").val().toUpperCase();
            
            if(serie.length > 0 ) 
            {

                $.ajax({
                    type: 'GET',
                    url: 'modelos/almacen_db.php', // call your php file
                    data: 'module=getSerie&serie='+serie,
                    cache: false,
                    success: function(data)
                    {
                        var info = JSON.parse(data);
                
                        if( !jQuery.isEmptyObject(info)  ) 
                        {
							
							//Llamada a la función para traer los datos de ambas consultas
                             $.ajax({
								 type: 'GET',
								 url: 'modelos/almacen_db.php',
								 data: 'module=getSeriesIE&serie='+serie,
								 cahe: false,
								 success: function(data)
								 {
									 var info = JSON.parse(data);
									 
									 $('#table_eventos').css("display","");
									 $('#table_inventario').css("display","");
									 
									 
										var tblEventos = $("#table_eventos").DataTable({
										 
										 language: {
										"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
										},
										 searching: false,
										"data" : (info.eventos),
										"columns": [
											{ "data": "odt" },
											{ "data": "ultima_mod" },
											{ "data": "afiliacion" },
											{ "data": "tpv_instalado" },
											{ "data": "tpv_retirado" },
											{ "data": "servicio" },
											{ "data": "tecnico" },
											{ "data": "modificado_por" }
											]
										});
									 
									 
									
									
									
										var tblInventario = $("#table_inventario").DataTable({
										 
										language: {
										"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
										},
										 searching: false,
										
										"data" : (info.inventario),
										"columns": [
											{ "data": "no_serie" },
											{ "data": "modelo" },
											{ "data": "conectividad" },
											{ "data": "estatus" },
											{ "data": "estatus_inventario" },
											{ "data": "anaquel" },
											{ "data": "caja" },
											{ "data": "tarima" },
											{ "data": "cantidad" },
											{ "data": "ubicacion" },
											{ "data": "ubicacionNombre" },
											{ "data": "quien_modifica" },
											{ "data": "fecha_edicion" }
											
											]
										});
									},
										  
									 
								 
								 error: function(error)
								 {
									 var demo = error;
								 }
							 });
				
                        }

						else {
                            $.toaster({
                                message: 'No existe la serie capturada',
                                title: 'Aviso',
                                priority : 'danger'
                            });  
							$('#table_eventos').DataTable().ajax.reload();
							$('#table_inventarios').DataTable().ajax.reload();
                        }
                    },
                    error: function(error){
                        var demo = error;
						//$('#table_eventos').DataTable().ajax.reload();
						//$('#table_inventarios').DataTable().ajax.reload();
                    }
                });
            
            } else {
                $.toaster({
                    message: 'Favor de capturar la serie',
                    title: 'Aviso',
                    priority : 'warning'
                });  
            }
				
        })
              
});

    





