<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$viavel = $_POST['viavel'];
$id_instituicao = $_POST['id_instituicao'];
$sql_instituticao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$id_instituicao'");
$vetor_instituicao = mysqli_fetch_array($sql_instituticao);
$sigla = $vetor_instituicao['sigla'];
$ocorrencia = $_POST['ocorrencia'];
$ocorrencia = $_POST['ocorrencia'];
$vagas1 = $_POST['vagas1'];
$vagas2 = $_POST['vagas2'];
$atletica = $_POST['atletica'];
$atletica1 = $_POST['atletica1'];
$observacoes = $_POST['observacoes'];
$sql = mysqli_query($con, "insert into cursos (nome, viavel, id_instituicao, sigla, ocorrencia, vagas1, vagas2, atletica, atletica1, observacoes) VALUES ('$nome', '$viavel', '$id_instituicao', '$sigla', '$ocorrencia', '$vagas1', '$vagas2', '$atletica', '$atletica1', '$observacoes')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_cursos.php\";
</script>";
?>