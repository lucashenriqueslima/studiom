<?php
include "../includes/conexao.php";
function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}
if (isset($_GET['remover'])) {
    $remover = $_GET['remover'];
    mysqli_query($con,"update tipos_pagamento set status='0' where id_tipo_pagamento='$remover'");
}elseif(isset($_GET['alterar'])){
    $alterar = $_GET['alterar'];
		$tipo = $_POST['tipo'];
		$nome = ucwords(strtolower($_POST['nome']));
		$conta = $_POST['conta'];
		$formapag = $_POST['formapag'];
		$qtdparcelas = $_POST['qtdparcelas'];
		$compensacao = $_POST['compensacao'];
		$porcentagem = moeda(str_replace('%','',$_POST['porcentagem']));
		$valor = moeda($_POST['valor']);
    mysqli_query($con,"update tipos_pagamento set tipo='$tipo',nome='$nome',id_conta='$conta',id_formapag='$formapag',qtd_parcelas='$qtdparcelas',compensacao='$compensacao',valor='$valor',porcentagem='$porcentagem' where id_tipo_pagamento='$alterar'");
}else{
    $tipo = $_POST['tipo'];
    $nome = ucwords(strtolower($_POST['nome']));
    $conta = $_POST['conta'];
    $formapag = $_POST['formapag'];
    $qtdparcelas = $_POST['qtdparcelas'];
    $compensacao = $_POST['compensacao'];
    $porcentagem = moeda(str_replace('%','',$_POST['porcentagem']));
    $valor = moeda($_POST['valor']);
    $sql = mysqli_query($con,"insert into tipos_pagamento (tipo,nome,id_conta,id_formapag,qtd_parcelas,compensacao,valor,porcentagem,status)VALUES('$tipo','$nome','$conta','$formapag','$qtdparcelas','$compensacao','$valor','$porcentagem','1')");
}
echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch5\";
</script>";
?>
