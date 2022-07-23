<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_formando = $_POST['id_formando'];
$data = date('Y-m-d');

$vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$id_turma'"));

$sql = mysqli_query($con, "insert into convite_personal (id_formando, data, datafinal, status) VALUES ('$id_formando', '$data', '$vetor_turma[datafinal]', '1')");

$id_gerado = $con->insert_id;

$sql_tipoarquivo = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '$id_turma'");

while($vetor_tipoarquivo = mysqli_fetch_array($sql_tipoarquivo)) {

	if($vetor_tipoarquivo['id_tipo'] > 2) {

		$sql_itens = mysqli_query($con, "insert into convite_personal_itens (id_convite, id_tipo, qtd) VALUES ('$id_gerado', '$vetor_tipoarquivo[id_tipo]', '$vetor_tipoarquivo[qtd]')");

	}

}

echo"<script language=\"JavaScript\">
location.href=\"afFotografia_personal.php\";
</script>";

?>