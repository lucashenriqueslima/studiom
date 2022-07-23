<?php

function moeda($get_valor) { 
$source = array('.', ',');  
$replace = array('', '.'); 
$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
return $valor; //retorna o valor formatado para gravar no banco 
}

error_reporting(0);
ini_set("display_errors", 0 );
include"../../includes/conexao.php";
require_once 'excel_reader2.php';

if(isset($_POST['submit'])){

$tmp_name = $_FILES["filename"]["tmp_name"];
$name = $_FILES["filename"]["name"];

move_uploaded_file($tmp_name, $name);

$xls = new Spreadsheet_Excel_Reader("$name");
 
$linhas = $xls->rowcount();
$colunas= $xls->colcount();

for($i = 1; $i <= $linhas; $i++){
    for($j = 1; $j <= $colunas; $j++){
        $data[$j] = $xls->val($i,$j);
    }

	$id_item = ltrim($data[1], "0");
	$datapagamento = explode("/", $data[4]);
	$dia = $datapagamento[0];
	$mes = $datapagamento[1];
	$ano = '20'.$datapagamento[2];
	$datafinal = $ano.'-'.$mes.'-'.$dia;
	$valorsemponto = str_replace(".", "", $data[6]);
	$valor_recebido = str_replace(",",".", $valorsemponto);

	$sql_atualiza = "update duplicatas_faturas SET datapagamento='$datafinal', valor_recebido='$valor_recebido', status='2',pagamento = '1' where id_item='$id_item'";
	$res_atualiza = mysqli_query($con, $sql_atualiza) or die(mysqli_error($con));

}
}
echo"<script>opener.location.reload(); window.close();</script>";
?>