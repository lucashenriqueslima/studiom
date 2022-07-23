<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];


	$id_tipo = $_POST['id_tipo'];
	$qtd = $_POST['qtd'];

	$sql_ref = "update tipos_arquivos_turma SET id_tipo='$id_tipo', qtd='$qtd' where id_tipo_formando = '$id'";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));



echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id1&tab=$tab&tab1=$tab1\";
</script>";	

?>