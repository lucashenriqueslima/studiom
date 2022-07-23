<?php
$data = date("Y-m-d");
$hora = date("H:i:s");
include "../includes/conexao.php";
$login = $_POST['usuario'];
$senha = $_POST['senha'];
if ($login != null and $senha != null) {
	$vetor = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where usuario='$login'"));
	$hash = $vetor['senha'];
	$verify = password_verify($senha,$hash);
	if (!$verify) {
		echo "<script>alert('Login ou senha errado(s)!!');top.location.href='index.php';</script>";
	}else {
		session_start();
		$_SESSION['id'] = $vetor['id_usuario'];
		$_SESSION['login'] = $vetor['usuario'];
		$_SESSION['senha'] = $vetor['senha'];
		$_SESSION['imagem'] = $vetor['imagem'];
		$_SESSION['nome'] = $vetor['nome'];
		$_SESSION['departamento'] = $vetor['departamento'];
		echo "<script language=\"JavaScript\">
	      location.href=\"dashboard.php\";
	      </script>";
	}
}else{
	header('Location: index.php');
}
?>