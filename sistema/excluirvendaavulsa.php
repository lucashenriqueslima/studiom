<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id_formando = $_GET['id_formando'];

$sql_exclui = "delete FROM venda_avulsa where id_avulsa = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_exclui1 = mysqli_query($con, "delete FROM venda_avulsa_produtos where id_avulsa = '$id'");
$sql_exclui2 = mysqli_query($con, "delete FROM vendas where tipo = '3' and produto = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='vendas_avulsas.php'</script>";

?>