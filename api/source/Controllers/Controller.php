<?php 

    namespace Source\Controllers;

    class Controller
    {   
        
        public function formatParmsForTable(string $order, string $dir = null): void
        {   
            empty($_GET["limit"]) ? $_GET["limit"] = 10 : $_GET["limit"] = $_GET["limit"];
            empty($_GET["offset"]) ? $_GET["offset"] = 0 : $_GET["offset"] = $_GET["offset"];
            empty($_GET["search"]) ? $_GET["search"] = '' : $_GET["search"] = $_GET["search"];
            empty($_GET["dir"]) ? $_GET["dir"] = 'ASC' : $_GET["dir"] = $_GET["dir"];
            empty($_GET["order"]) ? $_GET["order"] = $order : $_GET["order"] = $_GET["order"];
            
        }
        

        public function jsonResponseForTables($response, $total = null): void
        {   

            if($total){

                $response["additional"]["total"] = $response["additional"]["positive_total"] + $response["additional"]["negative_total"];

                

                print_r(json_encode([
                    "count" => $response["additional"]["count"],
                    "positive_total" => "R$ " . number_format(@$response["additional"]["positive_total"], 2, ',', '.' ?? '0.00'),
                    "negative_total" => "R$ " . number_format(@$response["additional"]["negative_total"], 2, ',', '.' ?? '0.00'),
                    "total" => "R$ " . number_format(@$response["additional"]["total"], 2, ',', '.' ?? '0.00'),
                    "results" => $response["results"]
                ]));         
                
                return;
            }

            print_r(json_encode([
                "count" => @$response["count"],
                "results" => @$response["results"]
            ]));
        }
        
        public function jsonResponse(string $param = null, array $values = null)
        {
            echo json_encode([$param => $values]);
        }

        public function replaceParse($template, $vars)
        {
            $keys   = array_map(function($key) { return '{{'.$key.'}}'; }, array_keys($vars));
            $values = array_values($vars);
        
            return str_replace($keys, $values, $template);
        }

        function pregParse($template, $vars) {
            $re = '/\{\{([^}]+)\}\}/';
        
            return preg_replace_callback($re, function($match) use($vars) {
                $key = trim($match[1]); //Remove os espaços da direita e esquerda do nome da variável
                return isset($vars[$key]) ? $vars[$key] : $match[0];
            }, $template);
        }

        
    }