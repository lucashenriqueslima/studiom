<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_convite = $_GET['id_convite'];

$sql = mysqli_query($con, "delete FROM convite_exclusive_escolhidas where id_exclusive = '$id'");

$sql_update = mysqli_query($con, "update convite_exclusive_itens SET status = '1' where id_item = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"conviteexclusive.php?id=$id_convite#Lamina-$id\";
</script>";

?>