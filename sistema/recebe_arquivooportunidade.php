<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma_lead = $_GET['id_turma_lead'];

$titulo = ucwords(strtolower($_POST['titulo']));
$data = date('Y-m-d');
$horaatual = date('H:i:s');
$diretorio = "arquivos/oportunidades/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
$imagem = 'oportunidades/'. $imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivos_oportunidade (id_lead, id_usuario,titulo, data, hora, arquivo) VALUES ('$id', '$_SESSION[id]', '$titulo', '$data', '$horaatual', '$imagem')");

echo"<script language=\"JavaScript\">
location.href=\"alteraroportunidade.php?id=$id_turma_lead\";
</script>";

?>