<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = mysqli_query($con, "delete FROM perfil where id_perfil = '$id'");
$sql_exclui1 = mysqli_query($con, "delete FROM perfil_paginas where id_perfil = '$id'");
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='listarperfil.php'</script>";

?>