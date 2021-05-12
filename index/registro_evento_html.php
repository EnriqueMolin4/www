<?php session_start();?>
<div class="apartado" id="registro-evento">
<section class="sub-apartado reg-eve-buscar-evento">
<h1>CONSULTA DE EVENTOS</h1>
<table><tr><td>
	<div>
		<label>ODT:</label><br>
		<input type="text" class="input-largo" onkeyup="find_dato(this.value)" id="reg-eve-odt">
	</div>
	<div>
		<label>Afiliacion:</label><br>
		<input type="text" class="input-largo" onkeyup="find_dato(this.value)" id="reg-eve-afiliacion">
	</div>
	<div>
		<label>Comercio:</label><br>
		<input type="text" class="input-largo" onkeyup="find_dato(this.value)" id="reg-eve-comercio">
	</div>
	<div>
		<label>Vencimineto Desde:</label><br>
		<input type="date" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-vencimiento_desde">
	</div>
	<div>
		<label>Vencimineto Hasta:</label><br>
		<input type="date" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-vencimineto_hasta">
	</div>
	<div>
		<label>Fecha de Alta Desde:</label><br>
		<input type="date" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-fecha_alta_desde">
	</div>
	<div>
		<label>Fecha de Alta Hasta:</label><br>
		<input type="date" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-fecha_alta_hasta">
	</div>
	<div>
		<label>Servicio:</label><br>
		<select type="text" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-servicio">
			<option value="0">SELECCIONA</option>
			<option value="Cambio de SIM">Cambio de SIM</option>
			<option value="Capacitacion">Capacitacion</option>
			<option value="Envio de Insumos">Envio de Insumos</option>
			<option value="Entrega de publicidad">Entrega de publicidad</option>
			<option value="Entrega de placa">Entrega de placa</option>
			<option value="Entrega de placa y transcriptora">Entrega de placa y transcriptora</option>
			<option value="Instalacion de TPV">Instalación de TPV</option>
			<option value="Instalacion de TPV adicional">Instalación de TPV adicional</option>
			<option value="Instalacion SCA">Instalación SCA</option>
			<option value="Mantenimiento Correctivo">Mantenimiento Correctivo</option>
			<option value="Remplazo de TPV">Remplazo de TPV</option>
			<option value="Reprogramacion de TPV">Reprogramación de TPV</option>
			<option value="Retiro de Tpv adicional">Retiro de Tpv adicional</option>
			<option value="Retiro de Tpv con baja de afiliacion">Retiro de Tpv con baja de afiliacion</option>
		</select>
	</div>
	<div>
		<label>Estatus:</label><br>
		<select type="text" class="input-largo" onchange="find_dato(this.value)" id="reg-eve-estatus">
			<option>SELECCIONA</option>
			<option>ABIERTO</option>
			<option>CERRADO</option>
			<option>EN RUTA</option>
		</select>
	</div>
	</td></tr></table>
</section>

<section class="sub-apartado" style="display:none;" id="alt-eve-consulta_evento_abierto">
	<h1>REGISTRO DE EVENTOS</h1>
	<table style="width:100%;"><tr><td>
		<div style="float:left">
			<label>Consultar Afiliacion: </label>
			<input class="input-largo" type="text" id="busqueda-afiliaciones" onkeyup="busqueda_afiliaciones_input(this.value)">
		</div>
		<?php if($_SESSION['tipo_user'] == 'ejecutivo_banco' or $_SESSION['tipo_user'] == 'admin'){ ?>
		<div style="float:left;margin-left:25px">
			<input type="button" onclick="registro_evento_masivo()" style="padding:5px;margin-bottom:2px" id="registro-evento-masivo" value="EVENTO MASIVO" class="boton">
		</div>
		<?php }?>
	<div id="vista-busqueda-afiliaciones" style="margin-top:3px"></div>

	<section style="margin-top:10px;margin-bottom:10px;" id="ajuste-evento">
		<label id="">Eventos del Comercio: </label>
		<input type="text" placeholder="O.D.T." id="registro_evento-buscar_odt_afiliacion" class="input" onkeyup="buscar_odt(this.value)">
		<input class="boton" id="reg-nuevo-evento" type="button" style="margin-left:3%;padding:3px;" onclick="nuevo_evento()" value="Nuevo Evento">
	</section>
	<div id="vista-busqueda-odt_evento"></div>
	</td></tr></table>
</section>

<section class="sub-apartado" style="display:none;" id="muestra-evento">
</section>

