<?php

include"../../../includes/conexao.php";

$id = $_GET['id'];

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$primeironome = explode(' ', $vetor_formando['nome']);
$primeironomefinal = $primeironome[0];

$nomele = (count($primeironome));


if($nomele > 1){

  $firstName = $primeironome[0];

  $lastName = $primeironome[$nomele-1];

  $espaco = ' ';

} else{

  $firstName = $primeironome[0];

  $lastName = '';

  $espaco = '';

}

$telefone = preg_replace("/[^0-9]/", "", $vetor_formando['telefone']);

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

?>
<!DOCTYPE html>
<html>
<head>
	<title>Pagamento Cartão</title>
</head>
<link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<body>

<script async src="https://checkout-homologacao.getnet.com.br/loader.js"
  data-getnet-sellerid="f8e39b9e-51aa-4fb2-85ea-e427f65d30b0"
  data-getnet-token="<?php echo $chaveretorno; ?>"
  data-getnet-amount="<?php echo $vetor_venda['valorvenda']; ?>"
  data-getnet-customerid="<?php echo $id; ?>"
  data-getnet-orderid="<?php echo $id; ?>"
  data-getnet-button-class="classe-botao-abrir-checkout"
  data-getnet-installments="<?php echo $vetor_venda['qtdparcelas']; ?>"
  data-getnet-customer-first-name="<?php echo $primeironomefinal; ?>"
  data-getnet-customer-last-name="<?php echo $lastName; ?>"
  data-getnet-customer-document-type="CPF"
  data-getnet-customer-document-number="<?php echo $vetor_formando['cpf']; ?>"
  data-getnet-customer-email="<?php echo $vetor_formando['email']; ?>"
  data-getnet-customer-phone-number="<?php echo $telefone; ?>"
  data-getnet-customer-address-street="<?php echo $vetor_formando['endereco']; ?>"
  data-getnet-customer-address-street-number="<?php echo $vetor_formando['numero']; ?>"
  data-getnet-customer-address-complementary=""
  data-getnet-customer-address-neighborhood="<?php echo $vetor_formando['bairro']; ?>"
  data-getnet-customer-address-city="<?php echo $vetor_formando['cidade']; ?>"
  data-getnet-customer-address-state="<?php echo $vetor_formando['estado']; ?>"
  data-getnet-customer-address-zipcode="<?php echo $vetor_formando['cep']; ?>"
  data-getnet-customer-country="Brasil"
  data-getnet-shipping-address='[{ "first_name": "<?php echo $primeironomefinal; ?>", "name": "<?php echo $vetor_formando['nome']; ?>", "email": "<?php echo $vetor_formando['email']; ?>", "phone_number": "", "shipping_amount": <?php echo $vetor_venda['valorvenda']; ?>, "address": { "street": "<?php echo $vetor_formando['endereco']; ?>", "complement": "", "number": "<?php echo $vetor_formando['numero']; ?>", "district": "<?php echo $vetor_formando['bairro']; ?>", "city": "<?php echo $vetor_formando['cidade']; ?>", "state": "<?php echo $vetor_formando['estado']; ?>", "country": "Brasil", "postal_code": "12345678"}}]'
  data-getnet-items='[{"name": "","description": "", "value": 0, "quantity": 0,"sku": ""}]'
  data-getnet-url-callback="https://studiomfotografia.com.br/areadocliente/retorno.php"
  data-getnet-pre-authorization-credit="">
</script>

<button class="classe-botao-abrir-checkout">Realizar pagamento</button>

</body>
</html>