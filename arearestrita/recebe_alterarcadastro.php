<?php

include"../includes/conexao.php";


session_start();

$id = $_SESSION['id_formando'];
$nome = ucwords(strtolower($_POST['nome']));
$sexo = $_POST['sexo'];
$estadocivil = $_POST['estadocivil'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$datanasc = $_POST['datanasc'];
$email = $_POST['email'];
$mostrarpai = 1;
$pai = $_POST['pai'];
$mae = $_POST['mae'];
$cep1 = $_POST['cep1'];
$endereco1 = $_POST['endereco1'];
$numero1 = $_POST['numero1'];
$complemento1 = $_POST['complemento1'];
$bairro1 = $_POST['bairro1'];
$cidade1 = $_POST['cidade1'];
$estado1 = $_POST['estado1'];
$celularpai = $_POST['celularpai'];
$celularmae = $_POST['celularmae'];
$telresidencial = $_POST['telresidencial'];
$telresidencial1 = $_POST['telresidencial1'];
$observacoes = $_POST['observacoes'];
$emailpai = $_POST['emailpai'];
$emailmae = $_POST['emailmae'];
$cep2 = $_POST['cep2'];
$endereco2 = $_POST['endereco2'];
$numero2 = $_POST['numero2'];
$complemento2 = $_POST['complemento2'];
$bairro2 = $_POST['bairro2'];
$cidade2 = $_POST['cidade2'];
$estado2 = $_POST['estado2'];
$nomeresponsavel = $_POST['nomeresponsavel'];
$telefoneresponsavel = $_POST['telefoneresponsavel'];
$tiporesponsavel = $_POST['tiporesponsavel'];
$facebook = (isset($_POST['facebook'])? $_POST['facebook']:null);
$instagram = $_POST['instagram'];
$inmemorianpai = $_POST['inmemorianpai'];
$inmemorianmae = $_POST['inmemorianmae'];


$sql = mysqli_query($con, "update formandos SET nome='$nome', sexo='$sexo',estadocivil='$estadocivil',
		datanasc='$datanasc', cep='$cep', endereco='$endereco', numero='$numero',
		complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', telefone='$telefone', celular='$celular',
		datanasc='$datanasc', email='$email', mostrarpai='$mostrarpai', pai='$pai', mae='$mae',
		cep1='$cep1', endereco1='$endereco1', numero1='$numero1', complemento1='$complemento1', bairro1='$bairro1', cidade1='$cidade1',
		estado1='$estado1', celularpai='$celularpai', celularmae='$celularmae', telresidencial='$telresidencial', telresidencial1='$telresidencial1',
		observacoes='$observacoes', emailpai='$emailpai', emailmae='$emailmae', cep2='$cep2', endereco2='$endereco2', numero2='$numero2',
		complemento2='$complemento2', bairro2='$bairro2', cidade2='$cidade2', estado2='$estado2', nomeresponsavel='$nomeresponsavel',
		telefoneresponsavel='$telefoneresponsavel', tiporesponsavel='$tiporesponsavel', facebook='$facebook', instagram='$instagram',
		inmemorianpai='$inmemorianpai',	inmemorianmae='$inmemorianmae' where id_formando = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"meucadastro.php\";
</script>";

?>
