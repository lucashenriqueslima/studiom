<?php

header("Content-type: text/html; charset=utf-8");

include"../includes/conexao.php";


session_start();

$id = $_GET['id'];
$sql = mysqli_query($con, "select * from turmas where id_turma = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$nomeplanilha = date('dmyhsi');

$titulo = ''.$vetor[ncontrato].' - '.$vetor_curso_inicio[nome].' '.$vetor[ano].' '.$vetor_instituicao_inicio[nome].'';

$order = $_POST['order'];
          
$sql_atual = mysqli_query($con, "select * from formandos where turma = '$id' ".$order."");

/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado
$arquivo = 'Formandos Contrato: '.$vetor[ncontrato].''.$nomeplanilha.'.xls';
// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">'.utf8_decode($titulo).'</tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Código Aluno').'</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Nome</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Cidade</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Estado</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Telefone</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Celular</b></td>';
$html .= '</tr>';
$html .= '<tr>';

while ($vetor_formando=mysqli_fetch_array($sql_atual)) {

$codigoaluno = $vetor['ncontrato'].' - '.$vetor_formando['id_cadastro'];

$html .= '<td>'.$codigoaluno.'</td>';
$html .= '<td>'.utf8_decode($vetor_formando['nome']).'</td>';
$html .= '<td>'.utf8_decode($vetor_formando['cidade']).'</td>';
$html .= '<td>'.utf8_decode($vetor_formando['estado']).'</td>';
$html .= '<td>'.$vetor_formando[telefone].'</td>';
$html .= '<td>'.$vetor_formando[celular].'</td>';
$html .= '</tr>';
}
$html .= '</table>';
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo $html;
exit;

?>