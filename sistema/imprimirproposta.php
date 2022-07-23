<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');


include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor[id_forma]'");
$vetor_forma = mysqli_fetch_array($sql_forma);

$sql_vendedor = mysqli_query($con, "select * from usuarios where id_usuario = '$vetor[id_vendedor]'");
$vetor_vendedor = mysqli_fetch_array($sql_vendedor);

if($vetor['tipo'] == 1) {

	$sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '$vetor[id_oportunidade]'");
	$vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

	$sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '$vetor_oportunidade[id_prospeccao]'");
    $vetor_prospeccao = mysqli_fetch_array($sql_mkt);

    $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor_prospeccao[id_turma]'");
    $vetor_turma = mysqli_fetch_array($sql_turma);

    $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
    $vetor_curso = mysqli_fetch_array($sql_curso);

    $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
    $vetor_instituicao = mysqli_fetch_array($sql_instituicao);

} if($vetor['tipo'] == 2) {

	$sql_oportunidade = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_oportunidade]'");
	$vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

	$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_oportunidade[id_instituicao]'");
    $vetor_instituicao = mysqli_fetch_array($sql_instituicao);

    $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_oportunidade[curso]'");
  	$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

}

?>

<!DOCTYPE html>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<html>
<head>
	<title>Imprimir Proposta</title>
</head>
<link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
  
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
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
<div align="center"><h4><strong>ORÇAMENTO DE CONVITES</strong></h4></div>
<br>
<table width="100%">
	<tr>
		<td width="70%"><strong>Turma:</strong> <?php if($vetor['tipo'] == 1) { ?> <?php echo $vetor_curso['nome']; ?> <?php echo $vetor_curso['sigla']; ?> <?php echo $vetor_turma['conclusao']; ?>-<?php echo $vetor_turma['semestre']; ?> <?php } if($vetor['tipo'] == 2) { ?> <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_instituicao['sigla']; ?> <?php echo $vetor_oportunidade['ano']; ?><?php } ?></td>
		<td>Goiânia, <?php echo $data_extenso = strftime('%d de %B de %Y', strtotime('today')); ?></td>
	</tr>
	<tr>
		<td><strong>Quantidade de Formandos:</strong> <?php echo $vetor['qtdformandos']; ?></td>
		<td></td>
	</tr>
	<tr>
		<td><strong>Responsável pelo Atendimento:</strong> <?php echo $vetor_vendedor['nome']; ?></td>
		<td></td>
	</tr>
</table>

<br>
<br>

<strong>Descrição dos convites:</strong>

<br>
<br>

<?php

$sql_produtos = mysqli_query($con, "select * from orcamento_produto where id_orcamento = '$id'");

while($vetor_produtos = mysqli_fetch_array($sql_produtos)) {

if($vetor_produtos['id_produto'] == 2) {

//pega tamanho

$sql_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '1'");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$result_tabela = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho[id_itemtabela]'");
$vetor_tabela_final = mysqli_fetch_array($result_tabela);

$sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final[id_tamanho]'");
$vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

// pega embalagem

$sql_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '2'");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$result_embalagem = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_embalagem[id_itemtabela]'");
$vetor_tabela_embalagem = mysqli_fetch_array($result_embalagem);

$sql_tipo_final_embalagem = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_embalagem[id_itemtabela]'");
$vetor_tipo_final_embalagem = mysqli_fetch_array($sql_tipo_final_embalagem);

?>

