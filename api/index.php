<?php

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
session_start();

$router = new Router(site('root')); 

$router->namespace(site("route"));

$router->group(null);

/**
 * Auth
 */
$router->group("/auth");
$router->get("/login-formando", "Auth:loginFormando");

/**
 * Web
 */

//Títulos 
$router->group("/titulos");
$router->get("/get-contas-a-receber",  "Web:getContasAReceber");
$router->get("/get-recebidos",  "Web:getRecebidos");
$router->get("/get-cobrancas", "Web:getCobrancas");
$router->get("/get-contas-a-pagar", "Web:getContasAPagar");
$router->get("/get-fluxo-de-caixa", "Web:getFluxoDeCaixa");
$router->get("/get-fluxo-futuro", "Web:getFluxoFuturo");

//Régua de Cobrança
$router->group("/regua-cobranca");
$router->get("/get-regua-cobranca", "Web:getReguaCobranca");
$router->post("/save-regua-cobranca", "Web:saveReguaCobranca");
$router->get("/get-tipo-contrato-by-turma-id", "Web:getTipoContrato");
$router->get("/get-tipo-venda-by-formando-id", "Web:getTipoVendaByFormandoId");
$router->post("/save-excecoes-regua-cobranca", "Web:saveExcecoesReguaCobranca");
$router->get("/get-formandos-faculdades", "Web:getFormandosFaculdades");
$router->get("/get-excecoes-regua-cobranca", "Web:getExcecoesReguaCobranca");
$router->post("/delete-excecao-regua-cobranca", "Web:deleteExcecaoReguaCobranca");

//Convites
$router->group("/convites");
$router->get("/get-dados-convite", "AppFormando:getDadosConvite");
$router->post("/save-dados-convite", "AppFormando:saveDadosConvite");
$router->post("/save-textos-convite", "AppFormando:saveDadosTextosConvite");

//Scripts
$router->group("/scripts");
$router->get("/get-regua-cobranca-to-script", "Script:getReguaCobrancaToScript");
$router->get("/get-excecoes-regua-cobranca", "Script:getExcecoesReguaCobranca");
$router->post("/save-regua-cobranca-erro", "Script:saveReguaCobrancaErro");
$router->get("/get-erros-regua-cobranca", "Script:getErrosReguaCobranca");
$router->get("/get-contatos", "Script:getContatos");

//Turmas
$router->group("/turmas");
$router->get("/get-turmas", "Web:getTurmas");

//Eventos
$router->group("/eventos");
$router->get("/get-eventos-by-turma", "Web:getEventosByTurma");


/**
 * App
 */

//Messages
$router->group("/mensagens");
$router->get("/get-mensagens", "App:getMensagens");
$router->post("/update-mensagem-status", "App:updateMensagemStatus");


$router->dispatch();

if($router->error()){
    echo "error: ". $router->error();
}