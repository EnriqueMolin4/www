
function select_estados(estados){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
	  if (this.readyState == 4 && this.status == 200){
		document.getElementById("selectMunicipios").innerHTML = this.responseText;
	  }
	}
	xmlhttp.open("POST","modelos/cierre_eventos_municipios.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("&estados="+estados);
}
function select_estados_regeve(estados){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
	  if (this.readyState == 4 && this.status == 200){
		document.getElementById("selectMunicipios-regEve").innerHTML = this.responseText;
	  }
	}
	xmlhttp.open("POST","modelos/cierre_eventos_municipios.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("&estados="+estados);
}


