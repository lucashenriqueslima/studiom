<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql_exclui = "delete FROM sub_categorias where id_sub = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='cadastros_status.php'</script>";

?>