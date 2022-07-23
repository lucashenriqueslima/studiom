<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id_evento = $_GET[ 'id_evento' ];
$id_turma = $_GET[ 'id_turma' ];

$sql_deleta_itens = mysqli_query($con, "delete FROM identificacao_formandos where id_identificacao = '$id'");

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='recebe_identificacaoformando_volta.php?id_evento=$id_turma&id_turma=$id_turma'</script>";

?>