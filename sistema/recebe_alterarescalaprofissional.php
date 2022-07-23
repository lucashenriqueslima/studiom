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
$id_colaborador = $_POST['id_colaborador'];
$id_funcao = $_POST['id_funcao'];
$ncartao = $_POST['ncartao'];
$horario = $_POST['horario'];
$horariofim = $_POST['horariofim'];
$qtdfotos = $_POST['qtdfotos'];

$sql_grava_profissionais = mysqli_query($con, "update escala_profissionais SET id_colaborador='$id_colaborador', id_funcao='$id_funcao', ncartao='$ncartao', horario='$horario', horariofim='$horariofim', qtdfotos='$qtdfotos' where id_escala_profissional = '$id'");


echo"<script language=\"JavaScript\">
location.href=\"alterarplanejamentoevento.php?id=$id1\";
</script>";

?>