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
$titulo = ucwords(strtolower($_POST['titulo']));
$descricao = $_POST['descricao'];
$valor = moeda($_POST['valor']);
$valorcomissao = moeda($_POST['valorcomissao']);
$pacote_especial = $_POST['pacote_especial'];
if($pacote_especial != 2){
    $qtdparcelas = $_POST['qtdparcelas'];
    $tamanho = 0;
}else{
    $qtdparcelas = 0;
    $tamanho = $_POST['tamanho'];
}
if(isset($_POST['data_limite']) && $_POST['data_limite']!= null){
	$data_limite = $_POST['data_limite'];
	$res_ref = mysqli_query($con, "insert into pacotes_itens_album (id_pacote, titulo, descricao, tamanho, valor, valorcomissao,pacote_especial,qtdparcelas,data_limite) VALUES ('$id', '$titulo', '$descricao', '$tamanho', '$valor', '$valorcomissao','$pacote_especial','$qtdparcelas','".$data_limite."')") or die (mysqli_error($con));
}else{
	$data_limite = "NULL";
	$res_ref = mysqli_query($con, "insert into pacotes_itens_album (id_pacote, titulo, descricao, tamanho, valor, valorcomissao,pacote_especial,qtdparcelas,data_limite) VALUES ('$id', '$titulo', '$descricao', '$tamanho', '$valor', '$valorcomissao','$pacote_especial','$qtdparcelas',".$data_limite.")") or die (mysqli_error($con));
}
$id_pacote_itens = $con->insert_id;

if($pacote_especial != 2){
		$vetor = mysqli_fetch_array(mysqli_query($con,"select id_tipo from tipo_opcionais where tipo_produto = '$pacote_especial'"));
		$tipo_opcional = $vetor['id_tipo'];
		mysqli_query($con, "insert into pacotes_itens_produtos (id_pacote, id_produto, qtdpaginas) VALUES ('$id_pacote_itens', '$tipo_opcional', '1')");
		mysqli_query($con, "insert into formaspag_pacote (id_pacote, id_forma, descricao) VALUES ('$id_pacote_itens', '2', '')");
		mysqli_query($con, "insert into formaspag_pacote (id_pacote, id_forma, descricao) VALUES ('$id_pacote_itens', '3', '')");
		mysqli_query($con, "insert into formaspag_pacote (id_pacote, id_forma, descricao) VALUES ('$id_pacote_itens', '18', '')");
		if($pacote_especial == 3){
			mysqli_query($con, "insert into formaspag_pacote (id_pacote, id_forma, descricao) VALUES ('$id_pacote_itens', '22', '')");
		}
}
echo "<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id_pacote_itens&id1=$id\";
</script>";
?>