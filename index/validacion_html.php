<?php session_start();?>
<div class="apartado" id="validacion">

	 <?php if($_SESSION['user'] == 'marcela' or $_SESSION['tipo_user'] == 'supervisor' or $_SESSION['tipo_user'] == 'admin') {?> 

	<div style="display:none;" id="validacion-opcion_excel" class="sub-apartado">

		<h1>REGISTRO DE USUARIOS</h1>
		<section>
			<table>
				<tr>
					<td>
						<label>Nombre</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-nombre">
					</td>
					<td>
						<label>Telefono</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-telefono">
					</td>
					<td>
						<label>Correo</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-correo">
					</td>
					<td>
						<label>Usuario</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-user">
					</td>
					<td>
						<label>Contraseña</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-pass">
					</td>
				</tr>
				<tr>
					<td>
						<label>Direccion</label><br>
						<input type="text" class="input-largo" id="validacion-reg_eject-direccion">
					</td>
					<td>
						<label>Tipo de Usuario</label><br>
						<select type="text" class="input-largo" id="validacion-reg_eject-tipo_user">
							<option>SELECCIONA</option>
							<option value="callcenter">VALIDACION</option>
							<option value="cierres">CIERRES</option>
						</select>
					</td>
					<td>
						<input style="margin-top:6px;margin-left:5px;" type="button" class="boton" id="validacion-registrar_ejecutivo" onclick="registrar_ejecutivo();setTimeout(function(){consultar_ejecutivo();},500);"value="REGISTRAR">
					</td>
				</tr>
			</table>
		</section>
		<br>
		<section id="validacion-vista-ejecutivos"></section>
	</div>
	<div style="display:none;"  id="validacion-elegir_odt" class="sub-apartado">
	<h1>ASIGNAR ODT A EJECUTIVO</h1>
		<table>
		<tr>
		<td>
			<label>Eejecutivo: </label>
			<input class="input-largo" type="text" id="validacion-elegir_odt-ejecutivo" disabled>
		</td>
		<td>
			<label>ODT: </label>
			<input class="input-largo" type="text" id="validacion-elegir_odt-odt">
		</td>
		<td>
			<input class="boton" onclick="validacion_asignar_evento()" value="ASIGNAR" type="button">
		</td>
		</tr>
		</table>
	</div>
	 <?php } ?> 
	<div class="sub-apartado">
	<h1>CONSULTA DE ODT's</h1>
		<table>
			<tr>
				<td>
					<label>ODT</label><br>
					<input type="text" id="con-valid-odt" onkeyup="buscar_odt_eve()" class="input-largo">
				</td>
				<td>
					<label>Afiliacion</label><br>
					<input type="text" id="con-valid-afiliacion" onkeyup="buscar_odt_eve()" class="input-largo">
				</td>
				<td>
					<label>Tipo de Servicio</label><br>
					<select onchange="buscar_odt_eve()" class="input-largo" style="width:180px" id="con-valid-servicios">
						<option value="0">TIPO DE SERVICIO</option>
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
				</td>
				<td>
					<label>Ejecutivo</label><br>
					<input type="text" id="con-valid-ejecutivo" onkeyup="buscar_odt_eve()" class="input-largo">
				</td>
				<td>
					<label>Telefono</label><br>
					<input type="text" id="con-valid-telefono" onkeyup="buscar_odt_eve()" class="input-largo">
				</td>
			</tr>
			<tr>
				<td>
					<label>Vencimineto Desde</label><br>
					<input type="date" id="con-valid-vencimiento_desde" onchange="buscar_odt_eve()" class="input-largo">
				</td>
				<td>
					<label>Vencimiento Hasta</label><br>
					<input type="date" id="con-valid-vencimiento_hasta" onchange="buscar_odt_eve()" class="input-largo">
				</td>
			</tr>
		</table>
		<br>
		<div id="vista-evento-validacion">
			<div class="table-view"></div>
			<?php if($_SESSION['user'] == 'marcela' or $_SESSION['tipo_user'] == 'supervisor' or $_SESSION['tipo_user'] == 'admin') {?>
			<br>
			<input type="button" onclick="validacion_excel_odt(this.value)" class="validacion-opcion_excel boton" name="" value="Cargar Excel">
			<input type="button" onclick="validacion_excel_odt(this.value)" class="validacion-opcion_excel boton" name="" value="Descargar Excel">
			<?php } ?>
		</div>
	</div>

	<div style="display:none;" id="validacion-excel-eventos" class="sub-apartado">
	<div id="validacion-cargar_excel">
		<table>
		<tr>
			<td style="width:330px;">
			<input class="input-largo" style="width:95%;" type="file" id="validacion-cargar_excel-file">
			</td>
			<td>
			<label>Desde: </label>
			<input class="input-largo" type="text" id="validacion-cargar_excel-desde">
			</td>
			<td>
			<input class="boton" value="CARGAR" onclick="validacion_cargar_excel();" type="button" id="validacion-cargar_excel-cargar">
			</td>
		</tr>
		</table>
	</div>

	<div id="validacion-descargar_excel">
		<table>
		<tr>
			<td>
			<label>Desde: </label>
			<input class="input-largo" type="date" id="validacion-descargar_excel-desde">
			</td>
			<td>
			<label>Hasta: </label>
			<input class="input-largo" type="date" id="validacion-descargar_excel-hasta">
			</td>
			<td>
			<input class="boton" value="DESCARGAR" onclick="validacion_descargar_excel();" type="button" id="validacion-descargar_excel-cargar">
			</td>
		</tr>
		</table>
		</div>
	</div>

	<div style="display:none" id="peticion-validacion" class="sub-apartado"></div>

	<script type="text/javascript">

	function validacion_cargar_excel(){
		var form = new FormData();

		var desde = document.getElementById("validacion-cargar_excel-desde").value;
 		var file = document.getElementById("validacion-cargar_excel-file");
 		form.append('archvio',file.files[0]);
 		form.append('desde',desde);

 		$.ajax({
		    url: "modelos/plugins/cargar_eventos.php",
		    type: "post",
			data: form,
			contentType:false,
			processData:false,
			cache:false,
		}).done(function(res){
			var alerta = "";

			if(res.length > 10){
				$("#validacion-elegir_odt").css({"display":"none"});
				$("#validacion-elegir_odt-odt").val("");
				alerta = res;
			}

			if(res == "0"){
				$("#validacion-elegir_odt").css({"display":"none"});
				$("#validacion-elegir_odt-odt").val("");
				alerta = "<br><br><label><center>EL ARCHIVO NO SE PUDO CARGAR</center></label>";
			}

			if(res == "1"){
				$("#validacion-elegir_odt").css({"display":"none"});
				$("#validacion-elegir_odt-odt").val("");
				alerta = "<br><br><label><center>SE REALIZO EL PROCESO CORRECTAMENTE</center></label>";
			}

			if(res == "2"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>ERROR EN EL PROCESO DE REGISTRO, CONSULTA AL ADMINISTRADOR</center></label>";
			}

			if(res == "3"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>HACE FALTA LA ODT PARA LA ASIGNACION</center></label>";
			}

			if(res == "3"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>NO HAY ARCHIVOS SELECCIONADOS, ELIGE UN FICHERO</center></label>";
			}

			if(res == "42"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>EL ARCHIVO NO CONTIENE FILAS VALIDAS PARA REGISTRAR</center></label>";
			}

			$("#alerta-todo").css({"display":"block"});
			$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
			$("#alerta-todo").css({"width":"700px","height":"250px"});
			$("#texto").html(alerta);
			console.log(res);
		});
	}

	function validacion_descargar_excel(){

	}



	function validacion_excel_odt(val){
		$("#validacion-excel-eventos").css({"display":"block"});
		if(val == 'Cargar Excel'){
			$("#validacion-cargar_excel").css({"display":"block"});
			$("#validacion-descargar_excel").css({"display":"none"});
		}
		else{
			$("#validacion-cargar_excel").css({"display":"none"});
			$("#validacion-descargar_excel").css({"display":"block"});
		}
	}

	function buscar_odt_eve(val){
		var odt =  $("#con-valid-odt").val();
		var afiliacion =  $("#con-valid-afiliacion").val();
		var servicios =  $("#con-valid-servicios").val();
		var ejecutivo =  $("#con-valid-ejecutivo").val();
		var telefono =  $("#con-valid-telefono").val();
		var vencimiento_desde =  $("#con-valid-vencimiento_desde").val();
		var vencimiento_hasta =  $("#con-valid-vencimiento_hasta").val();

		var form = "&odt="+odt+"&afiliacion="+afiliacion+"&servicios="+servicios+"&ejecutivo="+ejecutivo+"&telefono="+telefono+"&vencimiento_desde="+vencimiento_desde+"&vencimiento_hasta="+vencimiento_hasta;

		$.ajax({
		    url: "modelos/validacion.php",
		    type: "post",
			data: form+"&key_con_odt=1",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			console.log(res);
			$("#vista-evento-validacion > div").html(res);
		});
	}



	function registrar_ejecutivo(){
		var nombre  = $("#validacion-reg_eject-nombre").val();
		var telefono  = $("#validacion-reg_eject-telefono").val();
		var correo  = $("#validacion-reg_eject-correo").val();
		var user  = $("#validacion-reg_eject-user").val();
		var pass  = $("#validacion-reg_eject-pass").val();
		var direccion  = $("#validacion-reg_eject-direccion").val();
		var tipo_user = $("#validacion-reg_eject-tipo_user").val();

		var form = "&nombre="+nombre+"&telefono="+telefono+"&correo="+correo+"&user="+user+"&pass="+pass+"&direccion="+direccion+"&tipo_user="+tipo_user;

		$.ajax({
			url: "modelos/validacion/ejecutivos.php",
		    type: "post",
			data: form+"&key=registrar_ejecutivo",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			var alerta = "";
			if(res == "1"){
				alerta = "<br><br><label><center>SE REGISTRO EL EJECUTIVO CON EXITO</center></label>";
			}
			if(res == "2"){
				alerta = "<br><br><label><center>ERROR EN EL PROCESO DE REGISTRO, CONSULTA AL ADMINISTRADOR</center></label>";
			}
			if(res == "0"){
				alerta = "<br><br><label><center>HACEN FALTA DATOS ESENCIALES PARA EL REGISTRO</center></label>";
			}
			if(res == "3"){
				alerta = "<br><br><label><center>EL NOMBRE O EL USUARIO DEL EJECUTIVO YA FUE REGISTRADO, AGREGA UN NOMBRE DIFERNETE</center></label>";
			}
			if(res == "4"){
				alerta = "<br><br><label><center>DEBES SELECCIONAR UN TIPO DE USUARIO PARA EL EJECUTIVO.</center></label>";
			}
			$("#alerta-todo").css({"display":"block"});
			$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
			$("#alerta-todo").css({"width":"700px","height":"250px"});
			$("#texto").html(alerta);
			console.log(res);
		});
	}



	function validar_llamada(){
		var odt = $("#valid-peticion-odt").val();
		var afiliacion = $("#valid-peticion-afiliacion").val();
		var estatus =  $("#validacion-validar-estatus").val();
		var fecha_llamada =  $("#validacion-validar-fecha_llamada").val();
		var hora_llamada =  $("#validacion-validar-hora_llamada").val();
		var comentarios =  $("#validacion-validar-comentarios").val();
		var toque = $("#validacion-validar-toque").val();

		var form = "&toque="+toque+"&odt="+odt+"&afiliacion="+afiliacion+"&estatus="+estatus+"&fecha_llamada="+fecha_llamada+"&hora_llamada="+hora_llamada+"&comentarios="+comentarios;

		$.ajax({
		    url: "modelos/validacion/ejecutivos.php",
		    type: "post",
			data: form+"&key=validar",
		}).done(function(res){
			if(res == "1"){
				$("#validacion-elegir_odt").css({"display":"none"});
				$("#validacion-elegir_odt-odt").val("");
				alerta = "<br><br><label><center>SE REALIZO LA VALIDACION CON EXITO</center></label>";
			}
			if(res == "2"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>ERROR EN EL PROCESO DE REGISTRO, CONSULTA AL ADMINISTRADOR</center></label>";
			}
			if(res == "3"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>SELECCIONA LOS DATOS ESENCIALES PARA LA VALIDACION</center></label>";
			}

			$("#alerta-todo").css({"display":"block"});
			$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
			$("#alerta-todo").css({"width":"700px","height":"250px"});
			$("#texto").html(alerta);
			console.log(res);
		});
	}



	function consulta_img_valid(data){
		if(data.hasAttribute("caja-on")){
		var key_no_revisado = 1;
		<?php if($_SESSION['tipo_user'] == 'supervisor' or $_SESSION['tipo_user'] == 'callcenter'){ ?>
			data.className = 'odt-vista';
			var input = document.querySelector("#correo input");
			for(var i = 0; i <= input.length-1;i++){
				console.log(input[i]);
				if(input[i].value == val){
					input[i].className = 'odt-vista';
				}
			}
		<?php } ?>
		}
		else{
			var key_no_revisado = 0;
		}
		var odt = data.getAttribute("odt");
		$.ajax({
		    url: "modelos/imgs_con/consultar_imgs_odt.php",
		    type: "post",
			data: "&odt="+odt+"&key_no_revisado="+key_no_revisado,
		}).done(function(res){
			panoramico(res,odt);
			// $("#alerta-todo").css({"display":"block"});
			// $("#alerta-todo").animate({opacity:"1",top:"23px"},100);
			// $("#alerta-todo").css({"width":"700px","height":"520px"});
			// $("#texto").html(res);
		});
	}



	function panoramico(res,odt){

		var ancho = screen.width;
		var alto = screen.height;
		var alerta = $("#alerta-todo");

		if(ancho >= "1920"){
			var ancho_tab = ancho * .8;
			var alto_tab = alto * .8;
			var form = '<div id="img-tablero_datos_imgs">';		
		}

		if(ancho < "1920" && ancho >= "1280"){
			var ancho_tab = ancho * .8;
			var alto_tab = alto * .8;
			var form = '<div id="img-tablero_datos_imgs">';		
		}

		if(ancho < "1280"){
			var ancho_tab = ancho * .8;
			var alto_tab = alto * .8;
			var form = '<div id="img-tablero_datos_imgs" style="width:100%">';		
		}

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

	function consultar_ejecutivo(){
		$.ajax({
		    url: "modelos/validacion/ejecutivos.php",
		    type: "post",
			data: "&key=consultar_ejecutivo",
		}).done(function(res){
			// console.log(res);
		var out = "<table class='table-view'>"+
			"<tr>"+
			"<td style='width:100px;'>NOMBRE</td>"+
			"<td>USUARIO</td>"+
			"<td>TELEFONO</td>"+
			"<td>DIRECCION</td>"+
			"<td>SUPERVISOR</td>"+
			"<td>FEHCA DE INGRESO</td>"+
			"</tr>";
			var arr = JSON.parse(res);
			for(var i = 0; i <= arr.length-1; i++){
				out += "<tr>"+
				"<td><input onclick='elegir_evento(this.value);' style='width:100%;' type='button' class='boton' value='"+arr[i].nombre+"'</td>"+
				"<td>"+arr[i].user+"</td>"+
				"<td>"+arr[i].telefono+"</td>"+
				"<td>"+arr[i].direccion+"</td>"+
				"<td>"+arr[i].supervisor+"</td>"+
				"<td>"+arr[i].fecha_ingreso+"</td>"+
				"</tr>";
			}
			out += "</table>";
			$("#validacion-vista-ejecutivos").html(out);
		});
	}

</script>
<style type="text/css">
.input-checkbox-img{
	margin-bottom: 7px;
	margin-top: 7px;
	margin-left:20%;
	width:30px;
	height:30px;
}

.input-largo-img{
	width:100%;
	height:30px;
	font-size: 20px;
}

.input-radio{
	width:40px;
	height:40px;
}

.input-boton{
	width:100%;
	margin-bottom: 5px;
	margin-top: 5px;
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
</style>
<script type="text/javascript">
	function elegir_evento(val){
		$("#validacion-elegir_odt").css({"display":"block"});
		$("#validacion-elegir_odt-ejecutivo").val(val);
	}
	function validacion_asignar_evento(){
		$("#validvalidacion-elegir_odt").css({"display":"none"});
		var nombre = $("#validacion-elegir_odt-ejecutivo").val();
		var odt = $("#validacion-elegir_odt-odt").val();
		$.ajax({
			url: "modelos/validacion/ejecutivos.php",
		    type: "post",
			data: "&nombre="+nombre+"&odt="+odt+"&key=asignar_ejecutivo",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			var alerta = "";
			if(res == "1"){
				$("#validacion-elegir_odt").css({"display":"none"});
				$("#validacion-elegir_odt-odt").val("");
				alerta = "<br><br><label><center>SE ASIGNO AL EVENTO EL EJECUTIVO</center></label>";
			}
			if(res == "2"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>ERROR EN EL PROCESO DE REGISTRO, CONSULTA AL ADMINISTRADOR</center></label>";
			}
			if(res == "0"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>HACE FALTA LA ODT PARA LA ASIGNACION</center></label>";
			}
			if(res == "3"){
				$("#validacion-elegir_odt").css({"display":"block"});
				alerta = "<br><br><label><center>LA ODT NO EXISTE EN EL REGISTRO</center></label>";
			}

			$("#alerta-todo").css({"display":"block"});
			$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
			$("#alerta-todo").css({"width":"700px","height":"250px"});
			$("#texto").html(alerta);
			console.log(res);
		});
	}

	$(document).ready(function(){
		buscar_odt_eve();
		consultar_ejecutivo();
	});

	function validar_info(data){
		var odt = "";
		if(!data){
			odt = $("#valid-peticion-odt").val();
		}
		else{
			odt = data.getAttribute("odt");			
		}

		$.ajax({
		    url: "modelos/validacion.php",
		    type: "post",
			data: "&odt="+odt+"&key_con_todo_odt=1",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			var arr = JSON.parse(res);
			var out = '<h1>INFORMACION DE LA ODT</h1><table>'+
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
						'</tr>'+
							"<td><br></td>"+
						'<tr>'+
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
						'<tr>'+
							"<td><br></td>"+
						'</tr>'+
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
						'</tr>'+
							'<td colspan="1">'+
								'<input type="button" onclick="consulta_img_valid(this)" style="width:80%;height:100%;padding:10px;margin-left:6.5%;" value="IMAGENES" odt="'+arr[0].odt+'" class="boton">'+
							'</td>'+
							'<td colspan="3"><br><div>DESCRIPCION</div>'+
								'<textarea class="areas" type="text" class="input-largo" id="valid-peticion-descripcion" disabled>'+arr[0].descripcion+'</textarea><br><br>'+
							'</td>'+
						'</tr>'+
						'<tr>'+
						'<td colspan="4"><div>TOQUE: <input id="validacion-validar-toque" style="border:none; background:#0061a7; color:#fff;" type="text" value="'+arr[0].toque+'" disabled></div</td>'+
						'</tr>'+		
						'<tr>'+
							'<td>'+
								'<div>ESTATUS</div>'+
								'<input type="text" class="validacion-input-mostrar-datos" value="'+arr[0].estatus_validacion+'" disabled>'+
								'<select style="width:100%;" id="validacion-validar-estatus" class="input-largo">'+
									'<option>SELECCIONA</option>'+
									'<option>Exito</option>'+
									'<option>Rechazo</option>'+
									'<option>Sin Contacto</option>'+
									'<option>Volver a Llamar</option>'+
								'<select>'+
							'</td>'+
						'<td colspan="2">'+
								'<div>FECHA DE LLAMADA</div>'+
								'<input type="text" class="validacion-input-mostrar-datos" value="'+arr[0].fecha_llamada+'" disabled>'+
								'<input style="width:100%;" id="validacion-validar-fecha_llamada"  type="date" class="input-largo">'+
							'</td>'+
							'<td>'+
								'<div>HORA DE LLAMADA</div>'+
								'<input type="text" class="validacion-input-mostrar-datos" value="'+arr[0].hora_llamada+'" disabled>'+
								'<input style="width:100%;" id="validacion-validar-hora_llamada" type="time" class="input-largo">'+
							'</td>'+
						'</tr>'+
						'<tr><td><br></td></tr>'+
						'<tr>'+
							'<td colspan="5"><div>Comentarios</div>'+
								'<textarea class="areas" type="text" id="validacion-validar-comentarios" class="input-largo"">'+arr[0].comentarios_validacion+'</textarea>'+
							'</td>'+
							'<tr>'+
							'<td>'+
								'<input type="button" class="boton" id="valid-peticion-validar" onclick="validar_llamada();setTimeout(function(){validar_info();},500);" value="VALIDAR">'+
							'</td>'+
						'</tr>'+
					'</table>';

			$("#peticion-validacion").css({"display":"block"});
			$("#peticion-validacion").html(out);
		});
	}
	</script>
</div>
<style type="text/css">
	*{
		font-family:arial;
	}
	#validacion-excel-eventos > div table tr td{
		border:solid #fff 3px;
	}
	.validacion-opcion_excel{
		width:15%;
		position:relative;
		right:0;
	}
   .titulo{
      font-size:15px;
      font-weight: 600;
   }
   #vista-evento-validacion > div{
   		overflow-y: scroll;
	   	max-height:200px;
   }
   #vista-evento-validacion{
 	  /*height:200px;*/
   }
	h1{
		font-size:13px;
	}
	.areas{
		width:100%;
		height:35px;
	}
	#peticion-validacion table{
		width:100%;
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
	#validacion-vista-ejecutivos{
		max-height: 200px;
		overflow-y: scroll;
	}
	#validacion-vista-ejecutivos table tr:nth-child(1){
		/*position:absolute;*/
		top:0px;
	}
</style>