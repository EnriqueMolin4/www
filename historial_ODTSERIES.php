<div class="row">
				
    <table id="table_eventos" class="table table-md table-bordered" style="width:100%;display:none">
        <thead>
            <tr>
                <th>ODT</th>
                <th>Última Modificación</th>
                <th>Afiliación</th>
                <th>Tpv Instalado</th>
                <th>Tpv Retirado</th>
                <th>Servicio</th>
                <th>Técnico</th>
                <th>Modificado Por</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        
    </table>
    
</div>
            
<br>
<!-- Tabla Inventario -->

<div class="row">
        
        <table id="table_inventario" class="table table-md table-bordered" style="width:100%;display:none">
            <thead>
                <tr>
                    <th>Serie</th>
                    <th>Modelo</th>
                    <th>Conectividad</th>
                    <th>Estatus</th>
                    <th>Estatus Inventario</th>
                    <th>Anaquel</th>
                    <th>Caja</th>
                    <th>Tarima</th>
                    <th>Cantidad</th>
                    <th>Ubicación</th>
                    <th>Ubicación Nombre</th>
                    <th>Quien Modifica</th>
                    <th>Fecha Edición</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        
</div>
<script>
var infoAjax = 0;
var tblEventosHist,tblInventarioHist,eventos,inventarios;
$(document).ready(function() 
{
		ResetLeftMenuClass("submenureportes", "ulsubmenureportes","repbuscarserielink")

		tblEventosHist = $("#table_eventos").DataTable({							 
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
	
		tblInventarioHist = $("#table_inventario").DataTable({					
			language: {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			searching: false,
			paging: false,
			info: false,
			"data" : (inventarios),
			"columns": [
				{ "width": "20%", "data": "no_serie" },
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
				
				],
			fixedColumns: true
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
									tblEventosHist
										.clear()
										.draw(); 
									tblInventarioHist
										.clear()
										.draw(); 

									var info = JSON.parse(data);
									tblEventosHist.rows.add(info.eventos)
													.draw();
									tblInventarioHist.rows.add(info.inventario)
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
</script>