<?php
$data = date("Y-m-d");
$hora = date("H:i:s");
include "../includes/conexao.php";
$login = $_POST['usuario'];
$senha = $_POST['senha'];
if ($login != null and $senha != null) {
	$vetor = mysqli_fetch_array(mysqli_query($con, "select * from formandos where email='$login' and status='1'"));
	$hash = $vetor['senha'];
	$verify = password_verify($senha,$hash);
	if (!$verify) {
        echo "<script>alert('Login ou senha errado(s)!!');top.location.href='index.php';</script>";
	}else {
		session_start();
		$_SESSION['id_formando'] = $vetor['id_formando'];
		$_SESSION['login_formando'] = $vetor['email'];
		$_SESSION['senha_formando'] = $vetor['cpf'];
		$_SESSION['comissao'] = $vetor['comissao'];
		echo "<script language=\"JavaScript\">
      location.href=\"index.php\";
      </script>";
	}
}else{
	header('Location: inicio.php');
}
?>