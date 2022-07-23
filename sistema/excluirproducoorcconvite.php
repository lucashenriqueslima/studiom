<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];

$sql_consulta = mysqli_query($con, "select * from orcamento_produto where id_item = '$id'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$sql_soma = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id'");
$vetor_soma = mysqli_fetch_array($sql_soma);

$total = $vetor_soma['total'];

$sql_update = mysqli_query($con, "update orcamento_convite SET valortotal = valortotal - $vetor_soma[total] where id_orcamento = '$id1'");

$sql_exclui = mysqli_query($con, "delete FROM orcamento_produto where id_item = '$id'");

$sql_exclui1 = mysqli_query($con, "delete FROM orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id'");

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id1'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

	if($vetor_tributos['tipo'] == 1) {

		$percentual = $vetor_tributos['valor'] / 100;
		$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;
		$totalorcamento = $vetor_soma_calculo['total'] + $valorfinalcomissao;

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$valorfinalcomissao', valortotal = '$totalorcamento' where id_orcamento = '$id1'");

	} if($vetor_tributos['tipo'] == 2) {

		$valorfinalcomissao = $vetor_soma_calculo['total'] + $vetor_tributos['valor'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$vetor_tributos[valor]', valortotal = '$valorfinalcomissao' where id_orcamento = '$id1'");

	}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

$sql_orcamento = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id1'");
$vetor_orcamento = mysqli_fetch_array($sql_orcamento);

	if($vetor_tributos1['tipo'] == 1) {

		$percentual1 = $vetor_tributos1['valor'] / 100;
		$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;
		$totalorcamento1 = $vetor_soma_calculo['total'] + $valorfinalimposto1 + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$valorfinalimposto1', valortotal = '$totalorcamento1' where id_orcamento = '$id1'");

	} if($vetor_tributos1['tipo'] == 2) {

		$valorfinalimposto1 = $vetor_soma_calculo['total'] + $vetor_tributos1['valor'] + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$vetor_tributos1[valor]', valortotal = '$valorfinalimposto1' where id_orcamento = '$id1'");

	}

     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='cadastroorcconvite_produtos.php?id=$id1'</script>";

?>