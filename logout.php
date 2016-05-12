<?php 
	
	session_start(); 
	
	$_SESSION["isLogged"] = false;
	$_SESSION["user"] = NULL;
	$_SESSION["customer"] = NULL;
	$_SESSION["role"] = NULL;
	$_SESSION['cart'] = NULL;
	
	header('Location: index.php');
?>
	