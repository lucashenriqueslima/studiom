<?php
include "../includes/conexao.php";
//$ROOT = $SERVER_ROOT . '/studiomfotografia'; // TESTES LOCAL
//$ROOT = $SERVER_ROOT . '/testes'; // TESTES Servidor
//$ROOT = $SERVER_ROOT; // Produção

if(isset($_GET['dskd']) && $_GET['dskd'] == '45152'){
	$sql_plano_contas = mysqli_query($con,"select * from categorias_contas where cat_filha <> '0' and categoria_fornecedor is null");
	while($plano_contas = mysqli_fetch_array($sql_plano_contas)){
		$nome = $plano_contas['numeracao'] . ' - ' . $plano_contas['titulo'];
		$sql = mysqli_query($con,"insert into categoriafornecedor (nome,escala)VALUES('$nome','1')");
		$categoria_fornecedor = $con->insert_id;
		$sql2 = mysqli_query($con,"update categorias_contas set categoria_fornecedor = '$categoria_fornecedor' where id_catconta = '$plano_contas[id_catconta]'");
	}
}

if(isset($_GET['ryjs4e']) && $_GET['ryjs4e'] == '7946465'){
    $sql = mysqli_query($con,"select v.* from vendas v 
                                        left join formandos f on f.id_formando = v.id_formando
                                        left join turmas t on t.id_turma = f.turma
                                        where t.ncontrato = 359 and v.status <> 4 and v.tipo = 2 and v.data < '2021-02-25'");
    while($line = mysqli_fetch_array($sql)){
        $sql_delete = mysqli_query($con,"delete from arquivos where titulo = 'Contrato Álbum Formando' and data = '{$line["data"]}' and id_cliente = '{$line["id_formando"]}'");
        //CURL para fazer a inserção no PCP
        $url = 'https://studiomfotografia.com.br/arearestrita/gerarcontratopasta.php?id='.$line["id_venda"];

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => ''
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    }
}

if(isset($_GET['get']) && $_GET['get'] == '1145'){
//	https://studiomfotografia.com.br/sistema/mover_arquivos.php?get=1145&data_venda_avulsa=&parcelas=&contrato=&id=&valor=&data=&baixa=
	$data = $_GET['data']; // DATA DO ULTIMO BOLETO
	$id = $_GET['id']; // ID_CADASTRO
	$valor = $_GET['valor']; // VALOR DE CADA BOLETO
	$baixa = $_GET['baixa']; // ATÉ QNDO DAR BAIXA (PAGO ATÉ QUANDO)'
	$data_venda_avulsa = $_GET['data_venda_avulsa']; // TRAVAR ATUALIZAÇÃO EM ANTIGOS -> DATA DA VENDA EM 'VENDAS'
	$parcelas = $_GET['parcelas']; // N° DE PARCELAS
	$ncontrato = $_GET['contrato']; // N° CONTRATO
	$vetor = mysqli_fetch_array(mysqli_query($con,"select d.id_duplicata,v.formapag,v.id_venda from  duplicatas d
	left join vendas v on v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	left join turmas t on t.id_turma = f.turma
	where t.ncontrato = '$ncontrato' and f.id_cadastro = '$id' and v.tipo='3' and v.data='$data_venda_avulsa'"));
	for($i = 0;$i < $parcelas;$i++){
		if($i == 0){
			mysqli_query($con,"delete from duplicatas_faturas where id_duplicata = '$vetor[id_duplicata]'");
		}
		$dataatual = date('Y-m-d',strtotime('-'. $i .' months',strtotime($data)));
		$id_duplicata = $vetor['id_duplicata'];
		$posicao = $parcelas - $i;
		$formapag = $vetor['formapag'];
		if((strtotime($baixa) - strtotime($dataatual)) >= 0){
			$sql1 = mysqli_query($con,"insert into duplicatas_faturas (id_duplicata,posicao,data,datapagamento,valor,valor_recebido,status,formapag,pagamento)VALUES('$id_duplicata','$posicao','$dataatual','$dataatual','$valor','$valor','2','$formapag','1')");
		}else{
			$sql1 = mysqli_query($con,"insert into duplicatas_faturas (id_duplicata,posicao,data,valor,status,formapag)VALUES('$id_duplicata','$posicao','$dataatual','$valor','1','$formapag')");
		}
		var_dump($sql1);
		echo "<br>";
	}
	$sql2 = mysqli_query($con,"update vendas set qtdparcelas='$parcelas',tipo='2' where id_venda='$vetor[id_venda]'");
	echo "<br><br>";
	var_dump($sql1);
}

if(isset($_GET['a']) && $_GET['a'] == 1142986) {
	//MOVER TABELA "ARQUIVOS"
	$sql = mysqli_query($con, "select id_arquivo,id_cliente,arquivo from arquivos where ativo is null");
	while ($arquivos = mysqli_fetch_array($sql)) {
		$oldname = $ROOT.'/sistema/arquivos/'.$arquivos['arquivo'];
		if (file_exists($oldname)) {
			$formando = mysqli_fetch_array(mysqli_query($con, "select id_cadastro,turma,nome from formandos where id_formando='$arquivos[id_cliente]'"));
			$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma='$formando[turma]'"));
			$pasta_turma = $turma['ncontrato'];
			$diretorio = $ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
			if (!file_exists($diretorio)) {
				mkdir($diretorio);
			}
			$pasta_formando = $pasta_turma.'-'.$formando['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
			$diretorio = $ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando;
			if (!file_exists($diretorio)) {
				mkdir($diretorio);
			}
			$grava_pasta = $pasta_turma.'/'.$pasta_formando.'/'.$arquivos['arquivo'];
			$newname = $ROOT.'/sistema/arquivos/formandos/'.$grava_pasta;
			$sql_grava_pasta = mysqli_query($con, "update arquivos SET ativo='1',arquivo='$grava_pasta' WHERE id_arquivo='$arquivos[id_arquivo]'");
			rename($oldname, $newname);
		}else {
			$sql_grava_pasta = mysqli_query($con, "update arquivos SET ativo='1' WHERE id_arquivo='$arquivos[id_arquivo]'");
		}
	}
}

if(isset($_GET['b']) && $_GET['b'] == 497142){
	//MOVER TABELA "EVENTOSFORMANDOS"
	$sql = mysqli_query($con, "select id_evento,titulo,id_formando,pasta from eventosformando where ativo is null");
	while ($eventosformandos = mysqli_fetch_array($sql)) {
		$oldname = $ROOT.'/sistema/arquivos/formandos/'.$eventosformandos['pasta'];
		if (file_exists($oldname)) {
			$formando = mysqli_fetch_array(mysqli_query($con, "select id_cadastro,turma,nome from formandos where id_formando='$eventosformandos[id_formando]'"));
			$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma='$formando[turma]'"));
			$pasta_turma = $turma['ncontrato'];
			$diretorio = $ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
			if (!file_exists($diretorio)) {
				mkdir($diretorio);
			}
			$pasta_formando = $pasta_turma.'-'.$formando['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
			$diretorio = $ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando;
			if (!file_exists($diretorio)) {
				mkdir($diretorio);
			}
			
			$pasta_evento = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($eventosformandos['titulo'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
			$grava_pasta = $pasta_turma.'/'.$pasta_formando.'/'.$pasta_evento;
			$newname = $ROOT.'/sistema/arquivos/formandos/'.$grava_pasta;
			$sql_grava_pasta = mysqli_query($con, "update eventosformando SET ativo='1',pasta='$grava_pasta' WHERE id_evento='$eventosformandos[id_evento]'");
			$imgs = glob($oldname."/*.{JPG,jpg,png,gif,jpeg}", GLOB_BRACE);
			foreach ($imgs as $img){
				$auxOrigem = $oldname.'/'.$img;
				$auxDestino = $newname . '/' . $img;
				rename($auxOrigem, $auxDestino);
			}
			rmdir($oldname);
		}else {
			$sql_grava_pasta = mysqli_query($con, "update arquivos SET ativo='0' WHERE id_evento='$eventosformando[id_evento]'");
		}
	}
}

?>