<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$titulo = ucwords(strtolower($_POST['titulo']));
$tipo = $_POST['tipo'];
$valor = moeda($_POST['valor']);


$sql_grava = mysqli_query($con, "update tabela_tributos SET titulo='$titulo', tipo='$tipo', valor='$valor' where id_tributo = '$id'");


echo"<script language=\"JavaScript\">
location.href=\"comercial_tabelatribconvite.php\";
</script>";

?>