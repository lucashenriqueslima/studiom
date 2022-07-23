<?php
include"../includes/conexao.php";

$payment_type = $_GET['payment_type'];
$customer_id = $_GET['customer_id'];
$order_id = $_GET['order_id'];
$payment_id = $_GET['payment_id'];
$amount = number_format($_GET['amount'],'2','.',',');
$status = $_GET['status'];
$number_installments = $_GET['number_installments'];
$acquirer_transaction_id = $_GET['acquirer_transaction_id'];
$authorization_timestamp = substr($_GET['authorization_timestamp'],0,10);
$dataatual = date('Y-m-d');
$vetor = mysqli_fetch_array(mysqli_query($con, "select * from duplicatas where id_venda = '$customer_id'"));

if($status == 'APPROVED' || $status == 'AUTHORIZED') {
//	echo "aprovado atualiza vendas com id = {$customer_id}<br> Atualiza todos os boletos com id_duplicata = {$vetor['id_duplicata']} para valor={$amount},datapagameno=[$authorization_timestamp]";
	$sql_venda = mysqli_query($con, "update vendas SET pagamento = '1' where id_venda = '$customer_id'");
	$sql_venda = mysqli_query($con, "update duplicatas_faturas SET valor_recebido='$amount',datapagamento='$authorization_timestamp',pagamento='1',status='2' where id_duplicata = '$vetor[id_duplicata]'");
}else {
	if ($status == 'DENIED') {
		$cod_status = 4;
	}
	if ($status == 'CANCELED') {
		$cod_status = 3;
	}
	if ($status == 'ERROR') {
		$cod_status = 5;
	}
//	echo "negado atualiza duplicatas_faturas com id_duplicata = {$vetor['id_duplicata']}";
	$sql_faturas = mysqli_query($con, "update duplicatas_faturas SET status = '$cod_status' where id_duplicata = '$vetor[id_duplicata]'");
}
