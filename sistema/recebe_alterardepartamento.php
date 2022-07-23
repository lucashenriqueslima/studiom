<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$corcalendario = $_POST['corcalendario'];
$pcp = $_POST['pcp'];
$posicao = $_POST['posicao'];
$telefone = $_POST['telefone'];

$sql = mysqli_query($con, "update departamentos SET nome='$nome', corcalendario='$corcalendario', pcp='$pcp', posicao='$posicao', telefone='$telefone' where id_departamento = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_departamentos.php\";
</script>";

?>