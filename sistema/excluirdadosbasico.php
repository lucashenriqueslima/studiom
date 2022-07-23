<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM tabela_basico where id_basico = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='comercial_dadosbasico.php'</script>";

?>