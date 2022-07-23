<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$tab = $_GET['tab'];
$tab1 = $_GET['tab1'];
$datafinal = $_POST['datafinal'];

$sql_atualiza = mysqli_query($con, "update turmas SET datafinal = '$datafinal' where id_turma = '$id'");

$sql_convite_personal = mysqli_query($con, "select * from convite_personal a, formandos b where a.id_formando = b.id_formando and b.turma = '$id'");

while($vetor_convite_personal = mysqli_fetch_array($sql_convite_personal)) {
	$sql_atualiza = mysqli_query($con, "update convite_personal SET datafinal = '$datafinal' where id_convite = '$vetor_convite_personal[id_convite]'");
}

echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id#convite#tiposdearquivosconvite\";
</script>";

?>