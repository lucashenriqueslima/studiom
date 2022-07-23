<?php

include"../includes/conexao.php";


$id_gerado = $_GET['id'];
$id = $_GET['id1'];
$id_produto = $_POST['id_produto'];

$sql_consulta = mysqli_query($con, "select * from orcamento_produto where id_item = '$id_gerado'");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$sql_soma = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' AND id_produto = '$id_gerado'");
$vetor_soma = mysqli_fetch_array($sql_soma);

$total = $vetor_soma['total'];

$sql_update = mysqli_query($con, "update orcamento_convite SET valortotal = valortotal - $vetor_soma[total] where id_orcamento = '$id'");

$sql_exclui1 = mysqli_query($con, "delete FROM orcamento_itens where id_orcamento = '$id' AND id_produto = '$id_gerado'");

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

	if($vetor_tributos['tipo'] == 1) {

		$percentual = $vetor_tributos['valor'] / 100;
		$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;
		$totalorcamento = $vetor_soma_calculo['total'] + $valorfinalcomissao;

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$valorfinalcomissao', valortotal = '$totalorcamento' where id_orcamento = '$id1'");

	} if($vetor_tributos['tipo'] == 2) {

		$valorfinalcomissao = $vetor_soma_calculo['total'] + $vetor_tributos['valor'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$vetor_tributos[valor]', valortotal = '$valorfinalcomissao' where id_orcamento = '$id'");

	}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

$sql_orcamento = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id'");
$vetor_orcamento = mysqli_fetch_array($sql_orcamento);

	if($vetor_tributos1['tipo'] == 1) {

		$percentual1 = $vetor_tributos1['valor'] / 100;
		$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;
		$totalorcamento1 = $vetor_soma_calculo['total'] + $valorfinalimposto1 + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$valorfinalimposto1', valortotal = '$totalorcamento1' where id_orcamento = '$id'");

	} if($vetor_tributos1['tipo'] == 2) {

		$valorfinalimposto1 = $vetor_soma_calculo['total'] + $vetor_tributos1['valor'] + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$vetor_tributos1[valor]', valortotal = '$valorfinalimposto1' where id_orcamento = '$id'");

	}

if($id_produto == 2) {

$qtdconvites = $_POST['qtdconvites'];

$sql_grava = mysqli_query($con, "update orcamento_produto '$id', '$id_produto', qtd='$qtdconvites' WHERE id_item = '$id_gerado'");

$tamanho = $_POST['tamanho'];

//valor tamanho

$sql_tamanho = mysqli_query($con, "select * from tabela_basico_valores where id_basico = '$tamanho' and (qtd <= '$qtdconvites' AND qtdfinal >= '$qtdconvites')");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$sql_grava_tamanho = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '1', '$tamanho', '$vetor_tamanho[valor]')");

$embalagem = $_POST['embalagem'];

//valor embalagem

if(!empty($embalagem)) {

$sql_embalagem = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$embalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$sql_grava_embalagem = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '2', '$embalagem', '$vetor_embalagem[valor]')");

}

$x = $_POST['acabamentoembalagem'];

//valor acabamento embalagem

if(!empty($x)) {

$i = 0;

foreach($x as $keyy) {

$acabamentoembalagem = $_POST['acabamentoembalagem'][$i];

$sql_acabamentoembalagem = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_acabamentoembalagem = mysqli_fetch_array($sql_acabamentoembalagem);

$sql_grava_acabamentoembalagem = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '3', '$acabamentoembalagem', '$vetor_acabamentoembalagem[valor]')");

$i++;

}

}

$sobrecapaencarte = $_POST['sobrecapaencarte'];

//valor sobrecapa / encarte

if(!empty($sobrecapaencarte)) {

$sql_sobrecapaencarte = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_sobrecapaencarte = mysqli_fetch_array($sql_sobrecapaencarte);

$sql_grava_sobrecapaencarte = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '4', '$sobrecapaencarte', '$vetor_sobrecapaencarte[valor]')");

}

$personalizacao = $_POST['personalizacao'];
$capa = $_POST['capa'];

//valor capa

if(!empty($capa)) {

$sql_capa = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$capa' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_capa = mysqli_fetch_array($sql_capa);

$sql_grava_capa = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '5', '$capa', '$vetor_capa[valor]')");

}

$y = $_POST['acabamentocapa'];

//valor acabamento capa

if(!empty($y)) {

$f = 0;

foreach($y as $keyyy) {

$acabamentocapa = $_POST['acabamentocapa'][$f];

$sql_acabamentocapa = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentocapa' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_acabamentocapa = mysqli_fetch_array($sql_acabamentocapa);

$sql_grava_acabamentocapa = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '6', '$acabamentocapa', '$vetor_acabamentocapa[valor]')");

$f++;

}

}

//valor paginas padrão

