<?php
session_start();
include "../includes/conexao.php";
$data = date('Y-m-d');
$id = $_GET['id'];
$x = $_POST['imagem'];
$i = 0;
foreach ($x as $keyy) {
	$imagem = $_POST['imagem'][$i];
	$sql_grava = mysqli_query($con, "insert into escolha_fotos_tratamento (id_evento, id_formando, foto, tipo, data) VALUES ('{$id}', '{$_SESSION['id_formando']}', '{$imagem}', '1', '{$data}')");
	$i++;
}
$formando = mysqli_fetch_array(mysqli_query($con,"select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_escolha) as qtd from escolha_fotos_tratamento where id_formando = '{$_SESSION['id_formando']}'"));
$metrica = mysqli_fetch_array(mysqli_query($con,"select * from pcp_metricas where chave_metrica = '3'"));
$tempo = (int)$qtd_paginas['qtd'] * (int)$metrica['tempo_estimado'] + 10;

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

echo "<script language=\"JavaScript\">
location.href=\"escolhadefotospreevento.php\";
</script>";
?>