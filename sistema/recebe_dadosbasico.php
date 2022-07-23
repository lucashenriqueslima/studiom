<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id_produto = $_POST['id_produto'];
$id_tamanho = $_POST['id_tamanho'];
$descricao = $_POST['descricao'];
$paginas = $_POST['paginas'];
$paginaspersonalizadas = $_POST['paginaspersonalizadas'];

$sql = mysqli_query($con, "insert into tabela_basico (id_produto, id_tamanho, descricao, paginas, paginaspersonalizadas) VALUES ('$id_produto', '$id_tamanho', '$descricao', '$paginas', '$paginaspersonalizadas')");

$id_gerado = $con->insert_id;

$x = $_POST['qtd'];

if(!empty($_POST['qtd'])) {

	$i = 0;

	foreach($x as $key) {

		$qtd = $_POST['qtd'][$i];
		$qtdfinal = $_POST['qtdfinal'][$i];
		$valor = moeda($_POST['valor'][$i]);

		$sql_grava = mysqli_query($con, "insert into tabela_basico_valores (id_basico, qtd, qtdfinal, valor) VALUES ('$id_gerado', '$qtd', '$qtdfinal', '$valor')");

		$i++;

	}

}

$z = $_POST['id_embalagem'];

if(!empty($_POST['id_embalagem'])) {

	$f = 0;

	foreach($z as $keyz) {

		$id_embalagem = $_POST['id_embalagem'][$f];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '2', '$id_embalagem')");

		$f++;

	}

}

$y = $_POST['id_acabamentoembalagem'];

if(!empty($_POST['id_acabamentoembalagem'])) {

	$h = 0;

	foreach($y as $keyy) {

		$id_acabamentoembalagem = $_POST['id_acabamentoembalagem'][$h];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '3', '$id_acabamentoembalagem')");

		$h++;

	}

}

$w = $_POST['id_sobrecapaencarte'];

if(!empty($_POST['id_sobrecapaencarte'])) {

	$g = 0;

	foreach($w as $keyw) {

		$id_sobrecapaencarte = $_POST['id_sobrecapaencarte'][$g];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '4', '$id_sobrecapaencarte')");

		$g++;

	}

}

$p = $_POST['id_capa'];

if(!empty($_POST['id_capa'])) {

	$j = 0;

	foreach($p as $keyp) {

		$id_capa = $_POST['id_capa'][$j];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '5', '$id_capa')");

		$j++;

	}

}

$r = $_POST['id_acabamentocapa'];

if(!empty($_POST['id_acabamentocapa'])) {

	$k = 0;

	foreach($r as $keyr) {

		$id_acabamentocapa = $_POST['id_acabamentocapa'][$k];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '6', '$id_acabamentocapa')");

		$k++;

	}

}

$s = $_POST['id_componentesmiolo'];

if(!empty($_POST['id_componentesmiolo'])) {

	$l = 0;

	foreach($s as $keys) {

		$id_componentesmiolo = $_POST['id_componentesmiolo'][$l];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '7', '$id_componentesmiolo')");

		$l++;

	}

}

$t = $_POST['id_opcionais'];

if(!empty($_POST['id_opcionais'])) {

	$m = 0;

	foreach($t as $keyt) {

		$id_opcionais = $_POST['id_opcionais'][$m];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '8', '$id_opcionais')");

		$m++;

	}

}

$u = $_POST['id_paginas'];

if(!empty($_POST['id_paginas'])) {

	$n = 0;

	foreach($u as $keyu) {

		$id_paginas = $_POST['id_paginas'][$n];

		$sql_grava = mysqli_query($con, "insert into tabela_basico_itens (id_basico, id_tipo, id_itemtabela) VALUES ('$id_gerado', '10', '$id_paginas')");

		$n++;

	}

}

echo"<script language=\"JavaScript\">
location.href=\"comercial_dadosbasico.php\";
</script>";

?>