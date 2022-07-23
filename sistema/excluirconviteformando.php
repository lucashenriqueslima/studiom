<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM meu_convite where id_meuconvite = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
$sql_itens = mysqli_query($con, "delete FROM meu_convite_paginas where id_meuconvite = '$id'");
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afConvite_formandos.php'</script>";

?>