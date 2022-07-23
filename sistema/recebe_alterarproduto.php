<?php

include"../includes/conexao.php";

$id = $_GET['id'];
if(isset($_GET['remover'])){
	$id_tipo = $_GET['tipo'];
	$id_pacote = $_GET['id_p'];
	$res_ref = mysqli_query($con, "UPDATE pacotes_itens SET status = '0' WHERE id_tipo='{$id_tipo}' and id_pacote='{$id_pacote}'");
}else{
	$id_turma = $_POST['id_turma'];
	$tipo = $_POST['tipo'];
	$dataabertura = $_POST['dataabertura'];
	$termino = $_POST['termino'];
	$dataencerramento = $_POST['dataencerramento'];
	$dataentrega = $_POST['dataentrega'];
	$mesano = $_POST['mesano'];
	$desconto = $_POST['desconto'];
	$mesinicio = $_POST['mesinicio'];

	$dataencerramentofinal = date('Y-m-d', strtotime('-30 days', strtotime($dataentrega)));
	
	$sql = mysqli_query($con, "update produtos_turma SET id_turma='{$id_turma}', tipo='{$tipo}', dataabertura='{$dataabertura}', termino='{$termino}', dataencerramento='{$dataencerramentofinal}', dataentrega='{$dataentrega}', mesano='{$mesano}', desconto='{$desconto}', mesinicio='{$mesinicio}' where id_produto = '{$id}'");
}
echo"<script language=\"JavaScript\">
	location.href=\"alterarproduto.php?id=$id\";
	</script>";

?>