<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];

$sql = mysqli_query($con, "delete FROM escolha_fotos_escolhidas where id_escolha = '$id'");

$sql_update = mysqli_query($con, "update escolha_fotos_itens SET status = '1' where id_item = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"escolhafotos.php?id=$id_escolha#Lamina-$id\";
</script>";

?>