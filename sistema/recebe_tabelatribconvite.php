<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$z = ucwords(strtolower($_POST['titulo']));

if(!empty($_POST['titulo'])) {

	$f = 0;

	foreach($z as $keyz) {

		$titulo = ucwords(strtolower($_POST['titulo'][$f]));
		$tipo = $_POST['tipo'][$f];
		$valor = moeda($_POST['valor'][$f]);


		$sql_grava = mysqli_query($con, "insert into tabela_tributos (titulo, tipo, valor) VALUES ('$titulo', '$tipo', '$valor')");

		$f++;

	}

}

echo"<script language=\"JavaScript\">
location.href=\"comercial_tabelatribconvite.php\";
</script>";

?>