<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$titulo = ucwords(strtolower($_POST['titulo']));

$data = date('Y-m-d');
$horaatual = date('H:i:s');
$tipo = $_POST['tipo'];
$diretorio = "arquivos/arquivos_prospeccao/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagemAux = time().uniqid(md5()).$ext;
$imagem = 'arquivos_prospeccao/' . $imagemAux;
$upload = $diretorio.$imagemAux;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivos_mkt (id_prospeccao, id_usuario, titulo, data, hora, arquivo,produto) VALUES ('$id', '$_SESSION[id]', '$titulo', '$data', '$horaatual', '$imagem','$tipo')");

echo"<script language=\"JavaScript\">
location.href=\"alterarprospeccao.php?id=$id\";
</script>";

?>