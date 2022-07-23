<?php

session_start();

include"../includes/conexao.php";


$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id_turma = $vetor_cadastro[turma];
$tipo = $_POST['tipo'];
$observacoes = $_POST['observacoes'];
$data = date('Y-m-d'); 
$datafinal = date('Y-m-d', strtotime("+15 days",strtotime($data)));

$sql = mysqli_query($con, "insert into artes (id_turma, tipo, observacoes, dataprecisa) VALUES ('$id_turma', '$tipo', '$observacoes', '$datafinal')");
$id_cadastro = $con->insert_id;
//CURL para fazer a inserção no PCP
$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
$data = array('id_turma' => $id_turma,'tipo_job'=> '99','id_trabalho' => $id_cadastro, 'tipo_calculo' => '47');

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
	location.href=\"listarartes.php\";
	</script>";

?>