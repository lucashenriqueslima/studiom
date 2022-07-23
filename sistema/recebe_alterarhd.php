<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$ncontrato = $_POST['ncontrato'];
$nhd = $_POST['nhd'];
$marca = $_POST['marca'];
$nserie = $_POST['nserie'];
$tamanho = $_POST['tamanho'];

$sql = mysqli_query($con, "update hds SET ncontrato='$ncontrato', nhd='$nhd', marca='$marca', nserie='$nserie', tamanho='$tamanho' where id_hd = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"projetos_hds.php\";
</script>";

?>