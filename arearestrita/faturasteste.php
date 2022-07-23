<?php

$qtd = 12;
$data = '2019-10-30';
$vencimento = 30;
$datagerada = $data;

for($i = 1; $i <= $qtd; $i++) {

echo $datagerada;
echo "<br>";

if (!empty($vencimento)){

$dia = $vencimento;

}else{

$dia = date("d",strtotime($datagerada));

} 

$mes = date("m",strtotime($datagerada)) + 1;  
$ano = date("Y",strtotime($datagerada));

if ($mes == 13) {

$mes = 01;  
$ano = $ano + 1;

}

if ($dia == 30 && $mes == 2){

$datagerada = $ano."-".$mes."-28";

}else{  

$datagerada = $ano."-".$mes."-".$dia;

} 

}