<table width="100%">
	<tr>
		<td width="15%"></td>
		<td><strong><?php echo $vetor_produtos['qtd']; ?> Super Luxo – <?php echo $vetor_tipo_final['titulo']; ?></strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Embalagem do Convite: <?php echo $vetor_tipo_final_embalagem['titulo']; ?></strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Acabamento Interno da Embalagem:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>
						
						<?php

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_interno['titulo']; ?><?php if($total_acabamento_interno > $i) { echo ", "; } if($total_acabamento_interno == $i) { echo "."; } ?>

						<?php $i++; } ?>

					</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Acabamento Externo da Embalagem:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>
						
						<?php

							$sql_acabamento_externo = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '8'");

							$total_acabamento_externo = mysqli_num_rows($sql_acabamento_externo);

							$f = 1;

							while($vetor_acabamento_externo = mysqli_fetch_array($sql_acabamento_externo)) { 

							$result_acabamento_externo = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$total_acabamento_externo[id_itemtabela]'");
							$vetor_tabela_acabamento_externo = mysqli_fetch_array($result_acabamento_externo);

							$sql_tipo_final_acabamento_externo = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento_externo[id_itemtabela]'");
							$vetor_tipo_final_acabamento_externo = mysqli_fetch_array($sql_tipo_final_acabamento_externo);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_externo['titulo']; ?><?php if($total_acabamento_externo > $f) { echo ", "; } if($total_acabamento_externo == $f) { echo "."; } ?>

						<?php $f++; } ?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Convite</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Capa:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>
						
						<?php

							$sql_capa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and (id_tipo = '5' OR id_tipo = '6') order by id_item ASC");

							$sql_sobrecapa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '4'");
							$vetor_sobrecapa = mysqli_fetch_array($sql_sobrecapa);

							$sql_tipo_final_sobrecapa = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_sobrecapa[id_itemtabela]'");
							$vetor_tipo_final_sobrecapa = mysqli_fetch_array($sql_tipo_final_sobrecapa);

							$total_capa = mysqli_num_rows($sql_capa);

							$g = 1;

							while($vetor_capa = mysqli_fetch_array($sql_capa)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_capa[id_itemtabela]'");
							$vetor_tabela_capa = mysqli_fetch_array($result_capa);

							$sql_tipo_final_capa = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_capa[id_itemtabela]'");
							$vetor_tipo_final_capa = mysqli_fetch_array($sql_tipo_final_capa);

						?>
						
						<?php echo $vetor_tipo_final_capa['titulo']; ?><?php if($total_capa > $g) { echo ", "; } if($total_capa == $g) { echo "."; } ?>

						<?php $g++; } ?>

					</td>
				</tr>
				<?php if(mysqli_num_rows($sql_sobrecapa) > 0) { ?>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Sobrecapa/Encarte:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $vetor_tipo_final_sobrecapa['titulo']; ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Componentes Padrão do Miolo</strong></td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>1 Capa do Bloco (Capa Mole) - Couchê Fosco 250g</td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $vetor_tabela_final['paginas']; ?> Páginas Padrão - Couchê Fosco 170g</td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $vetor_tabela_final['paginaspersonalizadas']; if($vetor_tabela_final['paginaspersonalizadas'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Personalizadas - Couchê Fosco 170g</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Componentes Extras do Miolo</strong></td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<?php

                    $tabela_paginasextras = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '34'");
                    $vetor_tabela_paginasextras = mysqli_fetch_array($tabela_paginasextras);

                    if(mysqli_num_rows($tabela_paginasextras) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_paginasextras['qtd']; if($vetor_tabela_paginasextras['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Extras - Couchê Fosco 170g</td>
				</tr>
				<?php

					}

                    $tabela_paginasextraspersonalizadas = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '75'");
                    $vetor_tabela_paginasextraspersonalizadas = mysqli_fetch_array($tabela_paginasextraspersonalizadas);

                    if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_paginasextraspersonalizadas['qtd']; if($vetor_tabela_paginasextraspersonalizadas['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Extras Personalizadas - Couchê Fosco 170g</td>
				</tr>
				<?php

					}

                    $tabela_miniposter = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '36'");
                    $vetor_tabela_miniposter = mysqli_fetch_array($tabela_miniposter);

                    if(mysqli_num_rows($tabela_miniposter) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_miniposter['qtd']; ?> Mini Poster - Couchê Fosco 170g</td>
				</tr>
				<?php

					}

                    $tabela_vegetalcomum = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '37'");
                    $vetor_tabela_vegetalcomum = mysqli_fetch_array($tabela_vegetalcomum);

                    if(mysqli_num_rows($tabela_vegetalcomum) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_vegetalcomum['qtd']; if($vetor_tabela_vegetalcomum['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Vegetal Comum - Vegetal 90g</td>
				</tr>
				<?php

					}

                    $tabela_vegetalpersonalizado = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '38'");
                    $vetor_tabela_vegetalpersonalizado = mysqli_fetch_array($tabela_vegetalpersonalizado);

                    if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_vegetalpersonalizado['qtd']; if($vetor_tabela_vegetalpersonalizado['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Vegetal Personalizado - Vegetal 90g</td>
				</tr>
				<?php

					}

                    $tabela_acetatocomum = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '71'");
                    $vetor_tabela_acetatocomum = mysqli_fetch_array($tabela_acetatocomum);

                    if(mysqli_num_rows($tabela_acetatocomum) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_acetatocomum['qtd']; if($vetor_tabela_acetatocomum['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Transparência Comum - Acetato transparente</td>
				</tr>
				<?php

					}

                    $tabela_acetatopersonalizado = mysqli_query($con, "select * from orcamento_itens where '$id' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '72'");
                    $vetor_tabela_acetatopersonalizado = mysqli_fetch_array($tabela_acetatopersonalizado);

                    if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) {

                ?>
                <tr>
					<td></td>
					<td><?php echo $vetor_tabela_acetatopersonalizado['qtd']; if($vetor_tabela_acetatopersonalizado['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Transparência Personalizado - Acetato transparente</td>
				</tr>
				<?php } ?>
			</table>

		</td>
	</tr>
</table>

<?php

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' and id_produto = '$vetor_produtos[id_item]'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

if($vetor_tributos['tipo'] == 1) {

$percentual = $vetor_tributos['valor'] / 100;
$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

} if($vetor_tributos['tipo'] == 2) {

$valorfinalcomissao = $vetor_tributos['valor'];

}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

if($vetor_tributos1['tipo'] == 1) {

$percentual1 = $vetor_tributos1['valor'] / 100;
$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

} if($vetor_tributos1['tipo'] == 2) {

$valorfinalimposto1 = $vetor_tributos1['valor'];

} 

$totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

$totalunproduto = $totalproduto / $vetor_produtos['qtd'];

?>

<table width="100%">
	<tr>
		<td width="15%"><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Valor Unitário: R$ <?php echo $num = number_format($totalunproduto,2,',','.'); ?> Total: R$ <?php echo $num = number_format($totalproduto,2,',','.'); ?></strong></td>
	</tr>
</table>

<br>
<br>

<?php } if($vetor_produtos['id_produto'] == 4) { 

//pega tamanho

$sql_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '1'");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$result_tabela = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho[id_itemtabela]'");
$vetor_tabela_final = mysqli_fetch_array($result_tabela);

$sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final[id_tamanho]'");
$vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

// pega embalagem

$sql_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '2'");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$result_embalagem = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_embalagem[id_itemtabela]'");
$vetor_tabela_embalagem = mysqli_fetch_array($result_embalagem);

$sql_tipo_final_embalagem = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_embalagem[id_itemtabela]'");
$vetor_tipo_final_embalagem = mysqli_fetch_array($sql_tipo_final_embalagem);

?>

<table width="100%">
	<tr>
		<td width="15%"></td>
		<td><strong><?php echo $vetor_produtos['qtd']; ?> Convite Simples – <?php echo $vetor_tipo_final['titulo']; ?></strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Embalagem do Convite: <?php echo $vetor_tipo_final_embalagem['titulo']; ?></strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%">

						<strong>Acabamento da Embalagem:</strong>

						<?php

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_interno['titulo']; ?><?php if($total_acabamento_interno > $i) { echo ", "; } if($total_acabamento_interno == $i) { echo "."; } ?>

						<?php $i++; } ?>

					</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="85%">

						<strong>Quantidade de Paginas:</strong>

						<?php

							$sql_paginas = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '10'");
							$vetor_paginas = mysqli_fetch_array($sql_paginas);

							$sql_tipo_final_paginas = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_paginas[id_itemtabela]'");
							$vetor_tipo_final_paginas = mysqli_fetch_array($sql_tipo_final_paginas);

						?>
						
						<?php echo $vetor_tipo_final_paginas['titulo']; ?>

					</td>
				</tr>

			</table>

		</td>

	</tr>

</table>

<?php

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' and id_produto = '$vetor_produtos[id_item]'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

if($vetor_tributos['tipo'] == 1) {

$percentual = $vetor_tributos['valor'] / 100;
$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

} if($vetor_tributos['tipo'] == 2) {

$valorfinalcomissao = $vetor_tributos['valor'];

}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

if($vetor_tributos1['tipo'] == 1) {

$percentual1 = $vetor_tributos1['valor'] / 100;
$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

} if($vetor_tributos1['tipo'] == 2) {

$valorfinalimposto1 = $vetor_tributos1['valor'];

} 

$totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

$totalunproduto = $totalproduto / $vetor_produtos['qtd'];

?>

<table width="100%">
	<tr>
		<td width="15%"><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Valor Unitário: R$ <?php echo $num = number_format($totalunproduto,2,',','.'); ?> Total: R$ <?php echo $num = number_format($totalproduto,2,',','.'); ?></strong></td>
	</tr>
</table>

<br>
<br>

<?php } ?>

<?php } ?>

<strong>•	Diferenciais Studio M</strong>

<table width="100%">
	<tr>
		<td width="15%"><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>•	Projetos personalizados de acordo com o perfil da turma;</td>
	</tr>
	<tr>
		<td></td>
		<td>•	Orientação Fotográfica de acordo com o layout do convite;</td>
	</tr>
	<tr>
		<td></td>
		<td>•	Apresentação do projeto 3D;</td>
	</tr>
	<tr>
		<td></td>
		<td>•	Aprovação física do convite; </td>
	</tr>
	<tr>
		<td></td>
		<td>•	Cronograma de atividades incluso em contrato.</td>
	</tr>
</table>

<br>

<?php

$sql_bonificacoes = mysqli_query($con, "select * from orcamento_extras where id_orcamento = '$id'");

if(mysqli_num_rows($sql_bonificacoes) > 0) { 

?>

<strong>•	Bonificações Contratuais</strong>

<br>

<?php

while($vetor_bonificacoes = mysqli_fetch_array($sql_bonificacoes)) {

$sql_tipo_convite = mysqli_query($con, "select * from orcamento_produto WHERE id_item = '$vetor_bonificacoes[tipoconvite]'");
$vetor_tipo_convite = mysqli_fetch_array($sql_tipo_convite);

$sql_tamanho1 = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_bonificacoes[tipoconvite]' and id_tipo = '1'");
$vetor_tamanho1 = mysqli_fetch_array($sql_tamanho1);

$result_tabela1 = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho1[id_itemtabela]'");
$vetor_tabela_final1 = mysqli_fetch_array($result_tabela1);

$sql_tipo_final1 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final1[id_tamanho]'");
$vetor_tipo_final1 = mysqli_fetch_array($sql_tipo_final1);

?>

<?php echo $vetor_bonificacoes['qtd']; ?> <?php if($vetor_tipo_convite['id_produto'] == 2) { echo "Super Luxo"; } else { echo "Simples"; } ?> - <?php echo $vetor_tipo_final1['titulo']; ?>

<?php } } ?>

<br>
<br>

<strong>•	Prazo de Entrega</strong>

<br>

<?php if($vetor['dataentrega'] != NULL) { ?>

<div class="row">

<div class="col-lg-6">

              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <td width="3%"></td>
                  <td><div align="center">ETAPAS</div></td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center">DATA DO ENVIO</div>
                        </td>
                        <td>
                          <div align="center">CONCLUSÃO</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Questionário de Identidade Visual.</td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center"><?php echo date('d/m/Y', strtotime($vetor['questionario1'])); ?></div>
                        </td>
                        <td>
                          <div align="center"><?php echo date('d/m/Y', strtotime($vetor['questionario'])); ?></div>
                        </td>
                      </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Confecção da Temática.</td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center"><?php echo date('d/m/Y', strtotime($vetor['confeccaotematica1'])); ?></div>
                        </td>
                        <td>
                          <div align="center"><?php echo date('d/m/Y', strtotime($vetor['confeccaotematica'])); ?></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Aprovação final da Temática do Convite.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['aprovacaofinaltematica'])); ?></div></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Prazo limite para entrega dos Dados do Convite Gráfico.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['prazolimiteentrega'])); ?></div></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Data limite para acréscimo de convites extras.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['datalimiteconvextras'])); ?></div></td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Data da Aprovação Final do Convite.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataaprovacaofinal'])); ?></div></td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Data de envio do material para impressão.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataenviomaterial'])); ?></div></td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Entrega dos Convites.</td>
                  <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataentrega'])); ?></div></td>
                </tr>
              </table>

              </div>
              </div>

              <?php } ?>

<br>
<br>

<strong>•	Pagamento</strong>

<br>

Parcelamento via <?php echo $vetor_forma['nome']; ?> em <?php echo $vetor['qtdparcelas']; ?>x a partir da assinatura do contrato.

<br>
<br>

<strong>•	Processos de criação</strong>

<br>
<br>

<img src="imgs/f6d5e26c-4379-439b-bf45-e989537f7a92.jpg">

</body>
</html>

<script src="../layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../layout/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../layout/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../layout/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../layout/bower_components/fastclick/lib/fastclick.js"></script>

<link rel="stylesheet" href="../layout/bower_components/select2/dist/css/select2.min.css">
<!-- AdminLTE App -->
<script src="../layout/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../layout/dist/js/demo.js"></script>
<!-- page script -->
<script src="../layout/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  
  $('.select2').select2()

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
<!--
        print();
-->
</script>