		
$(document).ready(function(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	   if (this.readyState == 4 && this.status == 200){
	   		var out = this.responseText;
	   		// document.getElementById("vista-consulta-evento").innerHTML = out;
	   		// document.getElementById("vista-consulta-cierre-eventos").innerHTML = out;
	   		document.getElementById("vista-evento").innerHTML = out;
	    }
	}

	xmlhttp.open("POST","modelos/consultar_evento.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
});

function counsulta(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	   if (this.readyState == 4 && this.status == 200){
	   		var out = this.responseText;
	   		document.getElementById("vista-consulta-evento").innerHTML = out;
	   		document.getElementById("vista-evento").innerHTML = out;
	    }
	}
	xmlhttp.open("POST","modelos/consultar_evento.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}
