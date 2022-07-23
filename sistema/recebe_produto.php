<?php
include "../includes/conexao.php";
$id_turma = $_POST['id_turma'];
$tipo = $_POST['tipo'];
$dataabertura = $_POST['dataabertura'];
$termino = $_POST['termino'];
$dataencerramento = $_POST['dataencerramento'];
$dataentrega = $_POST['dataentrega'];
$mesano = $_POST['mesano'];
$desconto = $_POST['desconto'];
$dataencerramentofinal = date('Y-m-d', strtotime('-30 days', strtotime($dataentrega)));
$mesinicio = $_POST['mesinicio'];

$sql = mysqli_query($con, "insert into produtos_turma (id_turma, tipo, dataabertura, termino, dataencerramento, dataentrega, mesano, desconto, mesinicio) VALUES ('$id_turma', '$tipo', '$dataabertura', '$termino', '$dataencerramentofinal', '$dataentrega', '$mesano', '$desconto', '$mesinicio')");
$id_cadastro = $con->insert_id;
echo "<script language=\"JavaScript\">
	location.href=\"alterarproduto.php?id=$id_cadastro\";
	</script>";
?>