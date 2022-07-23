<?php
session_start();

include "../includes/conexao.php";
$responsavel = $_POST['responsavel'];
$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);
$titulo = ucwords(strtolower($_POST['titulo']));
$descricao = $_POST['descricao'];
$categoria = $_POST['departamento'];
$dataatual = date('Y-m-d');
$sql = mysqli_query($con, "insert into calendario (id_colaborador,departamento, departamentosolicitante, titulo, descricao, tipoatendimento,tarefa, datainclusao) VALUES ('$responsavel[0]','$categoria', '$vetor_cadastro[departamento]','$titulo', '$descricao', '1','1','$dataatual')");

echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=" . $categoria . "\";
</script>";
?>