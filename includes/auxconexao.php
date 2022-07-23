<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'studioms_sistema';
$SERVER_ROOT = $_SERVER['DOCUMENT_ROOT'];
// conex�o e sele��o do banco de dados
$con = mysqli_connect($host, $user, $pass, $db);

mysqli_set_charset($con,"utf8");

?>
