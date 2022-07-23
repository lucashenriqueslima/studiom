<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];
$ocorrencia = $_POST['ocorrencia'];
$statusint = $_POST['statusint'];
$negociacao = $_POST['negociacao'];
$categoria = $_POST['categoria'];
$status = $_POST['status'];
$data = date('Y-m-d');
$hora = date('H:i:s');

$sql = mysqli_query($con, "select * from interacao_oportunidade where id_interacao = '$id'");
$vetor = mysqli_fetch_array($sql);


$sql_interacao = mysqli_query($con, "update interacao_oportunidade SET data='$data', hora='$hora', ocorrencia='$ocorrencia', status='$statusint' where id_interacao = '$id'");

if(!empty($categoria)) { 

$sql_atualiza = mysqli_query($con, "update oportunidades SET categoria='$categoria', status='$status', id_interacao = '$id', ultimainteracao = '$data', statusinteracao = '$statusint', negociacao='$negociacao' where id_oportunidade = '$vetor[id_oportunidade]'");

} else {

$sql_atualiza = mysqli_query($con, "update oportunidades SET id_interacao = '$id', ultimainteracao = '$data', statusinteracao = '$statusint', negociacao='$negociacao' where id_oportunidade = '$vetor[id_oportunidade]'");

}


echo"<script language=\"JavaScript\">
location.href=\"comercial_oportunidades.php\";
</script>";

?>