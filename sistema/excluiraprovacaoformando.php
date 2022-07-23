<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];
$id_formando = $_GET[ 'id_formando' ];

$sql_exclui = "delete FROM minhas_aprovacoes where id_minhaaprovacao = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_deleta_itens = mysqli_query($con, "delete FROM minhas_aprovacoes_paginas where id_minhaaprovacao = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='listaraprovacoesformando.php?id=$id1&id_formando=$id_formando'</script>";

?>