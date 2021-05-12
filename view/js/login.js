
$(document).ready(function(){
	$("#logueo").css({"left":""+$(window).width()/2 - $("#logueo").width()/2+"px"});
	$("#logueo").css({"top":""+$(window).height()/2 - $("#logueo").height()/1.5+"px"});
	$("#nueva-contra").click(function(){
		$("logueo").css({"display":"block"});
	});
});

$(window).resize(function(){
	$("#logueo").css({"left":""+$(window).width()/2 - $("#logueo").width()/2+"px"});
	$("#logueo").css({"top":""+$(window).height()/2 - $("#logueo").height()/1.5+"px"});
});