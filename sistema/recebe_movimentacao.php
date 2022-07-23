<?php
include "../includes/conexao.php";
session_start();
$id_usuario = $_SESSION['id'];
function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

if (isset($_POST['editar'])) {
	$id = $_POST['editar'];
	$vetor = mysqli_fetch_array(mysqli_query($con, "select * from lancamentos where id_lancamento = '$id'"));
	if ($vetor['valor'] > 0) {
		$tipo_lancamento = 'receita';
	}else {
		$tipo_lancamento = 'despesa';
	}
	echo $tipo_lancamento."|".$vetor['id_fornecedor']."|".$vetor['categoria_fornecedor'].";".$vetor['id_catconta']."|".$vetor['id_centro']."|".$vetor['titulo']."|".$vetor['id_tipo_pagamento']."|".$vetor['id_conta']."|".$vetor['id_turma']."|".substr($vetor['data_competencia'],0,7)."|".$vetor['data_emissao']."|".$vetor['data_vencimento']."|".number_format(abs((float)$vetor['valor']), 2, ',', '.');
}
if (isset($_GET['excluir'])) {
	$id = $_GET['excluir'];
	$movimentacao = mysqli_query($con, "update movimentacao_financeira set status='0',usuario_cancelamento='$id_usuario' where id_lancamento='$id' and status = '1'");
	$lancamento = mysqli_query($con, "update lancamentos set status='0' where id_lancamento='$id'");
	$vetor = mysqli_fetch_array(mysqli_query($con, "select cp.*,cc3.nome as centronome,c.nome as fornecedor,cf.nome as titulo_fornecedor,cc.numeracao, t.ncontrato from lancamentos cp
                                                        left join turmas t on t.id_turma = cp.id_turma
                                                        left join clientes c on c.id_cli = cp.id_fornecedor
                                                        left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                                                        left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                                                        left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                                                        left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                                                        where cp.id_lancamento = '$id'"));
	echo ($vetor['ncontrato'] != null ? $vetor['ncontrato'] : 'Custo Fixo') . ';' . $vetor['centronome'] . ';' . $vetor['titulo_fornecedor'].' - '.ucwords(strtolower($vetor['fornecedor'])).($vetor['titulo'] == '' ? '' : '<br>'.$vetor['titulo'])
		. ';' . date('d/m/Y', strtotime($vetor['data_vencimento'])) . ';' . $vetor['valor']  . ';'
		.'<button type="button" class="btn btn-info btn-md" title="Dar Baixa" onclick="abreModal('.$vetor['id_lancamento']. ",'2'" .')">
       	<span><i class="fas fa-hand-holding-usd fa-lg"></i></span>
      </button>
			<button id="inserir'.$vetor['id_lancamento'].'" type="button" class="btn btn-success" title="Inserir Arquivo" onclick="abreModal('.$vetor['id_lancamento']. ",'4'" .')"'. (!($vetor['arquivo'] == '')?"hidden":'').'>
      	<span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
      </button>
			<a href="'.(($vetor['arquivo'] != null)?'arquivos'.$vetor['arquivo']:"").'" target="_blank" id="arq'.$vetor['id_lancamento'].'" '.(($vetor['arquivo'] == null)?'hidden':'').'>
      <button type="button" class="btn btn-warning"
              title="Ver Arquivo">
          <span><i class="fas fa-file-alt fa-lg"></i></span>
      </button>
			</a>
			<button id="exclui'.$vetor['id_lancamento'].'"
			        type="button" class="btn btn-danger"
			        title="Excluir Arquivo"
			        onclick="excluirArquivo('.$vetor['id_lancamento'].')" '.(!($vetor['arquivo'] != '')?"hidden":"").'>
			    <span><i class="fas fa-times fa-lg"></i></span>
			</button>
			<button type="button" class="btn btn-danger btn-md"
			        title="Desativar Lançamento"
			        onclick="desativarLancamento('.$vetor['id_lancamento'].')">
			    <span><i class="far fa-trash-alt"></i></span>
			</button>';
	die();
}
if (isset($_GET['modificardata'])) {
	$id = $_POST['id_movimentacao'];
	$nova_data = $_POST['nova_data'];
	$movimentacao = mysqli_query($con, "update movimentacao_financeira set data='{$nova_data}' where id_movimentacao='{$id}' and status = '1'");
	echo date('d/m/Y',strtotime($nova_data));
	die();
}
if (isset($_POST['id_duplicata']) && isset($_POST['detalhes'])) {
	$id_duplicata = $_POST['id_duplicata'];
	$id_duplicata = explode(";", $id_duplicata);
	$vetor = mysqli_fetch_array(mysqli_query($con, "select f.nome as fnome,df.data,df.posicao,v.qtdparcelas,df.valor,df.formapag,fp.nome as fpnome,t.ncontrato,f.id_cadastro,v.qtdparcelas from duplicatas_faturas df
																												left join duplicatas d on d.id_duplicata = df.id_duplicata
																												left join	vendas v on v.id_venda = d.id_venda
																												left join formandos f on f.id_formando = v.id_formando
																												left join turmas t on t.id_turma = f.turma
																												left join formaspag fp on fp.id_forma = df.formapag
																												left join fomentos f2 on f2.id_fomento = df.id_fomento
																												left join movimentacao_financeira mf on mf.id_duplicata = df.id_item
																												where df.id_item = '{$id_duplicata[1]}' and mf.id_movimentacao = '{$id_duplicata[0]}'"));
	if ($vetor['valor'] > 0) {
		$sql_tipo_pagamento = mysqli_query($con, "select * from tipos_pagamento where id_formapag = '{$vetor['formapag']}' and tipo = 'receita' and status = 1 order by qtd_parcelas ASC");
	}else {
		$sql_tipo_pagamento = mysqli_query($con, "select * from tipos_pagamento where id_formapag = '{$vetor['formapag']}' and tipo = 'despesa' and status = 1 order by qtd_parcelas ASC");
	}
	$qtd_parcelas_tp = 0;
	$tipo_pagamento = array();
	while ($vetor_tipo_pagamento = mysqli_fetch_array($sql_tipo_pagamento)) {
		if ($vetor_tipo_pagamento['qtd_parcelas'] <= $vetor['qtdparcelas']) {
			$qtd_parcelas_tp = $vetor_tipo_pagamento['id_tipo_pagamento'];
		}
		$tipo_pagamento[$vetor_tipo_pagamento['id_tipo_pagamento']]['porcentagem'] = $vetor_tipo_pagamento['porcentagem'];
		$tipo_pagamento[$vetor_tipo_pagamento['id_tipo_pagamento']]['valor'] = $vetor_tipo_pagamento['valor'];
	}
	if ($tipo_pagamento[$qtd_parcelas_tp]['porcentagem'] != null) {
		$porcentagem = (float)$tipo_pagamento[$qtd_parcelas_tp]['porcentagem'];
	}else {
		$porcentagem = 0;
	}
	if ($tipo_pagamento[$qtd_parcelas_tp]['valor'] != null) {
		$custo_fixo = $tipo_pagamento[$qtd_parcelas_tp]['valor'];
	}else {
		$custo_fixo = 0;
	}
	$total_taxa = $custo_fixo + (((float)$vetor['valor'] - $custo_fixo) * ($porcentagem / 100));
	echo "<div class='slider'>
<table cellpadding='1' cellspacing='0' border='0' style='padding-left: 50px'>
<tr>
<td>Cliente: ".$vetor['ncontrato']."-".$vetor['id_cadastro']." ".$vetor['fnome']."</td>
</tr>
<tr>
<td>Forma de Pagamento: ".$vetor['fpnome']."</td>
</tr>
<tr>
<td>Parcela: ".$vetor['posicao']."/".$vetor['qtdparcelas']."</td>
<td>Data de Vencimento: ".date('d/m/Y', strtotime($vetor['data']))."</td>
</tr>
<tr>
<td>Valor Bruto: R$".number_format($vetor['valor'], 2, ',', '.')."</td>
<td>Taxa: ".($custo_fixo != 0 ? 'R$'.number_format($custo_fixo, 2, ',', '.') : '').($porcentagem != 0 && $custo_fixo != 0 ? ' + ' : '').($porcentagem != 0 ? number_format($porcentagem, 2, ',', '.').'%' : '')."</td>
</tr>
<tr>
<td>Valor Liquido: R$".number_format((((float)$vetor['valor'] > 0 ? (float)$vetor['valor'] - $total_taxa : (float)$vetor['valor'] + $total_taxa)), 2, ',', '.')."</td>
<td>Total Taxa: R$".number_format($total_taxa, 2, ',', '.')."</td>
</tr>
</table>
</div> ";
}elseif (isset($_POST['id_lancamento']) && isset($_POST['detalhes'])) {
	$aux = explode(';',$_POST['id_lancamento']);
	$id_lancamento = $aux[0];
	$id_movimentacao = $aux[1];
	$vetor = mysqli_fetch_array(mysqli_query($con, "select l.chave_parcelamento,mf.valor as mfvalor,l.valor, fp.nome as fpnome,tp.id_tipo_pagamento,l.parcela,l.data_emissao,l.data_competencia,l.data_vencimento,mf.observacoes from movimentacao_financeira mf
																												left join lancamentos l on l.id_lancamento = mf.id_lancamento
																												left join tipos_pagamento tp on l.id_tipo_pagamento = tp.id_tipo_pagamento
																												left join formaspag fp on fp.id_forma = tp.id_formapag
                                                        where l.id_lancamento = '{$id_lancamento}' and mf.id_movimentacao = '{$id_movimentacao}'"));
	$sql_tipo_pagamento = mysqli_query($con, "select * from tipos_pagamento where id_tipo_pagamento = '{$vetor['id_tipo_pagamento']}'");

	$qtd_parcelas_tp = 0;
	$qtd = mysqli_num_rows(mysqli_query($con, "select * from lancamentos where chave_parcelamento <> 0 and chave_parcelamento = '{$vetor['chave_parcelamento']}'"));
	$tipo_pagamento = mysqli_fetch_array($sql_tipo_pagamento);
	if ($tipo_pagamento['porcentagem'] != null && (($vetor['valor'] > 0 && $vetor['mfvalor'] > 0)||($vetor['valor'] < 0 && $vetor['mfvalor'] < 0))) {
		$porcentagem = (float)$tipo_pagamento['porcentagem'];
	}else {
		$porcentagem = 0;
	}
	if ($tipo_pagamento['valor'] != null && (($vetor['valor'] > 0 && $vetor['mfvalor'] > 0)||($vetor['valor'] < 0 && $vetor['mfvalor'] < 0))) {
		$custo_fixo = $tipo_pagamento['valor'];
	}else {
		$custo_fixo = 0;
	}
	$total_taxa = $custo_fixo + (((float)$vetor['valor'] - $custo_fixo) * ($porcentagem / 100));
	echo "<div class='slider'>
<table cellpadding='5' cellspacing='0' border='0' style='padding-left: 50px'>
<tr>
<td>
Forma de Pagamento: ".$vetor['fpnome']."
</td>
</tr>
".($qtd > 1 ? '<tr>
<td>
Parcela: '.$vetor['parcela'].'/'.$qtd.'
</td>
</tr>' : '')."
<tr>
<tr>
<td>
Competência: ".ucfirst(strftime('%B', strtotime($vetor['data_competencia']))).'/'.date('Y', strtotime($vetor['data_competencia']))."
</td>
</tr>
<tr>
<td>
Emissão: ".date('d/m/Y', strtotime($vetor['data_emissao']))."
</td>
</tr>
<tr>
<td>
Vencimento: ".date('d/m/Y', strtotime($vetor['data_vencimento']))."
</td>
</tr>
<td>Valor Bruto: R$".number_format((($vetor['valor'] > 0 && $vetor['mfvalor'] > 0)||($vetor['valor'] < 0 && $vetor['mfvalor'] < 0)?$vetor['valor']:$vetor['mfvalor']), 2, ',', '.')."</td>
<td>Taxa: ".($custo_fixo != 0 ? 'R$'.number_format($custo_fixo, 2, ',', '.') : '').($porcentagem != 0 && $custo_fixo != 0 ? ' + ' : '').($porcentagem != 0 ? number_format($porcentagem, 2, ',', '.').'%' : '')."</td>
</tr>
<tr>
<td>Valor Liquido: R$".number_format((((float)$vetor['mfvalor'] > 0 ? (float)(($vetor['valor'] > 0 && $vetor['mfvalor'] > 0)||($vetor['valor'] < 0 && $vetor['mfvalor'] < 0)?$vetor['valor']:$vetor['mfvalor']) - $total_taxa : (float)(($vetor['valor'] > 0 && $vetor['mfvalor'] > 0)||($vetor['valor'] < 0 && $vetor['mfvalor'] < 0)?$vetor['valor']:$vetor['mfvalor']) + $total_taxa)), 2, ',', '.')."</td>
<td>Total Taxa: R$".number_format($total_taxa, 2, ',', '.')."</td>
</tr>
". ($vetor['observacoes'] == ''?'':'<tr>
<td>Observações: ' . $vetor['observacoes'] . '</td>
</tr>') ."
</table>
</div> ";
}
?>
