<?php

include"../includes/conexao.php";
session_start();
$id = $_GET['id'];
$data = date('Y-m-d');

$sql_aprovadoressalva = mysqli_query($con, "SELECT * FROM meu_album_paginas WHERE id_meualbum = '{$id}' and status = '2' and bloqueio <> '2'");
$total_aprovadoressalva = mysqli_num_rows($sql_aprovadoressalva);


if($total_aprovadoressalva > 0) {
	$sql_update = mysqli_query($con, "update meu_album SET status = '3', dataaprovacao = '{$data}' where id_meualbum = '{$id}'");
}else {
	$sql_update = mysqli_query($con, "update meu_album SET status = '4', dataaprovacao = '{$data}' where id_meualbum = '{$id}'");
}
    $formando = mysqli_fetch_array(mysqli_query($con,"select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
$vetor_meu_album = mysqli_fetch_array(mysqli_query($con,"select me.id_item from meu_album me where me.id_meualbum = '{$id}'"));
$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_meualbum) as qtd from meu_album_paginas where id_meualbum = '{$id}' and descricao <> ''"));
$metrica = mysqli_fetch_array(mysqli_query($con,"select * from pcp_metricas where chave_metrica = '{$vetor_meu_album['id_item']}'"));
$tempo = (int)$qtd_paginas['qtd'] * (int)$metrica['tempo_estimado'] + 10;

//CURL para fazer a inserção no PCP
$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
$data = array('id_turma' => $formando['turma'], 'id_formando' => $_SESSION['id_formando'],'tempo' => $tempo, 'tipo_job' => '99', 'tipo_calculo' => $vetor_meu_album['id_item'],'id_trabalho' => $id);

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
location.href=\"consultaprodutosfotografia.php?id=$id\";
</script>";

?>