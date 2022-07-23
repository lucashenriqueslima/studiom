<?php
	
	$host = 'localhost';
	$user = 'sistemst_sistema';
	$pass = 'Bm152612*';
	$db   = 'sistemst_sistema';
	 
	// conex�o e sele��o do banco de dados
	$con = mysqli_connect($host, $user, $pass, $db);
	
	mysqli_set_charset($con,"utf8");

?>
