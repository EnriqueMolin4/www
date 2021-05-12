function registrar_evento(){

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (this.readyState == 4 && this.status == 200){
	  	$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},100);
		$("#alerta-todo").css({"width":"500px","height":"220px"});
	  	$("#texto").html(this.responseText);
	  }
	}

	var comercio =    $("#alt-eve-comercio").val(),
	cve =		      $("#alt-eve-cve_banco").val(),
	direccion =	      $("#alt-eve-direccion").val(),
	colonia =	      $("#alt-eve-colonia").val(),
	afiliacion =      $("#busqueda-afiliaciones").val(),
	ip_caja =	      '0';
	territorio =      '0';
	estado =	      $("#alt-eve-estado").val(),
	municipio =	      $("#alt-eve-municipio").val(),
	folio_telecarga = '0';
	email =			  $("#alt-eve-email").val(),
	tipo_servicio =	  $("#alt-eve-servicios").val(),
	tipo_falla =	  $("#alt-eve-tipo_falla").val(),
	telefono =		  $("#alt-eve-telefono").val(),
	responsable =	  $("#alt-eve-responsable").val(),
	hora_atencion =	  $("#alt-eve-hora_atencion").val(),
	descripcion =	  $("#alt-eve-descripcion").val(),
	comentarios =	  '0';
	hora_comida =	  $("#alt-eve-hora_comida").val(),
	ticket =	  	  $("#alt-eve-ticket").val(),
	terminal =		  $("#alt-eve-terminal").val(),

	form = "&afiliacion="+afiliacion+"&hora_atencion="+hora_atencion+"&ip_caja="+ip_caja+"&comercio="+comercio+"&responsable="+responsable;
	form += "&telefono="+telefono+"&descripcion="+descripcion+"&folio_telecarga="+folio_telecarga+"&direccion="+direccion+"&colonia="+colonia;
	form += "&comentarios="+comentarios+"&tipo_servicio="+tipo_servicio+"&terminal="+terminal+"&email="+email+"&hora_comida="+hora_comida;
	form += "&territorio="+territorio+"&estado="+estado+"&municipio="+municipio+"&cve="+cve+"&tipo_falla="+tipo_falla+"&ticket="+ticket;
	xmlhttp.open("POST","modelos/registro_evento.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(form);
	console.log(form);
	setTimeout(function(){
		$.ajax({
	    url: "modelos/consulta_buscar_eventos.php",
	    type: "post",
		data: "&data=1",
		contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			$("#vista-evento").html(res);
		});
	},1000);
}