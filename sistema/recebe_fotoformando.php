<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$tipo = $_POST['tipo'];
if($tipo == 1) {

$titulo = ucwords(strtolower($_POST['titulo']));

}
if($tipo == 2) {

$titulo = $_POST['titulo1'];

}
$data = date('d-m-Y');

$sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'].' '.$titulo.$data;

$pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

mkdir ("/home/studioms/public_html/sistema/arquivos/formandos/$pasta", 0755 );

$sql_grava = mysqli_query($con, "insert into eventosformando (id_formando, tipo, titulo, pasta) VALUES ('$id', '$tipo', '$titulo', '$pasta')");

echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id\";
</script>";

?>