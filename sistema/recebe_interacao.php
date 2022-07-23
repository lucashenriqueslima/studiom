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

$sql_interacoes = mysqli_query($con, "insert into interacao (id_usuario, id_cliente, data, hora, tipo, assunto, categoria, status, ocorrencia, departamento) VALUES ('$_SESSION[id]', '$id', '$dataatual', '$horaatual', '$tipoocorrencia', '$assunto', '$categoria', '$status', '$ocorrenciatexto', '$departamento')");

$id_cadastro = $con->insert_id;

$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '$tipoocorrencia'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);

$sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('2', '$id_cadastro', '$departamento', '$vetor_tipo[nome]', '$ocorrenciatexto', '$dataagenda')");

$sql_usuario = mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'");
$vetor_usuario = mysqli_fetch_array($sql_usuario);

if($tipo == 2) {

	$sql_crm = mysqli_query($con, "insert into oportunidades (tipo, id_turma, id_formando, responsavel, categoria, status, descricao, data) VALUES ('2', '$turma', '$id', '$vetor_usuario[nome]', '$categoria', '$status', 'Interação com o Formando', '$dataatual')");
	$idimp11 = $con->insert_id;

	$sql_interacao = mysqli_query($con, "insert into interacao_oportunidade (id_usuario, id_oportunidade, data, hora, ocorrencia, status) VALUES ('$_SESSION[id]', '$idimp11', '$dataatual', '$horaatual', '$ocorrenciatexto', '1')");
	$id_interacao = $con->insert_id;

	$sql_atualiza = mysqli_query($con, "update oportunidades SET id_interacao = '$id_interacao', ultimainteracao = '$data' where id_oportunidade = '$idimp11'");

	$sql_mov = mysqli_query($con, "insert into mov_crm_formando (id_formando, id_oportunidade, data, categoria, sub, status) VALUES ('$id', '$idimp11', '$dataatual', '$categoria', '$status', '1')");

	echo"<script language=\"JavaScript\">
	location.href=\"alteraroportunidade.php?id=$idimp11\";
	</script>";

} else { 

	echo"<script language=\"JavaScript\">
	location.href=\"alterarformando.php?id=$id\";
	</script>";

}

?>