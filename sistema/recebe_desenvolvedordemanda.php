<?php

include"../includes/conexao.php";

$id = $_GET['id'];
$id_programador = $_POST['id_programador'];
$nomedesenvolvedor = $_POST['nomedesenvolvedor'];;

$sql = mysqli_query($con, "update suporte SET id_responsavel = '$id_programador', nomedesenvolvedor = '$nomedesenvolvedor' WHERE id = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";

?>