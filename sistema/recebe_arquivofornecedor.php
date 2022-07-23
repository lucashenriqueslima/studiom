<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$titulo = ucwords(strtolower($_POST['titulo']));
$data = date('Y-m-d');
$horaatual = date('H:i:s');
$tipo = $_POST['tipo'];
$diretorio = $SERVER_ROOT.'/sistema/arquivos/';
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivos_fornecedor (id_fornecedor, id_usuario, titulo, data, hora, arquivo) VALUES ('$id', '$_SESSION[id]', '$titulo', '$data', '$horaatual', '$imagem')");

echo"<script language=\"JavaScript\">
location.href=\"alterarfornecedor.php?id=$id\";
</script>";

?>