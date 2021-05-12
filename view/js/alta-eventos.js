
$(document).ready(function(){

	$(window).scroll(function(){
		var altura = $("#alerta-todo").offset().top;
		$("#alerta-todo").animate({top:"" +( $(window).scrollTop() + 30) +"px"},10);
	});


	$("#registro-evento").css({"left":""+$(window).width()/2 - $("#registro-evento").width()/2+"px"});
	$("#comercios").css({"left":""+$(window).width()/2 - $("#comercios").width()/2+"px"});
	$("#cierre-evento").css({"left":""+$(window).width()/2 - $("#cierre-evento").width()/2+"px"});
	$("#almacen").css({"left":""+$(window).width()/2 - $("#almacen").width()/2+"px"});
	$("#asignacion_ruta").css({"left":""+$(window).width()/2 - $("#asignacion_ruta").width()/2+"px"});
	$("#traspasos").css({"left":""+$(window).width()/2 - $("#traspasos").width()/2+"px"});
	$("#validacion").css({"left":""+$(window).width()/2 - $("#validacion").width()/2+"px"});
	$("#base-conocimiento").css({"left":""+$(window).width()/2 - $("#base-conocimiento").width()/2+"px"});

	$(".table-view tr:first").css({"background":"#333","color":"#fff"});



	$("#correo").css({"display":"block"});

	$("#contenedor0 > table").css({"left":""+$("#contenedor0").width()/2 - $("#contenedor0 > table").width()/2+"px"});

	$(".contenedor").css({"left":""+$(window).width()/2 - $(".contenedor").width()/2+"px"});

	if($(window).width() >= 1100){

		$("#registro-comercio").css({

			"left":""+$(window).width()/2 - $("#registro-comercio").width()/2+"px"});

		$("#registro-evento").css({"left":""+$(window).width()/2 - $("#registro-evento").width()/2+"px"});

		// $("#consulta-comercio").css({"width":""+$(window).width()-150+"px"});

	}

	else{

		// $("#consulta-comercio").css({"width":"800px"});

		$("#registro-comercio").css({

			"left":"150px"});

	}

	if($(window).height() >= 800){

		$("#consulta-comercio").css({"height":"650px"});

		$("#registro-comercio").css({"bottom":""+($("#consulta-comercio").height()+10)+"px"})

	}

	else{

		$("#consulta-comercio").css({"height":"320px"});

		$("#registro-comercio").css({"bottom":""+($("#consulta-comercio").height()+10)+"px"})

	}



	$("#sec0").mouseover(function(){

		$(this).css({"background":"#fff","color":"#000"});

		$("#sec0 > ul").css({"display":"block"});

		$("#sec0 > ul li").css({"display":"block"});

	});

	$("#sec0").mouseout(function(){

		$(this).css({"background":"#333","color":"#fff"});

		$("#sec0 > ul").css({"display":"none"});

	});

	$("#consulta-comercio").css({"top":""+($("#registro-comercio").height()+90)+"px"});

	function aceptar_alerta(){

		$("#alerta-todo").animate({opacity:"0"},150);

		setTimeout(function(){

			$("#alerta-todo").css({"display":"none","top":"0px"});

		},500);

	}


// FUNCIONES PARA EL CAMBIO DE COLOR EN EL MENU DE ITEMS LATERAL

	var item_menu = $(".item-menu");

	$(".item-menu:nth-child(2)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(3)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(4)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(5)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(6)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(7)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(8)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(9)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(10)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(11)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(12)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(13)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});

	$(".item-menu:nth-child(14)").click(function(){

		$("#menu > h1").removeClass("class-activado");

		$(this).addClass("class-activado");

		// $(".apartado").css({"display":"none"});

	});





// EVENTOS PARA LA ADMINISTRACION DEL DESPLIEGUE EN PATNALLA DE LOS APARTADOS

	$("#menu-comercio").click(function(){

		$("#comercios").css({"display":"block"});

	});

	$("#menu-pagos").click(function(){

		$("#pagos").css({"display":"block"});

	});

	$("#menu-correo").click(function(e){

		$("#correo").css({"display":"block"});

	});

	$("#menu-eventos").click(function(e){

		$("#registro-evento").css({"display":"block"});

	});

	$("#menu-validacion").click(function(){

		$("#validacion").css({"display":"block"});

	});

	$("#menu-cierres").click(function(){

		$("#cierre-evento").css({"display":"block"});

	});

	$("#menu-almacen").click(function(){

		$("#almacen").css({"display":"block"});

	});

	$("#menu-asignacion_ruta").click(function(){

		$("#asignacion_ruta").css({"display":"block"});

	});

	$("#menu-traspasos").click(function(){

		$("#traspasos").css({"display":"block"});

	});

	$("#menu-sims").click(function(){

		$("#sims").css({"display":"block"});

	});

	$("#menu-tecnicos").click(function(){

		$("#tecnicos").css({"display":"block"});

	});

	$("#menu-base-conocimientos").click(function(){

		$("#base-conocimiento").css({"display":"block"});

	});

	$("#menu-laboratorios").click(function(){

		$("#laboratorio").css({"display":"block"});

	});

	$("#menu-inventarios").click(function(){

		$("#consulta-inventarios").css({"display":"block"});

	});

	$("#menu-ajustes").click(function(){

		$("#ajustes").css({"display":"block"});

	});

	$("#menu-pdf").click(function(){

		$("#excel-pdf").css({"display":"block"});

	});



	$("#alt-eve-label-archivo").css({"left":""+$(window).width() / 2 - $("#alt-eve-label-archivo").width()/2+75+"px"});

	$("#subir-excel").css({"left":""+$(window).width() / 2 - $("#alt-eve-label-archivo").width() +150+"px"});

	$("#imp-pdf").css({"left":""+$(window).width() / 2 - $("#alt-eve-label-archivo").width() +150+"px"});

	$("#alerta-pdf").css({"left":""+$(window).width() / 2 - $("#alerta-pdf").width() +310+"px"});

	$("#generales-comercio").css({"left":""+$(window).width()/2 - $("#generales-comercio").width()/2+75+"px"});

	$(".activo").click(function(){

		alert('holo');

	});

	// $(".activo").mouseout(function(){

	// 	$(this).css({"background":"#0061a7"});

	// });

});



$(window).resize(function(){

	$("#comercios").css({"left":""+$(window).width() / 2 - $("#comercios") / 2+"px"});

	if($(window).width() > 1400){

		console.log('si');

		// $("#registro-evento").css({"height":"900px"});

	}

	else{

		// $("#registro-evento").css({"height":"550px"});	

	}

	$("#back").css({"width":""+$(window).width()-150+""});

	$("#registro-evento").css({"left":""+$(window).width()/2 - $("#registro-evento").width()/2+"px"});
	$("#comercios").css({"left":""+$(window).width()/2 - $("#comercios").width()/2+"px"});
	$("#cierre-evento").css({"left":""+$(window).width()/2 - $("#cierre-evento").width()/2+"px"});
	$("#almacen").css({"left":""+$(window).width()/2 - $("#almacen").width()/2+"px"});
	$("#asignacion_ruta").css({"left":""+$(window).width()/2 - $("#asignacion_ruta").width()/2+"px"});
	$("#traspasos").css({"left":""+$(window).width()/2 - $("#traspasos").width()/2+"px"});
	$("#base-conocimiento").css({"left":""+$(window).width()/2 - $("#base-conocimiento").width()/2+"px"});
	$("#validacion").css({"left":""+$(window).width()/2 - $("#validacion").width()/2+"px"});
	$("#traspasos").css({"left":""+$(window).width()/2 - $("#traspasos").width()/2+"px"});
	$("#pagos").css({"left":""+$(window).width()/2 - $("#pagos").width()/2+"px"});

	if($(window).height() >= 800){

		$("#consulta-comercio").css({"height":"650px"});

		$("#registro-comercio").css({"bottom":""+($("#consulta-comercio").height()+10)+"px"})

	}

	else{

		$("#consulta-comercio").css({"height":"320px"});

		$("#registro-comercio").css({"bottom":""+($("#consulta-comercio").height()+10)+"px"})

	}

	$("#subir-excel").css({"left":""+$(window).width() / 2 - $("#alt-eve-label-archivo").width() +150+"px"});
	$("#imp-pdf").css({"left":""+$(window).width() / 2 - $("#alt-eve-label-archivo").width() +150+"px"});
	$("#alerta-pdf").css({"left":""+$(window).width() / 2 - $("#alerta-pdf").width() +310+"px"});

	$("#consulta-comercio").css({"width":""+$(window).width()-150+"px"});
	$("#contenedor0 > table").css({"left":""+$("#contenedor0").width()/2 - $("#contenedor0 > table").width()/2+"px"});
	$(".contenedor").css({"left":""+$(window).width()/2 - $(".contenedor").width()/2+"px"});
	$("#generales-comercio").css({"left":""+$(window).width()/2 - $("#generales-comercio").width()/2+75+"px"});	
});