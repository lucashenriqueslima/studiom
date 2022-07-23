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

if(isset($_POST['valor_transferencia'])){
	$conta_origem = $_POST['conta_origem'];
	$conta_destino = $_POST['conta_destino'];
	$valor_transferencia = $_POST['valor_transferencia'];
	$valor_negativo = moeda($valor_transferencia) * -1;
	$valor_positivo = moeda($valor_transferencia);
	$data = date('Y-m-d');
	$data_insercao = date('Y-m-d H:i:s');
	$catconta = mysqli_fetch_array(mysqli_query($con,"select * from categorias_contas where id_catconta = '184'"));
	$titulo = $catconta['numeracao'] . ' - ' . $catconta['titulo'];
	$retirada = mysqli_query($con,"insert into lancamentos (id_turma,titulo,id_centro,data_emissao,data_vencimento,data_competencia,data_pagamento,valor,valor_pago,status,id_usuario,parcela,id_conta,id_catconta)VALUES('0','{$titulo}','0','{$data}','{$data}','{$data}','{$data}','{$valor_negativo}','{$valor_negativo}','1','{$id_usuario}','1','{$conta_origem}','184')");
	$insert_id = $con->insert_id;
	$retirada_movimentacao = mysqli_query($con,"insert into movimentacao_financeira (id_conta,id_lancamento,id_usuario,data,data_insercao,valor,status,id_catconta)VALUES('{$conta_origem}','{$insert_id}','{$id_usuario}','{$data}','{$data_insercao}','{$valor_negativo}','1','184')");
	$deposito = mysqli_query($con,"insert into lancamentos (id_turma,titulo,id_centro,data_emissao,data_vencimento,data_competencia,data_pagamento,valor,valor_pago,status,id_usuario,parcela,id_conta,id_catconta)VALUES('0','{$titulo}','0','{$data}','{$data}','{$data}','{$data}','{$valor_positivo}','{$valor_positivo}','1','{$id_usuario}','1','{$conta_destino}','184')");
	$insert_id = $con->insert_id;
	$deposito_movimentacao = mysqli_query($con,"insert into movimentacao_financeira (id_conta,id_lancamento,id_usuario,data,data_insercao,valor,status,id_catconta)VALUES('{$conta_destino}','{$insert_id}','{$id_usuario}','{$data}','{$data_insercao}','{$valor_positivo}','1','184')");
	die();
}

