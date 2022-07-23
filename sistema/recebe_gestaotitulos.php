<?php
include "../includes/conexao.php";
session_start();
$id_usuario = $_SESSION['id'];
$tabela = 0;

function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}
function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function objectToArray($d)
{
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
	}else {
		// Return array
		return $d;
	}
}

function arrayToObject($d)
{
	if (is_array($d)) {
		/*
				* Return array converted to object
				* Using __FUNCTION__ (Magic constant)
				* for recursive call
				*/
		return (object)array_map(__FUNCTION__, $d);
	}else {
		// Return object
		return $d;
	}
}
//Pago ou não
if (isset($_GET['tag']) && $_GET['tag'] == '8ui') {
	$pagamento = $_POST['pagamento'];
	$id_boleto = $_POST['id_item'];
	$status = $_POST['status'];
	$recebidos = $_POST['recebidos'];
	
	$sql_atualiza = mysqli_query($con, "update duplicatas_faturas SET status = '{$status}', pagamento = '{$pagamento}', recomprado = '0' where id_item = '{$id_boleto}'");
	$vetor = mysqli_fetch_array(mysqli_query($con,"select * from duplicatas_faturas where id_item = '{$id_boleto}'"));
	$vetor_mf = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM movimentacao_financeira mf WHERE mf.id_duplicata = '{$$vetor['id_item']}' AND mf.id_catconta = 46 ORDER BY mf.id_movimentacao DESC LIMIT 1 "));
	if($vetor['recomprado'] == '1') {
		$data = date('Y-m-d');
		$data_insercao = date('Y-m-d H:i:s');

		mysqli_query($con, "INSERT INTO `movimentacao_financeira` (`id_movimentacao`, `id_conta`, `id_lancamento`, `id_duplicata`, `id_usuario`, `data`, `data_insercao`, `valor`, `usuario_cancelamento`, `status`, `id_catconta`, `observacoes`) 
		VALUES (NULL, {$vetor_mf['id_conta']}, NULL, {$id_boleto}, $id_usuario, '{$data}', '{$data_insercao}', '{$vetor['valor']}', NULL, 1, '{$vetor_mf['id_conta']}', 'Pagamento Formando de título recomprado')");

	}
	
	if($vetor['status'] == '2' && ($vetor['pagamento'] == '1') && $recebidos != 1 &&(strtotime($vetor['data']) < strtotime(date('Y-m-d')))){
		$tabela = 3;
	}else{
		echo $pagamento;
	}

}
//gerar relatório inadimplentes
if (isset($_GET['tag']) && $_GET['tag'] == '4ri') {
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=DevelopersData.csv');
	header("Content-Disposition: attachment; filename=Export_" . date("Y-m-d H-i-s") . ".csv");
	header("Pragma: no-cache");
    header("Expires: 0");
	$output = fopen("php://output", "w");
	fputcsv($output, array('Id','Name','Skills','Address', 'Designation'));
	$data = "<script>document.write(dataRelatorio)</script>";
	$dataRelatorio = $_POST['dataRelatorio'];

	if (is_null($dataRelatorio) != 1) {
		$dataRelatorioFinal = DateTime:: createFromFormat('Y-m-d', $dataRelatorio)->format('Y-m-d');
		echo "$dataRelatorio";
		$sql = "SELECT CONCAT(t.ncontrato,'-',f.id_cadastro,' ',f.nome) as `First Name`,REPLACE(REPLACE(REPLACE(REPLACE(f.telefone,'(',''),')',''),' ',''),'-','') 
		as `Mobile Phone`,f.email as `E-mail Address` from formandos f
		left join vendas v on v.id_formando = f.id_formando
		left join duplicatas d on d.id_venda = v.id_venda 
		left join duplicatas_faturas df on df.id_duplicata = d.id_duplicata
		left join turmas t on t.id_turma = f.turma
		where df.`data` = '{$dataRelatorio}' and v.status <> '4' and df.pagamento <> '1' and df.formapag <> '3'";
		
		$qry = mysqli_query($con, $sql);

		// Write data to file
		$flag = false;
		while ($row = mysqli_fetch_assoc($qry)) {
			if (!$flag) {
				// display field/column names as first row
				echo implode("\t", array_keys($row)) . "\r\n";
				$flag = true;
			}
			echo implode("\t", array_values($row)) . "\r\n";
		}
	
	}
	//formatando
/* 
	$fields = mysqli_num_fields($qry);

	for ( $i = 0; $i < $fields; $i++ )
	{
		$header .= mysqli_fetch_field_direct( $qry , $i ) . "\t";
	}

	while( $row = mysqli_fetch_row( $qry ) )
	{
		$line = '';
		foreach( $row as $value )
		{                                            
			if ( ( !isset( $value ) ) || ( $value == "" ) )
			{
				$value = "\t";
			}
			else
			{
				$value = str_replace( '"' , '""' , $value );
				$value = '"' . $value . '"' . "\t";
			}
			$line .= $value;
		}
		$data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );

	if ( $data == "" )
	{
		$data = "\n(0) Records Found!\n";                        
	}

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=your_desired_name.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
	
*/	
}

if (isset($_GET['tag']) && $_GET['tag'] == '53g') {
	$id_boleto = $_POST['id_boleto'];
	$data = $_POST['data'];
	$valorinteiro = str_replace([',', '.'], '', $_POST['valor_gerado']);
	$vetor = mysqli_fetch_array(mysqli_query($con, "select f.cep,f.cpf,f.estado,f.endereco,f.numero,f.bairro,f.cidade,f.nome, df.* from duplicatas_faturas df
	left join duplicatas d on d.id_duplicata = df.id_duplicata
	left join vendas v on  v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	where id_item = '{$id_boleto}'"));
	$numerogerado = str_pad($vetor['id_item'], 15, '0', STR_PAD_LEFT);
	$datavencimento = date('d/m/Y', strtotime($data));
	$cep = preg_replace("/[^0-9]/", "", $vetor['cep']);
	$cpf = preg_replace("/[^0-9]/", "", $vetor['cpf']);
	$primeironome = explode(' ', $vetor['nome']);
	$primeironomefinal = $primeironome[0];
	$nomele = (count($primeironome));
	if ($nomele > 1) {
		$firstName = $primeironome[0];
		$lastName = $primeironome[$nomele - 1];
		$espaco = ' ';
	}else {
		$firstName = $primeironome[0];
		$lastName = '';
		$espaco = '';
	}
	$vetor_banco = mysqli_fetch_array(mysqli_query($con, "select * from banco where id_banco = '1'"));
	if ($vetor_banco['ambiente'] == 1) {
		$clienteID = $vetor_banco['clientIdhomologacao'];
		$clienteSecret = $vetor_banco['clientSecrethomologacao'];
		$sellerid = $vetor_banco['selleridhomologacao'];
		$urlbase = $vetor_banco['urlhomologacao'];
		$urlcurl = 'api-homologacao.getnet.com.br';
	}
	if ($vetor_banco['ambiente'] == 2) {
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
			'Authorization: Basic '.$valorbase64.''
		)
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
		CURLOPT_POSTFIELDS => "{\r\n    \"seller_id\": \"$sellerid\",\r\n    \"amount\": $valorinteiro,\r\n    \"currency\": \"BRL\",\r\n    \"order\": {\r\n        \"order_id\": \"$numerogerado\",\r\n        \"sales_tax\": 0,\r\n        \"product_type\": \"service\"\r\n    },\r\n    \"boleto\": {\r\n        \"our_number\": \"\",\r\n        \"document_number\": \"$numerogerado\",\r\n        \"expiration_date\": \"$datavencimento\",\r\n        \"instructions\": \"Não receber após o vencimento\",\r\n        \"provider\": \"santander\"\r\n    },\r\n    \"customer\": {\r\n        \"first_name\": \"$primeironomefinal\",\r\n        \"name\": \"$vetor[nome]\",\r\n        \"document_type\": \"CPF\",\r\n        \"document_number\": \"$cpf\",\r\n        \"billing_address\": {\r\n            \"street\": \"$vetor[endereco]\",\r\n            \"number\": \"$vetor[numero]\",\r\n            \"complement\": \"\",\r\n            \"district\": \"$vetor[bairro]\",\r\n            \"city\": \"$vetor[cidade]\",\r\n            \"state\": \"$vetor[estado]\",\r\n            \"postal_code\": \"$cep\"\r\n        }\r\n    }\r\n}",
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
		echo "cURL Error #:".$err;
	}else {
		$response;
		$jsonDecodificar = json_decode($response);
		$array = objectToArray($jsonDecodificar);
		$object = arrayToObject($array);
		$linkboleto = $array['boleto']['_links'][1]['href'];
		$payment_id = $array['payment_id'];
		$sql_atualiza = mysqli_query($con, "update duplicatas_faturas SET status='1',boleto = '1', link = '{$linkboleto}', payment_id='{$payment_id}' where id_item = '{$vetor['id_item']}'");
		echo $urlbase.$linkboleto;
	}
}
if (isset($_GET['excluir'])) {
	$id_boleto = $_GET['excluir'];
	$duplicata_fatura = mysqli_fetch_array(mysqli_query($con, "select * from duplicatas_faturas where id_item = '{$id_boleto}'"));
	if(!empty($duplicata_fatura['arquivo'])){
		$unlink = $SERVER_ROOT.'/sistema/arquivos/'.$duplicata_fatura['arquivo'];
		@unlink($unlink);
	}
	$sql = mysqli_query($con, "update duplicatas_faturas SET boleto=null, arquivo=null, link=null, payment_id=null where id_item = '{$id_boleto}'");

}
if (isset($_GET['tag']) && $_GET['tag'] == '4y3') {
	$id_boleto = $_POST['id_boleto'];
	$id_fomento = $_POST['fomento'];
	mysqli_query($con, "update duplicatas_faturas set id_fomento='{$id_fomento}' where id_item='{$id_boleto}'");
	$vetor = mysqli_fetch_array(mysqli_query($con,"select df.*,fo.nome as fonome from duplicatas_faturas df
																												left join fomentos fo on fo.id_fomento = df.id_fomento
																												where df.id_item = '{$id_boleto}'"));
	if ($vetor['id_fomento'] == null && $vetor['link'] == null) {
		$fomento = "<button
	                      type=\"button\" class=\"btn btn-info\"
	                      title=\"Inserir Fomento\"
	                      onclick=\"abreModal(".$vetor['id_item'].",'')\">
	              <span><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
	              </button>";
	}else {
		if ($vetor['id_fomento'] == null) {
			$fomento = "GetNet";
		}else {
			$fomento = "<button
	                        type=\"button\" class=\"btn btn-info\"
	                        title=\"Inserir Fomento\"
	                        onclick=\"abreModal(".$vetor['id_item'].",'')\">
	                <span>". $vetor['fonome'] ."</span>
	                </button>";
		}
	}
	echo $fomento;
}
if (isset($_GET['tag']) && $_GET['tag'] == 'kh2') {
	$id_boleto = $_POST['id_boleto'];
	$id_conta = $_POST['id_conta'];
	$valor_recebido = moeda($_POST['valor_recebido']);
	$tipo_pagamento = $_POST['tipo_pagamento'];
	if (isset($_POST['data_pagamento'])) {
		$datapagamento = $_POST['data_pagamento'];
	}
	$vetor = mysqli_fetch_array(mysqli_query($con, "select v.tipo,df.valor from vendas v
																																left join duplicatas d on d.id_venda=v.id_venda
																																left join duplicatas_faturas df on df.id_duplicata = d.id_duplicata
																																where df.id_item = '{$id_boleto}'"));
	switch ($vetor['tipo']) {
		case '1':
			$id_catconta = 38;
			break;
		case '2':
			$id_catconta = 39;
			break;
		case '4':
			$id_catconta = 41;
			break;
	}
	$data = date('Y-m-d H:i:s');
	$sql = mysqli_query($con, "update duplicatas_faturas set datapagamento='{$datapagamento}',valor_recebido='{$valor_recebido}',id_tipo_pagamento='{$tipo_pagamento}',status='2' where id_item='{$id_boleto}'");
	mysqli_query($con, "insert into movimentacao_financeira (id_conta,id_duplicata,id_usuario,data,data_insercao,valor,status,id_catconta)VALUES('{$id_conta}','{$id_boleto}','{$id_usuario}','{$datapagamento}','{$data}','{$valor_recebido}','1','{$id_catconta}')");
	if (isset($_POST['plano_contas'])) {
		$valorAux = (float)$vetor['valor'];
		$valorReal = (float)moeda($_POST['valor_recebido']);
		$id_catconta2 = $_POST['plano_contas'];
		$valor = number_format(($valorReal - $valorAux), '2', '.', ',');
		mysqli_query($con, "insert into movimentacao_financeira (id_conta,id_duplicata,id_usuario,data,data_insercao,valor,status,id_catconta)VALUES('{$id_conta}','{$id_boleto}','{$id_usuario}','{$datapagamento}','{$data}','{$valor}','1','{$id_catconta2}')");
	}
	$tabela = 3;
}
if (isset($_GET['resgatar'])) {
	$id_boleto = $_GET['resgatar'];
	$data = date('Y-m-d');
	$id_conta = $_POST['id_conta'];
	$sql = mysqli_query($con, "select mf.* from movimentacao_financeira mf left join duplicatas_faturas df on df.id_item = mf.id_duplicata where mf.id_duplicata = '{$id_boleto}' and df.data > '{$data}' order by `data` desc limit 0,1;");
	$df_clone = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM duplicatas_faturas WHERE id_item = '{$id_boleto}'"));
		$data = date('Y-m-d');
		$data_insercao = date('Y-m-d H:i:s');
	mysqli_query($con, "update duplicatas_faturas set recomprado='1' where id_item = '{$id_boleto}'");
	mysqli_query($con, "insert into movimentacao_financeira (id_conta,id_duplicata,id_usuario,data,data_insercao,valor,status,id_catconta,observacoes)
	VALUES('{$id_conta}','{$id_boleto}','{$id_usuario}','{$data}','{$data_insercao}','- {$df_clone['valor']}','1','46','Recompra de Título')");
	if($df_clone['id_fomento'] == '') {
		$df_clone['id_fomento'] = 'NULL';
	}
	$tabela = 2;
}
if (isset($_POST['assunto'])) {
	$id_boleto = $_GET['id'];
	$assunto = $_POST['assunto'];
	$meio = $_POST['tipo_interacao'];
	$usuario = $_SESSION['id'];
	$data = date('Y-m-d H:i:s');
	$ocorrencia = $_POST['ocorrencia'];
	mysqli_query($con, "insert into interacao_cobranca (id_usuario,id_duplicata_fatura,data_insercao,id_tipo_interacao,id_assunto,ocorrencia)VALUES('{$usuario}','{$id_boleto}','{$data}','{$meio}','{$assunto}','{$ocorrencia}')");
	echo "<script language=\"JavaScript\">
location.href=\"interacoes_cobranca.php?id=$id_boleto\";
</script>";
}
if (isset($_GET['tag']) && $_GET['tag'] == '5jy') {
	$id_boleto = $_POST['id_boleto'];
	$duplicata_fatura = mysqli_fetch_array(mysqli_query($con, "select * from duplicatas_faturas where id_item = '{$id_boleto}'"));
	$duplicata = mysqli_fetch_array(mysqli_query($con, "select * from duplicatas where id_duplicata = '{$duplicata_fatura['id_duplicata']}'"));
	$formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$duplicata['id_formando']}'"));
	$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$formando['turma']}'"));
	$pasta_turma = clean($turma['ncontrato']);
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}
	$pasta_formando = $pasta_turma.'-'.$formando['id_cadastro'].'-'.clean(strtolower(strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando.'/';
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}
	$boleto = $_FILES['boleto']['name'];
	$tmp = $_FILES['boleto']['tmp_name'];
	$ext = strrchr($boleto, '.');
	$nomegrava = time().uniqid(md5(1)).$ext;
	$upload = $diretorio.$nomegrava;
	move_uploaded_file($tmp, $upload);
	$grava_pasta = "formandos/".$pasta_turma."/".$pasta_formando."/".$nomegrava;
	$sql = mysqli_query($con, "update duplicatas_faturas SET boleto='1', arquivo='{$grava_pasta}' where id_duplicata = '{$duplicata_fatura['id_duplicata']}' AND posicao = '{$duplicata_fatura['posicao']}' AND data = '{$duplicata_fatura['data']}'");
	echo $grava_pasta;
}
if($tabela != 0) {
	$vetor = mysqli_fetch_array(mysqli_query($con, "select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome ,df.*,v.tipo ,v.qtdparcelas,fp.nome as fpnome from duplicatas_faturas df
	left join duplicatas d on d.id_duplicata = df.id_duplicata
	left join vendas v on  v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	left join formaspag fp on fp.id_forma = df.formapag
	left join turmas t on t.id_turma = f.turma
	left join fomentos fo on fo.id_fomento=df.id_fomento
	where df.id_item = '{$id_boleto}'"));
	$vetor_banco = mysqli_fetch_array(mysqli_query($con, "select * from banco where id_banco = '1'"));
	if ($vetor_banco['ambiente'] == 1) {
		$urlbase = $vetor_banco['urlhomologacao'];
	}
	if ($vetor_banco['ambiente'] == 2) {
		$urlbase = $vetor_banco['urlproducao'];
	}
//	tipo de servico
	switch ($vetor['tipo']) {
		case '1':
			$tipo_servico = "Convite";
			break;
		case '2':
			$tipo_servico = "Fotografia";
			break;
		case '3':
			$tipo_servico = "V.Avulsa";
			break;
		case '4':
			$tipo_servico = "Taxa de Estúdio";
			break;
	}
//	codigo cliente
	$cod_cliente = $vetor['ncontrato'].'-'.$vetor['id_cadastro'];
	
//	NOME cliente
	$nome_cliente = $vetor['fnome'];
	
//	forma de pagamento
	$formapag = $vetor['fpnome'];
	
//	parcela Ex:(1/3)
	$parcela = $vetor['posicao'].'/'.$vetor['qtdparcelas'];
	
//	data de vencimento
	$vencimento = date('d/m/Y', strtotime($vetor['data']));
	
//	valor do boleto
	$valor = $vetor['valor'];
	
//	valor recebido
	$valor_recebido = $vetor['valor_recebido'];
	
//	fomento
	if ($vetor['id_fomento'] == null && $vetor['link'] == null) {
		$fomento = "<button
	                      type=\"button\" class=\"btn btn-info\"
	                      title=\"Inserir Fomento\"
	                      onclick=\"abreModal(".$vetor['id_item'].",'')\">
	              <span><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
	              </button>";
	}else {
		if ($vetor['id_fomento'] == null) {
			$fomento = "GetNet";
		}else {
			$fomento = "<button
	                        type=\"button\" class=\"btn btn-info\"
	                        title=\"Inserir Fomento\"
	                        onclick=\"abreModal(".$vetor['id_item'].",'')\">
	                <span>". $vetor['fonome'] ."</span>
	                </button>";
		}
	}
	
//	pago ou não pago
	$pagamento = "<button id=\"pago_". $vetor['id_item']."\"
                        class=\"btn btn-success\"
                        onclick=\"mudaStatus(". $vetor['id_item'].",'0','1')\" ". ((int)$vetor['pagamento'] != 1 || $vetor['status'] == '1'?'hidden':'') .">SIM
                </button>
                <button id=\"naopago_". $vetor['id_item']."\"
                        class=\"btn btn-danger\"
                        onclick=\"mudaStatus(". $vetor['id_item'].",'1','2','1')\" ". ((int)$vetor['pagamento'] == 1 || $vetor['status'] == '1'?'hidden':'') .">NÃO
                </button>";
		
//	status
	if ($vetor['cobranca'] == '1' && $vetor['status'] == '2') {
		$status = "Cobrança";
	}elseif ($vetor['id_fomento'] != null) {
		$status = "Antecipação";
	}elseif($vetor['status'] == '2'){
		$status = "Recebido";
	}else{
		$status = "Em Aberto";
	}
	
//	Botões
	$insere_valor = "<button type=\"button\" class=\"btn btn-info btn-md\" title=\"Inserir Valor Recebido\" onclick=\"abreModal(".$vetor['id_item'].",'2')\" id=\"valorrecebido_".$vetor['id_item']."\" ". ($vetor['status'] == '1'?'':'hidden') .">
               <span><i class=\"fas fa-hand-holding-usd fa-lg\"></i></span>
             </button>";
	$gerar = "<button id=\"gerar_".$vetor['id_item']."\"
                    type=\"button\"
                    class=\"btn btn-secondary\" ".($vetor['status'] == '1'?'':'hidden') ." title=\"Gerar Boleto Santander\"
                    onclick=\"abreModal(".$vetor['id_item'].",'5')\">
                <span><i class=\"fas fa-history fa-lg\"></i></span>
            </button>";
	$insere_boleto = "<button id=\"inserir".$vetor['id_item']."\"
	                          type=\"button\" class=\"btn btn-success\"
	                          title=\"Inserir Boleto\"
	                          onclick=\"abreModal(".$vetor['id_item'].",'4')\" ". (!($vetor['arquivo'] == '' && $vetor['boleto'] == '')?'hidden':'') .">
	                      <span><i class=\"fas fa-cloud-upload-alt fa-md\"></i></span>
	                  </button>";
	$ver_boleto = "<a href=\"". (($vetor['arquivo'] != null)?'arquivos/'.$vetor['arquivo']:($vetor['link'] != null?$urlbase.$vetor['link']:'')) ."\" target=\"_blank\"
	                   id=\"bol".  $vetor['id_item'] ."\" ". (($vetor['arquivo'] == null && $vetor['link'] == null)?'hidden':'') .">
	                    <button type=\"button\" class=\"btn btn-warning\"
	                            title=\"Ver Boleto\">
	                        <span><i class=\"fas fa-file-alt fa-lg\"></i></span>
	                    </button>
	                </a>";
	$exclui_boleto = "<button id=\"exclui". $vetor['id_item'] ."\"
                            type=\"button\" class=\"btn btn-danger\"
                            title=\"Excluir Boleto\"
                            onclick=\"excluiBoleto(". $vetor['id_item'].")\" ". (!($vetor['arquivo'] != '')?'hidden':'') .">
                        <span><i class=\"fas fa-times fa-lg\"></i></span>
                    </button>";
	$recomprar = "<button type=\"button\" class=\"btn btn-danger\"
	                      title=\"Recomprar Título\"
	                      onclick=\"abreModal(". $vetor['id_item'] .",'6')\"
	                      id=\"resgatar_". $vetor['id_item']."\" ". ($vetor['status'] == '2' && $vetor['cobranca'] != '1'?'':'hidden') .">
	                  <span><i class=\"fas fa-history fa-lg\"></i></span>
	              </button>";
	$botoes = $insere_valor.$gerar.$insere_boleto.$ver_boleto.$exclui_boleto.$recomprar;
	switch ($tabela) {
		case 1:
			echo $cod_cliente.";;".$tipo_servico.";;".$formapag.";;".$parcela.";;".$vencimento.";;".$fomento.";;".$valor.";;".$status.";;".$botoes;
			break;
		case 2:
			echo $cod_cliente.";;".$nome_cliente.";;".$tipo_servico.";;".$parcela.";;".$vencimento.";;".$fomento.";;".$valor.";;".$pagamento.";;".$botoes;
			break;
		case 3:
			echo $cod_cliente.";;".$nome_cliente.";;".$tipo_servico.";;".$parcela.";;".$vencimento.";;".$fomento.";;".$valor_recebido.";;".$status.";;".$pagamento.";;".$botoes;
			break;
	}
}
?>
