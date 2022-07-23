<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM orcamento_convite where id_orcamento = '$id'";
$sql_exclui1 = "delete FROM orcamento_produto where id_orcamento = '$id'";
$sql_exclui2 = "delete FROM orcamento_itens where id_orcamento = '$id'";

$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='comercial_orcamento_convite.php'</script>";

?>