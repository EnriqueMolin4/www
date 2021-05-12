function registrar(){
	$(".cargando-gif").css({"display":"block"});
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (this.readyState == 4 && this.status == 200){
	  	$(".cargando-gif").css({"display":"none"});
		$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").css({"width":"600px"});
		$("#alerta-todo").css({"height":"300px"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
		$("#alerta-todo").css({"padding":"10px"});
		$("#texto").html(this.responseText);
	  }
	}

	var cve = $("#alt-com-cve_banco").val(),
	afiliacion = $("#alt-com-afiliacion").val(),
	comercio = $("#alt-com-comercio").val(),
	responsable = $("#alt-com-responsable").val(),
	propietario = $("#alt-com-propietario").val(),
	tipo_comercio = $("#alt-com-tipo_comercio").val(),
	estado = $("#alt-com-estado").val(),
	ciudad = $("#alt-com-ciudad").val(),
	colonia = $("#alt-com-colonia").val(),
	direccion = $("#alt-com-direccion").val(),
	rfc = $("#alt-com-rfc").val(),
	telefono = $("#alt-com-telefono").val(),
	email_ejecutivo = $("#alt-com-email_ejecutivo").val(),
	email = $("#alt-com-email").val(),
	territorial_banco = $("#alt-com-territorial_banco").val(),
	territorial_sinttecom = $("#alt-com-territorial_sinttecom").val(),
	hora_comida = $("#alt-com-hora_comida").val(),
	hora_general = $("#alt-com-hora_general").val(),
	razon_social = $("#alt-com-razon_social").val(),
	cp = $("#alt-com-cp").val(),

	form = "&cve="+cve+"&comercio="+comercio+"&responsable="+responsable+"&propietario="+propietario;
	form += "&tipo_comercio="+tipo_comercio+"&estado="+estado+"&ciudad="+ciudad;
	form += "&direccion="+direccion+"&colonia="+colonia+"&rfc="+rfc+"&afiliacion="+afiliacion;
	form += "&telefono="+telefono+"&razon_social="+razon_social+"&hora_general="+hora_general;
	form += "&email_ejecutivo="+email_ejecutivo+"&territorial_banco="+territorial_banco+"&email="+email;
	form += "&territorial_sinttecom="+territorial_sinttecom+"&hora_comida="+hora_comida+"&cp="+cp;
	
	xmlhttp.open("POST","modelos/comercios/alta_comercio.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(form);
}

