//FUNCIONES CON RESPUESTA AL CARGAR PAGINA 
$(document).ready(function(){
// BUSQUEDA DE EVENTOS PARA LA SECCION --"CONSULTA DE EVENTOS"
$("#con-eve-odt").keyup(function(){
	var odtCon = $(this).val();
	var select = $("#select-consulta-evento").val();
	form = "&odt="+odtCon+"&select="+select;
	$.ajax({
	    url: "modelos/consulta_buscar_eventos.php",
	    type: "post",
		data: form,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		$("#vista-evento").html(res);
	});
});

// // BUSQUEDA DE EVENTOS PARA LA SECCION --"EVENTOS"
$("#alt-eve-odt").keyup(function(){
	var odtAlt = $(this).val();
	var select = $("#select-alta-evento").val();
	var form = "&odt="+odtAlt+"&select="+select;
	$.ajax({
	    url: "modelos/alta_buscar_evento.php",
	    type: "post",
		data: form,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		$("#vista-evento-previa").html(res);
	});
});

// BUSQUEDA DE EVENTOS PARA LA SECCION --"CIERRE EVENTOS"
$("#submit-cierre-evento").click(function(){
	var afiliacion = $("#afiliacion-con-cierre").val();
	var odtCierre = $("#odt-con-cierre").val();
	var tipoServicio = $("#tipo_servicio").val();
	var territorios = $("#selectTerritorios").val();
	var estados = $("#selectEstados").val();
	var municipios = $("#selectMunicipios").val();
	var terminal = $("#select-modelo-terminal").val();
	var form = "&afiliacion="+afiliacion+"&odtCierre="+odtCierre+"&tipoServicio="+
	tipoServicio+"&territorios="+territorios+"&estados="+estados+"&municipios="+municipios+
	"&terminal="+terminal;
	$.ajax({
	    url: "modelos/buscar_evento.php",
	    type: "post",
		data: form,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		$("#vista-consulta-cierre-eventos").html(res);
	});
function no_serie_confirmar(){
	$.ajax({
	    url: "modelos/almacen/datos_almacen.php",
	    type: "post",
		data: "&key=key_con_series_confirmar",
	}).done(function(res){
		$("#tabla-vista-series_confirmar").html(res);
	});
}
});

$.ajax({
    url: "modelos/consulta_almacen.php",
    type: "post",
    data: '&key_almacen_vista_ready=1',
	contentType: "application/x-www-form-urlencoded",
}).done(function(res){
	$("#vista-almacen").html(res);
});

});



