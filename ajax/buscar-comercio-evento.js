function buscar_comercio_evento(){
	setTimeout(function(){

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (this.readyState == 4 && this.status == 200){
				var out = this.responseText;
				document.getElementById("vista-evento-previa").innerHTML = out;
				// document.getElementById("vista-evento").innerHTML = out;
				// document.getElementById("vista-consulta-cierre-eventos").innerHTML = out;
			}
		}
		
		xmlhttp.open("POST","/sinttecom/modelos/eventos/datos_evento.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
	},1000);
}

