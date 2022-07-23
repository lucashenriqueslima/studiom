<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$titulo = ucwords(strtolower($_POST['titulo']));

$sql_grava = mysqli_query($con, "update preeventos SET id_turma='$id_turma', titulo='$titulo' where id_pre = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_preeventos.php\";
</script>";

?>