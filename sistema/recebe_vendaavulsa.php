<?php
function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

include "../includes/conexao.php";
$id_turma = $_POST['id_turma'];
$id_formando = $_POST['id_formando'];
$data = date('Y-m-d');
$valorentrada = moeda($_POST['valorentrada']);
$formapagentrada = $_POST['formapagentrada'];
$formapag = $_POST['formapag'];
$qtdparcelas = $_POST['qtdparcelas'];
$diavencimento = $_POST['diavencimento'];
$datavencimento = $_POST['datavencimento'];
$tipopagamento = $_POST['tipopagamento'];
$sql_grava = mysqli_query($con, "insert into venda_avulsa (id_turma, id_formando, data, valorentrada, formapagentrada, formapag, qtd, diavencimento, datavencimento, status, tipopagamento) VALUES ('$id_turma', '$id_formando', '$data', '$valorentrada', '$formapagentrada', '$formapag', '$qtdparcelas', '$diavencimento', '$datavencimento', '1', '$tipopagamento')");
$id_gerado = $con->insert_id;
$x = $_POST['id_tipo'];
$i = 0;
$totalizador = 0;
foreach ($x as $key) {
	$id_tipo = $_POST['id_tipo'][$i];
	$valor = moeda($_POST['valor'][$i]);
	$qtdpaginas = $_POST['qtdpaginas'][$i];
	$sql_itens = mysqli_query($con, "insert into venda_avulsa_produtos (id_avulsa, id_item, valor, qtdpaginas) VALUES ('$id_gerado', '$id_tipo', '$valor', '$qtdpaginas')");
	
	$i++;
	$totalizador += $valor;
}
$y = $_POST['id_evento'];
$f = 0;
foreach ($y as $keyy) {
	$id_evento = $_POST['id_evento'][$f];
	$sql_evento = mysqli_query($con, "insert into eventos_venda_avulsa (id_evento, id_avulsa) VALUES ('$id_evento', '$id_gerado')");
	$f++;
}
$sql_atualiza = mysqli_query($con, "update venda_avulsa SET valor = '$totalizador' where id_avulsa = '$id_gerado'");

echo "<script language=\"JavaScript\">
location.href=\"gerarvenda.php?id=$id_gerado\";
</script>";
?>