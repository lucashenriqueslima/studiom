<?php

include"../includes/conexao.php";

$id = $_GET['id'];
$tempo = $_POST['tempo'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "update suporte SET tempo_total = '$tempo', status = '2', data_entregue = '$data' WHERE id = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";