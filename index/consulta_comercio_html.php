<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
  }
?>
<div class="apartado" id="comercios">
<div id="alerta-comercio" style="left:230px;position:absolute;background:#f1f1f1;z-index:100;"></div>

	
	<div class="sub-apartado">
		<h1>CONSULTA DE COMERCIOS</h1>
		<table>
			<tr>
				<td><label>Afiliacion:</label><br>

				<input type="text" class="input-largo" onkeyup="filtro_comercio()" id="consulta_comercios-afiliacion"></td>

				<td colspan="2"><label>Comercio:</label><br>

				<input type="text" class="input-largo" onkeyup="filtro_comercio()" id="consulta_comercios-comercio"></td>
				<?php if($_SESSION['tipo_user'] != 'user'){ ?>
				<td><label>Clave Bancaria:</label><br>

				<input type="text" class="input-largo" onkeyup="filtro_comercio()" id="consulta_comercios-cve"></td>

				<td><label>Responsable:</label><br>

				<input type="text" class="input-largo" onkeyup="filtro_comercio()" id="consulta_comercios-responsable"></td>

				<td><label>Telefono:</label><br>

				<input type="text" class="input-largo" onkeyup="filtro_comercio()" id="consulta_comercios-telefono"></td>
				<?php } ?>
			</tr>
		</table>
		<br>
		<section id="vista-comercio" style="max-height:250px;"></section>
		<div id="paginacion-comercios" class="paginacion"></div>
	</div>


	<div class="sub-apartado">
		<?php if($_SESSION['tipo_user'] != 'user'){ ?><h1>REGISTRO DE COMECIO</h1><?php } ?>
		<table id="comercios-registro_comercio">

			<tr>

				<td colspan="1"><label>Clave Bancaria: </label><br><input type="text" id="alt-com-cve_banco" class="input-largo"></td>

				<td><label>Afiliacion:</label><br><input type="text" id="alt-com-afiliacion" class="input-largo"></td>

				<td colspan="3"><label>Comercio</label><bt><input type="text" style="width:99.9%;" id="alt-com-comercio" class="input-largo"></td>

			</tr>

			<tr>

				<td colspan="2"><label>Responsable:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-responsable" class="input-largo"></td>

				<td colspan="2"><label>Propietario:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-propietario" class="input-largo"></td>

			</tr>

			<tr>
				<td colspan="1"><label>Codigo Postal:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-cp" placeholder="ENTER PARA BUSCAR" class="input-largo" onkeyup="comp_cp(event,this.value)"></td>
				
				<td colspan="1"><label>Estado:</label><br>

				<select style="width:99.9%;" type="text" id="alt-com-estado" class="input-largo">
					<?php 
					include '../modelos/conexion.php';
					$con = $conexion->query("SELECT * from `estados`");
					echo '<option>SELECCIONA</option>';
					while($dato = mysqli_fetch_array($con)){
						echo '<option>'.$dato['nombre'].'</option>';
					}

					?>
				</select></td>

				<td colspan="3"><label>Direccion:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-direccion" class="input-largo"></td>

			</tr>
			<tr>
				<td colspan="2"><label>Colonia:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-colonia" class="input-largo"></td>

				<td colspan="1"><label>Ciudad:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-ciudad" class="input-largo"></td>

				<td colspan="1"><label>Territorial Banco:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-territorial_banco" class="input-largo"></td>

				<td colspan="1"><label>Territorial Sinttecom:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-territorial_sinttecom" class="input-largo"></td>

			</tr>

			<tr>
				<td colspan="2"><label>R.F.C:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-rfc" class="input-largo"></td>

				<td colspan="1"><label>Telefono:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-telefono" class="input-largo"></td>

				<td colspan="1"><label>Tipo de Comercio:</label><br>

				<select id="alt-com-tipo_comercio" class="select input-largo">

					<option>SELECCIONA</option>

					<option value="normal">NORMAL</option>

					<option value="vip">VIP</option>

				</select>

				</td>

				<td colspan="2"><label>Razon Social:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-razon_social" class="input-largo"></td>
			</tr>

			<tr>

				<td colspan="1"><label>Email del Comercio:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-email" class="input-largo"></td>

				<td colspan="1"><label>Email Ejecutivo:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-email_ejecutivo" class="input-largo"></td>

				<td colspan="1"><label>Horario de Comida:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-hora_comida"" class="input-largo"></td>

				<td colspan="1"><label>Horario General:</label><br>

				<input style="width:99.9%;" type="text" id="alt-com-hora_general" class="input-largo"></td>

			</tr>

			<tr>

				<td colspan="1">
			<?php if($_SESSION['tipo_user'] != 'user'){ ?>
				<input type="button" id="comercio-boton-registrar" style="display: inline;width:99%;" onclick="registrar();setTimeout(function(){consulta_comercios();},500);" id="alt-com-enviar" value="REGISTRAR" class="boton">
			<?php } ?>
				</td>

				<td colspan="3"></td>

				<td colspan="1">

				<input style="display: inline;width:99%;" id="comercio-boton-limpiar" onclick="clean();" class="boton" type="button" value="LIMPIAR" id="tipo-comercio-masivo">

				</td>

			</tr>

		</table>

	</div>

	<br>

	<?php if($_SESSION['tipo_user'] != 'user'){ ?>
	<div class="sub-apartado">
	<h1>REGISTRO MASIVO</h1><br>
		<form enctype="multipart/form-data" method="POST">
			<input type='file' name="excel" id='excel-comercio-archivo'>
			<strong style="margin-left:10px;">Desde : </strong><input type='text' class='input-largo' id='excel-coemrcio-desde'>
			<input type='button' onclick='form_comercio_masivo()' style="margin-left:10px;" class='boton' value='REGISTRAR'>
		</form>
	</div>
	<?php } ?>

	<label id="res-subida-archivo"></label>

	<img class="cargando-gif" src="view/img/loading.gif">

 </div>

