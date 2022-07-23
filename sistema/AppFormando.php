<?php

    namespace Source\Controllers;

    use Source\Models\Formandos;
    use Source\Models\Convites;

    class AppFormando extends Controller
    {

        private string $id_formando;

        public function __construct($data)
        {

            $http_header = apache_request_headers();
            $token = explode(" ", $http_header["Authorization"])[1];

            $header = explode(".", $token)[0];
            $payload = explode(".", $token)[1];
            $sign = explode(".", $token)[2];

            $valid = hash_hmac('sha256', $header . "." . $payload, "a)()8***0--asf", true);
            $valid = base64_encode($valid);

            if($valid != $sign){

                session_destroy();

                echo json_encode([
                    "status" => "error",
                    "message" => "Token inválido."
                ]);
                die;
            }

            $this->id_formando = json_decode(base64_decode($payload))->id_formando;
            
        }

        public function getDadosConvite($data)
        {
            echo json_encode((new Convites())->getDadosConvite($this->id_formando));
        }

        public function saveDadosConvite($data)
        {

            if(!isset($data["nome_mae"])){
                $data["nao_mostrar_mae_convite"] = 1;
            }

            if(!isset($data["nome_pai"])){
                $data["nao_mostrar_pai_convite"] = 1;
            }


            unset($data["nome_pessoas"][0]);
            unset($data["inmemoriam_pessoas"][0]);
            
            for($i = 1; $i <= count($data["nome_pessoas"]); $i++){
                if(@empty($data["nome_pessoas"][$i])){
                     $this->jsonResponse("message", [
                        "icon" => "error",
                        "message" => "Favor, preencha o nome de todos os responsáveis."
                    ]);
                    return;
                }
            }

            (new Convites())->saveDadosConvite($this->id_formando, $data);
            
            $this->jsonResponse("message", [
                "icon" => "success",
                "message" => "Nomes salvos com sucesso."
            ]);
            

        }

        public function saveDadosTextosConvite($data)
        {

            if(@$data["texto_convite_familia"] == "" || $data["texto_convite_individual"] == ""){
                $this->jsonResponse("message", [
                    "icon" => "error",
                    "message" => "Favor, preencha o texto do convite."
                ]);
                return;
            }

            $data["texto_convite_familia"] = addslashes($data["texto_convite_familia"]);
            $data["texto_convite_individual"] = addslashes($data["texto_convite_individual"]);


            (new Convites())->saveDadosTextosConvite($this->id_formando, $data);

            $this->jsonResponse("message", [
                "icon" => "success",
                "message" => "Textos salvos com sucesso."
            ]);

        }
    }