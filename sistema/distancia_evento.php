<?php

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "select * from eventos_turma where id_evento = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor[id_local]'");
$vetor_local = mysqli_fetch_array($sql_local);

$cep = '74083120';
$cep1 = soNumero($vetor_local['cep']);

$xml = simplexml_load_file('https://maps.googleapis.com/maps/api/distancematrix/xml?origins='.$cep.'&destinations='.$cep1.'&key=AIzaSyCOoywvLULyKzumFABrBIXY5kRdYUPVjpg');

foreach($xml->row as $rows) {

    $total1 = $rows->element->distance->value;

    echo $tempo = $rows->element->duration->text;

    echo "<br>";

    $totalkm1 = $total1 / 1000;

    echo $totalarrendondado = round($totalkm1);

    echo "<br>";

    echo $distanciafinal = $totalarrendondado * 2;

}

?>