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

	$id_produto = $_POST['id_produto'];
	$valor = moeda($_POST['valor']);
	$qtdpaginas = $_POST['qtdpaginas'];

	$sql_ref = "update pacotes_itens_produtos SET id_produto='$id_produto', valor='$valor', qtdpaginas='$qtdpaginas' where id_produto_item = '$id'";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));



echo"<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id1\";
</script>";	

?>