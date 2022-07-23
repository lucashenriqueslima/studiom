<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$regiao = $_POST['regiao'];
$sigla = $_POST['sigla'];
$administracao = $_POST['administracao'];
$site = $_POST['site'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$distancia = $_POST['distancia'];

$sql = mysqli_query($con, "update instituicoes SET nome='$nome', estado='$estado', cidade='$cidade', regiao='$regiao', sigla='$sigla', administracao='$administracao', site='$site', telefone='$telefone', cep='$cep', endereco='$endereco', complemento='$complemento', bairro='$bairro', distancia='$distancia' where id_instituicao = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_instituicao.php\";
</script>";

?>