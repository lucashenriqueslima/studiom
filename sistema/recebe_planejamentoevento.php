<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];

$sql = mysqli_query($con, "insert into escala_eventos (id_contrato) VALUES ('$id_turma')");

$id_gerado = $con->insert_id;

$z = $_POST['eventos'];

if(!empty($_POST['eventos'])) {

	$f = 0;

	foreach($z as $keyz) {

		$eventos = $_POST['eventos'][$f];

		$sql_grava = mysqli_query($con, "insert into escala_eventos_itens (id_escala, id_evento) VALUES ('$id_gerado', '$eventos')");

		$id_gerado1 = $con->insert_id;

		$sql_tipo_evento = mysqli_query($con, "select * from eventos_turma where id_evento = '$eventos'");
		$vetor_tipo_evento = mysqli_fetch_array($sql_tipo_evento);

		//calculo qtd formandos

		$sql_vendas = mysqli_query($con, "select * from vendas a, formandos b where a.id_formando = b.id_formando and b.turma = '$id_turma' order by id_venda ASC");

		$sql_consulta = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b, escala_eventos c where a.id_evento = b.id_evento and a.id_escala = c.id_escala and c.id_contrato = '$id_turma' and c.id_escala = '$id_gerado' and b.id_categoria = '$vetor_tipo_evento[id_categoria]' order by b.data ASC");
		    $vetor_consulta = mysqli_fetch_array($sql_consulta);

		$totalcat = mysqli_num_rows($sql_consulta);

		while($vetor_vendas = mysqli_fetch_array($sql_vendas)) {

			$sql_pacotes = mysqli_query($con, "SELECT * FROM pacotes a, pacotes_itens_album b WHERE a.id_pacote = b.id_pacote and b.id_item = '$vetor_vendas[id_pacote]'");

			$sql_eventos = mysqli_query($con, "select * from eventos_pacote a, eventos_turma_lista b WHERE a.id_pacote = '$vetor_vendas[id_pacote]' and a.id_evento = b.id_evento_turma and b.id_evento = '$vetor_tipo_evento[id_categoria]'");
		    $vetor_eventos = mysqli_fetch_array($sql_eventos);

			$total = mysqli_num_rows($sql_eventos);

		    if($total == 1) {

		    	$totalizador[$f] += 1;

		    }

		}

		//final calculo qtd formandos

		$totalfinalqtdformando = $totalizador[$f];

		$sql_atualiza = mysqli_query($con, "update escala_eventos_itens SET qtd = $totalfinalqtdformando where id_escala_item = '$id_gerado1'");

		$f++;

	}

}

$w = $_POST['id_funcao'];

if(!empty($_POST['id_funcao'])) {

	$g = 0;

	foreach($w as $keyw) {

		$id_funcao = $_POST['id_funcao'][$g];

		$sql_grava_profissionais = mysqli_query($con, "insert into escala_profissionais (id_escala, id_funcao) VALUES ('$id_gerado', '$id_funcao')");

		$g++;

	}

}

echo"<script language=\"JavaScript\">
location.href=\"alterarplanejamentoevento.php?id=$id_gerado\";
</script>";

?>