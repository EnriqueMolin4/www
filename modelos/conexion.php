<?php

//$conexion = new mysqli('localhost','admin_ramsses','Sinttecom1!','admin_sinttecom');
$conexion = new mysqli('localhost','root','','sinttecomv3');

if ($conexion->connect_error) {
    die("La conexion fallo: " . $conexion->connect_error);
} 

date_default_timezone_set('America/Mexico_City');

if (!$conexion->set_charset("utf8")) {
	printf("Conjunto de caracteres actual: %s\n", $conexion->character_set_name());
    exit();
}

foreach($_POST as $key => $val){
	$_POST[$key] = $conexion->real_escape_string($_POST[$key]);
}

// function acentos($cadena){
//     $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
//     $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
//     $cadena = utf8_decode($cadena);
//     $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
//     $cadena = strtoupper($cadena);
//     return utf8_encode($cadena);
// }

// function esc_char($str){
//     $char = '!#$%&/() =?¡¨*[];:_-.,}{+´"¿?¡|\¬``´´°';
//     $char .= "'";
//     $cierto = 0;

//     for($i = 0; $i <= strlen($char)-1; $i++){
//         $existe = strpos($str, $char[$i]);
//         if($existe){
//             $cierto++;
//         }
//     } 
//     return $cierto;
// }
?>
