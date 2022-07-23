<?php

include"includes/conexao.php";

$sql_formandos = mysqli_query($con, "select * from formandos order by nome ASC");

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
$html .= '<td colspan="3">Planilha de nome e sobrenome</tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bgcolor="#CCCCCC"><b>'.utf8_decode('Código Aluno').'</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Nome</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Primeiro Nome</b></td>';
$html .= '<td bgcolor="#CCCCCC"><b>Sobrenome</b></td>';
$html .= '</tr>';
$html .= '<tr>';

while ($vetor_formando=mysqli_fetch_array($sql_formandos)) {

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
$vetor = mysqli_fetch_array($sql_turma);

$codigoaluno = $vetor['ncontrato'].' - '.$vetor_formando['id_cadastro'];

$nome_completo = $vetor_formando['nome'];
$posicao_primeiro_espaco = strpos($nome_completo,' ');
$nome = substr($nome_completo,0,$posicao_primeiro_espaco);
$sobre_nome = substr($nome_completo,$posicao_primeiro_espaco);

$html .= '<td>'.$codigoaluno.'</td>';
$html .= '<td>'.utf8_decode($vetor_formando['nome']).'</td>';
$html .= '<td>'.utf8_decode($nome).'</td>';
$html .= '<td>'.utf8_decode($sobre_nome).'</td>';
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