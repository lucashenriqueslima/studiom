<?php
include "../includes/conexao.php";

function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

$data = date('Y-m-d');
$hora = date('H:i:s');
$nprocesso = $_POST['nprocesso'];
$tipoparte = $_POST['tipoparte'];
$tipoparteexplode = explode('_', $tipoparte);
$tipopartefinal = $tipoparteexplode[0];
$tipoqualificar = $_POST['tipoqualificar'];
if ($tipoqualificar == 1) {
	$id_responsavel = $_POST['id_responsavel'];
}
if ($tipoqualificar == 2) {
	$id_responsavel = $_POST['id_responsavel1'];
}
if ($tipoqualificar == 3) {
	$id_responsavel = $_POST['id_responsavel2'];
}
if ($tipoqualificar == 4) {
	$responsaveloutro = $_POST['responsaveloutro'];
}
$dataprotocolo = $_POST['dataprotocolo'];
$datarecebimento = $_POST['datarecebimento'];
$tiponotificacao = $_POST['tiponotificacao'];
$pedidoliminar = $_POST['pedidoliminar'];
$pedidoliminarexplode = explode('_', $pedidoliminar);
$pedidoliminarfinal = $pedidoliminarexplode[0];
$descricaolimitar = $_POST['descricaolimitar'];
$valorcausa = moeda($_POST['valorcausa']);
$naturezaacao = $_POST['naturezaacao'];
$ocorrencia = $_POST['ocorrencia'];
$providencias = $_POST['providencias'];
$objetoacao = $_POST['objetoacao'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$nvara = $_POST['nvara'];
$tipovara = $_POST['tipovara'];
$fase = $_POST['fase'];
$faseexplode = explode('_', $fase);
$fasefinal = $faseexplode[0];
$cumprimentosentenca = $_POST['cumprimentosentenca'];
$dataaudiencia = $_POST['dataaudiencia'];
$tipoaudiencia = $_POST['tipoaudiencia'];
$relataraudiencia = $_POST['relataraudiencia'];
$sentenca = $_POST['sentenca'];
$sentencaexplode = explode('_', $sentenca);
$sentencafinal = $sentencaexplode[0];
$descricaosentenca = $_POST['descricaosentenca'];
if ($sentencafinal == 1) {
	$descricaosentenca = $_POST['descricaosentenca'];
}
if ($sentencafinal == 2) {
	$descricaosentenca = $_POST['descricaosentenca1'];
}
if ($sentencafinal == 3) {
	$descricaosentenca = $_POST['descricaosentenca2'];
}
$datasentenca = $_POST['datasentenca'];
$recursofinal = $_POST['recursofinal'];
$recursofinalexplode = explode('_', $recursofinal);
$recursofinalfinal = $recursofinalexplode[0];
$tipodespesa = $_POST['tipodespesa'];
$valordespesa = moeda($_POST['valordespesa']);
$datadespesa = $_POST['datadespesa'];
$forma = $_POST['forma'];
$sql = mysqli_query($con, "insert into juridico (nprocesso, tipoparte, tipoqualificar, id_responsavel, responsaveloutro, dataprotocolo, datarecebimento, tiponotificacao, pedidoliminar, descricaolimitar, valorcausa, naturezaacao, ocorrencia, providencias, objetoacao, cidade, estado, nvara, tipovara, fase, tiporecurso, cumprimentosentenca, dataaudiencia, tipoaudiencia, relataraudiencia, sentenca, descricaosentenca, datasentenca, recursofinal, descricaorecurso, tipodespesa, valordespesa, datadespesa, forma, status) VALUES ('$nprocesso', '$tipopartefinal', '$tipoqualificar', '$id_responsavel', '$responsaveloutro', '$dataprotocolo', '$datarecebimento', '$tiponotificacao', '$pedidoliminarexplode', '$descricaolimitar', '$valorcausa', '$naturezaacao', '$ocorrencia', '$providencias', '$objetoacao', '$cidade', '$estado', '$nvara', '$tipovara', '$fasefinal', '$tiporecurso', '$cumprimentosentenca', '$dataaudiencia', '$tipoaudiencia', '$relataraudiencia', '$sentencafinal', '$descricaosentenca', '$datasentenca', '$recursofinalfinal', '$descricaorecurso', '$tipodespesa', '$valordespesa', '$datadespesa', '$forma', '1')");
$id_gerado = $con->insert_id;
//recurso
$i = 0;
if (!empty($_POST['datarecurso'])) {
	foreach ($_POST['datarecurso'] as $key) {
		$datarecurso = $_POST['datarecurso'][$i];
	}
	$julgado = $_POST['julgado'][$i];
	$sql_recurso = mysqli_query($con, "insert into recursos_juridico (id_juridico, tipo, data, julgado) VALUES ('$id_gerado', '1', '$datarecurso', '$julgado')");
	$i++;
}
//recurso1
$f = 0;
if (!empty($_POST['datarecurso1'])) {
	foreach ($_POST['datarecurso1'] as $key) {
		$datarecurso1 = $_POST['datarecurso1'][$f];
	}
	$julgado1 = $_POST['julgado1'][$f];
	$sql_recurso = mysqli_query($con, "insert into recursos_juridico (id_juridico, tipo, data, julgado) VALUES ('$id_gerado', '1', '$datarecurso1', '$julgado1')");
	$f++;
}

//recurso2
$g = 0;
if (!empty($_POST['datarecurso2'])) {
	foreach ($_POST['datarecurso2'] as $key) {
		$datarecurso2 = $_POST['datarecurso2'][$g];
	}
	$julgado2 = $_POST['julgado2'][$g];
	$sql_recurso = mysqli_query($con, "insert into recursos_juridico (id_juridico, tipo, data, julgado) VALUES ('$id_gerado', '1', '$datarecurso2', '$julgado2')");
	$g++;
}

$h = 0;
if (!empty($_POST['titulo'])) {
	foreach ($_POST['titulo'] as $value) {
		$titulo = ucwords(strtolower($_POST['titulo'][$h]));
		$descricaoprocessual = $_POST['descricaoprocessual'][$h];
		$id_responsavelmov = $_POST['id_responsavelmov'][$h];
		$prazoconclusao = $_POST['prazoconclusao'][$h];
		$prognostico = $_POST['prognostico'][$h];
		$sql_mov = mysqli_query($con, "insert into mov_juridico (id_juridico, data, titulo, descricao, id_responsavel, prazoconclusao, prognostico, confirmar) VALUES ('$id_gerado', '$data', '$titulo', '$descricaoprocessual', '$id_responsavelmov', '$prazoconclusao', '$prognostico', '1')");
		$sql_cadastro = "select * from usuarios where id_colaborador = '$id_responsavelmov'";
		$res_cadastro = mysqli_query($con, $sql_cadastro);
		$vetor_cadastro = mysqli_fetch_array($res_cadastro);
		$sql_tarefa = mysqli_query($con, "insert into calendario (departamento, departamentosolicitante, titulo, data, hora, horafim, descricao, tipoatendimento) VALUES ('$vetor_cadastro[departamento]', '11', '$titulo', '$data', '$hora', '$hora', '$prognostico', 'Jurídico')");
		$h++;
	}
}
echo "<script language=\"JavaScript\">
location.href=\"juridico_processos.php\";
</script>";
?>