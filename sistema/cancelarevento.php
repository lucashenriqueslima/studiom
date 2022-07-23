<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];

$sql = mysqli_query($con, "update eventos_turma SET status = '2' where id_evento = '$id'");
$sql_delete = mysqli_query($con, "delete FROM calendario where tipo = '3' and id = '$id'");

echo "<script> alert('Evento Cancelado com sucesso!')</script>";
echo "<script> window.location.href='fotografia_eventos.php'</script>";