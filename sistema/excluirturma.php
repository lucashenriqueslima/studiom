<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM turmas where id_turma = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='projetos_turmas.php'</script>";

?>