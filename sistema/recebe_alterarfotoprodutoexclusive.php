<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$diretorio = "arquivos/";

$id_pagina = $_POST['id_pagina'];
$qtdfotos = $_POST['qtdfotos'];
$nomeimagem1 = $_FILES['imagem']['name'];  
$tmp1 = $_FILES['imagem']['tmp_name'];
$ext1 = strrchr($nomeimagem1, '.'); 
$imagem1 = time().uniqid(md5()).$ext1;
$upload1 = $diretorio.$imagem1;
move_uploaded_file($tmp1, $upload1);
$npagina1 = $_POST['npagina1'];
$bloqueio = $_POST['bloqueio'];

if($nomeimagem1 == NULL) {

	$sql_update = mysqli_query($con, "update produtos_exclusive_itens SET qtdfotos='$qtdfotos',npagina = '$npagina1', bloqueio='$bloqueio' where id_item = '$id_pagina'");

} else {

	$sql_update = mysqli_query($con, "update produtos_exclusive_itens SET qtdfotos='$qtdfotos',npagina = '$npagina1', bloqueio='$bloqueio', imagem = '$imagem1' where id_item = '$id_pagina'");

}

echo"<script language=\"JavaScript\">
location.href=\"alterarprodutoexclusive.php?id=$id\";
</script>";
 
?>