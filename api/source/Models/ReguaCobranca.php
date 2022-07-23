<?php

    namespace Source\Models;

    Class ReguaCobranca extends Model
    {   
        public function deleteAllFromReguaCobranca()
        {
            $this->pdo->query("DELETE FROM lembrete_regua_cobranca");
        }
        
        public function saveReguaCobranca($data, $i)
        {

            $stmt = $this->pdo->prepare("INSERT INTO `lembrete_regua_cobranca` 
                                        (`id_lembrete_regua_cobranca`, `nome_lembrete`, `dia`, `destinatario`, `enviar_boleto_wpp`, `enviar_boleto_email`, `mensagem_wpp`, `mensagem_email`, `mensagem_colaborador`) 
                                        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);
            )");
            $stmt->execute(array(
                $data["reminder_names"][$i],
                $data["days"][$i],
                ($data["destinatarys"][$i] != "colaborador" ? "1" : "0"),
                (@$data["is_to_send_bill_by_wpp"][$i] == "on" ? "1" : "0"),
                (@$data["is_to_send_bill_by_email"][$i] == "on" ? "1" : "0"),
                @$data["wpp_messages"][$i],
                @$data["email_messages"][$i],
                @$data["colaborador_messages"][$i]
        ));

        }

        public function getReguaCobranca()
        {
            $stmt = $this->pdo->query("SELECT * FROM lembrete_regua_cobranca ORDER BY dia");
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }

        public function getReguaCobrancaToScript()
        {

            $stmt = $this->pdo->query("
            SELECT f.nome as nome_formando,
            f.telefone,
            t.ncontrato,
            v.qtdparcelas,
            df.id_item,
            CONCAT(t.ncontrato, '-', f.id_cadastro) AS id,
            tv.descricao_tipo_venda,
            fp.nome as fpnome,
            CONCAT(df.posicao, '/', v.qtdparcelas) AS parcela_atual,
            REPLACE(df.valor, '.', ',') AS valor,
            DATEDIFF('{$_GET['data-filtro']}', df.data) datedif,
            DATE_FORMAT(df.`data`, '%d/%m/%Y') AS data_vencimento,
            lrc.mensagem_wpp,
            IFNULL(CONCAT('https://api.getnet.com.br', df.link), CONCAT('https://www.studiomfotografia.com.br/sistema/arquivos/', df.arquivo)) boleto_wpp,
            df.link,
            tv.descricao_tipo_venda produto_servico
            from duplicatas_faturas df
            left join duplicatas d on d.id_duplicata = df.id_duplicata
            left join vendas v on  v.id_venda = d.id_venda
            left join formandos f on f.id_formando = v.id_formando
            left join turmas t on t.id_turma = f.turma
            left join fomentos fo on fo.id_fomento=df.id_fomento
            left join formaspag fp on fp.id_forma = df.formapag
            LEFT JOIN tipos_venda tv
            ON tv.id_tipo_venda = v.tipo
            LEFT JOIN lembrete_regua_cobranca_erros lrce
            ON df.id_item = lrce.id_duplicata_fatura AND '{$_GET['data-filtro']}' = lrce.data_execucao
            INNER JOIN lembrete_regua_cobranca lrc
            ON lrc.dia = DATEDIFF('{$_GET['data-filtro']}', df.data)
            where (v.status ='3' AND (DATEDIFF('{$_GET['data-filtro']}', df.data) IN (SELECT DISTINCT lrb.dia FROM lembrete_regua_cobranca lrb WHERE lrb.destinatario = 1) and (df.status = 1 || df.status = 4)) or (df.status = 2 and (df.pagamento is null or df.pagamento = 0) and DATEDIFF('{$_GET['data-filtro']}', df.data) IN (SELECT DISTINCT lrb.dia FROM lembrete_regua_cobranca lrb WHERE lrb.destinatario = 1)))
            AND v.id_venda NOT IN (SELECT v2.id_venda FROM vendas v2
            INNER JOIN formandos f2
            ON v2.id_formando = f2.id_formando
            INNER JOIN excecao_regua_cobranca erc
            ON f2.turma = erc.id_turma AND v2.tipo = erc.id_tipo_venda)
            AND df.id_item NOT IN (SELECT erc.id_duplicata_fatura FROM excecao_regua_cobranca erc WHERE erc.id_duplicata_fatura IS NOT NULL)
            AND f.id_formando NOT IN (1816, 10703)
            LIMIT 1000 OFFSET 1");
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }

        public function saveReguaCobrancaErro($data)
        {
            $stmt = $this->pdo->prepare("
            INSERT INTO `lembrete_regua_cobranca_erros` 
            (`id_lembrete_regua_cobranca_erro`, `id_duplicata_fatura`, `cod_formando`, `nome_formando`, `telefone`, `parcela`, `data_execucao`, `motivo`) 
            VALUES (NULL, ?, ?, ?, ?, ?, CURDATE(), ?)
            ");

            $stmt->execute(array(
                $data["id_duplicata_fatura"],
                $data["cod_formando"],
                $data["nome_formando"],
                $data["telefone"],
                $data["parcela"],
                $data["motivo"]
                ));
        }

        public function getExcecoesReguaCobranca()
        {
            $stmt = $this->pdo->query("
            SELECT f.nome as nome_formando,
            f.telefone,
            t.ncontrato,
            v.qtdparcelas,
            df.id_item,
            CONCAT(t.ncontrato, '-', f.id_cadastro) AS id,
            tv.descricao_tipo_venda,
            fp.nome as fpnome,
            CONCAT(df.posicao, '/', v.qtdparcelas) AS parcela_atual,
            REPLACE(df.valor, '.', ',') AS valor,
            DATEDIFF(CURDATE(), df.data) datedif,
            DATE_FORMAT(df.`data`, '%d/%m/%Y') AS data_vencimento,
            lrc.mensagem_wpp,
            IFNULL(CONCAT('https://api.getnet.com.br', df.link), CONCAT('https://www.studiomfotografia.com.br/sistema/arquivos/', df.arquivo)) boleto_wpp,
            df.link
            from duplicatas_faturas df
            left join duplicatas d on d.id_duplicata = df.id_duplicata
            left join vendas v on  v.id_venda = d.id_venda
            left join formandos f on f.id_formando = v.id_formando
            left join turmas t on t.id_turma = f.turma
            left join fomentos fo on fo.id_fomento=df.id_fomento
            left join formaspag fp on fp.id_forma = df.formapag
            LEFT JOIN tipos_venda tv
            ON tv.id_tipo_venda = v.tipo
            INNER JOIN lembrete_regua_cobranca lrc
            ON lrc.dia = DATEDIFF(CURDATE(), df.data)
            where (v.status ='3' AND (DATEDIFF(CURDATE(), df.data) IN (SELECT DISTINCT lrb.dia FROM lembrete_regua_cobranca lrb WHERE lrb.destinatario = 1) and (df.status = 1 || df.status = 4)) or (df.status = 2 and (df.pagamento is null or df.pagamento = 0) and DATEDIFF(CURDATE(), df.data) IN (SELECT DISTINCT lrb.dia FROM lembrete_regua_cobranca lrb WHERE lrb.destinatario = 1)))
            ");

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }

        public function getErrosReguaCobranca() 
        {
            return $this->pdo->query("SELECT * FROM `lembrete_regua_cobranca_erros` WHERE `data_execucao` = '{$_GET['data-filtro']}'")->fetchAll(\PDO::FETCH_ASSOC);
        }
    }