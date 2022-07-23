<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id_gerado = $_GET['id'];
$id1 = $_GET['id1'];


		$id_item = $_POST['id_item'];
		$qtd = $_POST['qtd'];
		$qtdfinal = $_POST['qtdfinal'];
		$valor = moeda($_POST['valor']);


		$sql_grava = mysqli_query($con, "update tabela_basico_itens SET id_itemtabela='$id_item', qtd='$qtd', qtdfim='$qtdfinal', valor='$valor' where id_item = '$id_gerado'");


echo"<script language=\"JavaScript\">
location.href=\"alterardadosbasico.php?id=$id1\";
</script>";

?>