<section class="sub-apartado">
	<section id="vista-evento-previa"></section>
	<div id="vista-pag-evento" class="paginacion"></div>
	<?php if($_SESSION['tipo_user'] == 'admin'){ ?>
		<input class="boton" type="button" style="margin:3px;" onclick="si_no(this)" value="ELIMINAR">
		<input type="button" class="boton" style="margin:3px;" onclick="check_todo()" value="CHECK TODO">
	<?php } ?>
</section>

<section style="display:none;" id="peticion-validacion" class="sub-apartado"></section>

</style>
<script type="text/javascript">
paginacion('vista-evento-previa','vista-pag-evento',
	'eventos',
	'modelos/eventos/datos_eventos.php',
	'&key=datos');
function consultar_ubi(data){
	var latitud = parseFloat(data.getAttribute("latitud"));
	var longitud = parseFloat(data.getAttribute("longitud"));

	$("#alerta-todo").css({"display":"block"});
	$("#alerta-todo").animate({opacity:"1"},300);
	$("#alerta-todo").css({"width":"700px","height":"450px"});
	$("#texto").html("");

	var map = new google.maps.Map(document.getElementById('texto'), {
		center: {lat: latitud, lng: longitud},
		zoom: 18
	});

	var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var labelIndex = 0;
	var image = "view/img/atomo.jpg";
	
	var beachMarker = new google.maps.Marker({
		position: {lat: latitud, lng: longitud},
		map: map,
		label: labels[labelIndex++ % labels.length],
	});

}

<?php if($_SESSION['tipo_user'] == 'admin'){ ?>
	function check_todo(){
		var input = document.getElementsByName("eve-del-check");
		for(var i = 0; i <= input.length-1; i++){
			if(input[i].checked == true){
				input[i].checked = false;
			}
			else{
				input[i].checked = true;
			}
		}
	}
<?php } ?>
function si_no(data){
	$("#alerta-todo").css({"display":"block"});
	$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
	$("#alerta-todo").css({"width":"700px","height":"250px"});
	$("#texto").html('<br><label><center>ESTAS SEGURO QUE QUIERES ELIMINAR LOS DATOS MARCADOS</center></label><br><br><input class="boton" type="button" style="margin-left:15.5%;margin-top:15.5%;width:25%;" onclick="borrar_evento(this.value)" value="SI">'+
		'<input class="boton" type="button" style="margin-left:15.5%;margin-top:15.5%;width:25%;" onclick="borrar_evento(this.value)" value="NO">');
}
<?php if($_SESSION['tipo_user'] == 'admin'){ ?>
	function borrar_evento(val){
		if(val == 'SI'){
			var input = document.getElementsByName("eve-del-check");
			var odts = '';
			for(var i = 0; i <= input.length-1; i++){
				if(input[i].checked == true){
					odts += input[i].value+'/';
				}
			}
			if(odts.length > 0){
				$.ajax({
				    url: "modelos/eventos/borrar_eventos.php",
				    type: "post",
					data: "&odts="+odts,
				}).done(function(res){
					$("#alerta-todo").css({"display":"block"});
					$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
					$("#alerta-todo").css({"width":"700px","height":"250px"});
					$("#texto").html(res);
					vista_tabla_evento();
				});
			}
			else{
				$("#alerta-todo").css({"display":"block"});
				$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
				$("#alerta-todo").css({"width":"700px","height":"250px"});
				$("#texto").html("<br><label>ALERTA DE REGISTRO</label>"+
					"<br><label><center>SELECCIONA UNA ALGUN EVENTO PARA ELIMINAR</center></label>");
			}
		}
		if(val == 'NO'){
			$("#texto").html("")
			$("#alerta-todo").css({"display":"none"});
		}
	}
<?php } ?>
function panoramico(res,odt){
	var ancho = screen.width;
	var alto = screen.height;
	var alerta = $("#alerta-todo");

	if(ancho >= "1920"){
		var ancho_tab = ancho * .8;
		var alto_tab = alto * .8;
		var form = '<div id="alerta-tablero"></div><div id="img-tablero_datos_imgs">';
	}
	if(ancho < "1920" && ancho >= "1"){
		var ancho_tab = ancho * .8;
		var alto_tab = alto * .8;
		var form = '<div id="alerta-tablero"></div><div id="img-tablero_datos_imgs">';
	}
	// if(ancho < "1280"){
	// 	var ancho_tab = ancho * .8;
	// 	var alto_tab = alto * .8;
	// 	var form = '<div id="alerta-tablero"></div><div id="img-tablero_datos_imgs" style="width:100%">';
	// }

	alerta.css({"width":""+ancho_tab+"px"});
	alerta.css({"height":""+alto_tab+"px"});
form+='<div id="img-tablero-panoramico">'+
			'<div></div>'+
		'</div>'+
		'<div id="img-tablero-datos">'+
			'<div></div>'+
		'</div>'+
		'<div id="img-tablero-imgs">'+
			'<div></div>'+
		'</div>'+
	'</div>'+
		'<div id="img-tablero-botones">'+
			'<input style="width:20%;margin-left:4%;" data-giro="0" type="button" onclick="girar_derecha();" id="img-tablero-girar" class="boton" value="Girar 90">'+
			// '<input style="width:20%;margin-left:4%;" type="button" data-zoom="menos" onclick="zoom_tablero(this)" id="img-boton_menos" class="boton" value="-">'+
			// '<input style="width:20%;margin-left:4%;" type="button" data-zoom="mas" onclick="zoom_tablero(this)" id="img-boton_mas" class="boton" value="+">'+
			'<input style="width:20%;margin-left:4%;" type="button" value="CERRAR" onclick="aceptar_alerta_cerrar();" id="aceptar-alerta-cerrar" class="boton">'+
		'</div>'+
	'</div>';

	alerta.css({"display":"block","left":""+($(window).width()/2-alerta.width()/2)+"px"});
	alerta.animate({opacity:"1",top:"23px"},300);
	alerta.html(form);
	$("#img-tablero-imgs > div").html(res);

	$.ajax({
	    url: "modelos/imgs_con/datos_generales.php",
	    type: "post",
		data: "&key=key_con_datos_odt&odt="+odt,
	}).done(function(res){
		$("#img-tablero-datos > div").html(res);
	});
}

