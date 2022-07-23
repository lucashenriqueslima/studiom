<?php

session_start();

include "../includes/conexao.php";

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$id = $_GET['id'];

$result_pre = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_evento = '$id' and id_formando = '$_SESSION[id_formando]'");
$row_pre = mysqli_fetch_array($result_pre);

$caminho = "../sistema/arquivos/formandos/$row_pre[pasta]/";
$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
$contador = count($img);

// Criando o objeto
$zip = new ZipArchive();

$nome = $vetor_formando['nome'].'.zip';

if($zip->open($nome, ZIPARCHIVE::CREATE) == TRUE) {

   $i = 0;

   foreach($img as $img){

   	$imagem = explode("/", $img);
    $imagemfinal = $imagem[5];

    $zip->addFile($caminho.$imagemfinal,$imagemfinal);

    $i++;

   }

}

$zip->close();

header("Content-length: " . filesize( "$nome" ) );
header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=$nome");
 
readfile( "$nome" );

unlink("$nome");

?>