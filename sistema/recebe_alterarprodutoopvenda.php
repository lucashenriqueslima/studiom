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


	$id_tipo = $_POST['id_tipo'];
	$valor = moeda($_POST['valor']);

	$sql_ref = "update produtos_opcionais SET id_tipo='$id_tipo', valor='$valor' where id_item = '$id'";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));

	$sql_produto = mysqli_query($con, "select * from produtos_formando where id_produto = '$id1'");
	$vetor_produto = mysqli_fetch_array($sql_produto);

	$sql_itens = mysqli_query($con, "SELECT SUM(valor) as total FROM produtos_opcionais where id_produto = '$id1'");
	$vetor_itens = mysqli_fetch_array($sql_itens);

	$total = $vetor_produto['valor'] + $vetor_produto['encadernacao'] + $vetor_itens['total'];

	$sql_totalizador = mysqli_query($con, "update produtos_formando SET valorfinal = '$total' where id_produto = '$id1'");



echo"<script language=\"JavaScript\">
location.href=\"alterarprodutoop.php?id=$id1\";
</script>";	

?>