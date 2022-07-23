<?php

include "../includes/conexao.php";


$id = $_GET[ 'id' ];

$documentosADeletar = mysqli_query($con,"SELECT * FROM dispositivos WHERE id_dispositivo= '$id'");

    while ($vetor = mysqli_fetch_array($documentosADeletar)) {
          unlink($vetor['nfDispositivo']);
          unlink($vetor['garantiaDispositivo']);
    }
$sql_exclui = "delete FROM dispositivos where id_dispositivo = '$id'";
$res2 = mysqli_query($con, $sql_exclui);

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='cadastro_dispositivo.php'</script>";

?>