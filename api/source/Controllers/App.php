<?php

    namespace Source\Controllers;

    use Source\Models\Formandos;

    class App extends Controller
    {
        private string $id_formando;
        private string $id_turma;
        public $data;

        public function __construct($data)
        {
                
            $http_header = apache_request_headers();

            $token = explode(" ", $http_header["Authorization"])[1];

            $token = explode(".", $token);

            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

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

            if(json_decode(base64_decode($payload))->token_for != "formando"){

                session_destroy();

                echo json_encode([
                    "status" => "error",
                    "message" => "Token inválido."
                ]);
                die;
            }

            $this->id_formando = json_decode(base64_decode($payload))->id_formando;
            $this->id_turma = json_decode(base64_decode($payload))->id_turma;
            $this->data = json_decode(file_get_contents('php://input'));
        }

        public function getMensagens()
        {
            $result = (new Formandos())->getMensagens($this->id_formando, $this->id_turma);

            echo json_encode($result);
        }

        public function updateMensagemStatus()
        {
            // echo $this->data;
            // die;
            (new Formandos())->updateMensagemStatus($this->id_formando, $this->id_turma, $this->data);   
        }

    }