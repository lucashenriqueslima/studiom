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
$titulo = ucwords(strtolower($_POST['titulo']));
$sql = mysqli_query($con, "update pacotes_turma SET titulo='{$titulo}' where id_pacote = '{$id}'");
$id_cadastro = $con->insert_id;
$x = $_POST['id_tipo'];
$i = 0;
foreach ($x as &$key) {
	$id_tipo = $_POST['id_tipo'][$i];
	$qtdminima = $_POST['qtdminima'][$i];
	$valorun = moeda($_POST['valorun'][$i]);
	if ($id_tipo == '') {
	}else {
		$sql_ref = "insert into pacotes_itens (id_pacote, id_tipo, qtdminima, valorun,status) VALUES ('{$id}', '{$id_tipo}', '{$qtdminima}', '{$valorun}','1')";
		$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));
	}
	$i++;
}
echo "<script language=\"JavaScript\">
location.href=\"alterarproduto.php?id=$id1\";
</script>";
?>