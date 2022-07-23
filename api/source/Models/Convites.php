<?php

    namespace Source\Models;

    class Convites extends Model {

        public function getDadosConvite($id_formando)
        {
            $stmt = $this->pdo->prepare("SELECT f.pai, f.mae, f.inmemorianpai, f.inmemorianmae FROM formandos f WHERE f.id_formando = ?");
            $stmt->execute(array($id_formando));
            $results["pais"] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmt = $this->pdo->prepare("SELECT dn.id_nomes, dn.nome, dn.inmemoriam FROM dadosconvite_nomes dn WHERE dn.id_formando = ?");
            $stmt->execute(array($id_formando));
            $results["pessoas"] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $results;
        }

        public function saveDadosConvite($id_formando, $data)
        {   

            $stmt = $this->pdo->prepare("DELETE FROM dadosconvite_nomes WHERE id_formando = ?");
            $stmt->execute(array($id_formando));

            for($i = 1; $i <= count($data["nome_pessoas"]); $i++){
                $stmt = $this->pdo->prepare("INSERT INTO dadosconvite_nomes (id_formando, nome, inmemoriam) VALUES (?, ?, ?)");
                $stmt->execute(array($id_formando, $data["nome_pessoas"][$i], $data["inmemoriam_pessoas"][$i]));
            }

            if(@$data["nao_mostrar_mae_convite"] == 1){
                $stmt = $this->pdo->prepare("UPDATE formandos SET nao_mostrar_mae_convite = ? WHERE id_formando = ?");
                $stmt->execute(array($data["nao_mostrar_mae_convite"], $id_formando));
            }else{                
                $stmt = $this->pdo->prepare("UPDATE formandos SET mae = ?, inmemorianmae = ?, nao_mostrar_mae_convite = 0 WHERE id_formando = ?");
                $stmt->execute(array($data["nome_mae"], $data["inememorian_mae"], $id_formando));
            }

            if(@$data["nao_mostrar_pai_convite"] == 1){
                $stmt = $this->pdo->prepare("UPDATE formandos SET nao_mostrar_pai_convite = ? WHERE id_formando = ?");
                $stmt->execute(array($data["nao_mostrar_pai_convite"], $id_formando));
            }else{                
                $stmt = $this->pdo->prepare("UPDATE formandos SET pai = ?, inmemorianpai = ?, nao_mostrar_pai_convite = 0 WHERE id_formando = ?");
                $stmt->execute(array($data["nome_pai"], $data["inememorian_pai"], $id_formando));
            }

        }

        public function saveDadosTextosConvite( $id_formando, $data )
        {

            $stmt = $this->pdo->prepare("SELECT turma FROM formandos WHERE id_formando = ?");
            $stmt->execute(array($id_formando));
            $id_turma = $stmt->fetch(\PDO::FETCH_ASSOC);

            
                $stmt = $this->pdo->prepare("DELETE FROM dadosconvite WHERE id_tipo IN (1, 2) AND id_turma = ".$id_turma['turma']." AND id_formando = ? ");
                $stmt->execute(array($id_formando));

                if(isset($data["texto_convite_familia"])){
                    $stmt = $this->pdo->prepare("INSERT INTO dadosconvite (id_turma, id_formando, id_tipo, texto) VALUES (".$id_turma['turma'].", ?, 2, ?)");
                    $stmt->execute(array($id_formando, $data["texto_convite_familia"]));
                }

                $stmt = $this->pdo->prepare("INSERT INTO dadosconvite (id_formando, id_turma, id_tipo, texto) VALUES (?, ".$id_turma['turma'].", 1, ?)");
                $stmt->execute(array($id_formando, $data["texto_convite_individual"]));
            
        }        
    }