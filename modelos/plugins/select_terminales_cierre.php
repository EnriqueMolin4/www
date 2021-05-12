<?php

include '../conexion.php';

!empty($_POST['terminal']) ? $terminal = strtolower($_POST['terminal']): $terminal = '';
!empty($_POST['tecnologia']) ? $tecnologia = strtolower($_POST['tecnologia']): $tecnologia = '';
echo $tecnologia;
// $out = '';

// if(!empty($terminal) and empty($tecnologia)){

// 	$con = $conexion->query("SELECT $terminal from `terminales`");

// 	if($terminal = 'verifone'){
// 		while($dato = mysqli_fetch_array($con)){
// 			if(!empty($dato[0])){
// 				$info = explode(":",$dato[0]);
// 				$out .= '<option value="'.$info[0].'">'.$info[0].'</option>';
// 			}
// 		}
// 	}
// 	if($terminal = 'ingenico'){
// 		while($dato = mysqli_fetch_array($con)){
// 			if(!empty($dato[0])){
// 				$out .= '<option value="'.$dato[0].'">'.$dato[0].'</option>';
// 			}
// 		}
// 	}
// 	if($terminal = 'hypercom'){
// 		while($dato = mysqli_fetch_array($con)){
// 			if(!empty($dato[0])){
// 				$out .= '<option value="'.$dato[0].'">'.$dato[0].'</option>';
// 			}
// 		}
// 	}
// 	if($terminal = 'generica'){
// 		while($dato = mysqli_fetch_array($con)){
// 			if(!empty($dato[0])){
// 				$out .= '<option value="'.$dato[0].'">'.$dato[0].'</option>';
// 			}
// 		}
// 	}
// }

// if(!empty($terminal) and !empty($tecnologia)){
// 	$info = explode(":",$tecnologia);
// 	$out .= '<option value="'.$info[1].'">'.$info[1].'</option>';
// }
// echo $out;
?>