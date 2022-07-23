<?php

header("Content-type: text/html; charset=utf-8");

include"../includes/conexao.php";


session_start();

$min = $_POST['minn'];
$max = $_POST['maxx'];
$tipo = $_POST['tipo'];

if ($tipo == 'entrada') {
    $sql_atual = mysqli_query($con, "select a.id_item, b.id_duplicata, c.id_venda, f.id_formando, f.nome as nomeformando, pia.id_item as id_pia, pia.titulo as descricao, c.tipo as cod_centro_de_custo, f2.nome as forma_de_pagamento, a.posicao  as posicao_parcela, c.qtdparcelas,
    a.valor as valor_parcela, a.`data` as data_duplicatas_faturas, b.`data`as data_da_venda, a.datapagamento as data_pagamento, a.pagamento as status, a.id_fomento as cod_fomento
                                                            FROM duplicatas_faturas a, duplicatas b, vendas c, formandos f, pacotes_itens_album pia, formaspag f2 
                                                            where pia.id_item = c.id_pacote and c.id_formando = f.id_formando and b.id_venda = c.id_venda 
                                                            and a.id_duplicata = b.id_duplicata and f2.id_forma = a.formapag  and
                                                            b.`data` BETWEEN '$min' AND '$max' order by b.`data` asc");

    

    /*
    * Criando e exportando planilhas do Excel
    * /
    */
    // Definimos o nome do arquivo que será exportado

    $arquivo = 'Gestão e Título dia '.$min.' a '.$max.'.xls';
    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table>';
    $html .= '<tr>';
    $html .= '<td bgcolor="#CCCCCC"><b>id duplicatas_faturas</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>id duplicatas</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>id vendas</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>id formandos</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>id pacotes_itens_album</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Nome Formando</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Descrição').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Plano de Contas').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Plano de Contas</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Centro de Custo').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Centro de Custo</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Forma de Pagamento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Posição da Parcela').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Parcela</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Valor</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Valor Pago</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Fomento').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Fomento').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Data Emissão').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Data Vencimento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Data Competência').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Data Pagamento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Status</b></td>';
    $html .= '</tr>';
    $html .= '<tr>';

    while ($vetor_atual=mysqli_fetch_array($sql_atual)) {

    $vetor_fomento = mysqli_fetch_array(mysqli_query($con,"select * from fomentos where id_fomento = '{$vetor_atual['cod_fomento']}'"));

    $html .= '<td>'.utf8_decode($vetor_atual['id_item']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['id_duplicata']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['id_venda']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['id_formando']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['id_pia']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['nomeformando']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['descricao']).'</td>';
    $html .= '<td> </td>';
    $html .= '<td> </td>';
    $html .= '<td>'.utf8_decode($vetor_atual['cod_centro_de_custo']).'</td>';
    switch ($vetor_atual['cod_centro_de_custo']) {
        case '1':
            $html .= '<td>'.utf8_decode('Convite').'</td>';
            break;
        case '2':
            $html .= '<td>'.utf8_decode('Fotografia').'</td>';
            break;
        case '3':
            $html .= '<td>'.utf8_decode('V.Avulsa').'</td>';
            break;
        case '4':
            $html .= '<td>'.utf8_decode('Taxa de Estúdio').'</td>';
            break;
    }
    $html .= '<td>'.utf8_decode($vetor_atual['forma_de_pagamento']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['posicao_parcela']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['qtdparcelas']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['valor_parcela']).'</td>';
    $html .= '<td> </td>';
    $html .= '<td>'.utf8_decode($vetor_atual['cod_fomento']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_fomento['nome']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_da_venda']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_duplicatas_faturas']).'</td>';
    $html .= '<td> </td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_pagamento']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['status']).'</td>';
    $html .= '</tr>';
    }
    $html .= '</table>';
    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header ("Content-Description: PHP Generated Data" );
    // Envia o conteúdo do arquivo
    echo $html;
    exit;

}else if($tipo == 'saida'){
    $sql_atual = mysqli_query($con, "select cp.id_lancamento, t.id_turma, cp.titulo as descricao, cc.numeracao as cod_plano_de_contas, cc.titulo as plano_de_conta, cc3.id_centro as cod_centro_de_custo, 
    cc3.nome as centro_de_custo, tp.nome as forma_de_pagamento, cp.parcela, cp.valor, cp.valor_pago ,cp.data_emissao, cp.data_vencimento, cp.data_competencia, cp.data_pagamento, 
    cp.status, cp.id_conta, c2.nome as fomento 
    from lancamentos cp
                                                        left join turmas t on t.id_turma = cp.id_turma
                                                        left join clientes c on c.id_cli = cp.id_fornecedor
                                                        left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                                                        left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                                                        left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                                                        left join centro_custo cc3 on cc3.id_centro = cp.id_centro 
                                                        left join tipos_pagamento tp on cp.id_tipo_pagamento = tp.id_tipo_pagamento 
                                                        left join contas c2 on cp.id_conta = c2.id_conta
                                                        where cp.data_competencia BETWEEN '$min' AND '$max'");


    /*
    * Criando e exportando planilhas do Excel
    * /
    */
    // Definimos o nome do arquivo que será exportado

    $arquivo = 'Movimentação dia '.$min.' a '.$max.'.xls';
    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table>';
    $html .= '<tr>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('id lancamentos').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('id turmas').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Descrição').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Plano de Contas').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Plano de Contas</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Centro de Custo').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Centro de Custo</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Forma de Pagamento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Posição da Parcela').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Parcela</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Valor</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Valor Pago</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Cód. Fomento').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Fomento').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Data Emissão').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Data Vencimento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Data Competência').'</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Data Pagamento</b></td>';
    $html .= '<td bgcolor="#CCCCCC"><b>Status</b></td>';
    $html .= '</tr>';
    $html .= '<tr>';

    while ($vetor_atual=mysqli_fetch_array($sql_atual)) {
    
    $html .= '<td>'.utf8_decode($vetor_atual['id_lancamento']).'</td>';        
    $html .= '<td>'.utf8_decode($vetor_atual['id_turma']).'</td>';  
    $html .= '<td>'.utf8_decode($vetor_atual['descricao']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['cod_plano_de_contas']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['plano_de_conta']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['cod_centro_de_custo']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['centro_de_custo']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['forma_de_pagamento']).'</td>';
    $html .= '<td> </td>';
    $html .= '<td>'.utf8_decode($vetor_atual['parcela']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['valor']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['valor_pago']).'</td>';

    $html .= '<td>'.utf8_decode($vetor_atual['id_conta']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['fomento']).'</td>';

    $html .= '<td>'.utf8_decode($vetor_atual['data_emissao']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_vencimento']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_competencia']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['data_pagamento']).'</td>';
    $html .= '<td>'.utf8_decode($vetor_atual['status']).'</td>';
    $html .= '</tr>';
    }
    $html .= '</table>';
    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header ("Content-Description: PHP Generated Data" );
    // Envia o conteúdo do arquivo
    echo $html;
    exit;

}


?>