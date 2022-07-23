<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];


	$id_forma = $_POST['id_forma'];
	$qtdparcelas = $_POST['qtdparcelas'];
	$datainicio = $_POST['datainicio'];
	$datalimite = $_POST['datalimite'];
	$datafixa = $_POST['datafixa'];
	$datavencimento = $_POST['datavencimento'];
	$descricao = $_POST['descricao'];

	$sql_ref = "update formaspag_pacote SET id_forma='$id_forma', qtdparcelas='$qtdparcelas', datainicio='$datainicio', datalimite='$datalimite', datafixa='$datafixa', datavencimento='$datavencimento', descricao='$descricao' where id_item = '$id'";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));


echo"<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id1\";
</script>";	

?>