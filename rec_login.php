<?php
include "settings.php";

$username = $_POST["username"];
$password = $_POST["password"];
$usernameFromDB=settings::username;
$passwordFromDB=settings::password;


if ($username==$usernameFromDB && $password==$passwordFromDB) {
	session_set_cookie_params(60*60*24*14);//haciendo que la sesion dure 14 dias
    
	session_start();
	$_SESSION["usuario"]=$username;
	header("Location: index.php");
} else {
	
	echo '<script language="javascript">
	alert("Error de autenticacion");
	window.location.href="index.php"</script>';
	

}

?>