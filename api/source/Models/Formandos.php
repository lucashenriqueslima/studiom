<?php

    namespace Source\Models;

    Class Formandos extends Model
    {

        public function verifyCredentials($id_formando, $passwd)
        {
            $stmt = $this->pdo->prepare("SELECT count(*) FROM formandos WHERE id_formando = ? AND senha = ?");
            $stmt->execute(array($id_formando, $passwd));
            return $stmt->rowcount();
        }

        public function loginFormando($user, $passwd)
        {
            $stmt = $this->pdo->prepare("SELECT id_formando, email, turma FROM formandos WHERE email = ? AND senha = ? AND status = '1'");
            $stmt->execute(array($user, $passwd));
            return $stmt->fetch();
            
        }

        public function getContatos()
        {
            $stmt = $this->pdo->query("SELECT (SELECT COUNT(*) FROM formandos) - qf.qtd_formandos  qtd_formando_diario FROM qtd_formandos qf");

            $qtd_formando_diario = $stmt->fetch()["qtd_formando_diario"];

            $this->pdo->query("UPDATE qtd_formandos SET qtd_formandos = qtd_formandos + {$qtd_formando_diario}, data_qtd_formandos = CURDATE()");

            return $this->pdo->query(
            "SELECT  CONCAT(t.ncontrato, '-', f.id_cadastro, ' ', f.nome) nome,
            f.telefone celular
            FROM formandos f
            INNER JOIN turmas t
            ON f.turma = t.id_turma
            ORDER BY f.id_formando DESC
            LIMIT {$qtd_formando_diario}
            ")->fetchAll(\PDO::FETCH_ASSOC);

        // return $this->pdo->query("
        // SELECT  CONCAT(t.ncontrato, '-', f.id_cadastro, ' ', f.nome) nome,
        //     f.telefone celular
        //     FROM formandos f
        //     INNER JOIN turmas t
        //     ON f.turma = t.id_turma
        //     WHERE t.id_turma IN (215,217,218,219,220,223,225,226,227,229)
        //     ORDER BY f.id_formando DESC
        //     ");
            
        }

        public function getMensagens($id_formando, $id_turma)
        {

            if(!isset($_GET["total"])){
                
                $stmt = $this->pdo->prepare("
                SELECT nf.id_notificacao_formando id_notificacao,
                '0' is_notificao_turma,
                nf.titulo,
                nf.icone,
                nf.icone_cor,
                nf.link,
                nf.mensagem,
                nf.`status` status,
                nf.momento
                FROM notificacoes_formando nf
                WHERE nf.id_formando = ? AND nf.id_notificacao_formando_turma IS NULL 
    
                UNION
    
                SELECT nt.id_notificacao_turma id_notificacao,
                '1' is_notificao_turma, 
                nt.titulo titulo,
                nt.icone icone,
                nt.icone_cor icone_cor,
                nt.link link,
                nt.mensagem mensagem,
                IF(nft.id_notificacao_formando_turma IS NULL, 1, 0) status,
                nt.momento momento
                FROM notificacoes_turma nt
                LEFT JOIN notificacoes_formando_turma nft
                ON nt.id_notificacao_turma = nft.id_notificacao_turma AND nft.id_formando = ?
                WHERE nt.id_turma = ?
                ORDER BY momento DESC
                LIMIT 6
                ");
                $stmt->execute(array($id_formando, $id_formando, $id_turma));
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);

            }

            $stmt = $this->pdo->prepare("
            SELECT nf.id_notificacao_formando id_notificacao,
            '0' is_notificao_turma,
            nf.titulo,
            nf.icone,
            nf.icone_cor,
            nf.link,
            nf.mensagem,
            nf.`status` status,
            nf.momento
            FROM notificacoes_formando nf
            WHERE nf.id_formando = ? AND nf.id_notificacao_formando_turma IS NULL 

            UNION

            SELECT nt.id_notificacao_turma id_notificacao,
            '1' is_notificao_turma, 
            nt.titulo titulo,
            nt.icone icone,
            nt.icone_cor icone_cor,
            nt.link link,
            nt.mensagem mensagem,
            IF(nft.id_notificacao_formando_turma IS NULL, 1, 0) status,
            nt.momento momento
            FROM notificacoes_turma nt
            LEFT JOIN notificacoes_formando_turma nft
            ON nt.id_notificacao_turma = nft.id_notificacao_turma AND nft.id_formando = ?
            WHERE nt.id_turma = ?
            ORDER BY momento DESC
            ");
            $stmt->execute(array($id_formando, $id_formando, $id_turma));
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function updateMensagemStatus($id_formando, $id_turma, $data)
        {   

            if($data->is_notificao_turma == "0"){
                $stmt = $this->pdo->prepare("UPDATE notificacoes_formando SET status = '0', data_vista = SYSDATE() WHERE id_formando = ? AND id_notificacao_formando = ?");
                $stmt->execute(array($id_formando, $data->id_notificacao));
                return;
            }


            $stmt = $this->pdo->prepare("
            INSERT INTO `notificacoes_formando_turma` 
            (`id_notificacao_formando_turma`, `id_formando`, `id_notificacao_turma`, `data_vista`) 
            VALUES (NULL, ?, ?, SYSDATE());            
            ");

            $stmt->execute(array($id_formando, $data->id_notificacao));
        }

    }