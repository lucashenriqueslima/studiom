<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/conexao.php";

use D4sign\Client;

require '../vendor/autoload.php';

$client = new Client();
$client->setAccessToken("live_61443c5531164ba1e1fa2b5f88bc02dd8df49ad428317d08ab3ea4792a78b714");
$client->setCryptKey("live_crypt_34gRk77yQWLS2YsxbC9qEPf0kCzds1RU");
#https://sandbox.d4sign.com.br/api/v1/safes?tokenAPI=live_61443c5531164ba1e1fa2b5f88bc02dd8df49ad428317d08ab3ea4792a78b714&cryptKey=live_crypt_34gRk77yQWLS2YsxbC9qEPf0kCzds1RU


echo "<pre>";
var_dump(lista_cofres($client));
echo "</pre>";

function lista_cofres($client){
    return $safes = $client->safes->find();
}

// Upload de documento
function upload($path_file){
    $path_file = '/pasta/arquivo.pdf';
    $id_doc = $client->documents->upload('{UUID-SAFE}', $path_file);
    #print_r($id_doc);
}

// Cadastro de Signatários
$signatarios = array(
    array("email@dominio.com", "1","0","0","0","email", ""),
    array("email2@dominio.com", "1", "0","0","0","sms", "5511953020202")
);

#signatarios($signatarios, $client);

function signatarios($signatarios,$client){
    $signers = array();
    foreach($signatarios as $key => $valor){
        $signer = array(
            "email" => $valor[0], "act" => $valor[1], "foreign" => $valor[2], "certificadoicpbr" => $valor[3], "assinatura_presencial" => $valor[4], "embed_methodauth" => $valor[5], "embed_smsnumber" => $valor[6]
        );
        $signers[] = $signer;
    }
    #echo"<pre>";
    #var_dump($signers);
    #echo"</pre>";

    return $client->documents->createList("{UUID-DOCUMENT}", $signers);
}


//Enviar documento para assinatura
function enviar_assinatura(){
    $message = 'Prezados, segue o contrato eletrônico para assinatura.';
    $workflow = 0 ;//Todos podem assinar ao mesmo tempo;
    $skip_email = 0 ;//Não disparar email com link de assinatura (usando EMBED ou Assinatura Presencial);

    $doc = $client->documents->sendToSigner("{UUID-DOCUMENT}",$message, $skip_email, $workflow);

//print_r($doc);
}



#echo"<pre>";
#var_dump($client);
#echo"</pre>";


