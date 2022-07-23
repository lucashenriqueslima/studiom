<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$observacoes = $_POST['observacoes'];

$sql = mysqli_query($con, "update locais SET nome='$nome', estado='$estado', cidade='$cidade', cep='$cep', endereco='$endereco', complemento='$complemento', bairro='$bairro', observacoes='$observacoes' where id_local = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_locaiseventos.php\";
</script>";

?>