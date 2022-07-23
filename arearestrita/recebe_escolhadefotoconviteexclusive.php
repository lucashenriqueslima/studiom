<?php 

session_start();

include"../includes/conexao.php";


$id = $_GET['id'];
$id_convite = $_GET['id_convite'];
$observacoes = addslashes($_POST['observacoes']);
$uploadinicio = $_POST['upload'];
$uploadexplode = explode("_", $uploadinicio);
$upload = $uploadexplode[0];

$sql = mysqli_query($con, "update convite_exclusive_itens SET observacoes = '$observacoes', status = '2' where id_item = '$id'");

$sql_update_escolha = mysqli_query($con, "update convite_exclusive SET status = '2' where id_exclusive = '$id_convite'");

$sql_item = mysqli_query($con, "select * from convite_exclusive_itens where id_item = '$id'");
$vetor_item = mysqli_fetch_array($sql_item);

if($upload == 2) {

$diretorio = "../sistema/arquivos/";

$contaimagem = $_POST['contaimagem'];

$i = 0;

foreach($contaimagem as $keyy) {

$imagem_up = $_FILES['imagem_up']['name'][$i];  
$tmp = $_FILES['imagem_up']['tmp_name'][$i];
$ext = strrchr($imagem_up, '.'); 
$imagem_up = time().uniqid(md5()).$ext;
$upload_final = $diretorio.$imagem_up;
move_uploaded_file($tmp, $upload_final);

$sql = mysqli_query($con, "insert into convite_exclusive_escolhidas (id_exclusive, tipo, foto) VALUES ('$id', '2', '$imagem_up')");

$i++;

}

} else {

$x = $_POST['foto'];
$i = 0;

foreach($x as $key) {

	$foto = $_POST['foto'][$i];

	$sql_fotos = mysqli_query($con, "insert into convite_exclusive_escolhidas (id_exclusive, tipo, foto) VALUES ('$id', '1', '$foto')");

	$i++;

}

}


echo"<script language=\"JavaScript\">
location.href=\"conviteexclusive.php?id=$id_convite&lamina=Lamina-$id#Lamina-$id\";
</script>";

?>