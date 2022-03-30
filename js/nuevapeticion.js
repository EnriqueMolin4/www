var infoAjax = 0;
var tableTraspasos,tableTraspasosItems;
$(document).ready(function() {
    
    ResetLeftMenuClass("submenualmacen", "ulsubmenualmacen", "traspasoslink")
    
    getAlmacenes();
    getAlmacenesO()
    getConectividad();
    getProducto();
    getPlazas();
	getInsumos();
    getBancos();
	campos_tipo();
	getCarrier();

      
    //TABLA DETALLE PETICIONES
    tableTraspasosItems = $('#tplDetalle').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "autoWidth": false,
        dom: 't',
        aoColumnDefs: [
            {
                "targets": [ 9 ],
                "visible": true,
                "searchable": false
            },
            {
                "targets": [ 10 ],
                "visible": true,
                "searchable": false
            },
            {
                "targets": [ 11 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 12 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 13 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 14 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 15 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 16 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 17 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 18 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [19],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [20],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [21],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [22],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [23],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [24],
                "mRender": function ( data,type, row ) {
              
                    return '<a href="#" class="btn btn-danger delRow">Borrar</a>';
                }
            }
        ]	  
    });

    $('#tplDetalle tbody').on( 'click', '.delRow', function () {
        tableTraspasosItems
            .row( $(this).parents('tr') )
            .remove()
            .draw();
    } );

    $("#plaza").on("change", function() {
        getTecnicos( $(this).val()  );
    })

    $("#btnAdd").on('click',function() {
        var error = 0;
		var insumo = '';
        var insumoId = 0;
        var conectividad = '';
        var conectividadId = 0;
        var producto = '';
        var productoId = 0;
        var carrier = '';
		var carrierId = 0;

        var comentario_supervisor = document.getElementById("comentario_supervisor").value;

        switch( $("#tipo").val() ) 
		{
            case "1":
                conectividad = $("#conectividad option:selected" ).text();
                conectividadId = $("#conectividad").val();
                producto = $("#producto option:selected" ).text();
                productoId = $("#producto").val();
            break;
			case "2":
                carrier = $("#carrier option:selected").text();
				carrierId = $("#carrier").val();
			break
            case "3":
                insumo =  $("#insumo option:selected" ).text();
                insumoId =  $("#insumo").val();
            break;
        }


        if ($("#tipo_peticion").val() == "1") 
        {
            if ( $("#plaza").val() == "0" || $("#tecnico").val() == "0" )
                {
                    $.toaster({
                    message: 'Favor de seleccionar la plaza y el técnico',
                    title: 'Aviso',
                    priority : 'danger'
                    });
                        
                    error++;
                        
                }else if ( $("#tipo").val() == "0" )
                {
                    $.toaster({
                    message: 'Seleccionar tipo',
                    title: 'Aviso',
                    priority : 'danger'
                    });
                                  
                    error++;
                        
                }
        }
        else if ($("#tipo_peticion").val() == "2") 
        {
            if ( $("#almacen_origen").val() == "0" || $("#almacen_destino").val() == "0" )
                {
                    $.toaster({
                    message: 'Favor de seleccionar almacenes',
                    title: 'Aviso',
                    priority : 'danger'
                    });
                        
                    error++;
                        
                }
                else if ( $("#tipo").val() == "0" )
                {
                    $.toaster({
                    message: 'Seleccionar tipo',
                    title: 'Aviso',
                    priority : 'danger'
                    });
                                  
                    error++;
                        
                }else if ($("#almacen_origen").val() == $("#almacen_destino").val()) 
                {
                    $.toaster({
                    message: 'Los almacenes no pueden ser los mismos',
                    title: 'Aviso',
                    priority : 'danger'
                    });
                                  
                    error++;
                }    
        }

        if ( $("#banco").val() == "0" ) 
        {
            $.toaster({
                message: 'Favor de seleccionar el banco',
                title: 'Aviso',
                priority : 'danger'
                      });
              error++;
        }
        
		
		if ( $("#tipo").val() == "1" )
		{
			if ( $("#conectividad").val() == "0" || $("#producto").val() == "0" || $("#estatus").val() == "0" )
			{
				$.toaster({
				message: 'Revisar Estatus, Conectividad y Producto',
				title: 'Aviso',
				priority : 'danger'
                      });
			  error++;
			}else if ( $("#cantidad").val() == "" )
			{
				$.toaster({
				message: 'Favor de ingresar la cantidad',
				title: 'Aviso',
				priority : 'danger'
                      });
				error++;
			}
		}
		else if ( $("#tipo").val() == "2" )
		{
			if ( $("#cantidad").val() == "" )
			{
				$.toaster({
				message: 'Favor de ingresar la cantidad',
				title: 'Aviso',
				priority : 'danger'
                      });
				error++;
				
			} 
			
		}
		
		if ( $("#tipo").val() == "3" )
		{
			if ( $("#insumo").val() == "0" || $("#cantidad").val() == "" )
			{
				$.toaster({
				message: 'Favor de elegir insumo e ingresar la cantidad',
				title: 'Aviso',
				priority : 'danger'
                      });
				error++;
			}
				
		}
		
	if(error == 0){
        tableTraspasosItems.row.add( 
            [   
                $("#banco option:selected").text(),
                $("#tipo option:selected" ).text(),
                $("#almacen_origen option:selected").text(),
                $("#almacen_destino option:selected").text(),
                $("#tecnico option:selected" ).text(),
                $("#estatus option:selected" ).text(),
                insumo,
                carrier,
                conectividad,
                producto,
				$("#cantidad").val(),
                $("#banco").val(),
                $("#almacen_origen").val(),
                $("#almacen_destino").val(),
                comentario_supervisor,
				$("#tipo_envio option:selected").text(),
                $("#direccion_envio option:selected").text(),
				
                
                $("#tipo").val(),
                $("#tecnico").val(),
                $("#estatus").val(),
                insumoId,
                carrierId,
                $("#conectividad").val(),
                $("#producto").val(),
		        $("#carrier").val()
			] ).draw( false );

            
        $("#tipo").val('0');
        $("#conectividad").val("0");
        $("#producto").val("0");
        $("#estatus").val("0");
        $("#insumo").val("0");
        $("#carrier").val("0");
        $("#cantidad").val("0");
        $("#banco").val("0");
        campos_tipo();
        tableTraspasosItems.columns.adjust().draw();
	}
 
    });

	$("#btnPeticion").on('click', function()
	{
			var data = tableTraspasosItems.rows().data();
			var datosEnviar=[];
			console.log(data);
			
			$.each(data, function(index,value) {               

				var valueToPush = new Object();
                valueToPush['banco'] = value[11];
                valueToPush['almacen_origen'] = value[12];
                valueToPush['almacen_destino'] = value[13];
                valueToPush['comentario_supervisior'] = value[14];
                valueToPush['tipo_envio'] = value[15];
                valueToPush['direccion_envio'] = value[16];
				valueToPush["tipo"] = value[17];
				valueToPush["tecnico"] = value[18];
				valueToPush["estatus"] = value[19];
				valueToPush["insumo"] = value[20];
                valueToPush["carrier"] = value[21];
				valueToPush["conectividad"] = value[22];
                valueToPush["producto"] = value[23];
                valueToPush["cantidad"] = value[10];
				datosEnviar.push(valueToPush);
                
				})
                
                console.log(datosEnviar)
				
			$.ajax({ 
					type: 'POST',
					url : 'modelos/almacen_db.php',
					data: 'module=guardarPeticion&array='+JSON.stringify(datosEnviar),
					cache: false,
					success: function(data){
						
					
					  $.toaster({
                            message: 'Se guardaron los datos',
                            title: 'Aviso',
                            priority : 'success'
                        }); 
						cleartext();
                        window.location.href = "peticiones.php";
					},
					error: function(error){
						var demo = error;
					}
			})					
	});
	
	$("#btnRegresar").on("click", function() {
        window.location.href = "peticiones.php";
    })
	
	
	
	
});

