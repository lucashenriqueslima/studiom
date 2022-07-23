<?php
session_start();
$data = date('Y-m-d');
include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];
$observacoes = $_POST['observacoes'];
$imagem = $_POST['bn'];

$sql_grava = mysqli_query($con, "insert into escolha_fotos_tratamento (id_evento, id_formando, foto, observacoes, tipo, data) VALUES ('{$id}', '{$_SESSION['id_formando']}', '{$imagem}', '{$observacoes}', '2', '{$data}')");

$total = mysqli_num_rows(mysqli_query($con,"select * from escolha_fotos_tratamento where id_formando = '{$_SESSION['id_formando']}' and id_evento = '{$id}'"));
$qtd = mysqli_fetch_array(mysqli_query($con, "select * from turmas_escolha_formandos where id_evento = '{$id}' and id_formando = '{$_SESSION['id_formando']}'"));
if($qtd['qtd'] == $total){
	$formando = mysqli_fetch_array(mysqli_query($con,"select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
	$metrica = mysqli_fetch_array(mysqli_query($con,"select * from pcp_metricas where chave_metrica = '3'"));
	$tempo = (int)$total * (int)$metrica['tempo_estimado'] + 10;
	
	//CURL para fazer a inserção no PCP
	$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
	$data = array('id_turma' => $formando['turma'], 'id_formando' => $_SESSION['id_formando'],'tempo' => $tempo, 'tipo_job' => '99', 'tipo_calculo' => 3,'id_trabalho' => $id);
	
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}

echo"<script language=\"JavaScript\">
location.href=\"escolhadefotosevento_formando.php?id=$id\";
</script>";

?>