<script type="text/javascript">
paginacion('vista-comercio',
	'paginacion-comercios',
	'comercios',
	'modelos/comercios/consulta_comercio.php',

);
function comp_cp(e,val){
	if(e.keyCode == 13){
        $.ajax({
			url: "modelos/plugins/consulta_cp_comercio.php",
			type: "post",
			data: "&key_find_dato=1&cp="+val,
		}).done(function(res){
			console.log(res);
			if(JSON.parse(res)){
				var arr = JSON.parse(res);
				$("#alt-com-estado").val(arr[0].estado);
				$("#alt-com-ciudad").val(arr[0].ciudad);
				$("#alt-com-territorial_banco").val(arr[0].territorial_banco);
				$("#alt-com-territorial_sinttecom").val(arr[0].territorial_sinttecom);
			}
			else{
				$("#alerta-todo").css({"display":"block"});
				$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
				$("#alerta-todo").css({"width":"600px","height":"550px"});
				$("#texto").html(res);
			}
		});
	}
}

function clean(){
	$("#comercios-registro_comercio tr td input").val("");
	$(".select").val($('option:first', $(".select")).val());
	$("#comercio-boton-registrar").val("REGISTRAR");
	$("#comercio-boton-limpiar").val("LIMPIAR");
}
function filtro_comercio(data){

	paginacion('vista-comercio',
	'paginacion-comercios',
	'comercios',
	'modelos/comercios/consulta_comercio.php',
	<?php if($_SESSION['tipo_user'] != 'user'){ ?>
		"&cve="+$("#consulta_comercios-cve").val()+
		"&responsable="+$("#consulta_comercios-responsable").val()+
		"&telefono="+$("#consulta_comercios-telefono").val()+
		"&afiliacion="+$("#consulta_comercios-afiliacion").val()+
		"&comercio="+$("#consulta_comercios-comercio").val()
	<?php }else{ ?>
		"&afiliacion="+$("#consulta_comercios-afiliacion").val()+
		"&comercio="+$("#consulta_comercios-comercio").val()
	<?php } ?>
	);

}

function datos_cp_comercio(val){
	$.ajax({
		url: "modelos/plugins/consulta_cp_comercio.php",
		type: "post",
		data: "&key_find_dato=1&cp="+val,
	}).done(function(res){
		var arr = JSON.parse(res);
		$("#alt-com-cp").val(arr[0].cp);
		$("#alt-com-estado").val(arr[0].estado);
		$("#alt-com-ciudad").val(arr[0].ciudad);
		$("#alt-com-territorial_banco").val(arr[0].territorial_banco);
		$("#alt-com-territorial_sinttecom").val(arr[0].territorial_sinttecom);
	});
}

function consulta_cp_comercio(val){

	$.ajax({

	    url: "modelos/plugins/consulta_cp_comercio.php",

	    type: "post",

		data: "&key_cp_com=1&cp="+val,

	}).done(function(res){

		$(".cargando-gif").css({"display":"none"});

		$("#alerta-todo").css({"display":"block"});

		$("#alerta-todo").animate({opacity:"1",top:"23px"},300);

		$("#alerta-todo").css({"width":"600px","height":"210px"});

		$("#texto").html(res);

	});

}

function alerta_reg_masivo_comercio(){
	var out = "<br><div style='width:95%;margin-left:2.5%;'>"+
	"<label>Archivo : </label><input type='file' style='width:100%;' id='excel-comercio-archivo'><br>"+
	"<label>Desde : </label><input type='text' class='input-largo' style='width:100%;' id='excel-coemrcio-desde'><br><br>"+
	"<input type='button' style='width:100%;' onclick='form_comercio_masivo()' class='boton' value='REGISTRAR'>"+
	"</div>";
	$("#alerta-todo").css({"display":"block"});
	$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
	$("#alerta-todo").css({"width":"600px","height":"210px"});
	$("#texto").html(out);
}