//FUNCIONES QUE NO SE ACTIVAN AL CARGAR LA PAGINA
function consulta_almacen(){
	var select = $("#almacen-select-buscar").val();
	var input = $("#almacen-con-dato").val();
	var key = "si";
	console.log(input+"::"+select);
	$.ajax({
		url: "modelos/consulta_almacen.php",
		type: "post",
		data: "&input="+input+"&select="+select+"&key_almacen_vista_buscar="+key,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		if(res.length != 0){
			arr = JSON.parse(res);
			var out = "<table class='table-view'>";
			if(select == "TPV"){
				out += "<tr><td>USUARIO</td>"+
				"<td>FECHA ALTA</td>"+
				"<td>CVE BANCO</td>"+
				"<td>PRODUCTO</td>"+
				"<td>MODELO TPV</td>"+
				"<td>NO SERIE</td>"+
				"<td>CONECTIVIDAD</td>"+
				"<td>FABRICANTE</td>"+
				"<td>PTID</td>"+
				"<td>ESTATUS</td></tr>";
				for(var i = 0; i <= arr.length-1; i++){
					out += "<tr><td>"+arr[i].usuario+"</td>";
					out += "<td>"+arr[i].fecha_alta+"</td>";
					out += "<td>"+arr[i].cve_banco+"</td>";
					out += "<td>"+arr[i].producto+"</td>";
					out += "<td>"+arr[i].modelo_tpv+"</td>";
					out += "<td>"+arr[i].no_serie+"</td>";
					out += "<td>"+arr[i].conect+"</td>";
					out += "<td>"+arr[i].fabricante+"</td>";
					out += "<td>"+arr[i].ptid+"</td>";
					out += "<td>"+arr[i].estatus+"</td></tr>";
				}
			}
			if(select == "SIM"){
				out += "<tr><td>USUARIO</td>"+
				"<td>FECHA ALTA</td>"+
				"<td>CVE BANCO</td>"+
				"<td>PRODUCTO</td>"+
				"<td>CARRIER</td>"+
				"<td>NO DE SERIE</td>"+
				"<td>ESTATUS</td></tr>";
				for(var i = 0; i <= arr.length-1; i++){
					out += "<tr><td>"+arr[i].usuario+"</td>";
					out += "<td>"+arr[i].fecha_alta+"</td>";
					out += "<td>"+arr[i].cve_banco+"</td>";
					out += "<td>"+arr[i].producto+"</td>";
					out += "<td>"+arr[i].carrier+"</td>";
					out += "<td>"+arr[i].no_serie+"</td>";
					out += "<td>"+arr[i].estatus+"</td></tr>";
				}
			}
			if(select == "INSUMO"){
				out += "<tr><td>USUARIO</td>"+
				"<td>FECHA ALTA</td>"+
				"<td>CVE BANCO</td>"+
				"<td>PRODUCTO</td>"+
				"<td>INSUMO</td>"+
				"<td>CANTIDAD</td></tr>";
				for(var i = 0; i <= arr.length-1; i++){
					out += "<tr><td>"+arr[i].usuario+"</td>";
					out += "<td>"+arr[i].fecha_alta+"</td>";
					out += "<td>"+arr[i].cve_banco+"</td>";
					out += "<td>"+arr[i].producto+"</td>";
					out += "<td>"+arr[i].insumo+"</td>";
					out += "<td>"+arr[i].cantidad+"</td></tr>";
				}
			}
			out += "</table>";
			$("#vista-almacen").html(out);
		}
	});
}
function registro_evento_masivo(){
	 var form = "<form action='javascript: ajax_registro_masivo_eventos()' id='form-registro-evento-masivo'>"+
	 	"<center><input type='file' id='excel-evento-archivo' placeholder='REGISTRAR'></center>"+
	 	"<center><input type='text' id='excel-evento-desde' class='input' placeholder='DESDE QUE FILA'></center>"+
	 	"<center><input type='submit' class='boton' value='REGISTRAR'></center>"+
	 "</form>";
	$("#alerta-todo").css({"display":"block"});
	$("#alerta-todo").animate({opacity:"1",top:"23px"},100);
	$("#alerta-todo").css({"width":"500px","height":"220px"});
	$("#texto").html(form);

}
function ajax_registro_masivo_eventos(){
	$(".cargando-gif").css({"display":"block"});
 	var form = new FormData();
 	var file = document.getElementById("excel-evento-archivo");
 	var dato = document.getElementById("excel-evento-desde").value;
 	form.append('archvio',file.files[0]);
 	form.append('desde',dato);

	$.ajax({
	    url: "modelos/eventos/reg_masivo_eventos.php",
	    type: "post",
		data: form,
		contentType:false,
		processData:false,
		cache:false
	}).done(function(res){
		$(".cargando-gif").css({"display":"none"});
		$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
		$("#alerta-todo").css({"width":"600px","height":"250px"});
		$("#texto").html(res);
	});
}
function select_producto_cambiante(val){
	if(val == "0"){
		$("#almacen-producto-cambiante").
		$("#almacen-producto-cambiante").css({"display":"none"});
	}
	if(val == "tpv"){
		$.ajax({
		    url: "modelos/consulta_almacen.php",
		    type: "post",
			data: "&key_select_producto=1",
		}).done(function(res){
			var arr = JSON.parse(res);
			$("#almacen-producto-cambiante").css({"display":"block"});
			var out = "<table><tr><td><div><label>Modelos TPV: </label><br><select onchange='valores_inputs(this.value,this.options[this.selectedIndex])' id='select-modelo_tpv' class='input'>";
			out += "<option value='0'>SELECCIONA</option>";
			for(var i = 0; i <= arr.length-1;i++){
				out += "<option value='"+arr[i].modelo+"' largo='"+arr[i].no_largo+"' proveedor='"+arr[i].proveedor+"' conect='"+arr[i].conect+"'>"+arr[i].modelo+"</option>";
			}
				out += "</select></div>";
				out += "<div><label>No. de Serie: </label><br><input id='almacen-no_serie' type='text' class='input-largo'></div>";
				out += "<div><label>Fabricante: </label><br> <input type='text' class='input-largo' id='almacen-fabricante' disabled></div>";
				out += "<div><label>Conectividad: </label><br> <input type='text' class='input-largo' id='almacen-conect' disabled></div>";
				out += "<div><label>PTID: </label><br> <input id='almacen-ptid' type='text' class='input-largo'></div>";
				out += "<div><label>Estatus: </label><br> <select id='almacen-estatus' class='input-largo'>"+
				"<option value='0'>SELECCIONA</option>"+
				"<option value='DAÑADO'>DAÑADO</option>"+
				"<option value='ACTIVO'>ACTIVO</option>"+
				"<option value='NUEVO'>NUEVO</option>"+
				"</select></div>";
				out += "<div><label>Tarima: </label><br> <input type='text' class='input-largo' id='almacen-tarima-tpv'></div>";
				out += "<div><label>Anaquel: </label><br> <input type='number' class='input-largo' id='almacen-anaquel-tpv'></div>";
				out += "<div><label>Cajon: </label><br> <input type='number' class='input-largo' id='almacen-cajon-tpv'></div></td></tr></table>";
			$("#almacen-producto-cambiante").html(out);
		});
	}
	if(val == "sim"){
		$("#almacen-producto-cambiante").css({"display":"block"});
		$("#almacen-producto-cambiante").html("<table><tr><td><div><label>Carrier: </label><br>"+
			"<select class='input-largo' id='almacen-select-carrier'>"+
			"<option value='0'>SELECCIONA</option>"+
			"<option value='telcel'>Telcel</option>"+
			"<option value='movistar'>Movistar</option>"+
			"<option value='movistar'>DUAL SIM</option>"+
			"</select></div>"+
			"<div><label>No. de Serie: </label><br><input id='almacen-no_serie' type='text' class='input'></div>"+
			"<div><label>Estatus: </label><br><select id='almacen-estatus' class='input-largo'>"+
				"<option value='0'>SELECCIONA</option>"+
				"<option value='DAÑADO'>DAÑADO</option>"+
				"<option value='ACTIVO'>ACTIVO</option>"+
				"<option value='NUEVO'>NUEVO</option>"+
				"</select></div>"+
				"<div><label>Tarima: </label><br> <input type='text' class='input-largo' id='almacen-tarima-sim'></div>"+
				"<div><label>Anaquel: </label><br> <input type='number' class='input-largo' id='almacen-anaquel-sim'></div>"+
				"<div><label>Cajon: </label><br> <input type='number' class='input-largo' id='almacen-cajon-sim'></div></td></tr></table>");
	}
	if(val == "insumo"){
		$("#almacen-producto-cambiante").css({"display":"block"});
		$("#almacen-producto-cambiante").html("<table><tr><td><div><label>Insumo: </label><br>"+
			"<select class='input-largo' id='almacen-select-insumo'>"+
			"<option value='0'>SELECCIONA</option>"+
			"<option value='ROLLO TERMICO'>ROLLO TERMICO</option>"+
			"<option value='CALCOMANIA DE BIENVENIDA'>CALCOMANIA DE BIENVENIDA</option>"+
			"<option value='KIT DE BIENVENIDA'>KIT DE BIENVENIDA</option>"+
			"<option value='PORTACUENTA'>PORTACUENTA</option>"+
			"<option value='BOLSA'>BOLSA</option>"+
			"<option value='FOLDER'>FOLDER</option>"+
			"<option value='PORTA CUENTAS'>PORTA CUENTAS</option>"+
			"<option value='PORTANOTAS'>PORTANOTAS</option>"+
			"<option value='CARTA BIENVENIDA'>CARTA BIENVENIDA</option>"+
			"<option value='FOLLETO VTS SEG'>FOLLETO VTS SEG</option>"+
			"<option value='RELOJ'>RELOJ</option>"+
			"<option value='STICKER'>STICKER</option>"+
			"<option value='MINI G VERFIFONE'>MINI G VERFIFONE</option>"+
			"<option value='MINI G INGENICO'>MINI G INGENICO</option>"+
			"<option value='PAGARE MANUAL'>PAGARE MANUAL</option>"+
			"<option value='NOTAS DE DEVOLUCION'>NOTAS DE DEVOLUCION</option>"+
			"<option value='FICHAS DE DEPOSITO'>FICHAS DE DEPOSITO</option>"+
			"</select></div>"+
			"<div><label>Cantidad: </label><br><input id='almacen-cantidad-insumo' class='input' type='number'></div>"+
			"<div><label>Tarima: </label><br> <input type='text' class='input-largo' id='almacen-tarima-insumo'></div>"+
			"<div><label>Anaquel: </label><br> <input type='number' class='input-largo' id='almacen-anaquel-insumo'></div>"+
			"<div><label>Cajon: </label><br> <input type='number' class='input-largo' id='almacen-cajon-insumo'></div></td></tr></table>");
	}
}
function valores_inputs(val,data){
	conect = data.getAttribute("conect");
	proveedor = data.getAttribute("proveedor");
	$("#almacen-fabricante").val(proveedor);
	$("#almacen-conect").val(conect);
}

