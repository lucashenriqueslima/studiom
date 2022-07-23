<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_item = $_POST['id_item'];
$texto = $_POST['texto'];
$id_formando = $_POST['id_formando'];
$aproveitar = $_POST['aproveitar'];
$data = date('Y-m-d');

$sql_consulta = mysqli_query($con, "select * from meu_album where id_formando = '$id_formando'");


if($aproveitar == 2) {

	$sql_turma = mysqli_query($con, "select * from meu_album_turma where id_turma = '$id_turma' AND id_item='$id_item' order by id_meualbum DESC");
	$vetor_turma = mysqli_fetch_array($sql_turma);

	$sql_grava = mysqli_query($con, "insert into escolha_fotos (id_turma, id_formando, texto, id_item, data, status) VALUES ('$id_turma', '$id_formando', '$vetor_turma[descricao]', '$id_item', '$data', '1')");

	$id_gerado = $con->insert_id;

	$sql_itens = mysqli_query($con, "select * from meu_album_paginas_turma where id_meualbum = '$vetor_turma[id_meualbum]' order by npagina ASC");

	while($vetor_itens = mysqli_fetch_array($sql_itens)) {

		$sql_grava_itens = mysqli_query($con, "insert into escolha_fotos_itens (id_escolha, npagina, imagem, status, bloqueio) VALUES ('$id_gerado', '$vetor_itens[npagina]', '$vetor_itens[imagem]', '1', '$vetor_itens[bloqueio]')");

	}

} else {

	$sql_grava = mysqli_query($con, "insert into escolha_fotos (id_turma, id_formando, id_item, data, status) VALUES ('$id_turma', '$id_formando', '$id_item', '$data', '1')");

	$id_gerado = $con->insert_id;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarescolhafoto.php?id=$id_gerado\";
</script>";



?>