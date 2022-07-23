<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];
$link = $_POST['link'];
$comissao = $_POST['comissao'];
$cargo = $_POST['cargo'];

if(isset($_POST['prospeccao'])){
    $sql_contato = mysqli_query($con, "insert into contatos_mkt (id_prospeccao, nome, telefone, email, redesocial, link, comissao, cargo) VALUES ('$id', '$nome', '$telefone', '$email', '$tipo', '$link', '$comissao', '$cargo')");

    echo"<script language=\"JavaScript\">
	location.href=\"alterarprospeccao.php?id=$id\";
	</script>";
}elseif(isset($_POST['oportunidade'])){
    $sql_contato = mysqli_query($con, "insert into contatos_oportunidade (id_oportunidade, nome, telefone, email, redesocial, link, comissao, cargo) VALUES ('$id', '$nome', '$telefone', '$email', '$tipo', '$link', '$comissao', '$cargo')");

    echo"<script language=\"JavaScript\">
	location.href=\"alteraroportunidade.php?id=$id\";
	</script>";
}

?>