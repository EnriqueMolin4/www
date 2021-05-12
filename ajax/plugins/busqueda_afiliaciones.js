function busqueda_afiliaciones_input(valor){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (this.readyState == 4 && this.status == 200){
	  	if(this.responseText.length == 0){
			$("#vista-busqueda-label-odt_evento").css({"display":"none"});
			$("#vista-busqueda-odt_evento").css({"display":"none"});
			document.getElementById("vista-busqueda-afiliaciones").innerHTML = this.responseText;
	  	}
	  	else{
	  		document.getElementById("vista-busqueda-afiliaciones").innerHTML = this.responseText;
	  	}
	console.log(this.responseText);
	  }
	}
	var afiliacion = document.getElementById("busqueda-afiliaciones").value

	xmlhttp.open("POST","modelos/plugins/busqueda_afiliaciones.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("&afiliacion="+afiliacion);
	document.getElementById("vista-busqueda-afiliaciones").style.display = "block";
	if(valor.length == 0){
		document.getElementById("vista-busqueda-afiliaciones").style.display = "none";
		$("#vista-busqueda-label-odt_evento").css({"display":"none"});
		$("#vista-busqueda-odt_evento").css({"display":"none"});
	}
	$("#muestra-evento").css({"display":"none"});
	$("#ajuste-evento").css({"display":"none"});
	$("#vista-busqueda-odt_evento").css({"display":"none"});
}
function quitar_busqueda(){
	document.getElementById("vista-busqueda-afiliaciones").style.display = "none";
}
function buscar_odt_evento(valor,data){
	var afiliacion = data.getAttribute("afiliacion");
	var odt = valor;
	$.ajax({
	    url: "modelos/consulta_evento.php",
	    type: "post",
		data: "&afiliacion_eve="+afiliacion+"&odt_eve="+odt,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		var arr = JSON.parse(res);
		$("#muestra-evento").css({"display":"block"});
		if(res.length > 0){
			$("#muestra-evento").html(
			"<table id='reg-eve-table-datos'>"+
			"<tr>"+
				"<td><div>O.D.T: </div>"+
				"<div>"+arr[0].odt+"</div></td>"+
				"<td><div>Afiliacion: </div>"+
				"<div>"+arr[0].afiliacion+"</div></td>"+
				"<td><div>Comercio: </div>"+
				"<div>"+arr[0].comercio+"</div></td>"+
				"<td><div>Estatus: </div>"+
				"<div>"+arr[0].estatus+"</div></td>"+
				"<td><div>Servicio: </div>"+
				"<div>"+arr[0].servicio+"</div></td>"+
			"</tr>"+
			"<tr>"+
				"<td><div>Tipo Comercio: </div>"+
				"<div>"+arr[0].tipo_servicio+"</div></td>"+
				"<td><div>Tecnico: </div>"+
				"<div>"+arr[0].tecnico+"</div></td>"+
				"<td><div>Terminal: </div>"+
				"<div>"+arr[0].terminal+"</div></td>"+
				"<td><div>Fecha Alta: </div>"+
				"<div>"+arr[0].fecha_alta+"</div></td>"+
				"<td><div>Fecha Cierre: </div>"+
				"<div>"+arr[0].fecha_cierre+"</div></td>"+
			"</tr>"+
			"<tr>"+
				"<td colspan='4' style='width:77%;'><div>Descripcion: </div>"+
				"<div style='height:50px;max-width:100%;overflow:scroll;'>"+arr[0].descripcion+" </div></td>"+
				'<td>'+
					// '<form method="post" action="modelos/consultar_imgs_odt.php">'+
						'<input style="width:100%" type="submit" ticket="'+arr[0].ticket+'" onclick="consulta_img_odt(this.value,this)" id="odt_img_valor" class="boton" value="'+arr[0].odt+'">'+
					// '</form>'+
				'</td>'+
			"</tr>"+
			"</table>");
		}


		$("#selectTerritorios-regEve").css({"display":"none"});
		$("#selectTerritorios-regEve-input").css({"display":"block"});
		$("#selectTerritorios-regEve-input").val(arr[0].territorio);

		$("#selectEstados-regEve").css({"display":"none"});
		$("#selectEstados-regEve-input").css({"display":"block"});
		$("#selectEstados-regEve-input").val(arr[0].estado);

		$("#selectMunicipios-regEve").css({"display":"none"});
		$("#selectMunicipios-regEve-input").css({"display":"block"});
		$("#selectMunicipios-regEve-input").val(arr[0].municipio);

		$("#alt-eve-terminal").css({"display":"none"});

		$("#alt-eve-servicios").css({"display":"none"});
		$("#alt-eve-servicios-input").css({"display":"block"});
		$("#alt-eve-servicios-input").val(arr[0].tipo_servicio);

		$("#registro-evento > table").css({"display":"block"});
	});
}
function consulta_img_odt(val,data){
	var ticket = data.getAttribute("ticket");
	$.ajax({
	    url: "modelos/imgs_con/consultar_imgs_odt.php",
	    type: "post",
		data: "&odt="+val+"&ticket="+ticket,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},100);
		$("#alerta-todo").css({"width":"500px","height":"520px"});
		$("#texto").html(res);
	});
}
function ingresar_valor(valor,data_cve){
	var cve = data_cve.getAttribute("cve");
	$("#muestra-evento").css({"display":"none"});
	$("#ajuste-evento").css({"display":"block"});
	$("#muestra-evento").html(registro);
	document.getElementById("busqueda-afiliaciones").value = valor;
	$.ajax({
	    url: "modelos/consulta_comercio.php",
	    type: "post",
		data: "&afiliacion="+valor+"&cve="+cve,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		if(res.length > 0){
			var arr = JSON.parse(res);
			$("#alt-eve-cve_banco").val(arr[0].cve_banco);
			$("#alt-eve-afiliacion").val(arr[0].afiliacion);
			$("#alt-eve-comercio").val(arr[0].comercio);
			$("#alt-eve-direccion").val(arr[0].direccion);
			$("#alt-eve-estado").val(arr[0].estado);
			$("#alt-eve-municipio").val(arr[0].ciudad);
			$("#alt-eve-colonia").val(arr[0].colonia);

			var terminales = "<option value='0'>SELECCIONA TERMINAL</option>";
			for(var i = 0; i <= arr.length-1;i++){
				terminales += '<option value="'+arr[i].terminal+'">'+arr[i].terminal+'</option>';
			}
			$("#alt-eve-terminal").html(terminales);
		}
	});
	$.ajax({
	    url: "modelos/consulta_evento.php",
	    type: "post",
		data: "&afiliacion="+valor+"&cve="+cve,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		if(res.length > 0){
			$("#reg-nuevo-evento").css({"display":"inline"});
			var arr = JSON.parse(res);
			var afiliacion = arr[0].afiliacion;
			$.ajax({
			    url: "modelos/buscar_evento_registro.php",
			    type: "post",
				data: "&afiliacion="+afiliacion,
				contentType: "application/x-www-form-urlencoded",
			}).done(function(res){
				$("#vista-busqueda-label-odt_evento").css({"display":"block"});
				$("#vista-busqueda-odt_evento").css({"display":"block"});
				$("#vista-busqueda-odt_evento").html(res);
			});
		}
		else{
			$("#alt-eve-terminal").html("<option value=''>SELECCIONA EQUIPO</option><option value='otro'>OTRO...</option>");

			$("#reg-nuevo-evento").css({"display":"none"});
			$("#muestra-evento").css({"display":"block"});
			$("#vista-busqueda-label-odt_evento").css({"display":"block"});
			$("#vista-busqueda-odt_evento").css({"display":"block"});
			$("#vista-busqueda-odt_evento").html("<center><label>NO HAY EVENTOS PARA ESTA AFILIACION</label></center>");
			$("#registro-evento > table").css({"display":"block"});
		}
	});
}
function buscar_odt(odt){
	var afili_odt = $("#busqueda-afiliaciones").val();
	$.ajax({
	    url: "modelos/buscar_evento_registro.php",
	    type: "post",
		data: "&odt="+odt+"&afili_odt="+afili_odt,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		if(res.length > 0){
			$("#vista-busqueda-odt_evento").html(res);
		}
		else{
			$("#vista-busqueda-odt_evento").html("<center><label>NO HAY EVENTOS PARA ESTA AFILIACION</label></center>");
		}
	});
}
function nuevo_evento(){
	var cve = $("#alt-eve-cve_banco").val();
	var afiliacion = $("#busqueda-afiliaciones").val();
	$("#muestra-evento").css({"display":"block"});
	// $("#muestra-evento").html("<img src='view/img/loading.gif'>");
	$("#muestra-evento").html(registro);
	$.ajax({
	    url: "modelos/consulta_comercio.php",
	    type: "post",
		data: "&afiliacion="+afiliacion+"&cve="+cve,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		traer_eve(res);
	});
}
function traer_eve(res){
	setTimeout(function(){
		var arr = JSON.parse(res);
		$.ajax({
		   url: "modelos/consulta_evento.php",
		   type: "post",
		data: "&key_terminales=1&afiliacion="+arr[0].afiliacion+"&cve="+arr[0].cve_banco,
		contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			console.log(res);
			$("#alt-eve-terminal").html(res);
		});
		$("#alt-eve-cve_banco").val(arr[0].cve_banco);
		$("#alt-eve-comercio").val(arr[0].comercio);
		$("#alt-eve-afiliacion").val(arr[0].afiliacion);
		$("#alt-eve-direccion").val(arr[0].direccion);
		$("#alt-eve-colonia").val(arr[0].colonia);
		$("#alt-eve-estado").val(arr[0].estado);
		$("#alt-eve-municipio").val(arr[0].ciudad);
	},300);
}
function fallas(val){
	if(val == 'Mantenimiento Correctivo'){
		$("#alt-eve-tipo_falla").html(
			"<option value=''>SELECCIONA FALLA</option>"+
			"<option value='Terminal Bloqueado'>Terminal Bloqueado</option>"+
			"<option value='CPU no responde'>CPU no responde</option>"+
			"<option value='Retener tarjeta'>Retener tarjeta</option>"+
			"<option value='Credito insuficiente'>Credito insuficiente</option>"+
			"<option value='Host no responde'>Host no responde</option>"+
			"<option value='llame a banco'>llame a banco</option>"+
			"<option value='Chip danado'>Chip dañado</option>"+
			"<option value='Terminal Pos invalida'>Terminal Pos invalida</option>");
	}
	else{
		$("#alt-eve-tipo_falla").html("<option value=''>SELECCIONA FALLA</option>");
	}
	$("#td-alt-eve-tipo_falla").css({"display":"block"});
}
var registro = '<table id="reg-eve-tabla-evento"><tr><td>'+
	'<div>'+
		'<label>CVE Bancaria:</label><br>'+
		'<input class="input-largo" style="width:95px;" type="text" id="alt-eve-cve_banco" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Afiliacion:</label><br>'+
		'<input class="input-largo" type="text" style="width:95px;" id="alt-eve-afiliacion" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Comercio</label><br>'+
		'<input class="input-largo" type="text" style="width:270px;" id="alt-eve-comercio" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Direccion</label><br>'+
		'<input class="input-largo" type="text" style="width:310px;" id="alt-eve-direccion" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Estado</label><br>'+
		'<input class="input-largo" type="text" style="width:130px;" id="alt-eve-estado" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Colonia</label><br>'+
		'<input class="input-largo" type="text" id="alt-eve-colonia" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Tipo de Servicio</label><br>'+
		'<input style="display:none;" type="text" class="input-largo" id="alt-eve-servicios-input" disabled>'+
		'<select onchange="fallas(this.value)" class="input-largo" id="alt-eve-servicios">'+
			'<option value="0">TIPO DE SERVICIO</option>'+
			'<option value="Cambio de SIM">Cambio de SIM</option>'+
			'<option value="Capacitacion">Capacitacion</option>'+
			'<option value="Envio de Insumos">Envio de Insumos</option>'+
			'<option value="Entrega de publicidad">Entrega de publicidad</option>'+
			'<option value="Entrega de placa">Entrega de placa</option>'+
			'<option value="Entrega de placa y transcriptora">Entrega de placa y transcriptora</option>'+
			'<option value="Instalacion de TPV">Instalación de TPV</option>'+
			'<option value="Instalacion de TPV adicional">Instalación de TPV adicional</option>'+
			'<option value="Instalacion SCA">Instalación SCA</option>'+
			'<option value="Mantenimiento Correctivo">Mantenimiento Correctivo</option>'+
			'<option value="Remplazo de TPV">Remplazo de TPV</option>'+
			'<option value="Reprogramacion de TPV">Reprogramación de TPV</option>'+
			'<option value="Retiro de Tpv adicional">Retiro de Tpv adicional</option>'+
			'<option value="Retiro de Tpv con baja de afiliacion">Retiro de Tpv con baja de afiliacion</option>'+
		'</select>'+
	'</div>'+
	'<div>'+
		'<label>Tipo de Falla</label><br>'+
		'<select class="input-largo" id="alt-eve-tipo_falla">'+
			'<option value="0">SELECCIONA FALLA</option>'+
		'</select>'+
	'</div>'+
	'<div>'+
		'<label>Equipo Instalado</label><br>'+
		'<select class="input-largo" style="width:186px;" id="alt-eve-terminal">'+
		'<option value="otra">OTRA</option>'+
		'</select>'+
	'</div>'+
	'<div>'+
		'<label>Municipio</label><br>'+
		'<input class="input-largo" type="text" id="alt-eve-municipio" disabled>'+
	'</div>'+
	'<div>'+
		'<label>Telefono</label><br>'+
		'<input type="number" class="input-largo" style="width:100px;" id="alt-eve-telefono" placeholder="">'+
	'</div>'+
	'<div>'+
		'<label>Email</label><br>'+
		'<input type="text" class="input-largo" style="width:190px;" id="alt-eve-email" placeholder="">'+
	'</div>'+
	'<div>'+
		'<label>Responsable</label><br>'+
		'<input type="text" class="input-largo" style="width:220px;" id="alt-eve-responsable" placeholder="">'+
	'</div>'+
	'<div>'+
		'<label>TICKET</label><br>'+
		'<input type="text" class="input-largo" style="width:180px;" id="alt-eve-ticket" placeholder="">'+
	'</div>'+
	'<div>'+
		'<label>Hora Atencion</label><br>'+
		'<input type="text" class="input-largo" style="width:100px;" id="alt-eve-hora_atencion" placeholder="">'+
	'</div>'+
	'<div>'+
		'<label>Hora Comida</label><br>'+
		'<input type="text" class="input-largo" style="width:100px;" id="alt-eve-hora_comida" placeholder="">'+
	'</div>'+
	'<div style="width:100%">'+
		'<label>Descripcion</label><br>'+
		'<textarea style="heigth:220px;width:100%" type="text" id="alt-eve-descripcion"></textarea>'+
	'</div>'+
	'<div>'+
		'<input type="button" id="alt-eve-enviar" class="boton" onclick="registrar_evento();buscar_comercio_evento();" value="ENVIAR" >'+
	'</div></td></tr></table>';