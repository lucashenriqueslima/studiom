<?php

session_start();



include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$tipo = $_POST['tipo'];
$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql = mysqli_query($con, "insert into arquivosdeconvites (id_turma, tipo, arquivo) VALUES ('$id_turma', '$tipo', '$imagem')");

echo"<script language=\"JavaScript\">
location.href=\"listararquivosdeconvites.php\";
</script>";

?>