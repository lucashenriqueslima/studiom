<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$datafinal = $_POST['datafinal'];
$texto = $_POST['texto'];
$id_item = $_POST['id_item'];
$data = date('Y-m-d');

$sql = mysqli_query($con, "insert into produtos_exclusive (id_turma, datafinal, id_item, texto, data, status) VALUES ('$id_turma', '$datafinal', '$id_item', '$texto', '$data', '1')");

$id_gerado = $con->insert_id;

$x = $_POST['npagina'];

$i = 0;

$diretorio = "arquivos/";

foreach($x as $key) {

$nomeimagem = $_FILES['arquivo']['name'][$i];  
$tmp = $_FILES['arquivo']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);
$npagina = $_POST['npagina'][$i];
$tipo = $_POST['tipo'][$i];
$bloqueio = $_POST['bloqueio'][$i];
$qtdfotos = $_POST['qtdfotos'][$i];

$sql_grava = mysqli_query($con, "insert into produtos_exclusive_itens (id_produtoexclusive, npagina, imagem, status, tipo, bloqueio, qtdfotos) VALUES ('$id_gerado', '$npagina', '$imagem', '1', '$tipo', '$bloqueio', '$qtdfotos')");

$i++;

}
echo"<script language=\"JavaScript\">
location.href=\"afFotografia_exclusive.php\";
</script>";
 
?>