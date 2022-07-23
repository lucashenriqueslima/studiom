<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$diretorio = "arquivos/turmas/";

$id_pagina = $_POST['id_pagina'];
$nomeimagem1 = $_FILES['imagem']['name'];  
$tmp1 = $_FILES['imagem']['tmp_name'];
$ext1 = strrchr($nomeimagem1, '.'); 
$imagem1 = time().uniqid(md5()).$ext1;
$upload1 = $diretorio.$imagem1;
move_uploaded_file($tmp1, $upload1);
$npagina1 = $_POST['npagina1'];


	$sql_update = mysqli_query($con, "update minhas_aprovacoes_paginas SET npagina = '$npagina1', imagem = '$imagem1' where id_pagina = '$id_pagina'");


echo"<script language=\"JavaScript\">
location.href=\"alteraraprovacaoformando.php?id=$id\";
</script>";
 
?>