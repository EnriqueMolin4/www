var infoAjax = 0;
var tblEventos,tblInventario,eventos,inventario;
$(document).ready(function() 
{
		ResetLeftMenuClass("submenureportes", "ulsubmenureportes","repbuscarserielink")
		
		tblEventos = $("#table_eventos").DataTable({
										 
			language: {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		searching: false,
		paging: false,
		info: false,
		"data" : (eventos),
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
	
		tblInventario = $("#table_inventario").DataTable({
									
			language: {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			searching: false,
			paging: false,
			info: false,
			"data" : (inventario),
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
				{ "data": "id_ubicacion" },
				{ "data": "modificado_por" },
				{ "data": "fecha_edicion" }
				
				],
		});

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
									tblEventos
										.clear()
										.draw(); 
									tblInventario
										.clear()
										.draw(); 

									var info = JSON.parse(data);
									tblEventos.rows.add(info.eventos)
													.draw();
									tblInventario.rows.add(info.inventario)
													.draw();
							
									 $('#table_eventos').css("display","");
									 $('#table_inventario').css("display","");
									 
									
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
                        }
                    },
                    error: function(error){
                        var demo = error;
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

    





