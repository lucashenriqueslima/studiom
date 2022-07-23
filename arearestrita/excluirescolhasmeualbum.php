<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];

$sql = mysqli_query($con, "delete FROM meualbum_fotos_escolhidas where id_meualbum = '$id'");

$sql_update = mysqli_query($con, "update meu_album_paginas SET status = '0' where id_pagina = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"aprovaralbum.php?id=$id_escolha#Lamina-$id\";
</script>";

?>