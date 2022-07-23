<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$diretorio = "../sistema/arquivos/chat/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$data = date('Y-m-d');
$hora = date('H:i:s');

$sql_mensagem = mysqli_query($con, "insert into chat_mensagens (id_chat, tipo, id_usuario, data, hora, tipoenvio, mensagem, ext) VALUES ('$id', '2', '$_SESSION[id_formando]', '$data', '$hora', '2', '$imagem', '$ext')");

echo"<script language=\"JavaScript\">
location.href=\"chat.php?id=$id\";
</script>";

?>