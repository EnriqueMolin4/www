function info_comercio(data){
	var afiliacion = data.getAttribute("data-afiliacion");
	var cve = data.getAttribute("data-cve");

	if(data.value == "CONSULTAR"){
		var form = "&afiliacion="+afiliacion+"&cve="+cve;
		$.ajax({
		    url: "modelos/consulta_comercio.php",
		    type: "post",
			data: form,
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			var arr = JSON.parse(res);
			$("#alt-com-cve_banco").val(arr[0].cve_banco);
			$("#alt-com-direccion").val(arr[0].direccion);
			$("#alt-com-afiliacion").val(arr[0].afiliacion);
			$("#alt-com-comercio").val(arr[0].comercio);
			$("#alt-com-responsable").val(arr[0].responsable);
			$("#alt-com-propietario").val(arr[0].propietario);
			if(arr[0].tipo_comercio == 'NORMAL' || arr[0].tipo_comercio == 'normal'){
				$("#alt-com-tipo_comercio option[value='normal']").attr("selected",true);
			}
			else{
				$("#alt-com-tipo_comercio option[value='vip']").attr("selected",true);
			}
			$("#alt-com-territorio_banco").val(arr[0].territorio_banco);
			$("#alt-com-territorio_sinttecom").val(arr[0].territorio_sinttecom);
			$("#alt-com-telefono").val(arr[0].telefono);
			$("#alt-com-cp").val(arr[0].cp);
			$("#alt-com-estado").val(arr[0].estado);
			$("#alt-com-ciudad").val(arr[0].ciudad);
			$("#alt-com-rfc").val(arr[0].rfc);
			$("#alt-com-razon_social").val(arr[0].razon_social);
			$("#alt-com-email").val(arr[0].email);
			$("#alt-com-email_ejecutivo").val(arr[0].email_ejecutivo);
			$("#alt-com-hora_general").val(arr[0].hora_general);
			$("#alt-com-hora_comida").val(arr[0].hora_comida);
			$("#alt-com-colonia").val(arr[0].colonia);
			$("#alt-com-cve_banco").val(arr[0].cve_banco);
			$("#alt-com-territorial_banco").val(arr[0].territorial_banco);
			$("#alt-com-territorial_sinttecom").val(arr[0].territorial_sinttecom);
		});
	}
	else{
		data.parentNode.parentNode.setAttribute('id','comercio-td-eliminar');
		$("#alerta-comercio").css({"display":"block","width":"500px","height":"220px","border":"solid 8px #006799"});
		$("#alerta-comercio").animate({opacity:"1",top:"23px"},100);
		$("#alerta-comercio").html("<br><br><strong><center>SEGURO QUE QUIERES ELIMINAR EL COMERICO CON AFILIACION: '"+
		afiliacion+"' Y CLAVE BANCARIA: '"+cve+"'.</center></strong>"+
		"<br><br><br><input type='button' data-cve='"+cve+"' data-afiliacion='"+afiliacion+"'"+
		"class='boton' value='ELIMINAR' style='width:25%;margin-left:15%;'"+
		"onclick='eliminar_comercio(this)'>"+
		"<input type='button'class='boton' value='CANCELAR' style='width:25%;margin-left:15%;'"+
		"onclick='eliminar_comercio(this)'>");
	}
}

function eliminar_comercio(data){
	var afiliacion = data.getAttribute("data-afiliacion");
	var cve = data.getAttribute("data-cve");

	if(data.value == 'CANCELAR'){
		$("#alerta-comercio").animate({opacity:"0",top:"13px"},100);
		$("#alerta-comercio").css({"display":"none"});
		$("#comercio-td-eliminar").removeAttr('id');
	}
	else{
		$.ajax({
		    url: "modelos/comercios/eliminar_comercio.php",
		    type: "post",
			data: "&cve="+cve+"&afiliacion="+afiliacion,
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			if(res == '1'){
				$("#alerta-comercio").css({"display":"block","width":"500px","height":"200px","border":"solid 8px #006799"});
				$("#alerta-comercio").animate({opacity:"1",top:"23px"},100);
				$("#alerta-comercio").html("<br><br><br><label><center><strong>"+
					"SE ELIMINO EL COMERCIO EXITOSAMENTE</strong></center></label>");
				setTimeout(function(){$("#alerta-comercio").css({"display":"none"});},2000);
				$("#comercio-td-eliminar").css({"display":"none"});
			}
			else{
				$("#alerta-comercio").css({"display":"block","width":"500px","height":"200px","border":"solid 8px #006799"});
				$("#alerta-comercio").animate({opacity:"1",top:"23px"},100);
				$("#alerta-comercio").html(res);
				setTimeout(function(){$("#alerta-comercio").css({"display":"none"});},2000);
			}
		});
	}
}