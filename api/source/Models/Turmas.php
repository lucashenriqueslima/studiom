<?php

    namespace Source\Models;

    Class Turmas extends Model
    {   

        public function getTurmas()
        {
            return $this->pdo->query("SELECT t.id_turma id,
            IFNULL(CONCAT(t.ncontrato, ' - ', c.nome,' - ', t.ano, ' - ', i.nome), 'Sem Informação') descricao
            FROM turmas t
            LEFT JOIN cursos c
            ON c.id_curso = t.curso
            LEFT JOIN instituicoes i
            ON t.id_instituicao = i.id_instituicao
            ORDER BY t.ncontrato")->fetchAll(\PDO::FETCH_ASSOC);
        }


    }