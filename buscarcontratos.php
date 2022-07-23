<?php
	$id_turma = $_GET['id_turma'];
	include "includes/conexao.php";
	$result_turma = mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'");
	$row_turma = mysqli_fetch_array($result_turma);
	$sql_instituicao_inicio = mysqli_query($con,
		"select * from instituicoes where id_instituicao = '$row_turma[id_instituicao]'");
	$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
	$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$row_turma[curso]'");
	$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
	echo "<option value='".$row_turma['id_turma']."'>".$row_turma['nome']." - ".$row_turma['ano']." - ".$vetor_instituicao_inicio['sigla']."</option>";
?>