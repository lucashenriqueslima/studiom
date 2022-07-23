<?php

include "../includes/conexao.php";


$id = $_GET[ 'id' ];

$imagemQueVaiDeletada = mysqli_query($con,"select * from qr_convite where turma_fk = '$id'");

     while ($vetor = mysqli_fetch_array($imagemQueVaiDeletada)) {
         // print_r($vetor['imagem_turma']);
     
          unlink($vetor['imagem_turma']);
          unlink($vetor['imagem_brasao']);
          //if ($deleta1 & $deleta2) {

               $sql_exclui = "delete FROM qr_convite where turma_fk = '$id'";
               $res2 = mysqli_query($con, $sql_exclui);

               
                    echo "<script> alert('Excluido com sucesso!')</script>";
                    echo "<script> window.location.href='solenidades_qrcode.php'</script>";
          //}else {
               //echo "<script> alert('Arquivo não existe!')</script>";
             //  echo "<script> window.location.href='solenidades_qrcode.php'</script>";
           //}
     }
?>