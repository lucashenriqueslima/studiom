<?php

    namespace Source\Models;

    Class Contratos extends Model
    {   
        public function getTipoContrato($id_turma)
        {
            $stmt = $this->pdo->prepare("
            SELECT v.tipo FROM vendas v
            INNER JOIN formandos f
            ON v.id_formando = f.id_formando
            WHERE v.id_formando IN (SELECT f2.id_formando FROM formandos f2 WHERE f2.turma = ?)
            GROUP BY v.tipo
            ");

            $stmt->execute(array($id_turma));

            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $response;
        }
    }