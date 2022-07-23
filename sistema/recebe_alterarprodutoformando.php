<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$data = date('Y-m-d');
$qtd = $_POST['qtd'];
$encadernacao = $_POST['encadernacao'];

$sql_consulta = mysqli_query($con, "select * from produtos_formando where id_produto = '$id'");
$vetor = mysqli_fetch_array($sql_consulta);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$valoralbum = $qtd * $vetor_turma['valorfoto'];

if($encadernacao == 2) { 


$valorencadernacao = $vetor_turma['valorencadernacao'];

}

$sql_grava = mysqli_query($con, "update produtos_formando SET qtd='$qtd', encadernacao='$valorencadernacao', valor='$valoralbum' where id_produto = '$id'");

$x = $_POST['id_tipo'];

$i = 0;

foreach($x as $key) { 

	$id_tipo = $_POST['id_tipo'][$i];
	$valor = moeda($_POST['valor'][$i]);

	$sql_itens = mysqli_query($con, "insert into produtos_opcionais (id_produto, id_tipo, valor) VALUES ('$id', '$id_tipo', '$valor')");

	$i++;

	$totalizador += $valor;

}

$sql_atualiza = mysqli_query($con, "update produtos_formando SET valorfinal = valorfinal + $totalizador where id_produto = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"alterarprodutoop.php?id=$id\";
</script>";	

?>