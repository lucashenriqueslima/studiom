<?php

include"../includes/conexao.php";


$id_departamento = $_POST['id_departamento'];
$servico = $_POST['servico'];
$tipocad = $_POST['tipocad'];
$assunto = $_POST['assunto'];
$pergunta = $_POST['pergunta'];
$resposta = $_POST['resposta'];

$sql = mysqli_query($con, "insert into faq (id_departamento, servico, tipocad, assunto, pergunta, resposta) VALUES ('$id_departamento', '$servico', '$tipocad', '$assunto', '$pergunta', '$resposta')");

echo"<script language=\"JavaScript\">
	location.href=\"listarfaq.php\";
	</script>";	

?>