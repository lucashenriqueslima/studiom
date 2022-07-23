<?php

include "../includes/conexao.php";

$id = $_GET['id'];
$id1 = $_GET['id1'];
$arquivo = mysqli_fetch_array(mysqli_query($con, "select * from arquivos_mkt where id_arquivo='$id'"));
unlink('home/studioms/public_html/sistema/arquivos/'.$arquivo['arquivo']);
$delete = mysqli_query($con, "delete FROM arquivos_mkt where id_arquivo = '$id'");

echo "<script> alert('Excluido com sucesso!')</script>";
echo "<script> window.location.href='alterarprospeccao.php?id=$id1'</script>";

?>