<?php

include"includes/conexao.php";

$id = $_GET['id'];
$id_formando = $_GET['id_formando'];
$id_contrato = $_GET['id_contrato'];
$data = date('Y-m-d');
$ip = $_SERVER['REMOTE_ADDR'];

$sql_consulta = mysqli_query($con, "select * from contratos_aprovacao where id_turma = '$id' and id_formando = '$id_formando' and id_contrato = '$id_contrato'");

if(mysqli_num_rows($sql_consulta) == 0) {

	$sql_grava = mysqli_query($con, "insert into contratos_aprovacao (id_turma, id_formando, id_contrato, data, ip) VALUES ('$id', '$id_formando', '$id_contrato', '$data', '$ip')");

	$sql_consulta_contrato = mysqli_query($con, "select * from contratos_aprovacao where id_turma = '$id' and id_contrato = '$id_contrato'");
	$total = mysqli_num_rows($sql_consulta_contrato);

	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id'");
	$vetor = mysqli_fetch_array($sql_turma);

	if($vetor['qtdcomissao'] <= $total) { 

	$sql_atualiza = mysqli_query($con, "update contratos_convite SET status = '2' where id_contrato = '$id_contrato'");

	echo"<script language=\"JavaScript\">
	location.href=\"https://studiomfotografia.com.br/gerarcontratopasta.php?id=$id_contrato\";
	</script>";

	} else {

	echo"<script language=\"JavaScript\">
	location.href=\"https://studiomfotografia.com.br/areadacomissao/index.php\";
	</script>";

	}

} else {

echo"<script language=\"JavaScript\">
location.href=\"https://studiomfotografia.com.br/areadacomissao/index.php\";
</script>";

}

?>