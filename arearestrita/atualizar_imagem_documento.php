<?php

	session_start();

	include "../includes/conexao.php";
    
	
   	$idformando = $_SESSION['id_formando'];
	
	$tipo = $_POST['tipodoc'];
    
    $vetor = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = $idformando"));
    $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$vetor['turma']}'"));

	$filename = $_POST['filename'];
	$img = $_POST['pngimageData'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$imagemfinal = file_put_contents($filename, $data);
	

    
    $pasta_turma = $vetor_turma['ncontrato'];
	
	$diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma;
	if (!file_exists($diretorio)) {
		mkdir($diretorio);
	}

    $pasta_formando = $pasta_turma.'-'.$vetor['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($vetor['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));


    $diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/'.$pasta_formando;
    if (!file_exists($diretorio)) {
        mkdir($diretorio);
    }
	rename("$filename", "$diretorio/$filename");
    
	//convertendo em base64
	//$imgpega = file_get_contents("$diretorio/$filename");
	//$imgconvertida = base64_encode($imgpega); 

	$sql_verifica = mysqli_query($con, "select * from imagem_documento where id_formando_fk = $idformando and tipo = $tipo");
	$vetor_sql_verifica = mysqli_fetch_array($sql_verifica);
	$diretorio_imagem = $diretorio.'/'.$vetor_sql_verifica['img_documento'];
	
		if ($vetor_sql_verifica['tipo'] == 1) {
			# altera documento de contrato de fotografia
			
			
			$sql_update = mysqli_query($con, "update imagem_documento set img_documento = '$filename' where id_formando_fk = $idformando and tipo = 1");
			if ($vetor_sql_verifica['img_documento'] != $filename) {
				//rename("$filename", "$diretorio/$filename");
				unlink($diretorio_imagem);
			}
		}else if ($vetor_sql_verifica['tipo'] == 2) {
			# altera documento de contrato de convite
			
			
			$sql_update = mysqli_query($con, "update imagem_documento set img_documento = '$filename' where id_formando_fk = $idformando and tipo = 2");
			if ($vetor_sql_verifica['img_documento'] != $filename) {
				//rename("$filename", "$diretorio/$filename");
				unlink($diretorio_imagem);
			}
		}else {
			$sql_insert = mysqli_query($con, "insert into imagem_documento (img_documento, id_formando_fk, tipo) VALUES ('$filename', $idformando, $tipo)");
		}
	
	
?>