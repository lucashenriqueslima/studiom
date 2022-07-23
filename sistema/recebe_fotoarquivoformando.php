<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$x = $_POST['id_tipo'];
$data = date('Y-m-d');

$i = 0;

foreach($x as $key) {

$id_tipo = $_POST['id_tipo'][$i];

$sql_consulta = mysqli_query($con, "select * from tipos_arquivos_formando where id_formando = '$id' and id_tipo = '$id_tipo'");

if(mysqli_num_rows($sql_consulta) == 0) {

$sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$id_tipo'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);

$sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'].' '.$vetor_tipo['nome'].' '.$data;

$pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

mkdir ("/home/studioms/public_html/sistema/arquivos/formandos/fotosconvite/$pasta", 0755 );

$sql_grava = mysqli_query($con, "insert into tipos_arquivos_formando (id_formando, id_tipo, pasta) VALUES ('$id', '$id_tipo', '$pasta')");

}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id\";
</script>";

?>