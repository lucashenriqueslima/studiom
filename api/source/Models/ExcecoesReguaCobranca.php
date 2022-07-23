<?php

    namespace Source\Models;

    Class ExcecoesReguaCobranca extends Model
    {  

        public function getFormandosFaculdades()
        {
            $stmt = $this->pdo->query("
            SELECT f.id_formando id,
            IFNULL(CONCAT(IFNULL(t.ncontrato, ''), ' - ', IFNULL(f.id_cadastro, ''), ' - ', IFNULL(f.nome, '')), 'Sem Informação') descricao,
            (SELECT 1) is_formando
            FROM formandos f
            INNER JOIN duplicatas d
            ON f.id_formando = d.id_formando
            INNER JOIN duplicatas_faturas df
            ON d.id_duplicata = df.id_duplicata
            INNER JOIN turmas t
            ON f.turma = t.id_turma
            WHERE df.id_item NOT IN (SELECT IFNULL(erc.id_duplicata_fatura, '0') FROM excecao_regua_cobranca erc)
            AND (SELECT count(*) 
                FROM duplicatas_faturas df 
                INNER JOIN duplicatas d
                ON df.id_duplicata = d.id_duplicata
                INNER JOIN vendas v
                ON d.id_venda = v.id_venda
                WHERE v.status = 3 
                AND v.id_formando = f.id_formando
				) > 0
            
            UNION 
            
            SELECT t.id_turma id,
            IFNULL(CONCAT(t.ncontrato, ' - ', c.nome,' - ', t.ano, ' - ', i.nome), 'Sem Informação') descricao,
            (SELECT 0) is_formando
            FROM turmas t
            LEFT JOIN cursos c
            ON c.id_curso = t.curso
            LEFT JOIN instituicoes i
            ON t.id_instituicao = i.id_instituicao
            WHERE 0 < (SELECT COUNT(*) FROM vendas v WHERE v.id_formando IN (SELECT f2.id_formando FROM formandos f2 WHERE f2.turma = t.id_turma) AND v.tipo IN (1, 2 ,4))
            ORDER BY is_formando, descricao
            ");

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }

        public function saveExcecoesReguaCobrancaByFaculdade($data, $id_tipo_venda, $index_name)
        {
            
            $stmt = $this->pdo->prepare("

            INSERT INTO `excecao_regua_cobranca` 
            (`id_excecao_regua_cobranca`, `id_duplicata_fatura`, `id_turma`, `id_tipo_venda`, `motivo`, `observacao`) 
            VALUES (NULL, NULL, ?, ?, ?, ?);

            ");
            $stmt->execute(array($data[$index_name], $id_tipo_venda, $data["motivo"], $data["observacao"]));
        }

        public function saveExcecoesReguaCobrancaByFormando($data, $parcela)
        {
            $stmt = $this->pdo->prepare("
        
            INSERT INTO `excecao_regua_cobranca` 
            (`id_excecao_regua_cobranca`, `id_duplicata_fatura`, `id_turma`, `id_tipo_venda`, `motivo`, `observacao`) 
            VALUES (NULL, ?, NULL, NULL, ?, ?);

            )");
            $stmt->execute(array($parcela, $data["motivo"], $data["observacao"]));
        }

        public function getExcecoesReguaCobranca()
        {
            $stmt = $this->pdo->query("
            SELECT DISTINCT(erc.id_excecao_regua_cobranca) id_excecao, 
            CONCAT(t.ncontrato, ' - ', f.id_cadastro) id_item,
            tv.descricao_tipo_venda tipo_venda,
            CONCAT(df.posicao, '/', v.qtdparcelas) parcela,
            CONCAT('R$ ', REPLACE(df.valor, '.', ',')) valor,
            mec.motivo,
            erc.observacao,
            '1' is_formando
            FROM excecao_regua_cobranca erc
            LEFT JOIN duplicatas_faturas df
            ON erc.id_duplicata_fatura = df.id_item
            LEFT JOIN duplicatas d 
            ON df.id_duplicata = d.id_duplicata
            LEFT JOIN vendas v
            ON d.id_venda = v.id_venda
            LEFT JOIN tipos_venda tv
            ON v.tipo = tv.id_tipo_venda
            LEFT JOIN formandos f
            ON v.id_formando = f.id_formando
            LEFT JOIN turmas t
            ON f.turma = t.id_turma
            INNER JOIN motivos_excecao_cobranca mec
            ON erc.motivo = mec.id_motivo_excecao_cobranca
            WHERE erc.id_duplicata_fatura IS NOT NULL
            
            UNION
            
            
            SELECT DISTINCT(erc.id_excecao_regua_cobranca) id_excecao,
            t.ncontrato id_item,
            tv.descricao_tipo_venda,
            'Todas' parcela,
            CONCAT('R$ ', REPLACE(  (SELECT SUM(v.valorvenda) 
                                    FROM vendas v
                                    INNER JOIN formandos f
                                    ON v.id_formando = f.id_formando
                                    INNER JOIN excecao_regua_cobranca erc2
                                    ON f.turma = erc2.id_turma 
                                    AND v.tipo = erc2.id_tipo_venda 
                                    AND erc2.id_turma IS NOT NULL
                                    WHERE erc2.id_excecao_regua_cobranca = erc.id_excecao_regua_cobranca), '.', ',')
                                    ) valor,
            mec.motivo,
            erc.observacao,
            '0' is_formando
            FROM excecao_regua_cobranca erc
            INNER JOIN turmas t
            ON erc.id_turma = t.id_turma
            INNER JOIN tipos_venda tv
            ON erc.id_tipo_venda = tv.id_tipo_venda
            INNER JOIN motivos_excecao_cobranca mec
            ON erc.motivo = mec.id_motivo_excecao_cobranca
            WHERE erc.id_turma IS NOT NULL
            ORDER BY is_formando, tipo_venda, parcela
            ");

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }

        public function deleteExcecaoReguaCobranca($data)
        {
            $stmt = $this->pdo->prepare("

            DELETE FROM excecao_regua_cobranca
            WHERE id_excecao_regua_cobranca = ?

            ");
            
            $stmt->execute(array($data['id_excecao']));
        }

    }