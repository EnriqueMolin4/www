function accion(val,id,data){
	$("#alerta-todo").css({"display":"block"});
	$("#alerta-todo").animate({opacity:"1",top:"23px"},300);
	
	var afiliacion = data.getAttribute("data-afiliacion");
	var odt = data.getAttribute("data-odt");

	if(val == "1"){
		$("#alerta-todo").css({"width":"800px","height":"700px"});
		$("#alerta-todo").html(val);
		document.getElementById(id+"op").selected = "true";
		$.ajax({
		    url: "modelos/consulta_cierre_evento_cerrar.php",
		    type: "post",
			data: "&odt="+odt+"&afiliacion="+afiliacion,
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			$("#alerta-todo").html(res);
		});
	}
	if(val == "2"){
		$("#alerta-todo").html(val);
		document.getElementById(id+"op").selected = "true";
		$.ajax({
		    url: "modelos/consulta_evento_cierre.php",
		    type: "post",
			data: "&odt="+odt+"&afiliacion="+afiliacion,
			contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			$("#alerta-todo").html(res);
		});
	}
}
function alerta_todo(){
	// $("#alerta-todo").css({"display":"none","opacity":"0","top":"11px"});
}
$(window).resize(function(){
	$("#alerta-todo").css({"left":""+($(window).width()/2-$("#alerta-todo").width()/2)+"px"});
});

function terminal_cierre(val){
	$("#select-tipo-terminal").change(function(){
		var terminal = $(this).val();
		$.ajax({
	    url: "modelos/plugins/select_terminales_cierre.php",
	    type: "post",
		data: "&terminal="+terminal,
		contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			$("#select-tecnologia-terminal").html(res);
			alert(res);
		});
	});	
}

function tecnologia_terminal(val){
	$("#select-tecnologia-terminal").change(function(){
		var tecnologia = val;
		$.ajax({
	    url: "modelos/plugins/select_terminales_cierre.php",
	    type: "post",
		data: "&tecnologia="+tecnologia,
		contentType: "application/x-www-form-urlencoded",
		}).done(function(res){
			$("#alerta-todo").html(res);
			alert(res);
		});
	});	
}