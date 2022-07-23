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
                  <th>Formando</th>
                  <th>Data</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  
                $sql_contratos = mysqli_query($con, " select * from meu_convite where id_turma = '$vetor_cadastro[turma]' order by id_meuconvite DESC");

                while ($vetor_contrato=mysqli_fetch_array($sql_contratos)) {

                $sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_contrato[id_formando]'");
                $vetor_formando = mysqli_fetch_array($sql_formando);
                
                 ?>
                <tr>
                  <td><?php echo $vetor_formando['nome']; ?></td>
                  <td><?php echo date('d/m/Y', strtotime($vetor_contrato['data'])); ?></td>
                  <td><?php if($vetor_contrato['status'] == 1) { echo "Em Aberto"; } if($vetor_contrato['status'] == 2) { echo "Em Preenchimento"; } if($vetor_contrato['status'] == 3) { echo "Aprovado com Ressalva"; } if($vetor_contrato['status'] == 4) { echo "Finalizado"; } ?></td>
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