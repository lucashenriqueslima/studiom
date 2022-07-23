<?php

include "../includes/conexao.php";

$id = $_GET['id'];
$id_turma_lead = $_GET['id_turma_lead'];

$arquivo = mysqli_fetch_array(mysqli_query($con, "select * from arquivos_oportunidade where id_arquivo='$id'"));
unlink('home/studioms/public_html/sistema/arquivos/' . $arquivo['arquivo']);
$res2 = mysqli_query($con, "delete FROM arquivos_oportunidade where id_arquivo = '$id'");

echo "<script> alert('Excluido com sucesso!')</script>";
echo "<script> window.location.href='alteraroportunidade.php?id=$id_turma_lead'</script>";

?>