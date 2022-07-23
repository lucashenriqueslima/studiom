<?php

$chaves = '5859fcb9-5169-43c3-b958-99562ba7beca:dc30a79a-c375-4506-8b23-59671b675deb';

$valorbase64 = base64_encode($chaves);

$url = 'https://api-homologacao.getnet.com.br/auth/oauth/v2/token';

$request_body = 'scope=oob&grant_type=client_credentials';

$ch = curl_init($url);                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);                                                                   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Accept: application/json, text/plain, */*',
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic '.$valorbase64.'')                                                                       
); 

$result = curl_exec($ch);

curl_close($ch);

$obj = json_decode($result);

$chaveretorno = $obj->token_type.' '.$obj->access_token;

$url_tokenizacao = 'https://api-homologacao.getnet.com.br/v1/tokens/card';

$cartao = '5155901222280001';

$post = array(
    'card_number ' => (int)$cartao,
    'customer_id ' => '1'
);

$ch1 = curl_init($url_tokenizacao); 
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST"); 
curl_setopt($ch1, CURLOPT_POSTFIELDS, $post); 
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);   
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(                                                                          
    'authorization: '.$chaveretorno.'',
    'seller_id: f8e39b9e-51aa-4fb2-85ea-e427f65d30b0',
    'Content-Type: application/json')                                                                       
); 

$result1 = curl_exec($ch1);

curl_close($ch1);

$obj1 = json_decode($result1);

print_r($obj1);

?>