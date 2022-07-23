<?php 

include"../includes/conexao.php";


$id = $_GET['id'];
$id_evento = $_GET['id_evento'];
$sql = mysqli_query($con, "select * from escala_eventos where id_escala = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_contrato]'");
$vetor_contrato = mysqli_fetch_array($sql_contrato);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_contrato[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_contrato[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_membros = mysqli_query($con, "select * from formandos where turma = '$vetor_contrato[id_turma]' and comissao = '2' order by nome ASC");

$sql_eventos = mysqli_query($con, "select * from escala_eventos_itens where id_escala = '$vetor[id_escala]'");

$total = mysqli_num_rows($sql_eventos);

$sql_evento_primeiro = mysqli_query($con, "select * from escala_eventos_itens where id_escala = '$vetor[id_escala]' order by id_escala_item ASC limit 0,1");
$vetor_evento_primeiro = mysqli_fetch_array($sql_evento_primeiro);

$sql_evento_titulo_primeiro = mysqli_query($con, "select * from eventos_turma where id_evento = '$vetor_evento_primeiro[id_evento]'");
$vetor_evento_titulo_primeiro = mysqli_fetch_array($sql_evento_titulo_primeiro);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Faturamento de Evento</title>
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
<div align="center"><h4><strong>FATURAMENTO DE EVENTO(S)</strong></h4></div>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="100%">Contrato: <?php echo $vetor_contrato['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_contrato['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td>Evento(s)</td>
	</tr>

	<tr>
		<td width="100%">
		<?php

		$i = 1;

	    while($vetor_eventos = mysqli_fetch_array($sql_eventos)) {

	    $sql_evento_titulo = mysqli_query($con, "select * from eventos_turma where id_evento = '$vetor_eventos[id_evento]'");
	    $vetor_evento_titulo = mysqli_fetch_array($sql_evento_titulo);

	    $tituloexplode = explode('/', $vetor_evento_titulo['nome']);
	    $titulofinal = $tituloexplode[2];

		echo $titulofinal;

        if($i<$total) {

        echo ",  ";

        } if($i==$total) {

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

		<td width="25%"><div align="center">Nome</div></td>
		<td width="30%"><div align="center">Serviço</div></td>
		<td width="15%"><div align="center">Qtd (diárias)</div></td>
		<td width="15%"><div align="center">Pré-Orçado</div></td>
		<td width="15%"><div align="center">Orçado</div></td>

	</tr>

	<?php

	$sql_faturamento = mysqli_query($con, "select * from escala_faturamento where id_escala = '$id' order by id_escala_faturamento ASC");

	while ($vetor_faturamento=mysqli_fetch_array($sql_faturamento)) {

	$sql_tabela = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$vetor_faturamento[id_tabela]'");
    $vetor_tabela = mysqli_fetch_array($sql_tabela);

    $sql_escala = mysqli_query($con, "select * from escala_profissionais where id_escala_profissional = '$vetor_faturamento[id_colaborador]'");
    $vetor_escala = mysqli_fetch_array($sql_escala);

    $sql_fornecedor = mysqli_query($con, "select * from clientes where id_cli = '$vetor_escala[id_colaborador]'");
    $vetor_fornecedor = mysqli_fetch_array($sql_fornecedor);

    if($vetor_faturamento['id_tabela'] == 1) {

    $calculokm = $vetor_faturamento['qtdtotal'] / 10;
    $mediakm = floor($calculokm);

    $calculo = $mediakm * $vetor_faturamento['valor'];
    $valorfinal = $calculo * $vetor_faturamento['qtd'];

	} else {

	$calculo = $vetor_faturamento['qtdtotal'] * $vetor_faturamento['valor'];
	$valorfinal = $calculo * $vetor_faturamento['qtd'];

	}

	?>

	<tr>

		<td><?php echo $vetor_fornecedor['nome']; ?></td>
		<td><?php echo $vetor_faturamento['qtd']; ?> (un.) <?php echo $vetor_tabela['titulo']; ?></td>
		<td><?php echo $vetor_faturamento['qtdtotal']; ?> <?php if($vetor_faturamento['id_tabela'] == 1) { echo "KM"; } ?></td>
		<td>R$ <?php echo $num = number_format($valorfinal,2,',','.'); ?></td>
		<td>R$ <?php echo $num = number_format($vetor_faturamento['valorfinal'],2,',','.'); ?></td>

	</tr>

	<?php $totalizador += $valorfinal; $totalizador1 += $vetor_faturamento['valorfinal']; } ?>

	<tr style="background: #000000; color: #ffffff;">

		<td><div align="center">Totais</div></td>
		<td></td>
		<td></td>
		<td><div align="center">R$ <?php echo $num = number_format($totalizador,2,',','.'); ?></div></td>
		<td><div align="center">R$ <?php echo $num = number_format($totalizador1,2,',','.'); ?></div></td>

	</tr>
</table>
<br>

			<table width="100%">
			<tr>
			<td>

			<h3>Autorização de Serviço</h3>
			<br>
			Data: <?php echo date('d/m/Y', strtotime($vetor_evento_titulo_primeiro['data'])); ?>
			<br>

			
			<br>
			<br>
			Nome: ______________________________________
			<br>
			<br>
			
			<br>
			Assinatura: ___________________________________

			</td>
			</tr>
			</table>
		
<br>
</body>
</html>
<script type="text/javascript">
<!--
        print();
-->
</script>