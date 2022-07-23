<?php
	 include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$id = $_GET['id'];
  $sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
  $vetor = mysqli_fetch_array($sql);

  $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

  

  $sql_turmas = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
  $vetor_turma = mysqli_fetch_array($sql_turmas);

  $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
  $vetor_instituicao = mysqli_fetch_array($sql_instituicao); 
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Studio M Fotografia</title>
</head>
<link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<body>
<table width="100%">
	<tr>
		<td width="20%" valign="top">

			<br>
			<br>
			<br>
			<br>

			<img src="arquivos/<?php echo $vetor['imagem']; ?>" width="300px" height="300px">

			<br>
			<br>

			<div align="center"><font size="18px"><strong><?php echo $vetor_turma['ncontrato']; ?>-<?php echo $vetor['id_cadastro']; ?></strong></font></div>

		</td>
		<td width="2%"></td>
		<td width="78%" valign="top">
			
			
			<div align="center"><h3>FICHA DE IDENTIFICAÇÃO</h3></div>
			<br>

			<table width="100%">
				<tr>
					<td width="50%"><strong>Curso:</strong> <?php echo $vetor_turma['nome'] ?></td>
					<td width="50%"><strong>Faculdade:</strong> <?php echo $vetor_instituicao['nome']; ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="100%"><strong>Nome:</strong> <?php echo $vetor['nome'] ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="33%"><strong>CPF:</strong> <?php echo $vetor['cpf'] ?></td>
					<td width="33%"><strong>RG:</strong> <?php echo $vetor['rg']; ?></td>
					<td width="34%"><strong>Nasc:</strong> <?php echo date('d/m/Y', strtotime($vetor['datanasc'])); ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="70%"><strong>End. Resid.:</strong> <?php echo $vetor['endereco'] ?> <?php echo $vetor['numero']; ?> <?php echo $vetor['complemento']; ?></td>
					<td width="30%"><strong>Bairro:</strong> <?php echo $vetor['bairro']; ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="30%"><strong>Cidade:</strong> <?php echo $vetor['cidade'] ?></td>
					<td width="10%"><strong>UF:</strong> <?php echo $vetor['estado']; ?></td>
					<td width="30%"><strong>CEP:</strong> <?php echo $vetor['cep'] ?></td>
					<td width="30%"><strong>Fone:</strong> <?php echo $vetor['telefone'] ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="30%"><strong>Cel.:</strong> <?php echo $vetor['celular'] ?></td>
					<td width="70%"><strong>E-mail:</strong> <?php echo $vetor['email']; ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="50%"><strong>Pai.:</strong> <?php echo $vetor['pai'] ?></td>
					<td width="50%"><strong>Mãe:</strong> <?php echo $vetor['mae']; ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="70%"><strong>End. dos Pais.:</strong> <?php echo $vetor['endereco1'] ?> <?php echo $vetor['numero1']; ?> <?php echo $vetor['complemento1']; ?></td>
					<td width="30%"><strong>Bairro:</strong> <?php echo $vetor['bairro1']; ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="33%"><strong>Cidade:</strong> <?php echo $vetor['cidade1'] ?></td>
					<td width="33%"><strong>UF:</strong> <?php echo $vetor['estado1']; ?></td>
					<td width="34%"><strong>CEP:</strong> <?php echo $vetor['cep1'] ?></td>
				</tr>
			</table>

			<img src="imgs/transp.png" width="3px">

			<table width="100%">
				<tr>
					<td width="33%"><strong>Fone Residencial:</strong> <?php echo $vetor['telresidencial'] ?></td>
					<td width="33%"><strong>Celular Pai:</strong> <?php echo $vetor['celularpai']; ?></td>
					<td width="34%"><strong>Celular Mãe:</strong> <?php echo $vetor['celularmae'] ?></td>
				</tr>
			</table>

		</td>
	</tr>
</table>
</body>
</html>
<?php } ?>
<script type="text/javascript">
<!--
        print();
-->
</script>