<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM meu_album_turma where id_meualbum = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_deleta_itens = mysqli_query($con, "delete FROM meu_album_paginas_turma where id_meualbum = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afFotografia_albumturma.php'</script>";

?>