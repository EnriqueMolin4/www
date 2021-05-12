$(document).ready(function(){
	document.getElementById("no-pagina-comercio").value = 1;
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
			var arr = JSON.parse(res);
			var pag = Math.round(arr.length / 8);
			var pag_totales = pag.toFixed(0);
			document.getElementById("pag-totales").value = pag_totales;
			var out = "<table class='table-view'>";
			out += "<tr>" +
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
				"<tr><td><input onclick='info_comercio(this.value,this)' afiliacion='"+arr[i].afiliacion+"' type='button' class='boton' value='"+arr[i].cve_banco+"'></td><td>" +
				arr[i].comercio +
				"</td><td>" +
				arr[i].afiliacion +
				"</td><td>" +
				arr[i].responsable +
				"</td><td>" +
				arr[i].tipo_comercio +
				"</td><td>" +
				arr[i].territorial_banco +
				"</td><td>" +
				arr[i].territorial_sinttecom +
				"</td><td>" +
				arr[i].telefono +
				"</td></tr>";
			}
			out += "</table>";
			$("#vista-comercio").html(out);
		}
	},1000);
});