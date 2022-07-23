<?php
include "../includes/conexao.php";
$id = $_GET['id'];
$id_evento = $_GET['id_evento'];
if (isset($_GET['reverte'])) {
	$sql_deletar = mysqli_query($con, "delete from eventosformando where id_evento_turma_lista='$id_evento' and id_formando='$id'");
}else {
	$formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$id'"));
	$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$formando[turma]'"));
	$categoria = mysqli_fetch_array(mysqli_query($con, "select c.nome from categoriaevento c left join eventos_turma_lista etl on etl.id_evento = c.id_categoria where etl.id_evento_turma = '$id_evento'"));
	$pasta_turma = $turma['ncontrato'];
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
	if (!file_exists($diretorio)) mkdir($diretorio);
	
	$pasta_formando = $pasta_turma.'-'.$formando['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando;
	if (!file_exists($diretorio)) mkdir($diretorio);
	
	$pasta_evento = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($categoria['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));;
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando.'/'.$pasta_evento;
	if (!file_exists($diretorio)) mkdir($diretorio);
	
	$grava_pasta = $pasta_turma.'/'.$pasta_formando.'/'.$pasta_evento;
    $sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma_lista, tipo, titulo, pasta) VALUES ('$formando[id_formando]', '$id_evento', '2', '$categoria[nome]', '$grava_pasta')");

}
?>