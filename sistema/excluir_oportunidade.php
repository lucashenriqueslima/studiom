<?php

include"../includes/conexao.php";

if(isset($_GET['id_oportunidade'])){
    $id = $_GET['id_oportunidade'];
    $sql = mysqli_query($con, "delete FROM oportunidades where id_oportunidade = '{$id}'");
}else{
    $id = $_GET['id_turma_lead'];
    $turma_lead = mysqli_fetch_array(mysqli_query($con, "select * FROM turmas_leads where id_turma_lead = '{$id}'"));
    $fografia = mysqli_fetch_array(mysqli_query($con, "select * FROM leads where id_lead = '{$turma_lead['id_fotografia']}'"));
    $convite = mysqli_fetch_array(mysqli_query($con, "select * FROM leads where id_lead = '{$turma_lead['id_convite']}'"));
    $ensaio = mysqli_fetch_array(mysqli_query($con, "select * FROM leads where id_lead = '{$turma_lead['id_ensaio']}'"));
    $placa = mysqli_fetch_array(mysqli_query($con, "select * FROM leads where id_lead = '{$turma_lead['id_placa']}'"));
    $prospeccao = mysqli_fetch_array(mysqli_query($con, "select * FROM prospeccoes where id_prospeccao = '{$turma_lead['id_prospeccao']}'"));
    mysqli_query($con, "delete FROM calendario where id_calendario = '{$fotografia['id_calendario']}' or id_calendario = '{$convite['id_calendario']}' or id_calendario = '{$ensaio['id_calendario']}' or id_calendario = '{$placa['id_calendario']}'");
    mysqli_query($con, "update arquivos_oportunidade set deletado=1 where id_lead='{$turma_lead['id_fotografia']}' or id_lead='{$turma_lead['id_convite']}' or id_lead='{$turma_lead['id_ensaio']}' or id_lead='{$turma_lead['id_placa']}'");
    mysqli_query($con, "update leads set deletado=1 where id_lead='{$turma_lead['id_fotografia']}' or id_lead='{$turma_lead['id_convite']}' or id_lead='{$turma_lead['id_ensaio']}' or id_lead='{$turma_lead['id_placa']}'");
    mysqli_query($con, "update turmas_leads set deletado=1 where id_turma_lead='{$id}'");
}

if($sql){
    echo "OK";
}else{
    echo "ERRO";
}

?>