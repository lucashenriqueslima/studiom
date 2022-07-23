<?php

    namespace Source\Controllers;

use Source\Models\Formandos;
use Source\Models\Titulos;
    use Source\Models\ReguaCobranca;

    class Script extends Controller
    {
        public function __construct($data)
        {
            @$_GET["passwd"] != "a)()8***0--asf" ? die("Token inválido.") : null;
        }

        public function getReguaCobrancaToScript()
        {

            if(!isset($_GET["data-filtro"]))
            {
                $_GET["data-filtro"] = date("Y-m-d");
            }

            $dia_da_semana = date('w', strtotime($_GET["data-filtro"]));

            if($dia_da_semana == 6 || $dia_da_semana == 0)
            {
                return;
            }
            
            $feriados = json_decode('
            [{"date":"2022-01-01",
                "name":"Confraterniza\u00e7\u00e3o Universal",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-02-28",
                "name":"Carnaval",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-03-01",
                "name":"Carnaval",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-03-02",
                "name":"Quarta-feira de Cinzas",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-04-15",
                "name":"Sexta-feira Santa",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-04-21",
                "name":"Tiradentes",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-05-01",
                "name":"Dia do Trabalhador",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-06-16",
                "name":"Corpus Christi",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-09-07",
                "name":"Independ\u00eancia do Brasil",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-10-12",
                "name":"Nossa Senhora Aparecida",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-10-28",
                "name":"Dia do Servidor P\u00fablico",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-11-02",
                "name":"Finados",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-11-15",
                "name":"Proclama\u00e7\u00e3o da Rep\u00fablica",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-12-24",
                "name":"V\u00e9spera de Natal",
                "type":"facultativo",
                "level":"nacional"},
            {"date":"2022-12-25",
                "name":"Natal",
                "type":"feriado",
                "level":"nacional"},
            {"date":"2022-12-31",
                "name":"V\u00e9spera de Ano-Novo",
                "type":"facultativo",
                "level":"nacional"}]
            ', true);

            for($i = 0; $i < count($feriados); $i++)
            {
                if($feriados[$i]["date"] == $_GET["data-filtro"])
                {
                    return;
                }
            }


            $data = (new ReguaCobranca())->getReguaCobrancaToScript();

            for($i = 0; $i < count($data); $i++){

                $data[$i]["mensagem_wpp"] = $this->replaceParse($data[$i]['mensagem_wpp'], $data[$i]);

            }

            echo json_encode($data);
        }

        public function getErrosReguaCobranca()
        {        
            if(!isset($_GET["data-filtro"]))
            {
                $_GET["data-filtro"] = date("Y-m-d");
            }

            echo json_encode((new ReguaCobranca())->getErrosReguaCobranca());
        }

        public function saveReguaCobrancaErro()
        {
            (new ReguaCobranca())->saveReguaCobrancaErro($_POST);
            echo json_encode([$_POST]);
        }

        public function getContatos()
        {

            $dados = (new Formandos())->getContatos();

            // if(count($dados) == 0)
            // {
            //     return;
            //     die;
            // }

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="contatos'. date('Y-m-d') .'.csv"');
            
            $header = 'Name,Given Name,Additional Name,Family Name,Yomi Name,Given Name Yomi,Additional Name Yomi,Family Name Yomi,Name Prefix,Name Suffix,Initials,Nickname,Short Name,Maiden Name,Birthday,Gender,Location,Billing Information,Directory Server,Mileage,Occupation,Hobby,Sensitivity,Priority,Subject,Notes,Language,Photo,Group Membership,E-mail 1 - Type,E-mail 1 - Value,Phone 1 - Type,Phone 1 - Value';

            $fp = fopen('php://output', 'wb');

            fwrite($fp, $header . "\n");

            for($i = 0; $i < count($dados); $i++){

                $contato = "{$dados[$i]["nome"]},{$dados[$i]["nome"]},,,,,,,,,,,,,,,,,,,,,,,,,,,Script ::: * myContacts,,,Mobile,". $dados[$i]["celular"];
                fwrite($fp, $contato . "\n");
            }

            fclose($fp);

        }

    }