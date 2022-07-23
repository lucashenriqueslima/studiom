<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$descricao = $_POST['descricao'];

$sql = mysqli_query($con, "update minhas_aprovacoes SET descricao='$descricao' where id_minhaaprovacao = '$id'");

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

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into minhas_aprovacoes_paginas (id_minhaaprovacao, npagina, imagem) VALUES ('$id', '$npagina', '$imagem')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alteraraprovacaoformando.php?id=$id\";
</script>";
 
?>