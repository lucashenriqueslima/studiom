<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "update duplicatas_faturas SET link='$imagem' where id_item = '$id'");

echo"Boleto enviado com sucesso!!!";

?>