function consultar_imagenes(val,data){
	var key_no_revisado = 0;
	var odt = data.getAttribute("odt");
	$.ajax({
	    url: "modelos/imgs_con/consultar_imgs_odt.php",
	    type: "post",
		data: "&odt="+odt+"&key_no_revisado="+key_no_revisado,
	}).done(function(res){
		panoramico(res,odt);
	});
}

function aceptar_alerta_cerrar(){
	$("#alerta-todo").html('<section id="texto"></section><input type="button" value="ACEPTAR" id="aceptar-alerta" onclick="aceptar_alerta()" class="boton">');
	$("#alerta-todo").css({"display":"none"});
}

function ver_imagen_supervisor(data){
	var ruta = data.getAttribute("data-imagen");
	var panoramico = '<img style="width:100%;" src="'+ruta+'">';
	$("#img-tablero-panoramico > div").html(panoramico);
	var img = $("#img-tablero-panoramico > div > img");
	img.css({"position":"relative"});
}

function girar_derecha(){
	var img = $("#img-tablero-panoramico > div > img");
	var deg = $("#img-tablero-girar").attr("data-giro");
	deg = parseInt(deg) + 90;
	if(deg > 360){	deg = 0;}
	$("#img-tablero-girar").attr("data-giro",deg);
	$("#img-tablero-girar").attr("data-giro");
	img.css({"transform":"rotate("+deg+"deg)","top":"0px","position":"relative"});
	console.log(deg);
}

function find_dato(val){
	var odt = 				 $("#reg-eve-odt").val();
	var afiliacion =		 $("#reg-eve-afiliacion").val();
	var comercio = 			 $("#reg-eve-comercio").val();
	var estatus = 			 $("#reg-eve-estatus").val();
	var servicio = 			 $("#reg-eve-servicio").val();
	var vencimiento_desde =  $("#reg-eve-vencimiento_desde").val();
	var vencimineto_hasta =  $("#reg-eve-vencimineto_hasta").val();
	var fecha_alta_desde =  $("#reg-eve-fecha_alta_desde").val();
	var fecha_alta_hasta =  $("#reg-eve-fecha_alta_hasta").val();

	var form = "&odt="+odt+"&afiliacion="+afiliacion+"&comercio="+comercio+"&servicio="+servicio+"&estatus="+estatus+"&vencimiento_desde="+vencimiento_desde+"&vencimineto_hasta="+vencimineto_hasta+"&fecha_alta_desde="+fecha_alta_desde+"&fecha_alta_hasta="+fecha_alta_hasta;

	$.ajax({
	    url: "modelos/eventos/datos_eventos.php",
	    type: "post",
		data: "&key=datos"+form,
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		res = JSON.parse(res);
		$("#vista-evento-previa").html(res[2]);
	});
}
function vista_tabla_evento(){
	$.ajax({
	    url: "modelos/eventos/datos_eventos.php",
	    type: "post",
		data: "&key=datos",
		contentType: "application/x-www-form-urlencoded",
	}).done(function(res){
		console.log(res);
		res = JSON.parse(res);
		$("#vista-evento-previa").html(res[2]);
	});
}
$(document).ready(function(){
	vista_tabla_evento();
	initMap();
});

