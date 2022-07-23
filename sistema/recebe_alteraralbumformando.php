<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$id_item = $_POST['id_item'];
$datafinal = $_POST['datafinal'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];
$preenchimento = $_POST['preenchimento'];

$sql = mysqli_query($con, "update meu_album SET id_item='$id_item', datafinal='$datafinal', descricao='$descricao', status='$status' where id_meualbum = '$id'");

$x = $_POST['npagina'];

$i = 0;

$diretorio = "arquivos/turmas/";


foreach($x as $key) {

$nomeimagem = $_FILES['arquivo']['name'][$i];  
$tmp = $_FILES['arquivo']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);
$npagina = $_POST['npagina'][$i];
$bloqueio = $_POST['bloqueio'][$i];

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into meu_album_paginas (id_meualbum, npagina, status, bloqueio, imagem) VALUES ('$id', '$npagina', '0', '$bloqueio', '$imagem')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alteraralbumformando.php?id=$id\";
</script>";
 
?>