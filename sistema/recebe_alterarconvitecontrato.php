<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$datafinal = $_POST['datafinal'];
$id_item = $_POST['id_item'];
$descricao = $_POST['descricao'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "update meu_convite_turma SET datafinal='$datafinal', descricao='$descricao', id_item='$id_item' where id_meuconvite = '$id'");

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

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into meu_convite_paginas_turma (id_meuconvite, npagina, status, legenda, imagem) VALUES ('$id', '$npagina', '1', '$legenda', '$imagem')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"afConvite_contrato.php\";
</script>";
 
?>