
function logueo(){
	var user = $("#user").val();
	var pass = $("#user").val();

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	   if (this.readyState == 4 && this.status == 200){
	        if( this.responseText == 'correct_pass'){
	        	alert(this.responseText);
	        		window.location.replace("index/index-html.php");
	        }
	    }
	}

	var form = "&user="+user+"&pass="+pass;

	xmlhttp.open("POST","/cuentas/validacion.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(form);
}