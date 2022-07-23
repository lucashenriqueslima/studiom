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
$descricao = $_POST['descricao'];
$valor = moeda($_POST['valor']);
$valorcomissao = moeda($_POST['valorcomissao']);
if(isset($_POST['qtdparcelas']) && $_POST['qtdparcelas'] != ''){
    $qtdparcelas = $_POST['qtdparcelas'];
    $tamanho = 0;
}else{
    $qtdparcelas = 0;
    $tamanho = $_POST['tamanho'];
}
if(isset($_POST['data_limite']) && $_POST['data_limite'] != ''){
	$data_limite = "'".$_POST['data_limite']."'";
}else{
	$data_limite = 'NULL';
}
$res_ref = mysqli_query($con, "update pacotes_itens_album SET qtdparcelas='$qtdparcelas',titulo='$titulo', descricao='$descricao', tamanho='$tamanho', valor='$valor', valorcomissao='$valorcomissao',data_limite=$data_limite where id_item = '$id'") or die (mysqli_error($con));
echo "<script language=\"JavaScript\">
location.href=\"alterarpacote.php?id=$id1\";
</script>";

?>