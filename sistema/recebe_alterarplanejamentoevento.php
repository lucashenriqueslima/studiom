<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];

$x = $_POST['eventos'];

$i = 0;

foreach($x as $key) {

	$eventos = $_POST['eventos'][$i];

	if(!empty($eventos)) {

	$sql_eventos = mysqli_query($con, "select * from escala_eventos_itens where id_escala = '$id' and id_evento = '$eventos'");

	if(mysqli_num_rows($sql_eventos) == 0) {

		$sql_grava_evento = mysqli_query($con, "insert into escala_eventos_itens (id_escala, id_evento) VALUES ('$id', '$eventos')");

	}

	}

	$i++;

}

$y = $_POST['id_funcao'];

$f = 0;

foreach($y as $keyyy) {

	$id_funcao = $_POST['id_funcao'][$f];

	if(!empty($id_funcao)) {

	$sql_grava_escala_profissionais = mysqli_query($con, "insert into escala_profissionais (id_escala, id_funcao) VALUES ('$id', '$id_funcao')");

	}

	$f++;
}

echo"<script language=\"JavaScript\">
location.href=\"gerarcustosescala.php?id=$id\";
</script>";

?>