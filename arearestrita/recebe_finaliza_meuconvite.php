<?php

include"../includes/conexao.php";




$id = $_GET['id'];
$data = date('Y-m-d');


$sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id' and  bloqueio <> 2 and status <> 1"); // Somente itens com alterações
if(mysqli_num_rows($sql_consulta) > 0){
    $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id' and  bloqueio <> 2 and status <> 2"); // Itens que não tenham sidos finalizados
    if(mysqli_num_rows($sql_consulta) > 0) {
        $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id' and  bloqueio <> 2 and status = 1"); // Itens sem alterações
        if(mysqli_num_rows($sql_consulta) == 0) {
            $sql_update = mysqli_query($con, "update meu_convite SET status = '3', dataaprovacao = '$data' where id_meuconvite = '$id'");
        }else{
            $sql_update = mysqli_query($con, "update meu_convite SET status = '2' where id_meuconvite = '$id'");
        }
    }else{
        $sql_update = mysqli_query($con, "update meu_convite SET status = '4', dataaprovacao = '$data' where id_meuconvite = '$id'");
    }
}else{
    $sql_update = mysqli_query($con, "update meu_convite SET status = '1' where id_meuconvite = '$id'");
}

echo"<script language=\"JavaScript\">
location.href=\"consultaprodutosconvite.php?id=$id\";
</script>";

?>