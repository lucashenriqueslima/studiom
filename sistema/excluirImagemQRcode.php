<?php

include "../includes/conexao.php";


$id = $_GET[ 'id' ];

$imagemQueVaiDeletada = mysqli_query($con,"select * from imagem_QRcode where ncontrato = '$id'");


while ($vetor = mysqli_fetch_array($imagemQueVaiDeletada)) {
    //print_r($vetor['imagemQRcode']);

    $deleta = unlink($vetor['imagemQRcode']);
    if ($deleta) {

        $sql_exclui = "delete FROM imagem_QRcode where ncontrato = '$id'";
        $res2 = mysqli_query($con, $sql_exclui);

        if ($res2) {
            
            $res2 = mysqli_query($con, $sql_exclui);
            echo "<script> alert('Excluido com sucesso!')</script>";
            echo "<script> window.location.href='solenidades_qrcode.php'</script>";
        }else {
            
            echo "<script> alert('Arquivo não existe!')</script>";
            echo "<script> window.location.href='solenidades_qrcode.php'</script>";
        }
    }else {
        echo "<script> alert('Arquivo não existe!')</script>";
        echo "<script> window.location.href='solenidades_qrcode.php'</script>";
    }
}
?>