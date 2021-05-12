$(document).ready(function(){

});
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