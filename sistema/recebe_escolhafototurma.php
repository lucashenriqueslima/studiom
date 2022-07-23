<?php

include"../includes/conexao.php";

$id_turma = $_POST['id_turma'];
$id_evento = $_POST['id_evento'];
$qtd = $_POST['qtd'];



$sql_evento = mysqli_query($con, "select * from eventos_turma where id_evento = '$id_evento'");
$vetor_evento = mysqli_fetch_array($sql_evento);

$sql = mysqli_query($con, "insert into turmas_escolha (id_turma, id_evento, id_tipo, qtd, id_evento_turma_lista) VALUES ('$id_turma', '$id_evento', '$vetor_evento[id_categoria]', '$qtd', '$vetor_evento[id_eventos_turma_lista]')");
$id_gerado = $con->insert_id;


$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$id_turma'");

while($vetor_formandos = mysqli_fetch_array($sql_formandos)) {

	$sql_consulta = mysqli_query($con, "update eventosformando SET id_tipo = '$vetor_evento[id_categoria]', id_evento_turma = '$vetor_evento[id_evento]' where id_formando = '$vetor_formandos[id_formando]' and titulo = '$vetor_evento[titulo]'");
	
	$sql_grava = mysqli_query($con, "insert into turmas_escolha_formandos (id_turma, id_turma_escolha, id_formando, id_evento, id_tipo, qtd, id_eventos_turma_lista) VALUES ('$id_turma', '$id_gerado', '$vetor_formandos[id_formando]', '$id_evento', '$vetor_evento[id_categoria]', '$qtd', '$vetor_evento[id_eventos_turma_lista]')");
	
 
}

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_topfotos.php\";
</script>";

?>