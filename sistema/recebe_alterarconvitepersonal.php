<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$datafinal = $_POST['datafinal'];
$status = $_POST['status'];

$sql_consulta = mysqli_query($con, "select * from convite_personal where id_convite = '$id'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_consulta[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql = mysqli_query($con, "update convite_personal SET datafinal='$datafinal', status='$status' where id_convite = '$id'");

$id_gerado = $con->insert_id;

$sql_tipoarquivo = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '$id_turma'");

while($vetor_tipoarquivo = mysqli_fetch_array($sql_tipoarquivo)) {

	if($vetor_tipoarquivo['id_tipo'] > 2) {

		$sql_consulta_tipo = mysqli_query($con, "select * from convite_personal_itens where id_tipo = '$vetor_tipoarquivo[id_tipo]'");

		if(mysqli_num_rows($sql_consulta_tipo) == 0) {

		$sql_itens = mysqli_query($con, "insert into convite_personal_itens (id_convite, id_tipo, qtd) VALUES ('$id_gerado', '$vetor_tipoarquivo[id_tipo]', '$vetor_tipoarquivo[qtd]')");

		}

	}

}

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_personal.php\";
</script>";

?>