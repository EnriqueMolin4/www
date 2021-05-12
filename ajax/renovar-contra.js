$(document).ready(function(){
	$("#renovar-contra-button").click(function(){

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		   if (this.readyState == 4 && this.status == 200){
		   		alert(this.responseText);
		    }
		}

		var user = $("#user-contra").val(),
		nueva_con = $("#actualizar-contra").val(),
		vieja_con =$("#vieja-contra").val(),
		correo = $("#correo-contra").val();

		form = "&user="+user+"&nueva="+nueva_con;
		form += "&vieja="+vieja_con+"&correo="+correo;
		
 		xmlhttp.open("POST","modelos/renueva_contra.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(form);

	});
});