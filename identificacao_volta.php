<?php 

$dataatual = date('Y-m-d');

include"includes/conexao.php";

$id_formando = $_GET['id_formando'];

if(!empty($id_formando)) {

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$id_formando'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StudioM Fotografia</title>
</head>
<link rel="stylesheet" href="sistema/layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
<style>

          body {
		  background-image: url("imgs/fundo.png");
		  }

          #box {
          width:400px;
          height:100%;
          border-radius: 10px;
          margin: auto;
          padding:10px;
          margin-bottom: 20px;
          }

</style>
<body>
<br>
<br>
<br>
<br>
<div class="container">
	<div id="box" align="center">

		<img src="imgs/LOGOS-LOGIN.png">

		<br>

		<?php echo $vetor_turma['ncontrato'].' - '.$vetor_formando['id_cadastro'].' - '.$vetor_formando['nome']; ?>

		<br>
		<h6><strong>Eventos:</strong></h6>
		<?php

		$sql_eventos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_turma = '$vetor_formando[turma]' and data >= '$dataatual' order by data ASC");

		while($vetor_eventos = mysqli_fetch_array($sql_eventos)) {

		$sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_categoria]'");
        $vetor_evento = mysqli_fetch_array($sql_evento);

        $sql_consulta = mysqli_query($con, "select * from identificacao_formandos where id_evento = '$vetor_eventos[id_evento]' and id_formando = '$vetor_formando[id_formando]'");

		if(mysqli_num_rows($sql_consulta) == 0) {

		?>
		
		<table width="100%">
			<tr>
				<td width="70%">- <?php echo $vetor_evento['nome']; ?></td>
				<td width="1%"></td>
				<td><a href="fazeridentificacao.php?id=<?php echo $vetor_eventos['id_evento']; ?>&id_formando=<?php echo $vetor_formando['id_formando']; ?>"><button type="button" class="btn btn-warning"  style="    float: left;">Fazer Identificação</button></a></td>
			</tr>
			<tr>
				<td><br></td>
				<td></td>
				<td></td>
			</tr>
		</table>

		<?php } } ?>

	</div>
</div>
</body>
</html>

<?php 

} else {

echo"<script language=\"JavaScript\">
	location.href=\"identificacao.html\";
	</script>";

}

?>