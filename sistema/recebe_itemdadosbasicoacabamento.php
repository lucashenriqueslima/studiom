<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$z = $_POST['id_item'];

if(!empty($_POST['id_item'])) {

	$f = 0;

	foreach($z as $keyz) {

		$id_item = $_POST['id_item'][$f];
		$qtd = $_POST['qtd'][$f];
		$qtdfinal = $_POST['qtdfinal'][$f];
		$valor = moeda($_POST['valor'][$f]);
		$acabamentoembalagem = $_POST['acabamentoembalagem'][$f];
		$acabamentodacapa = $_POST['acabamentodacapa'][$f];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_acabamentos (id_itemtabela, qtd, qtdfim, valor, acabamentoembalagem, acabamentodacapa) VALUES ('$id_item', '$qtd', '$qtdfinal', '$valor', '$acabamentoembalagem', '$acabamentodacapa')");

		$f++;

	}

}

echo"<script language=\"JavaScript\">
location.href=\"comercial_tabelaacabamentos.php\";
</script>";

?>