<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];

$sql_exclui = "delete FROM pacotes_itens_produtos where id_produto_item = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarprodutopacotealbum.php?id=$id'</script>";

?>