<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];
$valorfinal = moeda($_POST['valorfinal']);

$sql_grava = mysqli_query($con, "update escala_faturamento SET valorfinal='$valorfinal' where id_escala_faturamento = '$id'");


echo"<script language=\"JavaScript\">
location.href=\"alterarfaturamentoevento.php?id=$id1\";
</script>";

?>