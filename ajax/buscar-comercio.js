function buscar_comercio(){

	var select_comercio= $("#consulta-comercio-select").val();
	var input_comercio = $("#consulta-comercio-input").val();

	form = "&select_comercio="+select_comercio+"&input_comercio="+input_comercio;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200){
			$("#vista-comercio").html('CARGANDO...');
			$("#vista-comercio").html(res);
		}
	}
	
	xmlhttp.open("POST","modelos/comercios/consulta_comercio.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(form);
}