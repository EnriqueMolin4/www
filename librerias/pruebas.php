<?php 
include("enviomails.php");

$email = new envioEmail();

$body = "Se a creado tu cuenta para el Sistema Sinttecom SAS <br /> Tus datos de acceso son  <br/> Usuario :mpal67@gmail.com <br/>"; 
	$body .= "Contraseña: 123456 <br /> Acceso Sistema <a href='http://sinttecom.net'>Click Aqui</a>";
	$header = "Acceso Sistema Sinttecom SAS";

	$envio = $email->send($header,$body,'mpal67@gmail.com');
