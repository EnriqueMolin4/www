<?php

session_start();

if(empty($_SESSION)){
	include 'html/login_html.php';
}
else{
	include 'html/index_html.php';
}

?>