<?php



session_start();

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$data = date('Y-m-d');
$hora = date('H:i:s');

$sql_consulta = mysqli_query($con, "select v.*,d.id_duplicata from vendas v left join duplicatas d on d.id_venda=v.id_venda where v.id_venda = '$id'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$descricao = "Cancelamento de Venda: ".$id;

$sql_log = mysqli_query($con, "insert into logs (id_usuario, descricao, data, hora) VALUES ('$_SESSION[id]', '$descricao', '$data', '$hora')");

$res2 = mysqli_query($con, "update vendas set status = '4' where id_venda = '$id'");
$res3 = mysqli_query($con, "update duplicatas_faturas set status = '3' where id_duplicata = '$vetor_consulta[id_duplicata]'");

     echo "<script> alert('Cancelado com sucesso!')</script>";
	 echo "<script> window.location.href='vendas_exclusao.php'</script>";

?>