<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET['id1'];

$sql_consulta = mysqli_query($con, "select * FROM produtos_opcionais where id_item = '$id'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);
$valor = $vetor_consulta['valor'];

$sql_exclui = "delete FROM produtos_opcionais where id_item = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

$sql_update = mysqli_query($con, "update produtos_formando SET valorfinal = valorfinal - $valor where id_produto = '$id1'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarprodutoop.php?id=$id1'</script>";

?>