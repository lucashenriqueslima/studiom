<?php

include"../includes/conexao.php";




$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];
$data = date('Y-m-d');
$statusexplode = explode("_", $_POST['status']);
$status = $statusexplode[0];
$observacoes = addslashes($_POST['observacoes']);
$x = $_POST['foto'];

$sql_update = mysqli_query($con, "update meu_album_paginas SET descricao = '$observacoes', status = '$status' where id_pagina = '$id'");

if($status == 2) {

$i = 0;

foreach($x as $key) {

	$foto = $_POST['foto'][$i];

	$sql_fotos = mysqli_query($con, "insert into meualbum_fotos_escolhidas (id_meualbum, foto) VALUES ('$id', '$foto')");

	$i++;

}

}

echo"<script language=\"JavaScript\">
location.href=\"aprovaralbum.php?id=$id_escolha#Lamina-$id\";
</script>";

?>