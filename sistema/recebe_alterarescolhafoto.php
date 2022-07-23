<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$texto = $_POST['texto'];
$id_item = $_POST['id_item'];
$status = $_POST['status'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "update escolha_fotos SET id_item='$id_item', texto='$texto', status='$status' where id_escolha = '$id'");

$x = $_POST['npagina'];

if(!empty($x)) {

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

if($nomeimagem != '') {

$sql_grava = mysqli_query($con, "insert into escolha_fotos_itens (id_escolha, npagina, imagem, status, bloqueio) VALUES ('$id', '$npagina', '$imagem', '1', '$bloqueio')");

}

$i++;

}

}

echo"<script language=\"JavaScript\">
location.href=\"alterarescolhafoto.php?id=$id\";
</script>";
 
?>