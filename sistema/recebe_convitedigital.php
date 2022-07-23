<?php
include "../includes/conexao.php";
session_start();
if (isset($_GET['excluir'])) {
	$id = $_GET['excluir'];
	$formando = mysqli_fetch_array(mysqli_query($con, "select convite_digital from formandos where id_formando = '$id'"));
	$unlink = $SERVER_ROOT.'/sistema/arquivos/'.$formando['convite_digital'];
	@unlink($unlink);
	$sql = mysqli_query($con, "update formandos SET convite_digital=null where id_formando = '$id'");
	die();
}
if (isset($_POST['id_formando'])) {
	$id = $_POST['id_formando'];
	$formando = mysqli_fetch_array(mysqli_query($con, "select id_cadastro,nome,turma from formandos where id_formando = '$id'"));
	$turma = mysqli_fetch_array(mysqli_query($con, "select ncontrato from turmas where id_turma = '$formando[turma]'"));
	$pasta_turma = $turma['ncontrato'];
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}
	$pasta_formando = $pasta_turma.'-'.$formando['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando.'/';
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}
	$arquivo = $_FILES['arquivo']['name'];
	$tmp = $_FILES['arquivo']['tmp_name'];
	$ext = strrchr($arquivo, '.');
	$nomegrava = 'convite' . time().uniqid().$ext;
	$upload = $diretorio.$nomegrava;
	move_uploaded_file($tmp, $upload);
	$grava_pasta = "formandos/".$pasta_turma."/".$pasta_formando."/".$nomegrava;
	$sql = mysqli_query($con, "update formandos SET convite_digital='$grava_pasta' where id_formando = '$id'");
	echo $grava_pasta;
	die();
}
?>
