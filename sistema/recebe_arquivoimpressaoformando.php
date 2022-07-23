<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$data = date('Y-m-d');
$horaatual = date('H:i:s');
$tipo = $_POST['tipo'];
$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivoimpressao_formando (id_formando, arquivo) VALUES ('$id', '$imagem')");

echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id\";
</script>";

?>