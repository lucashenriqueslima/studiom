<?php

include"../includes/conexao.php";


$id_formando = $_GET[ 'id_formando' ];
$id_evento = $_GET[ 'id_evento' ];

$sql_exclui = "delete FROM escolha_fotos_tratamento where id_formando = '$id_formando' and id_evento = '$id_evento'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='afFotografia_topfotos.php'</script>";

?>