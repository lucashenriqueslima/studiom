<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$corcalendario = $_POST['corcalendario'];
$pcp = $_POST['pcp'];
$posicao = $_POST['posicao'];
$telefone = $_POST['telefone'];
$sql = mysqli_query($con, "insert into departamentos (nome, corcalendario, pcp, posicao, telefone) VALUES ('$nome', '$corcalendario', '$pcp', '$posicao', '$telefone')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_departamentos.php\";
</script>";
?>