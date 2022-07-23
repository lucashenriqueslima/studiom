<?php

include"../includes/conexao.php";

if(isset($_GET['id'])){
    $titulo = ucwords(strtolower($_POST['titulo']));
	$id = $_GET['id'];
	$sql = mysqli_query($con, "update jobs SET titulo='{$titulo}' where id_job = '{$id}'");
}elseif(isset($_POST['titulo'])){
    $titulo = ucwords(strtolower($_POST['titulo']));
	$sql = mysqli_query($con, "insert into jobs (titulo,tipo_calculo,status) VALUES ('{$titulo}','0','1')");
	$id = $con->insert_id;
}
if(isset($_GET['remover_job'])){
    $remover = $_GET['remover_job'];
    mysqli_query($con, "update jobs set status = '0' where id_job = '{$remover}'");
}
if(isset($_GET['ativar'])){
    $ativar = $_GET['ativar'];
    mysqli_query($con, "update jobs set status = '1' where id_job = '{$ativar}'");
}
if(isset($_GET['remover'])){
	$remover = $_GET['remover'];
	$vetor = mysqli_fetch_array(mysqli_query($con,"select * from jobs_etapas where id_job_etapa = {$remover}"));
	mysqli_query($con, "update jobs_etapas set status = '0' where id_job_etapa = '{$remover}'");
    echo"<script language=\"JavaScript\">
location.href=\"alterartipojob.php?id={$vetor['id_job']}\";
</script>";
}
if(isset($_POST['etapa'])){
	$x = $_POST['etapa'];
	$i = 0;
	foreach ($x as $dado){
		$id_etapa = $_POST['etapa'][$i];
		$departamento = $_POST['departamento'][$i];
		$prazo_geral = $_POST['prazo_geral'][$i];
		$tempo_estimado = (int)$_POST['tempo_estimado'][$i];
		$etapa_pcp = $_POST['etapa_pcp'][$i];
		if($id_etapa == ''){
			$sql = mysqli_query($con,"insert into jobs_etapas (id_job,etapa,id_departamento,prazo_geral,tempo_estimado,status)VALUES('{$id}','{$etapa_pcp}','{$departamento}','{$prazo_geral}','{$tempo_estimado}','1')");
		}else{
			$sql = mysqli_query($con,"update jobs_etapas set etapa='{$etapa_pcp}',id_departamento = '{$departamento}',tempo_estimado='{$tempo_estimado}',prazo_geral='{$prazo_geral}' where id_job_etapa='{$id_etapa}'");
		}
		$i++;
	}
}
echo"<script language=\"JavaScript\">
location.href=\"pcp_cadastros.php\";
</script>";

?>