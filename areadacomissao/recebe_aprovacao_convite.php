<?php

include"../includes/conexao.php";




$id_convite = $_POST['id_convite'];
$data = date('Y-m-d');

$x = $_POST['id_item'];

$i = 0;

foreach($x as $key) {

    $id_item = $_POST['id_item'][$i];
    $descricao = addslashes($_POST['descricao'][$i]);
    $status = $_POST['status'][$i];

    $sql = mysqli_query($con, "update meu_convite_paginas_turma SET descricao = '$descricao', status = '$status' where id_pagina = '$id_item'");

    $i++;
}


$sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas_turma WHERE id_meuconvite = '$id_convite' and status <> 1");
if(mysqli_num_rows($sql_consulta) > 0){
    $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas_turma WHERE id_meuconvite = '$id_convite' and status <> 2");
    if(mysqli_num_rows($sql_consulta) > 0) {
        $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas_turma WHERE id_meuconvite = '$id_convite' and status = 1");
        if(mysqli_num_rows($sql_consulta) == 0) {
            $sql_update = mysqli_query($con, "update meu_convite_turma SET status = '3', dataaprovacao = '$data' where id_meuconvite = '$id_convite'");
        }else{
            $sql_update = mysqli_query($con, "update meu_convite_turma SET status = '2' where id_meuconvite = '$id_convite'");
        }
    }else{
        $sql_update = mysqli_query($con, "update meu_convite_turma SET status = '4', dataaprovacao = '$data' where id_meuconvite = '$id_convite'");
    }
}else{
    $sql_update = mysqli_query($con, "update meu_convite_turma SET status = '1' where id_meuconvite = '$id_convite'");
}


echo"<script language=\"JavaScript\">
location.href=\"inicio.php\";
</script>";

?>