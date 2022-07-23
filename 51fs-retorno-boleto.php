<?php
include"includes/conexao.php";

if(isset($_GET['payment_date'])){
	$payment_date = substr($_GET['payment_date'],6,4) . '-' . substr($_GET['payment_date'],3,2) . '-' . substr($_GET['payment_date'],0,2);
}
if(isset($_GET['order_id'])){
	$order_id = $_GET['order_id'];
}
$id_getnet = $_GET['id'];
$amount = number_format($_GET['amount'] / 100,'2','.',',');
$status = $_GET['status'];

switch($status){
	case 'PENDING':
//		echo "pending:{$id_getnet},{$order_id}";
		mysqli_query($con, "update duplicatas_faturas SET status = '1',id_getnet='$id_getnet' where id_item = '$order_id'");
		break;
	case 'PAID':
//		echo "paid:{$payment_date},{$amount},{$id_getnet}";
		mysqli_query($con, "update duplicatas_faturas SET status = '2',datapagamento='$payment_date',valor_recebido='$amount',pagamento='1' where id_getnet = '$id_getnet'");
		break;
	case 'CANCELED':
//		echo "canceled:{$id_getnet}";
		mysqli_query($con, "update duplicatas_faturas SET status = '3',link=NULL,boleto=NULL,payment_id=NULL,pagamento=NULL where id_getnet='$id_getnet'");
		break;
	case 'DENIED':
//		echo "denied:{$order_id}";
		mysqli_query($con, "update duplicatas_faturas SET status = '4',link=NULL,boleto=NULL,payment_id=NULL where id_item = '$order_id'");
		break;
	case 'ERROR':
//		echo "error:{$order_id}";
		mysqli_query($con, "update duplicatas_faturas SET status = '5',link=NULL,boleto=NULL,payment_id=NULL where id_item = '$order_id'");
		break;
}
