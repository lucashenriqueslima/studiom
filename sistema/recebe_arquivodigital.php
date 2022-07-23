<?php

include"../includes/conexao.php";


$id_formando = $_GET['id'];
if(isset($_GET['id_digital'])){
	$id_arquivo_digital = $_GET['id_digital'];
	$sql_grava = mysqli_query($con, "DELETE FROM arquivos_digitais where id_arquivo_digital = '$id_arquivo_digital'");
}else {
	$i = 0;
	foreach ($_POST['linkarquivodigital'] as $dado) {
		$id_arquivo_digital = $_POST['id_digital'][$i];
		$id_evento = $_POST['evento_lista'][$i];
		$linkarquivodigital = $_POST['linkarquivodigital'][$i];
		if ($id_arquivo_digital == '') {
			$sql_grava = mysqli_query($con, "insert into arquivos_digitais (id_formando,id_evento,link_arquivo_digital)VALUES('$id_formando','$id_evento','$linkarquivodigital')");
		}else {
			$sql_grava = mysqli_query($con, "update arquivos_digitais SET id_evento = '$id_evento', link_arquivo_digital = '$linkarquivodigital' where id_arquivo_digital = '$id_arquivo_digital'");
		}
		$i++;
	}
}
echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id_formando#fotografia#arquivodigitalfotografia\";
</script>";

?>