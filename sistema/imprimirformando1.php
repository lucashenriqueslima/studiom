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
	<title>StudioM Fotografia</title>
</head>
<link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<body>
<table width="100%">
	<tr>
		<td width="20%" valign="top"><img src="arquivos/<?php echo $vetor['imagem']; ?>" width="800px"></td>
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
					<td width="75%"><strong>End. Resid.:</strong> <?php echo $vetor['endereco'] ?> <?php echo $vetor['numero']; ?> <?php echo $vetor['complemento']; ?></td>
					<td width="25%"><strong>Bairro:</strong> <?php echo $vetor['bairro']; ?></td>
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