<?php

include"../includes/conexao.php";


$id = $_GET['id'];

function limpaPonto($valor){
 $valor = trim($valor);
 $valor = str_replace(".", "", $valor);
 $valor = str_replace(",", "", $valor);
 $valor = str_replace("-", "", $valor);
 $valor = str_replace("/", "", $valor);
 return $valor;
}

function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
    
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

function arrayToObject($d) {
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            // Return object
            return $d;
        }
    }

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql_duplicata = mysqli_query($con, "select * from duplicatas where id_venda = '$id'");
$vetor_duplicata = mysqli_fetch_array($sql_duplicata);

$sql_duplicatas = mysqli_query($con, "select * from duplicatas_faturas where id_duplicata = '$vetor_duplicata[id_duplicata]' and boleto IS NULL order by id_item ASC limit 0,1");

if(mysqli_num_rows($sql_duplicatas) == 0) {

  $sql_venda = mysqli_query($con, "update vendas SET pagamento = '1' where id_venda = '$id'");

  echo "<script> window.location.href='vendas_avulsas.php'</script>";

} else {

$vetor_item = mysqli_fetch_array($sql_duplicatas);

if($vetor_item['formapag'] == 2 || $vetor_item['formapag'] == 8 || $vetor_item['formapag'] == 9) {

$valor = $vetor_item['valor'] * 100;
$valorinteiro = (int)$valor;
$numerogerado = str_pad($vetor_item['id_item'] , 15 , '0' , STR_PAD_LEFT);

$datavencimento = date('d/m/Y', strtotime($vetor_item['data']));
$dataatual = date('d/m/Y');

if($datavencimento < $dataatual) {

  $data_venc = $datavencimento;

} else {

  $data_venc = $dataatual;

}

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

$sql_banco = mysqli_query($con, "select * from banco where id_banco = '1'");
$vetor_banco = mysqli_fetch_array($sql_banco);

if($vetor_banco['ambiente'] == 1) {

  $clienteID = $vetor_banco['clientIdhomologacao'];
  $clienteSecret = $vetor_banco['clientSecrethomologacao'];
  $sellerid = $vetor_banco['selleridhomologacao'];
  $urlbase = $vetor_banco['urlhomologacao'];
  $urlcurl = 'api-homologacao.getnet.com.br';

}

if($vetor_banco['ambiente'] == 2) {

  $clienteID = $vetor_banco['clientId'];
  $clienteSecret = $vetor_banco['clientSecret'];
  $sellerid = $vetor_banco['sellerid'];
  $urlbase = $vetor_banco['urlproducao'];
  $urlcurl = 'api.getnet.com.br';

}

$chaves = $clienteID.':'.$clienteSecret;

$valorbase64 = base64_encode($chaves);

$url = $urlbase.'/auth/oauth/v2/token';

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

$curl = curl_init();

curl_setopt_array($curl, array(

  CURLOPT_URL => $urlbase."/v1/payments/boleto",

  CURLOPT_RETURNTRANSFER => true,

  CURLOPT_ENCODING => "",

  CURLOPT_MAXREDIRS => 10,

  CURLOPT_TIMEOUT => 30,

  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

  CURLOPT_CUSTOMREQUEST => "POST",

  CURLOPT_POSTFIELDS => "{\r\n    \"seller_id\": \"$sellerid\",\r\n    \"amount\": $valorinteiro,\r\n    \"currency\": \"BRL\",\r\n    \"order\": {\r\n        \"order_id\": \"$numerogerado\",\r\n        \"sales_tax\": 0,\r\n        \"product_type\": \"service\"\r\n    },\r\n    \"boleto\": {\r\n        \"our_number\": \"\",\r\n        \"document_number\": \"$numerogerado\",\r\n        \"expiration_date\": \"$datavencimento\",\r\n        \"instructions\": \"Não receber após o vencimento\",\r\n        \"provider\": \"santander\"\r\n    },\r\n    \"customer\": {\r\n        \"first_name\": \"$primeironomefinal\",\r\n        \"name\": \"$vetor_formando[nome]\",\r\n        \"document_type\": \"CPF\",\r\n        \"document_number\": \"$vetor_formando[cpf]\",\r\n        \"billing_address\": {\r\n            \"street\": \"$vetor_formando[endereco]\",\r\n            \"number\": \"$vetor_formando[numero]\",\r\n            \"complement\": \"\",\r\n            \"district\": \"$vetor_formando[bairro]\",\r\n            \"city\": \"$vetor_formando[cidade]\",\r\n            \"state\": \"$vetor_formando[estado]\",\r\n            \"postal_code\": \"$vetor_formando[cep]\"\r\n        }\r\n    }\r\n}",

  CURLOPT_HTTPHEADER => array(

    "Accept: */*",

    "Authorization: ".$chaveretorno."",

    "Cache-Control: no-cache",

    "Connection: keep-alive",

    "Content-Type: application/json",

    "Host: ".$urlcurl."",

    "accept-encoding: gzip, deflate",

    "cache-control: no-cache"

  ),

));

 

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

 

if ($err) {

  echo "cURL Error #:" . $err;

} else {

  $response;

  $jsonDecodificar = json_decode($response);

  $array = objectToArray($jsonDecodificar);
  $object = arrayToObject($array);

  $linkboleto = $array['boleto']['_links'][1]['href'];
  $payment_id = $array['payment_id'];

  $sql_atualiza = mysqli_query($con, "update duplicatas_faturas SET status='1',boleto = '1', link = '$linkboleto', payment_id='$payment_id' where id_item = '$vetor_item[id_item]'");

}

?>

<link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">

<script type="text/javascript">
var ss = -1;
function atualizaContador(futuro) 
{
  ss = (ss==-1) ? futuro : ss;
  var faltam =  'Caro formando estamos gerando seu(s) Boletos, favor não fechar o navegador, você sera redirecionado em '+ss+' segundo(s).';

  if (ss > 0) {
  document.getElementById('contador').innerHTML = faltam;
  ss--;
  setTimeout(atualizaContador,1000);  
  } else {
  location.href="remessa-boleto.php?id=<?php echo $id; ?>";
  }
}
</script>

<body onLoad="atualizaContador(3);">
<div class="alert alert-warning" role="alert" id="contador"> </div>
</body>

<?php

} else {

echo "<script> window.location.href='remessa-boleto.php?id=$id'</script>";

}

}

?>