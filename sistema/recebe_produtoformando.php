<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$id_formando = $_POST['id_formando'];
$data = date('Y-m-d');
$qtd = $_POST['qtd'];
$encadernacao = $_POST['encadernacao'];

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$valoralbum = $qtd * $vetor_turma['valorfoto'];

if($encadernacao == 2) { 


$valorencadernacao = $vetor_turma['valorencadernacao'];

}

$sql_grava = mysqli_query($con, "insert into produtos_formando (id_turma, id_formando, data, qtd, encadernacao, valor, classificacao, status) VALUES ('$id_turma', '$id_formando', '$data', '$qtd', '$valorencadernacao', '$valoralbum', '1', '1')");

$id_gerado = $con->insert_id;

$x = $_POST['id_tipo'];

$i = 0;

foreach($x as $key) { 

	$id_tipo = $_POST['id_tipo'][$i];
	$valor = moeda($_POST['valor'][$i]);

	$sql_itens = mysqli_query($con, "insert into produtos_opcionais (id_produto, id_tipo, valor) VALUES ('$id_gerado', '$id_tipo', '$valor')");

	$i++;

	$totalizador += $valor;

}

$total = $totalizador + $valoralbum + $valorencadernacao;

$sql_atualiza = mysqli_query($con, "update produtos_formando SET valorfinal = '$total' where id_produto = '$id_gerado'");

echo"<script language=\"JavaScript\">
location.href=\"vendas_produtosformando.php\";
</script>";	

?>