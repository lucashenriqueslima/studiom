<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_formando = $_POST['id_formando'];
$id_item = $_POST['id_item'];
$datafinal = $_POST['datafinal'];
$descricao = $_POST['descricao'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "insert into meu_convite_turma (id_turma, data, datafinal, descricao, status, id_item) VALUES ('$id_turma', '$data', '$datafinal', '$descricao', '1', '$id_item')");

$id_gerado = $con->insert_id;

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

$sql_grava = mysqli_query($con, "insert into meu_convite_paginas_turma (id_meuconvite, npagina, status, legenda, imagem) VALUES ('$id_gerado', '$npagina', '1', '$legenda', '$imagem')");

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"afConvite_contrato.php\";
</script>";
 
?>