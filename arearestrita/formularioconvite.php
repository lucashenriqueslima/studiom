<?php

	include"../includes/conexao.php";


	session_start();

	$id = $_GET['id'];

	if($_SESSION['id_formando'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {

	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

	$sql_aprovacao = mysqli_query($con, "select * from meu_convite where id_meuconvite = '$id' AND id_formando = '$_SESSION[id_formando]'");
	$vetor_aprovacao = mysqli_fetch_array($sql_aprovacao);

	$sql_itens = mysqli_query($con, "select * from meu_convite_paginas where id_meuconvite = '$id' order by npagina ASC");

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
</head>
<body>

<div align="center" style="width: 100%; background-color: #fff;">

<form action="recebe_aprovacao_convite.php" method="post">

<input type="hidden" name="id_convite" value="<?php echo $id; ?>">

<?php while($vetor_item = mysqli_fetch_array($sql_itens)) { ?>

<input type="hidden" name="id_item[]" value="<?php echo $vetor_item['id_pagina']; ?>">

<table width="96%">
	<tr>
		<td width="40%" valign="top">

			<img src="../sistema/arquivos/<?php echo $vetor_item['imagem']; ?>" height="360px">

		</td>
		<td width="2%"></td>
		<td width="58%" valign="top">
			
			<textarea name="descricao[]" class="form-control" rows="10" placeholder="Indique sua (s) foto (s) preferida (s) e adicione suas observações."><?php echo $vetor_item['descricao']; ?></textarea>

			<br>

			<strong>Legenda:</strong> <?php echo $vetor_item['legenda']; ?>

			<br>
			<br>
			
			<div class="row">
          
          	<div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Aprovado?</label>
			<select name="status[]" class="form-control">
				<option value="" selected="">Selecione...</option>
				<option value="2" <?php if (strcasecmp($vetor_item['status'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
				<option value="3" <?php if (strcasecmp($vetor_item['status'], '3') == 0) : ?>selected="selected"<?php endif; ?>>Com Resssalva</option>
			</select>
			</div>
			</div>
			<br><br>

			<br>
			<br>
			

		</td>
	</tr>
</table>

<br>
<br>
<br>

<?php } ?>

<br>

<?php if($vetor_aprovacao['status'] != 4) { ?>

<table width="96%">

	<tr>
		<td><button type="submit" class="btn btn-primary"  style="    float: left;">Finalizar</button></td>
	</tr>

</table>

<?php } ?>

<br>

</form>

</div>

</body>
</html>
<?php } ?>