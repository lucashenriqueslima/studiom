<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$id_gerado = $_GET['id1'];


$qtd = $_POST['qtd'];
$qtdfinal = $_POST['qtdfinal'];
$valor = moeda($_POST['valor']);

$sql_grava = mysqli_query($con, "update tabela_basico_valores SET qtd='$qtd', qtdfinal='$qtdfinal', valor='$valor' where id_valor = '$id'");


echo"<script language=\"JavaScript\">
location.href=\"alterardadosbasico.php?id=$id_gerado\";
</script>";

?>