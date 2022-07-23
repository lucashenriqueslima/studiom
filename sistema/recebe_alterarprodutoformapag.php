<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];


	$id_forma = $_POST['id_forma'];
	$qtdparcelas = $_POST['qtdparcelas'];
	$datafixa = $_POST['datafixa'];
	$datavencimento = $_POST['datavencimento'];

	$sql_ref = "update formaspag_produto SET id_forma='$id_forma', qtdparcelas='$qtdparcelas', datafixa='$datafixa', datavencimento='$datavencimento' where id_item = '$id'";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));



echo"<script language=\"JavaScript\">
location.href=\"alterarproduto.php?id=$id1\";
</script>";	

?>