<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id_formando = $_GET['id_formando'];

$sql_exclui = "delete FROM produtos_formando where id_produto = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_exclui1 = mysqli_query($con, "delete FROM produtos_opcionais where id_produto = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='recebe_buscaprodutosformando_get.php?id_formando=$id_formando'</script>";

?>