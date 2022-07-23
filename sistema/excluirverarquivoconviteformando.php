<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET['id1'];

$sql_exclui = "delete FROM dadosconvite where id_dados = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='verarquivoconvite.php?id=$id1'</script>";

?>