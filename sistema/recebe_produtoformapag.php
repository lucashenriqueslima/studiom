<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$x = $_POST[ 'id_forma' ];
$i = 0;

	foreach($x as &$key){

	$id_forma = $_POST['id_forma'][$i];
	$qtdparcelas = $_POST['qtdparcelas'][$i];
	$datafixa = $_POST['datafixa'][$i];
	$datavencimento = $_POST['datavencimento'][$i];

	$sql_ref = "insert into formaspag_produto (id_produto, id_forma, qtdparcelas, datafixa, datavencimento) VALUES ('$id', '$id_forma', '$qtdparcelas', '$datafixa', '$datavencimento')";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));

	$i++;

	}


echo"<script language=\"JavaScript\">
location.href=\"alterarproduto.php?id=$id\";
</script>";	

?>