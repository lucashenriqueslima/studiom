<?php

include"../includes/conexao.php";


$ncontrato = $_POST['ncontrato'];
$nhd = $_POST['nhd'];
$marca = $_POST['marca'];
$nserie = $_POST['nserie'];
$tamanho = $_POST['tamanho'];

$sql = mysqli_query($con, "insert into hds (ncontrato, nhd, marca, nserie, tamanho) VALUES ('$ncontrato', '$nhd', '$marca', '$nserie', '$tamanho')");

echo"<script language=\"JavaScript\">
location.href=\"projetos_hds.php\";
</script>";

?>