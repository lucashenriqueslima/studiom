<?php 

include"../includes/conexao.php";


$id = $_GET['id'];

$sql_data = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' order by b.data ASC limit 0,1");
$vetor_data = mysqli_fetch_array($sql_data);

$sql_datafinal = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' order by b.data DESC limit 0,1");
$vetor_datafinal = mysqli_fetch_array($sql_datafinal);

$data_inicial = $vetor_data['data'];
$data_final = $vetor_datafinal['data'];

$diferenca = strtotime($data_final) - strtotime($data_inicial);

$dias = floor($diferenca / (60 * 60 * 24));
$totaldias = $dias + 1;

$x = $_POST['id_funcao'];

$i = 0;

foreach($x as $key) {

	$id_funcao = $_POST['id_funcao'][$i];
	$qtd = $_POST['qtd'][$i];

	$sql_valor = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$id_funcao'");
	$vetor_valor = mysqli_fetch_array($sql_valor);

	$sql_faturamento = mysqli_query($con, "insert into escala_faturamento (id_escala, id_tabela, qtd, qtdtotal, valor) VALUES ('$id', '$id_funcao', '$qtd', '$totaldias', '$vetor_valor[valor]')");

	$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"alterarfaturamentoevento.php?id=$id\";
</script>";

?>