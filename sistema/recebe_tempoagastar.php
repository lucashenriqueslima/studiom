<?php

include"../includes/conexao.php";

$id = $_GET['id'];
$tempo = $_POST['tempo'];

$sql = mysqli_query($con, "update suporte SET tempo_estimado = '$tempo' WHERE id = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";