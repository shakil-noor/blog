<?php 
	session_start();
	$_SESSION["user_id"]= null;
	session_destroy();
	header("Location: login.php");
?>