if(!empty($paginasextraspersonalizadas)) {

$sql_paginaspadrao = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$paginasextraspersonalizadas' and (qtd <= '$qtdpaginasextraspersonalizadas' AND qtdfim >= '$qtdpaginasextraspersonalizadas')");
$vetor_paginaspadrao = mysqli_fetch_array($sql_paginaspadrao);

$sql_grava_paginaspadrao = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdpaginasextraspersonalizadas', '7', '$paginasextraspersonalizadas', '$vetor_paginaspadrao[valor]')");

}

$paginasextras = $_POST['paginasextras'];
$qtdpaginasextras = $_POST['qtdpaginasextras'];

//valor paginas extras

if(!empty($paginasextras)) {

$sql_paginasextras = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$paginasextras' and (qtd <= '$qtdpaginasextras' AND qtdfim >= '$qtdpaginasextras')");
$vetor_paginasextras = mysqli_fetch_array($sql_paginasextras);

$sql_grava_paginasextras = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdpaginasextras', '7', '$paginasextras', '$vetor_paginasextras[valor]')");

}

$miniposter = $_POST['miniposter'];
$qtdminiposter = $_POST['qtdminiposter'];

//valor paginas mini poster

if(!empty($miniposter)) {

$sql_miniposter = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$miniposter' and (qtd <= '$qtdminiposter' AND qtdfim >= '$qtdminiposter')");
$vetor_miniposter = mysqli_fetch_array($sql_miniposter);

$sql_grava_miniposter = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdminiposter', '7', '$miniposter', '$vetor_miniposter[valor]')");

}

$paginasextraspersonalizadas = $_POST['paginasextraspersonalizadas'];
$qtdpaginasextraspersonalizadas = $_POST['qtdpaginasextraspersonalizadas'];

//valor paginas extras personalizadas

if(!empty($paginasextraspersonalizadas)) {

$sql_paginasextraspersonalizadas = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$paginasextraspersonalizadas' and (qtd <= '$qtdpaginasextraspersonalizadas' AND qtdfim >= '$qtdpaginasextraspersonalizadas')");
$vetor_paginasextraspersonalizadas = mysqli_fetch_array($sql_paginasextraspersonalizadas);

$sql_grava_paginasextraspersonalizadas = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdpaginasextraspersonalizadas', '7', '$paginasextraspersonalizadas', '$vetor_paginasextraspersonalizadas[valor]')");

}

$vegetalcomum = $_POST['vegetalcomum'];
$qtdvegetalcomum = $_POST['qtdvegetalcomum'];

//valor vegetal comum

if(!empty($vegetalcomum)) {

$sql_vegetalcomum = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$vegetalcomum' and (qtd <= '$qtdvegetalcomum' AND qtdfim >= '$qtdvegetalcomum')");
$vetor_vegetalcomum = mysqli_fetch_array($sql_vegetalcomum);

$sql_grava_vegetalcomum = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdvegetalcomum', '7', '$vegetalcomum', '$vetor_vegetalcomum[valor]')");

}

$vegetalpersonalizado = $_POST['vegetalpersonalizado'];
$qtdvegetalpersonalizado = $_POST['qtdvegetalpersonalizado'];

//valor vegetal personalizado

if(!empty($vegetalpersonalizado)) {

$sql_vegetalpersonalizado = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$vegetalpersonalizado' and (qtd <= '$qtdvegetalpersonalizado' AND qtdfim >= '$qtdvegetalpersonalizado')");
$vetor_vegetalpersonalizado = mysqli_fetch_array($sql_vegetalpersonalizado);

$sql_grava_vegetalpersonalizado = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdvegetalpersonalizado', '7', '$vegetalpersonalizado', '$vetor_vegetalpersonalizado[valor]')");

}

$acetatocomum = $_POST['acetatocomum'];
$qtdacetatocomum = $_POST['qtdacetatocomum'];

//valor acetato comum

if(!empty($acetatocomum)) {

$sql_acetatocomum = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acetatocomum' and (qtd <= '$qtdacetatocomum' AND qtdfim >= '$qtdacetatocomum')");
$vetor_acetatocomum = mysqli_fetch_array($sql_acetatocomum);

$sql_grava_acetatocomum = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdacetatocomum', '7', '$acetatocomum', '$vetor_acetatocomum[valor]')");

}

$acetatopersonalizado = $_POST['acetatopersonalizado'];
$qtdacetatopersonalizado = $_POST['qtdacetatopersonalizado'];

//valor acetato comum

if(!empty($acetatopersonalizado)) {

$sql_acetatopersonalizado = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acetatopersonalizado' and (qtd <= '$qtdacetatopersonalizado' AND qtdfim >= '$qtdacetatopersonalizado')");
$vetor_acetatopersonalizado = mysqli_fetch_array($sql_acetatopersonalizado);

$sql_grava_acetatopersonalizado = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdacetatopersonalizado', '7', '$acetatopersonalizado', '$vetor_acetatopersonalizado[valor]')");

}

