<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_item = $_POST['id_item'];
$id_formando = $_POST['id_formando'];
$texto = $_POST['texto'];
$aproveitar = $_POST['aproveitar'];
$data = date('Y-m-d');

$sql_consulta = mysqli_query($con, "select * from meu_album where id_formando = '$id_formando'");


if($aproveitar == 2) {

$sql_turma = mysqli_query($con, "select * from produtos_exclusive where id_turma = '$id_turma' AND id_item='$id_item' order by id_produtoexclusive DESC");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql = mysqli_query($con, "insert into convite_exclusive (id_turma, id_formando, datafinal, texto, id_item, data, status) VALUES ('$id_turma', '$id_formando', '$vetor_turma[datafinal]', '$vetor_turma[texto]', '$id_item', '$data', '1')");

$id_gerado = $con->insert_id;

$sql_itens = mysqli_query($con, "select * from produtos_exclusive_itens where id_produtoexclusive = '$vetor_turma[id_produtoexclusive]' order by npagina ASC");

while($vetor_itens = mysqli_fetch_array($sql_itens)) {

	$sql_grava_itens = mysqli_query($con, "insert into convite_exclusive_itens (id_exclusive, npagina, imagem, status, tipo, bloqueio, qtdfotos) VALUES ('$id_gerado', '$vetor_itens[npagina]', '$vetor_itens[imagem]', '1', '$vetor_itens[tipo]', '$vetor_itens[bloqueio]', '$vetor_itens[qtdfotos]')");

}

} else {

$sql = mysqli_query($con, "insert into convite_exclusive (id_turma, id_formando, id_item, data, status) VALUES ('$id_turma', '$id_formando', '$id_item', '$data', '1')");

$id_gerado = $con->insert_id;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarexclusive.php?id=$id_gerado\";
</script>";
 
?>