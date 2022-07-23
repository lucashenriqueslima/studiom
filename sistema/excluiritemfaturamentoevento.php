<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];

$sql_exclui = "delete FROM escala_faturamento where id_escala_faturamento = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarfaturamentoevento.php?id=$id1'</script>";

?>