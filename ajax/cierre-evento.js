
function select_territorios(opciones){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
	  if (this.readyState == 4 && this.status == 200){
		document.getElementById("selectEstados").innerHTML = this.responseText;
	  }
	}
	xmlhttp.open("POST","modelos/cierre_evento.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("&territorio="+opciones);
}
function select_territorios_regeve(opciones){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
	  if (this.readyState == 4 && this.status == 200){
		document.getElementById("selectEstados-regEve").innerHTML = this.responseText;
	  }
	}
	xmlhttp.open("POST","modelos/cierre_evento.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("&territorio="+opciones);
}

