<?php

session_start();



include"../includes/conexao.php";


$id_chat = $_POST['id_chat'];
$mensagem = $_POST['mensagem'];
$data = date('Y-m-d');
$hora = date('H:i:s');

$sql_mensagem = mysqli_query($con, "insert into chat_mensagens (id_chat, tipo, id_usuario, data, hora, tipoenvio, mensagem) VALUES ('$id_chat', '2', '$_SESSION[id_formando]', '$data', '$hora', '1', '$mensagem')");

?>