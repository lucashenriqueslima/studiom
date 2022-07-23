<?php
$data = date("Y-m-d");
$hora = date("H:i:s");
include "../includes/conexao.php";
$login = $_GET['email'];
$senha = $_GET['senha'];
$res = mysqli_query($con, "SELECT * FROM formandos WHERE email='$login' and senha='$senha' and status = '1'");
$qregistro = mysqli_num_rows($res);
if ($qregistro == 0) {
	echo "<script>alert('erro usuario login e senha inválidos...')

      ;top.location.href='index.php';</script>";
	//echo "Login ou senha errado(s)!!";
}else {


	$array = mysqli_fetch_array($res);
	session_start();
	$_SESSION['id_formando'] = $array['id_formando'];
	$_SESSION['login_formando'] = $array['email'];
	$_SESSION['senha_formando'] = $array['cpf'];

	
	echo "<script>


	fetch('http://localhost/studiomfotografia/api/auth/login-formando?user=".$login."&passwd=".$senha."').then((response) => {
		response.json().then((data) => {
			localStorage.token_formando = data.token_formando
			localStorage.setItem('id_formando', '". $_SESSION['id_formando'] ."')
			location.href=\"../arearestrita/inicio.php\";
		});
		}).catch((err) => {
		console.error('Failed retrieving information', err);
		});

	</script>";	
}
?>