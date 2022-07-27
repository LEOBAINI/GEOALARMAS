<?php 
 set_time_limit(13000);
session_start();

// si no existe usuario, salir
if (!isset($_SESSION["usuario"])) {		
	
	header("Location: login.php");
		
	die();
}

 ?>