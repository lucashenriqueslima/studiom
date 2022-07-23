<?php
include "../includes/conexao.php";
$id = $_GET['id'];
$id1 = $_GET['id1'];
$x = $_POST['id_forma'];
$i = 0;
foreach ($x as &$key) {
	$id_forma = $_POST['id_forma'][$i];
//	$qtdparcelas = $_POST['qtdparcelas'][$i];
//	$datainicio = $_POST['datainicio'][$i];
//	$datalimite = $_POST['datalimite'][$i];
//	$datafixa = $_POST['datafixa'][$i];
//	$datavencimento = $_POST['datavencimento'][$i];
	$descricao = $_POST['descricao'][$i];
	$res_ref = mysqli_query($con, "insert into formaspag_pacote (id_pacote, id_forma, descricao) VALUES ('$id', '$id_forma', '$descricao')") or die (mysqli_error($con));
	$i++;
}
echo "<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id&id1=$id1\";
</script>";
?>