function validar_info(data){

		var odt = "";
		if(!data){
			odt = $("#valid-peticion-odt").val();
		}
		else{
			odt = data.value;			
		}

		$.ajax({
			url: "modelos/validacion.php",
			type: "post",
			data: "&odt="+odt+"&key_con_todo_odt=1",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){

			var arr = JSON.parse(res);
			console.log(res);

			var out = '<h1>INFORMACION DEL EVENTO</h1><table>'+

						'<tr>'+

							'<td><label><div>ODT</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].odt+'" class="input-largo" id="valid-peticion-odt" disabled>'+

							'</td>'+

							'<td><label><div>AFILIACION</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].afiliacion+'" class="input-largo" id="valid-peticion-afiliacion" disabled>'+

							'</td>'+

							'<td><label><div>TIPO DE SERVICIO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].tipo_servicio+'" class="input-largo" id="valid-peticion-tipo_servicio" disabled>'+

							'</td>'+

							'<td><label><div>FECHA ALTA</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].fecha_alta+'" class="input-largo" id="valid-peticion-telefono" disabled>'+

							'</td>'+

						'</tr>'+

						'<tr>'+

							"<td><br></td>"+

						'</tr>'+

						'<tr>'+

							'<td><label><div>FECHA VENCIMIENTO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].fecha_cierre+'" class="input-largo" id="valid-peticion-fecha_vencimeinto" disabled>'+

							'</td>'+

							'<td><label><div>COMERCIO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].comercio+'" class="input-largo" id="valid-peticion-comercio" disabled>'+

							

							'<td><label><div>COLONIA</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].colonia+'" class="input-largo" id="valid-peticion-colonia" disabled>'+

							'<td><label><div>CIUDAD</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].ciudad+'" class="input-largo" id="valid-peticion-ciudad" disabled>'+

							'</td>'+

						'</tr><tr>'+

							"<td><br></td>"+

						'</tr><tr>'+

							'</td>'+

							'<td><label><div>ESTADO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].estado+'" class="input-largo" id="valid-peticion-estado" disabled>'+

							'</td>'+

							'</td>'+

							'<td colspan="2"><label><div>DIRECCION</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].direccion+'" class="input-largo" id="valid-peticion-direccion" disabled>'+

							'</td>'+

							'<td><label><div>TELEFONO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].telefono+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

						'</tr><tr>'+

							'<td colspan="1">'+

								'<input type="button" onclick="consultar_imagenes(this.value,this)" style="width:80%;height:100%;padding:7px;margin-left:6.5%;" value="IMAGENES" odt="'+arr[0].odt+'" class="boton">'+

								'<input type="button" onclick="consultar_ubi(this)" style="width:80%;height:100%;padding:7px;margin-left:6.5%;margin-top:4px;" value="UBICACION" odt="'+arr[0].odt+'" longitud="'+arr[0].longitud+'" latitud="'+arr[0].latitud+'" class="boton">'+

							'</td>'+

							'<td colspan="3"><br><div>DESCRIPCION</div>'+

								'<textarea class="areas" type="text" class="input-largo" id="valid-peticion-descripcion" disabled>'+arr[0].descripcion+'</textarea><br><br>'+

							'</td>'+

						'</tr>'+
						'<tr>'+
							'<td><label><div>HORARIO DE ATENCION</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].hora_atencion+'" class="input-largo" id="valid-peticion-hora_atencion" disabled>'+

							'</td>'+

							'<td><label><div>HORARIO DE COMIDA</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].hora_comida+'" class="input-largo" id="valid-peticion-hora_comida" disabled>'+

							'</td>'+

							'<td><label><div>FECHA DE ASIGNACION</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].fecha_asignacion+'" class="input-largo" id="valid-peticion-hora_comida" disabled>'+

							'</td>'+
						'</tr>'+

						'<tr><td colspan="4"><br><h1>INFORMACION DEL CIERRE</h1></td></tr>'+
						'<tr>'+

							'</td>'+

							'<td><label><div>QUIEN NOS ATENDIO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].receptor_servicio+'" class="input-largo" id="valid-peticion-estado" disabled>'+

							'</td>'+

							'</td>'+

							'<td><label><div>FECHA DE ATENCION</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].fecha_atencion+'" class="input-largo" id="valid-peticion-direccion" disabled>'+

							'</td>'+

							'<td><label><div>HORA DE LLEGADA</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].hora_llegada+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

							'<td><label><div>HORA DE SALIDA</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].hora_salida+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+
							'</tr><tr><td><br></td></tr>'+

						'<tr>'+

							'<td><label><div>TECNICO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].tecnico+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

							'<td><label><div>ESTATUS</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].estatus+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

							'<td><label><div>SERVICIO SOLICITADO</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].servicio+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

							'<td><label><div>SERVICIO FINAL</div></label>'+

								'<input class="validacion-input-mostrar-datos" type="text" value="'+arr[0].servicio_final+'" class="input-largo" id="valid-peticion-fecha_cierre" disabled>'+

							'</td>'+

						'</tr><tr><td><br></td></tr>'+

						'<tr>'+
							'<td colspan="4"><label><div>COMENTARIOS DEL CIERRE</div></label>'+

								'<textarea class="areas" type="text" class="input-largo" id="valid-peticion-descripcion" disabled>'+arr[0].comentarios_cierre+'</textarea>'+

							'</td>'+
						'</tr>'+

					'</table>';



			$("#peticion-validacion").css({"display":"block"});

			$("#peticion-validacion").html(out);

		});

	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALEf-LnTMDGDQFmCwOt7DDLrwzrmwikK0&callback=initMap"></script>
<style type="text/css">
	.reg-eve-buscar-evento table tbody tr td > div{
		float:left;
		display:inline-block;
		margin-left:2px;
	}
	#reg-nuevo-evento{
		display:none;
	}
	#ajuste-evento{
		display: none;
	}
	#registrar-evento-afiliaciones{
		position:relative;
		margin-left: 80%;
		top:0px;
	}
	#registro-evento table tr td textarea{
		width: 98%;
	}
	#registro-evento > section label{
		font-size:13px;
		font-weight:600;
	}
	#reg-eve-table-datos{
		width: 100%;
		border-collapse:collapse;
	}
	#reg-eve-table-datos tr td{
		border-collapse:collapse;
		padding:3px;
	}
	#reg-eve-table-datos tr td div:nth-child(1){
		width: 100%;
	    background: #0061a7;
	    font-weight: 500;
	    font-size: 15px;
	    text-align: center;
	    color: #fff;
    }
    #reg-eve-table-datos tr td div:nth-child(2){
		width: 100%;
	    background: #f1f1f1;
	    font-size: 15px;
    }
	#registro-evento table label{
		font-size:14px;
		font-weight:bold;
	}
	#alt-eve-servicios{
		width:180px;
	}
	#vista-busqueda-odt_evento label{
		font-size:13px;
		font-weight:600;
	}
	#vista-busqueda-odt_evento input{
		width:12%;
		margin:.25%;
	}
	#vista-busqueda-odt_evento{
		padding:2px;
	}
	#reg-eve-tabla-evento tr td div{
		float:left;
		margin-left:2px;
	}
	#peticion-validacion table{

		width:100%;

	}
	#img-tablero-botones{
	margin-top:1.7%;
	margin-bottom:.2%;
}

