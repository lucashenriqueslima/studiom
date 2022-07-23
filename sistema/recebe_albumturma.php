<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_item = $_POST['id_item'];
$descricao = $_POST['descricao'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "insert into meu_album_turma (id_turma, id_item, data, descricao) VALUES ('{$id_turma}', '{$id_item}', '{$data}', '{$descricao}')");

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
$bloqueio = $_POST['bloqueio'][$i];

$sql_grava = mysqli_query($con, "insert into meu_album_paginas_turma (id_meualbum, npagina, bloqueio, imagem) VALUES ('{$id_gerado}', '{$npagina}', '{$bloqueio}', '{$imagem}')");

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_albumturma.php\";
</script>";
 
?>