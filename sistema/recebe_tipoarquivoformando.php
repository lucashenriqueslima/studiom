<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$x = $_POST[ 'id_tipo' ];
$i = 0;

	foreach($x as &$key){

	$id_tipo = $_POST['id_tipo'][$i];

	$sql_ref = "insert into tipos_arquivos_formando (id_formando, id_tipo) VALUES ('$id', '$id_tipo')";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));

	$i++;

	}


echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id\";
</script>";	

?>