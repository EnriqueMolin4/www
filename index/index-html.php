<?php 
ini_set('display_errors', 'On');
date_default_timezone_set('America/Mexico_City');
?>
<!DOCTYPE html>

<html>

<?php 
include 'index/head.php';
?>

<body background="#ccc">

<div id="alerta-todo" onclick="alerta_todo()">

	<section id="texto"></section>



	<input type="button" value="ACEPTAR" id="aceptar-alerta" onclick="aceptar_alerta()" class="boton">



</div>



<div id="secciones" style="position: absolute;width:100%;height:100%;"></div>



<script type="text/javascript">
function recargar(interval){
	var refresh = setInterval(function(){
		$.ajax({
			url: "sesiones/logout.php",
			type: "post",
			data: "",
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			window.location.reload();
		});
	}, interval);
	document.getElementById("secciones").onmouseover = function(){
		clearInterval(refresh);
	};
}

recargar(900000);

function cargar_doc(data){
	var seccion = data.getAttribute("data-seccion");

	$("#alerta-todo").css({"display":"none"});

	$("#secciones").html('<div style="left:200px;z-index:100;position:relative;top:170px;width:400px;" id="cargando-secciones">'+

			'<label style="font-weight:bold;width:100%;padding:15px;border-radius:3px;padding-left:35px;padding-right:35px;font-size:30px;background:#333;color:#fff;">Cargando...</label>'+

		'</div>');

	var ancho = $(window).width();
	if(ancho < 1250){
		$("#menu").css({"display":"none"});
		console.log(ancho);
	}
	switch(seccion){

		<?php if($_SESSION['tipo_user'] != 'user' or $_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'almacen'){ ?>

			case 'ALMACEN': 		  $("#secciones").load('index/almacen_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'user' or $_SESSION['tipo_user'] == 'admin'){ ?>

		case 'COMERCIOS': 			  $("#secciones").load('index/consulta_comercio_html.php'); break;

		<?php  } if(($_SESSION['tipo_user'] == 'callcenter') or ($_SESSION['tipo_user'] == 'ejecutivo_banco') or ($_SESSION['tipo_user'] == 'admin' ) or ($_SESSION['tipo_user'] == 'supervisor' and $_SESSION['tipo_user'] != 'user')){ ?>

		case 'VALIDACION': 			  $("#secciones").load('index/validacion_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'user' or $_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'supervisor'){ ?>

		case 'EVENTOS': 			  $("#secciones").load('index/registro_evento_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'CIERRE EVENTOS': 		  $("#secciones").load('index/cierre_evento_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'supervisor'){ ?>

		case 'ASIGNACION RUTA': 	  $("#secciones").load('index/asignacion_ruta_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'user'){ ?>

		case 'TRASPASOS': 			  $("#secciones").load('index/traspasos_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'SIMS': 				  $("#secciones").load('index/sims_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'user' or $_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'tecnico'  or $_SESSION['tipo_user'] == 'supervisor' or $_SESSION['tipo_user'] == 'callcenter'){ ?>

		case 'IMAGENES': 			  $("#secciones").load('index/correos_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'REGISTROS': 			  $("#secciones").html('SECCION EN CONSTRUCCION'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'BASE CONOCIMIENTOS': 	  $("#secciones").load('index/base_conocimiento_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'LABORATORIOS': 		  $("#secciones").load('index/laboratorio_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'CONSULTA INVENTARIOS':  $("#secciones").load('index/consulta_inventarios_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		case 'AJUSTES': 			  $("#secciones").load('index/ajustes_html.php'); break;

		<?php  } if(false){ ?>

		case 'PAGOS': 			      $("#secciones").load('index/pagos_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'tecnico'){ ?>

		case 'MAPAS': 			      $("#secciones").load('index/mapas_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'pdf'){ ?>

		case 'PDF': 			      $("#secciones").load('index/creador_pdf_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'reparacion'){ ?>

		case 'REPARACION': 			      $("#secciones").load('index/reparacion_html.php'); break;

		<?php  } if($_SESSION['tipo_user'] == 'admin'){ ?>

		default: 					  $("#secciones").html('NO SE ENCONTRO LA SECCION SOLICITADA');break;

		<?php } ?>
	}



	if($(window).width() >= 950){

		$("#registro-evento").css({"left":""+$(window).width()/2 - $("#registro-evento").width()/2+"px"});

		$("#comercios").css({"left":""+$(window).width()/2 - $("#comercios").width()/2+"px"});

		$("#cierre-evento").css({"left":""+$(window).width()/2 - $("#cierre-evento").width()/2+"px"});

		$("#almacen").css({"left":""+$(window).width()/2 - $("#almacen").width()/2+"px"});

		$("#asignacion_ruta").css({"left":""+$(window).width()/2 - $("#asignacion_ruta").width()/2+"px"});

		$("#traspasos").css({"left":""+$(window).width()/2 - $("#traspasos").width()/2+"px"});

		$("#base-conocimiento").css({"left":""+$(window).width()/2 - $("#base-conocimiento").width()/2+"px"});

		$("#validacion").css({"left":""+$(window).width()/2 - $("#validacion").width()/2+"px"});

		$("#traspasos").css({"left":""+$(window).width()/2 - $("#traspasos").width()/2+"px"});

	}	

	else{
		$("#registro-evento").css({"left":"200px"});

		$("#comercios").css({"left":"200px"});

		$("#validacion").css({"left":"200px"});

		$("#cierre-evento").css({"left":"200px"});

		$("#almacen").css({"left":"200px"});

		$("#asignacion_ruta").css({"left":"200px"});

		$("#traspasos").css({"left":"200px"});

		$("#base-conocimiento").css({"left":"200px"});

	}



	var div = $("#cargando-secciones");

	if($(window).width() >= 500){

		div.css({"left":""+($(window).width()/2)-(div.width()/2)+"px"})

	}

	else{

		div.css({"left":"200px"});

	}

}

$(window).resize(function(){

	var div = $("#cargando-secciones");

	if($(window).width() >= 500){

		div.css({"left":""+($(window).width()/2)-(div.width()/2)+"px"})

	}

	else{

		div.css({"left":"200px"});

	}

});

function paginacion(id_res,id,id_in,ruta,form){
	$.ajax({
		url: ruta,
		type: "post",
		data: form,
	}).done(function(res){
		console.log(res);
		res = JSON.parse(res);
	var args = id_in+','+ruta+','+form+','+id_res+',';
	var out = '<input type="button" data-args="'+args+'" onclick="pag_func(this)" class="boton" value="<<">'+
		' Pagina: <input type="text" class="input" id="'+id_in+'-pag-list" style="width:70px;" value="'+res[0]+'" disabled>'+
		' De: <input type="text" class="input" style="width:70px;" value="'+res[1]+'" disabled>'+
		'<input type="button" data-args="'+args+'" onclick="pag_func(this)" class="boton" value=">>">';
		$("#"+id_res).html(res[2]);
		$('#'+id).html(out);
	});
}
function pag_func(dat){
	var data = dat.getAttribute("data-args");
	var str = '';
	var out = [];
	for(var i = 0; i <= data.length-1; i++){
		if(data[i] != ','){
			str += data[i];
		}else{
			out.push(str);
			str = '';
		}
	}
	var id_in = out[0];
	var ruta = out[1];
	var forml = out[2];
	var id_res = out[3];
	if(dat.value == '>>'){
		var form = '&masmenos=mas';
	}else{
		var form = '&masmenos=menos';
	}
	form += forml+"&actual="+$("#"+id_in+"-pag-list").val();
	dat.classList.remove("boton");
	dat.classList.add("boton-dis");
	dat.disabled = true;
	$.ajax({
		url: ruta,
		type: "post",
		data: form,
	}).done(function(res){
		console.log(form);
		setTimeout(function(){
			dat.classList.remove("boton-dis");
			dat.classList.add("boton");
			dat.disabled = false;
		},700);
		res = JSON.parse(res);
		$("#"+id_in+"-pag-list").val(res[0]);
		$("#"+id_res).html(res[2]);
	});
}

</script>





<!-- CONTENEDOR DE LAS ACTIVIDADES DEL SISTEMA -->

<div id="contenedor0" class="contenedor">



<img id="fondo_img" src="view/img/back_cont.jpg">



<?php if(($_SESSION['tipo_user'] != '')){ ?>

	

	<div id="menu-despligue-responivo">

		<div></div><div></div><div></div>

	</div>

	<div>



	<div id="menu">

	<img src="view/img/logo.png">



	<?php if(($_SESSION['tipo_user'] == 'ejecutivo_banco') or $_SESSION['tipo_user'] == 'user' or ($_SESSION['tipo_user'] == 'admin')) {?>

		<h1 onclick="cargar_doc(this);" data-seccion="COMERCIOS" class="item-menu" id="menu-comercio">COMERCIOS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'callcenter') or ($_SESSION['tipo_user'] == 'ejecutivo_banco') or ($_SESSION['tipo_user'] == 'admin' ) or ($_SESSION['tipo_user'] == 'supervisor' and $_SESSION['tipo_user'] != 'user')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="VALIDACION" class="item-menu" id="menu-validacion">VALIDACION</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'ejecutivo_banco') or $_SESSION['tipo_user'] == 'user' or ($_SESSION['tipo_user'] == 'admin') or $_SESSION['tipo_user'] == 'supervisor') {?>



		<h1 onclick="cargar_doc(this);" data-seccion="EVENTOS" class="item-menu" id="menu-eventos">EVENTOS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'cierres') or ($_SESSION['tipo_user'] == 'admin')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="CIERRE EVENTOS" class="item-menu" id="menu-cierres">CIERRE EVENTOS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'almacen' and $_SESSION['tipo_user'] != 'user') or $_SESSION['tipo_user'] == 'admin') {?>



		<h1 onclick="cargar_doc(this);" data-seccion="ALMACEN" class="item-menu" id="menu-almacen">ALMACEN</h1>



		<?php }?>



		<?php if(false) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="PAGOS" class="item-menu" id="menu-pagos">PAGOS</h1>



		<?php }?>



		<?php if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'supervisor' ){?>



		<h1 onclick="cargar_doc(this);" data-seccion="ASIGNACION RUTA" class="item-menu" id="menu-asignacion_ruta">ASIGNACION RUTA</h1>



		<?php }?>



		<?php if($_SESSION['tipo_user'] == 'admin' or $_SESSION['tipo_user'] == 'user') {?>



		<h1 onclick="cargar_doc(this);" data-seccion="TRASPASOS" class="item-menu" id="menu-traspasos">INVENTARIOS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin')) {?>



		<!-- <h1 onclick="cargar_doc(this);" data-seccion="SIMS" class="item-menu" id="menu-sims">SIMS</h1> -->



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin') or $_SESSION['tipo_user'] == 'user' or ($_SESSION['tipo_user'] == 'tecnico') or ($_SESSION['tipo_user'] == 'callcenter') or ($_SESSION['tipo_user'] == 'supervisor')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="IMAGENES" class="item-menu" id="menu-correo">IMAGENES</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin') or ($_SESSION['tipo_user'] == 'tecnico')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="MAPAS" class="item-menu" id="menu-mapas">MAPAS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin') or ($_SESSION['tipo_user'] == 'reparacion')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="REPARACION" class="item-menu" id="menu-reparacion">REPARACION</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'almacen') or ($_SESSION['tipo_user'] == 'admin')) {?>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin')) {

			?>



		<h1 onclick="cargar_doc(this);" data-seccion="BASE CONOCIMIENTOS" class="item-menu" id="menu-base-conocimientos">BASE CONOCIMIENTOS</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin')) {?>



		<!-- <h1 onclick="cargar_doc(this);" data-seccion="LABORATORIOS" class="item-menu" id="menu-laboratorios">LABORATORIOS</h1> -->



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'almacen') or ($_SESSION['tipo_user'] == 'admin')) {?>



		<!-- <h1 onclick="cargar_doc(this);" data-seccion="CONSULTA INVENTARIOS" class="item-menu" id="menu-inventarios">CONSULTA INVENTARIOS</h1> -->



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'pdf')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="PDF" class="item-menu" id="menu-pdf">CREAR PDF</h1>



		<?php }?>



		<?php if(($_SESSION['tipo_user'] == 'admin')) {?>



		<h1 onclick="cargar_doc(this);" data-seccion="AJUSTES" class="item-menu" id="menu-ajustes">AJUSTES</h1>



		<?php }?>



	</div>



<?php } ?>



	<div id="bienvenido"> <?php echo 'Bienvenido '.strtoupper($_SESSION['user']); ?> </div>



	<div id="salir"><a href="sesiones/logout.php">SALIR</a></div>



	</div>



