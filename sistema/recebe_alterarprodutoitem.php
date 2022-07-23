<?php
function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

include "../includes/conexao.php";
$id = $_GET['id'];
$id1 = $_GET['id1'];
$id_tipo = $_POST['id_tipo'];
$qtdminima = $_POST['qtdminima'];
$valorun = moeda($_POST['valorun']);
$sql_ref = "update produtos_turma_item SET id_tipo='$id_tipo', qtdminima='$qtdminima', valorun='$valorun' where id_item = '$id'";
$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));
echo "<script language=\"JavaScript\">
location.href=\"alterarproduto.php?id=$id1\";
</script>";
?>