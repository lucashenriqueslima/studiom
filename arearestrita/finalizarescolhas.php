<?php

include"../includes/conexao.php";
session_start();
$id_escolha = $_GET['id_escolha'];
$data = date('Y-m-d');

$sql_update = mysqli_query($con, "update escolha_fotos SET status = '4', dataaprovacao = '{$data}' where id_escolha = '{$id_escolha}'");

$formando = mysqli_fetch_array(mysqli_query($con,"select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
$vetor_meu_album = mysqli_fetch_array(mysqli_query($con,"select id_item from escolha_fotos where id_escolha = '{$id_escolha}'"));
$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_escolha) as qtd from escolha_fotos_itens where id_escolha = '{$id_escolha}' and bloqueio <> 2"));
$chave_metrica = (int)$vetor_meu_album['id_item'] + 20;
$metrica = mysqli_fetch_array(mysqli_query($con,"select * from pcp_metricas where chave_metrica = '{$chave_metrica}'"));
$tempo = (int)$qtd_paginas['qtd'] * (int)$metrica['tempo_estimado'] + 10;

//CURL para fazer a inserção no PCP
$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
$data = array('id_turma' => $formando['turma'], 'id_formando' => $_SESSION['id_formando'],'tempo' => $tempo, 'tipo_job' => '99', 'tipo_calculo' => $chave_metrica,'id_trabalho' => $id_escolha);

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
echo"<script language=\"JavaScript\">
location.href=\"consultaescolhafotos.php?id=$id_escolha\";
</script>";

?>