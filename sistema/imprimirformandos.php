<?php

include"../includes/conexao.php";


session_start();

$id = $_GET['id'];
$sql = mysqli_query($con, "select * from turmas where id_turma = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Imprimindo Formandos</title>
</head>
<link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<body>

<h3 class="box-title"><?php echo $vetor['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></h3>

<table class="table table-bordered table-striped">
                <thead>
                <tr bgcolor="#e8e8e8">
                  <th width="10%">Código Aluno</th>
                  <th>Nome</th>
                  <th>Cidade</th>
                  <th>Estado</th>
                  <th>Telefone</th>
                  <th>Celular</th>
                </tr>
                </thead>
                <tbody>
                <?php 
        
          $order = $_POST['order'];
          
          $sql_atual = mysqli_query($con, "select * from formandos where turma = '$id' ".$order."");
        
        while ($vetor_formando=mysqli_fetch_array($sql_atual)) {

          $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$id'");
          $vetor_instituicao = mysqli_fetch_array($sql_instituicao);          

          $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor[curso]'");
          $vetor_curso = mysqli_fetch_array($sql_curso);
        
         ?>
                <tr>
                  <td><?php echo $vetor['ncontrato']; ?> - <?php echo $vetor_formando['id_cadastro']; ?></td>
                  <td><?php echo $vetor_formando['nome']; ?></td>
                  <td><?php echo $vetor_formando['cidade']; ?></td>
                  <td><?php echo $vetor_formando['estado']; ?></td>
                  <td><?php echo $vetor_formando['telefone']; ?></td>
                  <td><?php echo $vetor_formando['celular']; ?></td>
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