$opcostura = $_POST['opcostura'];

//valor Costura opcional

if(!empty($opcostura)) {

$sql_opcostura = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opcostura' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opcostura = mysqli_fetch_array($sql_opcostura);

$sql_grava_opcostura = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opcostura', '$vetor_opcostura[valor]')");

}

$opcinta = $_POST['opcinta'];

//valor Cinta opcional

if(!empty($opcinta)) {

$sql_opcinta = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opcinta' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opcinta = mysqli_fetch_array($sql_opcinta);

$sql_grava_opcinta = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opcinta', '$vetor_opcinta[valor]')");

}

$opcosturaespecial = $_POST['opcosturaespecial'];

//valor Costura Especial opcional

if(!empty($opcosturaespecial)) {

$sql_opcosturaespecial = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opcosturaespecial' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opcosturaespecial = mysqli_fetch_array($sql_opcosturaespecial);

$sql_grava_opcosturaespecial = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opcosturaespecial', '$vetor_opcosturaespecial[valor]')");

}

$opjanelaacrilico = $_POST['opjanelaacrilico'];

//valor Janela Acrílico opcional

if(!empty($opjanelaacrilico)) {

$sql_opjanelaacrilico = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opjanelaacrilico' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opjanelaacrilico = mysqli_fetch_array($sql_opjanelaacrilico);

$sql_grava_opjanelaacrilico = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opjanelaacrilico', '$vetor_opjanelaacrilico[valor]')");

}

$opinsertacrilico = $_POST['opinsertacrilico'];

//valor insert Acrílico opcional

if(!empty($opinsertacrilico)) {

$sql_opinsertacrilico = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opinsertacrilico' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opinsertacrilico = mysqli_fetch_array($sql_opinsertacrilico);

$sql_grava_opinsertacrilico = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opinsertacrilico', '$vetor_opinsertacrilico[valor]')");

}

$ophotstamping = $_POST['ophotstamping'];

//valor hot stamping opcional

if(!empty($ophotstamping)) {

$sql_ophotstamping = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$ophotstamping' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_ophotstamping = mysqli_fetch_array($sql_ophotstamping);

$sql_grava_ophotstamping = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$ophotstamping', '$vetor_ophotstamping[valor]')");

}

$opbaixorelevo = $_POST['opbaixorelevo'];

//valor baixo relevo opcional

if(!empty($opbaixorelevo)) {

$sql_opbaixorelevo = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opbaixorelevo' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opbaixorelevo = mysqli_fetch_array($sql_opbaixorelevo);

$sql_grava_opbaixorelevo = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opbaixorelevo', '$vetor_opbaixorelevo[valor]')");

}

$opvernizlocalizado = $_POST['opvernizlocalizado'];

//valor verniz localizado opcional

if(!empty($opvernizlocalizado)) {

$sql_opvernizlocalizado = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opvernizlocalizado' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opvernizlocalizado = mysqli_fetch_array($sql_opvernizlocalizado);

$sql_grava_opvernizlocalizado = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opvernizlocalizado', '$vetor_opvernizlocalizado[valor]')");

}

$opcortealaser = $_POST['opcortealaser'];

//valor corte a laser opcional

if(!empty($opcortealaser)) {

$sql_opcortealaser = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opcortealaser' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opcortealaser = mysqli_fetch_array($sql_opcortealaser);

$sql_grava_opcortealaser = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opcortealaser', '$vetor_opcortealaser[valor]')");

}

$opgravacaoalaser = $_POST['opgravacaoalaser'];

//valor corte a laser opcional

if(!empty($opgravacaoalaser)) {

$sql_opgravacaoalaser = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opgravacaoalaser' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opgravacaoalaser = mysqli_fetch_array($sql_opgravacaoalaser);

$sql_grava_opgravacaoalaser = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opgravacaoalaser', '$vetor_opgravacaoalaser[valor]')");

}

$opmedalhademetal = $_POST['opmedalhademetal'];

//valor medalha de metal opcional

if(!empty($opmedalhademetal)) {

$sql_opmedalhademetal = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opmedalhademetal' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opmedalhademetal = mysqli_fetch_array($sql_opmedalhademetal);

$sql_grava_opmedalhademetal = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opmedalhademetal', '$vetor_opmedalhademetal[valor]')");

}

$opsuporteacrilico = $_POST['opsuporteacrilico'];

//valor suporte acrilico opcional

if(!empty($opsuporteacrilico)) {

$sql_opsuporteacrilico = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opsuporteacrilico' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opsuporteacrilico = mysqli_fetch_array($sql_opsuporteacrilico);

$sql_grava_opsuporteacrilico = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opsuporteacrilico', '$vetor_opsuporteacrilico[valor]')");

}

