<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];
$tab = $_GET['tab'];
$tab1 = $_GET['tab1'];

$sql_exclui = "delete FROM eventos_turma_lista where id_evento_turma = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarturma.php?id=$id1&tab=$tab&tab1=$tab1'</script>";

?>