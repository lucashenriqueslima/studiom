<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$dataatual = date('Y-m-d');
$horaatual = date('H:i:s');
$tipoocorrencia = $_POST['tipoocorrencia'];
$assunto = $_POST['assunto'];
$ocorrenciatexto = $_POST['ocorrenciatexto'];
$tipo = $_POST['tipo'];
$departamento = $_POST['departamento'];
if($departamento == null || $departamento == ''){
	$departamento = 0;
}
$categoria = $_POST['categoria'];
$status = $_POST['status'];

$sql_interacoes = mysqli_query($con, "insert into interacao_fornecedor
(id_usuario, id_fornecedor, data, hora, tipo, assunto, categoria, status, ocorrencia, departamento) VALUES
('{$_SESSION['id']}', '{$id}', '{$dataatual}', '{$horaatual}', '{$tipoocorrencia}', '{$assunto}', '{$categoria}', '{$status}', '{$ocorrenciatexto}', '{$departamento}')");

$id_cadastro = $con->insert_id;
	echo"<script language=\"JavaScript\">
	location.href=\"alterarfornecedor.php?id=$id\";
	</script>";

?>