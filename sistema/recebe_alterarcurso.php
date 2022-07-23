<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$viavel = $_POST['viavel'];
$id_instituicao = $_POST['id_instituicao'];
$sql_instituticao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$id_instituicao'");
$vetor_instituicao = mysqli_fetch_array($sql_instituticao);
$sigla = $vetor_instituicao['sigla'];
$ocorrencia = $_POST['ocorrencia'];
$vagas1 = $_POST['vagas1'];
$vagas2 = $_POST['vagas2'];
$atletica = $_POST['atletica'];
$atletica1 = $_POST['atletica1'];
$observacoes = $_POST['observacoes'];

$sql = mysqli_query($con, "update cursos SET nome='$nome', viavel='$viavel', id_instituicao='$id_instituicao', sigla='$sigla', ocorrencia='$ocorrencia', vagas1='$vagas1', vagas2='$vagas2', atletica='$atletica', atletica1='$atletica1', observacoes='$observacoes' where id_curso = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_cursos.php\";
</script>";

?>