function registro_almacen(){
	if($("#almacen-producto").val() != "insumo" && $("#almacen-producto").val() != "0" && $("#almacen-producto").val() != "sim"){
		var select_modelo_tpv = document.getElementById("select-modelo_tpv");
		var opcion = select_modelo_tpv.options[select_modelo_tpv.selectedIndex];
		var largo = opcion.getAttribute("largo");
	}
	var usuario = $("#usuario-almacen").val();
	var fecha_alta = $("#almacen-fecha_alta").val();
	var select_cve = $("#almacen-select-cve").val();
	var producto = $("#almacen-producto").val();
	var modelo_tpv = $("#select-modelo_tpv").val();
	var no_serie = $("#almacen-no_serie").val();
	var fabricante = $("#almacen-fabricante").val();
	var conect = $("#almacen-conect").val();
	var ptid = $("#almacen-ptid").val();
	var estatus = $("#almacen-estatus").val();
	var carrier = $("#almacen-select-carrier").val();
	var insumo = $("#almacen-select-insumo").val();
	var cantidad = $("#almacen-cantidad-insumo").val();

	if(producto == 'tpv'){
		var tarima  = $("#almacen-tarima-tpv").val();
		var anaquel = $("#almacen-anaquel-tpv").val();
		var cajon   = $("#almacen-cajon-tpv").val();

		var form = "&usuario="+usuario+"&fecha_alta="+fecha_alta+"&select_cve="+select_cve;
		form += "&producto="+producto+"&modelo_tpv="+modelo_tpv+"&no_serie="+no_serie+"&fabricante="+fabricante;
		form += "&conect="+conect+"&ptid="+ptid+"&estatus="+estatus+"&largo="+largo;
		form += "&tarima="+tarima+"&anaquel="+anaquel+"&cajon="+cajon;
	}
	if(producto == 'sim'){
		var tarima  = $("#almacen-tarima-sim").val();
		var anaquel = $("#almacen-anaquel-sim").val();
		var cajon   = $("#almacen-cajon-sim").val();

		var form = "&usuario="+usuario+"&fecha_alta="+fecha_alta+"&select_cve="+select_cve;
		form += "&producto="+producto+"&carrier="+carrier+"&no_serie="+no_serie+"&estatus="+estatus+"&largo="+largo;
		form += "&tarima="+tarima+"&anaquel="+anaquel+"&cajon="+cajon;
	}
	if(producto == 'insumo'){
		var tarima  = $("#almacen-tarima-insumo").val();
		var anaquel = $("#almacen-anaquel-insumo").val();
		var cajon   = $("#almacen-cajon-insumo").val();

		var form = "&usuario="+usuario+"&fecha_alta="+fecha_alta+"&select_cve="+select_cve;
		form += "&producto="+producto+"&insumo="+insumo+"&cantidad="+cantidad;
		form += "&tarima="+tarima+"&anaquel="+anaquel+"&cajon="+cajon;
	}

	$.ajax({
		url: "modelos/registro_almacen.php",
	    type: "post",
		data: form,
	}).done(function(res){
		if(res == '<br><label><center>SE REALIZO EL REGISTRO CON EXITO.</center></label>'){
			$("#almacen-producto-cambiante").html('');
			$("#almacen-producto-cambiante").css({"display":"none"});
			$("#almacen-producto option:contains('SELECCIONA')").attr("selected",true);
		}
		$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
		$("#texto").html(res);
	});
}