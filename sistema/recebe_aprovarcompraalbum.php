<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_GET['id_turma'];

$sql = mysqli_query($con, "update duplicatas SET status = '2' where id_venda = '$id'");

$sql_venda = mysqli_query($con, "update vendas SET duplicata = '2' where id_venda = '$id'");

$sql_consulta = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$sql_consulta1 = mysqli_query($con, "select * from formandos where id_formando = '$vetor_consulta[id_formando]'");
$vetor_consulta1 = mysqli_fetch_array($sql_consulta1);

echo"<script language=\"JavaScript\">
location.href=\"recebe_buscagestaoalbuns_ret.php?id_turma=$vetor_consulta1[turma]\";
</script>";

?>