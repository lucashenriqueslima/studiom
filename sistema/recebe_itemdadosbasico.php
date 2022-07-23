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

$z = $_POST['id_item'];

if(!empty($_POST['id_item'])) {

	$f = 0;

	foreach($z as $keyz) {

		$id_item = $_POST['id_item'][$f];
		$qtd = $_POST['qtd'][$f];
		$qtdfinal = $_POST['qtdfinal'][$f];
		$valor = moeda($_POST['valor'][$f]);


		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela, qtd, qtdfim, valor) VALUES ('$id_gerado', '$id1', '$id_item', '$qtd', '$qtdfinal', '$valor')");

		$f++;

	}

}

echo"<script language=\"JavaScript\">
location.href=\"alterardadosbasico.php?id=$id_gerado\";
</script>";

?>