<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];

$sql = mysqli_query($con, "delete FROM meuconvite_fotos_escolhidas where id_meuconvite = '$id'");

$sql_update = mysqli_query($con, "update meu_convite_paginas SET status = '1' where id_pagina = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"aprovarconvite.php?id=$id_escolha#Lamina-$id\";
</script>";

?>