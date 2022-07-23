<?php

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

include"../includes/conexao.php";


$id = $_GET['id'];

$sql_escala = mysqli_query($con, "select * from escala_eventos where id_escala = '$id'");
$vetor_escala = mysqli_fetch_array($sql_escala);

$id_contrato = $vetor_escala['id_contrato'];

$sql_exclui = mysqli_query($con, "delete FROM escala_faturamento where id_escala = '$id'");

$sql_profissionais = mysqli_query($con, "select * from escala_profissionais where id_escala = '$id'");
$totalprofissionais = mysqli_num_rows($sql_profissionais);

$sql_qtd_eventos = mysqli_query($con, "select * from escala_eventos_itens where id_escala = '$id'");
$total_qtd_eventos = mysqli_num_rows($sql_qtd_eventos);

$sql_data = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' order by b.data ASC limit 0,1");
$vetor_data = mysqli_fetch_array($sql_data);

$sql_datafinal = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' order by b.data DESC limit 0,1");
$vetor_datafinal = mysqli_fetch_array($sql_datafinal);

$data_inicial = $vetor_data['data'];
$data_final = $vetor_datafinal['data'];

$diferenca = strtotime($data_final) - strtotime($data_inicial);

$dias = floor($diferenca / (60 * 60 * 24));
$totaldias = $dias + 1;

$sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor_datafinal[id_local]'");
$vetor_local = mysqli_fetch_array($sql_local);

$cep = '74083120';
$cep1 = soNumero($vetor_local['cep']);

$passageiroporcarro = 4;
$totaldecarros = $totalprofissionais / 4;
$totaldecarrosar = floor($totaldecarros);
$restocarro = $totalprofissionais % $passageiroporcarro;

$totalfinalcarros = $totaldecarrosar + 1;

//valor aluguel de carro

$sql_diaria_carro = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '2'");
$vetor_diaria_carro = mysqli_fetch_array($sql_diaria_carro);

$sql_carros = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '2', '$totalfinalcarros', '$totaldias', '$vetor_diaria_carro[valor]')");

//valor km
$sql_km = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '1'");
$vetor_km = mysqli_fetch_array($sql_km);

$xml = simplexml_load_file('https://maps.googleapis.com/maps/api/distancematrix/xml?origins='.$cep.'&destinations='.$cep1.'&key=AIzaSyCOoywvLULyKzumFABrBIXY5kRdYUPVjpg');

foreach($xml->row as $rows) {

    $total1 = $rows->element->distance->value;

    $tempo = $rows->element->duration->text;

    $totalkm1 = $total1 / 1000;

    $totalarrendondado = round($totalkm1);

    $distanciafinal = $totalarrendondado * 2;

    $sql_km = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '1', '$totalfinalcarros', '$distanciafinal', '$vetor_km[valor]')");

}	

//quartos hotel - quarto simples
$sql_quartosimples = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '3'");
$vetor_quartosimples = mysqli_fetch_array($sql_quartosimples);

//quartos hotel - quarto duplo
$sql_quartoduplo = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '4'");
$vetor_quartoduplo = mysqli_fetch_array($sql_quartoduplo);

//quartos hotel - quarto triplo
$sql_quartotriplo = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '5'");
$vetor_quartotriplo = mysqli_fetch_array($sql_quartotriplo);

if($totalprofissionais == 1) {

	$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '3', '1', '$totaldias', '$vetor_quartosimples[valor]')");

} if($totalprofissionais == 2) {

	$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '4', '1', '$totaldias', '$vetor_quartoduplo[valor]')");

} if($totalprofissionais == 4) {

	$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '4', '2', '$totaldias', '$vetor_quartoduplo[valor]')");

} else {

	$numerodivisao = 3;
	$divisao = $totalprofissionais / $numerodivisao;
	$divisaoar = floor($divisao);
	$resto = $totalprofissionais % $numerodivisao;

	$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '5', '$divisaoar', '$totaldias', '$vetor_quartotriplo[valor]')");

	if($resto == 1) {

		$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '4', '1', '$totaldias', '$vetor_quartoduplo[valor]')");

	} if($resto == 2) {

		$sql_hotel = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '4', '1', '$totaldias', '$vetor_quartoduplo[valor]')");

	}

}

while($vetor_profissionais = mysqli_fetch_array($sql_profissionais)) {

	$sql_valor_colaborador = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$vetor_profissionais[id_funcao]'");
	$vetor_valor_colaborador = mysqli_fetch_array($sql_valor_colaborador);

	$sql_colaborador = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, id_colaborador, valor) VALUES ('$id', '$vetor_profissionais[id_funcao]', '1', '$total_qtd_eventos', '$vetor_profissionais[id_escala_profissional]', '$vetor_valor_colaborador[valor]')");

}


echo"<script language=\"JavaScript\">
location.href=\"fotografia_planejamento_eventos.php\";
</script>";

?>