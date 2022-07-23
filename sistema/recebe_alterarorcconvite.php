<?php

function getListaDiasFeriado($ano = null) {

    if ($ano === null) {
        $ano = intval(date('Y'));
    }

    $pascoa = easter_date($ano); // retorna data da pascoa do ano especificado
    $diaPascoa = date('j', $pascoa);
    $mesPacoa = date('n', $pascoa);
    $anoPascoa = date('Y', $pascoa);

    $feriados = [
        // Feriados nacionais fixos
        mktime(0, 0, 0, 1, 1, $ano),   // Confraternização Universal
        mktime(0, 0, 0, 4, 21, $ano),  // Tiradentes
        mktime(0, 0, 0, 5, 1, $ano),   // Dia do Trabalhador
        mktime(0, 0, 0, 9, 7, $ano),   // Dia da Independência
        mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida
        mktime(0, 0, 0, 11, 2, $ano),  // Todos os santos
        mktime(0, 0, 0, 11, 15, $ano), // Proclamação da republica
        mktime(0, 0, 0, 12, 25, $ano), // Natal
        mktime(0, 0, 0, 10, 22, $ano), // Avulso
        //
        // Feriados variaveis
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 48, $anoPascoa), // 2º feria Carnaval
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 47, $anoPascoa), // 3º feria Carnaval 
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 2, $anoPascoa),  // 6º feira Santa  
        mktime(0, 0, 0, $mesPacoa, $diaPascoa, $anoPascoa),      // Pascoa
        mktime(0, 0, 0, $mesPacoa, $diaPascoa + 60, $anoPascoa), // Corpus Christ
    ];

    sort($feriados);

    $listaDiasFeriado = [];
    foreach ($feriados as $feriado) {
        $data = date('Y-m-d', $feriado);
        $listaDiasFeriado[$data] = $data;
    }

    return $listaDiasFeriado;
}

function isFeriado($data) {
    $listaFeriado = getListaDiasFeriado(date('Y', strtotime($data)));
    if (isset($listaFeriado[$data])) {
        return true;
    }

    return false;
}

function getDiasUteis($aPartirDe, $quantidadeDeDias = 30) {
    $dateTime = new DateTime($aPartirDe);

    $listaDiasUteis = [];
    $contador = 0;
    while ($contador < $quantidadeDeDias) {
        $dateTime->modify('-1 weekday'); // adiciona um dia pulando finais de semana
        $data = $dateTime->format('Y-m-d');
        if (!isFeriado($data)) {
            $listaDiasUteis[] = $data;
            $contador++;
        }
    }

    return $listaDiasUteis;
}

include"../includes/conexao.php";


$id = $_GET['id'];
$id_oportunidade = $_POST['id_oportunidade'];
$qtdformandos = $_POST['qtdformandos'];
$id_job = $_POST['id_job'];
$id_produto = $_POST['id_produto'];
$dataentrega = $_POST['dataentrega'];

$dataenviomaterial_gera = getDiasUteis($dataentrega, 22);
$dataenviomaterial = end($dataenviomaterial_gera);

$dataaprovacaofinal_gera = getDiasUteis($dataenviomaterial, 22);
$dataaprovacaofinal = end($dataaprovacaofinal_gera);

$datalimiteconvextras_gera = getDiasUteis($dataaprovacaofinal, 66);
$datalimiteconvextras = end($datalimiteconvextras_gera);

$prazolimiteentrega_gera = getDiasUteis($dataaprovacaofinal, 66);
$prazolimiteentrega = end($prazolimiteentrega_gera);

$datafotografia_gera = getDiasUteis($prazolimiteentrega, 22);
$datafotografia = end($datafotografia_gera);

$confeccaotematica_gera = getDiasUteis($datafotografia, 44);
$confeccaotematica = end($confeccaotematica_gera);

$qtdparcelas = $_POST['qtdparcelas'];
$id_forma = $_POST['id_forma'];
$validadeproposta = $_POST['validadeproposta'];

$sql = mysqli_query($con, "update orcamento_convite SET id_oportunidade = '$id_oportunidade', qtdformandos = '$qtdformandos', id_job='$id_job', dataentrega = '$dataentrega', confeccaotematica='$confeccaotematica', prazolimiteentrega='$prazolimiteentrega', datalimiteconvextras='$datalimiteconvextras', dataaprovacaofinal='$dataaprovacaofinal', dataenviomaterial='$dataenviomaterial', datafotografia='$datafotografia', qtdparcelas='$qtdparcelas', id_forma='$id_forma', validadeproposta='$validadeproposta' where id_orcamento = '$id'");

