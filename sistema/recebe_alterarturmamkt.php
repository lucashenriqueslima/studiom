<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_curso = $_POST['id_curso'];
$conclusao = $_POST['conclusao'];

$sql = mysqli_query($con, "update turmas_mkt SET id_curso='$id_curso', conclusao='$conclusao' where id_turma = '$id'");

$x = $_POST['tipo'];

$i = 0;

foreach($x as $key) {

	$tipo = $_POST['tipo'][$i];
	$link = $_POST['link'][$i];

	$sql_consulta = mysqli_query($con, "select * from redessociais_turmas where id_turma = '$id' and tipo = '$tipo'");

	if(!empty($tipo)) {

	$sql_rede = mysqli_query($con, "insert into redessociais_turmas (id_turma, tipo, link) VALUES ('$id', '$tipo', '$link')");

	}

	$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"cadastros_turmasmkt.php\";
</script>";

?>