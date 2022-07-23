<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM escolha_fotos where id_escolha = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_deleta_itens = mysqli_query($con, "delete FROM escolha_fotos_itens where id_escolha = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afFotografia_escolhadefotos.php'</script>";

?>