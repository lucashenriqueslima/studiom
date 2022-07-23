<?php 

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');


function formatarCPF_CNPJ($campo, $formatado = true){
	//retira formato
	$codigoLimpo = preg_replace("[' '-./ t]",'',$campo);
	// pega o tamanho da string menos os digitos verificadores
	$tamanho = (strlen($codigoLimpo) -2);
	//verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
	if ($tamanho != 9 && $tamanho != 12){
		return false; 
	}
 
	if ($formatado){ 
		// seleciona a mÃ¡scara para cpf ou cnpj
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
 
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++) {
			if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
		}
		//retorna o campo formatado
		$retorno = $mascara;
 
	}else{
		//se nÃ£o quer formatado, retorna o campo limpo
		$retorno = $codigoLimpo;
	}
 
	return $retorno;
 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$sql = mysqli_query($con, "select * from eventos_turma where id_evento = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_solicitante = mysqli_query($con, "select * from formandos where id_formando = '$vetor[solicitante]'");
$vetor_solicitante = mysqli_fetch_array($sql_solicitante);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_membros = mysqli_query($con, "select * from formandos where turma = '$vetor[id_turma]' and comissao = '2' order by nome ASC");

$sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor[id_local]' order by nome ASC");
$vetor_local = mysqli_fetch_array($sql_local);

$sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor[id_categoria]'");
$vetor_categoria = mysqli_fetch_array($sql_categoria);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Imprimindo Evento</title>
</head>
<link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<style type="text/css">
p {
    text-indent: 2em;
    text-align: justify;
}

table tr td span {
    display:block;
    background-color:white;
    padding:5px 5px 0 5px;
}

</style>
<body>
<div class="box-body">
<table width="100%">
	<tr>
		<td><div align="right">Contrato nº <?php echo $vetor_turma['ncontrato']; ?></div></td>
	</tr>
</table>
<br>
<br>
<table width="100%">
	<tr>
		<td><div align="center" style="font-size: large"><strong>SOLICITAÇÃO DE COBERTURA FOTOGRÁFICA</strong></div></td>
	</tr>
</table>
<br>
<p>
	A Comissão de Formatura <?php echo $vetor_turma['ncontrato']; ?> – <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_turma['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?> através de seu membro solicitante (<?php echo $vetor_solicitante['nome']; ?>), CPF <?php echo $cpfcnpj = formatarCPF_CNPJ($vetor_solicitante['cpf']); ?>, vem solicitar a cobertura fotográfica de evento, conforme descrito abaixo:
</p>
<br>
<table width="100%">
	<tr>
		<td width="1%"></td>
		<td width="98%">
<table width="100%" border="1" style="border-collapse: collapse">
	<tr>
		<td width="40%" valign="top"><span>Nome do responsável pelo evento:</span></td>
		<td width="60%"><span><?php echo $vetor['responsavel']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Nome dos integrantes da comissão de formatura e telefones</span></td>
		<td><span>
			
			<?php 

			while($vetor_membros = mysqli_fetch_array($sql_membros)) { 

				echo $vetor_membros['nome'].' Celular: '.$vetor_membros['celular'];
				echo "<br>";

			}

			?>

		</span></td>
	</tr>
	<tr>
		<td valign="top"><span>Nome do evento:<br>
(ex.: confraternização, reunião, festa, etc)
</span></td>
		<td><span><?php echo $vetor_categoria['nome']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Endereço do local do evento:<br>
(o mais detalhado possível, para facilitar o acesso do fotógrafo)

</span></td>
		<td><span>Local: <?php echo $vetor_local['nome'] ?> / Endereço: <?php echo $vetor_local['endereco']; ?> <?php echo $vetor_local['numero']; ?> <?php echo $vetor_local['complemento']; ?> <?php echo $vetor_local['bairro']; ?> <?php echo $vetor_local['cidade']; ?> <?php echo $vetor_local['estado']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Data do evento:</span></td>
		<td><span><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Horário de início:</span></td>
		<td><span><?php $horaexplode = explode(':', $vetor['horainicio']); echo $horaexplode[0].':'.$horaexplode[1]; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Horário de término (previsto):</span></td>
		<td><span><?php $horaexplode1 = explode(':', $vetor['horafim']); echo $horaexplode1[0].':'.$horaexplode1[1]; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Quantidade de Alunos:</span></td>
		<td><span><?php echo $vetor['qtdalunos']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Quantidade de pessoas:</span></td>
		<td><span><?php echo $vetor['qtdpessoas']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Cerimonial ou Responsável pelo evento:</span></td>
		<td><span><?php echo $vetor['responsavel']; ?></span></td>
	</tr>
	<tr>
		<td valign="top"><span>Observações:</span></td>
		<td><span><?php echo $vetor['observacoes']; ?></span></td>
	</tr>
</table></td>
		<td width="1%"></td>
	</tr>
</table>
<br>
<div align="right"><?php echo $data_extenso = strftime('%A, %d de %B de %Y', strtotime('today')); ?></div>
<br>
<br>
<div align="center">
________________________<br>
<strong>Comissão de Formatura</strong>

</div>
<br>

Observações:
<br>
1.	O prazo para solicitação de coberturas fotográficas deverá ser realizado conforme antecedência de dias definida em contrato.
<br>
2.	A omissão de dados importantes, que interfira na cobertura fotográfica, eximirá a empresa e profissional de prestar o atendimento.
<br>
3.	É necessário listagem de nomes dos formandos do curso que participarão do evento, onde somente será considerada cobertura fotográfica para a turma se, no mínimo, 50% (cinquenta por cento) deles participarem.

</div>
</body>
</html>
<script type="text/javascript">
<!--
        print();
-->
</script>