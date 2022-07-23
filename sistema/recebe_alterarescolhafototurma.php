<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$sql_delete = mysqli_query($con, "delete FROM turmas_escolha_formandos where id_turma_escolha = '$id'");

$id_turma = $_POST['id_turma'];
$id_evento = $_POST['id_evento'];
$qtd = $_POST['qtd'];

$sql_evento = mysqli_query($con, "select * from eventos_turma where id_evento = '$id_evento'");
$vetor_evento = mysqli_fetch_array($sql_evento);

$sql = mysqli_query($con, "update turmas_escolha SET id_turma='$id_turma', id_evento='$id_evento', id_tipo='$vetor_evento[id_categoria]', qtd='$qtd' where id_turma_escolha = '$id'");

$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$id_turma'");

while($vetor_formandos = mysqli_fetch_array($sql_formandos)) {

	$sql_grava = mysqli_query($con, "insert into turmas_escolha_formandos (id_turma, id_turma_escolha, id_formando, id_evento, id_tipo, qtd) VALUES ('$id_turma', '$id', '$vetor_formandos[id_formando]', '$id_evento', '$vetor_evento[id_categoria]', '$qtd')");

}

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_topfotos.php\";
</script>";

?>