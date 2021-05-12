
 function consulta_comercio(){
		setTimeout(function(){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
		   if (this.readyState == 4 && this.status == 200){
		   		json_print(this.responseText);
		    }
		}
	
 		xmlhttp.open("POST","modelos/consulta_comercio.php", true);
		xmlhttp.send();
	
		function json_print(res){
			$("#vista-comercio").html(res);
		}
	},1000);
}

$(document).ready(function(){

$("#sig-pag-comercio").click(function(){

	var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
		   if (this.readyState == 4 && this.status == 200){
		   		json_print(this.responseText);
		    }
		}
	
 		xmlhttp.open("POST","modelos/consulta_comercio.php", true);
		xmlhttp.send();
	
		var pagina = document.getElementById("no-pagina-comercio").value;
		pagina++;
		pagina > 1 ? no_pagina = 8 * pagina : no_pagina = 0;

		function json_print(res){
			var arr = JSON.parse(res);
			var pag = (arr / 8);
			var pag_totales = pag.toFixed(0);
			// document.getElementById("pag-totales").value = pag_totales;
			if(arr.length >= no_pagina){
				var out = "<table class='table-view'>";
			"<td>CVE BANCARIA</td>" +
			"<td>COMERCIO</td>" +
			"<td>AFILIACION</td>" +
			"<td>RESPONSABLE</td>" +
			"<td>TIPO COMERCIO </td>" +
			"<td>TERRITORIAL BANCO</td>" +
			"<td>TERRITORIAL SINTTECOM</td>" +
			"<td>TELEFONO</td>" +
			"</tr>";
			for(var i = 0; i <= 8; i++){
				out += 
				"<tr><td><input onclick='info_comercio(this.value,this.id,this.options[this.selectedIndex])' data-afiliacion='"+arr[i].afiliacion+"' width='100%' type='button' class='boton' value='"+arr[i].cve_banco+"'></td><td>" +
				arr[i].comercio +
				"</td><td>" +
				arr[i].afiliacion +
				"</td><td>" +
				arr[i].responsable +
				"</td><td>" +
				arr[i].tipo_comercio +
				"</td><td>" +
				arr[i].territoria_banco +
				"</td><td>" +
				arr[i].territoria_sinttecom +
				"</td><td>" +
				arr[i].telefono +
				"</td></tr>";
				}
				out += "</table>";
				$("#vista-comercio").html(out);
				document.getElementById("no-pagina-comercio").value = pagina;
			}
		}
});






$("#ant-pag-comercio").click(function(){

	var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
		   if (this.readyState == 4 && this.status == 200){
		   		json_print(this.responseText);
		    }
		}
 		xmlhttp.open("POST","modelos/consulta_comercio.php", true);
		xmlhttp.send();

			var pagina = document.getElementById("no-pagina-comercio").value;
			var arr = JSON.parse(res);
			var no_pagina = pagina * 8;

			pagina != 1 ? pagina-- : null;
			document.getElementById("no-pagina-comercio").value = pagina;
			
		function json_print(res){

			var arr = JSON.parse(res);
			var pag = (arr / 8);
			var pag_totales = pag.toFixed(0);
			// document.getElementById("pag-totales").value = pag_totales;
			if(arr.length >= no_pagina){
				var out = "<table class='table-view'>";
			"<td>CVE BANCARIA</td>" +
			"<td>COMERCIO</td>" +
			"<td>AFILIACION</td>" +
			"<td>RESPONSABLE</td>" +
			"<td>TIPO COMERCIO </td>" +
			"<td>TERRITORIAL BANCO</td>" +
			"<td>TERRITORIAL SINTTECOM</td>" +
			"<td>TELEFONO</td>" +
			"</tr>";
			for(var i = 0; i <= 8; i++){
				out += 
				"<tr><td><input onclick='info_comercio(this.value,this.id,this.options[this.selectedIndex])' data-afiliacion='"+arr[i].afiliacion+"' width='100%' type='button' class='boton' value='"+arr[i].cve_banco+"'></td><td>" +
				arr[i].comercio +
				"</td><td>" +
				arr[i].afiliacion +
				"</td><td>" +
				arr[i].responsable +
				"</td><td>" +
				arr[i].tipo_comercio +
				"</td><td>" +
				arr[i].territoria_banco +
				"</td><td>" +
				arr[i].territoria_sinttecom +
				"</td><td>" +
				arr[i].telefono +
				"</td></tr>";
				}
				out += "</table>";
				$("#vista-comercio").html(out);
				document.getElementById("no-pagina-comercio").value = pagina;
			}
		}

});

});