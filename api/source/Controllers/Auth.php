<?php

    namespace Source\Controllers;

    use Source\Models\Formandos;

    class Auth extends Controller
    {   
        public function loginFormando()
        {   

            $result = (new Formandos())->loginFormando($_GET["user"], $_GET["passwd"]);

            if(!$result){

                echo json_encode([
                    "status" => "error",
                    "message" => "Usuário ou senha inválidos."
                ]);
                
                return;
            }

            $key = "a)()8***0--asf";

            //Header Token
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Payload - Content
            $payload = [
                'id_formando' => $result["id_formando"],
                'email' => $result["email"],
                'id_turma' => $result["turma"],
                'token_for' => 'formando'
            ];

            //JSON
            $header = json_encode($header);
            $payload = json_encode($payload);

            //Base 64
            $header = base64_encode($header);
            $payload = base64_encode($payload);

            //Sign
            $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
            $sign = base64_encode($sign);

            //Token
            $token = $header . '.' . $payload . '.' . $sign;

            echo json_encode([
                "status" => "success",
                "token_formando" => $token,
                "id_formando" => $result["id_formando"],
            ]);

            
        }


    }