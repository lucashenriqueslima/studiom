<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_departamento = $_POST['id_departamento'];
$servico = $_POST['servico'];
$tipocad = $_POST['tipocad'];
$assunto = $_POST['assunto'];
$pergunta = $_POST['pergunta'];
$resposta = $_POST['resposta'];

$sql = mysqli_query($con, "update faq SET id_departamento='$id_departamento', servico='$servico', tipocad='$tipocad', assunto='$assunto', pergunta='$pergunta', resposta='$resposta' where id_faq = '$id'");

echo"<script language=\"JavaScript\">
	location.href=\"listarfaq.php\";
	</script>";	

?>