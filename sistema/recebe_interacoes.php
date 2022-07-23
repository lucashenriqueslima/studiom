<?php
session_start();

include "../includes/conexao.php";
$id = $_GET['id'];
$dataatual = date('Y-m-d');
$horaatual = date('H:i:s');
$tipoocorrencia = $_POST['tipoocorrencia'];
$assuntos = $_POST['assunto'];
$responsavel = $_POST['responsavel'];
$ocorrenciatexto = addslashes($_POST['ocorrenciatexto']);
if (isset($_POST['tipo'])) {
	$tipo = $_POST['tipo'];
}else {
	$tipo = 1;
}
if (isset($_POST['departamento']) and $_POST['departamento'] != '') {
	$departamento = $_POST['departamento'];
}else {
	$departamento = 0;
}
$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '$tipoocorrencia'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);
$assunto = mysqli_fetch_array(mysqli_query($con, "select * from assuntos where id_assunto='$assuntos'"));

if (isset($_POST['oportunidade'])) {
	$sql_interacao = mysqli_query($con, "insert into interacao_oportunidade (id_usuario, id_oportunidade, data, hora, tipo, assunto, ocorrencia) VALUES ('$_SESSION[id]', '$id', '$dataatual', '$horaatual','$vetor_tipo[nome]','$assunto[nome]', '$ocorrenciatexto')");
	$id_interacao = $con->insert_id;
	$oportunidade = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_turma_lead='$id'"));
	$curso = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso='$oportunidade[id_curso]'"));
	$assunto = $curso['nome'].'/'.$curso['sigla'].'/'.$oportunidade['ano_conclusao'].'-'.$oportunidade['semestre'].' - '.$assunto['nome'];
}elseif (isset($_POST['prospeccao'])) {
	$sql_interacao = mysqli_query($con, "insert into interacao_mkt (id_usuario, id_prospeccao, data, hora, tipo, assunto, ocorrencia) VALUES ('$_SESSION[id]', '$id', '$dataatual', '$horaatual','$vetor_tipo[nome]','$assunto[nome]', '$ocorrenciatexto')");
	$id_interacao = $con->insert_id;
	$prospeccao = mysqli_fetch_array(mysqli_query($con, "select * from prospeccoes where id_prospeccao='$id'"));
	$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas_mkt where id_turma='$prospeccao[id_turma]'"));
	$curso = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso='$turma[id_curso]'"));
	$assunto = $curso['nome'].'/'.$curso['sigla'].'/'.$turma['conclusao'].'-'.$turma['semestre'].' - '. $assunto['nome'];
}else {
	$sql_interacoes = mysqli_query($con, "insert into interacao_contratos (id_usuario, id_cliente, data, hora, tipo, assunto, ocorrencia, departamento) VALUES ('$_SESSION[id]', '$id', '$dataatual', '$horaatual', '$vetor_tipo[nome]', '$assunto[nome]', '$ocorrenciatexto', '$departamento')") or die (mysqli_error($con));
	$contrato = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma='$id'"));
	$assunto = $contrato['ncontrato'] . ' - '.$assunto['nome'];
}
if ($tipo == 2) {
	$sql_calendario = mysqli_query($con, "insert into calendario (id_colaborador,tipo, departamento, titulo, descricao, tarefa,datainclusao) VALUES ('$responsavel','1', '$departamento', '$assunto', '$ocorrenciatexto', '1','$dataatual')");
}else {
	$sql_calendario = mysqli_query($con, "insert into calendario (tipo, departamento, titulo, descricao, tarefa,datainclusao) VALUES ('1', '$departamento', '$assunto', '$ocorrenciatexto', '0','$dataatual')");
}
if (isset($_POST['oportunidade'])) {
	echo "<script language=\"JavaScript\">
	location.href=\"alteraroportunidade.php?id=$id\";
	</script>";
}elseif (isset($_POST['prospeccao'])) {
	echo "<script language=\"JavaScript\">
	location.href=\"alterarprospeccao.php?id=$id\";
	</script>";
}else {
	echo "<script language=\"JavaScript\">
	location.href=\"alterarturma.php?id=$id#interacao#interacaocontrato\";
	</script>";
}
?>