<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM tabela_tipos where id_tipo = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='comercial_itenstabelaconvite.php'</script>";

?>