<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_arquivo = $_GET['id_arquivo'];
$comissao = $_POST['comissao'];

$sql = mysqli_query($con, "update arquivos_contratos SET comissao = '$comissao' where id_arquivo = '$id_arquivo'");

echo"<script language=\"JavaScript\">
	location.href=\"alterarturma.php?id=$id\";
	</script>";

?>