<?php

$imagem = $_GET['arquivo'];

header("Content-Type: application/save"); 
header("Content-Length:".filesize($imagem)); 
header('Content-Disposition: attachment; filename="' . $imagem . '"'); 
header("Content-Transfer-Encoding: binary");
header('Expires: 0'); 
header('Pragma: no-cache'); 

$dw = fopen("$imagem", "r"); 
fpassthru($dw); 
fclose($dw);

?>