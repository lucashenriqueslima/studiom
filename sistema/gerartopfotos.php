<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'];

if($vetor['topfotos'] == NULL) {

$pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

$sql_update_formando = mysqli_query($con, "update formandos SET topfotos = '$pasta' where id_formando = '$id'");

mkdir ("/home/studioms/public_html/sistema/arquivos/topfotos/$pasta", 0755 );

}

echo "<script> window.location.href='alterarformando.php?id=$id'</script>";
