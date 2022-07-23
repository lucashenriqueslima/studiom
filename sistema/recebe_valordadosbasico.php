<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id_gerado = $_GET['id'];

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

echo"<script language=\"JavaScript\">
location.href=\"alterardadosbasico.php?id=$id_gerado\";
</script>";

?>