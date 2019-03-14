<?php 
	session_start();
	unset($_SESSION['logged_user']);
	unset($_SESSION['wrong_sign']);
	

	header("Location:../index.php");
	exit;
 ?>