#img-tablero_datos_imgs{
	width:96%;

	position:relative;
	left:2.5%;

	height: 92%;
	top:2%;

	/*background:#fff;*/
}

#img-tablero_datos_imgs > div{
	display:block;
	float:left;
	position:relative;
	overflow-y: scroll;
}

#img-tablero-panoramico{
	width:80%;

	position:relative;
	height: 100%;
}

#img-tablero-datos{
	height:30%;
	width:20%;

	position:relative;
	color:#006799;
	font-size:12px;
	/*font-weight: bold;*/
}

#img-tablero-imgs{
	width:20%;

	position:relative;
	height:70%;
}
	#img-tablero-panoramico{
		width:80%;
		position:relative;
		height: 100%;
	}
	#peticion-validacion label{

		font-size:13px;

		font-weight: 600;

	}

	#peticion-validacion table tr td{

		/*border-left:4px solid #fff;*/

	}

	.validacion-input-mostrar-datos{

		width:100%;

		border:none;

		font-size: 12px;

	}

	#peticion-validacion > table tr td div{

		width:100%;

		background: #0061a7;

		font-weight:500;

		font-size:13px;

		color:#fff;

		text-align:center;

	}



	#peticion-validacion > table tr td label{

		background: #0061a7;

		font-weight:500;

		font-size:13px;

		color:#fff;

	}
</div>