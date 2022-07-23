<?php

    namespace Source\Models;

    Class Vendas extends Model
    {   
        public function getTipoVendaByFormandoId($id_formando)
        {
            $stmt = $this->pdo->prepare("
                SELECT df.id_item,
                tv.descricao_tipo_venda, 
                IFNULL(CONCAT(df.posicao, '/', v.qtdparcelas), '1/1') parcela,
                DATE_FORMAT(df.`data`, '%d/%m/%Y') AS vencimento
                FROM vendas v 
                INNER JOIN duplicatas d
                ON v.id_venda = d.id_venda
                INNER JOIN duplicatas_faturas df
                ON d.id_duplicata = df.id_duplicata
                INNER JOIN tipos_venda tv
                ON v.tipo = tv.id_tipo_venda
                WHERE v.formapag IN (2, 8, 18, 22)
                AND v.`status` = 3
                AND d.id_formando = ?
                ORDER BY tv.descricao_tipo_venda, df.posicao
            ");

            $stmt->execute(array($id_formando));

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            return $response;
        }
    }