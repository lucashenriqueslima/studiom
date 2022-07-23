<?php

    namespace Source\Models;

    Class Eventos extends Model
    {
        public function getEventosByTurma()
        {
            $stmt = $this->pdo->prepare("
            SELECT et.id_evento,
            CONCAT(et.nome, ' - ', ce.nome) descricao,
            ce.sigla
            FROM eventos_turma et
            INNER JOIN categoriaevento ce
            ON et.id_categoria = ce.id_categoria
            INNER JOIN turmas t
            ON et.id_turma = t.id_turma
            WHERE t.id_turma = ?
            ");

            $stmt->execute(array($_GET["id_turma"]));

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }  

    }