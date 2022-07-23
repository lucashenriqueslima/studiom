<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$tipo = $_POST['tipo'];
$titulo = ucwords(strtolower($_POST['titulo']));

$sql = mysqli_query($con, "update tabela_tipos SET tipo='$tipo', titulo='$titulo' where id_tipo = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"comercial_itenstabelaconvite.php\";
</script>";

?>