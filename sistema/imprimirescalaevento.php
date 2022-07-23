<?php 

include"../includes/conexao.php";


$id = $_GET['id'];
$id_evento = $_GET['id_evento'];
$sql = mysqli_query($con, "select * from escala_eventos where id_escala = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_eventos = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' and id_escala_item = '$id_evento' order by b.data ASC");

$vetor_eventos = mysqli_fetch_array($sql_eventos);

$sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor_eventos[id_local]'");
$vetor_local = mysqli_fetch_array($sql_local);

$nomeevento = explode("/", $vetor_eventos['nome']);

$sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_categoria]'");
$vetor_categoria = mysqli_fetch_array($sql_categoria);

$sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_contrato]'");
$vetor_contrato = mysqli_fetch_array($sql_contrato);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_contrato[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_contrato[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_membros = mysqli_query($con, "select * from formandos where turma = '$vetor_contrato[id_turma]' and comissao = '2' order by nome ASC");

$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$vetor_contrato[id_turma]' order by nome ASC");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Escala Evento - <?php echo $nomeevento[0].' / '.$nomeevento[2]; ?></title>
</head>
<link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom CSS -->
<link href="../layout/dist/css/style.min.css" rel="stylesheet">
<body>

<table width="100%">
	<tr>
		<td width="50%">
			
			<img src="imgs/logo.png" width="160px">

		</td>
		<td width="50%">

			<div align="right">

				(62)3218-3476
				<br>
				Rua 93, 296, Qd.F-14, Lt. 36
				<br>
				St. Sul - Goiânia-GO  Cep: 74083-120
				<br>
				www.studiomfotografia.com.br

			</div>

		</td>
	</tr>
</table>
<br>
<div align="center"><h4><strong>ESCALA DE EVENTOS</strong></h4></div>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="100%">Contrato: <?php echo $vetor_contrato['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_contrato['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="50%">Atendimento da Turma / Cerimonial</td>
		<td width="50%">Cerimonial</td>
	</tr>
	<tr>
		<td><?php echo $vetor_contrato['nomeresponsavel']; ?> / <?php echo $vetor_contrato['telefoneresponsavel']; ?></td>
		<td><?php echo $vetor_contrato['cerimonial']; ?> / <?php echo $vetor_contrato['telefonecerimonial']; ?></td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="100%">Comissão de Formatura</td>
	</tr>
	<tr>
		<td>
			<?php 

			$i = 1;
			$totalcomissao = mysqli_num_rows($sql_membros);

			while($vetor_membros = mysqli_fetch_array($sql_membros)) { 

				echo $vetor_membros['nome'].' Celular: '.$vetor_membros['telefone'];
				
				if($totalcomissao > $i) {

				echo ", ";

				} else {

				echo ".";

				}

				$i++;

			}

			?>
		</td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="30%">Evento</td>
		<td width="15%">Qtde Total Formandos</td>
		<td width="15%">Qtde Formandos Evento</td>
		<td width="15%">Data</td>
		<td width="15%">Horário Inicio</td>
		<td width="15%">Horário Término</td>
	</tr>
	<tr>
		<td><?php echo $nomeevento[2]; ?></td>
		<td><?php echo mysqli_num_rows($sql_formandos); ?></td>
		<td><?php echo $vetor_eventos['qtd']; ?></td>
		<td><?php echo date('d/m/Y', strtotime($vetor_eventos['data'])); ?></td>
		<td><?php echo $vetor_eventos['horainicio']; ?></td>
		<td><?php echo $vetor_eventos['horafim']; ?></td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="40%">Local</td>
		<td width="60%">Endereço</td>
	</tr>
	<tr>
		<td><?php echo $vetor_local['nome'] ?></td>
		<td><?php echo $vetor_local['endereco']; ?> <?php echo $vetor_local['numero']; ?> <?php echo $vetor_local['complemento']; ?> <?php echo $vetor_local['bairro']; ?> <?php echo $vetor_local['cidade']; ?> <?php echo $vetor_local['estado']; ?></td>
	</tr>

</table>

<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td>Nome</td>
		<td>Função</td>
		<td>N° Cartão</td>
		<td>Horário Chegada</td>
		<td>Horário Saída</td>
		<td>Qtde Fotos</td>
		<td>Assinatura</td>
	</tr>

	<?php

	$sql_escala_profissionais = mysqli_query($con, "select * from escala_profissionais where id_escala = '$id' order by id_escala_profissional ASC");

	while ($vetor_escala_profissionais=mysqli_fetch_array($sql_escala_profissionais)) {

    $sql_tabela = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$vetor_escala_profissionais[id_funcao]'");
    $vetor_tabela = mysqli_fetch_array($sql_tabela);

    $sql_fornecedor = mysqli_query($con, "select * from clientes where id_cli = '$vetor_escala_profissionais[id_colaborador]'");
    $vetor_fornecedor = mysqli_fetch_array($sql_fornecedor);

    ?>

	<tr>
		<td><?php echo $vetor_fornecedor['nome']; ?></td>
		<td><?php echo $vetor_tabela['titulo']; ?></td>
		<td><?php if($vetor_escala_profissionais['ncartao'] == '0' || $vetor_escala_profissionais['ncartao'] == NULL) { } else { echo $vetor_escala_profissionais['ncartao']; } ?></td>
		<td><?php if($vetor_escala_profissionais['horario'] == '00:00:00' || $vetor_escala_profissionais['horario'] == NULL) { } else { echo $vetor_escala_profissionais['horario']; } ?></td>
		<td><?php if($vetor_escala_profissionais['horariofim'] == '00:00:00' || $vetor_escala_profissionais['horariofim'] == NULL) { } else { echo $vetor_escala_profissionais['horariofim']; } ?></td>
		<td><?php if($vetor_escala_profissionais['qtdfotos'] == '0' || $vetor_escala_profissionais['qtdfotos'] == NULL) { } else { echo $vetor_escala_profissionais['qtdfotos']; } ?></td>
		<td></td>
	</tr>

	<?php } ?>

</table>

<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td>Orientações Para cobertura Fotográfica</td>
	</tr>
	<tr>
		<td>
			
			<?php if($vetor_eventos['orientacoes'] != NULL) { echo $vetor_eventos['orientacoes']; } else { ?>

                    <p>* Sincronizar Data e Hora em todas as máquinas fotográficas.</p>
                    <p>* Desligar nitidez das câmeras.</p>
                    <p>* Conferência da Formatação dos cartões antes de começar a fotografar.</p>
                    <p>* Mudar modo de cor para Adobe RGB.</p>

            <?php } ?>

		</td>
	</tr>

</table>

<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td>Relatório do Evento / Observações</td>
	</tr>
	<tr>
		<td><br><br><br><br><br><br><br><br><br><br><br></td>
	</tr>

</table>

<br>

<table width="100%">
	<tr>
		<td width="49%"></td>
		<td width="2%"></td>
		<td width="49%"></td>
	</tr>
</table>

</body>
</html>
<script type="text/javascript">
<!--
        print();
-->
</script>