function form_comercio_masivo(){
 	var form = new FormData();
 	var file = document.getElementById("excel-comercio-archivo");
 	var dato = document.getElementById("excel-coemrcio-desde").value;
 	form.append('archivo',file.files[0]);
 	form.append('dato',dato);

 	$("#texto").html('<img class="cargando-gif" src="view/img/loading.gif" style="display:block;"');

	$.ajax({
	    url: "modelos/comercios/registro_masivo_comercio.php",
	    type: "post",
		data: form,
		contentType:false,
		processData:false,
		cache:false,
	}).done(function(res){
		$(".cargando-gif").css({"display":"none"});
		$("#alerta-todo").css({"display":"block"});
		$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
		$("#alerta-todo").css({"width":"600px","height":"250"});
		$("#texto").html('<br>'+res);
	});
}

function consulta_comercios(){

	paginacion('vista-comercio',
	'paginacion-comercios',
	'comercios',
	'modelos/comercios/consulta_comercio.php',
	<?php if($_SESSION['tipo_user'] != 'user'){ ?>
		"&cve="+$("#consulta_comercios-cve").val()+
		"&responsable="+$("#consulta_comercios-responsable").val()+
		"&telefono="+$("#consulta_comercios-telefono").val()+
		"&afiliacion="+$("#consulta_comercios-afiliacion").val()+
		"&comercio="+$("#consulta_comercios-comercio").val()
	<?php }else{ ?>
		"&afiliacion="+$("#consulta_comercios-afiliacion").val()+
		"&comercio="+$("#consulta_comercios-comercio").val()
	<?php } ?>
	);

}

 	$(document).ready(function(){

 		consulta_comercios();

 		$("#atras-tipo-comercio").click(function(){

 			$(this).css({"display":"none"});

 			$("#res-subida-archivo").css({"display":"none"});

 			$("#consulta-comercio").css({"display":"none"});

 			$("#registro-comercio > table").css({"display":"none"});

 			$("#botones-tipo-registro-comercio").css({"display":"block"});

 			$("#excel-form-comercio").css({"display":"none"});

 		});

 		$("#tipo-comercio-masivo").click(function(){

 			$("#botones-tipo-registro-comercio").css({"display":"none"});

 			$("#excel-form-comercio").css({"display":"block"});

 		});

 		$("#tipo-comercio-individual").click(function(){

 			$("#consulta-comercio").css({"display":"block"});

 			$("#atras-tipo-comercio").css({"display":"block"});

 			$("#botones-tipo-registro-comercio").css({"display":"none"});

 			$("#registro-comercio > table").css({"display":"block"});

 		});

 	});

 </script>

 <style type="text/css">

 	#excel-form-comercio, #registro-comercio > table, #registro-comercio > h2{

 		/*display:none;*/

 	}

 	#alt-com-enviar{

 		width:100%;

 	}

 	.cargando-gif{

 		position:relative;

 		left:45%;

 		top:100px;

 		width:80px;

 		height:80px;

 		display:none;

 	}

 	#excel-form-comercio{

 		position:relative;

 		top:-30px;

 		width:60%;

 		left:20%;

 		height:170px;

 		background:#fff;

 		border:solid 1px #ccc;

 	}

 	#excel-form-comercio input{

 		margin-left:1%;

 	}

 	#comercios-registro_comercio tr td{

 		border:solid 2px #fff;

 	}

 	#botones-tipo-registro-comercio{

 		width:50%;

 		height:100px;

 		background:#fff;

 		border:solid 1px #ccc;

 		margin-left:25%;

 		margin-top:2%;

 	}

 	#botones-tipo-registro-comercio input{

 		margin-left: 16%;

 		margin-top: 3.5%;

 	}

 	#botones-tipo-registro-comercio label{

 		font-weight:bold;

 		border:solid 1px #fff;

 		padding: 5px;

 		color:#fff;

 		background: #0061a7;

 		position:relative;

 		margin-left:40px;

 		top:-6px;

 	}

 	#atras-tipo-comercio{

 		background:#007dc1;

 		color:#fff;

 		margin-left:10px;

 		border:solid 1px #fff;

 		padding-left:10px;

 		padding-right:10px;

 		padding-bottom:5px;

 		padding-top:5px;

 		display:none;

 	}

 	#atras-tipo-comercio:hover{

 		background:#0061a7;

 	}

 	#res-subida-archivo{

 		position:absolute;

 		top:210px;

 		width:90%;

 		left:5%;

 		height:155%;

 		overflow-x: scroll;

 		display:none;

 		/*text-align:center;*/

 		/*background:#333;*/

 	}

 	#vista-comercio{

 		overflow-y: scroll;

 	}
 	.boton-comercio{
 		padding-top: 2px;
 		padding-bottom: 2px;
 		margin-bottom:2px;
 		background:#0085ba;
 		border:solid 2px #006799;
 		border-radius:1px;
 		color:#fff;
 		cursor:pointer;
 	}
 	.boton-comercio:hover{
 		background:#006799;
 	}

 </style>