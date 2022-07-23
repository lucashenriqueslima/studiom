<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$dataatual = date('Y-m-d');
$horaatual = date('H:i:s');
$tipoocorrencia = $_POST['tipoocorrencia'];
$assunto = $_POST['assunto'];
$ocorrenciatexto = addslashes($_POST['ocorrenciatexto']);
$dataagenda = $_POST['dataagenda'];
$tipo = $_POST['tipo'];
$departamento = $_POST['departamento'];
$categoria = $_POST['categoria'];
$status = $_POST['status'];
$turma = $_POST['turma'];

$sql_interacoes = mysqli_query($con, "insert into interacao_oportunidade (id_usuario, id_oportunidade, data, hora, tipo, assunto, categoria, status, ocorrencia, departamento) VALUES ('$_SESSION[id]', '$id', '$dataatual', '$horaatual', '$tipoocorrencia', '$assunto', '$categoria', '$status', '$ocorrenciatexto', '$departamento')");

$id_cadastro = $con->insert_id;

$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '$tipoocorrencia'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);

$sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('7', '$id_cadastro', '$departamento', '$vetor_tipo[nome]', '$ocorrenciatexto', '$dataagenda')");

	echo"<script language=\"JavaScript\">
	location.href=\"alteraroportunidade.php?id=$id\";
	</script>";

?>