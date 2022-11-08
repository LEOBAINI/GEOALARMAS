<?php 
 session_set_cookie_params(60*60*24*14);//haciendo que la sesion dure 14 dias

session_start();

// si no existe usuario, salir
if (!isset($_SESSION["usuario"])) {		
	
	header("Location: login.php");
		
	die();
}

 ?>