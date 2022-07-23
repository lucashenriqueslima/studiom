<?php

include"../includes/conexao.php";




$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];
$data = date('Y-m-d');
$status = $_POST['status'];
if($status != '1'){
    $statusexplode = explode("_", $_POST['status']);
    $status = $statusexplode[0];
    $observacoes = addslashes($_POST['observacoes']);
    $x = $_POST['foto'];
    if($status == '1'){
        $status = 2;
    }elseif ($status == '2'){
        $status = 3;
    }
}

$sql_update = mysqli_query($con, "update meu_convite_paginas SET descricao = '$observacoes', status = '$status' where id_pagina = '$id'");

$sql_update_convite = mysqli_query($con, "update meu_convite SET status = '2' where id_meuconvite = '$id_escolha'");
if($status == 2){
    $status = 1;
}elseif ($status == 3){
    $status = 2;
}
if($status == 2) {

$i = 0;

foreach($x as $key) {

	$foto = $_POST['foto'][$i];

	$sql_fotos = mysqli_query($con, "insert into meuconvite_fotos_escolhidas (id_meuconvite, foto) VALUES ('$id', '$foto')");

	$i++;

}

}

echo"<script language=\"JavaScript\">
location.href=\"aprovarconvite.php?id=$id_escolha&lamina=Lamina-$id#Lamina-$id\";
</script>";

?>