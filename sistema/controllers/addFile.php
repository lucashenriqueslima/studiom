<?php

session_start();

if(isset($_FILES['arquivo'])) {
	
	include "../includes/conexao.php";
	$id = $_GET['id'];
	$data = date('Y-m-d');
	$horaatual = date('H:i:s');
	$diretorio = "arquivos/album_virtual/";
	$nomeimagem = $_FILES['arquivo']['name'];
	$tmp = $_FILES['arquivo']['tmp_name'];
	$ext = strrchr($nomeimagem, '.');
	$imagem = md5($id.'albumvirtual').$ext;
	$upload = $diretorio.$imagem;
	move_uploaded_file($tmp, "../".$upload);
	$sql_grava = mysqli_query($con, "insert into album_virutal (id_formando, arquivo) VALUES ('$id', '$imagem')");
	echo '1';
}else{
	echo '0';
}
?>