<?php

include"../includes/conexao.php";


$sql_banco = mysqli_query($con, "select * from banco where id_banco = '1'");
$vetor_banco = mysqli_fetch_array($sql_banco);

if($vetor_banco['ambiente'] == 1) {

  $clienteID = $vetor_banco['clientIdhomologacao'];
  $clienteSecret = $vetor_banco['clientSecrethomologacao'];
  $sellerid = $vetor_banco['selleridhomologacao'];
  $urlbase = $vetor_banco['urlhomologacao'];

}

if($vetor_banco['ambiente'] == 2) {

  $clienteID = $vetor_banco['clientId'];
  $clienteSecret = $vetor_banco['clientSecret'];
  $sellerid = $vetor_banco['sellerid'];
  $urlbase = $vetor_banco['urlproducao'];

}

echo $chaves = $clienteID.':'.$clienteSecret;

echo "<br>";

$valorbase64 = base64_encode($chaves);

echo $url = $urlbase.'/auth/oauth/v2/token';

echo "<br>";

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

echo $obj = json_decode($result);

print_r($result);

echo $chaveretorno = $obj->token_type.' '.$obj->access_token;

