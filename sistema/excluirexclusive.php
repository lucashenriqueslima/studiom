<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM convite_exclusive where id_exclusive = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_deleta_itens = mysqli_query($con, "delete FROM convite_exclusive_itens where id_exclusive = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afFotografia_exclusive.php'</script>";

?>