$(document).ready(function(){
		
	$("#renovar-contra a").click(function(){
		$("#renovar-contra").css({"display":"none"});
	});

	$("#nueva-contra").click(function(){
		$("#renovar-contra").css({"display":"block"});
	});

});