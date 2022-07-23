<?php
include "../includes/conexao.php";
$id_curso = $_POST['id_curso'];
$conclusao = $_POST['conclusao'];
$semestre = $_POST['semestre'];
$sql = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$conclusao', '$semestre')");
$id_gerado = $con->insert_id;
$x = $_POST['tipo'];
$i = 0;
foreach ($x as $key) {
	$tipo = $_POST['tipo'][$i];
	$link = $_POST['link'][$i];
	$sql_rede = mysqli_query($con, "insert into redessociais_turmas (id_turma, tipo, link) VALUES ('$id_gerado', '$tipo', '$link')");
	$i++;
}
echo "<script language=\"JavaScript\">
location.href=\"cadastros_turmasmkt.php\";
</script>";
?>