$opaplicacaoacrilico = $_POST['opaplicacaoacrilico'];

//valor aplicação acrilico opcional

if(!empty($opaplicacaoacrilico)) {

$sql_opaplicacaoacrilico = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opaplicacaoacrilico' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opaplicacaoacrilico = mysqli_fetch_array($sql_opaplicacaoacrilico);

$sql_grava_opaplicacaoacrilico = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opaplicacaoacrilico', '$vetor_opaplicacaoacrilico[valor]')");

}

$opsuportemadeira = $_POST['opsuportemadeira'];

//valor suporte madeira opcional

if(!empty($opsuportemadeira)) {

$sql_opsuportemadeira = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$opsuportemadeira' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_opsuportemadeira = mysqli_fetch_array($sql_opsuportemadeira);

$sql_grava_opsuportemadeira = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '8', '$opsuportemadeira', '$vetor_opsuportemadeira[valor]')");

}

$sql_soma = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' AND id_produto = '$id_gerado'");
$vetor_soma = mysqli_fetch_array($sql_soma);

$sql_atualiza = mysqli_query($con, "update orcamento_convite SET valortotal = valortotal + $vetor_soma[total] where id_orcamento = '$id'");


} if($id_produto == 4) {

$qtdconvites = $_POST['qtdconvites1'];

$sql_grava = mysqli_query($con, "update orcamento_produto '$id', '$id_produto', qtd='$qtdconvites' WHERE id_item = '$id_gerado'");

$tamanho = $_POST['tamanho1'];

//valor tamanho

$sql_tamanho = mysqli_query($con, "select * from tabela_basico_valores where id_basico = '$tamanho' and (qtd <= '$qtdconvites' AND qtdfinal >= '$qtdconvites')");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$sql_grava_tamanho = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '1', '$tamanho', '$vetor_tamanho[valor]')");

$embalagem = $_POST['embalagem1'];

if(!empty($embalagem)) {

$sql_embalagem = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$embalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$sql_grava_embalagem = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '2', '$embalagem', '$vetor_embalagem[valor]')");

}

$x = $_POST['acabamentoembalagem1'];

//valor acabamento embalagem

if(!empty($x)) {

$i = 0;

foreach($x as $keyy) {

$acabamentoembalagem = $_POST['acabamentoembalagem1'][$i];

$sql_acabamentoembalagem = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_acabamentoembalagem = mysqli_fetch_array($sql_acabamentoembalagem);

$sql_grava_acabamentoembalagem = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '3', '$acabamentoembalagem', '$vetor_acabamentoembalagem[valor]')");

$i++;

}

}

$paginas = $_POST['paginas'];

//valor paginas

if(!empty($paginas)) {

$sql_paginas = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_paginas = mysqli_fetch_array($sql_paginas);

$sql_grava_paginas = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '10', '$paginas', '$vetor_paginas[valor]')");

}

$sql_soma = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' AND id_produto = '$id_gerado'");
$vetor_soma = mysqli_fetch_array($sql_soma);

$sql_atualiza = mysqli_query($con, "update orcamento_convite SET valortotal = valortotal + $vetor_soma[total] where id_orcamento = '$id'");


}


$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

	if($vetor_tributos['tipo'] == 1) {

		$percentual = $vetor_tributos['valor'] / 100;
		$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;
		$totalorcamento = $vetor_soma_calculo['total'] + $valorfinalcomissao;

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$valorfinalcomissao', valortotal = '$totalorcamento' where id_orcamento = '$id'");

	} if($vetor_tributos['tipo'] == 2) {

		$valorfinalcomissao = $vetor_soma_calculo['total'] + $vetor_tributos['valor'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET comissao = '$vetor_tributos[valor]', valortotal = '$valorfinalcomissao' where id_orcamento = '$id'");

	}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

$sql_orcamento = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id'");
$vetor_orcamento = mysqli_fetch_array($sql_orcamento);

	if($vetor_tributos1['tipo'] == 1) {

		$percentual1 = $vetor_tributos1['valor'] / 100;
		$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;
		$totalorcamento1 = $vetor_soma_calculo['total'] + $valorfinalimposto1 + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$valorfinalimposto1', valortotal = '$totalorcamento1' where id_orcamento = '$id'");

	} if($vetor_tributos1['tipo'] == 2) {

		$valorfinalimposto1 = $vetor_soma_calculo['total'] + $vetor_tributos1['valor'] + $vetor_orcamento['comissao'];

		$sql_atualiza = mysqli_query($con, "update orcamento_convite SET imposto = '$vetor_tributos1[valor]', valortotal = '$valorfinalimposto1' where id_orcamento = '$id'");

	}




echo"<script language=\"JavaScript\">
location.href=\"cadastroorcconvite_produtos.php?id=$id\";
</script>";

?>