if(isset($_GET['desativar'])){
	$id_lancamento = $_GET['desativar'];
	$conta = mysqli_fetch_array(mysqli_query($con, "select arquivo from lancamentos where id_lancamento = '$id'"));
	$unlink = $SERVER_ROOT.'/sistema/arquivos/'.$conta['arquivo'];
	@unlink($unlink);
	$sql = mysqli_query($con, "update lancamentos SET arquivo=null,status=null where id_lancamento = '$id_lancamento'");
	var_dump($sql);
	die();
}
if (isset($_GET['novo'])) {
	$centro_custo = $_POST['centro_custo'];
	$id_fornecedor = $_POST['id_fornecedor'];
	$data_vencimento = $_POST['data_vencimento'];
	$data_emissao = $_POST['data_emissao'];
	$data_competencia = $_POST['data_competencia'].'-01';
	$aux = explode(";",$_POST['id_cat_fornecedor']);
	$categoria_fornecedor = $aux[0];#split
	$parcelamento = (int)$_POST['parcelamento'];
	$tipo_pagamento = (int)$_POST['tipo_pagamento'];
	$recorrencia = $_POST['recorrencia'];
	$id_conta = $_POST['id_conta'];
	$id_catconta = $aux[1];
	$titulo = ucwords(strtolower($_POST['titulo']));
	if ($_POST['turma'] == '' || $_POST['turma'] == null) {
		$id_turma = '0';
	}else {
		$id_turma = $_POST['turma'];
	}
	$valor = moeda($_POST['valor']) * ($_POST['tipo_lancamento'] == 'receita' ? 1 : -1);
	$diavencimento = substr($data_vencimento, 8, 2);
	$data_vencimento = substr($data_vencimento, 0, 7);
	if ($recorrencia == 'on') {
		$diavencimento_emissao = substr($data_emissao, 8, 2);
		$data_emissao = substr($data_emissao, 0, 7);
	}
	if ($parcelamento > 1) {
		$sql_maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(chave_parcelamento) as chave_parcelamento from lancamentos"));
		$chave_parcelamento = (int)$sql_maximo['chave_parcelamento'] + 1;
	}else {
		$chave_parcelamento = 0;
	}
	$msg = '';
	for ($i = 1; $i <= $parcelamento; $i++) {
		if ($diavencimento > 28 && substr($data_vencimento, 5, 2) == '02') {
			$data_vencimento = $data_vencimento."-28";
		}else {
			$data_vencimento = $data_vencimento."-".$diavencimento;
		}
		if ($recorrencia == 'on') {
			if ($diavencimento_emissao > 28 && substr($data_emissao, 5, 2) == '02') {
				$data_emissao = $data_emissao."-28";
			}else {
				$data_emissao = $data_emissao."-".$diavencimento_emissao;
			}
		}
		$sql = mysqli_query($con, "insert into lancamentos (id_turma,titulo,id_centro,data_vencimento,data_emissao,data_competencia,valor,status,id_usuario,categoria_fornecedor,id_fornecedor,parcela,id_tipo_pagamento,chave_parcelamento,id_conta,id_catconta)
VALUES('$id_turma','$titulo','$centro_custo','$data_vencimento','$data_emissao','$data_competencia','$valor','0','$id_usuario','$categoria_fornecedor','$id_fornecedor','$i','$tipo_pagamento','$chave_parcelamento','$id_conta','$id_catconta')") or die (mysqli_error($con));
		$id_lancamento = $con->insert_id;
		$data_vencimento = date('Y-m', strtotime('+1 months', strtotime(substr($data_vencimento, 0, 7))));
		$vetor = mysqli_fetch_array(mysqli_query($con, "select cp.*,cc3.nome as centronome,c.nome as fornecedor,cf.nome as titulo_fornecedor,cc.numeracao, t.ncontrato from lancamentos cp
                                                        left join turmas t on t.id_turma = cp.id_turma
                                                        left join clientes c on c.id_cli = cp.id_fornecedor
                                                        left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                                                        left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                                                        left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                                                        left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                                                        where cp.id_lancamento = '$id_lancamento'"));
		$msg .= ($i == 1 ? '':';new;') . ($vetor['ncontrato'] != null ? $vetor['ncontrato'] : 'Custo Fixo') . ';' . $vetor['centronome'] . ';' . $vetor['titulo_fornecedor'].' - '.ucwords(strtolower($vetor['fornecedor'])).($vetor['titulo'] == '' ? '' : '<br>'.$vetor['titulo'])
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
			</button>' . ';' . $id_lancamento;
		if ($recorrencia == 'on') {
			$data_competencia = date('Y-m-d', strtotime('+1 months', strtotime($data_competencia)));
			$data_emissao = date('Y-m', strtotime('+1 months', strtotime(substr($data_emissao, 0, 7))));
		}
	}
	echo $msg;
	die();
}
if (isset($_GET['excluir'])) {
	$id = $_GET['excluir'];
	$conta = mysqli_fetch_array(mysqli_query($con, "select arquivo from lancamentos where id_lancamento = '$id'"));
	$unlink = $SERVER_ROOT.'/sistema/arquivos/'.$conta['arquivo'];
	@unlink($unlink);
	$sql = mysqli_query($con, "update lancamentos SET arquivo=null where id_lancamento = '$id'");
	die();
}
if (isset($_GET['baixar'])) {
	$id_lancamento = $_POST['id_lancamento'];
	$tipo_lancamento = $_POST['tipo_lancamento'];
	$id_fornecedor = $_POST['id_fornecedor'];
	$aux = explode(";",$_POST['id_cat_fornecedor']);
	$id_cat_fornecedor = $aux[0];
	$id_catconta = $aux[1];
	$centro_custo = $_POST['centro_custo'];
	$titulo = ucwords(strtolower($_POST['titulo']));
	$tipo_pagamento = $_POST['tipo_pagamento'];
	$id_conta = $_POST['id_conta'];
	$selectTurma = $_POST['selectTurma'];
	$data_competencia = $_POST['data_competencia'].'-01';
	$data_emissao = $_POST['data_emissao'];
	$data_vencimento = $_POST['data_vencimento'];
	$observacoes = $_POST['observacoes'];
	$datapagamento = date('Y-m-d');
	$data = $_POST['data_baixa'];
	$data_insercao = date('Y-m-d H:i:s');
	$vetor_lancamento = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM lancamentos WHERE id_lancamento = '$id_lancamento'"));
	$valorAux = (float)$vetor_lancamento['valor'];
	$maximo = $valorAux + ($valorAux * 0.005);
	$minimo = $valorAux - ($valorAux * 0.005);
	$valorReal = (float)moeda($_POST['valor']) * ($tipo_lancamento == 'receita' ? 1 : -1);
	if(($valorAux < 0 &&($valorReal >= $minimo || $valorReal <= $maximo))||($valorAux > 0 &&($valorReal <= $minimo || $valorReal >= $maximo))){
		$id_catconta2 = $_POST['plano_contas'];
		$valor = number_format(($valorReal - $valorAux),'2','.',',');
		$sql2 = mysqli_query($con, "insert into movimentacao_financeira (id_conta,id_lancamento,id_usuario,data,data_insercao,valor,status,id_catconta,observacoes)VALUES('$id_conta','$id_lancamento','$id_usuario','$data','$data_insercao','$valor','1','$id_catconta2','$observacoes')") or die (mysqli_error($con));
	}
	$valor_pago = $vetor_lancamento['valor'];
	$sql = mysqli_query($con, "update lancamentos set id_turma='$selectTurma',titulo='$titulo',id_centro='$centro_custo',data_emissao='$data_emissao',
data_vencimento='$data_vencimento',data_competencia='$data_competencia', data_pagamento='$datapagamento',valor_pago='$valor_pago',status='1',categoria_fornecedor='$id_cat_fornecedor',
id_fornecedor='$id_fornecedor',id_tipo_pagamento='$tipo_pagamento',id_conta='$id_conta',id_catconta='$id_catconta' where id_lancamento='$id_lancamento'") or die (mysqli_error($con));
	$sql1 = mysqli_query($con, "insert into movimentacao_financeira (id_conta,id_lancamento,id_usuario,data,data_insercao,valor,status,id_catconta,observacoes)VALUES('$id_conta','$id_lancamento','$id_usuario','$data','$data_insercao','$valor_pago','1','$id_catconta','$observacoes')") or die (mysqli_error($con));
	$vetor = mysqli_fetch_array(mysqli_query($con, "select mf.id_movimentacao,l.id_lancamento,l.arquivo,mf.valor,mf.data,l.parcela,l.chave_parcelamento,c.nome as cnome,cc.numeracao, l.titulo, cf.nome as titulo_fornecedor, c2.nome as fornecedor from movimentacao_financeira mf
                                                                                            left join lancamentos l on l.id_lancamento = mf.id_lancamento
                                                                                            left join contas c on c.id_conta = mf.id_conta
                                                                                            left join clientes c2 on c2.id_cli = l.id_fornecedor
                                                                                            left join categoriafornecedor cf on cf.id_categoria = l.categoria_fornecedor
                                                                                            left join categorias_contas cc on cc.id_catconta = mf.id_catconta
                                                                                            where mf.status='1' and mf.id_lancamento = '$id_lancamento'"));
	echo ((float)$vetor['valor'] < 0?'<span hidden>despesa</span>':'<span hidden>receita</span>') . $vetor['cnome'] . ';;' .	$vetor['titulo_fornecedor'].' - '.ucwords(strtolower($vetor['fornecedor'])).($vetor['titulo'] == '' ? '' : '<br>'.$vetor['titulo']) . ';;' .	((float)$vetor['valor'] > 0 ? '+' : '').$vetor['valor'] . ';;' .	date('d/m/Y', strtotime($vetor['data'])) . ';;' .
		'<button id="inserir'.$vetor['id_lancamento'].'" type="button" class="btn btn-success" title="Inserir Arquivo" onclick="abreModal('.$vetor['id_lancamento']. ",'4'" .')" '. (!($vetor['arquivo'] == '')?'hidden':'').'>
        <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
    </button>

    <a href="'. ($vetor['arquivo'] != null ?'arquivos/'.$vetor['arquivo']:'').'" target="_blank"
       id="arq'.$vetor['id_lancamento'].'" '.($vetor['arquivo'] == null ?'hidden':'').'>
        <button type="button" class="btn btn-warning"
                title="Ver Arquivo">
            <span><i class="fas fa-file-alt fa-lg"></i></span>
        </button>
    </a>
    <button type="button" class="btn btn-danger btn-md"
            title="Cancelar Lançamento"
            onclick="cancelarLancamento('.$vetor['id_lancamento'].')">
        <span><i class="mdi mdi-window-close"></i></span>
    </button>' . ';;' .	$vetor['id_lancamento'].';'.$vetor['id_movimentacao'];
	die();
}
if (isset($_GET['alterar'])) {
	$id_lancamento = $_POST['id_lancamento'];
	$tipo_lancamento = $_POST['tipo_lancamento'];
	$id_fornecedor = $_POST['id_fornecedor'];
	$aux = explode(";",$_POST['id_cat_fornecedor']);
	$id_cat_fornecedor = $aux[0];
	$id_catconta = $aux[1];
	$centro_custo = $_POST['centro_custo'];
	$titulo = ucwords(strtolower($_POST['titulo']));
	$tipo_pagamento = $_POST['tipo_pagamento'];
	$id_conta = $_POST['id_conta'];
	$selectTurma = $_POST['selectTurma'];
	$data_competencia = $_POST['data_competencia'].'-01';
	$data_emissao = $_POST['data_emissao'];
	$data_vencimento = $_POST['data_vencimento'];
	$observacoes = $_POST['observacoes'];
	$datapagamento = date('Y-m-d');
	$valorReal = (float)moeda($_POST['valor']) * ($tipo_lancamento == 'receita' ? 1 : -1);
	$sql = mysqli_query($con, "update lancamentos set id_turma='$selectTurma',titulo='$titulo',id_centro='$centro_custo',data_emissao='$data_emissao',
data_vencimento='$data_vencimento',data_competencia='$data_competencia',categoria_fornecedor='$id_cat_fornecedor',valor='$valorReal',
id_fornecedor='$id_fornecedor',id_tipo_pagamento='$tipo_pagamento',id_conta='$id_conta',id_catconta='$id_catconta' where id_lancamento='$id_lancamento'") or die (mysqli_error($con));
	$vetor = mysqli_fetch_array(mysqli_query($con, "select cp.*,cc3.nome as centronome,c.nome as fornecedor,cf.nome as titulo_fornecedor,cc.numeracao, t.ncontrato from lancamentos cp
                                                        left join turmas t on t.id_turma = cp.id_turma
                                                        left join clientes c on c.id_cli = cp.id_fornecedor
                                                        left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                                                        left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                                                        left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                                                        left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                                                        where cp.id_lancamento = '$id_lancamento'"));
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
if (isset($_GET['arquivo'])) {
	$id_lancamento = $_POST['id_lancamento'];
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/contas/';
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}
	$arquivo = $_FILES['arquivo']['name'];
	$tmp = $_FILES['arquivo']['tmp_name'];
	$ext = strrchr($arquivo, '.');
	$nomegrava = time().uniqid().$ext;
	$upload = $diretorio.$nomegrava;
	move_uploaded_file($tmp, $upload);
	$grava_pasta = "contas/".$nomegrava;
	$sql = mysqli_query($con, "update lancamentos SET arquivo='$grava_pasta' where id_lancamento = '$id_lancamento'");
	echo $grava_pasta;
	die();
}
?>