<script type="text/javascript" src="ajax/alta-comercio.js"></script>

	<script type="text/javascript">

	function menu_responsivo(){

		var ancho = $(window).width();

		if(ancho < 1250){

			$("#menu-despligue-responivo").css({"display":"block"});

			$("#menu").css({"width":"100%","display":"none"});

			$(".item-menu").css({"width":"100%"});

			$(".item-menu > h1").css({"width":"100%","text-align":"center"});

		}

		else{
			$("#menu-despligue-responivo").css({"display":"none"});
			$("#menu").css({"display":"block"});
			$("#menu").css({"width":"200px"});
			$(".item-menu").css({"width":"200px"});
		}

	}

	function aceptar_alerta(){

		$("#alerta-todo").animate({opacity:"0"},150);

		setTimeout(function(){

			$("#alerta-todo").css({"display":"none","top":"0px"});

		},500);



	}

	$(window).resize(function(){

		menu_responsivo()

	});

	$(document).ready(function(){

		menu_responsivo()

	});

	$("#menu-despligue-responivo").click(function(){

		if($("#menu").css('display') == 'block'){

			$("#menu").css({"display":"none"});

		}

		else{

			$("#menu").css({"display":"block"});

		}

	});	

	</script>
	<style type="text/css">
		.boton-dis{
			background:#333;
			border:solid 1px #ccc;
			padding:7px;
			color:#fff;
		}
		.boton-dis:hover{
			background: #333;
			border:solid 1px #ccc;
			padding:7px;
			color:#fff;
		}
		.paginacion{
			display: inline;
			width: 30%;
		}
		.paginacion input{
			margin-left:3px;
			margin-right:3px;
			margin-top:3px;
			margin-bottom:3px;
		}
		#cargando-seccion h1{
			color:#fff;
			background:#333;
			border-radius:3px;
			font-size:25px;
		}

		#menu-despligue-responivo{
			background: #0061a7;
			border-radius: 50px;
			width:50px;
			height:50px;
			color:#fff;
			z-index: 1000;
			text-align: center;
			vertical-align: middle;
			position:absolute;
			top:10px;
			left:10px;
			cursor:pointer;
			position:fixed;
			-webkit-box-shadow: 4px 11px 22px -12px rgba(0,0,0,0.75);
-moz-box-shadow: 4px 11px 22px -12px rgba(0,0,0,0.75);
box-shadow: 4px 11px 22px -12px rgba(0,0,0,0.75);
		}

		#menu-despligue-responivo > div{
			position: relative;
			width: 45%;
			margin-left: 14px;
			height:2px;
			z-index: 1001;
			margin-top: 10.8px;
			background:#fff;
		}

	</style>
	</body>


</html>



