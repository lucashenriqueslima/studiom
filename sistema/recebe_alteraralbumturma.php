<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$id_item = $_POST['id_item'];
$descricao = $_POST['descricao'];

$sql = mysqli_query($con, "update meu_album_turma SET id_turma='$id_turma', id_item='$id_item', descricao='$descricao' where id_meualbum = '$id'");

$id_gerado = $con->insert_id;

$x = $_POST['npagina'];

$i = 0;

$diretorio = "arquivos/turmas/";


foreach($x as $key) {

$nomeimagem = $_FILES['arquivo']['name'][$i];  
$tmp = $_FILES['arquivo']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);
$npagina = $_POST['npagina'][$i];
$bloqueio = $_POST['bloqueio'][$i];

if($nomeimagem != '' || $nomeimagem != NULL) {

$sql_grava = mysqli_query($con, "insert into meu_album_paginas_turma (id_meualbum, npagina, bloqueio, imagem) VALUES ('$id', '$npagina', '$bloqueio', '$imagem')");

}

$i++;

}

$y = $_POST['id_pagina'];

$f = 0;

foreach($y as $keyyy) {

$id_pagina = $_POST['id_pagina'][$f];
$nomeimagem1 = $_FILES['imagem']['name'][$f];  
$tmp1 = $_FILES['imagem']['tmp_name'][$f];
$ext1 = strrchr($nomeimagem1, '.'); 
$imagem1 = time().uniqid(md5()).$ext1;
$upload1 = $diretorio.$imagem1;
move_uploaded_file($tmp1, $upload1);
$npagina1 = $_POST['npagina1'][$f];

if($nomeimagem1 != '' || $nomeimagem1 != NULL) {

	$sql_update = mysqli_query($con, "update meu_album_paginas_turma SET npagina = '$npagina1', imagem = '$imagem1' where id_pagina = '$id_pagina'");

}

$f++;

}

echo"<script language=\"JavaScript\">
location.href=\"alteraralbumturma.php?id=$id\";
</script>";
 
?>