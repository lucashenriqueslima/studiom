<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];

$sql = mysqli_query($con, "delete FROM convite_personal_escolhas where id_item = '$id'");

$sql_update = mysqli_query($con, "update convite_personal_itens SET status = '0' where id_item = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"dadosconvite.php\";
</script>";

?>