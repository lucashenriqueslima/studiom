<?php

    namespace Source\Models;

    Class Titulos extends Model
    {

        public function getContasAReceber()
        {   
            
            $stmt = $this->pdo->prepare("
            SELECT	
            CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(tv.descricao_tipo_venda, ''), IFNULL(fp.nome, ''), IFNULL(CONCAT(df.posicao, '/', v.qtdparcelas), ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'),''), IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE fo.nome END), ''),IFNULL(REPLACE(df.valor, '.', ','), ''), IFNULL(fo.nome, ''), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END), '')),
        f.nome as fnome,
        CONCAT(t.ncontrato, '-', f.id_cadastro) id, 
        tv.descricao_tipo_venda,
        fp.nome as fpnome,
        CONCAT(df.posicao, '/', v.qtdparcelas) parcela_atual,
        DATE_FORMAT(df.`data`, '%d/%m/%Y') vencimento,
        REPLACE(df.valor, '.', ',') valor_formatado,
        fo.nome as fonome,
        df.recomprado,
        df.posicao, df.data, df.id_fomento, df.link, df.id_item, df.status, df.arquivo, df.id_item, df.arquivo, df.boleto
        from duplicatas_faturas df
            left join duplicatas d on d.id_duplicata = df.id_duplicata
            left join vendas v on  v.id_venda = d.id_venda
            LEFT JOIN tipos_venda tv
            ON tv.id_tipo_venda = v.tipo
            left join formandos f on f.id_formando = v.id_formando
            left join formaspag fp on fp.id_forma = df.formapag
            left join turmas t on t.id_turma = f.turma
            left join fomentos fo on fo.id_fomento=df.id_fomento
            where (v.status ='3' and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d') and df.status <> 2 OR df.recomprado = 1) 
             AND CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(tv.descricao_tipo_venda, ''), IFNULL(fp.nome, ''), IFNULL(CONCAT(df.posicao, '/', v.qtdparcelas), ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'),''), IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE fo.nome END), ''),IFNULL(REPLACE(df.valor, '.', ','), ''), IFNULL(fo.nome, ''), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END), '')) LIKE '%".$_GET["search"]."%'
                ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
                LIMIT ".$_GET["offset"].", ".$_GET["limit"]."
                ");



                $stmt->execute(array());
                
                return ["count" => $this->pdo->query("SELECT COUNT(*) count
                from duplicatas_faturas df
                    left join duplicatas d on d.id_duplicata = df.id_duplicata
                    left join vendas v on  v.id_venda = d.id_venda
                    LEFT JOIN tipos_venda tv
                    ON tv.id_tipo_venda = v.tipo
                    left join formandos f on f.id_formando = v.id_formando
                    left join formaspag fp on fp.id_forma = df.formapag
                    left join turmas t on t.id_turma = f.turma
                    left join fomentos fo on fo.id_fomento=df.id_fomento
                    where (v.status ='3' and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d') and df.status <> 2)
                    AND CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(tv.descricao_tipo_venda, ''), IFNULL(fp.nome, ''), IFNULL(CONCAT(df.posicao, '/', v.qtdparcelas), ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'),''), IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE fo.nome END), ''),IFNULL(REPLACE(df.valor, '.', ','), ''), IFNULL(fo.nome, ''), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END), '')) LIKE '%".$_GET["search"]."%'
                    ")->fetch(\PDO::FETCH_ASSOC)["count"], "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];

        }

        public function getCobrancas()
        {   

            $stmt = $this->pdo->prepare("
            select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome , v.tipo , v.qtdparcelas,
            df.posicao, df.data, df.id_fomento, df.link, df.id_item, df.pagamento, df.arquivo, df.status, df.arquivo, df.boleto, 
            CONCAT(t.ncontrato, '-', f.id_cadastro) AS id,
            tv.descricao_tipo_venda,
            CONCAT(df.posicao, '/', v.qtdparcelas) AS parcela_atual,
            REPLACE(df.valor, '.', ',') AS valor_formatado,
            (select count(*) cobranca_count from interacao_cobranca where id_duplicata_fatura = id_item) AS cobranca,
            DATEDIFF(CURDATE(), df.data) datedif,
            DATE_FORMAT(df.`data`, '%d/%m/%Y') AS vencimento,
            df.recomprado
            from duplicatas_faturas df
            left join duplicatas d on d.id_duplicata = df.id_duplicata
            left join vendas v on  v.id_venda = d.id_venda
            left join formandos f on f.id_formando = v.id_formando
            left join turmas t on t.id_turma = f.turma
            left join fomentos fo on fo.id_fomento=df.id_fomento
            LEFT JOIN tipos_venda tv
            ON tv.id_tipo_venda = v.tipo
            where (v.status ='3' and (df.data <= (SELECT CURDATE() + INTERVAL -1 *(SELECT MIN(lrc.dia) FROM lembrete_regua_cobranca lrc) DAY) and (df.status = 1 || df.status = 4)) or (df.status = 2 and (df.pagamento is null or df.pagamento = 0) and df.data <= (SELECT CURDATE() + INTERVAL -1 *(SELECT MIN(lrc.dia) FROM lembrete_regua_cobranca lrc) DAY)))
            AND CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(v.tipo, ''), IFNULL(v.qtdparcelas, ''),IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE fo.nome END), ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'), ''), IFNULL(REPLACE(df.valor, '.', ','), ''), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END), '') ) LIKE '%".$_GET["search"]."%'            
            ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
            LIMIT ".$_GET["offset"].", ".$_GET["limit"]."");
            
            $stmt->execute(array());

            return ["count" => $this->pdo->query("select count(*) count
            from duplicatas_faturas df
            left join duplicatas d on d.id_duplicata = df.id_duplicata
            left join vendas v on  v.id_venda = d.id_venda
            left join formandos f on f.id_formando = v.id_formando
            left join turmas t on t.id_turma = f.turma
            left join fomentos fo on fo.id_fomento=df.id_fomento
            LEFT JOIN tipos_venda tv
            ON tv.id_tipo_venda = v.tipo
            where (v.status ='3' and (df.data <= (SELECT CURDATE() + INTERVAL -1 *(SELECT MIN(lrc.dia) FROM lembrete_regua_cobranca lrc) DAY) and (df.status = 1 || df.status = 4)) or (df.status = 2 and (df.pagamento is null or df.pagamento = 0) and df.data <= (SELECT CURDATE() + INTERVAL -1 *(SELECT MIN(lrc.dia) FROM lembrete_regua_cobranca lrc) DAY)))
            AND CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(v.tipo, ''), IFNULL(v.qtdparcelas, ''),IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE fo.nome END), ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'), ''), IFNULL(REPLACE(df.valor, '.', ','), ''), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END), '') ) LIKE '%".$_GET["search"]."%'       
            ")->fetch(\PDO::FETCH_ASSOC)["count"], "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];
            
        }

            

            public function getRecebidos()
            {

                $stmt = $this->pdo->prepare("select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome,v.tipo ,v.qtdparcelas,
                CONCAT(t.ncontrato, '-', f.id_cadastro) id,
                tv.descricao_tipo_venda,
                CONCAT(df.posicao, '/', v.qtdparcelas) parcela_atual,
                fp.nome as fpnome,
                DATE_FORMAT(df.`data`, '%d/%m/%Y') vencimento,
                REPLACE(df.valor, '.', ',') valor_formatado,
                REPLACE(df.valor_recebido, '.', ',') valor_recebido_formatado,
                df.*,
                (SELECT COUNT(*) FROM interacao_cobranca where id_duplicata_fatura= id_item ) cobranca,
                (
					 SELECT c.nome 
					 FROM contas c 
					 INNER JOIN movimentacao_financeira mf
					 ON c.id_conta = mf.id_conta
					 WHERE mf.id_duplicata = id_item AND mf.data = datapagamento AND mf.valor > 0
					 LIMIT 1
			    ) conta_destino
                from duplicatas_faturas df
                left join duplicatas d on d.id_duplicata = df.id_duplicata
                left join vendas v on  v.id_venda = d.id_venda
                left join formandos f on f.id_formando = v.id_formando
                left join turmas t on t.id_turma = f.turma
                left join fomentos fo on fo.id_fomento=df.id_fomento
                left join formaspag fp on fp.id_forma = df.formapag
                LEFT JOIN tipos_venda tv
                ON tv.id_tipo_venda = v.tipo
                where (v.status ='3' and (df.status = 2 and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d')) or (df.status = 2 and df.pagamento = 1)) 
                AND CONCAT(IFNULL(fp.nome, ''), IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(v.tipo, ''), IFNULL(v.qtdparcelas, ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'), ''), IFNULL(REPLACE(df.valor, '.', ','), '0,00'), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END),''), IFNULL(REPLACE(df.valor_recebido, '.', ','), '0,00') ) LIKE '%".$_GET["search"]."%'            
                ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
                LIMIT ".$_GET["offset"].", ".$_GET["limit"]."
                ");

                $stmt->execute(array());

                return ["count" => $this->pdo->query("select count(*) count from duplicatas_faturas df
                left join duplicatas d on d.id_duplicata = df.id_duplicata
                left join vendas v on  v.id_venda = d.id_venda
                left join formandos f on f.id_formando = v.id_formando
                left join turmas t on t.id_turma = f.turma
                left join fomentos fo on fo.id_fomento=df.id_fomento
                where ((v.status ='3' and (df.status = 2 and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d')) or (df.status = 2 and df.pagamento = 1)))
                AND CONCAT(IFNULL(CONCAT(t.ncontrato, '-', f.id_cadastro), ''), IFNULL(f.nome, ''), IFNULL(v.tipo, ''), IFNULL(v.qtdparcelas, ''), IFNULL(DATE_FORMAT(df.`data`, '%d/%m/%Y'), ''), IFNULL(REPLACE(df.valor, '.', ','), '0,00'), IFNULL((CASE WHEN df.`status` = '1' THEN 'Antecipado' ELSE 'Negado' END),''), IFNULL(REPLACE(df.valor_recebido, '.', ','), '0,00') ) LIKE '%".$_GET["search"]."%'            

                ")->fetch(\PDO::FETCH_ASSOC)["count"], "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];
            }

            public function getContasAPagar()
            {

                $stmt = $this->pdo->prepare("
                select cp.*,
                cc3.nome as centronome,
                c.nome as fornecedor,
                cf.nome as titulo_fornecedor,
                cc.numeracao, 
                co.nome as conta_nome,
                DATE_FORMAT(cp.data_vencimento, '%d/%m/%Y') vencimento,
                DATE_FORMAT(cp.data_pagamento, '%d/%m/%Y') pagamento,
                REPLACE(CONCAT('R$ ', FORMAT(cp.valor, 2)), '.', ',') valor_conta,
                IF(t.ncontrato != 0, t.ncontrato, 'Custo Fixo') contrato,
                UPPER(CONCAT(IFNULL(CONCAT(cf.nome, ' - ' ), ''), IFNULL(CONCAT(c.nome, ' - '), ''), IFNULL(cp.titulo, ''))) descricao,
                IF(cp.status = '1', 'Quitada', 'Não Pago') status_conta
                from lancamentos cp
                left join turmas t on t.id_turma = cp.id_turma
                left join clientes c on c.id_cli = cp.id_fornecedor
                left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                left join contas co on co.id_conta = cp.id_conta
                where (cp.valor < 0 ) 
                AND CONCAT(IF(t.ncontrato != 0, t.ncontrato, 'Custo Fixo'), IF(cp.`status` != 0, 'Quitado', 'Nao Pago'), CONCAT(IFNULL(CONCAT(cf.nome, ' - ' ), ''), IFNULL(CONCAT(c.nome, ' - '), ''), IFNULL(cp.titulo, '')), IFNULL(CONCAT(IFNULL(CONCAT(cf.nome, ' - ' ), ''), IFNULL(CONCAT(c.nome, ' - '), ''), IFNULL(cp.titulo, '')), ''), cc3.nome, cp.titulo, IFNULL(DATE_FORMAT(cp.data_vencimento, '%d/%m/%Y'), ''), IFNULL(DATE_FORMAT(cp.data_pagamento, '%d/%m/%Y'), ''), IFNULL(REPLACE(cp.valor, '.', ','), '')) LIKE '%{$_GET['search']}%'
                ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
                LIMIT ".$_GET["offset"].", ".$_GET["limit"]."
                                ");

                $stmt->execute(array());

                return ["count" => $this->pdo->query("select count(*) count from lancamentos cp
                left join turmas t on t.id_turma = cp.id_turma
                left join clientes c on c.id_cli = cp.id_fornecedor
                left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                where (cp.valor < 0)
                AND CONCAT(IF(t.ncontrato != 0, t.ncontrato, 'Custo Fixo'), IF(cp.`status` != 0, 'Quitada', 'Nao Pago'), CONCAT(IFNULL(CONCAT(cf.nome, ' - ' ), ''), IFNULL(CONCAT(c.nome, ' - '), ''), IFNULL(cp.titulo, '')), IFNULL(CONCAT(IFNULL(CONCAT(cf.nome, ' - ' ), ''), IFNULL(CONCAT(c.nome, ' - '), ''), IFNULL(cp.titulo, '')), ''), cc3.nome, cp.titulo, IFNULL(DATE_FORMAT(cp.data_vencimento, '%d/%m/%Y'), ''), IFNULL(DATE_FORMAT(cp.data_pagamento, '%d/%m/%Y'), ''), IFNULL(REPLACE(cp.valor, '.', ','), '')) LIKE '%{$_GET['search']}%'")
                ->fetch(\PDO::FETCH_ASSOC)["count"], 
                "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];

            }

            // public function getContasPagas()
            // {
            //     if($_GET["order"] == "id") {
            //         $_GET["order"] = "mf.data";
            //         $_GET["dir"] = 'ASC';
            //     }
                
            //     $stmt = $this->pdo->prepare("select mf.id_movimentacao,l.id_lancamento,l.arquivo, l.parcela,l.chave_parcelamento,c.nome as cnome,cc.numeracao, l.titulo, cf.nome as titulo_fornecedor, c2.nome as fornecedor, 
            //     REPLACE(CONCAT('R$ ', FORMAT(mf.valor, 2)), '.', ',') valor,
            //     DATE_FORMAT(mf.`data`, '%d/%m/%Y') data
            //     from movimentacao_financeira mf
            //     left join lancamentos l on l.id_lancamento = mf.id_lancamento
            //     left join contas c on c.id_conta = mf.id_conta
            //     left join clientes c2 on c2.id_cli = l.id_fornecedor
            //     left join categoriafornecedor cf on cf.id_categoria = l.categoria_fornecedor
            //     left join categorias_contas cc on cc.id_catconta = mf.id_catconta
            //     where (mf.status='1' and mf.id_duplicata is null AND mf.valor < 0)
            //     AND CONCAT(IFNULL(c.nome, ''), IFNULL(c2.nome, ''), IFNULL(l.titulo, ''), IFNULL(cf.nome, ''), IFNULL((CASE WHEN df.id_fomento IS NULL AND df.link IS NOT NULL THEN 'GetNet' ELSE f.nome END), ''), IFNULL(CONCAT(REPLACE(mf.valor, '.', ','), '0'), ''), IFNULL(DATE_FORMAT(mf.`data`, '%d/%m/%Y'), '')) LIKE '%".$_GET["search"]."%' 
            //     ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
            //     LIMIT ".$_GET["offset"].", ".$_GET["limit"]."");

            //     $stmt->execute(array());

            //     $sql_lancamentos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            //     $stmt = $this->pdo->prepare("select mf.id_movimentacao,mf.id_duplicata,f.nome as fnome,cc.numeracao,cc.titulo,mf.valor,mf.data,c.nome as cnome from movimentacao_financeira mf
            //     left join duplicatas_faturas df on df.id_item = mf.id_duplicata
            //     left join duplicatas d on d.id_duplicata = df.id_duplicata
            //     left join vendas v on v.id_venda = d.id_venda   
            //     left join formandos f on f.id_formando = v.id_formando
            //     left join contas c on c.id_conta=mf.id_lancamento
            //     left join categorias_contas cc on cc.id_catconta = mf.id_catconta
            //     where (mf.status = '1' and mf.id_lancamento is NULL AND mf.valor < 0)
            //     AND CONCAT(IFNULL(c.nome, ''), IFNULL(c2.nome, ''), IFNULL(l.titulo, ''), IFNULL(cf.nome, ''), IFNULL(CONCAT(REPLACE(mf.valor, '.', ','), '0'), ''), IFNULL(DATE_FORMAT(mf.`data`, '%d/%m/%Y'), '')) LIKE '%".$_GET["search"]."%'
            //     ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
            //     LIMIT ".$_GET["offset"].", ".$_GET["limit"]."
            //     ");


            //     return ["count" => $this->pdo->query("select count(*) count FROM movimentacao_financeira mf WHERE mf.status='1' and mf.id_duplicata is null")->fetch(\PDO::FETCH_ASSOC)["count"], "results" => $sql_lancamentos];   
            // }


            public function getFluxoDeCaixa()
            {
                $stmt = $this->pdo->prepare("
                SELECT mf.id_movimentacao,
                (CASE 
                    WHEN v.id_formando IS NULL AND l.id_turma IS NULL || l.id_turma = 0
                        THEN 'Custo Fixo'
                    WHEN df.id_item IS NOT NULL 
                        THEN CONCAT(t.ncontrato, '-', f.id_cadastro)
                    ELSE t.ncontrato
                END
                )id_item,
                IFNULL(f.nome, IFNULL(CONCAT(cu.nome,' - ', t.ano, ' - ', i.nome), 'Despesas Administrativas')) titulo,
                IF(l.id_lancamento IS NOT NULL, cc.nome, tv.descricao_tipo_venda) centro_custo,
                IF(df.posicao IS NOT NULL, CONCAT(df.posicao, '/', v.qtdparcelas), CONCAT(l.parcela, '/', (SELECT COUNT(*)
                                                                                                                                        FROM lancamentos l2
                                                                                                                                        WHERE l2.chave_parcelamento != 0 
                                                                                                                                    AND l2.chave_parcelamento = l.chave_parcelamento))) parcela,
                CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')) descricao,
                DATE_FORMAT(mf.`data`, '%d/%m/%Y') data_realizado,
                IF(l.id_lancamento IS NOT NULL, DATE_FORMAT(l.data_vencimento, '%d/%m/%Y'), DATE_FORMAT(df.`data`, '%d/%m/%Y')) data_vencimento,
                CONCAT('R$ ', REPLACE(mf.valor, '.', ',')) valor_realizado,
                IF(l.id_lancamento IS NOT NULL, CONCAT('R$ ', REPLACE(l.valor, '.', ',')), CONCAT('R$ ', REPLACE(df.valor, '.', ','))) valor_total,
                co.nome,
                mf.observacoes
                FROM movimentacao_financeira mf
                LEFT JOIN categorias_contas cac
                ON mf.id_catconta = cac.id_catconta
                LEFT JOIN lancamentos l
                ON mf.id_lancamento = l.id_lancamento
                LEFT JOIN centro_custo cc
                ON l.id_centro = cc.id_centro
                LEFT JOIN clientes c
                ON l.id_fornecedor = c.id_cli
                LEFT JOIN categoriafornecedor cf ON
                l.categoria_fornecedor = cf.id_categoria
                LEFT JOIN duplicatas_faturas df
                ON mf.id_duplicata = df.id_item
                LEFT JOIN duplicatas d
                ON df.id_duplicata = d.id_duplicata
                LEFT JOIN vendas v 
                ON  v.id_venda = d.id_venda
                LEFT JOIN formandos f 
                ON f.id_formando = v.id_formando
                LEFT JOIN turmas t 
                ON l.id_turma = t.id_turma || f.turma = t.id_turma
                LEFT JOIN instituicoes i
                ON t.id_instituicao = i.id_instituicao
                LEFT JOIN tipos_venda tv
                ON v.tipo = tv.id_tipo_venda
                LEFT JOIN contas co 
                ON mf.id_conta = co.id_conta
                LEFT JOIN cursos cu 
                ON t.curso = cu.id_curso
                WHERE (mf.`status` != 0)  AND 
                CONCAT(
                IFNULL(mf.id_movimentacao, ''),
                IFNULL((CASE 
                    WHEN df.id_item IS NULL AND t.ncontrato IS NULL
                        THEN 'Custo Fixo'
                        WHEN df.id_item IS NOT NULL 
                    THEN CONCAT(t.ncontrato, '-', f.id_cadastro)
                    ELSE t.ncontrato
                END
                ), ''), 
                IFNULL(IF(l.id_lancamento IS NOT NULL, cc.nome, tv.descricao_tipo_venda), ''),
                IFNULL(IF(df.posicao IS NOT NULL, CONCAT(df.posicao, '/', v.qtdparcelas), ''),
                CONCAT(l.parcela, '/', (SELECT COUNT(*)
                                        FROM lancamentos l2
                                        WHERE l2.chave_parcelamento != 0 
                                        AND l2.chave_parcelamento = l.chave_parcelamento))), 
                IFNULL(CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')), ''), 
                IFNULL(DATE_FORMAT(mf.`data`, '%d/%m/%Y'), ''), 
                IFNULL(REPLACE(mf.valor, '.', ','), ''),
                IFNULL(IF(l.id_lancamento IS NOT NULL, REPLACE(l.valor, '.', ','), REPLACE(df.valor, '.', ',')), ''),
                IFNULL(co.nome, ''),	
                IFNULL(mf.observacoes, '')
                )
                LIKE '%{$_GET['search']}%'
                ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
                LIMIT ".$_GET["offset"].", ".$_GET["limit"].
                "");

                $stmt->execute(array());

                return["additional" => $this->pdo->query("
                SELECT * FROM (
                    SELECT COUNT(*) count,
                    SUM(CASE WHEN mf.valor > 0 THEN mf.valor ELSE 0 END) positive_total,
                    SUM(CASE WHEN mf.valor < 0 THEN mf.valor ELSE 0 END) negative_total
                    FROM movimentacao_financeira mf 
                    LEFT JOIN categorias_contas cac
                    ON mf.id_catconta = cac.id_catconta
                    LEFT JOIN lancamentos l
                    ON mf.id_lancamento = l.id_lancamento
                    LEFT JOIN centro_custo cc
                    ON l.id_centro = cc.id_centro
                    LEFT JOIN clientes c
                    ON l.id_fornecedor = c.id_cli
                    LEFT JOIN categoriafornecedor cf ON
                    l.categoria_fornecedor = cf.id_categoria
                    LEFT JOIN duplicatas_faturas df
                    ON mf.id_duplicata = df.id_item
                    LEFT JOIN duplicatas d
                    ON df.id_duplicata = d.id_duplicata
                    LEFT JOIN vendas v 
                    ON  v.id_venda = d.id_venda
                    LEFT JOIN formandos f 
                    ON f.id_formando = v.id_formando
                    LEFT JOIN turmas t 
                    ON l.id_turma = t.id_turma || f.turma = t.id_turma
                    LEFT JOIN tipos_venda tv
                    ON v.tipo = tv.id_tipo_venda
                    LEFT JOIN contas co 
                    ON mf.id_conta = co.id_conta
                    LEFT JOIN cursos cu 
                    ON t.curso = cu.id_curso
                    WHERE (mf.`status` != 0) AND 
                    CONCAT(
                    IFNULL(mf.id_movimentacao, ''),
                    IFNULL((CASE 
                        WHEN df.id_item IS NULL AND t.ncontrato IS NULL
                            THEN 'Custo Fixo'
                            WHEN df.id_item IS NOT NULL 
                        THEN CONCAT(t.ncontrato, '-', f.id_cadastro)
                        ELSE t.ncontrato
                    END
                    ), ''), 
                    IFNULL(IF(l.id_lancamento IS NOT NULL, cc.nome, tv.descricao_tipo_venda), ''),
                    IFNULL(IF(df.posicao IS NOT NULL, CONCAT(df.posicao, '/', v.qtdparcelas), ''),
                    CONCAT(l.parcela, '/', (SELECT COUNT(*)
                                            FROM lancamentos l2
                                            WHERE l2.chave_parcelamento != 0 
                                            AND l2.chave_parcelamento = l.chave_parcelamento))), 
                    IFNULL(CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')), ''), 
                    IFNULL(DATE_FORMAT(mf.`data`, '%d/%m/%Y'), ''), 
                    IFNULL(REPLACE(mf.valor, '.', ','), ''),
                    IFNULL(IF(l.id_lancamento IS NOT NULL, REPLACE(l.valor, '.', ','), REPLACE(df.valor, '.', ',')), ''),
                    IFNULL(co.nome, ''),	
                    IFNULL(mf.observacoes, '')
                    )
                    LIKE '%{$_GET['search']}%'
                    ) movimentacoes
                    ")->fetch(\PDO::FETCH_ASSOC), "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];
            }


            public function getFluxoFuturo()
            {
$stmt = $this->pdo->prepare("
SELECT 
IFNULL(t.ncontrato, 'Custo Fixo') contrato,
IFNULL(CONCAT(cu.nome,' - ', t.ano, ' - ', i.nome), 'Despesas Administrativas') nome,
cec.nome centro_custo,
CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')) descricao,
CONCAT(l.parcela, '/', (SELECT COUNT(*)
								FROM lancamentos l2
								WHERE l2.chave_parcelamento != 0 
								AND l2.chave_parcelamento = l.chave_parcelamento)) parcela,
DATE_FORMAT(l.data_vencimento, '%d/%m/%Y') data_vencimento,
CONCAT('R$ ', REPLACE(l.valor, '.', ',')) valor
FROM lancamentos l
LEFT JOIN turmas t 
ON t.id_turma = l.id_turma
LEFT JOIN instituicoes i
ON t.id_instituicao = i.id_instituicao
LEFT JOIN clientes c 
ON c.id_cli = l.id_fornecedor
LEFT JOIN categoriafornecedor cf 
ON cf.id_categoria = l.categoria_fornecedor
LEFT JOIN ficha_tecnica ft 
ON ft.categoria_fornecedor = l.categoria_fornecedor
LEFT JOIN categorias_contas cac 
ON cac.id_catconta = ft.id_catconta
LEFT JOIN centro_custo cec 
ON cec.id_centro = l.id_centro
LEFT JOIN cursos cu 
ON t.curso = cu.id_curso
WHERE (l.`status` = 0) AND
CONCAT(IFNULL(t.ncontrato, 'Custo Fixo'), IFNULL(CONCAT(cu.nome,' - ', t.ano, ' - ', i.nome), 'Despesas Administrativas'), IFNULL(cec.nome, ''), CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')), CONCAT(l.parcela, '/', (SELECT COUNT(*)
								FROM lancamentos l2
								WHERE l2.chave_parcelamento != 0 
								AND l2.chave_parcelamento = l.chave_parcelamento)), 
DATE_FORMAT(l.data_vencimento, '%d/%m/%Y'),
REPLACE(l.valor, '.', ',')
) 
LIKE '%{$_GET['search']}%'

UNION ALL

SELECT
CONCAT(t.ncontrato, '-', f.id_cadastro) contrato,
f.nome nome,
tv.descricao_tipo_venda centro_custo,
CONCAT('Venda de ', tv.descricao_tipo_venda, ' - ', fp.nome) descricao,
CONCAT(df.posicao, '/', v.qtdparcelas) parcela,
DATE_FORMAT(df.`data`, '%d/%m/%Y') data_vencimento,
CONCAT('R$ ', REPLACE(df.valor, '.', ',')) valor
from duplicatas_faturas df
LEFT JOIN duplicatas d on d.id_duplicata = df.id_duplicata
LEFT JOIN vendas v on  v.id_venda = d.id_venda
LEFT JOIN formandos f on f.id_formando = v.id_formando
LEFT JOIN turmas t on t.id_turma = f.turma
LEFT JOIN formaspag fp on fp.id_forma = df.formapag
LEFT JOIN tipos_venda tv
ON tv.id_tipo_venda = v.tipo
where (v.status ='3' and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d') and df.status <> 2) AND
CONCAT(CONCAT(t.ncontrato, '-', f.id_cadastro), f.nome, tv.descricao_tipo_venda, CONCAT('VENDA DE ', tv.descricao_tipo_venda, ' - ', fp.nome), CONCAT(df.posicao, '/', v.qtdparcelas), DATE_FORMAT(df.`data`, '%d/%m/%Y'), REPLACE(df.valor, '.', ','))
LIKE '%{$_GET['search']}%'
ORDER BY ".$_GET["order"]." ".$_GET["dir"]."
LIMIT ".$_GET["offset"].", ".$_GET["limit"].
"");

$stmt->execute(array());

return ["additional" => $this->pdo->query("
SELECT  
SUM(ff.c) count,
SUM(ff.positive_total) positive_total,
SUM(ff.negative_total) negative_total
FROM 
(
SELECT 
COUNT(*) c,
SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END) positive_total,
SUM(CASE WHEN l.valor < 0 THEN l.valor ELSE 0 END) negative_total
FROM lancamentos l
LEFT JOIN turmas t 
ON t.id_turma = l.id_turma
LEFT JOIN instituicoes i
ON t.id_instituicao = i.id_instituicao
LEFT JOIN clientes c 
ON c.id_cli = l.id_fornecedor
LEFT JOIN categoriafornecedor cf 
ON cf.id_categoria = l.categoria_fornecedor
LEFT JOIN ficha_tecnica ft 
ON ft.categoria_fornecedor = l.categoria_fornecedor
LEFT JOIN categorias_contas cac 
ON cac.id_catconta = ft.id_catconta
LEFT JOIN centro_custo cec 
ON cec.id_centro = l.id_centro
LEFT JOIN cursos cu 
ON t.curso = cu.id_curso    
WHERE (l.`status` = 0) AND
CONCAT(IFNULL(t.ncontrato, 'Custo Fixo'), IFNULL(CONCAT(cu.nome,' - ', t.ano, ' - ', i.nome), 'Despesas Administrativas'), IFNULL(cec.nome, ''), CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')), CONCAT(l.parcela, '/', (SELECT COUNT(*)
                    FROM lancamentos l2
                    WHERE l2.chave_parcelamento != 0 
                    AND l2.chave_parcelamento = l.chave_parcelamento)), 
DATE_FORMAT(l.data_vencimento, '%d/%m/%Y'),
REPLACE(l.valor, '.', ',')
) 
LIKE '%{$_GET['search']}%'

UNION ALL

SELECT 
COUNT(*) c,
SUM(CASE WHEN df.valor > 0 THEN df.valor ELSE 0 END) positive_total,
SUM(CASE WHEN df.valor < 0 THEN df.valor ELSE 0 END) negative_total
from duplicatas_faturas df
left join duplicatas d on d.id_duplicata = df.id_duplicata
left join vendas v on  v.id_venda = d.id_venda
left join formandos f on f.id_formando = v.id_formando
left join turmas t on t.id_turma = f.turma
left join formaspag fp on fp.id_forma = df.formapag
LEFT JOIN tipos_venda tv
ON tv.id_tipo_venda = v.tipo
where (v.status ='3' and df.data >= DATE_FORMAT(NOW(), '%Y-%m-%d') and df.status <> 2) AND
CONCAT(CONCAT(t.ncontrato, '-', f.id_cadastro), f.nome, tv.descricao_tipo_venda, CONCAT('VENDA DE ', tv.descricao_tipo_venda, ' - ', fp.nome), CONCAT(df.posicao, '/', v.qtdparcelas), DATE_FORMAT(df.`data`, '%d/%m/%Y'), REPLACE(df.valor, '.', ','))
LIKE '%{$_GET['search']}%'
)ff
")->fetch(\PDO::FETCH_ASSOC), "results" => $stmt->fetchAll(\PDO::FETCH_ASSOC)];
            }

            
    public function getFluxoDeCaixaSearchByColumn($columns, $values)
    {
    
        $body = '';
        $body_sq = '';


        if($values) {
            $columns = explode(',', $columns);
            $values = explode(',', $values);

            for($i = 0; $i < count($columns); $i++){

                if($i == 0) {
                    $body .= "WHERE ";
                } else {
                    $body .= "AND ";
                }

                $body .= $columns[$i]." LIKE '%".$values[$i]."%' ";

                $body_sq .= "AND ". $columns[$i]." LIKE '%".$values[$i]."%' ";
            }

        }
        
        $stmt = $this->pdo->prepare("
            SELECT * FROM(
                SELECT mf.id_movimentacao,
                    (CASE 
                        WHEN v.id_formando IS NULL AND l.id_turma IS NULL || l.id_turma = 0
                            THEN 'Custo Fixo'
                        WHEN df.id_item IS NOT NULL 
                            THEN CONCAT(t.ncontrato, '-', f.id_cadastro)
                        ELSE t.ncontrato
                    END
                    )id_item,
                    IFNULL(f.nome, IFNULL(CONCAT(cu.nome,' - ', t.ano, ' - ', i.nome), 'Despesas Administrativas')) titulo,
                    IF(l.id_lancamento IS NOT NULL, cc.nome, tv.descricao_tipo_venda) centro_custo,
                    IF(df.posicao IS NOT NULL, CONCAT(df.posicao, '/', v.qtdparcelas), CONCAT(l.parcela, '/', (SELECT COALESCE(NULLIF(COUNT(*), 0 ), '1')
                                                                                                                                            FROM lancamentos l2
                                                                                                                                            WHERE l2.chave_parcelamento != 0 
                                                                                                                                        AND l2.chave_parcelamento = l.chave_parcelamento))) parcela,
                    CONCAT(IFNULL(CONCAT(cf.nome, ' - '),  ''), IFNULL(CONCAT(cac.titulo, ' - '), ''), IFNULL(c.nome, '')) descricao,
                    DATE_FORMAT(mf.`data`, '%d/%m/%Y') data_realizado,
                    IF(l.id_lancamento IS NOT NULL, DATE_FORMAT(l.data_vencimento, '%d/%m/%Y'), DATE_FORMAT(df.`data`, '%d/%m/%Y')) data_vencimento,
                    CONCAT('R$ ', REPLACE(mf.valor, '.', ',')) valor_realizado,
                    IF(l.id_lancamento IS NOT NULL, CONCAT('R$ ', REPLACE(l.valor, '.', ',')), CONCAT('R$ ', REPLACE(df.valor, '.', ','))) valor_total,
                    co.nome,
                    mf.observacoes
                    FROM movimentacao_financeira mf
                    LEFT JOIN categorias_contas cac
                    ON mf.id_catconta = cac.id_catconta
                    LEFT JOIN lancamentos l
                    ON mf.id_lancamento = l.id_lancamento
                    LEFT JOIN centro_custo cc
                    ON l.id_centro = cc.id_centro
                    LEFT JOIN clientes c
                    ON l.id_fornecedor = c.id_cli
                    LEFT JOIN categoriafornecedor cf ON
                    l.categoria_fornecedor = cf.id_categoria
                    LEFT JOIN duplicatas_faturas df
                    ON mf.id_duplicata = df.id_item
                    LEFT JOIN duplicatas d
                    ON df.id_duplicata = d.id_duplicata
                    LEFT JOIN vendas v 
                    ON  v.id_venda = d.id_venda
                    LEFT JOIN formandos f 
                    ON f.id_formando = v.id_formando
                    LEFT JOIN turmas t 
                    ON l.id_turma = t.id_turma || f.turma = t.id_turma
                    LEFT JOIN instituicoes i
                    ON t.id_instituicao = i.id_instituicao
                    LEFT JOIN tipos_venda tv
                    ON v.tipo = tv.id_tipo_venda
                    LEFT JOIN contas co 
                    ON mf.id_conta = co.id_conta
                    LEFT JOIN cursos cu 
                    ON t.curso = cu.id_curso
                    WHERE (mf.`status` != 0)
                    
            )sq 
            ". $body ."
            ORDER BY sq.".$_GET["order"]." ".$_GET["dir"]."
                    
        ");
        
        $stmt->execute(array());

            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
        return [
            "count" => 
            count($results),
            "results" => $results
        ];

    }


    }
