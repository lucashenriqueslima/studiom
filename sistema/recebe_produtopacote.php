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
$sql = mysqli_query($con, "insert into pacotes_turma (id_produto)VALUES('{$id}')");
$id_cadastro = $con->insert_id;
$x = $_POST['id_tipo'];
$i = 0;
foreach ($x as $key) {
	$id_tipo = $_POST['id_tipo'][$i];
	$res_ref = mysqli_query($con, "insert into pacotes_itens (id_pacote, id_tipo,status) VALUES ('{$id_cadastro}', '{$id_tipo}','1')");
	$i++;
}
echo "<script language=\"JavaScript\">
location.href=\"alterarproduto.php?id=$id\";
</script>";
?>