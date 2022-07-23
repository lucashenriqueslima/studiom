<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM eventos_turma where id_evento = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
$sql_exclui = "delete FROM calendario where id = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='fotografia_eventos.php'</script>";

?>