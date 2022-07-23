<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

if($vetor_venda['tipopagamento'] == 2) { 

echo "<script> window.location.href='mensagemfinalizacaoalbum.php?id=$id'</script>";

} else {

if($vetor_venda['formapag'] == 3 || $vetor_venda['formapag'] == 6 || $vetor_venda['formapag'] == 7 || $vetor_venda['formapag'] == 3 || $vetor_venda['formapag'] == 14 || $vetor_venda['formapag'] == 15) {

echo "<script> window.location.href='pagamento-cartao.php?id=$id'</script>";

} if($vetor_venda['formapag'] == 2 || $vetor_venda['formapag'] == 8 || $vetor_venda['formapag'] == 9) {

echo "<script> window.location.href='remessa-boleto.php?id=$id'</script>";

} else { 

echo "<script> window.location.href='mensagemfinalizacaoalbum.php?id=$id'</script>";

}

}

?>