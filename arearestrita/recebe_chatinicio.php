<?php

session_start();



include"../includes/conexao.php";


$departamento = $_POST['departamento'];
$mensagem = $_POST['mensagem'];
$data = date('Y-m-d');
$hora = date('H:i:s');

$sql_chat = mysqli_query($con, "insert into chat (id_formando, id_departamento, data, horainicio, status) VALUES ('$_SESSION[id_formando]', '$departamento', '$data', '$hora', '1')");

$id_chat = $con->insert_id;

$sql_mensagem = mysqli_query($con, "insert into chat_mensagens (id_chat, tipo, id_usuario, data, hora, tipoenvio, mensagem) VALUES ('$id_chat', '2', '$_SESSION[id_formando]', '$data', '$hora', '1', '$mensagem')");

echo"<script language=\"JavaScript\">
location.href=\"chat.php?id_chat=$id_chat\";
</script>";

?>