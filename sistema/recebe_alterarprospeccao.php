<?php

include "../includes/conexao.php";

$id = $_GET['id'];
$qual_produto = $_POST['qual_produto'];
if (isset($_GET['dados'])) {
    $num_alunos = $_POST['num_alunos'];
    $empresa_cerimonial = $_POST['empresa_cerimonial'];
    $nome_cerimonial = $_POST['nome_cerimonial'];
    $observacoes = $_POST['observacao'];
    $sql = mysqli_query($con, "update prospeccoes SET num_alunos='$num_alunos',empresa_cerimonial='$empresa_cerimonial',nome_cerimonial='$nome_cerimonial',observacao='$observacoes' where id_prospeccao = '$id'");
} else {
    $viabilidade = ($_POST[$qual_produto . '_viabilidade'] == 2 ?'inviavel':'viavel');
    $motivo = ($_POST[$qual_produto . '_motivo']=='1'?'Contrato Fechado com outra Empresa':'Fora do Perfil de atendimento');
    $empresa = $_POST[$qual_produto . '_empresa'];

    $sql = mysqli_query($con, "update prospeccoes SET ".$qual_produto."_viabilidade='$viabilidade',".$qual_produto."_motivo='$motivo',".$qual_produto."_empresa='$empresa' where id_prospeccao = '$id'");
}

echo "<script language=\"JavaScript\">
	location.href=\"alterarprospeccao.php?id=$id\";
	</script>";
?>