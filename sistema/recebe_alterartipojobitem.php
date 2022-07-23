<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];

$id_departamento = $_POST['id_departamento'];
$qtddia = $_POST['qtddia'];
$posicao = $_POST['posicao'];
$cor = $_POST['cor'];

$sql_grava = mysqli_query($con, "update jobs_departamentos SET id_departamento='$id_departamento', qtddia='$qtddia', posicao='$posicao', cor='$cor' where id_job_dep = '$id'");


echo"<script language=\"JavaScript\">
location.href=\"alterartipojob.php?id=$id1\";
</script>";

?>