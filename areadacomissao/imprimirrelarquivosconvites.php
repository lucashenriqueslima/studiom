<?php

	include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";
	
	} else {

  if($_SESSION['comissao'] != 2) {

  echo"<script language=\"JavaScript\">
  location.href=\"inicio.php\";
  </script>";

  }
		
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Imprimir Relatório</title>
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
</head>
<body>

<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Criado</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  
                $sql_contratos = mysqli_query($con, "select * from formandos where turma = '$vetor_cadastro[turma]' order by nome ASC");

                while ($vetor_contrato=mysqli_fetch_array($sql_contratos)) {

                $sql_dados = mysqli_query($con, "select * from dadosconvite where id_formando = '$vetor_contrato[id_formando]'");
                
                ?>
                <tr>
                  <td><?php echo $vetor_contrato['nome']; ?></td>
                  <td><?php if(mysqli_num_rows($sql_dados) > 0) { ?><button type="button" class="btn btn-success mesmo-tamanho" title="Sim"><i class="fa fa-thumbs-up"></i> Sim</button><?php } else { ?><button type="button" class="btn btn-danger mesmo-tamanho" title="Não"><i class="fa fa-thumbs-down"></i> Não</button><?php } ?></td>
                </tr>
                <?php } ?>
                </tbody>
              </table>

</body>
</html>

<script type="text/javascript">
<!--
        print();
-->
</script>

<?php } ?>