<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$tab = $_GET['tab'];
$tab1 = $_GET['tab1'];
$data = date('Y-m-d');

$x = $_POST[ 'id_tipo' ];
$i = 0;

	foreach($x as &$key){

	$id_tipo = $_POST['id_tipo'][$i];
	$qtd = $_POST['qtd'][$i];

	$sql_ref = "insert into tipos_arquivos_turma (id_turma, id_tipo, qtd) VALUES ('$id', '$id_tipo', '$qtd')";
	$res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));

	$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$id'");

	while($vetor_formandos = mysqli_fetch_array($sql_formandos)) {

		$sql_consulta = mysqli_query($con, "select * from tipos_arquivos_formando where id_formando = '$vetor_formandos[id_formando]' and id_tipo = '$id_tipo'");

		if(mysqli_num_rows($sql_consulta) == 0) {

		$sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$id_tipo'");
		$vetor_tipo = mysqli_fetch_array($sql_tipo);

		$sql = mysqli_query($con, "select * from formandos where id_formando = '$vetor_formandos[id_formando]'");
		$vetor = mysqli_fetch_array($sql);

		$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id'");
		$vetor_turma = mysqli_fetch_array($sql_turma);

		$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor_formandos['id_cadastro'].' '.$vetor_formandos['nome'].' '.$vetor_tipo['nome'].' '.$data;

		$pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

		mkdir ("/home/studioms/public_html/sistema/arquivos/formandos/fotosconvite/$pasta", 0755 );

		$sql_grava = mysqli_query($con, "insert into tipos_arquivos_formando (id_formando, id_tipo, pasta) VALUES ('$vetor_formandos[id_formando]', '$id_tipo', '$pasta')");

		}

	}

	$i++;

	}


echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id#convite#tiposdearquivosconvite\";
</script>";	

?>