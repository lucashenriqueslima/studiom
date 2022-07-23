<?php
include "../includes/conexao.php";
$id_curso = $_POST['id_curso'];
$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$id_curso'");
$vetor_curso = mysqli_fetch_array($sql_curso);
if ($vetor_curso['ocorrencia'] == 'Anual') {
	$qtd = 5;
	for ($i = 1; $i <= $qtd; $i++) {
		$consulta = mysqli_query($con, "select * from turmas_mkt where id_curso = '$id_curso' order by id_turma DESC");
		if (mysqli_num_rows($consulta) == 0) {
			$ano = date('Y') + 1;
			$semestre = 2;
			$sql_grava = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$ano', '$semestre')");
		}else {
			$vetor_consulta = mysqli_fetch_array($consulta);
			$ano = $vetor_consulta['conclusao'] + 1;
			$semestre = 2;
			$sql_valida = mysqli_query($con, "select * from turmas_mkt where id_curso = '$id_curso' and conclusao = '$ano' and semestre = '$semestre' order by id_turma DESC");
			if (mysqli_num_rows($sql_valida) == 0) {
				$sql_grava = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$ano', '$semestre')");
			}
		}
	}
}else {
	$qtd = 10;
	for ($i = 1; $i <= $qtd; $i++) {
		$consulta = mysqli_query($con, "select * from turmas_mkt where id_curso = '$id_curso' order by id_turma DESC");
		if (mysqli_num_rows($consulta) == 0) {
			$ano = date('Y') + 1;
			$semestre = 1;
			$sql_grava = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$ano', '$semestre')");
		}else {
			if ($i % 2 == 0) {
				$vetor_consulta = mysqli_fetch_array($consulta);
				$ano = $vetor_consulta['conclusao'];
				$semestre = 2;
				$sql_valida = mysqli_query($con, "select * from turmas_mkt where id_curso = '$id_curso' and conclusao = '$ano' and semestre = '$semestre' order by id_turma DESC");
				if (mysqli_num_rows($sql_valida) == 0) {
					$sql_grava = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$ano', '$semestre')");
				}
			}else {
				$vetor_consulta = mysqli_fetch_array($consulta);
				$ano = $vetor_consulta['conclusao'] + 1;
				$semestre = 1;
				$sql_valida = mysqli_query($con, "select * from turmas_mkt where id_curso = '$id_curso' and conclusao = '$ano' and semestre = '$semestre' order by id_turma DESC");
				if (mysqli_num_rows($sql_valida) == 0) {
					$sql_grava = mysqli_query($con, "insert into turmas_mkt (id_curso, conclusao, semestre) VALUES ('$id_curso', '$ano', '$semestre')");
				}
			}
		}
	}
}
echo "<script language=\"JavaScript\">
location.href=\"cadastros_turmasmkt.php\";
</script>";
?>