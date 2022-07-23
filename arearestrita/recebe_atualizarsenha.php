<?php

include"../includes/conexao.php";

     
session_start();

$password = $_POST['senha'];
$hash = password_hash($password,PASSWORD_DEFAULT);
$sql = mysqli_query($con, "update formandos SET senha = '$hash' where id_formando = '$_SESSION[id_formando]'");

echo "<script> window.location.href='alterarsenha.php'</script>";