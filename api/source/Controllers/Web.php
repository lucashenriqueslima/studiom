<?php

    namespace Source\Controllers;

    use Source\Models\Titulos;
    use Source\Models\ReguaCobranca;
    use Source\Models\Contratos;
    use Source\Models\Vendas;
    use Source\Models\ExcecoesReguaCobranca;
    use Source\Models\Turmas;
    use Source\Models\Eventos;

    class Web extends Controller
    {
        public function getContasAReceber()
        {   

            @$this->formatParmsForTable("t.ncontrato {$_GET["dir"]}, f.id_cadastro", "ASC");
            $response = (new Titulos())->getContasAReceber(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);
        
            $this->jsonResponseForTables($response);
        }

        public function getRecebidos()
        {
            @$this->formatParmsForTable("t.ncontrato {$_GET["dir"]}, f.id_cadastro", "ASC");
            $response = (new Titulos())->getRecebidos(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);

            $this->jsonResponseForTables($response);
        }

        public function getCobrancas()
        {
            @$this->formatParmsForTable("t.ncontrato {$_GET["dir"]}, f.id_cadastro", "ASC");
            $response = (new Titulos())->getCobrancas(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);
            
            $this->jsonResponseForTables($response);
        }

        public function getContasAPagar()
        {
            @$this->formatParmsForTable("t.ncontrato");
            $response = (new Titulos())->getContasAPagar(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);

            $this->jsonResponseForTables($response);
        }

        public function getFluxoDeCaixa()
        {   

            @$this->formatParmsForTable("id_movimentacao");
            if(isset($_GET["bycolumn"])){
                $response = @(new Titulos())->getFluxoDeCaixaSearchByColumn($_GET['columns'], $_GET['values']);
                return @$this->jsonResponseForTables($response, true);                
            }
            
            $response = (new Titulos())->getFluxoDeCaixa(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);

            $this->jsonResponseForTables($response, true);
        }

        public function getFluxoFuturo()
        {
            @$this->formatParmsForTable("contrato");
            $response = (new Titulos())->getFluxoFuturo(@$_GET["limit"], @$_GET["offset"], @$_GET["search"], @$_GET["order"], @$_GET["dir"]);

            $this->jsonResponseForTables($response, true);
        }

        public function getReguaCobranca()
        {
            echo json_encode((new ReguaCobranca())->getReguaCobranca());
        }

        public function saveReguaCobranca($data)
        {

            (new ReguaCobranca())->deleteAllFromReguaCobranca();
            
            if(@count($data["reminder_names"])){

                for($i = 0; $i < count($data["reminder_names"]); $i++){
                    (new ReguaCobranca())->saveReguaCobranca($data, $i);
                }

            }

            $this->jsonResponse("message", [
                "icon" => "success",
                "message" => "Régua de Cobrança salva com sucesso!"
            ]);

        }

        public function getExcecoesReguaCobranca()
        {
            echo json_encode((new ExcecoesReguaCobranca())->getExcecoesReguaCobranca());
        }

        public function getFormandosFaculdades()
        {
            echo json_encode((new ExcecoesReguaCobranca())->getFormandosFaculdades());
        }

        public function getTipoContrato()
        {
            echo json_encode((new Contratos)->getTipoContrato($_GET["id_turma"]));
        }

        public function getTipoVendaByFormandoId()
        {
            echo json_encode((new Vendas)->getTipoVendaByFormandoId($_GET["id_formando"]));
        }

        public function saveExcecoesReguaCobranca($data)
        {


            if($data["is_formando"] == 0){
                
                if(isset($data["convite"])){
                    (new ExcecoesReguaCobranca)->saveExcecoesReguaCobrancaByFaculdade($data, 1, "convite");
                }

                if(isset($data["fotografia"])){
                    (new ExcecoesReguaCobranca)->saveExcecoesReguaCobrancaByFaculdade($data, 2, "fotografia");
                }

                if(isset($data["ensaio"])){
                    (new ExcecoesReguaCobranca)->saveExcecoesReguaCobrancaByFaculdade($data, 4, "ensaio");
                }
                
                

                $this->jsonResponse("message", [
                    "icon" => "success",
                    "message" => "Régua de Cobrança salva com sucesso!"
                ]);
                return;
            }
            
            for($i = 0; $i < count($data["parcela"]); $i++){
                (new ExcecoesReguaCobranca)->saveExcecoesReguaCobrancaByFormando($data, $data["parcela"][$i]);
            }

            $this->jsonResponse("message", [
                "icon" => "success",
                "message" => "Régua de Cobrança salva com sucesso!"
            ]);
            return;
        
        }

        public function deleteExcecaoReguaCobranca($data)
        {
            (new ExcecoesReguaCobranca)->deleteExcecaoReguaCobranca($data);

            $this->jsonResponse("message", [
                "icon" => "success",
                "message" => "Exceção deletada com sucesso!"
            ]);

        }

        public function getTurmas()
        {
            echo json_encode((new Turmas())->getTurmas());
        }
        
        public function getEventosByTurma()
        {
            $eventos = ((new Eventos())->getEventosByTurma());

            if(is_dir(FOTOS_SEPARADAS["path"] . "/{$_GET["id_turma"]}/")){
                foreach($eventos as $evento){
                    if(is_dir(FOTOS_SEPARADAS["path"] . "/{$_GET["id_turma"]}/{$evento["sigla"]}")){
                        $evento["has_folder"] = true;
                    }else{
                        $evento["has_folder"] = false;
                    }
                }
            }

            echo json_encode($eventos);
            

            


        }

        public function verificaDiretorioEvento()
        {
        }

    }