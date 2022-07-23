<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];
$nome = ucwords(strtolower($_POST['nome']));
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];
$link = $_POST['link'];
$comissao = $_POST['comissao'];
$cargo = $_POST['cargo'];

$sql_contato = mysqli_query($con, "update contatos_oportunidade SET nome='$nome', telefone='$telefone', email='$email', redesocial='$tipo', link='$link', comissao='$comissao', cargo='$cargo' where id_contato = '$id'");

echo"<script language=\"JavaScript\">
	location.href=\"alteraroportunidade.php?id=$id1\";
	</script>";

?>