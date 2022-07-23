<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$observacoes = $_POST['observacoes'];
$sql = mysqli_query($con, "insert into locais (nome, estado, cidade, cep, endereco, complemento, bairro, observacoes) VALUES ('$nome', '$estado', '$cidade', '$cep', '$endereco', '$complemento', '$bairro', '$observacoes')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_locaiseventos.php\";
</script>";
?>