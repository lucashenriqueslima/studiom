<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$datafinal = $_POST['datafinal'];
$id_item = $_POST['id_item'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "update meu_convite SET datafinal='$datafinal', descricao='$descricao', id_item='$id_item', status='$status' where id_meuconvite = '$id'");

$x = $_POST['npagina'];

$i = 0;

$diretorio = "arquivos/";

foreach($x as $key) {

$nomeimagem = $_FILES['arquivo']['name'][$i];  
$tmp = $_FILES['arquivo']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);
$npagina = $_POST['npagina'][$i];
$legenda = $_POST['legenda'][$i];
$bloqueio = $_POST['bloqueio'][$i];

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into meu_convite_paginas (id_meuconvite, npagina, status, legenda, bloqueio, imagem) VALUES ('$id', '$npagina', '1', '$legenda', '$bloqueio', '$imagem')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"afConvite_formandos.php\";
</script>";
 
?>