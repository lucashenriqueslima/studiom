<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];

$sql = mysqli_query($con, "delete FROM meu_album_fotos_escolhidas where id_meualbum = '$id'");

$sql_update = mysqli_query($con, "update meu_album_paginas SET status = NULL where id_item = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"aprovaralbum1.php?id=$id_escolha\";
</script>";

?>