<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_formando = $_GET['id_formando'];
$descricao = $_POST['descricao'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "insert into minhas_aprovacoes (id_item, id_formando, descricao, data, status) VALUES ('$id', '$id_formando', '$descricao', '$data', '1')");

$id_gerado = $con->insert_id;

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

$sql_grava = mysqli_query($con, "insert into minhas_aprovacoes_paginas (id_minhaaprovacao, npagina, imagem) VALUES ('$id_gerado', '$npagina', '$imagem')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id_formando\";
</script>";
 
?>