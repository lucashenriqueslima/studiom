<?php

ob_start();

include"../includes/conexao.php";


$id = $_GET['id'];

$res = mysqli_query($con, "SELECT * FROM mostruario WHERE id_mostruario = $id");
$vetor = mysqli_fetch_array($res);

$caminho = "/home/studioms/public_html/sistema/arquivos/fotografia/mostruario/$vetor[pasta]/";

$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
$contador = count($img);

$zip = new ZipArchive();

$nome = $vetor['pasta'].'.zip';

if($zip->open($nome, ZIPARCHIVE::CREATE) == TRUE) {

   foreach($img as $img) {

   	$imgexplode = explode('/', $img);
   	$imagemfinal = $imgexplode[9];

    $zip->addFile($img,$imagemfinal);

   }

}

$zip->close();

header("Content-length: " . filesize( "$nome" ) );
header("Content-type: application/octet-stream"); 
header("Content-disposition: attachment; filename=$nome");
 
readfile( "$nome" );

unlink("$nome");

?>