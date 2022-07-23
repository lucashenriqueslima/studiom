<?php



include"../includes/conexao.php";
session_start();
$id_escolha = $_GET['id_escolha'];
$data = date('Y-m-d');

$sql_update = mysqli_query($con, "update convite_exclusive SET status = '4', dataaprovacao = '{$data}' where id_exclusive = '{$id_escolha}'");

$formando = mysqli_fetch_array(mysqli_query($con,"select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
$sql_metrica = mysqli_query($con,"select * from pcp_metricas where chave_metrica in (1,2) order by chave_metrica");
$metrica = mysqli_fetch_array($sql_metrica);
$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select sum(qtdfotos) as qtd from convite_exclusive_itens where id_exclusive = '{$id_escolha}' and tipo='1'"));
$tempo = (int)$qtd_paginas['qtd'] * (int)$metrica['tempo_estimado'];
$metrica = mysqli_fetch_array($sql_metrica);
$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select sum(qtdfotos) as qtd from convite_exclusive_itens where id_exclusive = '{$id_escolha}' and tipo='2'"));
$tempo += (int)$qtd_paginas['qtd'] * (int)$metrica['tempo_estimado'] + 10;

//CURL para fazer a inserção no PCP
$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
$data = array('id_turma' => $formando['turma'], 'id_formando' => $_SESSION['id_formando'],'tempo' => $tempo, 'tipo_job' => '99', 'tipo_calculo' => '2','id_trabalho' => $id_escolha);

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
location.href=\"listarconviteexclusive.php\";
</script>";

?>