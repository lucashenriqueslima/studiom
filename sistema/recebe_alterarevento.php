<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$solicitante = $_POST['solicitante'];

$id_evento_turma_lista = $_POST['id_categoria'];
$vetor_evento_turma_lista = mysqli_fetch_array(mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = $id_evento_turma_lista"));
$id_categoria = $vetor_evento_turma_lista['id_evento'];


$titulo = ucwords(strtolower($_POST['titulo']));
$id_local = $_POST['id_local'];
$data = $_POST['data'];
$horainicio = $_POST['horainicio'];
$horafim = $_POST['horafim'];
$qtdalunos = $_POST['qtdalunos'];
$qtdpessoas = $_POST['qtdpessoas'];
$responsavel = $_POST['responsavel'];
$telefone = $_POST['telefone'];
$nomeresponsavel = $_POST['nomeresponsavel'];
$telefoneresponsavel = $_POST['telefoneresponsavel'];
$tarefa = $_POST['tarefa'];
$departamento = $_POST['departamento'];
$observacoes = $_POST['observacoes'];

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$id_categoria'");
$vetor_categoria = mysqli_fetch_array($sql_categoria);

$sql_local = mysqli_query($con, "select * from locais where id_local = '$id_local'");
$vetor_local = mysqli_fetch_array($sql_local);

//$nome = $vetor_turma['ncontrato'].' / '.$vetor_local['cidade'].' - '.$vetor_local['estado'].' / '.$vetor_categoria['nome'].' - '.$titulo;
if ($id_categoria == 2) {
    $nome = $vetor_turma['ncontrato'] . ' / ' . $vetor_local['cidade'] . ' - ' . $vetor_local['estado'] . ' / ' . $vetor_local['nome'] . ' - ' . $vetor_categoria['nome'] .' ('.$titulo.')';
}else{
    $nome = $vetor_turma['ncontrato'] . ' / ' . $vetor_local['cidade'] . ' - ' . $vetor_local['estado'] . ' / ' . $vetor_local['nome'] . ' - ' . $vetor_categoria['nome'];
}

$sql = mysqli_query($con, "update eventos_turma SET nome='$nome', id_turma='$id_turma', solicitante='$solicitante', id_categoria='$id_categoria', titulo='$titulo', id_local='$id_local', data='$data', horainicio='$horainicio', horafim='$horafim', qtdalunos='$qtdalunos', qtdpessoas='$qtdpessoas', responsavel='$responsavel', telefone='$telefone', nomeresponsavel='$nomeresponsavel', telefoneresponsavel='$telefoneresponsavel', tarefa='$tarefa', departamento='$departamento', observacoes='$observacoes', status='0' where id_evento = '$id'");

$id_cadastro = $id;

$sql = mysqli_query($con,"update eventosformando set id_evento_turma = $id_cadastro where id_evento_turma_lista = $id_evento_turma_lista");

if($tarefa == '1') { 

$sql_tarefa = mysqli_query($con, "update calendario SET titulo='$nome', departamento = '3', departamentosolicitante='3', descricao='$observacoes', data='$data', hora='$horainicio' where tipo = '3' AND id = '$id'");

}

if($tarefa == '2') { 

$sql_tarefa = mysqli_query($con, "update calendario SET titulo='$nome', departamento = '$departamento', departamentosolicitante='3', descricao='$observacoes', data='$data', hora='$horainicio' where tipo = '3' AND id = '$id'");

}

echo"<script language=\"JavaScript\">
	location.href=\"fotografia_eventos.php\";
	</script>";

?>