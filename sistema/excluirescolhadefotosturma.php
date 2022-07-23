<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM turmas_escolha where id_turma_escolha = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_exclui1 = "delete FROM turmas_escolha_formandos where id_turma_escolha = '$id'";
$res3 = mysqli_query($con, $sql_exclui1);

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afFotografia_topfotos.php'</script>";

?>