/*Peticiones opciones*/
	function campos_tipo() {
	
	var val = document.getElementById("tipo").value;
    var valP = document.getElementById("tipo_peticion").value;
	
        if (valP == "1") 
        {
            $("#divPlaza").show();
            $("#divTecnico").show();
            $("#almO").hide();
            $("#almD").hide();
        }
        if (valP == "2") 
        {
            $("#almO").show();
            $("#almD").show();
             $("#divPlaza").hide();
            $("#divTecnico").hide();
        }

		if (val === "0") 
		{
			$("#divIns").hide();
			$("#divCan").hide();
			$("#divTpv").hide();
			$("#divStat").hide();
			$("#divCarrier").hide();
		}
	
		if (val === "1") 
		{
            $("#divTpv").show();
            $("#divCan").show();
            $("#divStat").show();
            $("#divIns").hide();
			$("#divCarrier").hide();
		}
		
		if (val === "2")
		{
			$("#divCan").show();
			$("#divStat").show();
            $("#divTpv").hide();
            $("#divIns").hide();
			$("#divCarrier").show();
		}
		
		if (val === "3")
		{
			$("#divIns").show();
			$("#divCan").show();
			$("#divTpv").hide();
			$("#divStat").show();
			$("#divCarrier").hide();
			
		}
}
	

function getPlazas() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getPlazasbyAlmacen',
        cache: false,
        success: function(data){
             
            $("#plaza").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getInsumos() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getInsumos',
        cache: false,
        success: function(data){
             
            $("#insumo").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getProducto() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getProducto',
        cache: false,
        success: function(data){
             
            $("#producto").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getCarrier() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getCarriers',
        cache: false,
        success: function(data){
             
            $("#carrier").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getConectividad() {
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getConectividad',
        cache: false,
        success: function(data){
             
            $("#conectividad").html(data);
			
			
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getTecnicos(plaza) {
	
	
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getTecnicoxPlaza&plaza='+plaza,
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
           
            $("#almacen_origen").html(data);   
            $("#almacen_destino").html(data);
		
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getAlmacenesO()
{
    $.ajax({
        type: 'GET',
        url: 'modelos/almacen_db.php', // call your php file
        data: 'module=getAlmacenO',
        cache: false,
        success: function(data){
           
            $("#almacen_origen").html(data);   
                
        },
        error: function(error){
            var demo = error;
        }
    });
}

function getBancos()
{
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getBancos',
        cache: false,
        success: function(data){
            //console.log(data);
        $("#banco").html(data);
      
        },
        error: function(error){
            var demo = error;
        }
    });
}

function enableCB() {

    tableTraspasos.ajax.reload();
    
    if($("#userPerm").val() == 'admin' || $("#userPerm").val() == 'CA' || $("#userPerm").val() == 'AL' ) {
        $("#almacen").attr('disabled',false);
    } else {
        $("#almacen").attr('disabled',true);
    }
}



function cleartext()
{ 
    $("#tecnico").val("0");
    $("#plaza").val("0");
	$("#tipo").val('0');
    $("#conectividad").val("0");
    $("#producto").val("0");
    $("#estatus").val("0");
    $("#insumo").val("0");
	$("#cantidad").val("0");
    $("#banco").val("0");


}






