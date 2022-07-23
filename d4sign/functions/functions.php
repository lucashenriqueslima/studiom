<?php

// Listar cofres
function lista_cofres($client){
    return $safes = $client->safes->find();
}

// Upload de documento
function upload($client, $path_file, $cofreId){;
    $id_doc = $client->documents->upload($cofreId, $path_file);
    return $id_doc;
}

function signatarios($signatarios, $client, $idDoc){
    $signers = array();
    foreach($signatarios as $key => $valor){
        $signer = array(
            "email" => $valor[0], "act" => $valor[1], "foreign" => $valor[2], "certificadoicpbr" => $valor[3], "assinatura_presencial" => $valor[4], "docauthandselfie" => 1 ,"embed_methodauth" => $valor[5], "whatsapp_number" => $valor[6]
        );
        $signers[] = $signer;
    }
    return $client->documents->createList($idDoc, $signers);
}

//Enviar documento para assinatura
function solicitar_assinatura($client, $id_doc){
    $message = 'Prezados, segue o contrato eletrônico para assinatura.';
    $workflow = 0 ;//Todos podem assinar ao mesmo tempo;
    $skip_email = 0 ;//Não disparar email com link de assinatura (usando EMBED ou Assinatura Presencial);
    $doc = $client->documents->sendToSigner($id_doc,$message, $skip_email, $workflow);
    return $doc;
}


?>