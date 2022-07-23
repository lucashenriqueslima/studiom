<?php

$diretorio = "arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

?>