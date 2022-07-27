<?php
include "settings.php";

$username = $_POST["username"];
$password = $_POST["password"];
$usernameFromDB=settings::username;
$passwordFromDB=settings::password;


if ($username==$usernameFromDB && $password==$passwordFromDB) {
	session_start();
	$_SESSION["usuario"]=$username;
	header("Location: index.php");
} else {
	
	echo '<script language="javascript">
	alert("Error de autenticacion");
	window.location.href="index.php"</script>';
	

}

?>