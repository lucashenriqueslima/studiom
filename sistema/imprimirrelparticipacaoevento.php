<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];

$sql = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
$vetor = mysqli_fetch_array($sql);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor[curso]'");

$sql_eventos = mysqli_query($con, "select * from eventos_turma_lista WHERE id_turma = '$id_turma' order by id_evento_turma ASC");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Participação em Evento</title>
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

<div align="center"><h4><strong>Relatório de Participação em Evento</strong></h4></div>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">
		<td width="100%">Contrato: <?php echo $vetor['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></td>
	</tr>

</table>
<br>

<table width="100%" border="1" style="border-collapse: collapse">

	<tr style="background: #000000; color: #ffffff;">

		<td width="5%"></td>
		<td><div align="center">Nome do Formando</div></td>

		<?php 

		while($vetor_eventos = mysqli_fetch_array($sql_eventos)) {

		$sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_evento]'");
        $vetor_evento = mysqli_fetch_array($sql_evento);

		?>

		<td><div align="center"><?php echo $vetor_evento['nome']; ?></div></td>

		<?php } ?>

	</tr>

	<?php 

	$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$id_turma' order by nome ASC");

	$i = 1;

	while($vetor_formandos = mysqli_fetch_array($sql_formandos)) { 

	?>

	<tr>
		
		<td><div align="center"><?php echo $i; ?></div></td>
		<td><?php echo $vetor['ncontrato']; ?>-<?php echo $vetor_formandos['id_cadastro']; ?> <?php echo $vetor_formandos['nome']; ?></td>

		<?php 

		$sql_lista = mysqli_query($con, "select * from eventos_turma_lista WHERE id_turma = '$id_turma' order by id_evento_turma ASC");

		while($vetor_lista = mysqli_fetch_array($sql_lista)) {

		$sql_evento1 = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_lista[id_evento]'");
        $vetor_evento1 = mysqli_fetch_array($sql_evento1);

		$sql_venda = mysqli_query($con, "select * from vendas where id_formando = '$vetor_formandos[id_formando]' and tipo IN ('2', '3') and status = '3' order by id_venda DESC");
		$vetor_venda = mysqli_fetch_array($sql_venda);

		if($vetor_venda['tipo'] == 2) {

		$sql_pacotes = mysqli_query($con, "SELECT * FROM pacotes a, pacotes_itens_album b WHERE a.id_pacote = b.id_pacote and b.id_item = '$vetor_venda[id_pacote]'");

		$sql_eventos = mysqli_query($con, "select * from eventos_pacote a, eventos_turma_lista b WHERE a.id_pacote = '$vetor_venda[id_pacote]' and a.id_evento = b.id_evento_turma and b.id_evento = '$vetor_evento1[id_categoria]'");
    	
    	$total = mysqli_num_rows($sql_eventos);

    	} if($vetor_venda['tipo'] == 3) {

    	$sql_eventos = mysqli_query($con, "select * from eventos_venda_avulsa where id_avulsa = '$vetor_venda[produto]' and id_evento = '$vetor_evento1[id_categoria]'");
    	
    	$total = mysqli_num_rows($sql_eventos);

    	}

		?>

		<td width="8%"><div align="center"><?php if($total > 0) { ?>X<?php } ?></div></td>

		<?php } ?>

	</tr>

	<?php $i++; } ?>

</table>

</body>
</html>

<script type="text/javascript">
<!--
        print();
-->
</script>