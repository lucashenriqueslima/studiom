<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$id_produto = $_POST['id_produto'];
$id_tamanho = $_POST['id_tamanho'];
$descricao = $_POST['descricao'];
$paginas = $_POST['paginas'];
$paginaspersonalizadas = $_POST['paginaspersonalizadas'];

$sql = mysqli_query($con, "update tabela_basico SET id_produto='$id_produto', id_tamanho='$id_tamanho', descricao='$descricao', paginas='$paginas', paginaspersonalizadas='$paginaspersonalizadas' where id_basico = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"comercial_dadosbasico.php\";
</script>";

?>