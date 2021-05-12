// $(document).ready(function(){
// 		var xmlhttp = new XMLHttpRequest();
// 		xmlhttp.onreadystatechange=function() {
// 		   if (this.readyState == 4 && this.status == 200){

// 				var arr = JSON.parse(this.responseText);

// 				for(var i = 0; i <= arr.length; i++){
// 					if(arr[i] == 'amarillo'){
// 						$("#fecha-cierre"+i+"").css({"background":"#ffff66"});
// 					}
// 					if(arr[i] == 'verde'){
// 						$("#fecha-cierre"+i+"").css({"background":"#00cc00"});
// 					}
// 					if(arr[i] == 'rojo'){
// 						$("#fecha-cierre"+i+"").css({"background":"#ae2b2b"});
// 					}
// 					if(arr[i] == 'vencido'){
// 						$("#fecha-cierre"+i+"").css({"background":"#000","color":"#fff"});
// 					}
// 				}
// 		    }
// 		}

// 	xmlhttp.open("POST","/sinttecom/modelos/vencimiento.php", true);
// 	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 	xmlhttp.send();
// });

function vencimineto(){
	// var xmlhttp = new XMLHttpRequest();
	// 	xmlhttp.onreadystatechange=function() {
	// 	   if (this.readyState == 4 && this.status == 200){

	// 			var arr = JSON.parse(this.responseText);

	// 			for(var i = 0; i <= arr.length; i++){
	// 				if(arr[i] == '2'){
	// 					$("#fecha-cierre"+i+"").css({"background":"#ffff66"});
	// 				}
	// 				if(arr[i] == '3'){
	// 					$("#fecha-cierre"+i+"").css({"background":"#00cc00"});
	// 				}
	// 				if(arr[i] == '1'){
	// 					$("#fecha-cierre"+i+"").css({"background":"#ae2b2b"});
	// 				}
	// 				if(arr[i] == '0'){
	// 					$("#fecha-cierre"+i+"").css({"background":"#000","color":"#fff"});
	// 				}
	// 			}
	// 	    }
	// 	}

	// xmlhttp.open("POST","/sinttecom/modelos/vencimiento.php", true);
	// xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// xmlhttp.send();
}