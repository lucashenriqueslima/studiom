<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$datafinal = $_POST['datafinal'];
$texto = $_POST['texto'];
$id_item = $_POST['id_item'];
$datafinal = $_POST['datafinal'];
$descricao = $_POST['descricao'];

$sql = mysqli_query($con, "update produtos_exclusive SET id_item='$id_item', datafinal='$datafinal', texto='$texto' where id_produtoexclusive = '$id'");

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
$tipo = $_POST['tipo'][$i];
$bloqueio = $_POST['bloqueio'][$i];
$qtdfotos = $_POST['qtdfotos'][$i];

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into produtos_exclusive_itens (id_produtoexclusive, npagina, imagem, status, tipo, bloqueio, qtdfotos) VALUES ('$id', '$npagina', '$imagem', '1', '$tipo', '$bloqueio', '$qtdfotos')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarprodutoexclusive.php?id=$id\";
</script>";
 
?>