$sql_consulta = mysqli_query($con, "select * from orcamento_produto where id_orcamento = '$id' and id_produto = '$id_produto'");

$tipo = $_POST['tipo'];

if(!empty($tipo)) {

	$tip = 0;

	foreach($tipo as $keyyyyy) {

		$tipo = $_POST['tipo'][$tip];
		$tipoconvite = $_POST['tipoconvite'][$tip];
		$cod_produto = explode('_', $tipoconvite);
		$id_item_item = $cod_produto[0];
		$id_produto_item = $cod_produto[1];
		$qtd = $_POST['qtd'][$tip];

		$sql_consultar = mysqli_query($con, "select * from orcamento_extras where id_orcamento = '$id' and tipoconvite = '$id_item' and tipo = '$tipo'");

		if($tipo > 0) { 

		if(mysqli_num_rows($sql_consultar) == 0) {

		$sqltipos = mysqli_query($con, "insert into orcamento_extras (id_orcamento, tipo, tipoconvite, id_produto, qtd) VALUES ('$id', '$tipo', '$id_item_item', '$id_produto_item', '$qtd')");

		}

		}

		$tip++;

	}

}

if($id_produto == 2) {

$qtdconvites = $_POST['qtdconvites'];

$sql_grava = mysqli_query($con, "insert into orcamento_produto (id_orcamento, id_produto, qtd) VALUES ('$id', '$id_produto', '$qtdconvites')");
$id_gerado = $con->insert_id;

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

$v = $_POST['acabamentoexternoembalagem'];

//valor acabamento embalagem

if(!empty($v)) {

$ta = 0;

foreach($v as $keyyv) {

$acabamentoexternoembalagem = $_POST['acabamentoexternoembalagem'][$ta];

$sql_acabamentoembalagem = mysqli_query($con, "select * from tabela_basico_acabamentos where id_itemtabela = '$acabamentoexternoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_acabamentoembalagem = mysqli_fetch_array($sql_acabamentoembalagem);

$sql_grava_acabamentoembalagem = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '3', '$acabamentoexternoembalagem', '$vetor_acabamentoembalagem[valor]')");

$ta++;

}

}

$sobrecapaencarte = $_POST['sobrecapaencarte'];

//valor sobrecapa / encarte

if(!empty($sobrecapaencarte)) {

$sql_sobrecapaencarte = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '$acabamentoembalagem' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
$vetor_sobrecapaencarte = mysqli_fetch_array($sql_sobrecapaencarte);

$sql_grava_sobrecapaencarte = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '4', '$sobrecapaencarte', '$vetor_sobrecapaencarte[valor]')");

}

$personalizada = $_POST['personalizada'];

if(!empty($personalizada)) {

	if($personalizada == 1) {

		$sql_personalizada = mysqli_query($con, "select * from tabela_basico_itens where id_itemtabela = '76' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
		$vetor_personalizada = mysqli_fetch_array($sql_personalizada);

		$sql_grava_sobrecapaencarte = mysqli_query($con, "insert into orcamento_itens (id_orcamento, id_produto, qtd, id_tipo, id_itemtabela, valorun) VALUES ('$id', '$id_gerado', '$qtdconvites', '4', '76', '$vetor_personalizada[valor]')");

	}

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

$sql_acabamentocapa = mysqli_query($con, "select * from tabela_basico_acabamentos where id_itemtabela = '$acabamentocapa' and (qtd <= '$qtdconvites' AND qtdfim >= '$qtdconvites')");
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

$sql_soma = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' AND id_produto = '$id_gerado'");
$vetor_soma = mysqli_fetch_array($sql_soma);

$sql_atualiza = mysqli_query($con, "update orcamento_convite SET valortotal = valortotal + $vetor_soma[total] where id_orcamento = '$id'");


} if($id_produto == 4) {

$qtdconvites = $_POST['qtdconvites1'];

$sql_grava = mysqli_query($con, "insert into orcamento_produto (id_orcamento, id_produto, qtd) VALUES ('$id', '$id_produto', '$qtdconvites')");
$id_gerado = $con->insert_id;

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