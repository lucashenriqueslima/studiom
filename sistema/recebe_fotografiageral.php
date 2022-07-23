<?php

include"../includes/conexao.php";


if(isset($_GET['id'])){
	if(isset($_GET['remover'])){
		$remover = $_GET['remover'];
		$data = date('Y-m-d');
		switch ($remover){
			case '4': // Top Fotos
				$id_escolha = $_GET['id'];
				$formando = mysqli_fetch_array(mysqli_query($con, "SELECT id_formando from escolha_fotos_tratamento where id_escolha='$id_escolha'"));
				$sql = mysqli_query($con,"UPDATE escolha_fotos_tratamento SET finalizado='1',data_finalizado=null WHERE id_formando = '$formando[id_formando]'");
				break;
			case '3': // Escolha de Fotos
				$id_escolha = $_GET['id'];
				$sql = mysqli_query($con,"UPDATE escolha_fotos SET finalizado='1',data_finalizado=null WHERE id_escolha = '$id_escolha'");
				break;
			case '2': // Album
				$id_meualbum = $_GET['id'];
				$sql = mysqli_query($con,"UPDATE meu_album SET finalizado='1',data_finalizado=null WHERE id_meualbum = '$id_meualbum'");
				break;
			case '1': // Convite Exclusive
				$id_exclusive = $_GET['id'];
				$sql = mysqli_query($con,"UPDATE convite_exclusive SET finalizado='1',data_finalizado=null WHERE id_exclusive = '$id_exclusive'");
				break;
		}
	}else {
		$inserir = $_GET['inserir'];
		$data = date('Y-m-d');
		switch ($inserir) {
			case '4': // Top Fotos
				$id_escolha = $_GET['id'];
				$formando = mysqli_fetch_array(mysqli_query($con, "SELECT id_formando from escolha_fotos_tratamento where id_escolha='$id_escolha'"));
				$sql = mysqli_query($con, "UPDATE escolha_fotos_tratamento SET finalizado='0',data_finalizado='$data' WHERE id_formando = '$formando[id_formando]'");
				break;
			case '3': // Escolha de Fotos
				$id_escolha = $_GET['id'];
				$sql = mysqli_query($con, "UPDATE escolha_fotos SET finalizado='0',data_finalizado='$data' WHERE id_escolha = '$id_escolha'");
				break;
			case '2': // Album
				$id_meualbum = $_GET['id'];
				$sql = mysqli_query($con, "UPDATE meu_album SET finalizado='0',data_finalizado='$data' WHERE id_meualbum = '$id_meualbum'");
				break;
			case '1': // Convite Exclusive
				$id_exclusive = $_GET['id'];
				$sql = mysqli_query($con, "UPDATE convite_exclusive SET finalizado='0',data_finalizado='$data' WHERE id_exclusive = '$id_exclusive'");
				break;
		}
	}
}else{
	$inserir = $_GET['inserir'];
	$id_usuario = $_POST['usuario'];
	$usuario = mysqli_fetch_array(mysqli_query($con, "SELECT nome from usuarios where id_usuario='$id_usuario'"));
	switch ($inserir){
		case '4': // Top Fotos
			$id_escolha = $_POST['id'];
			$formando = mysqli_fetch_array(mysqli_query($con, "SELECT id_formando from escolha_fotos_tratamento where id_escolha='$id_escolha'"));
			mysqli_query($con,"UPDATE escolha_fotos_tratamento SET id_responsavel='$id_usuario' WHERE id_formando = '$formando[id_formando]'");
			break;
		case '3': // Escolha de Fotos
			$id_escolha = $_POST['id'];
			mysqli_query($con,"UPDATE escolha_fotos SET id_responsavel='$id_usuario' WHERE id_escolha = '$id_escolha'");
			break;
		case '2': // Album
			$id_meualbum = $_POST['id'];
			mysqli_query($con,"UPDATE meu_album SET id_responsavel='$id_usuario' WHERE id_meualbum = '$id_meualbum'");
			break;
		case '1': // Convite Exclusive
			$id_exclusive = $_POST['id'];
			mysqli_query($con,"UPDATE convite_exclusive SET id_responsavel='$id_usuario' WHERE id_exclusive = '$id_exclusive'");
			break;
	}
	echo $usuario['nome'];
	die();
}
?>